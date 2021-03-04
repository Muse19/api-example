<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends ApiController
{
  public function __construct(){
    $this->middleware('auth:api', ['except' => ['login']]);
  }

  public function login(Request $request) {

    if (! $token = auth()->attempt($request->only('email', 'password'))) {
      return $this->errorResponse('Usuario y/o contraseña incorrectos', 400);
    }

    return $this->createNewToken($token);

  }

  public function logout() {
    auth()->logout();

    return $this->showMessage(['Usuario desconectado correctamente']);
  }

  public function refresh() {
    return $this->createNewToken(auth()->refresh());
  }

  public function userProfile() {
    $user = auth()->user();
     
    return $this->showResponse($user);
  }

  protected function createNewToken($token){
    return response()->json([
        'access_token' => $token,
        'token_type' => 'bearer',
        'user' => auth()->user(),
    ]);
  }
}
