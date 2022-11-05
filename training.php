<?php
$error = null;
$succes = false;
require_once 'class/message.php';
require_once 'class/GuestBook.php';
    if (isset($_POST['username'],$_POST['message']))
    {
        $message = new Message($_POST['username'],$_POST['message']);
        if($message->isValid())
        {
            $book = new GuestBook(__DIR__.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'messages');
            $book->addMessage($message);
            $succes = true;
            $messages = $book->getMessage();
            $_POST = [];
        }
        else{
            $error = $message->getErrors(); 
        }
    }
    
    
    $title = "Livre d'or";
    require 'element/header.php';
?>

<div class="container">
    <h1>Livre d'or</h1>

    <?php if(!empty($error)): ?>
        <div class="alert alert-danger">
            Le formulaire est invalide
        </div>
    <?php endif?>
    <?php if($succes): ?>
        <div class="alert alert-success">
            Merci beaucoup pour votre message!
        </div>
    <?php endif?>


    <form action="" method = "post"  >
        <div class="form-group">
            <input value="<?= htmlentities($_POST['username'] ?? '')?>" type="text" name="username" placeholder="votre pseudo" class="form-control <?= isset($error['username']) ? 'is-invalid': ''?>"> 
            <?php if(isset($error['username'])): ?>
                <div class="invalid-feedback">
                    <?= $error['username'] ?>
                </div>
            <?php endif?> 
        </div>
        
        <br>
        <div class="form-group">
            <textarea name="message" placeholder="votre message" class = "form-control <?= isset($error['message']) ? 'is-invalid': ''?>" ><?= htmlentities($_POST['message'] ?? '')?></textarea>
            <?php if(isset($error['message'])): ?>
                <div class="invalid-feedback">
                    <?= $error['message'] ?>
                </div>
            <?php endif?>   
        </div>
        
        <br>
        <button class="btn btn-primary">Envoyer</button>
    </form>

    <?php if(!empty($messages)): ?>
        <h1 class='mt-4'>Vos messages</h1>

    <?php foreach($messages  as $message): ?>
        <?= $message->toHTML()?>
    <?php endforeach ?>

    <?php endif ?>
</div
 
<?php
    require 'element/footer.php';

?>