<?php
use App\Core\Session;
$topics = $data['topics'];
?>

<div class="page-infos">
    <a class="btn" href="?ctrl=home&action=newTopic">Nouveau sujet</a>
</div>
<?php

    if(empty($topics)){
        ?>
        <h4>Soyez le premier à écrire un sujet ici !</h4>
        <?php
    }
    else{
        ?>
        <table class="table" data-sortable>
            <thead>
                <tr>
                    <th>Titre</th>
                    <th class="text-center">Réponses</th>
                    <th class="text-center">Auteur</th>
                    <th class="text-center">Date</th>
                    <th class="text-center">Etat</th>
                    <th>#</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach($topics as $topic){
                    ?>
                    <tr>
                        <td>
                            <a href="?ctrl=home&action=showTopic&id=<?= $topic->getId() ?>">
                                <?= $topic->getTitle() ?> 
                            </a>
                        </td>
                        <td class="text-center" data-label="Réponses">
                            <?= $topic->getNbposts() ?>
                        </td>
                        <td class="text-center" data-label="Auteur">
                            <?php 
                            if($topic->getUser()){
                                ?>
                                <a href="?ctrl=security&action=profile&id=<?= $topic->getUser()->getId() ?>">
                                    <?= $topic->getUser() ?>
                                </a>
                                <?php
                            } 
                            else echo "Utilisateur supprimé" 
                            ?>
                        </td>
                        <td class="text-center" data-label="Créé le"><?= $topic->getCreated_at("d/m/Y H:i:s") ?></td>
                        <td class="text-center" data-label="Etat"><?= $topic->getLocked() ? "verrouillé" : "ouvert" ?></td>
                        <td class="pos-relative" data-label="Actions">
                            <?php 
                                if(Session::get("user") && ($topic->isAuthor(Session::get("user")) || Session::get("user")->hasRole("ROLE_ADMIN"))){
                                    ?>
                                    <a class="lockLink"     
                                        onclick="handleLockTopic(event, this)"
                                        href="?ctrl=home&action=lock&id=<?= $topic->getId() ?>&actualLock=<?= $topic->getLocked() ?>">
                                        <i class='fas <?= $topic->getLocked() ? 'fa-lock' : 'fa-lock-open' ?>'></i>
                                    </a>
                                    <?php
                                }
                            ?>
                        </td>
                    </tr>
                    <?php
                    }
                ?>
                
            </tbody>
        </table>
        <?php
    }
?>