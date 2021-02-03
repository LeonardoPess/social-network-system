<div class="box__content">
    
  <h2><i class="fas fa-user-edit"></i> Cadastrar Empreendimento</h2>

    <form method="post" enctype="multipart/form-data">

    <?php
      if(isset($_POST['acao'])){

        $nome = $_POST['nome'];
        $tipo = $_POST['tipo'];
        $imagem = $_FILES['imagem'];

        if($nome == '' || $tipo == ''){
          Painel::alert('erro','Campos vázio não são permitidos!');
        }else if($imagem == ''){
          Painel::alert('erro','Você precisa selecionar uma imagem.');
        }else{
          if(Painel::imagemValida($imagem) == false){
            Painel::alert('erro','Ops. Imagem inválida :(');
          }else{
            $idImagem = Painel::uploadFile($imagem);
            $slug = Painel::generateSlug($nome);
            $sql = MySql::conectar()->prepare("INSERT INTO `tb_admin.empreendimentos` VALUES (null,?,?,?,?,?)");
            $sql->execute(array($nome,$tipo,$idImagem,$slug,0));
            $lastId = MySql::conectar()->lastInsertId();
            MySql::conectar()->exec("UPDATE `tb_admin.empreendimentos` SET order_id = $lastId WHERE id = $lastId");
            Painel::alert('sucesso','Cadastro do empreendimento foi feito com sucesso!');
          }
        }

      }
    ?>

      <div class="form__group">
        <label for="nome">Nome:</label>
        <input type="text" name="nome" required>
      </div><!--form__group-->

      <div class="form__group">
        <label for="tipo">Tipo:</label>
        <select name="tipo" required>
          <option value="residencial">Residencial</option>
          <option value="comercial">Comercial</option>
        </select>
      </div><!--form__group-->

      <div div class="form__group">
        <label for="imagem">Imagem:</label>
        <input type="file" name="imagem" required>
      </div><!--form__group-->

      <div div class="form__group">
        <input type="submit" name="acao">
      </div><!--form__group-->

    </form>

</div><!--box__content-->