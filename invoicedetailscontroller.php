<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\invoicemodel;
use App\Models\invoicedetailsmodel;
use App\Models\productsmodel;
use DB;

class invoicedetailscontroller extends Controller
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
        $invoiceddata=invoicedetailsmodel::all();
        return view('invoicedetaillist',['invoiceddata'=>$invoiceddata]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $invdata=invoicemodel::all();
        $prodata=productsmodel::all();
        return view('invoicedetailadd',['invdata'=>$invdata,'prodata'=>$prodata]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tbl_invoice_details=new invoicedetailsmodel();
        $tbl_invoice_details->invoice_d_id=$request->invoice_d_id;
        $tbl_invoice_details->invoice_id=$request->invoice_id;
        $tbl_invoice_details->prod_id=$request->prod_id;
        $tbl_invoice_details->qty=$request->qty;
        $tbl_invoice_details->rate=$request->rate;
        $tbl_invoice_details->save();
        return redirect("invoicedetaillist");

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
        $invdata=invoicemodel::all();
        $prodata=productsmodel::all();
        $invoiceddata=DB::select("select * from tbl_invoice_details where invoice_d_id= ?",[$id]);
        return view('invoicedetailedit',['tbl_invoice_details'=>$invoiceddata[0],'invdata'=>$invdata,'prodata'=>$prodata]);
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
        $invoice_id=$request->invoice_id;
        $prod_id=$request->prod_id;
        $qty=$request->qty;
        $rate=$request->rate;
        DB::update("update tbl_invoice_details set invoice_id=?,prod_id=?,qty=?,rate=? where invoice_d_id=?",[$invoice_id,$prod_id,$qty,$rate,$id]);
        return redirect("invoicedetaillist");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::delete("delete from tbl_invoice_details where invoice_d_id=$id");
        return redirect('invoicedetaillist');
    }
}
