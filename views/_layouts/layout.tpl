<!DOCTYPE html>
<html dir="ltr">
    <head>
        <meta charset="utf-8" />
        <title>Fruitiers {if isset($page_titre) && !empty($page_titre)}- {$page_titre}{/if}</title>

        <link href="/public/assets/plugins/fontawesome/fontawesome-6.0.0.min.css" rel="stylesheet" type="text/css">

        {block name=css}{/block}

    </head>
    <body>

    <!-- CONTENT -->
    {block name=content}{/block}
    <!-- / -->

    <script type="text/javascript" src="/public/assets/plugins/tailwindcss/tailwindcss-3.0.18.min.js"></script>

    {block name=js}{/block}

    </body>
</html>