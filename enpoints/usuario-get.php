<?php 

// Função retorna um array com os dados do usuário
function usuario_api_get($request) {
  $user = wp_get_current_user();

    return rest_ensure_response( $user );
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