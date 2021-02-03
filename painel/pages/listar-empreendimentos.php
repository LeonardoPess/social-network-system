<div class="box__content">
    
    <h2><i class="fa fa-id-card"></i> Empreendimentos</h2>

    <div class="busca">

        <h2><i class="fas fa-search"></i> Realizar uma busca:</h2>

        <form method="post">
            <input style="font-size: 13px;" placeholder="Procure pelo nome do empreendimento" type="text" name="busca">
            <input type="submit" name="acao" value="Buscar!">
        </form>

    </div><!--busca-->

    <?php
        if(isset($_GET['deletar'])){
            //We wanna delete some product
            $id = (int)$_GET['deletar'];
            $imagens = MySql::conectar()->prepare("SELECT `imagem` FROM `tb_admin.empreendimentos` WHERE id = $id");
            $imagens->execute();
            $imagens = $imagens->fetch();
            @unlink(BASE_DIR_PAINEL.'/uploads/'.$imagens['imagem']);

            $imoveis = MySql::conectar()->prepare("SELECT * FROM `tb_admin.imoveis` WHERE empreend_id = $id");
            $imoveis->execute();
            $imoveis = $imoveis->fetchAll();
            foreach($imoveis as $key => $value){
                $imagens = MySql::conectar()->prepare("SELECT * FROM `tb_admin.imagens_imoveis` WHERE imovel_id = $value[id]");
                $imagens->execute();
                $imagens = $imagens->fetchAll();
                foreach($imagens as $key2 => $value2){
                    @unlink(BASE_DIR_PAINEL.'/uploads/'.$value2['imagem']);
                    MySql::conectar()->exec("DELETE FROM `tb_admin.imagens_imoveis` WHERE id = $value2[id]");
                }
            }
            MySql::conectar()->exec("DELETE FROM `tb_admin.imoveis` WHERE empreend_id = $id");
            MySql::conectar()->exec("DELETE FROM `tb_admin.empreendimentos` WHERE id = $id");
            Painel::alert('sucesso','O empreendimento foi deletado com sucesso!');
        }

        $query = "";
        if(isset($_POST['acao']) && $_POST['acao'] == 'Buscar!'){
            $nome = $_POST['busca'];
            $query = "WHERE (nome like '%$nome%')";
        }
        if($query == ''){
            $query2 = "";
        }else{
            $query2 = "";
        }
        $sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.empreendimentos` $query ORDER BY order_id ASC");
        $sql->execute();
        $produtos = $sql->fetchAll();
        if($query != ''){
            echo '<div class="busca__result"><p>Foi encontrado <b>'.count($produtos).'</b> resultado(s):</p></div>';
        }

    ?>

    <div class="boxes">

        <?php
            foreach($produtos as $key => $value){
        ?>

        <div id="item=<?php echo $value['id'] ?>" class="box__single__wraper w50">
            <div class="box__single w100 border__shadow__grayb">

                <div class="topo__box">
                  <img src="<?php echo INCLUDE_PATH_PAINEL ?>uploads/<?php echo $value['imagem']; ?>">
                </div><!--topo__box-->

                <div class="body__box">

                    <h3 class="title blue"><b><?php echo $value['nome'] ?></b></h3>
                    <p><b>Tipo:</b> <?php echo ucfirst($value['tipo']); ?></p>

                    <div class="group__btn">
                        <a actionBtn="delete" item_id="<?php echo $value['id'] ?>" class="btn delete" href="<?php echo INCLUDE_PATH_PAINEL ?>listar-empreendimentos?deletar=<?php echo $value['id'] ?>"><i class="fas fa-times"></i> Excluir</a>
                        <a style="background: #0091ea;" class="btn" href="<?php echo INCLUDE_PATH_PAINEL ?>visualizar-empreendimento/<?php echo $value['id'] ?>"><i class="fas fa-eye"></i> Visualizar</a>
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