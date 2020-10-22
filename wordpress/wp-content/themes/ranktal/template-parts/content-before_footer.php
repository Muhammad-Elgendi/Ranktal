<!-- Learn SEO with us section
================================================== -->
<section id="learn-resources">
<div class="container">

    <div class="row">
    <div class="col-xs-12 m-auto">
        <div class="text-center">
        <h2 class="mt-3 mb-3">Learn More</h2>
        </div>
    </div>
    </div>
    <div class="row justify-content-center">
    <?php 
    $loop = new WP_Query(array(
        'post_type' => 'resource',
        'orderby' => 'post_id',
        'order' => 'ASC'
        ));
    ?>
    <?php while( $loop->have_posts()): ?>
    <?php $loop->the_post(); ?>

    <div class="col-12 col-md-4 icon-card-col d-flex mb-3">
        <div class="card icon-card card-no-border card-transparent">
        <div class="card-body py-4 text-center">
            <div class="mb-3">
            <img
                src="<?php the_post_thumbnail_url(); ?>"
                alt="<?php the_title(); ?>">
            </div>
            <h5 class=""><?php the_title(); ?></h5>
            <p>
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

<?php dynamic_sidebar('before_footer'); ?>