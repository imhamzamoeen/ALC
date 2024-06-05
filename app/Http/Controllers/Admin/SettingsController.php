<?php

namespace App\Http\Controllers\Admin;

use App\Classes\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Repository\SettingRepositoryInterface;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    protected $module_title;
    protected $module_slug;
    protected $module_model;
    protected $settingRepository;
    public function __construct(SettingRepositoryInterface $settingRepository) {
        $this->module_title = 'Settings';
        $this->module_slug = 'settings';
        $this->module_model = new Setting();

        $this->settingRepository = $settingRepository;

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
        $module_action = 'list';
        $data = $this->settingRepository->all();
        $categories = $this->settingRepository->fetchAllCategories();
        return view('admin.'.$this->module_slug.'.index', compact('data', 'categories', 'module_title', 'module_slug', 'module_action'));
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

        $categories = $this->settingRepository->fetchAllCategories();
        return view('admin.settings.add', compact('module_slug', 'module_title', 'module_action', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $request->merge([
            'key' => slugify($request->get('key')),
            'category' => slugify($request->get('category')),
            'new_category' => slugify($request->get('new_category'))
        ]);
        $request->validate([
            'key'       => 'required|max:255|string|unique:settings,key',
            'value'     => 'required|string',
            'category'  => 'required_without:new_category',
            'new_category'  => 'max:255|required_without:category',
            'is_required'   => 'required'
        ]);
        $input = $request->except('_token', 'new_category');
        $input['category'] = empty($input['category']) ? $request->get('new_category') : $input['category'];
        $input = array_merge($input, [
            'created_by'    => auth()->user()->id
        ]);

        $create = $this->settingRepository->create($input);
        if($create){
            return redirect()->route('admin'.'.'.$this->module_slug.'.list')->with('success', $this->module_title .' added successfully');
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
        //dd($request->all());
        try{
            foreach ($request->all() as $key => $data){
                if(is_array($data)){
                    if(($data['is_required'] == 1 && !is_null($data['value'])) || $data['is_required'] == 0){
                        $data['status'] = ($data['is_required'] == 1) ? StatusEnum::Active : (!isset($data['status']) ? StatusEnum::Inactive : $data['status']);
                        //dd($data);
                        $this->settingRepository->update(
                            ['key' => $key, 'is_locked' => 0],
                            ['value' => $data['value'], 'status' => $data['status']]
                        );
                    }
                }
            }
        }catch (\Exception $e){
            return redirect()->back()->with('success', 'Something went wrong');
        }

        return redirect()->back()->with('success', $this->module_title.' updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Setting $id)
    {
        if($id && $id->is_required == 0 && $id->is_locked == 0){
            $id->deleteOrFail();
            return redirect()->back()->with('success', 'Record deleted');
        }else{
            return redirect()->back()->with('warning', 'Sorry! Record is locked or required.');
        }

    }
}
