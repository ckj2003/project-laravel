<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\inquirymodel;
use App\Models\customermodel;
use DB;

class inquirycontroller extends Controller
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

        
        //return view('inquirylist',['inqdata'=>$inqdata]);
        $cdata=customermodel::all();
        $inqdata=inquirymodel::all();
        $inqdata=inquirymodel::join("tbl_customer","tbl_inquiry.cus_id","=","tbl_customer.cus_id")->get(['tbl_customer.*','tbl_inquiry.*']);
        return view('inquirylist',['inqdata'=>$inqdata]);
    }
    public function inquiryreport()
    {
        //return view('inquirylist',['inqdata'=>$inqdata]);
        $cdata=customermodel::all();
        $inqdata=inquirymodel::all();
        $inqdata=inquirymodel::join("tbl_customer","tbl_inquiry.cus_id","=","tbl_customer.cus_id")->get(['tbl_customer.*','tbl_inquiry.*']);
        return view('inquiryreport',['inqdata'=>$inqdata]);
    }
    public function myinquiry(Request $request)
    {
        if($request->session()->get('customer')==null)
        return redirect('clogin/');
        $cid=$request->session()->get('customer');
           
        $inqdata=inquirymodel::where('cus_id',$cid)->get();
        return view('customer/myinquiry',['inqdata'=>$inqdata]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customerdata=customermodel::all();
        return view('inquiryadd',['cdata'=>$customerdata]);
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tbl_inquiry=new inquirymodel();
        $tbl_inquiry->cus_id =$request->cus_id;
        $tbl_inquiry->date=$request->date;
        $tbl_inquiry->save();
        return redirect("inquirylist");
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
        $cdata=customermodel::all();
        $inqdata=DB::select("select * from tbl_inquiry where inq_id= ?",[$id]);
        return view('inquiryedit',['tbl_inquiry'=>$inqdata[0],'cdata'=>$cdata]);
        return redirect('inquirylist');
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
        $cus_id=$request->cus_id;
        $date=$request->date;
        DB::update("update tbl_inquiry set cus_id=?,date=? where inq_id=?",[$cus_id,$date,$id]);
        return redirect('inquirylist');
        
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::delete("delete from tbl_inquiry where inq_id=$id");
        return redirect('inquirylist');
    }
}
