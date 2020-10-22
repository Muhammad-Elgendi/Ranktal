  <!-- Trusted by section
    ================================================== -->
    <section class="bcolor-4 color-1">
    <div class="text-center">
      <h3 class="py-3"><?php echo get_field('client_title')?></h3>
    </div>
    <div class="text-center brands">
        <?php 
        $loop = new WP_Query(array(
            'post_type' => 'client',
            'orderby' => 'post_id',
            'order' => 'ASC'
            ));
        ?>
        <?php while( $loop->have_posts()): ?>
            <?php
                $loop->the_post();
                if ( !empty(get_the_content()) ){
                    echo get_the_content();
                }else{
                    the_post_thumbnail();
                }
            ?>
        <?php endwhile; ?>
        <!-- reset the main query loop -->
        <?php wp_reset_postdata(); ?>
    </div>
  </section>