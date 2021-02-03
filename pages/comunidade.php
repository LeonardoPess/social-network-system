<section class="comunidade">
  <div class="container">
    <div class="box w100">
      <h2 class="tittle">Comunidade</h2>

      <div class="membro-listagem-wraper">
      <?php
        $select = \MySql::conectar()->prepare("SELECT * FROM `tb_site.membros`");
        $select->execute();
        $select = $select->fetchAll();
        foreach($select as $key => $value){
          if($value['id'] == $_SESSION['id_membro']){
            continue;
          }
      ?>

        <div class="membro-listagem">
          <div class="box-imagem-wraper">
          <div style="background-image: url('<?= INCLUDE_PATH_PAINEL ?>uploads/<?= $value['imagem'] ?>');" class="box-imagem"></div><!--box-imagem-->
          </div><!--box-imagem-wraper-->
          <p><i class="fa fa-user"></i><?= $value['nome']; ?></p>

          <?php if($arr['controller']->isAmigo($value['id'])){ ?>
            <a style="background: green;opacity: 0.6;" href="<?= INCLUDE_PATH ?>comunidade?addFriend=<?= $value['id'] ?>"><i class="fa fa-check"></i> Amigo</a>
          <?php }else if($arr['controller']->amigoPendente($value['id']) == false){ ?>
            <a href="<?= INCLUDE_PATH ?>comunidade?addFriend=<?= $value['id'] ?>">Adicionar</a>
          <?php }else{ ?>
            <a style="opacity: 0.6;" href="javascript:void(0);">Pendente</a>
          <?php } ?>


        </div><!--membro-listagem-->

      <?php } ?>
      </div><!--membro-listagem-wraper-->

    </div><!--w100-->
  </div><!--container-->
</section><!--comunidade-->