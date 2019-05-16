<?php
$token = ""; //gerar em http://passwordsgenerator.net
if(isset($_SERVER['HTTP_X_GITLAB_TOKEN']) && $_SERVER['HTTP_X_GITLAB_TOKEN'] == $token){
    $conteudoRaw = file_get_contents('php://input');
    $conteudo = json_decode($conteudoRaw, true);
    if(isset($conteudo['ref'])){
        $auxBranch = explode("/", $conteudo['ref']);
        if($auxBranch[2] == 'master'){
            `cd .. && git fetch origin && git reset --hard origin/master`;
        }elseif($auxBranch[2] == 'dev'){
            `cd ../dev && git fetch origin && git reset --hard origin/dev`;
        }
    }
}
?>
