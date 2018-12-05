<?php

   // ==========================================================
   // PERFIL - Configurações e conteúdo
   // ==========================================================

    //verificar a sessão.
    if(!isset($_SESSION['a'])){
        exit();
    }

    $erro = false;
    $mensagem = '';

    //Verifica se utilizador tem permissão
    if(!funcoes::Permissao(1)){
        $erro = true;
        $mensagem = 'Não a tem permissão necessaria para acessar essa funcionalidade';
    }

    //Vai buscar todas as informações do utilizador
    $gestor = new cl_gestorBD();
    $data = new DateTime();

    $parametros = [
        ':cd_login'    =>  $_SESSION['cd_login']
    ];

    $user = $gestor->EXE_QUERY('SELECT * FROM tab_user WHERE cd_login = :cd_login', $parametros);

    //Busca o conteúdo da base de dados. 
    $conteudo = $gestor->EXE_QUERY('SELECT * FROM tab_content');
    $link = $gestor->EXE_QUERY('SELECT * FROM tab_link');
 
    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        //Buscando os valores do form tab_content
        $empresa = $_POST['form_nm_company'];
        $apresentacao = $_POST['form_ds_presentation'];
        $email = $_POST['form_ds_email'];
        $doc = $_POST['form_ds_document'];
        $tel1 = $_POST['form_cd_tel1'];
        $tel2 = $_POST['form_cd_tel2'];
        $rodape = $_POST['form_ds_footer'];
        //Buscando os valores do form tab_link
        $face = $_POST['form_lnk_face'];
        $twitter = $_POST['form_lnk_twit'];
        $linkedin = $_POST['form_lnk_link'];
        $instagram = $_POST['form_lnk_inst'];
        $olx = $_POST['form_lnk_olx'];
        $market = $_POST['form_lnk_mark'];

        //Atualiza a base de dados TAB_CONTENT =====================================
        $parametros = [
            ':cd_info'          => $conteudo[0]['cd_info'],
            ':nm_company'       => $empresa,
            ':ds_presentation'  => $apresentacao,
            ':ds_email'         => $email,
            ':ds_document'      => $doc,
            ':cd_phone_1'       => $tel1,
            ':cd_phone_2'       => $tel2,
            ':ds_text_footer'   => $rodape,
            ':dt_updated'       => $data->format('Y-m-d H:i:s')
        ];
        $gestor->EXE_NON_QUERY(
            'UPDATE tab_content SET
             nm_company = :nm_company,
             ds_presentation = :ds_presentation, 
             ds_email = :ds_email, 
             ds_document = :ds_document, 
             cd_phone_1 = :cd_phone_1, 
             cd_phone_2 = :cd_phone_2,
             ds_text_footer = :ds_text_footer,  
             dt_updated = :dt_updated 
             WHERE cd_info = :cd_info', $parametros);

        //Atualiza a base de dados TAB_LINK =======================================
        $parametros = [
            ':cd_link'          => $link[0]['cd_link'],
            ':ds_link_face'     => $face,
            ':ds_link_twit'     => $twitter,
            ':ds_link_linked'   => $linkedin,
            ':ds_link_insta'    => $instagram,
            ':ds_link_olx'      => $olx,
            ':ds_link_market'   => $market,
            ':dt_updated'       => $data->format('Y-m-d H:i:s')
        ];
        $gestor->EXE_NON_QUERY(
            'UPDATE tab_link SET
             ds_link_face = :ds_link_face,
             ds_link_twit = :ds_link_twit, 
             ds_link_linked = :ds_link_linked, 
             ds_link_insta = :ds_link_insta, 
             ds_link_olx = :ds_link_olx,
             ds_link_market = :ds_link_market,    
             dt_updated = :dt_updated 
             WHERE cd_link = :cd_link', $parametros);
 
        //Redirecionar
        header("Location:?a=configuracoes");
    }

?>

<?php if($erro) :?>

    <div class="text-center m-3">
        <h3><?php echo $mensagem ?></h3>
        <a href="?a=home" class="btn btn-primary btn-size-150">Voltar</a>
    </div>

<?php else : ?>
    <div class="container m-0 p-0">
        <div class="row">
            <div class="col card p-3">
                <div class="card p-3 borda-painel">
                    <h5 id="green" class="text-center">PERFIL DE UTILIZADOR</h5>
                    <!--DADOS DO UTILIZADOR-->
                    <h5 class="mb-5 mt-3"><i class="fa fa-user mr-2" aria-hidden="true"></i><?php echo $user[0]['nm_user']?></h5>
                    <h5 class="mb-3"><i class="far fa-id-badge mr-2" aria-hidden="true"></i>Login:  <label id="grey"><?php echo $user[0]['cd_login']?></label><a href="?a=perfil_alterar_login" class="btn btn-outline-success m-0 ml-3"><i class="fas fa-edit"></i></a></h5>
                    <h5 class="mb-3"><i class="fa fa-key mr-2" aria-hidden="true"></i>Senha:  <label id="grey"><?php echo str_repeat("*", 6)?></label><a href="?a=perfil_alterar_senha" class="btn btn-outline-success m-0 ml-3"><i class="fas fa-edit"></i></a></h5>  
                    <h5 class="mb-3"><i class="fa fa-envelope mr-2" aria-hidden="true"></i>Email:  <label id="grey"><?php echo $user[0]['ds_email']?></label><a href="?a=perfil_alterar_email" class="btn btn-outline-success m-0 ml-3"><i class="fas fa-edit"></i></a></h5>
                </div>
                <!-- Formulario para edição do conteudo do site -->
                <div class="card p-3 mt-3 borda-painel">
                    <div class="text-left">
                        <h5 id="green" class="text-center mb-5">GERENCIAR CONTEÚDO</h5>
                        <form method="POST" action="?a=configuracoes">
                            <div class="form-row">
                                <div class="col-md-6 mt-1">
                                    <label><b><i class="fas fa-building mr-2"></i>Nome/Apelido da Empresa:</b></label>
                                    <input type="text" name="form_nm_company" class="form-control" value="<?php echo $conteudo[0]['nm_company']?>" required>
                                </div>
                                <div class="col-md-6 mt-1">
                                    <label><b><i class="fas fa-passport mr-2"></i>DOC/CNPJ:</b></label>
                                    <input type="text" name="form_ds_document" class="form-control" value="<?php echo $conteudo[0]['ds_document']?>">
                                    <label class="Obs mt-1"><i class="fas fa-exclamation-circle mr-2"></i>Obs. Deixe este campo em branco se não quiser que ele apareça no Site.</label>
                                </div>                      
                            </div>
                            <div class="form-goup mt-4">
                                <label><b><i class="fas fa-file-alt mr-2"></i>Apresentação:</b></label>
                                <textarea type="text" name="form_ds_presentation" class="form-control" rows="6" required><?php echo $conteudo[0]['ds_presentation']?></textarea>
                            </div>
                            <div class="form-row mt-4">
                                <div class="col-md-6 mt-1">
                                    <label><b><i class="fas fa-phone-square mr-2"></i>Telefone 1:</b></label>
                                    <input type="tel" name="form_cd_tel1" class="form-control" value="<?php echo $conteudo[0]['cd_phone_1']?>" required>
                                </div>
                                <div class="col-md-6 mt-1">
                                    <label><b><i class="fab fa-whatsapp mr-2"></i>Telefone 2:</b></label>
                                    <input type="tel" name="form_cd_tel2" class="form-control" value="<?php echo $conteudo[0]['cd_phone_2']?>">
                                    <label class="Obs mt-1"><i class="fas fa-exclamation-circle mr-2"></i>Obs. Deixe este campo em branco se não quiser que ele apareça no Site.</label>
                                </div>                      
                            </div>
                            <div class="form-goup mt-4">
                                <label><b><i class="fas fa-at mr-2"></i>E-mail:</b></label>
                                <input type="email" name="form_ds_email" class="form-control" value="<?php echo $conteudo[0]['ds_email']?>" required>
                            </div>
                            <div class="form-goup mt-4">
                                <label><b><i class="fas fa-book mr-2"></i>Texto do rodapé:</b></label>
                                <textarea type="text" name="form_ds_footer" class="form-control" rows="3" required><?php echo $conteudo[0]['ds_text_footer']?></textarea>
                            </div>

                            <hr class="m-"><h5 id="green" class="text-center mb-5">GERENCIAR LINKS</h5>

                            <div class="form-group row pr-3">
                                <label class="col-sm-2 col-form-label p-0 ml-3"><b><i class="fab fa-facebook-square mr-2"></i>Facebook:</b></label>
                                <div class="col">
                                    <input type="text" name="form_lnk_face" class="form-control p-0 ml-3" value="<?php echo $link[0]['ds_link_face']?>">
                                </div>
                            </div>
                            <div class="form-group row pr-3">
                                <label class="col-sm-2 col-form-label p-0 ml-3"><b><i class="fab fa-twitter-square mr-2"></i>Twitter:</b></label>
                                <div class="col">
                                    <input type="text" name="form_lnk_twit" class="form-control p-0 ml-3" value="<?php echo $link[0]['ds_link_twit']?>">
                                </div>
                            </div>
                            <div class="form-group row pr-3">
                                <label class="col-sm-2 col-form-label p-0 ml-3"><b><i class="fab fa-linkedin mr-2"></i>LinkedIn:</b></label>
                                <div class="col">
                                    <input type="text" name="form_lnk_link" class="form-control p-0 ml-3" value="<?php echo $link[0]['ds_link_linked']?>">
                                </div>
                            </div>
                            <div class="form-group row pr-3">
                                <label class="col-sm-2 col-form-label p-0 ml-3"><b><i class="fab fa-instagram mr-2"></i>Instagram:</b></label>
                                <div class="col">
                                    <input type="text" name="form_lnk_inst" class="form-control p-0 ml-3" value="<?php echo $link[0]['ds_link_insta']?>">
                                </div>
                            </div>
                            <div class="form-group row pr-3">
                                <label class="col-sm-2 col-form-label p-0 ml-3"><b><i class="far fa-handshake mr-2"></i>OLX:</b></label>
                                <div class="col">
                                    <input type="text" name="form_lnk_olx" class="form-control p-0 ml-3" value="<?php echo $link[0]['ds_link_olx']?>">
                                </div>
                            </div>
                            <div class="form-group row pr-3">
                                <label class="col-sm-2 col-form-label p-0 ml-3"><b><i class="fas fa-shopping-cart mr-2"></i>Mercado Livre:</b></label>
                                <div class="col">
                                    <input type="text" name="form_lnk_mark" class="form-control p-0 ml-3" value="<?php echo $link[0]['ds_link_market']?>">
                                </div>
                            </div>

                            <label class="Obs mt-1"><i class="fas fa-exclamation-circle mr-2"></i>Obs. Deixe em branco os links que não quiser que apareçam no Site.</label>
                            
                            <!-- Botões voltar e aplicar alterações -->
                            <div class="text-center">
                                <hr><a href="?a=home" class="btn btn-primary btn-size-150 m-2"><i class="fas fa-arrow-circle-left mr-2"></i>Voltar</a>
                                <button type="submit" class="btn btn-success">Aplicar alterações<i class="fas fa-edit ml-2"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>  
        </div>
    </div>
<?php endif;?>