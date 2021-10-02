<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class ApiController extends Controller
{
    function register(Request $request)
    {
        $user = new User;
        $user->name=$request->name;
        $user->email=$request->email;
        $user->password=$request->password;
        $user->user_type=$request->user_type;
        $result=$user->save();
        if($result){
            return["Result"=>'Registered Successfully'];
        } else {
            return["Result"=>'data not saved'];
        }
    }
    function login(Request $request)
    {
        $user = new User;
        $user->email=$request->email;
        $user->password=$request->password;
        if($user->email && $user->password) {
            return["Result"=>'Login Successfully'];
        } else {
            return["Result"=>'Login failed'];
        }

    }
}
