<!DOCTYPE html>
<html dir="ltr">
    <head>
        <meta charset="utf-8" />
        <link rel="icon" type="image/ico" href="/public/favicon.ico">
        <title>ESLF {if isset($page_titre) && !empty($page_titre)}- {$page_titre}{/if}</title>

        {block name=css}{/block}

    </head>
    <body>

    <!-- CONTENT -->
    {block name=content}{/block}
    <!-- / -->

    {block name=js}{/block}

    </body>
</html>
