<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    protected $redirectPath = '/auth/login';
    // protected $redirectPath = '/auth';
    protected $loginPath = '/auth/login';
    protected $failPath = '/auth/fail';


    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

 
    protected function validator(array $data)
    {
        
        $v = Validator::make($data, [
	            'name' 		 	=> 'required|max:255',
	            'english_name' 	=> 'required|max:255',
	            'email' 	 	=> 'required|email|max:255|unique:users',
	            'password' 		=> 'required|confirmed|min:6',
	            'staff_id' 	 	=> 'required',
	            'first_day'     => 'required|date|before:tomorrow',
	        ]);

        return $v;
    }


    protected function create(array $data)
    {
        $user = User::create([
	            'name' 			=> $data['name'],
	            'english_name' 	=> $data['english_name'],
	            'email' 		=> $data['email'],
	            'password' 		=> bcrypt($data['password']),
	            'staff_id' 		=> $data['staff_id'],
	            'first_day_company' => $data['first_day']
	        ]);

        return $user;
    }

    public function getLogin()
   	{
       	return view('auth.login');
   	}

	public function postLogin(Request $request)
	{
		
		$this->validate($request, [
			$this->loginUsername() => 'required', 'password' => 'required',
		]);

		$throttles = $this->isUsingThrottlesLoginsTrait();

		if ($throttles && $this->hasTooManyLoginAttempts($request)) {
			return $this->sendLockoutResponse($request);
		}

		$credentials = $this->getCredentials($request);

		if (\Auth::attempt($credentials, $request->has('remember'))) {
			return $this->handleUserWasAuthenticated($request, $throttles);
		}


		if ($throttles) {
			$this->incrementLoginAttempts($request);
		}

		return redirect($this->loginPath())
			->withInput($request->only($this->loginUsername(), 'remember'))
			->withErrors([
				$this->loginUsername() => $this->getFailedLoginMessage(),
		]);
	}

	protected function handleUserWasAuthenticated(Request $request, $throttles){
       	if ($throttles) {
    	    $this->clearLoginAttempts($request);
       	}
       	
       	if (method_exists($this, 'authenticated')) {
    	   return $this->authenticated($request, Auth::user());
       	}
       	return redirect()->intended($this->redirectPath());
   	}

   	protected function getCredentials(Request $request){
    	return $request->only($this->loginUsername(), 'password');
   	}

   	protected function getFailedLoginMessage(){
   		
   		return \Lang::has('auth.failed')
               ? \Lang::get('auth.failed')
               : 'These credentials do not match our records.';
    
  	}

  	public function getLogout(){
    	
    	\Auth::logout();
    	return redirect(property_exists($this, 'redirectAfterLogout') ? $this->redirectAfterLogout : '/');
   	}


   	public function loginUsername(){
    	return property_exists($this, 'username') ? $this->username : 'email';
 	}

 	protected function isUsingThrottlesLoginsTrait(){
    	return in_array(
        	ThrottlesLogins::class, class_uses_recursive(get_class($this))
    	);
   	}

   	public function getRegister(){
    	return view('auth.register');
   	}

   	public function postRegister(Request $request){
    	$validator = $this->validator($request->all());

    	if ($validator->fails()) {
           	$this->throwValidationException(
            	$request, $validator
           	);
       	}

    	// \Auth::login($this->create($request->all()));
    	$this->create($request->all());
    	// dd($this->redirectPath());
    	return redirect($this->redirectPath());
   	}

}
