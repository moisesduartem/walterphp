<?php
/**
 * O arquivo é executado aqui.
 */
require __DIR__ . '/Walter.php';

$view = new Walter('views/');

$year = date('Y');

$view->render('home', [
    'name' => 'Moisés', 
    'movie' => 'Harry Potter', 
    'fullName' => 'Moisés Mariano Duarte Maia',
    'year' => $year
]);

?>