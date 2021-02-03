<div class="box__content">
    
    <h2><i class="fas fa-user-edit"></i> Adicionar Aluno</h2>

    <form method="post" enctype="multipart/form-data">

    <?php
        if(isset($_POST['acao'])){

          $nome = $_POST['nome'];
          $email = $_POST['email'];
          $senha = $_POST['senha'];

          if($nome == '' || $email == '' || $senha == ''){
            Painel::alert("erro","Você precisa preencher todos os campos!");
          }else{
            $sql = Mysql::conectar()->prepare("INSERT INTO `tb_admin.alunos` VALUES (null,?,?,?)");
            $sql->execute([$nome,$email,$senha]);
            Painel::alert("sucesso","O aluno foi cadastrado com sucesso!");
          }

        }
    ?>

        <div class="form__group">
            <label>Nome do aluno:</label>
            <input type="text" name="nome">
        </div><!--form__group-->

        <div class="form__group">
            <label>Email:</label>
            <input type="email" name="email">
        </div><!--form__group-->

        <div class="form__group">
            <label>Senha:</label>
            <input type="password" name="senha">
        </div><!--form__group-->

        <div class="form__group">
            <input type="submit" name="acao" value="Cadastrar Aluno">
        </div><!--form__group-->

    </form>

</div><!--box__content-->