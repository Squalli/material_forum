<?php
    $user = $data['user']; 
?>

<section id="profile">
    <figure id="profile-avatar">
        <img src="<?= getenv('IMG_PATH') ?>/avatars/<?= ($user->getAvatar()) ?? "no-avatar.jpg" ?>">
        
    </figure>
    <article id="profile-description">
        <?php var_dump($user); ?>
    </article>
</section>

