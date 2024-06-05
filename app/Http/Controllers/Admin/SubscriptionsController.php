<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPlan;
use App\Repository\SubscriptionPlanRepositoryInterface;
use Illuminate\Http\Request;

class SubscriptionsController extends Controller
{
    protected $module_title;
    protected $module_slug;
    protected $module_model;
    protected $subscriptionPlanRepository;
    public function __construct(SubscriptionPlanRepositoryInterface $subscriptionPlanRepository) {
        $this->module_title = 'Subscription Plans';
        $this->module_slug = 'subscription-plans';
        $this->module_model = new SubscriptionPlan();

        $this->subscriptionPlanRepository = $subscriptionPlanRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $where = getFilters($request);
        $data = $this->subscriptionPlanRepository->simplePaginate($where);
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

        $types = $this->subscriptionPlanRepository->fetchAllTypes();

        return view('admin.'.$this->module_slug.'.add', compact('module_slug', 'module_title', 'module_action', 'types'));
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
            'type' => slugify($request->get('type')),
            'new_type' => slugify($request->get('new_type'))
        ]);
        $request->validate([
            'title' => 'required|string|max:255',
            'description'   => 'required|string',
            'us_price'  => 'required|numeric|max:1000|min:1',
            'uk_price' => 'required|numeric|max:1000|min:1',
            'type'  => 'max:255|required_without:new_type',
            'new_type'  => 'max:255|required_without:type',

        ]);
        $input = $request->except('_token', 'new_type');
        $input['type'] = empty($input['type']) ? $request->get('new_type') : $input['type'];
        $input = array_merge($input, [
            'created_by'    => auth()->user()->id
        ]);
       //dd($input);
        $create = $this->subscriptionPlanRepository->create($input);
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
    public function edit(SubscriptionPlan $id)
    {
        $module_title = $this->module_title;
        $module_slug = $this->module_slug;
        $module_action = 'edit';
        $data = $id;
        if(!$data){
            abort(404);
        }
        $types = $this->subscriptionPlanRepository->fetchAllTypes();

        return view('admin.'.$this->module_slug.'.edit', compact('data', 'module_title', 'module_slug', 'module_action', 'types'));
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
        $request->merge([
            'type' => slugify($request->get('type')),
            'new_type' => slugify($request->get('new_type'))
        ]);
        $request->validate([
            'title' => 'required|string|max:255',
            'description'   => 'required|string',
            'us_price'  => 'required|numeric',
            'uk_price' => 'required|numeric',
            'type'  => 'max:255|required_without:new_type',
            'new_type'  => 'max:255|required_without:type',

        ]);
        $input = $request->except('_token', 'new_type');
        $input['type'] = empty($input['type']) ? $request->get('new_type') : $input['type'];
        $input = array_merge($input, [
            'created_by'    => auth()->user()->id
        ]);
        //dd($input);
        $create = $this->subscriptionPlanRepository->update(['id' => $id],$input);
        //dd($create);
        if($create){
            return redirect()->route('admin'.'.'.$this->module_slug.'.list')->with('success', $this->module_title .' updated successfully');
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
        if(!empty($id)){
            $this->subscriptionPlanRepository->deleteBy(['id' => $id]);
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
                    $response = $this->subscriptionPlanRepository->deleteBy([['id' , 'IN', $ids]]);
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
