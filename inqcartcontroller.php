<?php

namespace App\Http\Controllers;

use App\Models\customermodel;
use Illuminate\Http\Request;
use App\Models\inqcartmodel;
use DB;

class inqcartcontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $cartdata=inqcartModel::all();
        return view('customer/cartlist',['cartdata'=>$cartdata]);

    }
    public function cart(Request $request)
    {
        if($request->session()->get('customer')==null)
        return redirect('clogin/');
        $cid=$request->session()->get('customer');
           
        $cartdata=inqcartModel::where('cus_id',$cid)->get();
        
        return view('customer/cartlist',['cartdata'=>$cartdata]);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cdata=customermodel::all();
        return view('inquiryadd',['cdata'=>$cdata]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$id)
    {
        $inqcart=new inqcartmodel();
        
        
        $inqcart->prod_id=$id;
        $inqcart->diameter=$request->diameter;
        $inqcart->height=$request->height;
        $inqcart->width=$request->width;
        $inqcart->length=$request->length;
        $inqcart->other=$request->other;
        
        $inqcart->save();
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::delete("delete from inqcart where inqcart_id=$id");
        return redirect('cartlist'); 
    }
}
