<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>服务器错误，请刷新重试</title>
        <style type="text/css">
        * {margin:0;padding:0;}
        a {color:#42a8e1;font-family:'Microsoft yahei'}
        #doc {width:474px;margin:60px auto;}
        #cont {position:relative;width:474px;height:252px;margin-bottom:25px;background:url(http://<?php echo DOMAIN_STATIC;?>/css/video/images/error_500.png) no-repeat;}        
        #refresh {position:absolute;top:90px;left:108px;font-size:22px;}
        </style>
    </head>
    <body>
        <div id="doc">
            <div id="cont">
                <a id="refresh" href="?" onclick="window.location.reload();return false;">刷新试试</a>
            </div>
        </div>
    </body>
</html>