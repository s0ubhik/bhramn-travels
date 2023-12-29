<?php require_once("../lib/inc.php");

function index($req){
    $req->send(file_get_contents("../templates/index.html"));
}

function feedback($req){
    $feedbck = R::dispense('feedbacks');

    foreach (['name', 'email', 'feedback'] as $key) {
        $feedbck->{$key} = $req->req($key);
    }
    
    R::store($feedbck);
    $req->success(["message" => "Thanks for the feedback :)"]);

}

$routes['/'] = ['index'];
$routes['/feedback'] = ['feedback'];

route($routes);
?>