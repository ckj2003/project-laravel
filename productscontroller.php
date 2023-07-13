<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\productsmodel;
use App\Models\inqcartmodel;
use App\Models\inquirymodel;
use App\Models\customermodel;

use App\Models\inquirydetailmodel;



use DB;


class productscontroller extends Controller
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
        $productsdata=productsModel::all();
        return view('productslist',['pdata'=>$productsdata]);
    }
    public function productsreport()
    {
        $productsdata=productsModel::all();
        return view('productsreport',['pdata'=>$productsdata]);
    }
    public function shop()
    {
        $productsdata=productsModel::all();
        $customerdata=CustomerModel::all();
        return view('customer/shop',['pdata'=>$productsdata,'cdata'=>$customerdata]);
    }
    public function productdetail($id)
    {
        $pdata=DB::select("select * from tbl_products where prod_id= ?",[$id]);
        // dd($pdata);
        return view('customer/inquiry',['pdata'=>$pdata[0]]);
    
    }
    public function cartadd(Request $request, $id){
        // dump($id);
        if(session()->has('customer')==false)
        return redirect('clogin');
 
        $product_id = $id;   
        // fetch product data by iwrd
            $inqcamodel = new inqcartmodel();
            $inqcamodel->cus_id = session()->get('customer');
            $inqcamodel->prod_id = $id;
            $inqcamodel->diameter = $request->diameter;
            $inqcamodel->height = $request->height;
            $inqcamodel->width = $request->width;
            $inqcamodel->length = $request->length;
            $inqcamodel->other = $request->other;
            $inqcamodel->save();
            return redirect('/cartlist');
           
    }
    public function cartlisting(){
        if(session()->has('customer')==false)
        return redirect('clogin');
 
    $cartdata=DB::select("select * from inqcart where cus_id= ?",[session()->get('customer')]);
       return view('customer.cartlisting',['cartdata'=>$cartdata]);
        // return view('customer.cartlisting');
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
    public function store(Request $request)
    {
        $tbl_products=new productsmodel();
        $tbl_products->prod_type=$request->prod_type;
        
        $imagename=time()."_img.".$request->prod_img->getclientoriginalExtension();
       // $tbl_products->prod_img=$imagename;
        $request->prod_img->move(public_path('productimg'),$imagename);
        $tbl_products->prod_img=$imagename;
        $tbl_products->prod_gst_slab=$request->prod_gst_slab;
        $tbl_products->save();
        return redirect("productslist");
    }


    public function placeinquiry(Request $request)
    {
        if(session()->has('customer')==false)
        return redirect('clogin');
         
        {
        $inqdata= New inquirymodel();
        $inqdata->cus_id = session()->get('customer');
        $inqdata->date = date("d-m-y");
        
        $inqdata->save();
        };
        //$inqdata->fresh();
        $inq_id = $inqdata->inq_id;
        $inq_id = inquirymodel::max('inq_id');

        if($request->session()->get('customer')==null)
        return redirect('clogin/');
        $cid=$request->session()->get('customer');
           
        $cartdata=inqcartModel::where('cus_id',$cid)->get();
        
        //featch details for inquiry details
        foreach($cartdata as $data)
        {
                $inqdetail=new inquirydetailmodel();
        
                $inqdetail->inq_id=$inq_id;
                $inqdetail->p_id=$data->prod_id;
                $inqdetail->diameter=$data->diameter;
                $inqdetail->height=$data->height;
                $inqdetail->width=$data->width;
                $inqdetail->length=$data->length;
                $inqdetail->other=$data->other;
                
                $inqdetail->save();  
        }
        foreach($cartdata as $data)
        {
            DB::delete("delete from inqcart where inqcart_id=$data->inqcart_id");
        }

        return redirect("thank");

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
    public function about(){
        return view('customer.about');
    }

    public function contact(){
        return view('customer.contact');
    }

    public function addcontact(Request $request){
        $contact = new contect();
        $contact->con_email = $request->con_email;
        $contact->con_description = $request->con_description;
        $contact->save();
        return view('customer.contact');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pdata=DB::select("select * from tbl_products where prod_id= ?",[$id]);
        return view('productsedit',['tbl_products'=>$pdata[0]]);
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
        $prod_type=$request->prod_type;
        $prod_img=$request->prod_img;
        $prod_gst_slab=$request->prod_gst_slab;
        DB::update("update tbl_products set prod_type=?,prod_img=?,prod_gst_slab=? where prod_id=?",[$prod_type,$prod_img,$prod_gst_slab,$id]);
        return redirect("productslist");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::delete("delete from tbl_products where prod_id=$id");
        return redirect('productslist'); 

    }
}
