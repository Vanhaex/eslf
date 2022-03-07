<!DOCTYPE html>
<html dir="ltr">
<head>
    <title>RÉSULTAT ddb !</title>
</head>
<body>
<form action="/testpost" method="post">
    <input type="hidden" name="csrf_token" value="{$csrf_token}" >
    <label for="name">Entrez un nom : </label>
    <input type="text" name="nom">
</form>

le nom est : {if isset($afficher_nom)}{$afficher_nom}{/if}
</body>
</html>
