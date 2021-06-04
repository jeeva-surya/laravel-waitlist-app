<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm(Request $request)
    {
        if ($request->has('ref')) {
            session(['referrer' => $request->query('ref')]);
        }
        return view('auth.register');
    }
    

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $users = User::all();
        $total = $users->count();
        $usercount = 99 + $total;
        $referrer = User::wherereferral_token(session()->pull('referrer'))->first();
        
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'referrer_id' => $referrer ? $referrer->id : null,
            'referral_token' => Str::random(20),
            'position'  => $usercount,
        ]);
        if($referrer != null){
            $pos = (int)$referrer->position - 1;
            $u = User::where("id", $referrer->id)->update(["position" => $pos]);
            if($referrer->position == "2"){
                $d = $referrer->email;
                $data['referral_link'] = "";
                $data['name']  = $referrer->name;
                $data["body"] = "Congratz! You Win a new iPhone Product. You can use your coupon-code(WAITLIST100) to purchase the product.";
                Mail::send('mail', $data, function($message) use ($data,$d)
                {
                    $message->from('jeevasurya968@gmail.com', "WaitList Application");
                    $message->subject("Welcome to WaitList Application");
                    $message->to($d);
                });
            }
        }

        $data['name']  = $user->name;
        $data['referral_link'] = $user->referral_token;
        $data["body"] = "Congratz! Share your referral links online with your friends and family. It will help you buy a new iPhone Product.";

        Mail::send('mail', $data, function($message) use ($data)
        {
            $message->from('jeevasurya968@gmail.com', "WaitList Application");
            $message->subject("Welcome to WaitList Application");
            $message->to($data['email']);
        });
        
        return $user;
    }
}
