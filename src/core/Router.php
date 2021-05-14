<?php
namespace App\Core;

abstract class Router 
{
    private static $defaultCtrl = "home";

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

    public static function handleRequest($params){
        $ctrlname = ucfirst(self::$defaultCtrl)."Controller";//par défaut !!
        
        $method = "index";

        if(isset($params['ctrl'])){
            $urlCtrl = $params['ctrl'];

            if(class_exists("App\\Controller\\".ucfirst($urlCtrl)."Controller")){
                $ctrlname = ucfirst($urlCtrl)."Controller";
            }
        }
        
        //eh oui, on peut mettre le nom de la classe à instancier dans une variable et faire new avec !!
        $ctrlname = "App\\Controller\\".$ctrlname;
        $ctrl = new $ctrlname();

        if(isset($params['action']) && method_exists($ctrl, $params['action'])){
            $method = $params['action'];
        }

        if(isset($params['id'])){
            $id = $params['id'];
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
            $route.= "?ctrl=".$params['ctrl'];
            $route.= $params['method'] ? "&action=".$params['method'] : "";
            if(!empty($params['param'])){
                foreach($params['param'] as $param => $value){
                    $route.= "&".$param."=".$value;
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

