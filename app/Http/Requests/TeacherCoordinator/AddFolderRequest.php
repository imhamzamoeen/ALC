<?php

namespace App\Http\Requests\TeacherCoordinator;

use App\Models\SharedLibrary;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class AddFolderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->hasRole('teacher-coordinator');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // 'folder_name' => ['required', 'string', 'max:50', 'unique:shared_libraries,title,1,id,deleted_at,NULL'],
            'folder_name' => ['required', 'string', 'max:50', function ($attribute, $value, $fail) {        // to check is user n pehly is name s folder tu nhe create kia wa 
                if (SharedLibrary::where('created_by', auth()->id())->where('title', $value)->exists()) {
                    $fail('The ' . $attribute . ' already exists.');
                }
            },],

        ];
    }
}
