<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\inquirydetailmodel;
use App\Models\productsmodel;
use App\Models\inquirymodel;
use App\Models\inqcartModel;
use DB;

class inquirydetailscontroller extends Controller
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
        $inqddata=inquirydetailmodel::all();
        return view('inquirydetaillist',['inqddata'=>$inqddata]);
    }

    public function inqdetail($id)
    {
        //$inqddata=inquirydetailmodel::where('inq_id',$id);
        $inqddata=DB::select("select * from tbl_inquiry_details where inq_id= ?",[$id]);
        return view('customer/inqdetail',['inqddata'=>$inqddata]);

    }

    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $inqdata=inquirymodel::all();
        $pdata=productsmodel::all();
        return view('inquirydetailadd',['inqdata'=>$inqdata,'pdata'=>$pdata]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$id)
    {
        $inqdetail=new inquirymodel();
        
        
        $inqdetail->prod_id=$id;
        $inqdetail->diameter=$request->diameter;
        $inqdetail->height=$request->height;
        $inqdetail->width=$request->width;
        $inqdetail->length=$request->length;
        $inqdetail->other=$request->other;
        
        $inqdetail->save();
        return redirect("cartlist");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $inqdata=inquirymodel::all();
        $pdata=productsmodel::all();
        $inqddata=DB::select("select * from tbl_inquiry_details where inq_d_id= ?",[$id]);
        return view('inquirydetailedit',['tbl_inquiry_details'=>$inqddata[0],'inqdata'=>$inqdata,'pdata'=>$pdata]);
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
        $inq_id=$request->inq_id;
        $p_id=$request->p_id;
        $diameter=$request->diameter;
        $height=$request->height;
        $width=$request->width;
        $length=$request->length;
        $other=$request->other;
        DB::update("update tbl_inquiry_details set inq_id=?,p_id=?,diameter=?,height=?,width=?,length=?,other=? where inq_d_id=?",[$inq_id,$p_id,$diameter,$height,$width,$length,$other,$id]);
        return redirect('inquirydetaillist');
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
