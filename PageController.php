<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PageController extends Controller {
    
    protected $_mydata = [];

    public function __construct($data = []) {
        $this->_mydata = $data;
    }
}
