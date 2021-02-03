<div class="box__content">

    <h2><i class="fas fa-balance-scale"></i> Cadastrar Produto</h2>

    <form method="post" enctype="multipart/form-data">

    <?php
        if(isset($_POST['acao'])){
            $nome = $_POST['nome'];
            $descricao = $_POST['descricao'];
            $largura = $_POST['largura'];
            $altura = $_POST['altura'];
            $comprimento = $_POST['comprimento'];
            $peso = $_POST['peso'];
            $preco = Painel::formatarMoedaBd($_POST['valor']);
            $quantidade = $_POST['quantidade'];

            $imagens = array();
            $amountFiles = count($_FILES['imagem']['name']);

            $sucesso = true;
            $image = true;

            if($_FILES['imagem']['name'][0] != ''){
                for($i = 0; $i < $amountFiles; $i++){
                    $imagemAtual = ['type'=>$_FILES['imagem']['type'][$i],
                    'size'=>$_FILES['imagem']['size'][$i]];
                    if(Painel::imagemValida($imagemAtual) == false){
                        $sucesso = false;
                        Painel::alert('erro','Uma das imagens selecionadas não são inválidas!');
                        break;
                    }
                }
            }else{ 
                $image = false;
            }

            if($sucesso){
                //register information, images and upload.
                for($i = 0; $i < $amountFiles; $i++){
                    $imagemAtual = ['tmp_name'=>$_FILES['imagem']['tmp_name'][$i],
                    'name'=>$_FILES['imagem']['name'][$i]];
                    $imagens[] = Painel::uploadFile($imagemAtual);
                }
                
                $sql = MySql::conectar()->prepare("INSERT INTO `tb_admin.estoque` VALUE (null,?,?,?,?,?,?,?,?)");
                $sql->execute(array($nome,$descricao,$largura,$altura,$comprimento,$peso,$preco,$quantidade));
                $lastId = MySql::conectar()->lastInsertId();

                if($sucesso & $image){
                    foreach($imagens as $key => $value){
                        MySql::conectar()->exec("INSERT INTO `tb_admin.estoque_imagens` VALUES (null,$lastId,'$value')");
                    }
                }
                Painel::alert('sucesso','O produto foi cadastrado com sucesso!');
            }
        }
    ?>

        <div class="form__group">
            <label>Nome do produto:</label>
            <input type="text" name="nome">
        </div><!--form__group-->

        <div class="form__group">
            <label>Descrição do produto:</label>
            <textarea class="tinymce" name="descricao"></textarea>
        </div><!--form__group-->

        <div class="form__group">
            <label>Largura do produto:</label>
            <input type="number" name="largura" min="0" max="900" step="1" value="0">
        </div><!--form__group-->

        <div class="form__group">
            <label>Altura do produto:</label>
            <input type="number" name="altura" min="0" max="900" step="1" value="0">
        </div><!--form__group-->

        <div class="form__group">
            <label>Comprimento do produto:</label>
            <input type="number" name="comprimento" min="0" max="900" step="1" value="0">
        </div><!--form__group-->

        <div class="form__group">
            <label>Peso:</label>
            <input type="number" name="peso" min="0" max="900" step="1" value="0">
        </div><!--form__group-->

        <div class="form__group">
            <label>Preço:</label>
            <input type="text" name="valor">
        </div><!--form__group-->

        <div class="form__group">
            <label>Quantidade atual do produto:</label>
            <input type="number" name="quantidade" min="0" max="900" step="1" value="0">
        </div><!--form__group-->

        <div class="form__group">
            <label>Selecione as imagens:</label>
            <input multiple type="file" name="imagem[]">
        </div><!--form__group-->

        <input type="submit" name="acao" value="Cadastrar Produto!">

    </form>

</div><!--box__content-->