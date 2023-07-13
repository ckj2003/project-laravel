<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\quotationdetailsmodel;
use App\Models\quotationmodel;
use App\Models\productsmodel;
use DB;

class quotationdetailscontroller extends Controller
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
        $qddata=quotationdetailsmodel::all();
        return view('quotationdetaillist',['qddata'=>$qddata]);
    }
    public function quotationdetailreport()
    
    {
        
        $qddata=quotationdetailsmodel::all();
        return view('quotationdetailreport',['qddata'=>$qddata]);
    }

    public function quodetail($id)
    {
        //$inqddata=inquirydetailmodel::where('inq_id',$id);
        $qddata=DB::select("select * from tbl_quotation_details where quo_id= ?",[$id]);
        return view('customer/quodetails',['qddata'=>$qddata]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pdata=productsmodel::all();
        $qdata=quotationmodel::all();
        return view('quotationdetailadd',['pdata'=>$pdata,'qdata'=>$qdata]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tbl_quotation_details=new quotationdetailsmodel();
        $tbl_quotation_details->quo_d_id=$request->quo_d_id;
        $tbl_quotation_details->quo_id=$request->quo_id;
        $tbl_quotation_details->p_id=$request->p_id;
        $tbl_quotation_details->p_type=$request->p_type;
        $tbl_quotation_details->cost_id=$request->cost_id;
        $tbl_quotation_details->rate=$request->rate;
        $tbl_quotation_details->save();
        return redirect("quotationdetaillist");


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
        $qdata=quotationmodel::all();
        $qddata=DB::select("select * from tbl_quotation_details where quo_d_id= ?",[$id]);
        return view('quotationdetailedit',['tbl_quotation_details'=>$qddata[0],'pdata'=>$pdata,'qdata'=>$qdata]);
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
        $quo_id=$request->quo_id;
        $p_id=$request->p_id;
        $p_type=$request->p_type;
        $cost_id=$request->cost_id;
        $rate=$request->rate;
        DB::update("update tbl_quotation_details set quo_id=?,p_id=?,p_type=?,cost_id=?,rate=? where quo_d_id=?",[$quo_id,$p_id,$p_type,$cost_id,$rate,$id]);
        return redirect("quotationdetaillist");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::delete("delete from tbl_quotation_details where quo_d_id=$id");
        return redirect('quotationdetaillist');
    }
}
