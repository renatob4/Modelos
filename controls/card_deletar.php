<?php
    //verificar a sessão.
    if(!isset($_SESSION['a'])){
        exit();
    }
    //verifica se existe card definido
    if(!isset($_GET['card'])){
        //header("Location:?a=home");
        echo('<meta http-equiv="refresh" content="0;URL=?a=home">');
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
    $result = $acesso->EXE_QUERY('SELECT cd_card, img_front_card, img_card FROM tab_card WHERE cd_card = :cd_card', $parametros);
    
    //Se não existir card de mesmo codigo na base ele encerra.
    if(count($result) == 0){
        exit();
    }

    if($result[0]['img_front_card'] != '')
        unlink("./".$result[0]['img_front_card']);
    if($result[0]['img_card'] != '')
        unlink("./".$result[0]['img_card']);
    
    //Atualizar os dados no card no banco
    $parametros = [
        ':cd_card'      =>  $cd_card
    ];  
    //Atualizar a DB
    $acesso->EXE_NON_QUERY('DELETE FROM tab_card WHERE cd_card = :cd_card', $parametros);

    //Log
    funcoes::CriarLOG('Card de conteúdo removido.', $_SESSION['nm_user']);

    //header("Location:?a=home");
    echo('<meta http-equiv="refresh" content="0;URL=?a=home">');
    exit();
?>