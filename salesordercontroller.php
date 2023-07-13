<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\salesordermodel;
use App\Models\customermodel;
use App\Models\quotationdetailsmodel;
use App\Models\quotationmodel;
use App\Models\salesorderdetailsmodel;
use DB;

class salesordercontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sodata=salesordermodel::all();
        return view('salesorderlist',['sodata'=>$sodata]);
    }

    public function myorder(Request $request)
    {
        if($request->session()->get('customer')==null)
        return redirect('clogin/');
        $cid=$request->session()->get('customer');
        $sodata=salesordermodel::where('cus_id',$cid)->get();
        return view('customer/myorder',['sodata'=>$sodata]);
    }
    

    public function order(Request $request,$id)
    {
        if(session()->has('customer')==false)
        return redirect('clogin');
       { 
        $qdata=quotationmodel::where('quo_id',$id)->get()->first();
        $sodata= New salesordermodel();
        $sodata->cus_id = session()->get('customer');
        $sodata->date = date("d-m-y");
        $sodata->total=$qdata->total;
        
        $sodata->save();
       } 
        // //$sodata->fresh();
        $so_id = $sodata->so_id;
        $so_id = salesordermodel::max('so_id');

         if($request->session()->get('customer')==null)
         return redirect('clogin');
         //$cid=$request->session()->get('customer');
           
        $id=$qdata->quo_id;
        $qddata=quotationdetailsmodel::where('quo_id',$id)->get();
        // //featch details for inquiry details
         foreach($qddata as $data)
         {

                 $soddata=new salesorderdetailsmodel();
                 $soddata->so_id=$so_id;
                 $soddata->prod_id=$data->p_id;
                 $soddata->quo_id =$data->quo_id;
                 $soddata->save(); 
                 
         }
        // //foreach($cartdata as $data)
        // {
        //    // DB::delete("delete from inqcart where inqcart_id=$data->inqcart_id");
        // }

        return redirect("myorder");

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cdata=customermodel::all();
        return view('salesorderadd',['cdata'=>$cdata]);
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
                $soddata->prod_id=$request->prod_id;
                $soddata->quo_id =$request->quo_id ;
                
                $soddata->save(); 
                return redirect('salesordrelist'); 
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
        $sodata=DB::select("select * from tbl_sales_order where so_id= ?",[$id]);
        return view('salesorderedit',['tbl_sales_order'=>$sodata[0],'cdata'=>$cdata]);
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
        $total=$request->total;
        DB::update("update tbl_sales_order set cus_id=?,date=?,total=? where so_id=?",[$cus_id,$date,$total,$id]);
        return redirect("salesorderlist");
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
