<?php
    $id = (int)$_GET['id'];
    $sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.estoque` WHERE id = ?");
    $sql->execute(array($id));
    if($sql->rowCount() == 0){
        Painel::alert('erro','O produto que você quer editar não existe!');
        die();
    }

    $infoProduto = $sql->fetch();

    $pegaImagens = MySql::conectar()->prepare("SELECT * FROM `tb_admin.estoque_imagens` WHERE produto_id = $id");
    $pegaImagens->execute();
    $pegaImagens = $pegaImagens->fetchAll();

?>
<div class="box__content">
    
    <h2><i class="fas fa-user-edit"></i> Editando Produto: <span class="pink"><?php echo $infoProduto['nome'] ?></span></h2>

    <?php

        if(isset($_GET['sucesso'])){
            Painel::alert('sucesso','Você atualizou seu produto com sucesso!');
        }

        if(isset($_GET['deletarImagem'])){
            $idImagem = $_GET['deletarImagem'];
            @unlink(BASE_DIR_PAINEL.'/uploads/'.$idImagem);
            MySql::conectar()->exec("DELETE FROM `tb_admin.estoque_imagens` WHERE imagem = '$idImagem'");
            Painel::alert('sucesso','A imagem foi deletada com sucesso!');
            $pegaImagens = MySql::conectar()->prepare("SELECT * FROM `tb_admin.estoque_imagens` WHERE produto_id = $id");
            $pegaImagens->execute();
            $pegaImagens = $pegaImagens->fetchAll();
        }
    ?>

    <div class="card__title"><i class="fa fa-rocket"></i> Imagens do Produto</div><!--card__title-->

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
                        <a actionBtn="delete" class="btn delete" href="<?php echo INCLUDE_PATH_PAINEL ?>editar-produto?id=<?php echo $id; ?>&deletarImagem=<?php echo $value['imagem'] ?>"><i class="fas fa-times"></i> Excluir</a>
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

        <?php 
            if(isset($_POST['acao'])){
                $nome = $_POST['nome'];
                $descricao = $_POST['descricao'];
                $largura = $_POST['largura'];
                $altura = $_POST['altura'];
                $comprimento = $_POST['comprimento'];
                $peso = $_POST['peso'];
                $preco = $_POST['valor'];
                $quantidade = $_POST['quantidade'];

                $imagens = [];
                $amountFiles = count($_FILES['imagem']['name']);

                $sucesso = true;

                if($_FILES['imagem']['name'][0] != ''){
                    for($i = 0; $i < $amountFiles; $i++){
                        $imagemAtual = ['type'=>$_FILES['imagem']['type'][$i],
                        'size'=>$_FILES['imagem']['size'][$i]];
                    if(Painel::imagemValida($imagemAtual) == false){
                        $sucesso = false;
                        Painel::alert('erro','Uma das imagens selecionadas sao inválidas!');
                        break;
                        }
                    }
                }
                
                if($sucesso == true){
                    if($_FILES['imagem']['name'][0] != ''){
                        for($i = 0; $i < $amountFiles; $i++){
                            $imagemAtual = ['tmp_name'=>$_FILES['imagem']['tmp_name'][$i],
                            'name'=>$_FILES['imagem']['name'][$i]];
                            $imagens[] = Painel::uploadFile($imagemAtual);
                        }

                        foreach($imagens as $key => $value){
                            MySql::conectar()->exec("INSERT INTO `tb_admin.estoque_imagens` VALUES (null,$id,'$value')");
                        }
                    }

                    $sql = MySql::conectar()->prepare("UPDATE `tb_admin.estoque` SET nome = ?,descricao = ?,
                    altura = ?,largura = ?, comprimento = ?, peso = ?, preco = ?, quantidade = ? WHERE id = $id");
                    $sql->execute(array($nome,$descricao,$altura,$largura,$comprimento,$peso,$preco,$quantidade));

                    Painel::redirect("http://localhost/curso-web-master/back_end/projetos/projeto_01/painel/editar-produto?id=".$id."&sucesso");

                    $sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.estoque` WHERE id = ?");
                    $sql->execute(array($id));
                    $infoProduto = $sql->fetch();
                }
            }
        ?>

        <div class="form__group">
            <label>Nome do produto:</label>
            <input type="text" name="nome" value="<?php echo $infoProduto['nome'] ?>">
        </div><!--form__group-->

        <div class="form__group">
            <label>Descrição do produto:</label>
            <textarea class="tinymce" name="descricao"><?php echo $infoProduto['descricao'] ?></textarea>
        </div><!--form__group-->

        <div class="form__group">
            <label>Largura do produto:</label>
            <input type="number" name="largura" min="0" max="900" step="1" value="<?php echo $infoProduto['largura'] ?>">
        </div><!--form__group-->

        <div class="form__group">
            <label>Altura do produto:</label>
            <input type="number" name="altura" min="0" max="900" step="1" value="<?php echo $infoProduto['altura'] ?>">
        </div><!--form__group-->

        <div class="form__group">
            <label>Comprimento do produto:</label>
            <input type="number" name="comprimento" min="0" max="900" step="1" value="<?php echo $infoProduto['comprimento'] ?>">
        </div><!--form__group-->

        <div class="form__group">
            <label>Peso:</label>
            <input type="number" name="peso" min="0" max="900" step="1" value="<?php echo $infoProduto['peso'] ?>">
        </div><!--form__group-->

        <div class="form__group">
            <label>Preço:</label>
            <input type="text" name="valor" value="<?php echo $infoProduto['preco'] ?>">
        </div><!--form__group-->

        <div class="form__group">
            <label>Quantidade atual do produto:</label>
            <input type="number" name="quantidade" min="0" max="900" step="1" value="<?php echo $infoProduto['quantidade'] ?>">
        </div><!--form__group-->

        <div class="form__group">
            <label>Selecione as imagens:</label>
            <input multiple type="file" name="imagem[]">
        </div><!--form__group-->

        <input type="submit" name="acao" value="Atualizar Produto!">

    </form>

</div><!--box__content-->