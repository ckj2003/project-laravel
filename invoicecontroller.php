<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\invoicemodel;
use App\Models\salesordermodel;
use DB;

class invoicecontroller extends Controller
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
        $invoicedata=invoicemodel::all();
        return view('invoicelist',['invoicedata'=>$invoicedata]);
    }

    public function myinvoice($id)
    {
        if(session()->has('admin')==false)
        return redirect('login');
        
        
        $invoicedata=invoicemodel::where('so_id',$id)->get();
        return view('/customer/myinvoice',['invoicedata'=>$invoicedata]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sodata=salesordermodel::all();
        return view('invoiceadd',['sodata'=>$sodata]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $invoice=new invoicemodel();
        $invoice->invoice_id=$request->invoice_id;
        $invoice->so_id=$request->so_id;
        $invoice->date=$request->date;
        $invoice->total=$request->total;
        $invoice->save();
        return redirect("invoicelist");
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
        $sodata=salesordermodel::all();
        $invoicedata=DB::select("select * from invoice where invoice_id= ?",[$id]);
        return view('invoiceedit',['invoice'=>$invoicedata[0],'sodata'=>$sodata]);
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
        $so_id=$request->so_id;
        $date=$request->date;
        $total=$request->total;
        DB::update("update tbl_invoice set so_id=?,date=?,total=? where invoice_id=?",[$so_id,$date,$total,$id]);
        return redirect("invoicelist");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::delete("delete from invoice where invoice_id=$id");
        return redirect('invoicelist');
    }
}
