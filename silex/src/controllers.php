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


$app->match('/form', function (Request $request) use($app)
{
    $dbConnection = $app['db'];
    
    if($request->isMethod('GET')){
        return $app['templating']->render('form.html.php', array("error" => false,
                                                                    "dbConnection" => $dbConnection
        ));
    }
    elseif($request->isMethod('POST')){
        $title = $request->get('title');
        $text = $request->get('text');
        if($title == ""){
            return $app['templating']->render('form.html.php', array("error"  => true));
        }   
        elseif ($text == ""){
            return $app['templating']->render('form.html.php', array("error"  => true));
        }
        else {
            $dbConnection->insert(
                'blog_post',
                array(
                    'title' => $title,
                    'text' => $text,
                    'created_at' => date('y-m-d')
                )
            
            );
            return $app['templating']->render('success.html.php', array());
        }
    
    }
});