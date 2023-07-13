<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\costingmodel;
use App\Models\inquirymodel;
use App\Models\employeemodel;
use DB;

class costingcontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(session()->has('admin')==false)
        return redirect('login');
        $costingdata=costingmodel::all();
        $empdata=employeemodel::all();
        //return view('costinglist',['costingdata'=>$costingdata]);
        $costingdata=costingmodel::join("tbl_employee","tbl_costing.emp_id","=","tbl_employee.emp_id")->get(['tbl_employee.*','tbl_costing.*']);
        return view('costinglist',['costingdata'=>$costingdata]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $employeedata=employeemodel::all();
        $inqdata=inquirymodel::all();
        return view('costingadd',['edata'=>$employeedata,'inqdata'=>$inqdata]);
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tbl_costing=new costingmodel();
        $tbl_costing->inq_id =$request->inq_id ;
        $tbl_costing->cost_date=$request->cost_date;
        $tbl_costing->total=$request->total;
        $tbl_costing->emp_id =$request->emp_id ;
        $tbl_costing->save();
        return redirect('costinglist');
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
        if(session()->has('admin')==false)
        return redirect('login');
        $empdata=employeemodel::all();
        $inqdata=inquirymodel::all();
        $costingdata=DB::select("select * from tbl_costing where cost_id= ?",[$id]);
        return view('costingedit',['tbl_costing'=>$costingdata[0],'edata'=>$empdata,'inqs'=>$inqdata],);
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
        $inq_id=$request->inq_id;
        $cost_date=$request->cost_date;
        $total=$request->total;
        $emp_id=$request->emp_id;
        DB::update("update tbl_costing set inq_id=?,cost_date=?,total=?,emp_id=? where cost_id=?",[$inq_id,$cost_date,$total,$emp_id,$id]);
        return redirect('costinglist');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(session()->has('admin')==false)
        return redirect('login');
        DB::delete("delete from tbl_costing where cost_id=$id");
        return redirect('costinglist');
    }
}
