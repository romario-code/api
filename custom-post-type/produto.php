<?php
function registrar_ctp_produto() {
    register_post_type('produto',array(
        'label' => 'Produtos',
        'description' => 'Produtos disponíveis para compra',
        'public' => true,
        'show_ui' => true,
        'capability_type' => 'post',
        'rewrite' => array('slug' => 'produto', 'with_front' => true),
        'query_var' => true,
        'supports' => array('custom-fields', 'author', 'title'),
        'publicly_queryable' => true,
        'menu_icon' => 'dashicons-cart',
        )
    );  
}

add_action('init', 'registrar_ctp_produto');