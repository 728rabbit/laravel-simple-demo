Url Format
---------------------------------------------------------------------------

1. cportal (backend):
http://{domain_name}/cportal/{class_name}/{function_name}/{parameter1}/{parameter2}/.../?t=xxx

2. website within multi language(frontend):
http://{domain_name}/{language_code}/{class_name}/{function_name}/{parameter1}/{parameter2}/.../?t=xxx

or

3. website within single language(frontend):
http://{domain_name}/{class_name}/{function_name}/{parameter1}/{parameter2}/.../?t=xxx

---------------------------------------------------------------------------


Step1: edit "/Applications/XAMPP/htdocs/laravel9/routes/web.php"

Step2: create new controller "/Applications/XAMPP/htdocs/laravel9/app/Http/Controllers/ModuleController.php"

Step3: create new controller "/Applications/XAMPP/htdocs/laravel9/app/Http/Controllers/PageController.php"

Step3: create new controller "/Applications/XAMPP/htdocs/laravel9/app/Http/Controllers/Web/HomeController.php"
