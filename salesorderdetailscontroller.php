<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\salesorderdetailsmodel;
use App\Models\salesordermodel;
use App\Models\productsmodel;
use App\Models\quotationmodel;
use DB;

class salesorderdetailscontroller extends Controller
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
        $soddata=salesorderdetailsmodel::all();
        return view('salesorderdetaillist',['soddata'=>$soddata]);
    }

    public function detail($id)
    {
        //$inqddata=inquirydetailmodel::where('inq_id',$id);
        $soddata=DB::select("select * from tbl_sales_order_detales where so_id= ?",[$id]);
        return view('customer/orddetail',['soddata'=>$soddata]);

    } 

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pdata=productsmodel::all();
        $sdata=salesordermodel::all();
        $qdata=quotationmodel::all();
        return view('salesorderdetailadd',['pdata'=>$pdata,'sdata'=>$sdata,'qdata'=>$qdata]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
                 $soddata=new salesorderdetailsmodel();
                 $soddata->so_id=$request->so_id;
                 $soddata->prod_id=$request->p_id;
                 $soddata->quo_id =$request->quo_id;
                 $soddata->save();
                 return redirect('salesorderdetaillist');
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
        $pdata=productsmodel::all();
        $sdata=salesordermodel::all();
        $qdata=quotationmodel::all();
        $soddata=DB::select("select * from tbl_sales_order_detales where so_d_id= ?",[$id]);
        return view('salesorderdetailedit',['tbl_sales_order_detales'=>$soddata[0],'pdata'=>$pdata,'sdata'=>$sdata,'qdata'=>$qdata]);
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
        $prod_id=$request->prod_id;
        $quo_id=$request->quo_id;
        DB::update("update tbl_sales_order_details set so_id=?,prod_id=?,quo_id=? where so_d_id=?",[$so_id,$prod_id,$quo_id,$id]);
        return redirect("salesorderdetaillist");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
