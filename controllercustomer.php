<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomerModel;
use Illuminate\Support\Facades\Redirect;
use DB;
class controllercustomer extends Controller
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
        $customerdata=CustomerModel::all();
        return view('customerlist',['cdata'=>$customerdata]);
    }
    public function customerreport()
    {
        
    
        $customerdata=CustomerModel::all();
        return view('customerreport',['cdata'=>$customerdata]);
    }
    public function register(Request $request)
    {
        $tbl_customer=new CustomerModel();
        $tbl_customer->cus_name=$request->cus_name;
        $tbl_customer->cus_email=$request->cus_email;
        $tbl_customer->cus_contact=$request->cus_contact;
        $tbl_customer->cus_address=$request->cus_address;
        $tbl_customer->cus_gst_no=$request->cus_gst_no;
        $tbl_customer->cus_password=$request->cus_password;
        $tbl_customer->save();
        return Redirect('clogin');
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $cemail=$request->cus_email;
        $pwd=$request->cus_password;
        $cdata=customermodel::where('cus_email',$cemail)->where('cus_password',$pwd)->first();
        if($cdata)
        {
            $request->session()->put('customer',$cdata->cus_id);
            return redirect('shoplist');
        }
        return redirect('clogin');
    }
    /**
    */

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
        $cdata=DB::select("select * from tbl_customer where cus_id= ?",[$id]);
        return view('customeredit',['tbl_customer'=>$cdata[0]]);
        return redirect('customerlist');
    }
    public function cprofile($id)
    {
        $cdata=DB::select("select * from tbl_customer where cus_id= ?",[$id]);
        
        return view('customer/cprofile',['tbl_customer'=>$cdata[0]]);
        return redirect('shoplist');
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
        $cus_name=$request->cus_name;
        $cus_email=$request->cus_email;
        $cus_contact=$request->cus_contact;
        $cus_address=$request->cus_address;
        $cus_gst_no=$request->cus_gst_no;
        $cus_password=$request->cus_password;
        DB::update("update tbl_customer set cus_name=?,cus_email=?,cus_contact=?,cus_address=?,cus_gst_no=?,cus_password=? where cus_id=?",[$cus_name,$cus_email,$cus_contact,$cus_address,$cus_gst_no,$cus_password,$id]);
        return redirect('customerlist');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
      public function destroy($id)
    {
        DB::delete("delete from tbl_customer where cus_id=$id");
        return redirect('customerlist'); 
    }
    
}

