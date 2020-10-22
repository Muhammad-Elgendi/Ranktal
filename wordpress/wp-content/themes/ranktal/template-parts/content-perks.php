 <!-- Perks section
    ================================================== -->
    <section>
    <div class="col-xs-12 text-center">
      <h2 class="my-3"><?php the_field('perks_title'); ?></h2>
    </div>

    <div class="row justify-content-center m-3">
    <?php $loop = new WP_Query(array(
         'post_type' => 'perk',
         'orderby' => 'post_id',
         'order' => 'ASC'
    ));
    ?>
    <?php while( $loop->have_posts()): ?>
    <?php $loop->the_post(); ?>

      <div class="col-md-3 col-xs-12">
        <span class="perks-icon">
            <?php the_post_thumbnail(); ?>
        </span>
        <div class="perks-content">
          <h4><?php the_title(); ?></h4>
          <p><?php the_content(); ?></p>
        </div>
      </div>

    <?php endwhile; ?>
    <!-- reset the main query loop -->
    <?php wp_reset_postdata(); ?>
     

    </div>
  </section>