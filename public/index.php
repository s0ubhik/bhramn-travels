<?php require_once("../lib/inc.php");

function index($req){
    $req->send(file_get_contents("../templates/index.html"));
}

function feedback($req){
    global $mongo;

    $feedbcks = $mongo->travel->feedbacks;

    foreach (['name', 'email', 'feedback'] as $key) 
        $feedbck[$key] = $req->req($key);
    
    $feedbcks->insertOne($feedbck);

    $req->success(["message" => "Thanks for the feedback :)"]);
}

$routes['/'] = ['index'];
$routes['/feedback'] = ['feedback'];

route($routes);
?>
