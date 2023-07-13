<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\employeemodel;
use App\Models\designationmodel;
use DB;

class controlleremployee extends Controller
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
        $desigdata=designationModel::all();
        $employeedata=employeeModel::all();
        $employeedata=employeeModel::join("tbl_designation","tbl_employee.emp_designation","=","des_id")->get(['tbl_designation.*','tbl_employee.*']);
        return view('employeelist',['edata'=>$employeedata]);
    }
    public function employeereport()
    {
        
        $desigdata=designationModel::all();
        $employeedata=employeeModel::all();
        $employeedata=employeeModel::join("tbl_designation","tbl_employee.emp_designation","=","des_id")->get(['tbl_designation.*','tbl_employee.*']);
        return view('employeereport',['edata'=>$employeedata]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $desigdata=designationModel::all();
        return view('employeeadd',['ddata'=>$desigdata]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tbl_employee=new employeemodel();
        $tbl_employee->emp_name=$request->emp_name;
        $tbl_employee->emp_email=$request->emp_email;
        $tbl_employee->emp_contact=$request->emp_contact;
        $tbl_employee->emp_address=$request->emp_address;
        $tbl_employee->emp_gender=$request->emp_gender;
        $tbl_employee->emp_designation=$request->emp_designation;
        $tbl_employee->emp_password=$request->emp_password;
        $tbl_employee->save();
        return redirect('employeelist');
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
        $desigdata=designationmodel::all();
        $edata=DB::select("select * from tbl_employee where emp_id= ?",[$id]);
        return view('employeeedit',['tbl_employee'=>$edata[0],'ddata'=>$desigdata],);
        return redirect('employeelist');
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
        $emp_name=$request->emp_name;
        $emp_email=$request->emp_email;
        $emp_contact=$request->emp_contact;
        $emp_address=$request->emp_address;
        $emp_gender=$request->emp_gender;
        $emp_designation=$request->emp_designation;
        $emp_password=$request->emp_password;
        DB::update("update tbl_employee set emp_name=?,emp_email=?,emp_contact=?,emp_address=?,emp_gender=?,emp_designation=?,emp_password=? where emp_id=?",[$emp_name,$emp_email,$emp_contact,$emp_address,$emp_gender,$emp_designation,$emp_password,$id]);
        return redirect('employeelist');

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
        DB::delete("delete from tbl_employee where emp_id=$id");
        return redirect('employeelist'); 
    }
}
