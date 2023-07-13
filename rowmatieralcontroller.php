<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\rowmatieralmodel;
use DB;


class rowmatieralcontroller extends Controller
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
        $rowmatieraldata=rowmatieralModel::all();
        return view('rowmatierallist',['rdata'=>$rowmatieraldata]);
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
        $tbl_rowmatieral=new rowmatieralmodel();
        $tbl_rowmatieral->r_name=$request->r_name;
        $tbl_rowmatieral->r_fom=$request->r_fom;
        $tbl_rowmatieral->save();
        return redirect('rowmatierallist');
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
        $rdata=DB::select("select * from tbl_rowmatieral where rid= ?",[$id]);
        return view('rowmatieraledit',['tbl_rowmatieral'=>$rdata[0]]);
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
        $r_name=$request->r_name;
        $r_fom=$request->r_fom;
        DB::update("update tbl_rowmatieral set r_name=?,r_fom=? where rid=?",[$r_name,$r_fom,$id]);
        return redirect('rowmatierallist');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deletedata($id) 
    {
        DB::delete("delete from tbl_rowmatieral where rid=$id");
        return redirect('rowmatierallist'); 
    }
}
