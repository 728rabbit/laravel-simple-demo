<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\PageController;

class HomeController extends PageController
{
    
    public function main() {
        dump($this->_mydata);
        echo '<h1>Hello, '.$this->_mydata['extra_parameters']['name'].'</h1>';
    }
}
