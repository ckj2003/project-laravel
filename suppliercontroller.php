<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Suppliermodel;
use DB;
class suppliercontroller extends Controller
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
        $supplierdata=supplierModel::all();
        return view('supplierlist',['sdata'=>$supplierdata]);
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
        $tbl_supplier=new Suppliermodel();
       
        $tbl_supplier->sup_name=$request->sup_name;
        $tbl_supplier->sup_email=$request->sup_email;
        $tbl_supplier->sup_address=$request->sup_address;
        $tbl_supplier->sup_contact_no=$request->sup_contact_no;
        
        $tbl_supplier->save();
        return redirect('supplierlist');
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
        $sdata=DB::select("select * from tbl_supplier where sup_id= ?",[$id]);
        return view('supplieredit',['tbl_supplier'=>$sdata[0]]);
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
        $sup_name=$request->sup_name;
        $sup_email=$request->sup_email;
        $sup_address=$request->sup_address;
        $sup_contact_no=$request->sup_contact_no;
        
        DB::update("update tbl_supplier set sup_name=?,sup_email=?,sup_address=?,sup_contact_no=? where sup_id=?",[$sup_name,$sup_email,$sup_address,$sup_contact_no,$id]);
        return redirect('supplierlist');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deletedata($id)
    {
        DB::delete("delete from tbl_supplier where sup_id=$id");
        return redirect('supplierlist');
    }
}
