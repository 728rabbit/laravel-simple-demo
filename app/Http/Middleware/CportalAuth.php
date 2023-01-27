<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Validator;

class CportalAuth {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    
    public function handle($request, Closure $next) {
        $post_data = $request->input();
        
        $validator = Validator::make($post_data, [
            'user_name' => 'required',
            'user_password' => 'required|min:6'
        ]);
        
        if($validator->fails()) {
            return redirect()->back()->with([
                'error_message' => __('cportal.message_login_empty'),
                'user_name' => $post_data['user_name'], 
                'user_password' => $post_data['user_password']
            ]); 
        }
        
        if($post_data['user_name'] != 'admin' || $post_data['user_password'] != '@abc123') {
            return redirect()->back()->with([
                'error_message' => __('cportal.message_login_fail'),
                'user_name' => $post_data['user_name'], 
                'user_password' => $post_data['user_password']
            ]); 
        }

        return $next($request);
    }
}