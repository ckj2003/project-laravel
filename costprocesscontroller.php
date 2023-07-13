<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\costprocessmodel;
use App\Models\costingmodel;
use App\Models\processmastermodel;
use DB;

class costprocesscontroller extends Controller
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
        $costprodata=costprocessmodel::all();
        return view('costprocesslist',['costprodata'=>$costprodata]); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $costingdata=costingmodel::all();
        $processmasterdata=processmastermodel::all();
        return view('costprocessadd',['costingdata'=>$costingdata,'pmdata'=>$processmasterdata]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tbl_cost_process=new costprocessmodel();
        $tbl_cost_process->cost_pid=$request->cost_pid;
        $tbl_cost_process->cost_id=$request->cost_id;
        $tbl_cost_process->proc_id=$request->proc_id;
        $tbl_cost_process->rate=$request->rate;
        $tbl_cost_process->save();
        return redirect('costprocesslist');
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
        $costingdata=costingmodel::all();
        $processmasterdata=processmastermodel::all();
        $costprodata=DB::select("select * from tbl_cost_process where cost_pid= ?",[$id]);
        return view('costprocessedit',['tbl_cost_process'=>$costprodata[0],'costingdata'=>$costingdata,'pmdata'=>$processmasterdata]);
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
        $cost_id=$request->cost_id;
        $proc_id=$request->proc_id;
        $rate=$request->rate;
        DB::update("update tbl_cost_process set cost_id=?,proc_id=?,rate=? where cost_pid=?",[$cost_id,$proc_id,$rate,$id]);
        return redirect('costprocesslist');
        
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
        DB::delete("delete from tbl_cost_process where cost_pid=$id");
        return redirect('costprocesslist');
    }
}
