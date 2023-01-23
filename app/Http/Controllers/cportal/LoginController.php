<?php

namespace App\Http\Controllers\cportal;

use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Validator;

class LoginController extends PageController {
    
    public function main() {
        // clear auth token
        request()->session()->forget('_cportal_auth_token');
        
        return $this->renderView('login');
    }
    
    public function auth(){
        // get post data & do checking
        $post_data = $this->_my_data['extra_parameters'];
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
        
        // save login auth token
        request()->session()->put('_cportal_auth_token', md5(uniqid()));
        
        // go to cportal home page
        return redirect(url('cportal/home'));
    }
}
