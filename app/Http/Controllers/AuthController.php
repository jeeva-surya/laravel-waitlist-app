<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Mail;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name'  => 'required',
            'email' => 'required|email|unique:users',
            'password'  => 'required|string|min:8',
        ]);
        if($validator->fails()){
            return response()->json($validator->messages(),400);
        }
        if ($request->has('ref')) {
            session(['referrer' => $request->query('ref')]);
        }
        $users = User::all();
        $total = $users->count();
        $usercount = 99 + $total;
        $referrer = User::wherereferral_token(session()->pull('referrer'))->first();
        
        $user =new User;    
        $user->name =$request->name;
        $user->email =$request->email;
        $user->password =Hash::make($request->password);
        $user->referrer_id =$referrer ? $referrer->id : null;
        $user->referral_token =Str::random(20);
        $user->position =$usercount;
        
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

        
        $user->save();

        return response()->json([
            'message' => 'Registration Successful'
        ], 200);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'password'  => 'required'
        ]);
        if($validator->fails()){
            return response()->json([
                $validator->messages(),
            ],400);
        }
        $credentials = request(['email', 'password']);
        if (!Auth::attempt($credentials))
            return response()->json(['message' => 'Unauthorized'], 401);
        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        return $this->loginSuccess($tokenResult, $user);
    }

    protected function loginSuccess($tokenResult, $user)
    {
        $token = $tokenResult->token;
        $token->expires_at = Carbon::now()->addWeeks(100);
        $token->save();
        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString(),
            'user' => [
                'Name' => $user->name,
                'Email' => $user->email,
                'Referral Link' =>  \URL::to('/register?ref='.$user->referral_token),
                'Referrer' => $user->referrer->name ?? 'Not Specified',
                'Referral Count' => count($user->referrals)  ?? '0',
                'Position' => $user->position
            ]
        ]);
    }
}
