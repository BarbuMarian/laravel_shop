<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;

use Illuminate\Http\Request;
use App\User;
use Session;
class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $users = User::all();
        $username = $request->input('username');
        $password = $request->input('password');
        $db = User::where('username', $username)->where('password', $password)->get();
        if (!$db->count()) {
              $message = "Te rog sa completezi datele corecte";
              //return redirect('login')->with('message',$message);
              return redirect()->route('logIn')->with('message',$message);

        }else {

            $request->session()->put('admin' ,$username);
            $get_sesstion = $request->session()->get('admin');
            return redirect('admin')->with('success', 'Te-ai logat cu succes');
        }

    }

    public function logOut(Request $request){
        $get_sesstion = $request->session()->get('admin');

        $request->session()->flush();

        //return redirect('/')->with('logout', 'Te-ai delogat');
         return redirect()->route('sorting')->with('message', 'Te-ai delogat');
    }



}
