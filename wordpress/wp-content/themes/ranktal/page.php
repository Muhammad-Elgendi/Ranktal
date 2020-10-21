<?php
 get_header();
 ?>

  <!-- Content section
    ================================================== -->
<section class="my-3">
    <div class="container">
    <?php
    if( have_posts() ){
      while (have_posts()){
        the_post();
        get_template_part('template-parts/content','page');
      }
    }
    ?>
    </div>
</section>

<?php 
get_footer();
?>