<?php
    use App\Core\Session;
?>

<section id="messages">
<?php 
    if($successMsgs = Session::getFlashes("success")){
        ?>
        
        <div class="msg-success">
            
            <?php
                foreach($successMsgs as $msg){
                    echo "<span>",$msg,"</span>";
                }
            ?>
        </div>
    
        <?php
    }
    if($errorMsgs = Session::getFlashes("error")){
        ?>
        
        <div class="msg-error">
            
            <?php
                foreach($errorMsgs as $msg){
                    echo "<span>", $msg ,"</span>";
                }
            ?>
        </div>
        
        <?php
    }
?>
</section>
<script>
    let msgBox = document.querySelector("#messages")
    
    if(msgBox.childNodes.length > 1){
        msgBox.classList.add("display")
    }
</script>