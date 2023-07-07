<!DOCTYPE html>
<html dir="ltr" lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>ESLF {if isset($page_titre) && !empty($page_titre)}- {$page_titre}{/if}</title>

        <!-- Theme style -->
        <link href="/public/assets/css/custom.min.css" rel="stylesheet" type="text/css" >

        {block name=css}{/block}

    </head>
    <body>

    <!-- CONTENT -->
    {block name=content}{/block}
    <!-- / -->

    {block name=js}{/block}

    </body>
</html>
