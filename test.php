<?php

// Il faut le fichier Application.php pour utiliser l'utilitaire esbuilder !
$file = "Application.php";
$arguments = null; // Pas d'arguments de base

if (file_exists($file)) {

    array_shift($argv);

    foreach ($argv as $param) {
        $arguments .= " " . $param;
    }

    exec("php " . $file . $arguments, $output);

    echo("\n");
    for ($i=1;$i < count($output);$i++){
        echo $output[$i];
    }
    echo("\n\n");

} else {
    echo "\n";
    echo "Impossible de lancer la commande esbuilder car le fichier " . $file . " semble inexistant";
    echo "\n\n";
}

