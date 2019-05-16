Gerar chave ssh

    ssh-keygen -t rsa

Salvar como:

    ~/.ssh/gitlab_rsa

Manter senha em branco

Criar o arquivo ~/.ssh/config com o conteudo:

    Host gitlab.com
    HostName gitlab.com
    IdentityFile ~/.ssh/gitlab_rsa
    IdentitiesOnly yes

Alterar permissoes para 600 no ~/.ssh/config

    chmod 600 ~/.ssh/config

Pegar o conteudo de ~/.ssh/gitlab_rsa.pub e cadastrar no gitlab
    
    cat ~/.ssh/gitlab_rsa.pub

Criar o arquivo de hook.php

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

    
Clonar em um diretorio já existente:

    git init
    git remote add origin URL_DO_GIT
    git fetch
    git reset --hard origin/master #origin/dev
    git branch --set-upstream-to=origin/master master #origin/dev master
    git pull
    
Caso problemas com permissão no server, verificar umask:

    umask 022