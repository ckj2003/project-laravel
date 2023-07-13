<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\designationmodel;
use DB;

class designationcontroller extends Controller
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
        $designationdata=designationModel::all();
        $designationdata=designationModel::all();
        return view('designationlist',['ddata'=>$designationdata]);
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
        $tbl_designation=new designationmodel();
        
        $tbl_designation->designation=$request->designation;
        $tbl_designation->save();
        return redirect("designationlist");
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
        $ddata=DB::select("select * from tbl_designation where des_id= ?",[$id]);
        return view('designationedit',['tbl_designation'=>$ddata[0]]);
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
        
        $designation=$request->designation;
        DB::update("update tbl_designation set designation=? where des_id=?",[$designation,$id]);
        return redirect("designationlist");
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
        DB::delete("delete from tbl_designation where des_id=$id");
        return redirect('designationlist'); 

    }
}
