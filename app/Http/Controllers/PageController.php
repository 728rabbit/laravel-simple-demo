<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\View;

class PageController extends Controller {
    
    protected $_my_data = [];
    protected $_meta_data = [];
    protected $_css_files = [];
    protected $_js_files = [];

    public function __construct($data) {
        $this->_my_data = $data;
       
        // set display language
        app()->setLocale((strtolower($this->_my_data['module']) == 'web')?$this->_my_data['web_language']:$this->_my_data['cportal_language']);

        // set default meta
        $this->_meta_data['title'] = 'Larave 9 Demo';
        $this->_meta_data['custom_title'] = '';
        $this->_meta_data['description'] = '';
        $this->_meta_data['url'] = '#';
    }
    
    protected function hasPrivilege ($do_redirect = false) {
        $check_auth_token = request()->session()->get('_'.$this->_my_data['module'].'_auth_token');
        if(!empty($check_auth_token) && $check_auth_token != null) {
            return true;
        }
        if($do_redirect) {
            redirect(url($this->_my_data['module'].'/login'))->send();
            exit();
        }
        return false;
    }


    protected function toPlainText($value = '', $no_space = false) {
        // First remove the leading/trailing whitespace
        $value = strip_tags(trim(str_replace('&nbsp;', ' ', $value)));
        // Now remove any doubled-up whitespace
        $value = preg_replace('/\s(?=\s)/', '', $value);
        // Finally, replace any non-space whitespace, with a space
        $value = preg_replace('/[\n\r\t]/', ' ', $value);
        // Echo out: 'This line contains liberal use of whitespace.'
        if($no_space) {
            $value = preg_replace('/\s+/', '', $value);
        }
        return trim($value);
    }

    protected function setMeta($data = []) {
        $this->_meta_data['title'] = (!empty($data['title']))?($this->_meta_data['title'].' | '.$this->toPlainText($data['title'])):$this->_meta_data['title'];
        $this->_meta_data['custom_title'] = (!empty($data['custom_title']))?$this->toPlainText($data['custom_title']):'';
        $this->_meta_data['description'] = (!empty($data['description']))?$this->toPlainText($data['description']):'';
        $this->_meta_data['url'] = (!empty($data['url']))?$this->toPlainText($data['url']):Request::fullUrl();
    }
    
    protected function setCss($path = '') {
        if(!empty($path)) {
            $this->_css_files[] = $path;
        }
    }
    
    protected function setJs($path = '') {
        if(!empty($path)) {
            $this->_js_files[] = $path;
        }
    }

    protected function renderView($view_name = '', $extra_data = []) {
        $view_name = strtolower(trim($view_name));
        if(!empty($view_name) && View::exists(strtolower($this->_my_data['module']).'.'.$view_name)) {
            // try to load default css & js file
            if(file_exists('../resources/css/'.strtolower($this->_my_data['module']).'/common.css')) {
                $this->_css_files[] = '../resources/css/'.strtolower($this->_my_data['module']).'/common.css';
            }
            if(file_exists('../resources/css/'.strtolower($this->_my_data['module']).'/'.strtolower($this->_my_data['class']).'.css')) {
                $this->_css_files[] = '../resources/css/'.strtolower($this->_my_data['module']).'/'.strtolower($this->_my_data['class']).'.css';
            }
            if(file_exists('../resources/js/'.strtolower($this->_my_data['module']).'/'.strtolower($this->_my_data['class']).'.js')) {
                $this->_js_files[] = '../resources/js/'.strtolower($this->_my_data['module']).'/'.strtolower($this->_my_data['class']).'.js';
            }
            
            // output view
            return View::make($this->_my_data['module'].'.'.$view_name, [
                'my_data' => $this->_my_data,
                'extra_data' => $extra_data,
                'meta_data' => $this->_meta_data,
                'css_files' => $this->_css_files,
                'js_files' => $this->_js_files,
            ]);
        }
        return abort(404);
    }
}
