<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\quotationmodel;
use App\Models\customermodel;

use DB;

class quotationcontroller extends Controller
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
        $qdata=quotationmodel::all();
        return view('quotationlist',['qdata'=>$qdata]);
    }
    public function quotation(Request $request)
    {
        
       // $qdata=DB::select("select * from tbl_quotation where cus_id= ?",[$id]);
        //return view('customer/quotation',['qdata'=>$qdata]);
    
        if($request->session()->get('customer')==null)
        return redirect('clogin/');
        $cid=$request->session()->get('customer');
           
        $qdata=quotationmodel::where('cus_id',$cid)->get();
        
        return view('customer/quotation',['qdata'=>$qdata]);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cdata=customermodel::all();
        return view('quotationadd',['cdata'=>$cdata]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tbl_quotation=new quotationmodel();
        $tbl_quotation->quo_id=$request->quo_id;
        $tbl_quotation->cus_id=$request->cus_id;
        $tbl_quotation->date=$request->date;
        $tbl_quotation->total=$request->total;
        $tbl_quotation->save();
        return redirect("quotationlist");
    }

    public function quotationadd(Request $request, $id)
    {
        // dump($id);
        if(session()->has('customer')==false)
        return redirect('clogin');
 
        
        // fetch product data by id
            $quomodel = new quotationmodel();
            $quomodel->cus_id = session()->get('customer');  
            $quomodel->date = $request->date;
            $quomodel->total = $request->total;
            
            $quomodel->save();
            return redirect('/quotation');
       
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
        $qdata=DB::select("select * from tbl_quotation where quo_id= ?",[$id]);
        return view('quotationedit',['tbl_quotation'=>$qdata[0],'cdata'=>$cdata]);
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
        DB::update("update tbl_quotation set cus_id=?,date=?,total=? where quo_id=?",[$cus_id,$date,$total,$id]);
        return redirect("quotationlist");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::delete("delete from tbl_quotation where quo_id=$id");
        return redirect('quotationlist');
    }
}
