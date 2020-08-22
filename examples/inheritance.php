<?php

require __DIR__ . '/../Walter.php';

$view = new Walter('../views/inheritance/');

$year = date('Y');

$view->render('index', [
    'name' => 'Moisés', 
    'movie' => 'Harry Potter', 
    'fullName' => 'Moisés Mariano Duarte Maia',
    'year' => $year
    ]);

?>