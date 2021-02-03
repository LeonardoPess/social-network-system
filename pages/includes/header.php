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

    <div class="form-login">
      <form method="post">
        <input type="text" name="email" placeholder="E-mail...">
        <input type="password" name="senha" placeholder="Senha...">
        <input type="submit" name="login" value="Logar!">
      </form>
    </div><!--form-login-->

  </div><!--container-->
</header>
  