<?php
$users = $data['users'];
$paginator = $data['paginator'];
?>

<div class="page-infos">
    <?= $paginator->getHTML() ?>
</div>

<table class="table" data-sortable>
    <thead>
        <tr>
            <th rowspan=2 colspan=2>Utilisateur</th>
            <th rowspan=2>Grade</th>
            <th rowspan=2 class="text-center">Score</th>
            <th rowspan=2>Date d'inscription</th>
            <th colspan=2 class="text-center top-th">Contributions</th>
        </tr>
        <tr>
            <th class="text-center sub-th">Sujets</th>
            <th class="text-center sub-th">Messages</th>
        </tr>
    </thead>
    <tbody>
    <?php
        foreach($users as $user){
            ?>
            <tr>
                <td data-label="Utilisateur">
                    <div class="author-avatar">
                        <img src="<?= getenv('IMG_PATH') ?>/avatars/<?= ($user->getAvatar()) ?? "no-avatar.jpg" ?>">
                    </div> 
                    <a href="?ctrl=security&action=profile&id=<?= $user->getId() ?>"><?= $user->getUsername() ?></a><br>
                </td>
                <td data-label="Email">
                    <?= $user->getEmail() ?>
                </td>
                <td data-label="Grade">
                    <?= $user->getGrade() ?> 
                </td>
                <td class="text-center" data-label="Score">
                    <span class="user-score"><?= $user->getScore() ?></span>
                </td>
                <td data-label="Date d'inscription"><?= $user->getCreated_at() ?></td>
                <td class="text-center" data-label="Nombre de sujets créés"><?= $user->getNbtopics() ?></td>
                <td class="text-center" data-label="Nombre de réponses postées"><?= $user->getNbposts() ?></td>
            </tr>
            <?php
        }
    ?>
    </tbody>
</table>

<div class="page-infos">
    <?= $paginator->getHTML() ?>
</div>
