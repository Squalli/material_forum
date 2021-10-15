<?php
namespace App\Controller;

use App\Core\Router;
use App\Core\Session;
use App\Service\Upload;
use App\Model\Manager\UserManager;
use App\Core\AbstractController as AC;

class SecurityController extends AC
{
    public function __construct(){
        $this->manager = new UserManager();
    }
    /**
     * display the login form or compute the login action with post data
     * 
     * @return mixed the render of the login view or a Router redirect (if login action succeeded)
     */
    public function login(){
        if(Router::isMethod("POST")){
            $usernameOrEmail = filter_input(INPUT_POST, "username-or-email", FILTER_SANITIZE_STRING);
            $password = filter_input(INPUT_POST, "password", FILTER_VALIDATE_REGEXP, [
                "options" => [
                    "regexp" => "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{6,}$/"
                    //au moins 6 caractères, MAJ, min et chiffre obligatoires
                ]
            ]);

            if($usernameOrEmail && $password){
                if($user = $this->manager->getOneByCredentials($usernameOrEmail)){//on récupère l'user si l'email saisi correspond en BDD
                    if(password_verify($password, $this->manager->getPasswordBy($usernameOrEmail))){
                        Session::set("user", $user);
                        Session::addFlash('success', "Bienvenue ".$user->getUsername()." !");
                        
                        return $this->redirectToRoute("home");
                    }
                    else Session::addFlash('error', "Le mot de passe est erroné");
                }
                else Session::addFlash('error', "E-mail inconnu !");
            }
            else Session::addFlash('error', "Tous les champs sont obligatoires et doivent respecter...");

        }

        return $this->render("user/login.php", [
            "title" => "Connexion"
        ]);
    }

    public function logout(){
        $this->authenticationRequired();

        Session::remove("user");
        Session::addFlash('success', "Déconnexion réussie, à bientôt !");
        return $this->redirectToRoute("home");
    }

    public function register(){
        if(Router::isMethod("POST")){
            $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING);
            $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
            $password = filter_input(INPUT_POST, "password", FILTER_VALIDATE_REGEXP, [
                "options" => [
                    "regexp" => "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{6,}$/"
                    //au moins 6 caractères, MAJ, min et chiffre obligatoires
                ]
            ]);
            $password_repeat = filter_input(INPUT_POST, "password_repeat", FILTER_DEFAULT);
            
            if($username && $email && $password){
                if(!$this->manager->getOneByCredentials($username, $email)){
                    if($password === $password_repeat){
                        $path = getenv("IMG_PATH")."/avatars/";
                        $filename = "avatar-".uniqid()."-".md5($username);
                        $avatar = Upload::uploadFile("avatar", $filename , $path);
                        $hash = password_hash($password, PASSWORD_ARGON2I);

                        if($this->manager->insertUser($username, $email, $hash, $avatar)){
                            Session::addFlash('success', "Inscription réussie, connectez-vous !");
                            
                            return $this->redirectToRoute("security", "login");
                        }
                        else Session::addFlash('error', "Une erreur est survenue...");
                    }
                    else{
                        Session::addFlash('error', "Les mots de passe ne correspondent pas !");
                        Session::addFlash('notice', "Tapez les mêmes mots de passe dans les deux champs !");
                    }
                }
                else Session::addFlash('error', "Cette adresse mail est déjà liée à un compte...");
            }
            else Session::addFlash('notice', "Les champs saisis ne respectent pas les valeurs attendues !");
        }

        return $this->render("user/register.php", [
            "title" => "Inscription"
        ]);
    }

    public function profile($id){
        $this->authenticationRequired();

        $user = $this->manager->getOneById($id);
        
        return $this->render("user/profile.php", [
            "user"  => $user,
            "title" => $user->getUsername()
        ]);
    }
}