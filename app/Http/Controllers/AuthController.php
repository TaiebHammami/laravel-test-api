<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
  function Register(Request $request){

    $user = $request->validate([
        'name' => ['required' , 'string' , 'min:2' , 'max:2500'],
        'email' =>['required' , 'email' , 'unique : users,column,email'],
        "password" =>["required",'string','min:8','max:30']
    ]);
          
    $users = User::create([
        'name' => $user['name'],
        'email' => $user['email'],
        'password' => bcrypt($user['password'])
    ]);

    if(!$users){
      return response(["message" => "impossible"]);
    }else{
       return response($users,201);
    }
   


  }
  
  function Login(Request $R){
    $utilisateurDonnee = $R->validate([
        "email" =>["required", "email"],
        "password" =>["required","string","min:8","max:30"]
    ]);
  $utilisateur =   User::where("email",$utilisateurDonnee["email"])->first();
   if(!$utilisateur){
      return response(["message" => "Aucun utilisateur de trouver "]);
   }else{
     $token = $utilisateur->createToken()->plainTextToken;
   return response([
    "User" => $utilisateur,
    "token" => $token],200);
   }
  }
}
