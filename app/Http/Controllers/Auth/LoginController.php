<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
  /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

  use AuthenticatesUsers;

  /**
   * Where to redirect users after login.
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
    $this->middleware('guest')->except('logout');
  }

  public function rules($request)
  {
    $rule = [
      'username' => 'required|string|exists:users,username',
      'password' => 'required|string'
    ];

    $pesan = [
      'username.required' => 'Username tidak boleh kosong!',
      'username.exists' => 'Username tidak ditemukan!',
      'password.required' => 'Password tidak boleh kosong!'
    ];

    return Validator::make($request, $rule, $pesan);
  }

  public function login(Request $request)
  {
    $input = $request->all();
    $validator = $this->rules($input);

    if ($validator->fails()) {
      // return redirect()->back()->with('errors', $validator->errors());
      return response()->json(['status' => false, 'pesan' => $validator->errors()], 200);
    } else {
      $fieldType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

      $remember_me  = (!empty($request->remember_me)) ? TRUE : FALSE;

      // Load user from database
      $user = User::where('username', $input['username'])->first();
      $check_publish = ($user->is_publish == '1') ? TRUE : FALSE;

      if (empty($user)) {
        return response()->json(['status' => false, 'pesan' => 'Akun tidak ditemukan!'], 200);
      }

      if ($user && Hash::check($request->password, $user->password)) {
        if (auth()->attempt(array($fieldType => $input['username'], 'password' => $input['password']), $check_publish)) {
          Auth::login($user, true);
          // return redirect(route($this->redirectTo));

          return response()->json(['status' => true, 'pesan' => 'Selamat datang ' . $user->name . '!', 'url_home' => route($this->redirectTo)], 200);
        } else {
          return response()->json(['status' => false, 'pesan' => 'Akun tidak aktif!'], 200);
        }
      } else {
        return response()->json(['status' => false, 'pesan' => 'Username atau password salah!'], 200);
      }
    }
  }

  public function showLoginForm()
  {
    return view('auth.login');
  }

  public function username()
  {
    return 'username';
  }
}