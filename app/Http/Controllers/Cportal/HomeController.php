<?php

namespace App\Http\Controllers\Cportal;

use App\Http\Controllers\PageController;

class HomeController extends PageController
{
   
    public function __construct($data) {
        parent::__construct($data);
        $this->hasPrivilege(true);
    }

    public function main() {
        
       echo '<h1 align="center">Welcome to laravel 9 CPortal!!!</h1>';
       
    }
    
    
}
