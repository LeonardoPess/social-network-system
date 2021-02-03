<div class="box__content">
    
    <h2><i class="fas fa-user-edit"></i> Adicionar Aula</h2>

    <form method="post" enctype="multipart/form-data">

    <?php
        if(isset($_POST['acao'])){

          $nome = $_POST['nome'];
          $modulo = $_POST['modulo_id'];
          $link = $_POST['link_aula'];

          if($nome == '' || $link == ''){
            Painel::alert("erro","Você precisa preencher todos os campos!");
          }else{
            $sql = \Mysql::conectar()->prepare("INSERT INTO `tb_admin.aulas` VALUES (null,?,?,?)");
            $sql->execute([$nome,$modulo,$link]);
            Painel::alert("sucesso","A aula foi cadastrado com sucesso!");
          }

        }
    ?>

        <div class="form__group">
            <label>Nome da aula:</label>
            <input type="text" name="nome">
        </div><!--form__group-->

        <div class="form__group">
          <label>Selecione o Módulo:</label>
            <select name="modulo_id">
              <?php 
                $modulo = MySql::conectar()->prepare("SELECT * FROM `tb_admin.modulos`");
                $modulo->execute();
                $modulo = $modulo->fetchAll();
                foreach($modulo as $key => $value){
              ?>

              <option value="<?= $value['id'] ?>"><?= $value['nome'] ?></option>

              <?php } ?>
            </select>
        </div><!--form__group-->

        <div class="form__group">
            <label>Aula:</label>
            <input type="text" name="link_aula">
        </div><!--form__group-->

        <div class="form__group">
            <input type="submit" name="acao" value="Cadastrar Módulo">
        </div><!--form__group-->

    </form>

</div><!--box__content-->