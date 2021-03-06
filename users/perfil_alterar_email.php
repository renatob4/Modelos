<?php
    // ========================================
    // PERFIL - ALTERAR EMAIL
    // ========================================

    // verificar a sessão
    if(!isset($_SESSION['a'])){
        exit();
    }

    //define o erro
    $erro = false;
    $sucesso = false;
    $mensagem = '';

    //verifica se foi feito post
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        
        //busca o valor inseridos nos inputs
        $novo_email = $_POST['text_novo_email'];

        $gestor = new cl_gestorBD();

        // verifica se o novo email esta a ser utilizado por outro usuário
        $parametros = [
            ':cd_login'    => $_SESSION['cd_login'],
            ':ds_email'    =>  $novo_email
        ];
        $dados = $gestor->EXE_QUERY(
            'SELECT cd_login, ds_email FROM tab_user
             WHERE cd_login <> :cd_login
             AND ds_email = :ds_email', $parametros);

        if(count($dados) != 0){
            //Outro utilizador com o mesmo email
            $erro = true;
            $mensagem = 'Já existe outro Sócio com o mesmo email.';
        }
       
        // atualizar o email na base     
        if(!$erro){
            
            $data_atualizacao = new DateTime();
            $parametros = [
                ':cd_login'    => $_SESSION['cd_login'],
                ':ds_email'    => $novo_email,
                ':dt_updated'  => $data_atualizacao->format('Y-m-d H:i:s')
            ];
            $gestor->EXE_NON_QUERY(
                'UPDATE tab_user SET
                 ds_email = :ds_email,
                 dt_updated = :dt_updated 
                 WHERE cd_login = :cd_login          
                ', $parametros);
            
            $sucesso = true;
            $mensagem = 'Email atualizado com sucesso.';

            //Atualiza o email exibido na pagina
            $_SESSION['ds_email'] = $novo_email;

            //LOG
            funcoes::CriarLOG('Utilizador '.$_SESSION['cd_login'].': alterou o seu Email.',$_SESSION['nm_user']);
        }
    }
?>

<!--________________________________________________________________________ HTML ____________________________________________________________________________-->

<?php if($erro) : ?>
    <div class="alert alert-danger text-center shadow mr-1 ml-1 mt-2">
        <?php echo $mensagem ?>
    </div>
<?php endif; ?>

<?php if($sucesso) : ?>
    <div class="alert alert-success text-center shadow mr-1 ml-1 mt-2">
        <?php echo $mensagem ?>
    </div>
<?php endif; ?>

<div class="container p-0">
    <div class="row mr-1 ml-1 mt-2 borda-painel shadow">
        <div class="col card">
            <h5 class="text-center mt-3">ALTERAR E-MAIL DA CONTA</h5>
            <hr class="mt-2"><div id="green"><strong>EMAIL ATUAL:</strong> </div><label id="black"><?php echo $_SESSION['ds_email'] ?></label><hr class="mt-2">
            <!-- formulário -->
            <form action="?a=perfil_alterar_email" method="post">
                <div class="col-sm-4 offset-sm-4 justify-content-center">
                    <div class="form-group">
                        <label><i id="grey" class="fas fa-at mr-2"></i><b>Novo e-mail:</b></label>
                        <input type="email" class="form-control shadow" name="text_novo_email" title="No mínimo 5 e no máximo 50 caracteres." pattern=".{5,50}" required>
                    </div>
                </div>
                <div class="text-center mb-3">
                    <a href="?a=home" class="btn btn-primary shadow">Voltar</a>
                    <button role="submit" class="btn btn-primary shadow">Alterar</button>                    
                </div>
            </form>
        </div>        
    </div>
</div>