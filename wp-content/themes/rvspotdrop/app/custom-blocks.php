<?php
/**
 *
 * @file
 * Register custom gutenberg blocks.
 *
 * @package WordPress
 */

/**
 * Register custom block types.
 */
function register_custom_block_types() {
  // Register a banner block.
  acf_register_block_type(
    array(
      'name'            => 'banner',
      'title'           => 'Banner',
      'description'     => 'A custom banner block.',
      'category'        => 'custom',
      'icon'            => 'id',
      'keywords'        => array( 'banner', 'section' ),
      'render_template' => 'blocks/banner.php',
      'mode'            => 'edit',
      'supports'        => array(
        'mode' => false,
      ),
    )
  );
  // Register a hero block.
  acf_register_block_type(
    array(
      'name'            => 'hero',
      'title'           => 'Hero',
      'description'     => 'A custom hero block.',
      'category'        => 'custom',
      'icon'            => 'schedule',
      'keywords'        => array( 'hero', 'banner'),
      'render_template' => 'blocks/hero.php',
      'mode'            => 'edit',
      'supports'        => array(
        'mode' => false,
      ),
    )
  );
  // Register a cards block.
  acf_register_block_type(
    array(
      'name'            => 'cards',
      'title'           => 'Cards',
      'description'     => 'A custom cards block.',
      'category'        => 'custom',
      'icon'            => 'screenoptions',
      'keywords'        => array( 'cards', 'blocks'),
      'render_template' => 'blocks/cards.php',
      'mode'            => 'edit',
      'supports'        => array(
        'mode' => false,
      ),
    )
  );
}
add_action( 'init', 'register_custom_block_types' );