<?php

namespace App\Http\Controllers;
use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Catch_;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleGoogleCallback(){
        try{
            $user= Socialite::driver('google')->user();
            $finduser = User::where('social_id', $user->id)->first();
            if($finduser){
                Auth::login($finduser);
                return response()->json($finduser);

            }
            else{
                $newUser = User::create([
                    'name'=>$user->name,
                    'email'=>$user->email,
                    'password'=>Hash::make('my-google'),
                    'social_id'=>$user->id,
                    'social_type'=>'google',
                    'created_at'=>$user

                    
                ]);

                Auth::login($newUser);
                return redirect('/');
            }
            
        } catch (Exception $e){
            dd($e->getMessage());
         }
    }
    public function handleFacebookCallback(){
        try{
            $user= Socialite::driver('facebook')->user();
            $finduser = User::where('social_id', $user->id)->first();
            if($finduser){
                Auth::login($finduser);
                return response()->json($finduser);

            }
            else{
                $newUser = User::create([
                    'name'=>$user->name,
                    'email'=>$user->email,
                    'password'=>Hash::make('my-facebook'),
                    'social_id'=>$user->id,
                    'social_type'=>'facebook',
                    
                ]);

                Auth::login($newUser);
                return redirect('/');
            }
            
         } catch (Exception $e){
            dd($e->getMessage());
         }
    }
}
