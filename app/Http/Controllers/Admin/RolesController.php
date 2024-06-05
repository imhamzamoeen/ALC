<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;

class RolesController extends Controller
{
    protected $module_title;
    protected $module_slug;
    protected $module_model;
    public function __construct() {
        $this->module_title = 'Roles';
        $this->module_slug = 'roles';
        $this->module_model = new Role();

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $model = new Role();
        $data = applyWheres($model, getFilters($request))->simplePaginate(10);
        $module_title = $this->module_title;
        $module_slug = $this->module_slug;
        return view('admin.'.$this->module_slug.'.list', compact('data', 'module_title', 'module_slug'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $module_title = $this->module_title;
        $module_slug = $this->module_slug;
        $module_action = 'add';

        return view('admin.'.$this->module_slug.'.add', compact('module_slug', 'module_title', 'module_action'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->merge([
            'name' => slugify($request->get('name')),
        ]);
        $request->validate([
            'name' => 'required|max:100|string|unique:roles'
        ]);

        $create = Role::create($request->only('name'));

        if($create){
            return redirect()->route('admin'.'.'.$this->module_slug.'.list');
        }else{
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Role $id)
    {
        $module_title = $this->module_title;
        $module_slug = $this->module_slug;
        $module_action = 'add';
        $role = $id;
        $users = $role->users()->simplePaginate(10);
//        dd($role->users);
        return view('admin.roles.index', compact('module_slug', 'module_title', 'module_action', 'role', 'users'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   /* public function edit($id)
    {
        $module_title = $this->module_title;
        $module_slug = $this->module_slug;
        $module_action = 'edit';
        $data = Role::findOrFail($id);

        return view('admin.'.$this->module_slug.'.edit', compact('data', 'module_title', 'module_slug', 'module_action'));
    }*/

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /*public function update(Request $request, $id)
    {
        $request->merge([
            'name' => slugify($request->get('name')),
        ]);
        //dd($request->all());
        $request->validate([
            'name' => 'sometimes|required|max:100|string|unique:roles,id,'.$id
        ]);
        $update = Role::findOrFail($id)->update($request->only('name'));

        if($update){
            return redirect()->route('admin'.'.'.$this->module_slug.'.list');
        }else{
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }*/

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!empty($id)){
            $role = Role::findorFail($id);

            if($role->is_locked == 1){
                return redirect()->back()->with('warning', 'Sorry! This record is locked.');
            }else{
                $role->delete();
            }
            return redirect()->back()->with('success', 'Role has been deleted.');
        }else{
            return redirect()->back()->with('error' , 'Something went wrong!');
        }
    }

    public function assign($id){
        $module_title = $this->module_title;
        $module_slug = $this->module_slug;

        $permissions = Permission::all();
        $role = Role::findOrFail($id);
        $module_action = 'assign_permissions_to_"'.beautify_slug($role->name).'"';

        return view('admin.'.$this->module_slug.'.assign', compact('permissions', 'role', 'module_title', 'module_slug', 'module_action'));
    }

    public function assignPermissions(Request $request, $id){
        $role = Role::findOrFail($id);
        $permissions = Permission::whereIn('id', $request->permissions)->get();
        if($permissions->count()){
           $assign = $role->syncPermissions($permissions);
           if($assign){
               return redirect()->route('admin'.'.'.$this->module_slug.'.list')->with('success', 'Operation Successfull');
           }
        }
        return redirect()->back()->with('error', 'Something went wrong');
    }

    public function bulkAction(Request $request){
        $action = $request->action;
        $ids = $request->ids;
        switch ($action){
            case 'delete':
                if(count($ids)){
                    $response = Role::whereIn('id', $ids)->where('is_locked', 0)->delete();
                    if($response){
                        return redirect()->back()->with('success', 'Selected '. $this->module_title.' has been deleted.');
                    }else{
                        return redirect()->back()->with('error' , 'Something went wrong!');
                    }
                }
                break;
            default:{
                return redirect()->back();
            }
        }
        return redirect()->back();
    }
}
