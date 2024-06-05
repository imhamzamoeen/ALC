<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SharedLibrary;
use App\Models\User;
use App\Repository\LibraryFilesRepositoryInterface;
use App\Repository\SharedLibraryRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SharedLibraryController extends Controller
{
    protected $module_title;
    protected $module_slug;
    protected $module_model;
    protected $sharedLibraryRepository;
    protected $libraryFilesRepository;
    public function __construct(SharedLibraryRepositoryInterface $sharedLibraryRepository, LibraryFilesRepositoryInterface $libraryFilesRepository)
    {
        $this->module_title = 'Shared Library';
        $this->module_slug = 'shared-library';
        $this->module_model = new SharedLibrary();

        $this->sharedLibraryRepository = $sharedLibraryRepository;
        $this->libraryFilesRepository = $libraryFilesRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $module_title = $this->module_title;
        $module_slug = $this->module_slug;

        $data = $this->sharedLibraryRepository->simplePaginate();

        return view('admin.' . $module_slug . '.list', compact('module_slug', 'module_title', 'data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data = $request->validate([
            'title' => 'string|max:250|required|unique:shared_libraries,title,' . $request->id,
            'id' => 'required'
        ]);
        $request->merge([
            'slug' => slugify($request->title)
        ]);
        $update = $this->sharedLibraryRepository->update(['id' => $data['id']], $request->only('title', 'slug'));
        if ($update) {
            return redirect()->route('admin'. '.' . $this->module_slug . '.list')->with('success', $this->module_title . ' updated successfully');
        } else {
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!empty($id)) {
            $this->sharedLibraryRepository->deleteBy(['id' => $id]);
            return redirect()->back()->with('success', $this->module_title . ' has been deleted.');
        } else {
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }

    public function destroyFile($id)
    {
        if (!empty($id)) {
            $this->libraryFilesRepository->deleteBy(['id' => $id]);
            return redirect()->back()->with('success', $this->module_title . ' has been deleted.');
        } else {
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }

    public function addFolder(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'new_folder_name' => ['required', 'string', 'max:50', function ($attribute, $value, $fail) {        // to check is user n pehly is name s folder tu nhe create kia wa 
                if (SharedLibrary::where('created_by', auth()->id())->where('title', $value)->exists()) {
                    $fail('The ' . $attribute . ' already exists.');
                }
            },],
        ]);
        $input['title'] = $request->new_folder_name;
        $input['slug'] = slugify($request->new_folder_name);
        $input['created_by'] = auth()->user()->id;

        $create = $this->sharedLibraryRepository->create($input);

        if ($create) {
            return redirect()->route('admin' . '.' . $this->module_slug . '.list')->with('success', 'New Folder Added Successfully');
        } else {
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }

    public function folderFiles(Request $request, $folder)
    {
        $module_title = $this->module_title;
        $module_slug = $this->module_slug;
        $folder = $this->sharedLibraryRepository->getFirstBy(['slug' => $folder]);
        //dd($folder);
        if (!$folder) {
            abort(404);
        }
        $where = getFilters($request);
        $data = $this->libraryFilesRepository->simplePaginate(array_merge(['shared_library_id' => $folder->id], $where));
        //dd($data);
        return view('admin.' . $module_slug . '.files', compact('module_slug', 'module_title', 'data', 'folder'));
    }

    public function addFile(Request $request, SharedLibrary $folder)
    {
        $data = $request->validate([
            'title' => ['string', 'required', 'unique:library_files,title'],
            'file'  => ['required', 'max:5000']
        ]);
        $path = $extension = '';
        $fileSize = 0;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            // Get filename with the extension
            $extension = $file->getClientOriginalExtension();
            $fileSize = $file->getSize();
            // Filename to store
            $fileNameToStore = slugify($data['title']) . '-' . substr(microtime(), 5, 5) . '.' . $extension;
            // Upload Image
            $path = $file->storeAs('public/shared-library/' . $extension, $fileNameToStore);
        }

        if (!empty($path)) {
            $upload = $this->libraryFilesRepository->create([
                'title'     => $data['title'],
                'slug'      => slugify($data['title']),
                'file'      => str_replace('public/', '', $path),
                'file_size' => $fileSize,
                'file_type' => $extension,
                'created_by' => auth()->user()->id,
                'shared_library_id' => $folder->id
            ]);

            if ($upload) {
                return redirect()->route('admin'. '.' . $this->module_slug . '.folderFiles', $folder->slug)->with('success', 'Files uploaded successfully');
            }
        }
        return redirect()->back()->with('error', 'Something went wrong');
    }

    public function updateFile(Request $request)
    {
        $data = $request->validate([
            'title' => 'string|max:250|required|unique:library_files,title,' . $request->id,
            'id' => 'required'
        ]);
        $request->merge([
            'slug' => slugify($request->title)
        ]);
        $update = $this->libraryFilesRepository->update(['id' => $data['id']], $request->only('title', 'slug'));
        if ($update) {
            return redirect()->back()->with('success', $this->module_title . ' updated successfully');
        } else {
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }

    public function bulkAction(Request $request)
    {
        $action = $request->action;
        $ids = $request->ids;
        switch ($action) {
            case 'delete':
                if (count($ids)) {
                    $response = $this->sharedLibraryRepository->deleteBy([['id', 'IN', $ids]]);
                    if ($response) {
                        return redirect()->back()->with('success', 'Selected ' . $this->module_title . ' has been deleted.');
                    } else {
                        return redirect()->back()->with('error', 'Something went wrong!');
                    }
                }
                break;
            default: {
                    return redirect()->back();
                }
        }
        return redirect()->back();
    }

    public function bulkFileAction(Request $request)
    {
        $action = $request->action;
        $ids = $request->ids;
        switch ($action) {
            case 'delete':
                if (count($ids)) {
                    $response = $this->libraryFilesRepository->deleteBy([['id', 'IN', $ids]]);
                    if ($response) {
                        return redirect()->back()->with('success', 'Selected ' . $this->module_title . ' has been deleted.');
                    } else {
                        return redirect()->back()->with('error', 'Something went wrong!');
                    }
                }
                break;
            default: {
                    return redirect()->back();
                }
        }
        return redirect()->back();
    }

    public function assignTeachers(Request $request, SharedLibrary $library)
    {
        $data = $request->validate([
            'teachers' => ['required'],
        ]);
        try {
            foreach ($data['teachers'] as $key => $teacher) {
                $data['teachers'][$key]['shared_library_id'] = $library->id;
                $data['teachers'][$key]['shareable_type'] = User::class;
            }
            DB::beginTransaction();

            $library->shareableUsers()->delete();
            $library->shareableUsers()->createMany($data['teachers']);

            DB::commit();
            return redirect()->back()->with('success', 'Library assignment successfull');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Sorry! Something went wrong. Please try again');
        }
    }
}
