<section class="comunidade">
  <div class="container">
    <div class="box w100">
      <h2 class="tittle">Solicitações</h2>

      <div class="membro-listagem-wraper">

      <?php
        $solicitacoesPendentes = \controllers\solicitacoesController::listarSolicitacoes();
        foreach($solicitacoesPendentes as $key => $value){
        $membro = \models\membrosModel::getMmembroById($value['id_from']);
      ?>

        <div class="membro-listagem">
          <div class="box-imagem-wraper">
          <div style="background-image: url('<?= INCLUDE_PATH_PAINEL.'uploads/'.$membro['imagem']; ?>');" class="box-imagem"></div><!--box-imagem-->
          </div><!--box-imagem-wraper-->
          <p><i class="fa fa-user"></i><?= $membro['nome']; ?></p>
          <a style="background: green;opacity: 0.6;width: 120px;margin: 6px 0;" href="<?= INCLUDE_PATH ?>solicitacoes?aceitar=<?= $value['id_from'] ?>"><i class="fa fa-check"></i> Aceitar</a>
          <a style="background: red;opacity: 0.6;width: 120px;" href="<?= INCLUDE_PATH ?>solicitacoes?recusar=<?= $value['id_from'] ?>"><i class="fa fa-times"></i> Recusar</a>
        </div><!--membro-listagem-->

      <?php } ?>

      </div><!--membro-listagem-wraper-->

    </div><!--box w100-->
  </div><!--container-->
</section><!--comunidade-->