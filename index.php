<?php 
    include('config.php'); 
    Site::updateUsuarioOnline();
    Site::contador(); 

    $homeController = new controllers\homeController();
    $perfilController = new controllers\perfilController();
    $comunidadeController = new controllers\comunidadeController();
    $solicitacoesController = new controllers\solicitacoesController();

    Router::get('/',function() use ($homeController) {
        $homeController->index();
    });

    Router::get('/me',function() use ($perfilController) {
        $perfilController->index();
    });

    Router::get('/comunidade',function() use ($comunidadeController) {
        $comunidadeController->index();
    });

    Router::get('/solicitacoes',function() use ($solicitacoesController) {
        $solicitacoesController->index();
    });
    
?>

