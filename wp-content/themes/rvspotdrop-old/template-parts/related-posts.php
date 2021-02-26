<?php
/**
 * Related posts based on categories and tags.
 * 
 */

$rvspotdrop_related_posts_taxonomy = get_theme_mod( 'rvspotdrop_related_posts_taxonomy', 'category' );

$rvspotdrop_post_args = array(
    'posts_per_page'    => absint( get_theme_mod( 'rvspotdrop_related_posts_count', '3' ) ),
    'orderby'           => 'rand',
    'post__not_in'      => array( get_the_ID() ),
);

$rvspotdrop_tax_terms = wp_get_post_terms( get_the_ID(), 'category' );
$rvspotdrop_terms_ids = array();
foreach( $rvspotdrop_tax_terms as $tax_term ) {
	$rvspotdrop_terms_ids[] = $tax_term->term_id;
}

$rvspotdrop_post_args['category__in'] = $rvspotdrop_terms_ids; 

if(get_theme_mod('rvspotdrop_related_post',true)==1){

$rvspotdrop_related_posts = new WP_Query( $rvspotdrop_post_args );

if ( $rvspotdrop_related_posts->have_posts() ) : ?>
    <div class="related-post">
        <h3><?php echo esc_html(get_theme_mod('rvspotdrop_related_post_title','Related Post'));?></h3>
        <div class="row">
            <?php while ( $rvspotdrop_related_posts->have_posts() ) : $rvspotdrop_related_posts->the_post(); ?>
                <?php get_template_part('template-parts/grid-layout'); ?>
            <?php endwhile; ?>
        </div>
    </div>
<?php endif;
wp_reset_postdata();

}