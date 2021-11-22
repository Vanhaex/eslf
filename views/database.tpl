<!DOCTYPE html>
<html dir="ltr">
  <head>
    <title>RÉSULTAT ddb !</title>
  </head>
  <body>
    {foreach $resultat as $res}
      <p>Le id : {$res->id}</p>
      <p>Le résultat : {$res->name}</p>
    {/foreach}
  </body>
</html>
