<?php
  $id = $par[2];
  $sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.empreendimentos` WHERE id = ?");
  $sql->execute(array($id));

  $infoEmpreend = $sql->fetch();

  if($infoEmpreend['nome'] == ''){
    header('Location: '.INCLUDE_PATH_PAINEL);
    die();
  }

?>
<div class="box__content">
  <h2><i class="fa fa-id-card"></i> Empreendimento: <span class="pink"><?= $infoEmpreend['nome'] ?></span></h2>

  <?php
    if(isset($_GET['sucesso'])){
      Painel::alert('sucesso','O Imóvel foi cadastrado com sucesso!');
    }
  ?>

    <div class="info__item">

      <div class="row1">
        <div class="card__title"><i class="fa fa-rocket"></i> Imagem</div><!--card__title-->
          <img class="border__shadow__blue" src="<?= INCLUDE_PATH_PAINEL ?>uploads/<?= $infoEmpreend['imagem'] ?>" alt="Empreendimento">
      </div><!--row1-->

      <div class="row2">
        <div class="card__title"><i class="fa fa-rocket"></i> Informações do Empreendimento</div><!--card__title-->
          <h4>Nome do Empreendimento: <span><?= $infoEmpreend['nome'] ?></span></h4>
          <h4>Tipo: <span><?= ucfirst($infoEmpreend['tipo']) ?></span></h4>
      </div><!--row2-->

    <div class="clear"></div>
    </div><!--info__item-->

    <div class="wraper__table">
    <table>
        <tr>
            <td>Nome</td>
            <td>Preço</td>
            <td>Area</td>
            <td>Visualizar</td>
        </tr>
        <?php
          $pegaImoveis = Painel::selectQuery('tb_admin.imoveis','empreend_id=?',[$id]);
          foreach($pegaImoveis as $key => $value){
          $value['preco'] = Painel::convertMoney($value['preco']);
        ?>
        <tr>
            <td><?= $value['nome'] ?></td>
            <td>R$<?= $value['preco'] ?></td>
            <td><?= $value['area'] ?>m²</td>
            <td><a class="btn order" href="<?php echo INCLUDE_PATH_PAINEL ?>editar-imovel?id=<?= $value['id'] ?>"><i class="fa fa-eye"></i>Visualizar</a></td>
        </tr>
        <?php } ?>

    </table>
    </div><!--wraper__table-->

    <div class="card__title"><i class="fa fa-rocket"></i> Cadastrar Imóvel</div><!--card__title-->
    <form method="post" enctype="multipart/form-data">

    <?php
        if(isset($_POST['acao'])){
            $empreend_id = $id;
            $nome = $_POST['nome'];
            $area = $_POST['area'];
            $preco = Painel::formatarMoedaBd($_POST['valor']);

            $imagens = array();
            $amountFiles = count($_FILES['imagens']['name']);

            $sucesso = true;

            if($_FILES['imagens']['name'][0] != ''){
                for($i = 0; $i < $amountFiles; $i++){
                    $imagemAtual = ['type'=>$_FILES['imagens']['type'][$i],
                    'size'=>$_FILES['imagens']['size'][$i]];
                    if(Painel::imagemValida($imagemAtual) == false){
                        $sucesso = false;
                        Painel::alert('erro','Uma das imagens selecionadas não são inválidas!');
                        break;
                    }
                }
            }else{ 
              $sucesso = false;
              Painel::alert('erro','Você precisa selecionar pelo menos uma imagem!');
            }

            if($sucesso){
                //register information, images and upload.
                for($i = 0; $i < $amountFiles; $i++){
                    $imagemAtual = ['tmp_name'=>$_FILES['imagens']['tmp_name'][$i],
                    'name'=>$_FILES['imagens']['name'][$i]];
                    $imagens[] = Painel::uploadFile($imagemAtual);
                }
                
                $sql = MySql::conectar()->prepare("INSERT INTO `tb_admin.imoveis` VALUE (null,?,?,?,?,0)");
                $sql->execute(array($empreend_id,$nome,$preco,$area));
                $lastId = MySql::conectar()->lastInsertId();
                foreach($imagens as $key => $value){
                    MySql::conectar()->exec("INSERT INTO `tb_admin.imagens_imoveis` VALUES (null,$lastId,'$value')");
                }
                Painel::redirect("http://localhost/curso-web-master/back_end/projetos/projeto_01/painel/visualizar-empreendimento/".$id."?sucesso");
            }
        }
    ?>

      <div class="form__group">
        <label>Nome:</label>
        <input type="text" name="nome">
      </div><!--form__group-->

      <div class="form__group">
            <label>Área:</label>
            <input type="number" name="area" min="0" step="100" value="0">
        </div><!--form__group-->

      <div class="form__group">
          <label>Valor do pagamento:</label>
          <input type="text" name="valor">
      </div><!--form__group-->

      <div class="form__group">
        <label>Selecione imagens:</label>
          <input type="file" multiple name="imagens[]">
      </div><!--form__group-->

      <div class="form__group">
          <input type="submit" name="acao" value="Cadastrar Imóvel!">
      </div><!--form__group-->

    </form>

</div><!--box__content-->