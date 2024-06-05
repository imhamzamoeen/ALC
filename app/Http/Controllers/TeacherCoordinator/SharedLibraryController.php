<?php

namespace App\Http\Controllers\TeacherCoordinator;

use App\Classes\AlertMessages;
use App\Http\Controllers\Controller;
use App\Http\Requests\TeacherCoordinator\AddFileToFolder;
use App\Http\Requests\TeacherCoordinator\AddFolderRequest;
use App\Http\Requests\TeacherCoordinator\AssignFolderToTeacherRequest;
use App\Http\Requests\TeacherCoordinator\DeleteFileRequest;
use App\Http\Requests\TeacherCoordinator\DeleteSharedFile;
use App\Http\Requests\TeacherCoordinator\UpdateFileNameRequest;
use App\Http\Requests\TeacherCoordinator\UpdateFolderNameRequest;
use App\Models\LibraryFile;
use App\Models\Shareable;
use App\Models\SharedLibrary;
use App\Models\User;
use App\Services\JsonResponseService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SharedLibraryController extends Controller
{
    //

    public function CreateFolder(AddFolderRequest $request)
    {

        try {

            if ($request->ajax()) {
                DB::beginTransaction();
                $NewFolder = User::find(auth()->id())->MyFolders()->create([
                    'title' => $request->folder_name
                ]);
                if (!is_null($NewFolder)) {
                    DB::commit();
                    return JsonResponseService::JsonSuccess("Success", $NewFolder);
                } else {
                    DB::rollBack();
                    return JsonResponseService::JsonFailed(AlertMessages::ERROR_500, []);
                }
            }
        } catch (Exception $e) {   //  catch all Exceptions
            DB::rollBack();
            return JsonResponseService::getJsonException($e);
        }
    }

    public function UpdateFolderName(UpdateFolderNameRequest $request)
    {

        try {

            if ($request->ajax()) {
                DB::beginTransaction();
                $update = SharedLibrary::find($request->id)->update($request->except('id'));
                if ($update > 0) {
                    DB::commit();
                    return JsonResponseService::JsonSuccess("Success", []);
                } else {
                    DB::rollBack();
                    return JsonResponseService::JsonFailed(AlertMessages::ERROR_500, []);
                }
            }
        } catch (Exception $e) {   //  catch all Exceptions
            DB::rollBack();
            return JsonResponseService::getJsonException($e);
        }
    }

    public function UpdateFileName(UpdateFileNameRequest $request)
    {
        try {

            if ($request->ajax()) {
                DB::beginTransaction();
                $update = LibraryFile::find($request->file_id)->update([
                    'title' => $request->file_name,
                ]);
                if ($update > 0) {
                    DB::commit();
                    return JsonResponseService::JsonSuccess("Success", []);
                } else {
                    DB::rollBack();
                    return JsonResponseService::JsonFailed(AlertMessages::ERROR_500, []);
                }
            }
        } catch (Exception $e) {   //  catch all Exceptions
            DB::rollBack();
            return JsonResponseService::getJsonException($e);
        }
    }

    public function DeleteFile(DeleteFileRequest  $request)
    {
        try {

            if ($request->ajax()) {
                DB::beginTransaction();
                $update = LibraryFile::find($request->file_id)->delete();
                if ($update > 0) {
                    DB::commit();
                    return JsonResponseService::JsonSuccess("Success", []);
                } else {
                    DB::rollBack();
                    return JsonResponseService::JsonFailed(AlertMessages::ERROR_500, []);
                }
            }
        } catch (Exception $e) {   //  catch all Exceptions
            DB::rollBack();
            return JsonResponseService::getJsonException($e);
        }
    }

    public function AddFileToFolder(Request $request)
    {
        try {
            // yeh validation is lie idhr ki h k file pond ko hm json mai return kr sakien 
            $validator = Validator::make($request->all(), [
                'filepond' => ['required', 'file', ],
                'folder_id' => ['required', 'numeric', 'exists:shared_libraries,id']
            ]);
            if (!$validator->fails()) {
                $validator->after(function ($validator) use ($request) {

                    // check whether the given folder id is under coordinator or not 
                    if (!in_array(strtolower($request->filepond->getClientOriginalExtension()), ['pdf', 'png', 'docx', 'txt', 'jpg', 'jpeg', 'dox', 'pptx', 'ppt', 'word'])) {
                        $validator->errors()->add('Folder', 'The provided file type is not supported');
                    }
                    if (SharedLibrary::find($request->folder_id)->created_by != auth()->id()) {  // kia yeh file isi teacher coordinator n create ki h ya nhe 
                        $validator->errors()->add('Folder', 'The Given File Does Not Belong To You');
                    }
                });
            }
            if ($validator->fails()) {
                return JsonResponseService::JsonFailed(AlertMessages::ERROR_500, $validator->errors());
            }

            DB::beginTransaction();
            $path = $extension = '';
            $fileSize = 0;
            if ($request->hasFile('filepond')) {

                $file = $request->file('filepond');
                // Get filename with the extension
                $extension = strtolower($file->getClientOriginalExtension());
                $filename = $file->getClientOriginalName();
                $filename = pathinfo($filename, PATHINFO_FILENAME);
                $fileSize = $file->getSize();
                // Filename to store
                $fileNameToStore = slugify($filename) . '-' . substr(microtime(), 5, 5) . '.' . $extension;
                // Upload Image
                $path = $file->storeAs('public/shared-library/' . $extension, $fileNameToStore);
            }
            if (!empty($path)) {
                $upload =  LibraryFile::create([
                    'title'     => $filename,
                    'slug'      => slugify($filename),
                    'file'      => str_replace('public/', '', $path),
                    'file_size' => $fileSize,
                    'file_type' => $extension,
                    'created_by' => auth()->user()->id,
                    'shared_library_id' => $request->folder_id,
                ]);
            }

            if (!is_null($upload)) {
                DB::commit();
                return JsonResponseService::JsonSuccess("Success", $upload);
            } else {
                DB::rollBack();
                return JsonResponseService::JsonFailed(AlertMessages::ERROR_500, []);
            }
        } catch (Exception $e) {   //  catch all Exceptions
            DB::rollBack();
            return JsonResponseService::getJsonException($e);
        }
    }


    public function DeleteSharedFile(DeleteSharedFile $request)
    {
        try {
            DB::beginTransaction();
            $data = Shareable::find($request->shared_id);
            if ($data->Folder->created_by != auth()->id()) {
                DB::rollBack();
                return JsonResponseService::JsonFailed(AlertMessages::ERROR_500, []);           // it means the id given does not belong to the folder that is created by this user
            }
            if ($data->delete() > 0) {
                DB::commit();
                return JsonResponseService::JsonSuccess("Success", $data);
            } else {
                return JsonResponseService::JsonFailed(AlertMessages::ERROR_500, []);           // it means the id given does not belong to the folder that is created by this user

            }
        } catch (Exception $e) {   //  catch all Exceptions
            DB::rollBack();
            return JsonResponseService::getJsonException($e);
        }
    }

    public function AssignFolderToTeacher(AssignFolderToTeacherRequest $request)
    {
        try {
            DB::beginTransaction();
            $Create = SharedLibrary::find($request->folder_id)->shareableUsers()->create([
                'shareable_id' => $request->teacher_id,
                'shareable_type' => User::class,
            ]);
            if (!is_null($Create)) {
                DB::commit();
                return JsonResponseService::JsonSuccess("Success", $Create);
            }
            DB::rollback();
            return JsonResponseService::JsonFailed(AlertMessages::ERROR_500, []);           // it means the id given does not belong to the folder that is created by this user

        } catch (Exception $e) {   //  catch all Exceptions
            DB::rollBack();
            return JsonResponseService::getJsonException($e);
        }
    }
}
