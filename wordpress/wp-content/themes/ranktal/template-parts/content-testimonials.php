<!-- Testimonials section
    ================================================== -->
    <section>
    <div class="container-fluid" id="testimonials">
      <div class="row">
        <div class="col-md-8 m-auto">
          <div class="bottom-line text-center">
            <h2 class="my-3"><?php the_field('testimonials_title'); ?></h2>
          </div>
          <div id="myCarousel" class="carousel slide" data-ride="carousel">
            <!-- Carousel indicators -->
            <ol class="carousel-indicators">

            <?php 
                    $loop = new WP_Query(array(
                        'post_type' => 'testimonial',
                        'orderby' => 'post_id',
                        'order' => 'ASC'
                        ));
            ?>
            <?php while( $loop->have_posts()): ?>
            <?php $loop->the_post(); ?>
              <li data-target="#myCarousel" data-slide-to="<?php echo $loop->current_post;?>" <?php echo ( $loop->current_post == 0 ) ? 'class="active"' : ''; ?> ></li>
            <?php endwhile; ?>
            <!-- reset the main query loop -->
            <?php wp_reset_postdata(); ?>   

            </ol>
            <!-- Wrapper for carousel items -->
            <div class="carousel-inner">

            <?php 
                    $loop = new WP_Query(array(
                        'post_type' => 'testimonial',
                        'orderby' => 'post_id',
                        'order' => 'ASC'
                        ));
            ?>
            <?php while( $loop->have_posts()): ?>
            <?php $loop->the_post(); ?>

            <div class="item carousel-item <?php echo ( $loop->current_post == 0 ) ? 'active' : ''; ?>">
                <div class="img-box">
                    <?php the_post_thumbnail(); ?>
                </div>
                <p class="testimonial">
                    <?php the_content(); ?>
                </p>
                <p class="overview"><b><?php the_title(); ?></b>, <?php echo get_the_excerpt(); ?></p>
            </div>

            <?php endwhile; ?>
            <!-- reset the main query loop -->
            <?php wp_reset_postdata(); ?>           
              
            </div>
            <!-- Carousel controls -->
            <a class="carousel-control left carousel-control-prev" href="#myCarousel" data-slide="prev">
              <i class="fas fa-angle-left"></i>
            </a>
            <a class="carousel-control right carousel-control-next" href="#myCarousel" data-slide="next">
              <i class="fas fa-angle-right"></i>
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>