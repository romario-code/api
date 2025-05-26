<?php

$template_diretorio = get_template_directory();

require_once($template_diretorio . "/custom-post-type/produto.php");
require_once($template_diretorio . '/custom-post-type/transacao.php');

require_once($template_diretorio . '/enpoints/usuario-post.php');
require_once($template_diretorio . '/enpoints/usuario-get.php');

function expire_token() {
	return time() + (60 * 60 * 24);
}

add_action('jwt_auth_expire', 'expire_token');