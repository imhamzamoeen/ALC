<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

class PermissionsController extends Controller
{
    protected $module_title;
    protected $module_slug;
    protected $module_model;
    public function __construct() {
        $this->module_title = 'Permissions';
        $this->module_slug = 'permissions';
        $this->module_model = new Permission();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $model = new Permission();
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
        $request->validate([
            'module' => 'required|max:100|string',
            'action' => 'required|max:100|string'
        ]);
//dd( slugify($request->get('action').'-'.$request->get('module')));
        $request->merge([
            'name' => slugify($request->get('action').'-'.$request->get('module')),
        ]);

        $request->validate(
            ['name' => 'required|max:100|string|unique:permissions'],
            ['name.unique' => 'This permission already exists']
        );

        $create = Permission::create($request->only('name'));

        if($create){
            return redirect()->route('admin'.'.'.$this->module_slug.'.list')->with('success', 'Permission added Successfully');
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
        $module_title = $this->module_title;
        $module_slug = $this->module_slug;
        $module_action = 'edit';
        $data = Permission::find($id);
        if(!$data){
            abort(404);
        }

        return view('admin.'.$this->module_slug.'.edit', compact('data', 'module_title', 'module_slug', 'module_action'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   /* public function update(Request $request, $id)
    {

        $request->validate([
            'name' => 'required|max:100|string|unique:permissions'
        ]);
        $input['name'] = slugify($request->name);
        $update = Permission::where('id', $id)->update($input);

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
            $data = Permission::find($id);

            if($data->is_locked == 1){
                return redirect()->back()->with('warning', 'Sorry! This record is locked.');
            }

            return redirect()->back()->with('success', $this->module_title.' has been deleted.');
        }else{
            return redirect()->back()->with('error' , 'Something went wrong!');
        }
    }

    public function bulkAction(Request $request){
        $action = $request->action;
        $ids = $request->ids;
        switch ($action){
            case 'delete':
                if(count($ids)){
                    $response = Permission::whereIn('id', $ids)->where('is_locked', 0)->delete();
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
