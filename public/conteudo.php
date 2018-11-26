<?php
    //verificar a sessão.
    if(!isset($_SESSION['a'])){
        exit();
    }

    //Instancia do banco de dados.
    $acesso = new cl_gestorBD();

     //Pega o codigo do card na URL
     $cd_card = $_GET['card'];

     //pesquisa se existe card com esse codigo na base
     $parametros = [
         ':cd_card'   =>  $cd_card
     ];
     $card = $acesso->EXE_QUERY('SELECT * FROM tab_card WHERE cd_card = :cd_card', $parametros);
     
     //Se não existir card de mesmo codigo na base ele encerra.
     if(count($card) == 0){
         header("Location:?a=home");
         exit();
     }
?>

<div class="row borda-painel">
    <div class="col p-0">
        <div class="card p-5">
            <div><h5 class="text-right" id="grey"><?php echo $card[0]['dt_updated']?></h5><h4 class="text-center"><?php echo $card[0]['ds_title']?></h4></div>
            <div class="card text-center p-3 m-3 mb-5"><p><?php echo $card[0]['ds_content']?></p></div>
        </div>
    </div>
</div>

<?php if(funcoes::VerificarLogin()):?>
    <div class="row mt-5">
        <div class="col p-0">
            <div class="card painel-direito p-3">
                <h5 id="black" class="text-left">Edite as informações do conteúdo acima:</h5>
                <form action="?a=card_editar&card=<?php echo $card[0]['cd_card']?>" method="POST">
                    <div class="form-goup mt-2">
                        <label><b>Título:</b></label>
                        <input type="text" name="cardtext_titulo" class="form-control" value="<?php echo $card[0]['ds_title']?>">
                    </div>
                    <div class="form-goup mt-2">
                        <label><b>Conteúdo:</b></label>
                        <textarea type="text" 
                                  name="cardtext_content" 
                                  class="form-control" 
                                  rows="10" ><?php echo $card[0]['ds_content']?></textarea>
                    </div>  
                    <div class="text-right p-0 mr-0 mt-2">
                        <button type="submit" class="btn btn-success borda-painel">Aplicar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endif;?>