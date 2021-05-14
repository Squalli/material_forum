<?php
use App\Core\Session;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.gstatic.com"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" />   
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,400;0,700;1,300&display=swap">

    <link rel="stylesheet" href="<?= CSS_PATH ?>/style.css">
    <title><?= $title ?></title>
    <script src="<?= JS_PATH ?>/sortable.min.js"></script>
    <script src="https://cdn.tiny.cloud/1/zg3mwraazn1b2ezih16je1tc6z7gwp5yd4pod06ae5uai8pa/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '.tinymce-textarea',
            menubar: false,
            toolbar: 'styleselect | undo redo | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent'
        })
    </script>
</head>
<body>
    <div id="wrapper">
        <nav id="menu">
            <ul id="main-menu">
                <li>
                    <a href="?ctrl=home">
                        <i class="far fa-list-alt"></i>
                        <span>forum</span>
                    </a>
                </li>
                <?php
                if(Session::get("user") && Session::get("user")->hasRole("ROLE_ADMIN")){
                    ?>
                    <li>
                        <a href="?ctrl=home&action=members">
                            <i class="fas fa-users"></i>
                            <span>membres</span>
                        </a>
                    </li>
                    <?php
                    }
                ?>
            </ul>
            <ul id="user-menu">
                <?php
                    if(Session::get("user")){
                        ?>
                        <li>
                            <a href="?ctrl=security&action=profile&id=<?= Session::get("user")->getId() ?>">
                                <img src="<?= IMG_PATH ?>/avatars/<?= (Session::get("user")->getAvatar()) ?? "no-avatar.jpg" ?>">
                                <span><?= Session::get("user") ?></span>
                            </a>
                        </li>
                        <li>
                            <a href="?ctrl=security&action=logout">
                                <i class="fas fa-sign-out-alt"></i>
                                <span>logout</span>
                            </a>
                        </li>
                        <?php
                    }
                    else{
                        ?>
                        <li>
                            <a href="?ctrl=security&action=login">
                                <i class="fas fa-sign-in-alt"></i>
                                <span>connexion</span>
                            </a>
                        </li>
                        <li>
                            <a href="?ctrl=security&action=register">
                                <i class="fas fa-user-plus"></i>
                                <span>inscription</span>
                            </a>
                        </li>
                        <?php
                    }
                ?>
            </ul>
        </nav>


        <div id="title-bar">
            <h1><?= $title ?></h1>
            <?php include("messages.php"); ?>
        </div>
        
        <div id="page-wrapper">
            <section id="page-content">
                <?= $page ?> 
            </section>
        </div>

        <footer>
            <p class="text-center">&copy;2021 - Virgile GIBELLO - <a href="#">règlement du forum</a></p>
        </footer>
    </div>
    <script src="<?= JS_PATH ?>/functions.js"></script>
</body>
</html>
    