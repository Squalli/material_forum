
<form class="contained" action="?ctrl=security&action=login" method="post">
    <p>
        <label for="uore">Pseudonyme ou e-mail</label>
        <input type="text" name="username-or-email" id="uore" required>
    </p>
    <p>
        <label for="pass">Mot de passe</label>
        <input type="password" name="password" id="pass" required>
    </p>
    <p>
        <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
        <button class="btn" type="submit" name="submit">Valider</button>
    </p>
</form>
  

