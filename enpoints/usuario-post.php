<?php 

// Função retorna um array com os dados do usuário
function usuario_api_post($request) {
    $email = sanitize_email($request['email']);
    $senha = $request['senha'];
    $nome = sanitize_text_field($request['nome']);
    $cep = sanitize_text_field($request['cep']);
    $rua = sanitize_text_field($request['rua']);
    $numero = sanitize_text_field($request['numero']);
    $bairro = sanitize_text_field($request['bairro']);
    $cidade = sanitize_text_field($request['cidade']);
    $estado = sanitize_text_field($request['estado']);

    $user_exists = username_exists($email);
    $email_exists = email_exists($email);

    if(!$user_exists && !$email_exists && $email && $senha) {
      $user_id = wp_create_user($email, $senha, $email);

			$response = array(
				'ID' => $user_id,
        'display_name' => $nome,
				'first_name' => $nome,
        'role' => 'subscriber'
   	 );
		 wp_update_user($user_id);

		 update_user_meta($user_id,'cep', $cep);
		 update_user_meta($user_id,'rua', $rua);
		 update_user_meta($user_id,'numero', $numero);
		 update_user_meta($user_id,'bairro', $bairro);
		 update_user_meta($user_id,'cidade', $cidade);
		 update_user_meta($user_id,'estado', $estado);
    } else {
			$response = new WP_Error('email', 'E-mail já cadastrado.', array('status' => 403));
		}

    return rest_ensure_response( $response );
}

// Função registra a rota da API
// É executada durante a inicialização da API REST do WordPress através do hook rest_api_init
function register_api_usuario_post() {
    register_rest_route( 'api/v1', '/usuario', array(
        array(
            'methods' => WP_REST_Server::CREATABLE,
            'callback' => 'usuario_api_post',
        ),
    ) );
}

add_action( 'rest_api_init', 'register_api_usuario_post' );