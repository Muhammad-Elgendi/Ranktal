  <!-- Numbers section
    ================================================== -->
    <section>
    <div class="container-fluid bcolor-1 white-font" id="numbers-section">
      <div class="row justify-content-center mt-5">
        <div class="col-xs-12 text-center">
          <h2 class="my-3"><?php the_field('numbers_title'); ?></h2>
        </div>
        <div class="col-xs-12 col-xl-12">
          <p class="mx-5 px-5 text-center ">
            <?php the_field('numbers_excerpt'); ?>
          </p>
        </div>
      </div>
      <div class="row justify-content-center m-3 pb-3">
      <?php 
        $loop = new WP_Query(array(
            'post_type' => 'number',
            'orderby' => 'post_id',
            'order' => 'ASC'
            ));
        ?>
        <?php while( $loop->have_posts()): ?>
            <?php $loop->the_post(); ?>

            <div class="col-md-2 col-xs-12 text-center">
                <div class="figure-counter">
                    <?php the_content();?>
                </div>
                <div class="figure-text">
                    <?php the_title(); ?>
                </div>
            </div>  

        <?php endwhile; ?>    
        <!-- reset the main query loop -->
        <?php wp_reset_postdata(); ?>    
      </div>
    </div>
  </section>