<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;        
use App\User;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
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

    // auth handlers
    /**
     * generate jwt token.
     * @param User
     * @return Firebase\JWT\JWT
     */
    private function jwt(User $user) 
    {
        $payload = [
            'iss' => "lumen-jwt", // Issuer of the token
            'sub' => $user->id, // Subject of the token
            'iat' => time(), // Time when JWT was issued. 
            'exp' => time() + env("JWT_EXP") // Expiration time
        ];
        return JWT::encode($payload, env('JWT_SECRET'));
    }

    /**
     * upload file
     *
     * @return PATH
     */
    public function upload()
    {
        $this->validate($this->request, [
            'image'=> 'required|mimes:jpeg,jpg',
        ]);
        $file = date("F j, Y, g:i a")." --" . $this->request->file('image')->getClientOriginalName();
        $this->request->file('image')->move(env("APP_UPLOAD_DIR"), $file );
        return $this->response(201,"File", $file);
    }

    /**
     * Auth user
     * @param User
     * @return JWT
     */
    public function login() 
    {
        //validate incoming request 
        $this->validate($this->request, User::loginRules());

        $password = $this->request->input('password');
        $phone = $this->request->input('phone');
        $user = User::where('phone',$phone)->firstOrFail();
        //not implemented
        $rememberme = $this->request->input('rememberme');

        if (Hash::check($password, $user->password)) {
            return $this->response(201,"User", ['token' => $this->jwt($user), 'user' => $user] );
        }
        abort(401,'Phone number or password is wrong.');
    }

    /**
     * Reresh token from user space
     *
     * @return JWT
     */
    public function refresh()
    {
        return $this->response(202,"User", $this->jwt($this->request->user));
    }

    //resource cruds
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->validate($this->request, User::indexRules());
        
        $users = User::all(); 
        return $this->response(200,"User", $users );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $user = User::findOrFail($id);

        return $this->response(200,"User", $user );

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->validate($this->request, User::createRules());

        $user = new User;
        $user->name = $this->request->name;
        $user->phone = $this->request->phone;
        $user->dob = $this->request->dob;
        $user->image = $this->request->image_path;
        $plainPassword = $this->request->password;
        $user->password = app('hash')->make($plainPassword);

        $user->save();

        //return successful response
        return $this->response(201,"User", $user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
                                
        $project = Project::findOrFail($id);

        $project->update( $this->request->only('name','image','dob','phone','privileges') );

        return $this->response(202,"User", $user );

       
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {

        $this->validate($this->request, User::updateRules());
                                        
        $user= User::findOrFail($id);
        
        $user->name= $this->request->name;
        $user->image = $this->request->image;
        $user->dob = $this->request->dob;
        $user->phone = $this->request->phone;
        $this->request->privileges && $user->privileges = $this->request->privileges;

        $user->save();

        return $this->response(202,"User", $user );


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
                
        $user = User::findOrFail($id);
        $user->delete();

        //  return response()->json([ 'message' =>'user removed successfully'],202);
        return $this->response(207,"User", $user );


    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function bills($id)
    {
        if(!$this->request->user->is_admin){

            if($this->request->user->id != $id) return response()->json([ "errors" => ["permission denied"] ], 403);
        }
        
        $bills = User::findOrFail($id)->bills();
        foreach ($bills as $bill) {
            $bill->project_id = $bill->project();
            $bill->user_id = $bill->user();
            $bill->payment_id = $bill->payment();
        }
        return $this->response(200,"User", $bills );

    }
}
