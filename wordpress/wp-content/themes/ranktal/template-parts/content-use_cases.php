  <!-- User cases section
    ================================================== -->
    <section>
    <div class="container-fluid">
      <div class="row">
        <div class="col-xs-12 m-auto">
          <div class="text-center">
            <h2 class="mt-3 mb-3"><?php the_field('use_cases_title'); ?></h2>
          </div>
        </div>
      </div>

      <div class="row justify-content-center mb-3">
        <?php 
                    $loop = new WP_Query(array(
                        'post_type' => 'use_case',
                        'orderby' => 'post_id',
                        'order' => 'ASC'
                        ));
        ?>
        <?php while( $loop->have_posts()): ?>
        <?php $loop->the_post(); ?>

        <div class="col-xs-12 col-md-3 pb-3">
          <div class="card">
            <img class="card-img-top" src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>">
            <div class="card-body">
              <h5 class="card-title"><?php the_title(); ?></h5>
              <p class="card-text">
                    <?php the_content(); ?>
              </p>
              <?php echo get_the_excerpt(); ?>
            </div>
          </div>
        </div>

        <?php endwhile; ?>
        <!-- reset the main query loop -->
        <?php wp_reset_postdata(); ?>      
        
      </div>

    </div>
  </section>