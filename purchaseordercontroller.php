<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\purchaseordermodel;
use DB;

class purchaseordercontroller extends Controller
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
        $podata=purchaseordermodel::all();
        return view('purchaseorderlist',['podata'=>$podata]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $podata=purchaseordermodel::all();
        return view('purchaseorderadd',['podata'=>$podata]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $purchase_order=new purchaseordermodel();
        $purchase_order->po_id=$request->po_id;
        $purchase_order->sup_id=$request->sup_id;
        $purchase_order->date=$request->date;
        $purchase_order->total=$request->total;
        $purchase_order->save();
        return redirect("purchaseorderlist");
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
        $podata=purchaseordermodel::all();
        $podata=DB::select("select * from purchase_order where po_id= ?",[$id]);
        return view('purchaseorderedit',['purchase_order'=>$podata[0],'podata'=>$podata]);
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
        $sup_id=$request->sup_id;
        $date=$request->date;
        $total=$request->total;
        DB::update("update purchase_order set sup_id=?,date=?,total=? where po_id=?",[$sup_id,$date,$total,$id]);
        return redirect("purchaseorderlist");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::delete("delete from purchase_order where po_id=$id");
        return redirect('purchaseorderlist');
    }
}
