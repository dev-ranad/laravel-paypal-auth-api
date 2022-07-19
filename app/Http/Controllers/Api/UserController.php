<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;
use Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\sendEmail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function register(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            $validator = Validator::make($data, $rules = [
                'first_name' => 'required',
                'last_name' => 'required',
                'username' => 'required|unique:users',
                'email' => 'required|email|unique:users',
                'phone' => 'numeric',
                'password' => 'required',
                'confirm_password' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            } else {
                $otp = rand(1000, 9999);
                Log::info("otp = " . $otp);
                $insert = DB::table('password_resets')->insert([
                    'email' => $data['email'],
                    'token' => $otp,
                    'created_at' => Carbon::now()
                ]);

                if ($insert) {
                    $action_link = route('varify.user');
                    $email_body = "We are received a request to verify user for <b>Task API Application</b> account associated with " . $data['email'] . ". You can get your verify page by clicking the link below";
                    $otp = "Your OTP is : " . $otp;
                    $send_mail = Mail::send('email.verify', ['action_link' => $action_link, 'otp' => $otp,  'email_body' => $email_body], function ($message) use ($request) {
                        $message->from('noreply@example.com', 'Task API Application');
                        $message->to($request->email, 'User')
                            ->subject('User Verification Email');
                    });
                    if ($send_mail) {
                        $session_data = $request->session(['data' => $data]);
                    }
                    return response(["status" => 200, "message" => "OTP sent successfully", "data" => $session_data]);
                } else {
                    return response(["status" => 401, 'message' => 'Invalid']);
                }
            }
        }
    }

    public function varify_user(Request $request)
    {
        $check_token = DB::table('password_resets')->where([
            'email' => $request->email,
            'token' => $request->otp
        ])->first();
        if (!$check_token) {
            return response(["status" => 401, 'message' => 'Invalid']);
        } else {
            $data = Session::get('data');
            $user = new User();
            $user->first_name = $data['first_name'];
            $user->last_name = $data['last_name'];
            $user->username = $data['username'];
            $user->phone = $data['phone'];
            $user->email = $data['email'];
            $user->password = Hash::make($data['password']);
            if ($data['password'] === $data['confirm_password']) {
                $user->save();
            } else {
                return response()->json('Confirm Password Not Match!', 422);
            }


            if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
                $user = User::where('email', $data['email'])->first();
                $access_token = $user->createToken($data['email'])->accessToken;
                User::where('email', $data['email'])->update(['access_token' => $access_token]);
                $message = 'User Successfully Registerd';
                return response()->json([$message, 'access_token' => $access_token], 201);
            } else {
                $message = 'Opps! Something went wrong';
                return response()->json($message, 422);
            }
        }
    }

    public function login(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            $validator = Validator::make($data, $rules = [
                'email' => 'required|email|exists:users',
                'password' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
                $user = User::where('email', $data['email'])->first();
                $access_token = $user->createToken($data['email'])->accessToken;
                User::where('email', $data['email'])->update(['access_token' => $access_token]);
                $message = 'User Successfully Login';
                return response()->json([$message, 'access_token' => $access_token], 201);
            } else {
                $message = 'Invalid email or password';
                return response()->json($validator->errors(), 422);
            }
        }
    }

    public function logout($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        $message = 'User Successfully Logout';
        return response()->json($message, 201);
    }


}
