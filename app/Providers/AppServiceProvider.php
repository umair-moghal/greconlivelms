<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        
            view()->composer('layouts.sidebar', function($view) {
            $user = auth()->user()->id;
            $assigned_permissions =array();
            //  if( auth()->user()->role_id == '3'){
               $data = DB::table('module_permissions_users')->where('user_id' , $user)->pluck('allowed_module');
             
             if( auth()->user()->role_id == '3'){
               $data = DB::table('module_permissions_users')->where('user_id' , $user)->pluck('allowed_module');
             }
            if( auth()->user()->role_id == '4'){
                 $data = DB::table('module_permissions_store_instructors')->where('user_id' , $user)->pluck('allowed_module');
            }
            
            
            

            if($data != null){
                 foreach ($data as $value) {
                $assigned_permissions = explode(',',$value);
                 
            }
                // dd($assigned_permissions);
            }
            elseif($data == null){
                $assigned_permissions = [' ',' '];
            }

                $view->with('data', $assigned_permissions);

        });
       
       
    }
}
