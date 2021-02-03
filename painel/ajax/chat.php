<?php

  include('../../includeConstantes.php');

  $data['success'] = true;
  $data['mensagem'] = "";
  $hour = date("H:i:s");

  if(Painel::logado() == false){
      die("You're not logged in!");
  }

  if(isset($_POST['acao']) && $_POST['acao'] == 'inserir_mensagem'){
    $mensagem = $_POST['mensagem'];
    $nome = $_SESSION['nome'];
    $id_user = $_SESSION['id_user'];
    $img_user = $_SESSION['img'];
    $color = Painel::selectColor($id_user);

    $sql = Mysql::conectar()->prepare("INSERT INTO `tb_admin.chat` VALUES (null,?,?,?,?,?)");
    $sql->execute(array($id_user,$mensagem,$hour,$img_user,$color));

    if($img_user != ''){
      $imagem = '<img src="'.INCLUDE_PATH_PAINEL.'uploads/'.$img_user.'">';
    }else{
      $imagem = '<i class="fas fa-user"></i>';
    }

    echo '<div class="box__chat_wraper">
            <div style="background-color: '.$color.';" class="image__user">
              '.$imagem.'
            </div><!--image__user-->

            <div style="background-color: '.$color.';" class="mensagem__chat">
              <span>'.$nome.' <b>'.$hour.'</b></span>
              <p>'.$mensagem.'</p>
            </div><!--mensagem__chat-->
          </div><!--box__chat_wraper-->
          <br>';

        $_SESSION['lastIdChat'] = MySql::conectar()->lastInsertId();

  }else if(isset($_POST['acao']) && $_POST['acao'] == 'pegarMensagens'){
    //take messages
    $lastId = $_SESSION['lastIdChat'];

    $sql = Mysql::conectar()->prepare("SELECT * FROM `tb_admin.chat` WHERE id > $lastId");
    $sql->execute();
    $mensagens = $sql->fetchAll();
    $mensagens = array_reverse($mensagens);

    foreach($mensagens as $key => $value){
      $nomeUsuario = MySql::conectar()->prepare("SELECT `nome` FROM `tb_admin.usuarios` WHERE id = $value[user_id]");
      $nomeUsuario->execute();
      $nomeUsuario = $nomeUsuario->fetch()['nome'];

      if($value['img_user'] != ''){
        $imagem = '<img src="'.INCLUDE_PATH_PAINEL.'uploads/'.$value['img_user'].'">';
      }else{
        $imagem = '<i class="fas fa-user"></i>';
      }

      echo '<div class="box__chat_wraper">
              <div style="background-color: '.$value['color'].';" class="image__user">
                '.$imagem.'
              </div><!--image__user-->

              <div style="background-color: '.$value['color'].';" class="mensagem__chat">
                <span>'.$nomeUsuario.' <b>'.$value['hora'].'</b></span>
                <p>'.$value['mensagem'].'</p>
              </div><!--mensagem__chat-->
            </div><!--box__chat_wraper-->
            <br>';

      $_SESSION['lastIdChat'] = $value['id'];

    }
  }

