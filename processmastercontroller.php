<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\processmastermodel;
use DB;

class processmastercontroller extends Controller
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
        $processmasterdata=processmasterModel::all();
        return view('processmasterlist',['pmdata'=>$processmasterdata]);
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
        $tbl_process_master=new processmastermodel();
        $tbl_process_master->proc_id=$request->proc_id;
        $tbl_process_master->proc_name=$request->proc_name;
        $tbl_process_master->save();
        return redirect("processmasterlist");
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
        $pmdata=DB::select("select * from tbl_process_master where proc_id= ?",[$id]);
        return view('processmasteredit',['tbl_process_master'=>$pmdata[0]]);
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
        $proc_name=$request->proc_name;
        DB::update("update tbl_process_master set proc_name=? where proc_id=?",[$proc_name,$id]);
        return redirect('processmasterlist');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::delete("delete from tbl_process_master where proc_id=$id");
        return redirect('processmasterlist');
    }
}
