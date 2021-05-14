<form class="contained" action="?ctrl=home&action=newTopic" method="post">
    <p>
        <label for="title">Titre</label> 
        <input type="text" name="title" id="title">
    </p>
    <p>
        <label for="firstpost">Premier message</label> 
        <textarea class="tinymce-textarea" name="firstpost" id="firstpost"></textarea>
    </p>
    <p>
        <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
        <button class="btn" type="submit" name="submit">Valider</button>
    </p>
</form>