<section class="me">
  <div class="container">
    <div class="row-me">
      <section class="perfil-info w30">
        <h2 class="tittle">Bem vindo <?= $_SESSION['nome_membro'] ?></h2>

        <div class="container-img">
          <img src="<?= INCLUDE_PATH_PAINEL ?>uploads/<?= $_SESSION['img_membro'] ?>">
        </div><!--container-img-->

        <div class="lista-amigos">
          <h3><i class="fa fa-users"></i> Minha amizades (<?= count(\models\membrosModel::listarAmigos()) ?>)</h3>

          <div class="img-amigos-wraper">

          <?php
            $amigos = \models\membrosModel::listarAmigos();
            foreach($amigos as $key => $value){
              $membros = \models\membrosModel::getMmembroById($value);
          ?>
            <div style="background-image: url('<?= INCLUDE_PATH_PAINEL.'uploads/'.$membros['imagem']; ?>')" class="img-amigos-single"></div><!--img-amigos-single-->
          <?php } ?>

          </div><!--img-amigos-wraper-->

        </div><!--lista-amigos-->

      </section><!--perfil-info-->

      <section class="feed w70">
        <h2 class="tittle">O que está pensando hoje?</h2>

        <form method="post">
          <textarea name="mensagem" placeholder="Sua mensagem..."></textarea>
          <input type="submit" name="feed_post" value="enviar">
        </form>
        <br>
        <?php 
          $postFeeds = MySql::conectar()->prepare("SELECT * FROM `tb_Site.feed` ORDER BY `id` DESC");
          $postFeeds->execute();
          $postFeeds = $postFeeds->fetchAll();
          foreach($postFeeds as $key => $value){
            $membro = \models\membrosModel::getMmembroById($value['membro_id']);
        ?>

        <div class="post-user-wraper">
          <div class="img-user-post">
              <img src="<?= INCLUDE_PATH_PAINEL ?>uploads/<?= $membro['imagem'] ?>">
          </div><!--img-user-post-->

          <div class="post-user-single">
              <p style="color: blue;font-weight:bold;"><?= $membro['nome'] ?></p>
              <p><?= $value['post'] ?></p>
          </div><!--post-user-single-->
        </div><!--post-user-wraper-->

        <?php } ?>


      </section><!--feed-->
    </div><!--row-me-->
  </div><!--container-->
</section>