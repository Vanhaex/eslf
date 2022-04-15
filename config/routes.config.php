<?php

// C'est ici que l'on déclare les routes vers les controllers ainsi que les méthodes
// Exemple : $router->get('/bonjour', "MonControlleur", "MaMéthode");
$router->get('/', 'HomeController', 'index');
$router->get('/bzip', 'HomeController', 'bzipbzip');
$router->get('/test/:id', 'HomeController', 'test');
$router->get('/testalerte', 'HomeController', 'testalerte');

?>
