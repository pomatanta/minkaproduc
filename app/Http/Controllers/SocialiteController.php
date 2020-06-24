<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
 use App\User;
use Socialite;

class  SocialiteController extends Controller
{
       private  $availableDrivers = [
       	'facebook','google'
       ];

       public function redirectToProvider($provider)
    {
    	 if(!in_array($provider, $this->availableDrivers))
    	 {
    	 	 return redirect()->route('sesion');
    	 	 
    	 }
        return Socialite::driver($provider)->redirect();
    }


    public function handleProviderCallback($provider)
    {

    	 if(!in_array($provider, $this->availableDrivers))
    	 {
    	 	 return redirect()->route('sesion');
    	 	 
    	 }

        $userSocialite = Socialite::driver($provider)->user();

       if($userSocialite->getEmail()){
        $user = User::where('email',$userSocialite->getEmail())->first();
       } else {
       	$user = User::where($provider . '_id',$userSocialite->getId())->first();
       }

        
        if($user) {
        	  $user->update([
            'name' =>$userSocialite->getName(),
            $provider . '_id' =>$userSocialite->getId(),
            'avatar' =>$userSocialite->getAvatar(),
            'role'=>'USER',     
            'nick' =>$userSocialite->getNickname()  
             
                ]);



        	}else{
          $user = User::create([
            'name' =>$userSocialite->getName(),
            'email' =>$userSocialite->getEmail(),
            'password' =>'',
            'role'=>'USER',     
            $provider . '_id' =>$userSocialite->getId(),
            'avatar' =>$userSocialite->getAvatar(),
            'nick' =>$userSocialite->getNickname()  

        ]);
        }
        auth()->login($user);
       return redirect()->route('inicio');

    }


  

}
