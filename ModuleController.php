<?php

/* Url Format
---------------------------------------------------------------------------

1. cportal (backend):
http://{domain_name}/cportal/{class_name}/{function_name}/{parameter1}/{parameter2}/.../?t=xxx

2. website within multi language(frontend):
http://{domain_name}/{language_code}/{class_name}/{function_name}/{parameter1}/{parameter2}/.../?t=xxx

or

3. website within single language(frontend):
http://{domain_name}/{class_name}/{function_name}/{parameter1}/{parameter2}/.../?t=xxx

---------------------------------------------------------------------------
*/

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class ModuleController extends Controller {
    
    public function index() {
        // get route information
        $my_route_data = $this->myRouteData();
  
        // redirect to default language while language code is empty
        if(strtolower($my_route_data['module']) == 'web' && 
           $my_route_data['multi_languages'] > 0 && 
           !in_array($my_route_data['path'][0],$my_route_data['multi_languages'])) {
            $redirect_url = [
                $my_route_data['web_language'],
                $my_route_data['class'],
                (($my_route_data['function'] != 'main')?$my_route_data['function']:'')
            ];
            if(!$my_route_data['parameters']) {
                $redirect_url[] = implode('/', $my_route_data['parameters']);
            }
            $redirect_url = implode('/', array_filter($redirect_url));
            // add extra parameters if exist
            if(strtolower($my_route_data['extra_method']) == 'get' && !empty($my_route_data['extra_parameters'])) {
                $extra_url = [];
                foreach ($my_route_data['extra_parameters'] as $extra_key => $extra_value) {
                    if(!empty($extra_value)) {
                        $extra_url[] = $extra_key.'='.$extra_value;
                    }
                }
                $redirect_url.= '?'.implode('&', $extra_url);
            }
            return redirect(url($redirect_url),301);
        }
       
        // call target controller & method within data
        $my_class = 'App\\Http\\Controllers\\'.$my_route_data['module'].'\\'.ucfirst($my_route_data['class']).'Controller';
        if(class_exists($my_class)) {
            return app()->call([
                app()->make($my_class,['data' => $my_route_data]
            ),$my_route_data['function']]);
        }
        return abort(404);  
    }
    
    private function myRouteData($my_path = '') {
        // assign default value if path is empty
        if(empty($my_path)) {
            $my_path = (!empty($my_path))?$my_path: request()->path();
        }
        
        // Define variables & assign default value
        $my_module = 'Web';
        $my_multi_languages = ['en','tc','sc'];
        $my_cportal_language = 'en';
        $my_web_language = (count($my_multi_languages) == 1)?$my_multi_languages[0]:'en';
        $my_class = 'Home';
        $my_function = 'main';
        $my_parameters = [];

        // Convert url string to array format
        $my_path_explode = array_filter(explode('/',trim(strtolower($my_path))));
        // assign default value if path array is empty
        if(empty($my_path_explode)) {
            $my_path_explode = [$my_web_language];
        }
        
        // find target controller & method
        $parameters_index = 2;
        if(trim($my_path_explode[0]) == 'cportal' || ((count($my_multi_languages) > 1) && in_array(trim($my_path_explode[0]),$my_multi_languages))) {
            if(in_array(trim($my_path_explode[0]),$my_multi_languages)){
                $my_web_language = trim($my_path_explode[0]);
            }
            else {
                $my_module = 'CPortal';
            }
            if(!empty($my_path_explode[1])) {
                $my_class = trim($my_path_explode[1]);
            }
            if(!empty($my_path_explode[2])) {
                $my_function = trim($my_path_explode[2]);
            }
            $parameters_index = 3;
        }
        else {
            if(!empty($my_path_explode[0])) {
                $my_class = trim($my_path_explode[0]);
            }
            if(!empty($my_path_explode[1])) {
                $my_function = trim($my_path_explode[1]);
            }
        }

        if(count($my_path_explode) > $parameters_index) {
            foreach ($my_path_explode as $parameter_key => $parameter_value) {
                if($parameter_key >= $parameters_index) {
                    $my_parameters[] = $parameter_value;
                }
            }
        }

        // return result
        return [
            'path' => $my_path_explode,
            'module' => $my_module,
            'multi_languages' => $my_multi_languages,
            'cportal_language' => $my_cportal_language,
            'web_language' => $my_web_language,
            'class' => $my_class, 
            'function' => $my_function, 
            'parameters' => $my_parameters, 
            'extra_method' => request()->method(),
            'extra_parameters' => request()->all()
        ];
    }
}
