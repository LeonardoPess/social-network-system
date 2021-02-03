<?php
    if(isset($_GET['pendentes']) == false){
?>
<div class="box__content">
    
    <h2><i class="fa fa-id-card"></i> Produtos no Estoque</h2>

    <div class="busca">

        <h2><i class="fas fa-search"></i> Realizar uma busca:</h2>

        <form method="post">
            <input style="font-size: 13px;" placeholder="Procure pelo nome do produto" type="text" name="busca">
            <input type="submit" name="acao" value="Buscar!">
        </form>

    </div><!--busca-->

    <?php
        if(isset($_GET['deletar'])){
            //We wanna delete some product
            $id = (int)$_GET['deletar'];
            $imagens = MySql::conectar()->prepare("SELECT * FROM `tb_admin.estoque_imagens` WHERE produto_id = $id");
            $imagens->execute();
            $imagens = $imagens->fetchAll();
            foreach($imagens as $key => $value){
                @unlink(BASE_DIR_PAINEL.'/uploads/'.$value['imagem']);
            }
            MySql::conectar()->exec("DELETE FROM `tb_admin.estoque_imagens` WHERE produto_id = $id");
            MySql::conectar()->exec("DELETE FROM `tb_admin.estoque` WHERE id = $id");
            Painel::alert('sucesso','O produto foi deletado do estoque com sucesso!');
        }

        if(isset($_POST['atualizar'])){
            $quantidade = $_POST['quantidade'];
            $produto_id = $_POST['produto_id'];
            if($quantidade < 0){
                Painel::alert('erro','Você não pode atualizar a quantidade para menos que zero!');
            }else{
                MySql::conectar()->exec("UPDATE `tb_admin.estoque` SET quantidade = $quantidade WHERE id = $produto_id");
                Painel::alert('sucesso','Você atualizou a quantidade do produto com o ID:'.$_POST['produto_id'].'');
            }
        }

        $sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.estoque` WHERE quantidade = 0");
        $sql->execute();
        if($sql->rowCount() > 0){
            Painel::alert('atencao','Você está com produtos em falta! Clique <a href="'.INCLUDE_PATH_PAINEL.'visualizar-produtos?pendentes">aqui</a> para visualizar-los!');
        }

        $query = "";
        if(isset($_POST['acao']) && $_POST['acao'] == 'Buscar!'){
            $nome = $_POST['busca'];
            $query = "WHERE (nome like '%$nome%' OR descricao LIKE '%$nome%')";
        }
        if($query == ''){
            $query2 = "WHERE quantidade > 0";
        }else{
            $query2 = "AND quantidade > 0";
        }
        $sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.estoque` $query $query2");
        $sql->execute();
        $produtos = $sql->fetchAll();
        if($query != ''){
            echo '<div class="busca__result"><p>Foi encontrado <b>'.count($produtos).'</b> resultado(s):</p></div>';
        }

    ?>

    <div class="boxes">

        <?php
            foreach($produtos as $key => $value){
            $imagemSingle = MySql::conectar()->prepare("SELECT * FROM `tb_admin.estoque_imagens` WHERE produto_id = $value[id] LIMIT 1");
            $imagemSingle->execute();
            @$imagemSingle = $imagemSingle->fetch()['imagem'];
        ?>

        <div class="box__single__wraper w50">
            <div class="box__single w100 border__shadow__grayb">

                <div class="topo__box">
                    <?php if($imagemSingle == ''){ ?>
                        <h1><i class="fas fa-shopping-bag"></i></h1>
                    <?php }else{ ?>
                        <img src="<?php echo INCLUDE_PATH_PAINEL ?>uploads/<?php echo $imagemSingle; ?>">
                    <?php } ?>
                </div><!--topo__box-->

                <div class="body__box">

                    <h3 class="title blue"><b><?php echo $value['nome'] ?></b></h3>
                    <p><b>Descrição:</b> <?php echo $value['descricao']; ?></p>
                    <p><b>Largura:</b> <?php echo $value['largura'] ?> cm</p>
                    <p><b>Altura:</b> <?php echo $value['altura'] ?> cm</p>
                    <p><b>Comprimento:</b> <?php echo $value['comprimento'] ?> cm</p>
                    <p><b>Peso:</b> <?php echo $value['peso'] ?></p>
                    <p><b>Preço:</b> R$<?php echo Painel::convertMoney($value['preco']) ?></p>
                    <p><i class="fas fa-long-arrow-alt-down"></i> <b>Quantidade atual <i class="fas fa-long-arrow-alt-down"></i></b></p>

                    <div style="padding: 0 0 10px 0; border-top: 2px solid #455A64; border-bottom: 2px solid #455A64;" class="group__btn">
                        <form method="post">
                            <input style="height: 34px;width: 30%;" type="number" name="quantidade" min="0" max="900" step="1" value="<?php echo $value['quantidade'] ?>">
                            <input type="hidden" name="produto_id" value="<?php echo $value['id']; ?>">
                            <input style="height: 34px; margin-top: 0;" type="submit" name="atualizar" value="Atualizar!">
                        </form>
                    </div><!--group__btn-->

                    <div class="group__btn">
                        <a class="btn edit" href="<?php echo INCLUDE_PATH_PAINEL ?>editar-produto?id=<?php echo $value['id'] ?>"><i class="fas fa-pencil-alt"></i> Editar</a>
                        <a actionBtn="delete" item_id="<?php echo $value['id'] ?>" class="btn delete" href="<?php echo INCLUDE_PATH_PAINEL ?>visualizar-produtos?deletar=<?php echo $value['id'] ?>"><i class="fas fa-times"></i> Excluir</a>
                    </div><!--group__btn-->

                </div><!--body__box-->

            </div><!--box__single-->
        <div class="clear"></div>
        </div><!--box__single__wraper-->

        <?php
            }
        ?>

    </div><!--boxes-->

</div><!--box__content-->

<?php } else { ?>

        <div class="box__content">
    
        <h2><i class="fa fa-id-card"></i> <a href="<?php echo INCLUDE_PATH_PAINEL ?>visualizar-produtos"> Produtos no Estoque</a> / Produtos em Falta</h2>

        <?php
        echo '<br>';
        if(isset($_POST['atualizar'])){
            $quantidade = $_POST['quantidade'];
            $produto_id = $_POST['produto_id'];
            if($quantidade < 0){
                Painel::alert('erro','Você não pode atualizar a quantidade para menos que zero!');
            }else{
                MySql::conectar()->exec("UPDATE `tb_admin.estoque` SET quantidade = $quantidade WHERE id = $produto_id");
                Painel::alert('sucesso','Você atualizou a quantidade do produto com o ID:'.$_POST['produto_id'].'');
            }
        }

        $sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.estoque` WHERE quantidade = 0");
        $sql->execute();
        $produtos = $sql->fetchAll();
        if(count($produtos) > 0)
            Painel::alert('atencao','Todos os produtos listados <b>abaixo</b> estão em <b>falta no seu estoque!</b>');
        else   
            Painel::redirect('http://localhost/curso-web-master/back_end/projetos/projeto_01/painel/visualizar-produtos');
        echo '<br>';
        

    ?>

    <div class="boxes">

        <?php
            foreach($produtos as $key => $value){
            $imagemSingle = MySql::conectar()->prepare("SELECT * FROM `tb_admin.estoque_imagens` WHERE produto_id = $value[id] LIMIT 1");
            $imagemSingle->execute();
            @$imagemSingle = $imagemSingle->fetch()['imagem'];
        ?>

        <div class="box__single__wraper w50">
            <div class="box__single w100 border__shadow__grayb">

                <div class="topo__box">
                    <?php if(isset($imagemSingle) == ''){ ?>
                        <h1><i class="fas fa-shopping-bag"></i></h1>
                    <?php }else{ ?>
                        <img src="<?php echo INCLUDE_PATH_PAINEL ?>uploads/<?php echo $imagemSingle; ?>">
                    <?php } ?>
                </div><!--topo__box-->

                <div class="body__box">

                <h3 class="title blue"><b><?php echo $value['nome'] ?></b></h3>
                    <p><b>Descrição:</b></p>
                    <p class="styletinymce"><?php echo $value['descricao'] ?></p>
                    <p><b>Largura:</b> <?php echo $value['largura'] ?>cm</p>
                    <p><b>Altura:</b> <?php echo $value['altura'] ?>cm</p>
                    <p><b>Comprimento:</b> <?php echo $value['comprimento'] ?>cm</p>
                    <p><b>Peso:</b> <?php echo $value['peso'] ?></p>
                    <p><b>Preço:</b> R$<?php echo Painel::convertMoney($value['preco']) ?></p>
                    <p><i class="fas fa-long-arrow-alt-down"></i> <b>Quantidade atual:</b> <i class="fas fa-long-arrow-alt-down"></i></p>

                    <div style="padding: 0 0 10px 0; border-top: 2px solid #455A64; border-bottom: 2px solid #455A64;" class="group__btn">
                        <form method="post">
                            <input style="height: 34px;width: 30%;" type="number" name="quantidade" min="0" max="900" step="1" value="<?php echo $value['quantidade'] ?>">
                            <input type="hidden" name="produto_id" value="<?php echo $value['id']; ?>">
                            <input style="height: 34px; margin-top: 0;" type="submit" name="atualizar" value="Atualizar!">
                        </form>
                    </div><!--group__btn-->

                    <div class="group__btn">
                        <a class="btn edit" href="<?php echo INCLUDE_PATH_PAINEL ?>editar-produto?id=<?php echo $value['id'] ?>"><i class="fas fa-pencil-alt"></i> Editar</a>
                        <a actionBtn="delete" item_id="<?php echo $value['id'] ?>" class="btn delete" href="<?php echo INCLUDE_PATH_PAINEL ?>visualizar-produtos?deletar=<?php echo $value['id'] ?>"><i class="fas fa-times"></i> Excluir</a>
                    </div><!--group__btn-->

                </div><!--body__box-->

            </div><!--box__single-->
        <div class="clear"></div>
        </div><!--box__single__wraper-->

        <?php
            }
        ?>

        </div><!--boxes-->

        </div><!--box__content-->
<?php } ?>