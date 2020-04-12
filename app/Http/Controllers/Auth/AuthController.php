<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    // ===========================================================================================================================================
    // ================================================token g routine ========================================================================
    // ===========================================================================================================================================
    protected function jwt(User $user) {
        $payload = [
            'iss' => "lumen-jwt", // Issuer of the token
            'sub' => $user->id, // Subject of the token
            'iat' => time(), // Time when JWT was issued. 
            'exp' => time() + 60*60 // Expiration time
        ];
        
        // As you can see we are passing `JWT_SECRET` as the second parameter that will 
        // be used to decode the token in the future.
        return JWT::encode($payload, env('JWT_SECRET'));
    } 

    // ===========================================================================================================================================
    // ================================================register routine ========================================================================
    // ==========================================================================================================================================
    public function register(Request $request)
    {
        //validate incoming request 
        // $this->validate($request, [
        //     'name'=> 'required|string',
        //     'phone'=> 'required|string|unique:users',
        //     'dob'=> 'required|string',
        //     'image'=> 'required|string',
        //     'password'=> 'required|string|confirmed',
        // ]);

        try {
           
            // $user = new User;
            // $user->name = $request->input('name');
            // $user->phone = $request->input('phone');
            // $user->dob = $request->input('dob');
            // $file = $request->file('image')->getClientOriginalName();
            $request->file('image')->move('./upload', 'file.jpeg');
            // $user->image = 'file.jpeg';
            // $plainPassword = $request->input('password');
            // $user->password = app('hash')->make($plainPassword);

            // $user->save();

        } catch (\Exception $e) {
            
            abort(409,'User Registration Failed!' . $e->getMessage());
        }

        //return successful response
        return response()->json(['message' => 'registration was successfull'], 201);
    }

    // ===========================================================================================================================================
    // ================================================login routine ========================================================================
    // ===========================================================================================================================================
    public function login(User $user){
        
        //validate incoming request 
        $this->validate($this->request, [
            'phone' => 'required',
            'password' => 'required',
        ]);

            $password = $this->request->input('password');
            $phone = $this->request->input('phone');
            $user = User::where('phone',$phone)->firstOrFail();

            if (Hash::check($password, $user->password)) {
                
                return response()->json([
                    'token' => $this->jwt($user)
                ], 201);
            }
            
            abort(401,'Phone number or password is wrong.');
    }

    // ===========================================================================================================================================
    // ================================================refresh routine ========================================================================
    // ===========================================================================================================================================
    public function refresh(Request $r){
        
        //validate incoming request 
        return response()->json(['token' => $this->jwt($r->auth)],202);
    }

}
