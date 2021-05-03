<?php
function init_func(){ 
  add_theme_support('title-tag');
  add_theme_support('post-thumbnails');

  register_post_type('item',[
    'labels' => [
      'name' => '商品',
    ],
    'public' => true,
    'has_archive' => true,
    'hierarchical' => true,
    'supports' => [
      'title',
      'editor',
      'page-attributes'
    ],
    'menu_position' => 5,
    'menu_icon' => 'dashicons-cart' 
  ]);

}
add_action('init','init_func');
