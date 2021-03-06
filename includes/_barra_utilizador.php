<?php
    // ==========================================================
    // Barra do utilizador
    // ==========================================================
    //verificar a sessão.
    if(!isset($_SESSION['a'])){
        exit();
    }
    
    $classe = 'barra_utilizador_inativo';
    //vefifica se existe login ativo
    if(funcoes::VerificarLogin()){
        $nome_utilizador = $_SESSION['nm_user'];
        $classe = 'barra_utilizador_ativo';
    }

    //Instancia do banco de dados.
    $acesso = new cl_gestorBD();
    
    //busca o conteúdo da pagina no banco de dados.
    //$prospects = $acesso->EXE_QUERY('SELECT * FROM tab_prospect');
    //$conteudo = $acesso->EXE_QUERY('SELECT * FROM tab_content');
    $config = $acesso->EXE_QUERY('SELECT st_product, st_service, st_promotion FROM tab_config');
    $code = $acesso->EXE_QUERY('SELECT lnk_script, id_app FROM tab_code');
?>
<div class="barra_utilizador navbar-fixed-top">
    <nav class="navbar navbar-expand-sm p-0 mr-2 ml-1">
        <button class="navbar-toggler navbar navbar-dark border-none ml-3 m-1" type="button" data-toggle="collapse" data-target="#navprimary" aria-controls="navprimary" aria-expanded="true" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-brand pt-0 mr-0 ml-3">
            <?php if(funcoes::VerificarLogin()):?>
            <div class="navbar-brand dropdown m-0 mt-1">
                <span class="mr-2"><i id="green" class="fa fa-user mr-2"></i><?php echo $nome_utilizador?></span>
                <button class="btn btn-secondary dropdown-toggle mr-1 shadow" type="button" id="d1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog"></i></button>
                <div class="dropdown-menu shadow-strong" aria-labelledby="d1">
                    <div class="text-center"><a class="dropdown-item" href="?a=configuracoes" title="Página de configuração de conteúdo."><strong>Configurações</strong></a></div>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="?a=promocoes_config" title="Página de configuração de promoções."><i id="green" class="fas fa-percentage mr-2"></i>Cfg Promoções</a>
                    <a class="dropdown-item" href="?a=prospects" title="Página de clientes prováveis."><i id="green" class="fas fa-chart-line mr-2"></i>Prospects</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="?a=perfil_alterar_login" title="Página de alteração de login/ID."><i id="green" class="fas fa-id-badge mr-2"></i>Alterar Login</a>
                    <a class="dropdown-item" href="?a=perfil_alterar_senha" title="Página de alteração de senha."><i id="green" class="fas fa-key mr-2"></i>Alterar Senha</a>
                    <a class="dropdown-item" href="?a=perfil_alterar_email" title="Página de alteração de email."><i id="green" class="fas fa-at mr-2"></i>Alterar Email</a>
                    <div class="dropdown-divider"></div>
                    <div class="text-center"><a class="dropdown-item" href="?a=logout" title="Sair do sistema."><strong>Logout</strong></a></div>
                </div>
            </div>
            <?php else:?>
            <div class="p-2"><span class="<?php echo $classe ?>"><i class="fa fa-user"></i> Entrar | <a href="?a=login" class="mr-1" title="Fazer login como administrador do site."><i class="fas fa-sign-in-alt"></i>Login</a></span></div>
            <?php endif;?>
        </div>
        <div class="collapse navbar-collapse p-0 textm" id="navprimary">
            <hr class="mt-1 mb-1" style="border: 0.5px solid white;">
            <ul class="navbar-nav ml-auto mr-2">
                <li class="nav-item mt-2 mb-2 p-0"><a id="it1" href="?a=home" class="texto-menu mr-1" title="Página principal."><label class="mr-3 grey">|</label><i class="fas fa-home mr-1"></i></a><label class="ml-2 hider" style="opacity: 0.5;"><a href="?a=home" title="Página principal.">Página Inicial</a></label></li>
                <?php if($config[0]['st_product'] == 1):?><li class="nav-item mt-2 mb-2 p-0"><a id="it2" href="?a=produtos" class="texto-menu mr-2" title="Página de produtos."><label class="mr-3 grey">|</label><i class="fas fa-shopping-cart mr-1"></i></a><label class="ml-2 hider" style="opacity: 0.5;"><a href="?a=produtos" title="Página de produtos.">Produtos</a></label></li><?php endif;?>
                <?php if($config[0]['st_service'] == 1):?><li class="nav-item mt-2 mb-2 p-0"><a id="it3" href="?a=servicos" class="texto-menu mr-2" title="Página de serviços."><label class="mr-3 grey">|</label><i class="fas fa-wrench mr-1"></i></a><label class="ml-2 hider" style="opacity: 0.5;"><a href="?a=servicos" title="Página de serviços.">Serviços</a></label></li><?php endif;?>
                <li class="nav-item mt-2 mb-2 p-0"><a id="it4" href="?a=contatos" class="texto-menu mr-2" title="Página dos nossos contatos."><label class="mr-3 grey">|</label><i class="fas fa-phone mr-1"></i></a><label class="ml-2 hider" style="opacity: 0.5;"><a href="?a=contatos" title="Página dos nossos contatos.">Fale Conosco</a></label></li>
                <?php if($config[0]['st_promotion'] == 1 && $code[0]['lnk_script'] != '' && $code[0]['id_app'] != ''):?><li class="nav-item mt-2 mb-2"><a href="?a=promocoes" class="texto-menu mr-2" title="Nossas promoções."><label class="mr-3 grey">|</label><i class="fas fa-percentage mr-1" style="font-size: 1.1em;"></i></a><label class="ml-2 hider" style="opacity: 0.5;"><a href="?a=promocoes" title="Nossas promoções.">Promoçoes</a></label></li><?php endif;?>
            </ul>
        </div>
    </nav>
</div>