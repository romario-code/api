<?php
function registrar_ctp_transacao() {
    register_post_type('transacao',array(
        'label' => 'Transação',
        'description' => 'Transação',
        'public' => true,
        'show_ui' => true,
        'capability_type' => 'post',
        'rewrite' => array('slug' => 'transacao', 'with_front' => true),
        'query_var' => true,
        'supports' => array('custom-fields', 'author', 'title'),
        'publicly_queryable' => true,
        'menu_icon' => 'dashicons-clipboard',
        )
    );  
}

add_action('init', 'registrar_ctp_transacao');