<?php
require_once('vendor/autoload.php');

use Dotenv\Dotenv;
use App\Core\Router;
use App\Core\Session;

$dotenv = Dotenv::createUnsafeImmutable(__DIR__);
$dotenv->load();

session_start();

//on fait générer une clé propre à la session (si c'est pas déjà fait)
$key = Session::generateKey();
//on génère le jeton CSRF pour CETTE REQUETE HTTP SEULEMENT
$csrf_token = hash_hmac("sha256", getenv("SECRET"), $key);

//si la protection présente dans Router renvoie true
if(Router::CSRFProtection($csrf_token)){
    //on laisse le routeur solliciter le contrôleur 
    //(aka : continuer la prise en charge de la requête comme normalement)
    $response = Router::handleRequest($_GET);
}//sinon, on redirige vers l'accueil
else{
    Session::eraseKey();
    Session::addFlash("error", "Invalid CSRF Token !!");
    Router::redirect([
        "ctrl"   => "home", 
    ]);
}

$title = null;
if(isset($response["data"]["title"])){
    $title = $response["data"]["title"];
    unset($response["data"]["title"]);
}

$data = isset($response["data"]) ? $response["data"] : null;

ob_start();

include $response['view'];
$page = ob_get_contents();

ob_end_clean();

include "view/layout.php";