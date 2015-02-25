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

$app->match('/blogpost', function (Request $request) use($app) {
    $dbConnection = $app['db'];
    
    
    $posts = $dbConnection->fetchAll('SELECT * FROM blog_post');
    if ($request->isMethod("GET")) {
        return $app['templating']->render('blog.html.php', array('posts' => $posts));
    }
    elseif ($request->isMethod("POST")){
        
        $dbConnection->delete("SELECT * FROM blo");
        return $app['templating']->render("blog.html.php", array("posts" => $posts));
            
    }
    
    
});

$app->match('/blogposts/post/{id}', function ($id) use ($app){
    $dbConnection = $app['db'];
    
    $post = $dbConnection->fetchAssoc("SELECT * FROM blog_post WHERE id = $id", array(1));
    
    return $app['templating']->render('overview.html.php', array('post' => $post));
    
    
});
































