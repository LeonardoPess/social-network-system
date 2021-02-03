<?php
    if(isset($_GET['loggout'])){
        Painel::loggout();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!--// TITLE //-->
    <title>Painel de controle</title>

    <!--// META //-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--// LINK //-->
    <link rel="stylesheet" href="https:cdn.jsdelivr.net/gh/stefangabos/Zebra_Datepicker/dist/css/default/zebra_datepicker.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo INCLUDE_PATH_PAINEL ?>css/style.css">
    <link rel="stylesheet" href="<?php echo INCLUDE_PATH_PAINEL ?>css/jquery-ui.min.css">
    
</head>
<body>

<base base="<?php echo INCLUDE_PATH_PAINEL; ?>">

    <aside>
        <div class="aside__wraper">
            <div class="box__usuario">
                <?php
                    if($_SESSION['img'] == ''){
                ?>
                <div class="avatar__usuario">
                    <i class="fa fa-user"></i>
                </div><!--avatar__usuario-->
                <?php }else{ ?>
                <div class="imagem__usuario">
                    <img src="<?php echo INCLUDE_PATH_PAINEL; ?>uploads/<?php echo $_SESSION['img']; ?>">
                </div><!--imagem__usuario-->
                <?php } ?>

                <div class="nome__usuario">
                    <p><?php echo $_SESSION['nome']; ?></p>
                    <p><?php echo pegaCargo($_SESSION['cargo']); ?></p>
                </div><!--nome__usuario-->

            </div><!--box__usuario-->

            <div class="itens__menu">
                <h2><i class="far fa-address-card"></i> Cadastro</h2>
                <a <?php selecionadoMenu('cadastrar-depoimento'); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>cadastrar-depoimento">Cadastrar Depoimento</a>
                <a <?php selecionadoMenu('cadastrar-servico'); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>cadastrar-servico">Cadastrar serviço</a>
                <a <?php selecionadoMenu('cadastrar-slides'); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>cadastrar-slides">Cadastrar Slides</a>
                <h2><i class="far fa-calendar-check"></i> Gestão</h2>
                <a <?php selecionadoMenu('listar-depoimentos'); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>listar-depoimentos">Listar Depoimentos</a>
                <a <?php selecionadoMenu('listar-servicos'); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>listar-servicos">Listar Serviços</a>
                <a <?php selecionadoMenu('listar-slides'); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>listar-slides">Listar Slides</a>
                <h2><i class="fas fa-chart-line"></i> Administração do Painel</h2>
                <a <?php selecionadoMenu('editar-usuario'); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>editar-usuario">Editar Usuário</a>
                <a <?php selecionadoMenu('adicionar-usuarios'); ?> <?php verificaPermissaoMenu(0); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>adicionar-usuarios">Adicionar Usuários</a>
                <h2><i class="far fa-edit"></i> Configuração Geral</h2>
                <a <?php selecionadoMenu('editar-site'); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>editar-site">Editar Site</a>
                <h2><i class="far fa-newspaper"></i> Gestão de notícias</h2>
                <a <?php selecionadoMenu('gerenciarr-noticias'); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>gerenciar-noticias">Gerenciar Notícias</a>
                <a <?php selecionadoMenu('gerenciar-categorias'); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>gerenciar-categorias">Gerenciar Categorias</a>
                <a <?php selecionadoMenu('cadastrar-noticias'); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>cadastrar-noticias">Cadastrar Notícias</a>
                <a <?php selecionadoMenu('cadastrar-categorias'); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>cadastrar-categorias">Cadastrar Categorias</a>
                <h2><i class="fa fa-id-card"></i> Gestão de clientes</h2>
                <a <?php selecionadoMenu('gerenciar-clientes'); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>gerenciar-clientes">Gerenciar Clientes</a>
                <a <?php selecionadoMenu('cadastrar-clientes'); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>cadastrar-clientes">Cadastrar Clientes</a>
                <h2><i class="fas fa-cash-register"></i> Controle Financeiro</h2>
                <a <?php selecionadoMenu('visualizar-pagamentos'); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>visualizar-pagamentos">Visualizar Pagamentos</a>
                <h2><i class="fas fa-balance-scale"></i> Controle de Estoque</h2>
                <a <?php selecionadoMenu('visualizar-produtos'); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>visualizar-produtos">Visualizar Produtos</a>
                <a <?php selecionadoMenu('cadastrar-produtos'); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>cadastrar-produtos">Cadastrar Produtos</a>
                <h2><i class="far fa-building"></i> Gestão Imóveis</h2>
                <a <?php selecionadoMenu('listar-empreendimentos'); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>listar-empreendimentos">Listar Empreendimentos</a>
                <a <?php selecionadoMenu('cadastrar-empreendimento'); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>cadastrar-empreendimento">Cadastrar Empreendimento</a>
                <h2><i class="fas fa-book-reader"></i> Gestão EAD</h2>
                <a <?php selecionadoMenu('novo-aluno'); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>novo-aluno">Novo Aluno</a>
                <a <?php selecionadoMenu('novo-modulo'); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>novo-modulo">Novo Modulo</a>
                <a <?php selecionadoMenu('nova-aula'); ?> href="<?php echo INCLUDE_PATH_PAINEL ?>nova-aula">Nova Aula</a>
            </div><!--itens__menu-->

        </div><!--aside_wraper-->
    </aside>

    <header>
        <div class="container">

            <div class="nav-top">
                <div class="menu__btn">
                    <i class="fa fa-bars"></i>
                </div><!--menu__btn-->
                
                <div class="nav-btn">
                    <a <?php if(@$_GET['url'] == 'chat'){ ?> style="background-color: #60727a;" <?php } ?> href="<?php echo INCLUDE_PATH_PAINEL ?>chat"><i class="far fa-comments"></i></a>
                    <a <?php if(@$_GET['url'] == ''){ ?> style="background-color: #60727a;" <?php } ?> href="<?php echo INCLUDE_PATH_PAINEL ?>"><i class="fas fa-home"></i></a>
                    <a style="background-color: red;" href="<?php echo INCLUDE_PATH_PAINEL ?>?loggout"><i class="fas fa-sign-out-alt"></i></a>
                </div><!--nav-btn-->
            </div><!--nav-top-->

        </div><!--container-->
    </header>

    <div class="content">

        <?php
           Painel::loadPage();
        ?>

    </div><!--content-->


<script src="<?php echo INCLUDE_PATH; ?>js/all.min.js"></script>
<script src="<?php echo INCLUDE_PATH; ?>js/jquery.js"></script>
<script src="https:cdn.jsdelivr.net/gh/stefangabos/Zebra_Datepicker/dist/zebra_datepicker.min.js"></script>
<script src="<?php echo INCLUDE_PATH_PAINEL; ?>js/jquery.mask.min.js"></script>
<script src="<?php echo INCLUDE_PATH_PAINEL; ?>js/jquery.ajaxform.js"></script>
<script src="<?php echo INCLUDE_PATH; ?>js/constants.js"></script>
<script src="<?php echo INCLUDE_PATH_PAINEL; ?>js/main.js"></script>
<script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
  <script>
  tinymce.init({ 
    selector:'.tinymce',
    height:300,
    plugins: 'textcolor image link lists ',
    toolbar: "forecolor backcolor image link numlist bullist"
   });
  </script>
<script src="<?php echo INCLUDE_PATH_PAINEL; ?>js/helperMask.js"></script>
<?php Painel::loadJS(array('ajax.js'),'gerenciar-clientes'); ?>
<?php Painel::loadJS(array('ajax.js'),'cadastrar-clientes'); ?>
<?php Painel::loadJS(array('ajax.js','controleFinanceiro.js','jquery.maskMoney.js'),'editar-cliente'); ?>
<?php Painel::loadJS(array('ajax.js'),'cadastrar-empreendimento'); ?>
<?php Painel::loadJS(array('jquery-ui.min.js','empreendimentos.js'),'listar-empreendimentos'); ?>
<?php Painel::loadJS(array('controleFinanceiro.js','jquery.maskMoney.js'),'visualizar-empreendimento'); ?>
<?php Painel::loadJS(array('chat.js'),'chat'); ?>
<?php Painel::loadJS(array('controleFinanceiro.js','jquery.maskMoney.js'),'cadastrar-produtos'); ?>
<?php Painel::loadJS(array('controleFinanceiro.js','jquery.maskMoney.js'),'editar-produto'); ?>
</body>
</html>