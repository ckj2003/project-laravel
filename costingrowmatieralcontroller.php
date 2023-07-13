<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\costingrowmatieralmodel;
use App\Models\costingmodel;
use App\Models\rowmatieralmodel;
use DB;

class costingrowmatieralcontroller extends Controller
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
        $costingrmdata=costingrowmatieralmodel::all();
        $rmdata=rowmatieralmodel::all();
        //return view('costingrmlist',['costingrmdata'=>$costingrmdata]);
        $costingrmdata=costingrowmatieralmodel::join("tbl_rowmatieral","tbl_costing_rm.r_id","=","tbl_rowmatieral.rid")->get(['tbl_rowmatieral.*','tbl_costing_rm.*']);
        return view('costingrmlist',['costingrmdata'=>$costingrmdata]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $costingdata=costingmodel::all();
        $rmdata=rowmatieralmodel::all();
        return view('costingrmadd',['costingdata'=>$costingdata,'rmdata'=>$rmdata]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tbl_costing_rm=new costingrowmatieralmodel();
        $tbl_costing_rm->cost_rmid=$request->cost_rmid;
        $tbl_costing_rm->cost_id=$request->cost_id;
        $tbl_costing_rm->r_id=$request->r_id;
        $tbl_costing_rm->qty=$request->qty;
        $tbl_costing_rm->rate=$request->rate;
        $tbl_costing_rm->save();
        return redirect('costingrmlist');
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
        $rmdata=rowmatieralmodel::all();
        $costingrmdata=DB::select("select * from tbl_costing_rm where cost_rmid= ?",[$id]);
        return view('costingrmedit',['tbl_costing_rm'=>$costingrmdata[0],'costingdata'=>$costingdata,'rmdata'=>$rmdata],);
        return redirect('costingrmlist');
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
        $r_id=$request->r_id;
        $qty=$request->qty;
        $rate=$request->rate;
        DB::update("update tbl_costing_rm set cost_id=?,r_id=?,qty=?,rate=? where cost_rmid=?",[$cost_id,$r_id,$qty,$rate,$id]);
        return redirect('costingrmlist');

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
        DB::delete("delete from tbl_costing_rm where cost_rmid=$id");
        return redirect('costingrmlist');
    }
}
