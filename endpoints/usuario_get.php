<?php 

// Função retorna um array com os dados do usuário
function usuario_api_get($request) {
  $user = wp_get_current_user();
  $user_id = $user->ID;

  if ( $user_id > 0 ) {
    $user_meta = get_user_meta($user_id);

    $response = array(
      'id' => $user->user_login,
      'nome' => $user->display_name,
      'email' => $user->user_email,
      'cep' => $user_meta['cep'][0],
      'numero' => $user_meta['numero'][0],
      'rua' => $user_meta['rua'][0],
      'bairro' => $user_meta['bairro'][0],
      'cidade' => $user_meta['cidade'][0],
      'estado' => $user_meta['estado'][0]
    );
  } else {
    $response = new WP_Error('permissao', 'Usuário não autenticado ou não encontrado.', array('status' => 401));
  }
    return rest_ensure_response( $response );
}

// Função registra a rota da API
// É executada durante a inicialização da API REST do WordPress através do hook rest_api_init
function register_api_usuario_get() {
    register_rest_route( 'api/v1', '/usuario', array(
        array(
            'methods' => WP_REST_Server::READABLE,
            'callback' => 'usuario_api_get',
        ),
    ) );
}

add_action( 'rest_api_init', 'register_api_usuario_get' );