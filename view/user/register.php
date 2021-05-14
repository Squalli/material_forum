<form class="contained" action="?ctrl=security&action=register" method="post" enctype="multipart/form-data">
    <p>
        <label for="username">Votre pseudonyme</label>
        <input type="text" name="username" id="username" required>
    </p>
    <p>
        <label for="mail">Votre email</label>
        <input type="email" name="email" id="mail" required>
    </p>
    <p>
        <label for="pass">Votre mot de passe</label>
        <input type="password" name="password" id="pass" required>
    </p>
    <p>
        <label for="passr">Ressaisir votre mot de passe</label>
        <input type="password" name="password_repeat" id="passr" required>
    </p>
    <p>
        <label for="avatar">Votre avatar</label>
        <input type="file" name="avatar" id="avatar">
    </p>
    <p>
        <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
        <button class="btn" type="submit" name="submit">Valider</button>
    </p>
</form>
