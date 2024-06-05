<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Repository\CourseRepositoryInterface;
use Illuminate\Http\Request;

class CoursesController extends Controller
{
    protected $module_title;
    protected $module_slug;
    protected $module_model;
    protected $courseRepository;
    public function __construct(CourseRepositoryInterface $courseRepository) {
        $this->module_title = 'Courses';
        $this->module_slug = 'courses';
        $this->module_model = new Course();

        $this->courseRepository = $courseRepository;

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $module_title = $this->module_title;
        $module_slug = $this->module_slug;
        $module_action = 'list';
        $where = getFilters($request);
        $where[] = ['is_custom', '=', 0];
        $data = $this->courseRepository->simplePaginate($where);
        return view('admin.'.$this->module_slug.'.index', compact('data', 'module_title', 'module_slug', 'module_action'));
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
        $data = $request->validate([
            'title'  => 'required|max:255',
            'description'   => 'required',
        ]);
        $data['is_locked'] = 1;
        $create = $this->courseRepository->create($data);
        if($create){
            return redirect()->route('admin'.'.'.$this->module_slug.'.list')->with('success', $this->module_title.' added successfully');
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
        $data = $this->courseRepository->findOrFail($id);

        /*if($data->is_locked == 1){
            return redirect()->back()->with('warning', 'Sorry! This record is locked.');
        }*/
        return view('admin.'.$this->module_slug.'.edit', compact('data', 'module_title', 'module_slug', 'module_action'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title'  => 'required|max:255',
            'description'   => 'required',
            'status'    => 'required'
        ]);
        $update = $this->courseRepository->update(['id' => $id], $request->except('_token'));

        if($update){
            return redirect()->route('admin'.'.'.$this->module_slug.'.list')->with('success', $this->module_title.' updated successfully');
        }else{
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
        // dd($id);
        if(!empty($id)){
            $action = $this->courseRepository->deleteBy(['id' => $id]);
      
            if($action){
                return redirect()->back()->with('success', $this->module_title.' has been deleted.');
            }else{
                return redirect()->back()->with('warning', 'Sorry! This record is locked.');
            }

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
                    $response = $this->courseRepository->deleteBy([['id' , 'IN', $ids], ['is_locked', '=', 0]]);
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
