<?php
namespace App\Core;

abstract class Router 
{

    public static function CSRFProtection($token){
        if(!empty($_POST)){
            if(isset($_POST['csrf_token'])){
                $form_csrf = $_POST['csrf_token'];
                if(hash_equals($form_csrf, $token)){
                    return true;
                }
            }
            return false;
        }
        return true;
    }

    public static function handleRequest($uri){
        $ctrlname = ucfirst(getenv("DEFAULT_CONTROLLER"))."Controller";//par défaut !!
        
        $method = "index";

        //$params = explode("/", $uri);
        $params = [$_GET["ctrl"], $_GET["action"], isset($_GET["id"]) ? $_GET["id"] : null];
        if(isset($params[0])){
            $urlCtrl = $params[0];

            if(class_exists("App\\Controller\\".ucfirst($urlCtrl)."Controller")){
                $ctrlname = ucfirst($urlCtrl)."Controller";
            }
        }
        
        //eh oui, on peut mettre le nom de la classe à instancier dans une variable et faire new avec !!
        $ctrlname = "App\\Controller\\".$ctrlname;
        $ctrl = new $ctrlname();

        if(isset($params[1]) && method_exists($ctrl, $params[1])){
            $method = $params[1];
        }

        if(isset($params[2])){
            $id = $params[2];
        }
        else $id = null;
        
        return $ctrl->$method($id);
    }

    /**
     * 
     */
    public static function redirect($params){

        $route = "Location:";

        if(is_array($params)){
            $route.= $params['ctrl'];
            $route.= $params['method'] ? "/".$params['method'] : "";
            if(!empty($params['param'])){
                foreach($params['param'] as $param => $value){
                    if($param == "id"){
                        $route.= "/".$value;
                    }
                    else $route.= "?".$param."=".$value;
                }
            }
        }
        else $route.= $params;

        header($route);
        die;
    }

    public static function isMethod($method){
        return strtoupper($method) == $_SERVER['REQUEST_METHOD'];
    }

    public static function isXMLHTTPRequest(){
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            return true;
        }
        else return false;
    }
}

