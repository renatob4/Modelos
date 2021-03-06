<?php
    //verificar a sessão.
    if (!isset($_SESSION['a'])) {
        exit();
    }
    //Instancia do banco de dados.
    $acesso = new cl_gestorBD();
    //busca o conteúdo da pagina no banco de dados.
    $conteudo = $acesso->EXE_QUERY('SELECT ds_presentation, cd_phone_1, cd_phone_2, lnk_map FROM tab_content');
    $card = $acesso->EXE_QUERY('SELECT * FROM tab_card');
    $post = $acesso->EXE_QUERY('SELECT * FROM tab_post');
    $img = $acesso->EXE_QUERY('SELECT img_panel, img_body FROM tab_imagem');
    $code = $acesso->EXE_QUERY('SELECT * FROM tab_code');
    $config = $acesso->EXE_QUERY('SELECT st_map, st_contact, st_map, st_card, st_post, st_comment FROM tab_config');
?>
<!-- Imagem de apresentação do site -->
<div class="row mt-0 mr-1 ml-1 mt-2">
    
        <img class="img-fluid imagem-painel shadow-strong" src="<?php echo $img[0]['img_panel']?>">
    
    <?php if (funcoes::VerificarLogin()):?>
    <div>
        <form class="p-0 m-0 mt-2" action="?a=recebe_imagem&sender=panel" method="post" enctype="multipart/form-data">
            <label class="p-0 m-0">
                <strong><i id="grey" class="fas fa-image mr-1 ml-1"></i>
                    <a data-toggle="collapse" href="#collapseInputP" id="green" role="button" aria-expanded="false" aria-controls="collapseExample" title="Alterar imagem">Alterar imagem</a>
                    <label class="ml-1 file" id="grey">(Ideal: 1300x600)</label>
                </strong>
            </label>
            <div class="collapse" id="collapseInputP">
                <input class="btn btn-warning file p-0" name="arquivo" type="file" accept="image/*">
                <input class="btn btn-success file m-0 p-1" type="submit" value="Enviar">
            </div>
        </form>
    </div>
    <?php endif;?>
</div>
<article>
    <!-- Apresentação da empresa, texto. -->
    <hr class="mt-2 mb-2">
    <div class="row mr-1 ml-1 pt-0">
        <?php if(($config[0]['st_map'] == 1 || $config[0]['st_contact'] == 1) && ($conteudo[0]['lnk_map'] != '' || $config[0]['st_contact'] == 1)):?>
        <div class="col-md-7 p-0">
        <?php else:?>
        <div class="col p-0">
        <?php endif;?>
            <div class="text-center pt-3 pr-3 pl-3 pb-0">
                <h4 class="mb-2 txt-shadow">APRESENTAÇÃO</h4>
                <!-- Dados contidos no campo 'ds_presentation' do banco de dados -->
                <p class="wrap mb-2"><?php echo $conteudo[0]['ds_presentation']?></p>
                <!-- Mostra a imagem no corpo da apresentação se ela existir -->
                <?php if ($img[0]['img_body'] != ''):?>
                
                    <img class="img-fluid shadow-strong mt-2" src="<?php echo $img[0]['img_body']?>">
                
                <?php endif;?>
                <?php if (funcoes::VerificarLogin()):?>
                <div class="row mt-2 mb-0">
                    <div class="col p-0 text-left mt-1 mb-0 pl-2">
                        <form class="p-0 m-0" action="?a=recebe_imagem&sender=body" method="post" enctype="multipart/form-data">
                            <label class="p-0 m-0">
                                <strong><i id="grey" class="fas fa-image mr-1 ml-1"></i>
                                    <a data-toggle="collapse" href="#collapseInputB" id="green" role="button" aria-expanded="false" aria-controls="collapseExample" title="Inserir Imagem">Inserir</a>
                                    <label class="ml-1 file" id="grey">(Ideal: 960x460)</label>
                                </strong>
                            </label>
                            <div class="collapse" id="collapseInputB">
                                <input class="btn btn-warning file p-0" name="arquivo" type="file" accept="image/*">
                                <input class="btn btn-success file m-0 p-1" type="submit" value="Enviar">
                            </div>
                        </form>
                    </div>
                    <?php if ($img[0]['img_body'] != ''):?>
                    <div class="col p-0 text-right mt-1 mb-0 pr-2">
                        <strong><i id="grey" class="fas fa-trash-alt mr-2"></i><a href="?a=deleta_imagem&sender=body&img=<?php echo $img[0]['img_body']?>" title="Remover Imagem">Remover</a></strong>
                    </div>
                    <?php endif;?>
                </div>
                <?php endif;?>
            </div>
        </div>
        <?php if(($config[0]['st_map'] == 1 || $config[0]['st_contact'] == 1) && ($conteudo[0]['lnk_map'] != '' || $config[0]['st_contact'] == 1)):?>
        <div class="col-md-5 p-0">
        <?php else:?>
        <div>
        <?php endif;?>
        <?php if($config[0]['st_contact'] == 1):?>
        <!-- Painel rapido de contatos telefonicos -->
        <div class="card painel-direito text-center p-2 pt-3 mt-2 mb-0 borda-painel shadow-strong">
            <h4 id="black"><i id="white" class="fas fa-phone-square mr-2"></i>Fale conosco:</h4>
            <div class="flex-media">
                <div class="card m-2 pt-4 pb-3 pr-0 borda-painel">
                    <label><label class="mb-0" id="black"><i id="grey" class="fas fa-phone mr-2"></i>Contato:</label> <?php echo funcoes::FormataTelefone($conteudo[0]['cd_phone_1'])?></label>
                    <?php if ($conteudo[0]['cd_phone_2'] != ''):?>
                    <label><label id="black"><i id="grey" class="fab fa-whatsapp mr-2"></i>Ou:</label> <?php echo funcoes::FormataTelefone($conteudo[0]['cd_phone_2'])?></label>
                    <?php endif;?>
                </div>
            </div>
            <div class="text-center mt-2"><p id="white"><i class="fas fa-envelope ml-2 mr-1"></i>Ou envie um e-mail direto <a href="?a=contatos" title="Página com nossos contatos">Aqui</a></p></div>
        </div>
        <?php endif;?>
        <?php if ($conteudo[0]['lnk_map'] != '' && $config[0]['st_map'] == 1):?>
        <!-- Painel rapido de localização/mapa -->
        <div class="card painel-direito text-center p-2 pt-3 mt-3 mb-2 borda-painel shadow-strong">
            <h4 id="black"><i id="white" class="fas fa-map-marked mr-2"></i>Nos encontre:</h4>
            <div class="card mt-2">
                <!-- iframe do mapa -->
                <?php echo $conteudo[0]['lnk_map'];?>
            </div>
        </div>
        <?php endif;?>
        </div>
    </div>
    <?php if($config[0]['st_card'] == 1):?>
    <hr class="mt-3 mb-0">
    <!-- Cards de texto -->
    <div class="row">
        <?php for ($i = 0; $i <= count($card)-1; $i++):?>
        <!-- CARD-->
        <?php if (count($card) >= 3):?>
        <div class="col-md-4 col-sm-6 col-xs-12">
        <?php elseif (count($card) == 2):?>
        <div class="col-md-6 col-sm-6 col-xs-12">
        <?php else:?>
        <div class="col-md-12 col-sm-6 col-xs-12">
        <?php endif;?>
        <div class="panel panel-default text-center espaco-paineis shadow-strong">
            <!-- Titulo carregado direto da base de dados -->
            <p class="titulo-painel wrap mb-0"><i id="gold" class="fas fa-star mr-2"></i><?php echo $card[$i]['ds_title']?></p>
            <!-- Conteúdo carregado direto da base de dados -->
            
                <img class="img-fluid alturamax mt-2 mb-2 " src="<?php echo $card[$i]['img_front_card']?>">
            
            <?php if($card[$i]['img_front_card'] == ''): ?>
            <div class="conteudo-baixo wrap mb-3"><div><?php echo substr($card[$i]['ds_content'], 0, 192)?></div></div>
            <?php else:?>
            <div class="mb-3"><div><?php echo substr($card[$i]['ds_content'], 0, 192)?></div></div>
            <?php endif;?>
            <div class="text-center p-0 ml-0">
                <?php if (funcoes::VerificarLogin()):?>
                <a href="#edit<?php echo $card[$i]['cd_card']?>" class="btn btn-outline-success p-2 mr-1" data-toggle="collapse" role="button" aria-expanded="false" title="Editar informações do card"><i class="fas fa-edit mr-1"></i>Edit</a>                    
                <a href="?a=conteudo&card=<?php echo $card[$i]['cd_card']?>" class="btn btn-primary p-2" title="Texto na integra."><i class="fas fa-plus-square mr-2"></i>Mais</a>
                <a href="?a=card_deletar&card=<?php echo $card[$i]['cd_card']?>" class="btn btn-outline-danger p-2 ml-1" title="Apagar card."><i class="fas fa-trash mr-1"></i>Del</a>
                <div class="collapse" id="edit<?php echo $card[$i]['cd_card']?>"><hr>
                    <div class="text-left">
                        <form action="?a=card_editar&card=<?php echo $card[$i]['cd_card']?>" method="POST">
                            <div class="form-goup mt-2">
                                <label><b>Título:</b></label>
                                <input type="text" name="card_text_titulo" class="form-control" maxlength="50" value="<?php echo $card[$i]['ds_title']?>" required>
                            </div>
                            <div class="form-goup mt-2">
                                <label><b>Conteúdo:</b></label>
                                <textarea type="text" name="card_text_content" class="form-control" rows="3" required><?php echo $card[$i]['ds_content']?></textarea>
                            </div>
                            <div class="text-center p-0 mr-0 mt-2"><button type="submit" class="btn btn-success">Aplicar</button></div>
                        </form>
                        <div class="row mt-2 mb-0 pr-3 pl-3 pt-1">
                            <div class="col p-0 text-left mt-1 mb-0 pl-0">
                                <form class="p-0 m-0" action="?a=conteudo&card=<?php echo $card[$i]['cd_card'];?>&flag=true" method="post" enctype="multipart/form-data">
                                    <label class="p-0 m-0">
                                        <strong><i id="grey" class="fas fa-image mr-1 ml-1"></i>
                                            <a data-toggle="collapse" href="#<?php echo $card[$i]['cd_card'];?>" id="green" role="button" aria-expanded="false" aria-controls="collapseInputG" title="Inserir Imagem">Inserir</a>
                                        </strong>
                                    </label>
                                    <div class="collapse" id="<?php echo $card[$i]['cd_card'];?>">
                                        <input class="btn btn-warning file2 p-1" name="arquivo" type="file" accept="image/*">
                                        <input class="btn btn-success file2 m-0 p-2" type="submit" value="Enviar">
                                    </div>
                                </form>
                            </div>
                            <?php if($card[$i]['img_front_card'] != ''):?>
                            <div class="col p-0 text-right mt-1 mb-0">
                                <strong><i id="grey" class="fas fa-trash-alt mr-2"></i><a href="?a=deleta_imagem&sender=card&img=<?php echo $card[$i]['img_front_card']?>&flag=true" title="Remover imagem.">Remover</a></strong>
                            </div>
                            <?php endif;?>
                        </div>
                    </div>
                </div>
            <?php else :?>
            <a href="?a=conteudo&card=<?php echo $card[$i]['cd_card']?>" class="btn btn-primary p-2" title="Texto na Integra."><i class="fas fa-plus-square mr-2"></i>Saiba mais</a>
            <?php endif;?>
            </div>
        </div>
        </div>
        <?php endfor;?>
        </div>
        <!-- Botão para adição de novos cards, limitados a quantidade maxima de 6. -->
        <?php if (funcoes::VerificarLogin()):?>
        <?php if (count($card) < 6):?>
        <div class="row text-right p-0 mt-2">
            <div class="col">
                <a href="?a=card_inserir" class="btn btn-success text-center shadow mt-2" title="Inserir novo card.">Adicinar novo card<i class="fas fa-plus-square mr-2 ml-2"></i></a>                   
            </div>
        </div>
        <?php else:?>
        <div class="row text-right p-0 mt-2 ">
            <div class="col">
                Obs. Ja está no limite de <strong>6</strong> Cards.          
            </div>
        </div>
        <?php endif; ?>
        <?php endif;?>
    <?php endif;?>
    <!-- Noticias/Microforum -->
    <?php if($config[0]['st_post'] == 1):?>
        <?php if (count($post) > 0):?>
        <hr>
        <div class="row borda-painel m-0 shadow-strong">
            <div class="col p-0">
                <div class="card painel-direito"><div id="black" class="text-center mt-3 mb-2"><h5><i id="green" class="fas fa-comments mr-2"></i><label>NOTÍCIAS RECENTES</label></h5></div>
                    <?php for ($x = 0; $x < count($post); $x++):?>
                    <!-- Corpo da noticia -->
                    <div class="card text-left p-0 m-2">
                        <div class="p-2">
                            <div class="row p-0">
                                <div id="black" class="col-sm-6 text-left m-0"><h6><i id="green" class="fas fa-flag mr-2"></i><?php echo $post[$x]['ds_title']?> | <label id="grey"><?php echo $post[$x]['nm_autor']?> </label>                                
                                <?php if (funcoes::VerificarLogin()):?>
                                <a class="ml-3" href="?a=post_editar&post=<?php echo $post[$x]['cd_post']?>" title="Editar Postagem.">Editar</a> | <a href="?a=post_deletar&post=<?php echo $post[$x]['cd_post']?>" title="Apagar Postagem.">Apagar</a>
                                <?php endif;?></h6></div>                    
                                <div id="grey" class="col text-right mr-1"><h6><i class="far fa-clock mr-2"></i><?php echo $post[$x]['dt_register']?></h6></div>                               
                            </div><hr class="mb-1 mt-0">
                            <p class="wrap"><?php echo $post[$x]['ds_content']?></p>
                        </div>
                    </div>
                    <?php endfor;?>
                </div>
            </div>
        </div>
        <?php endif;?>
        <!-- Form para postar noticias -->
        <?php if (funcoes::VerificarLogin()):?>
        <hr class="mb-2"><form class="p-0 mb-0" method="POST" action="?a=post_inserir">
            <div class="form-row">
                <div class="col-md-8 mt-1">
                    <label><b><i class="fas fa-star mr-2"></i>Título:</b></label>
                    <input type="text" name="post_text_titulo" maxlength="30" class="form-control shadow" required>
                </div>
                <div class="col-md-4 mt-1">
                    <label><b><i class="fas fa-user mr-2"></i>Autor:</b></label>
                    <input type="text" name="post_text_autor" maxlength="22" class="form-control shadow" value="<?php echo $_SESSION['nm_user']?>" required>
                </div>
            </div>
            <div class="form-goup mt-2">
                <label><b><i class="fas fa-file-alt mr-2"></i>Conteúdo:</b></label>
                <textarea type="text" name="post_text_content" maxlength="254" class="form-control shadow" rows="3" required></textarea>
            </div>
            <div class="text-right p-0 mr-0 mt-3"><button type="submit" class="btn btn-success shadow">Postar<i class="fas fa-plus-square mr-2 ml-2"></i></button></div>
        </form>
        <?php endif;?>
    <?php endif;?>
</article>
<?php if($config[0]['st_comment'] == 1 && $code[0]['lnk_script'] != ''):?>
<!-- Comentarios do facebook -->
<hr class="bordahr">
<div class="row mt-3 m-1 p-0">
    <div class="col p-0 m-0">
        <div class="fb-comments" data-href="<?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"?>" data-width="100%" data-numposts="6"></div>
    </div>
</div>
<?php endif;?>