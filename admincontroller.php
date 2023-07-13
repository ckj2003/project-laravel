<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\adminmodel;
use DB;

class admincontroller extends Controller
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
        $admindata=adminModel::all();
        return view('adminlist',['adata'=>$admindata]);
    }
    public function login(Request $request)
    {
        $uname=$request->user_name;
        $pwd=$request->password;
        $admindata=adminmodel::where('user_name',$uname)->where('password',$pwd)->first();
        if($admindata)
        {
            $request->session()->put('admin',$admindata->user_name);
            return redirect('dashboard');
        }
        else{
                 return redirect('/login');
            }  
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
        $tbl_admin=new adminmodel();
        $tbl_admin->user_name=$request->user_name;
        $tbl_admin->Email=$request->Email;
        $tbl_admin->password=$request->password;
        $tbl_admin->save();
        return Redirect('login');

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
        //
    }
}
