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
use Image;

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
                $insert = DB::table('otp_verifies')->insert([
                    'email' => $data['email'],
                    'otp' => $otp,
                    'data' => json_encode($data),
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
        $check_token = DB::table('otp_verifies')->where([
            'otp' => $request->otp
        ])->first();
        $pre_data = json_decode($check_token->data);
        if (!$check_token) {
            return response(["status" => 401, 'message' => 'Invalid']);
        } else {
            $user = new User();
            $user->first_name = $pre_data->first_name;
            $user->last_name = $pre_data->last_name;
            $user->username = $pre_data->username;
            $user->phone = $pre_data->phone;
            $user->email = $pre_data->email;
            $user->password = Hash::make($pre_data->password);
            if ($pre_data->password === $pre_data->confirm_password) {
                $user->save();
            } else {
                return response()->json('Confirm Password Not Match!', 422);
            }

            if (Auth::attempt(['email' => $pre_data->email, 'password' => $pre_data->password])) {
                $user = User::where('email', $pre_data->email)->first();
                $access_token = $user->createToken($pre_data->email)->accessToken;
                User::where('email', $pre_data->email)->update(['access_token' => $access_token]);
                $message = 'User Successfully Registerd';
                return response()->json([$message, 'access_token' => $access_token], 201);
            } else {
                $message = 'Opps! Something went wrong';
                return response()->json($message, 422);
            }
            $verify = DB::table('otp_verifies')->where('email', $check_token->email)->first();
            $verify->delete();
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

    public function logout(Request $request)
    {
        $token = $request->user()->token();
        $token->revoke();
        $message = 'User Successfully Logout';
        return response()->json($message, 201);
    }

    public function dashboard()
    {
        $user = User::all();
        return response()->json($user, 201);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'phone' => 'numeric',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $user = User::findOrFail($id);
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->phone = $request->phone;
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            if (file_exists($user->photo)) {
                unlink(base_path("public/assets/uploads/user_photos/.$user->photo"));
            }
            $photo_name = 'photo_' . rand() . '.' . $photo->getClientOriginalExtension();
            $photo_resize = Image::make($photo->getRealPath());
            $photo_resize->resize(512, 512);
            $photo_resize->save(public_path("assets/uploads/user_photos/$photo_name"));
            $user->photo = $photo_name;
        }
        $user->update();
        return response()->json([
            "success" => true,
            "message" => "User updated successfully.",
            "data" => $user
        ]);
    }
}
