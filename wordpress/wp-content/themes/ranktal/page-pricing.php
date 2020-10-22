<?php
/* Template Name: Pricing Page Template */
 get_header();
 ?>

<?php
// implement ordering functionality
if(get_field('sections_order')){
  $order = explode(",", get_field('sections_order'));
  foreach($order as $item){
    $item = trim($item);
    if(get_field('enable_'.$item.'_section')) {
      get_template_part('template-parts/content',$item);
    }
  }
}  
?>

<?php if(!get_field('sections_order')): ?>
<!-- User doesn't specify any order -->
  <?php if(get_field('enable_plans_section')) :?>
    <?php get_template_part('template-parts/content','plans'); ?>
  <?php endif; ?>

  <?php if(get_field('enable_features_section')) :?>
    <?php get_template_part('template-parts/content','features'); ?>
  <?php endif; ?> 

  <?php if(get_field('enable_clients_section')) :?>
    <?php get_template_part('template-parts/content','clients'); ?>
  <?php endif; ?>

  <?php if(get_field('enable_perks_section')) :?>
    <?php get_template_part('template-parts/content','perks'); ?>
  <?php endif; ?> 

  <?php if(get_field('enable_testimonials_section')) :?>
    <?php get_template_part('template-parts/content','testimonials'); ?>
  <?php endif; ?> 

  <?php if(get_field('enable_faq_section')) :?>
    <?php get_template_part('template-parts/content','faq'); ?>
  <?php endif; ?>
<?php endif; ?>

<?php 
get_footer();
?>