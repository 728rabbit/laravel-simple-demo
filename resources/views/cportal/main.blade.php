<!DOCTYPE html>
<html>
    <head>
        <title><?php echo (!empty($meta_data['custom_title']))?$meta_data['custom_title']:$meta_data['title'];?></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta property="og:title" content="<?php echo (!empty($meta_data['custom_title']))?$meta_data['custom_title']:$meta_data['title'];?>"/>
        <meta property="og:description" content="<?php echo $meta_data['description'];?>"/>
        <meta property="og:url" content="<?php echo $meta_data['url'];?>"/>
        <meta property="og:type" content="website"/>
        <link href="{{ asset('../resources/css/iweb.css') }}" rel="stylesheet" type="text/css"/>
        <?php if(!empty($css_files)) { foreach ($css_files as $css) { ?>
        <link href="{{ asset($css) }}" rel="stylesheet" type="text/css"/>
        <?php }} ?>
        <script src="{{ asset('../resources/js/jquery.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('../resources/js/iweb.js') }}" type="text/javascript"></script>
        <?php if(!empty($js_files)) { foreach ($js_files as $js) { ?>
        <script src="{{ asset($js) }}" type="text/javascript"></script>
        <?php }} ?>
    </head>
    <body>
        @if(!in_array($my_data['class'],['login']))
        <header id="header">
           
        </header>
        @endif
        
        <div id="main">
            <div id="{{ strtolower($my_data['class']) }}-wrap">@yield('content')</div>
        </div>
        
        @if(!in_array($my_data['class'],['login']))
        <footer id="footer">
            @copyright 2023
        </footer>
        @endif
        
    </body>
</html>
