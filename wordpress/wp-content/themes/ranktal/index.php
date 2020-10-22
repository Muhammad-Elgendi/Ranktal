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
        get_template_part('template-parts/content','archive');
      }
    }
    // the_posts_pagination(array(
    //     'screen_reader_text' => ' '
    // ));
    if (function_exists("ranktal_wpbs_pagination"))
    {
        ranktal_wpbs_pagination();
        //ranktal_wpbs_pagination($the_query->max_num_pages);
    }

    ?>
    
    </div>
</section>

<?php get_template_part('template-parts/content','before_footer'); ?>

<?php 
get_footer();
?>