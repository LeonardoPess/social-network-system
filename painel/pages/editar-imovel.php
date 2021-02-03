<?php
    $id = (int)$_GET['id'];
    $sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.imoveis` WHERE id = ?");
    $sql->execute(array($id));
    if($sql->rowCount() == 0){
        Painel::alert('erro','O imóvel que você quer editar não existe!');
        die();
    }

    $infoProduto = $sql->fetch();

    $pegaImagens = MySql::conectar()->prepare("SELECT * FROM `tb_admin.imagens_imoveis` WHERE imovel_id = $id");
    $pegaImagens->execute();
    $pegaImagens = $pegaImagens->fetchAll();

?>
<div class="box__content">
    
    <h2><i class="fas fa-user-edit"></i> Editando imóvel: <span class="pink"><?php echo $infoProduto['nome'] ?></span></h2>

    <?php

        if(isset($_GET['sucesso'])){
            Painel::alert('sucesso','Você atualizou seu imóvel com sucesso!');
        }

        if(isset($_GET['deletarImagem'])){
          $idImagem = $_GET['deletarImagem'];
          @unlink(BASE_DIR_PAINEL.'/uploads/'.$idImagem);
          MySql::conectar()->exec("DELETE FROM `tb_admin.imagens_imoveis` WHERE imagem = $idImagem");
          Painel::alert('sucesso','A imagem foi deletada com sucesso!');
          $pegaImagens = MySql::conectar()->prepare("SELECT * FROM `tb_admin.imagens_imoveis` WHERE imovel_id = $id");
          $pegaImagens->execute();
          $pegaImagens = $pegaImagens->fetchAll();
        }else if(isset($_GET['deletarImovel'])){
         foreach($pegaImagens as $key => $value){
            @unlink(BASE_DIR_PAINEL.'/uploads/'.$value['imagem']);
          }
          MySql::conectar()->exec("DELETE FROM `tb_admin.imagens_imoveis` WHERE imovel_id = $id");
          MySql::conectar()->exec("DELETE FROM `tb_admin.imoveis` WHERE id = $id");
          Painel::alertJS("O imóvel foi deletado com sucesso!");
          Painel::redirect(INCLUDE_PATH_PAINEL.'listar-empreendimentos');
        }
    ?>

    <div class="card__title"><i class="fa fa-rocket"></i> Imagens do imóvel</div><!--card__title-->

    <div class="boxes">

    <?php
        if(isset($pegaImagens) == ''){ ?>
            <h1><i class="fas fa-shopping-bag"></i></h1>
        <?php }else{
            foreach($pegaImagens as $key => $value){
    ?>

        <div class="box__single__wraper w50">
            <div class="box__single w100 border__shadow__blue">

                <div class="topo__box__img">
                    <img class="square" src="<?php echo INCLUDE_PATH_PAINEL ?>uploads/<?php echo $value['imagem'] ?>">

                    <div class="group__btn">
                        <a actionBtn="delete" class="btn delete" href="<?php echo INCLUDE_PATH_PAINEL ?>editar-imovel?id=<?php echo $id; ?>&deletarImagem=<?php echo $value['imagem'] ?>"><i class="fas fa-times"></i> Excluir</a>
                    </div><!--group__btn-->

                </div><!--topo__box__img-->

            </div><!--box__single-->
        </div><!--box__single__wraper-->

        <?php
            }
        }
        ?>
    
        </div><!--boxes-->

        <div class="card__title"><i class="fa fa-rocket"></i> Informações do Produto</div><!--card__title-->

        <form method="post" enctype="multipart/form-data">

        <div class="form__group">
            <label>Nome do imóvel:</label>
            <input disabled type="text" name="nome" value="<?= $infoProduto['nome'] ?>">
        </div><!--form__group-->

        <div class="form__group">
            <label>Preço:</label>
            <input disabled type="text" name="nome" value="<?= $infoProduto['preco'] ?>">
        </div><!--form__group-->
        
        <div class="form__group">
            <label>Área:</label>
            <input disabled type="text" name="nome" value="<?= $infoProduto['area'] ?>">
        </div><!--form__group-->

        <div class="form__group">
            <label>Selecione as imagens:</label>
            <input multiple type="file" name="imagem[]">
        </div><!--form__group-->

          <a style="max-width: 138px;" actionBtn="delete" class="btn delete" href="<?php echo INCLUDE_PATH_PAINEL ?>editar-imovel?id=<?= $id; ?>&deletarImovel"><i class="fas fa-times"></i> Excluir imóvel</a>

    </form>

</div><!--box__content-->