<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Rede Social</title>
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= INCLUDE_PATH ?>css/style.css">
</head>
<body>
<base base="<?= INCLUDE_PATH ?>">

<header>
  <div class="container">

    <div class="logo"><a href="<?= INCLUDE_PATH ?>">Rede Social</a></div><!--logo-->

    <div class="btn-opt-menu">
      <?php $solicitacoesPendentes = count(\controllers\solicitacoesController::listarSolicitacoes()) ?>
      <a href="<?= INCLUDE_PATH ?>solicitacoes"> Solicitações(<?= $solicitacoesPendentes ?>)</a>
      <a href="<?= INCLUDE_PATH ?>comunidade"> Comunidade</a>
      <a href="<?= INCLUDE_PATH?>me?sair"><i class="fa fa-times"></i> Sair</a>
    </div><!--btn-opt-menu-->

  </div><!--container-->
</header>
  