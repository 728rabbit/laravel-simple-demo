<?php

namespace App\Http\Controllers\Cportal;

use App\Http\Controllers\PageController;

class LoginController extends PageController {
    
    public function __construct($data) {
        parent::__construct($data);
    }
    
    public function main() {
        // clear auth token
        request()->session()->forget('_cportal_auth_token');
        
        return $this->renderView('login');
    }
    
    public function auth(){
        // get post data & do checking
        $post_data = $this->_my_data['extra_parameters'];
        
        // save login auth token
        request()->session()->put('_cportal_auth_token', md5(uniqid()));
        
        // go to cportal home page
        return redirect(url('cportal/home'));
    }
}
