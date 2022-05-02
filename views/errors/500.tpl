<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Erreur 500</title>
    <link href="/public/assets/style.css" rel="stylesheet" type="text/css" >
  </head>
  <body style="text-align:center;" >
    <h3>Erreur 500 - Erreur interne</h3>
    <h5>Le serveur a rencontré une erreur et ne peut répondre à la requête</h5>
    {if isset($detail_exception)}
      <pre>
        {$detail_exception}
      </pre>
    {/if}
    <a href="/">Revenir à l'accueil</a>
  </body>
</html>
