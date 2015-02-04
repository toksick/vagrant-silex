<?php
use Symfony\Component\HttpFoundation\Request;

$app->get('/welcome/{name}', function ($name) use($app)
{
    return $app['templating']->render('hello.html.php', array(
        'name' => $name
    ));
});

$app->get('/welcome-twig/{name}', function ($name) use($app)
{
    return $app['twig']->render('hello.html.twig', array(
        'name' => $name
    ));
});

$app->get('/home/', function () use($app)
{
    return $app['templating']->render('home.html.php', array());
});

$app->get('/hello/', function () use($app)
{
    return $app['templating']->render('hello.html.php', array());
});