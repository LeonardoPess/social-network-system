<div class="box__content">
    
    <h2><i class="far fa-comments"></i> Chat Online</h2>

    <div class="box__chat__online">
      
    <?php
      $mensagens = MySql::conectar()->prepare("SELECT * FROM `tb_admin.chat` ORDER BY `id` DESC LIMIT 10");
      $mensagens->execute();
      $mensagens = $mensagens->fetchAll();
      $mensagens = array_reverse($mensagens);
      foreach($mensagens as $key => $value){ 
      $nomeUsuario = MySql::conectar()->prepare("SELECT `nome`,`color_user` FROM `tb_admin.usuarios` WHERE id = $value[user_id]");
      $nomeUsuario->execute();
      $nomeUsuario = $nomeUsuario->fetch();
      $lastId = $value['id'];
    ?>
      <div class="box__chat_wraper">
        <div style="background-color: <?= $nomeUsuario['color_user'] ?>;" class="image__user">
        <?php if($value['img_user'] != ''){ ?>
          <img src="<?= INCLUDE_PATH_PAINEL ?>uploads/<?= $value['img_user'] ?>">
        <?php }else{ ?>
          <i class="fas fa-user"></i>
        <?php } ?>
        </div><!--image__user-->

        <div style="background-color: <?= $nomeUsuario['color_user'] ?>;" class="mensagem__chat">
          <span><?= $nomeUsuario['nome'] ?> <b><?= $value['hora'] ?></b></span>
          <p><?= $value['mensagem'] ?></p>
        </div><!--mensagem__chat-->
      </div><!--box__chat_wraper-->
      <br>

    <?php $_SESSION['lastIdChat'] = $lastId; } ?>

    </div><!--box__chat__online-->

    <div class="form__chat__online">
      <form method="post" action="<?= INCLUDE_PATH_PAINEL ?>ajax/chat.php">
        <textarea name="mensagem"></textarea>
        <input type="submit" name="acao" value="Enviar!">
      </form>
    </div><!--form__chat__online-->

</div><!--box__content-->