<?php
// Função para listar todos os produtos
function api_transacao_get($request) {
  $tipo = sanitize_text_field($request['tipo']);

  $user = wp_get_current_user();
  $user_id = $user->ID;

  if ($user_id > 0) {
    $login = get_userdata($user_id)->user_login;

    $meta_query = null;
    if ($tipo) {
      $meta_query = array(
        'key' => $tipo,
        'value' => $login,
        'compare' => '=',
      );
    }
      
    $query = array(
      'post_type' => 'transacao',
      'orderby' => 'date',
      'post_per_page' => -1,
      'meta_query' => array(
        $meta_query,
      ),
    );

    $loop = new WP_Query($query);
    $posts = $loop->posts;

    $response = array();
    foreach ($posts as $key => $value) {
      $post_id = $value->ID;
      $post_meta = get_post_meta($post_id);
      $response[] = array(
        'comprador_id' => $post_meta['comprador_id'][0],
        'vendedor_id' => $post_meta['vendedor_id'][0],
        'endereco' => json_encode($post_meta['endereco'][0]),
        'produto' => json_encode($post_meta['produto'][0]),
        'data' => $value->post_date,
      );
    }
  } else {
    $response = new WP_Error('permissao', 'Usuário não possui permissão.', array('status' => 401));
  }
  return rest_ensure_response($response);
}

// Função para registrar a rota da API
function registrar_api_transacao_get() {
  register_rest_route( 'api/v1', '/transacao', array(
      array(
          'methods' => WP_REST_Server::READABLE,
          'callback' => 'api_transacao_get',
      ),
  ) );
}
add_action( 'rest_api_init', 'registrar_api_transacao_get' );