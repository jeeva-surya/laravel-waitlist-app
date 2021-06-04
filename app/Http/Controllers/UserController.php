<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Hash;
use DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::where('is_admin','!=', '1')->orderBy('position','asc')->distinct();
        $users = $users->paginate(15);
        //dd($request->name);
        return view('users.index',compact('users'))
            ->with('i', (request()->input('page', 1) - 1) * 15);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'cpassword' => 'same:password',
            'referrer_id' => 'required',
            'position' => 'required'
        ],
        [
            'name.required' => "Username field is required",
            'email.required' => "Email field is required",
            'email.unique' => "Email-Id has already been taken",
            'position.required' => "Position field is required",
            'referrer_id.required' => "Referrer-Id field is required",
        ]);

        $user =new User;    
        $user->name =$request->name;
        $user->email =$request->email;
        $user->password =Hash::make($request->password);
        $user->position =$request->position;
        $user->referrer_id =$request->referrer_id;
        
        if($user->save()){
            Session::put('flash_message', 'User successfully added!');
            Session::put('alert-class', 'alert-success');
            return redirect()->back();
        }else{
            Session::put('flash_message', 'User does not added!');
            Session::put('alert-class', 'alert-danger');
            return redirect()->back();
        } 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
         return view('users.show',compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('users.edit',compact('user'));
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
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'position' => 'required',
            //'referrer_id' => 'required',
        ],
        [
            'name.required' => "Username field is required",
            'email.required' => "Email field is required",
            'email.unique' => "Email-Id has already been taken",
            'position.required' => "Position field is required",
            //'referrer_id.required' => "Referrer-Id field is required",
        ]);
    
        $user =User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->position = $request->position;
        if($user->save()){
            Session::put('flash_message', 'User updated successfully!');
            Session::put('alert-class', 'alert-success');
            return redirect()->back();
        }else{
            Session::put('flash_message', 'User details does not added!');
            Session::put('alert-class', 'alert-danger');
            return redirect()->back();
        } 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
    
        return redirect()->route('users.index')
                        ->with('success','User deleted successfully');
    }
}
