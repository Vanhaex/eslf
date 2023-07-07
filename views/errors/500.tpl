<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>500 Error</title>
    <link href="/public/assets/css/style.css" rel="stylesheet" type="text/css" >
  </head>
  <body style="text-align:center;" >
    <h3>500 Error - Internal server error</h3>
    <h5>The server encountered an error and cannot respond to the request</h5>
    {if isset($detail_exception)}
      <pre>
        {$detail_exception}
      </pre>
    {/if}
    <a href="/">Go back to home</a>
  </body>
</html>
