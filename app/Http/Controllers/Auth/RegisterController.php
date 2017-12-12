<?php

namespace App\Http\Controllers\Auth;

use App\ActivationService;
use App\Traits\PassportToken;
use App\Transformers\Json;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

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
    use PassportToken;
    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';
    protected $activationService;
    protected $user;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(User $user, ActivationService $activationService)
    {
        $this->user = $user;
        $this->middleware('guest');
        $this->activationService = $activationService;
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    public function signup(Request $request){
        $this->validate($request,[
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);

        $createdUser = $this->user->create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);
        $domainClient = '';
        if(isset($request->server()['HTTP_ORIGIN'])) {
            $domainClient = $request->server()['HTTP_ORIGIN'];
        }
        $this->activationService->sendActivationMail($createdUser, $domainClient);
        return response()->json(Json::response(null, 'success'));
    }

    public function activateUser(Request $request)
    {
        $this->validate($request,[
            'token' => 'required|min:3',
        ]);
        $token = $request->input('token');
        if ($user = $this->activationService->activateUser($token)) {
            $tokenData =  $this->getBearerTokenByUser($user, 1, false);
            return response()->json( $tokenData );
        }
        abort(404);
    }
}
