<?php
use Symfony\Component\HttpFoundation\Request;

$app->get('/home/', function () use($app)
{
    return $app['templating']->render('home.html.php', array());
});


$app->match('/form/', function (Request $request) use($app)
{
    $user_session = $app['session']->get('user');
    $username = $user_session["username"];
    $dbConnection = $app['db'];
    
    if($request->isMethod('GET')){
        return $app['templating']->render('form.html.php', array("error" => false, "username" => $username));
    }
    elseif($request->isMethod('POST')){
        $title = $request->get('title');
        $text = $request->get('text');
        if($title == ""){
            return $app['templating']->render('form.html.php', array("error"  => true, "username" => $username));
        }   
        elseif ($text == ""){
            return $app['templating']->render('form.html.php', array("error"  => true, "username" => $username));
        }
        elseif (null == $user_session){
            return $app['templating']->render('form.html.php', array("error"  => true, "username" => ""));
        }
        else {
            $dbConnection->insert(
                'blog_post',
                array(
                    'title' => $title,
                    'text' => $text,
                    'created_at' => date('y-m-d'),
                    'author' => $username
                )
            
            );
            return $app['templating']->render('success.html.php', array());
        }
    
    }
});

$app->match('/blogpost/', function (Request $request) use($app) {
    $dbConnection = $app['db'];
    
    
    $posts = $dbConnection->fetchAll('SELECT * FROM blog_post');
    return $app['templating']->render('blog.html.php', array('posts' => $posts));
        
});

$app->match('/blogposts/post/{id}', function ($id) use ($app){
    $dbConnection = $app['db'];
    
    $post = $dbConnection->fetchAssoc("SELECT * FROM blog_post WHERE id = $id", array(1));
    
    return $app['templating']->render('overview.html.php', array('post' => $post));
    
    
});

$app->match('blogpost/delete/{id}', function($id) use($app){
    $dbConnection = $app['db'];
    
    $user_session = $app['session']->get('user');
    $username = $user_session["username"];
    
    $post = $dbConnection->fetchAssoc("SELECT * FROM blog_post WHERE id = $id", array(1));
    if (null != $user_session) {
        if ($username == $post["author"]) {
            $dbConnection->delete('blog_post', array('id' => $id));
        };
    }
    
    $posts = $dbConnection->fetchAll('SELECT * FROM blog_post');
    return $app['templating']->render('blog.html.php', array('posts' => $posts));
    
    
});

$app->match('/login/', function (Request $request) use($app)
{
    $user_session = $app['session']->get('user');
    if (null == $user_session) {
        $username = "";
    }
    else {
        $username = $user_session["username"];
        
    }
    if ($request->isMethod('GET')) {
        return $app['templating']->render('login.html.php', array("error" => false, "username" => $username));
    }
    elseif ($request->isMethod('POST')){
        $dbConnection = $app['db'];
        
        $user = $request->get('user');
        $password = $request->get('password');
        
        
        if($user == ""){
            return $app['templating']->render('login.html.php', array("error"  => true, "username" => $username));
        }
        elseif ($password == ""){
            return $app['templating']->render('login.html.php', array("error"  => true, "username" => $username));
        }
        else {
            $user_pwd = $dbConnection->fetchAssoc("SELECT * FROM user WHERE user = '$user'", array(1));
            if ($password == $user_pwd["pwd"]) {
                $app['session']->set('user', array('username' => $user));
                return $app['templating']->render('login.html.php', array("error" => false, "username" => $user));
            }            
        }
        
        
            
    }
});


$app->match('/register/', function (Request $request) use($app)
{
    $dbConnection = $app['db'];

    if($request->isMethod('GET')){
        return $app['templating']->render('register.html.php', array("error"  => false));
    }
    elseif($request->isMethod('POST')){
        $user = $request->get('user');
        $password1 = $request->get('password1');
        $password2 = $request->get('password2');
        
        $existing_users = $dbConnection->fetchAll('SELECT * FROM user');
        foreach ($existing_users as $value) {
            if ($value["user"] == $user ) {
                return $app['templating']->render('register.html.php', array("error"  => true));
            }
        }
        
        if($user == ""){
            return $app['templating']->render('register.html.php', array("error"  => true));
        }
        elseif ($password1 == ""){
            return $app['templating']->render('register.html.php', array("error"  => true));
        }
        elseif ($password2 == ""){
            return $app['templating']->render('register.html.php', array("error"  => true));
        }
        elseif ($password1 != $password2){
            return $app['templating']->render('register.html.php', array("error"  => true));
        }
        else {
            $dbConnection->insert(
                'user',
                array(
                    'user' => $user,
                    'pwd' => $password1
                )

            );
            $app['session']->set('user', array('username' => $user));
            return $app['templating']->render('login.html.php', array("error" => false, "username" => $user));
        }

    }
});





























