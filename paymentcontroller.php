<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\paymentmodel;
use App\Models\invoicemodel;
use DB;

use function GuzzleHttp\Promise\all;

class paymentcontroller extends Controller
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
        $paydata=paymentmodel::all();
        return view('paymentlist',['paydata'=>$paydata]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $invdata=invoicemodel::all();
        return view('paymentadd',['invdata'=>$invdata]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $payment=new paymentmodel();
        $payment->rec_id=$request->rec_id;
        $payment->invoice_id=$request->invoice_id;
        $payment->date=$request->date;
        $payment->amount=$request->amount;
        $payment->type=$request->type;
        $payment->Transaction_no=$request->Transaction_no;
        $payment->save();
        return redirect("paymentlist");

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
        $paydata=DB::select("select * from payment where rec_id= ?",[$id]);
        return view('paymentedit',['payment'=>$paydata[0],'invdata'=>$invdata]);
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
        $date=$request->date;
        $amount=$request->amount;
        $type=$request->type;
        $transaction_no=$request->transaction_no;
        DB::update("update payment set invoice_id=?,date=?,amount=?,type=?,transaction_no=? where rec_id=?",[$invoice_id,$date,$amount,$type,$transaction_no,$id]);
        return redirect("paymentlist");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::delete("delete from payment where rec_id=$id");
        return redirect('paymentlist');
    }
}
