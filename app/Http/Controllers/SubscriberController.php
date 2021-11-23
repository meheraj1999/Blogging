<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subscriber;
use Brian2694\Toastr\Facades\Toastr;

class SubscriberController extends Controller
{
    public function store(Request $request){
        $this->validate($request,[
            'email'=>'required|email|unique:subscribers'

        ]);

        $subscribers=new Subscriber();
        $subscribers->email=$request->email;
        $subscribers->save();
        Toastr::success('subscriber added successfully','success');
        return redirect()->back();

    }
}
