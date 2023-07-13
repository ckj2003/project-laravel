<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\purchaseorderdetailsmodel;
use App\Models\purchaseordermodel;
use App\Models\rowmatieralmodel;
use DB;

class purchaseorderdetailscontroller extends Controller
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
        $poddata=purchaseorderdetailsmodel::all();
        return view('purchaseorderdetaillist',['poddata'=>$poddata]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $podata=purchaseordermodel::all();
        $rmdata=rowmatieralmodel::all();
        return view('purchaseorderdetailadd',['podata'=>$podata,'rmdata'=>$rmdata]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tbl_purchase_order_details=new purchaseorderdetailsmodel();
        $tbl_purchase_order_details->po_id=$request->po_id;
        $tbl_purchase_order_details->pod_id=$request->pod_id;
        $tbl_purchase_order_details->r_id=$request->r_id;
        $tbl_purchase_order_details->qty=$request->qty;
        $tbl_purchase_order_details->rate=$request->rate;
        $tbl_purchase_order_details->save();
        return redirect("purchaseorderdetaillist");

        
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
        $rmdata=rowmatieralmodel::all();
        $poddata=DB::select("select * from tbl_purchase_order_detail where pod_id= ?",[$id]);
        return view('purchaseorderdetailedit',['tbl_purchase_order_detail'=>$poddata[0],'podata'=>$podata,'rmdata'=>$rmdata]);
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
        $po_id=$request->po_id;
        $r_id=$request->r_id;
        $qty=$request->qty;
        $rate=$request->rate;
        DB::update("update tbl_purchase_order_detail set po_id=?,r_id=?,qty=?,rate=? where pod_id=?",[$po_id,$r_id,$qty,$rate,$id]);
        return redirect("purchaseorderdetaillist");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::delete("delete from tbl_purchase_order_detail where pod_id=$id");
        return redirect('purchaseorderdetaillist');
    }
}
