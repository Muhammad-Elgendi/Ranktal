<!-- Plans section
  ================================================== -->

  <section class="layer bcolor-3" id="pricing">
      <section>

        <?php 
        $loop = new WP_Query(array(
            'post_type' => 'plan',
            'orderby' => 'menu_order',
            'order' => 'ASC',
            'posts_per_page' => 3,
            'nopaging' => true
            ));
        ?>
        <?php while( $loop->have_posts()): ?>
        <?php $loop->the_post(); ?>

          <section class="third lift plan-tier <?php echo ( has_excerpt() ) ? 'callout' : ''; ?>">
          <?php if(has_excerpt()):?>
                <h6 class="bcolor-2"><?php echo get_the_excerpt(); ?></h6>
          <?php endif; ?>

              <h4><?php the_title(); ?></h4>
             <?php echo get_the_content(); ?>
          </section>

        <?php endwhile; ?>
        <!-- reset the main query loop -->
        <?php wp_reset_postdata(); ?>
          
      </section>
  </section>