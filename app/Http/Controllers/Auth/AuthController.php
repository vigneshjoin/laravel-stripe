<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Session;

class AuthController extends Controller
{

    /**

     * Write code on Method

     *

     * @return response()

     */

    public function index()
    {
        if(!Auth::check()) 
            return view('auth.login');
        else
            return redirect('products');
        
    }

    /**

     * Write code on Method

     *

     * @return response()

     */

    public function registration()
    {
        return view('auth.registration');
    }

    /**

     * Write code on Method

     *

     * @return response()

     */

    public function postLogin(Request $request)
    {
        // $validator = $request->validate([
        //     'email' => 'required',
        //     'password' => 'required',
        // ]);

        $validator = Validator::make($request->all(), [ 'email' => 'required|email', 'password' => 'required' ]);


        // dd( $validator->errors());
        // if ($validator->fails()) { 
        //     dd('ppp');
        //     return $validator->errors();
        //  }
        //  if ($validator->passes()) {
        //     dd();
        //  }


        

        $credentials = $request->only('email', 'password');
try{
// dd($validator);
// if ($validator->fails()) {
//     $messages = $validator->messages();

//     dd($messages);
// }



        if (Auth::attempt($credentials)) {
            return redirect()->intended('products')
                ->withSuccess('You have Successfully loggedin');
        }

    } 
    catch (\Exception $e) {
        return back()->withErrors(['message' => 'Error . ' . $e->getMessage()]);
    }
        return redirect("login")->withSuccess('Oppes! You have entered invalid credentials');
    }

    /**

     * Write code on Method

     *

     * @return response()

     */

    public function postRegistration(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);
        $data = $request->all();
        $check = $this->create($data);
        return redirect("login")->withSuccess('Great! You have Successfully loggedin');
    }

    /**

     * Write code on Method

     *

     * @return response()

     */

    // public function dashboard()
    // {

    //     if (Auth::check()) {

    //         return view('/dashboard');

    //     }
    //     return redirect("login")->withSuccess('Opps! You do not have access');
    // }

    /**

     * Write code on Method

     *

     * @return response()

     */

    public function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    /**

     * Write code on Method

     *

     * @return response()

     */

    public function logout()
    {
        Session::flush();
        Auth::logout();
        return Redirect('login');
    }

}
