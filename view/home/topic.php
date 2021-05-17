<?php
use App\Core\Session;

$topic = $data['topic'];
$posts = $data['posts'];
$paginator = $data['paginator'];

?>

<div class="page-infos">
    <?= $paginator->getHTML() ?>
</div>
<?php
    if(Session::get("user") && ($topic->isAuthor(Session::get("user")) || Session::get("user")->hasRole("ROLE_ADMIN"))){
    ?>
    <div id="floating-actions">
        <a class="btn lockLink"
            data-lock="<?= $topic->getLocked() ?>"  
            href="?ctrl=home&action=lock&id=<?= $topic->getId() ?>&actualLock=<?= $topic->getLocked() ?>">
            <i class='fas <?= $topic->getLocked() ? 'fa-lock' : 'fa-lock-open' ?>'></i>
        </a>
    </div>
    <?php
    }

    foreach($posts as $index => $post){
        $author = $post->getUser() ?? null;
        ?>
        <article class="post" <?= $index == count($posts)-1 ? 'id="last-post"' : '' ?>>
            <div class="post-author">
                <div class="post-author-info">
                    <div class="author-avatar">
                        <img src="<?= getenv('IMG_PATH') ?>/avatars/<?= ($author && $author->getAvatar()) ? $author->getAvatar() : "no-avatar.jpg" ?>">
                        <br>
                    </div> 
                    <div class="author-name">
                        <?php 
                        if($author){
                            ?>
                            <a href="?ctrl=security&action=profile&id=<?= $author->getId() ?>">
                                <?= $author ?>
                            </a>
                            <?php
                        } 
                        else echo "Utilisateur supprimé";
                        ?>
                        <br>
                        <span class="post-created-at"><?= $post->getCreated_at("d/m/Y H:i:s") ?></span>
                    </div>
                </div>
                <?php 
                    if($author){ 
                        ?>
                        <div class="user-status">
                            <span class="user-grade"><?= $author->getGrade() ?></span>
                            <span class="user-score"><?= $author->getScore() ?></span> 
                        </div>
                        <?php 
                    } 
                ?>
            </div>
            
         
            <div class="post-content">
                <?= $post->getText() ?>
            </div>
        </article>
        <?php
    }

    if($paginator->isLastPage()){
        ?>
        <article class="post post-answer">
        <?php
            if(Session::get("user")){
                ?>
                <div class="post-author">
                    <i class="fas fa-pencil-alt fa-5x answer-icon"></i>
                </div>
                <div class="post-content">
                    <?php
                        $page = getenv("PER_PAGE") == count($posts) ? $paginator->getPage()+1 : $paginator->getPage();
                    ?>
                    <form 
                        method="post" 
                        action="?ctrl=home&action=addPost&id=<?= $topic->getId() ?>&page=<?= $page ?>#last-post">
                        <div>
                            <label for="post">Votre réponse</label>
                            <textarea class="tinymce-textarea" name="post" id="post"></textarea>
                        </div>
                        <p>
                            <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                            <button class="btn" type="submit" name="submit">répondre</button>
                        </p>
                    </form>
                </div>
                <?php
            }
            else{
                ?>
                <div class="post-content msg-info text-center">
                    <p>Vous devez être authentifié pour répondre.</p>
                    <p>
                        <a href="?ctrl=security&action=login">Connexion</a> - 
                        <a href="?ctrl=security&action=register">Inscription</a>
                    </p>
                </div>
                <?php
            }
        ?>
        </article>
    <?php
    }
?>

<div class="page-infos">
    <?= $paginator->getHTML() ?>
</div>