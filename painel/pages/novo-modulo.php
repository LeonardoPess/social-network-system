<div class="box__content">
    
    <h2><i class="fas fa-user-edit"></i> Adicionar Módulo</h2>

    <form method="post" enctype="multipart/form-data">

    <?php
        if(isset($_POST['acao'])){

          $nome = $_POST['nome'];

          if($nome == ''){
            Painel::alert("erro","Você precisa preencher todos os campos!");
          }else{
            $sql = Mysql::conectar()->prepare("INSERT INTO `tb_admin.modulos` VALUES (null,?)");
            $sql->execute([$nome]);
            Painel::alert("sucesso","O módulo foi cadastrado com sucesso!");
          }

        }
    ?>

        <div class="form__group">
            <label>Nome do módulo:</label>
            <input type="text" name="nome">
        </div><!--form__group-->

        <div class="form__group">
            <input type="submit" name="acao" value="Cadastrar Módulo">
        </div><!--form__group-->

    </form>

</div><!--box__content-->