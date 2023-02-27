<?php

namespace App\Http\Controllers;

use App\Models\department;
use App\Models\Complain;
use Illuminate\Http\Request;

class DeptLoginController extends Controller
{
    public function index()
    {
        return view('deptlogin');
    }

    public function deptlogin(Request $request)
    {
        $request->validate(
            [
                'email' => 'email|required',
                'passward' => 'required',
            ]
        );

        $user = department::where('email', $request->input('email'))->get();

        // echo "<pre>";
        // print_r($user);

        if (empty($user->all())) {
            return redirect('/deptlogin')->withError('Invalid email or password');
        } elseif ($user[0]->passward == $request->input('passward')) 
        { 
            session()->put('dept_id', 1);
            // return redirect('/deptlogin/deptdash');
        } else {
            return redirect('/deptlogin')->withError('Invalid email or password');
        }
    }

    public function viewdash($de){
       
        if(!is_null($de)){
            $complaints = Complain::where('dept', $de)->get();
            $data = compact('complaints');
            return view('deptDash')->with($data);
        }
    }

    public function deptedit($de, $id)
    {
        $complain = Complain::find($id);
        if(is_null($complain)){
            $url = url('/deptlogin/deptdash') ."/". $de;
            return redirect($url);
        }
        else{
            $url = url('/deptlogin/deptdash') ."/". $de . "/update" . "/" . $id;
            // $url = url('/deptlogin/deptdash/{de}/update/{id}') ."/". $id;
            // echo $url;
            $data = compact('complain', 'url', 'id');
            // echo "<pre>";
            // print_r($data);
            return view('deptEditComplain')->with($data , $url);
        }
    }

    public function deptupdate($id, Request $request, $de){

        $fileName = time() . "-ocrs-" . date('d-m-y') . "." . $request->file('update_file')->getClientOriginalExtension();
        $fileloc = $request->file('update_file')->storeAs('public/uploads/update', $fileName);

        $complain = Complain::find($de);
        $complain->status = $request['status'];
        $complain->file_update = $fileloc;
        $complain->save();
        echo "<pre>";
        print_r($complain);
        $url = url('/deptlogin/deptdash') ."/". $id;
        return redirect($url);
    }

    // public function deptdash()
    // {
    //     $complaints = Complain::where('department_id', 'water')->get();
    //     // where 1 is the ID of the water department in the database
    //     return view('deptdash', ['complain' => $complaints]);
    // }
}
