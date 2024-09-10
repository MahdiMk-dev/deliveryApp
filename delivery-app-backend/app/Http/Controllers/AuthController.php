<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\User;
use Illuminate\Support\Facades\Hash; // Add this line

class AuthController extends Controller
{
    public function login(Request $request)
{
    $credentials = $request->validate([
        'username' => 'required',
        'password' => 'required'
    ]);
    $user = User::where('username', $credentials['username'])->first();


    if (!$user) {
        // Username doesn't exist
        return response()->json([
            'status' => 404,
            'message' => 'Username does not exist'
        ], 404);
    }

    // Check if the password is correct
    if (!Hash::check($credentials['password'], $user->password)) {
        // Password is incorrect
        return response()->json([
            'status' => 401,
            'message' => 'Incorrect password'
        ], 401);
    }

    $token = auth()->attempt($credentials);

    if (!$token) {
        return response()->json([
            'status' => 'error',
            'message' => 'Credentials incorrect'
        ], 401);
    }

    return response()->json([
        'token' => $token,
        'user' => auth()->user(),
        'status'=>'success',
        'expire_in' => auth()->factory()->getTTL() * 60
    ]);
}
public function me()
{

    return response()->json(['status'=>'success'] );
}
  
}
