<?php
namespace App\Controller;
    
use PDOException;
use App\Core\Router;
use App\Core\Session;
use App\Service\Paginator;
use App\Model\Manager\PostManager;
use App\Model\Manager\UserManager;
use App\Model\Manager\TopicManager;
use App\Core\AbstractController as AC;

class HomeController extends AC
{
    public function __construct(){
        $this->topicManager = new TopicManager();
        $this->postManager = new PostManager();
        $this->userManager = new UserManager();
    }

    public function index(){ 
        $this->authenticationRequired();

        return $this->render("home/home.php", [
            "topics" => $this->topicManager->getAll(),
            "title"  => "Liste des topics"
        ]);
    }

    public function showTopic($topic_id){
        $this->authenticationRequired();

        $topic = $this->topicManager->getOneById($topic_id);
        
        $paginator = new Paginator(
            "?ctrl=home&action=showTopic&id=".$topic_id,
            $topic->getNbPosts()
        );
        $posts = $this->postManager->getAllByTopic($topic_id, $paginator->paginateSQL());

        return $this->render("home/topic.php", [
            "topic"     => $topic,
            "posts"     => $posts,
            "title"     => $topic->getTitle(),
            "paginator" => $paginator
        ]);
    }

    public function newTopic(){
        $this->authenticationRequired();

        if(Router::isMethod("POST")){
            $title = trim(filter_input(INPUT_POST, "title", FILTER_SANITIZE_STRING));
            $firstPost = filter_input(INPUT_POST, "post", FILTER_DEFAULT);

            if($title && $firstPost){
                $topic_id = $this->topicManager->insertTopic($title, Session::get("user")->getId());
                if($topic_id){
                    $this->postManager->insertPost($firstPost, $topic_id, Session::get("user")->getId());
                    Session::addFlash('success', "Sujet créé avec succès !");
                    return $this->redirectToRoute("home", "showTopic", ["id" => $topic_id]);
                }
                else Session::addFlash('error', "Une erreur est survenue...");
            }
            else Session::addFlash('error', "Veuillez vérifier vos saisies !");
        }
        return $this->render("home/new-topic.php", [
            "title" => "Nouveau sujet"
        ]);
    }

    public function addPost($topic_id){
        $this->authenticationRequired();

        if(Router::isMethod("POST") && $topic_id){
            
            $text = filter_input(INPUT_POST, "post", FILTER_DEFAULT);

            if($text){
                $this->postManager->insertPost($text, $topic_id, Session::get("user")->getId());
                Session::addFlash('success', "Message ajouté avec succès !");
            }
            else Session::addFlash('error', "Veuillez vérifier vos saisies !");
        }
        return $this->redirectToRoute("home", "showTopic", [
            "id" => $topic_id,
            "page" => $_GET["page"]
        ]);
    }

    public function members(){
        $this->authenticationRequired("ROLE_ADMIN");

        $paginator = new Paginator(
            "?ctrl=home&action=members",
            $this->userManager->countUsers()
        );

        return $this->render("home/members.php", [
            "users"     => $this->userManager->getList($paginator->paginateSQL()),
            "title"     => "Membres du forum",
            "paginator" => $paginator
        ]);
    }

    public function lock($topic_id){
        $this->authenticationRequired();

        $topic = $this->topicManager->getOneById($topic_id);

        if($topic->isAuthor(Session::get("user")) || Session::get("user")->hasRole("ROLE_ADMIN")){
            $lockAction = $_GET["actualLock"] == 1 ? 0 : 1;
            $this->topicManager->updateLock($lockAction, $topic_id);

            if(Router::isXMLHTTPRequest()){
                return $this->ajaxResponse([
                    'result' => $lockAction
                ]);
            }
            else{
                Session::addFlash("success", "Ce sujet est désormais ".($lockAction ? "verrouillé" : "déverrouillé"));
                $this->redirectToRoute("home", "showTopic", [
                    "id" => $topic_id
                ]);
            }
        }
        else $this->redirectToRoute("home");
    }
}