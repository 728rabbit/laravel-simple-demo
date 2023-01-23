<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\PageController;

class HomeController extends PageController
{
    
    public function main() {
        $this->setMeta([
            'title' => 'Home',
            'description' => 'Hello world!!!'
        ]);
        return $this->renderView('home');
    }
}
