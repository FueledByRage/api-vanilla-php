<?php
require_once './routes/router.php';
require_once './providers/database/bd.php';
require_once './routes/urlHandler.php';
require_once './providers/jwt/jwt.php';
$JWTProvider = new JWT();


$router = new Router(new URLHandler);

$router->GET('/user/?username', function($req, $res){
    try{
        $username = array_key_exists('username', $req->params) ? $req->params['username'] : null;
        if($username == null){
            $res->status(406);
            $res->send(['message' => 'Missing credentials']);
        }
        $UserMysql = new UserMysql(getConnection());
        $users = $UserMysql->get($username);
        if($users == null) throw new Exception('User not found', 404);
        $res->send($users);
    }catch(Exception $e){  
        $res->status($e->getCode());
        $res->send(['message' => $e->getMessage()]);
    }
});

$router->GET('/post/?author', function($req, $res){
    try{
        $author = array_key_exists('author', $req->params) ? $req->params['author'] : null;
        if($author == null){
            $res->status(406);
            $res->send(['message' => 'Missing credentials']);
        }
        $PostMysql = new PostMysql(getConnection());
        $data = $PostMysql->getAll($author);
        $res->send($data);
    }catch(Exception $e){
        $res->status($e->getCode());
        $res->send(['message' => $e->getMessage()]);
    }
});

$router->POST('/user/register', function($req, $res){
    try{
        global $JWTProvider;
        $body = $req->body();
        $UserMysql = new UserMysql(getConnection());
        if(!checkKeys($body, ['username', 'email', 'password', 'about'])){
            $res->status(406);
            $res->send(['message' => 'Missing credentials']);
        }
        $user = new User($body['username'], $body['email'], $body['password'], $body['about']);
        $checkUser = $UserMysql->getByEmail($body['email']);
        if($checkUser != null) throw new Exception('User already registered', 401);
        $UserMysql->get($body['username']);
        $UserMysql->save($user);
        $token = $JWTProvider->provider(['typ' => 'JWT', 'alg' => 'HS256'],['username' => $user['username']]);
        $res->send(['token' => $token, 'user' => $user['username']]);
    }catch(Exception $e){
        $res->status($e->getCode());
        $res->send(['message' => $e->getMessage()]);
    }

});

$router->POST('/post/register', function($req, $res){

    try{
        global $JWTProvider;
        $body = $req->body();
        if(!checkKeys($body, ['body', 'token'])) throw new Exception('Missing credentials', 406);    
        $user = $JWTProvider->decript($body['token'])->{'username'};
        $post = new Post($user, $body['body'], date('Y-m-d H:i:s'));
        $PostMysql = new PostMysql(getConnection());
        $PostMysql->save($post);
        die();
    }catch(Exception $e){
        $res->status($e->getCode());
        $res->send(['message' => $e->getMessage()]);
    }

});

$router->POST('/login', function($req, $res){
    try{
        global $JWTProvider;
        $body = $req->body();

        if(!checkKeys($body, ['email', 'password'])){
            $res->status(406);
            $res->send(['message' => 'Missing param.']);
        }
        $UserMysql = new UserMysql(getConnection());
        $user = $UserMysql->getByEmail($body['email']);
        if($user == null) throw new Exception('User not found', 404);
        if($user['pass'] == $body['password']){
            $token = $JWTProvider->provider(['typ' => 'JWT', 'alg' => 'HS256'],['username' => $user['username']]);
            $res->send(['token' => $token,'username' => $user['username']]);
        }
        throw new Exception('Wrong email or password.', 401);
    }catch(Exception $e){
        $res->status($e->getCode());
        $res->send(['message' => $e->getMessage()]);
    }
});

function checkKeys($array, $keys){
    foreach($keys as $key){
        if(!array_key_exists($key, $array)){
            return false;
        }
    }
    return true;
}
