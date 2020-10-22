<!-- Tools features section
    ================================================== -->
    <section id="features" class="mb-3">
        <div class="container">
            <div class="text-center mt-2 mb-2">
                <h2 class="my-3">
                    <?php the_field('features_title'); ?>
                </h2>
            </div>
            <ul class="nav nav-tabs justify-content-center" id="featuresTabs" role="tablist">
            <?php 
                $loop = new WP_Query(array(
                    'post_type' => 'feature',
                    'orderby' => 'post_id',
                    'order' => 'ASC'
                    ));
                ?>
                <?php while( $loop->have_posts()): ?>
                    <?php $loop->the_post(); ?>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ( $loop->current_post == 0 ) ? 'active' : ''; ?>" id="<?php echo str_replace(" ","",get_the_title()); ?>-tab" data-toggle="tab" role="tab" aria-controls="<?php echo str_replace(" ","",get_the_title()); ?>"
                            aria-selected="true" href="#<?php echo str_replace(" ","",get_the_title()); ?>" data-target="#carouselExampleIndicators" data-slide-to="<?php echo $loop->current_post; ?>">
                            <div class="text-center p-2">
                                <?php the_field('feature_icon');?>
                                <h5><?php the_title(); ?></h5>
                            </div>
                        </a>
                    </li>
                <?php endwhile; ?>
                <!-- reset the main query loop -->
                <?php wp_reset_postdata(); ?>
            </ul>
            <div id="carouselExampleIndicators" class="carousel slide" data-interval="false">
                <div class="tab-content">
                    <div class="carousel-inner">
                    <?php 
                    $loop = new WP_Query(array(
                        'post_type' => 'feature',
                        'orderby' => 'post_id',
                        'order' => 'ASC'
                        ));
                    ?>
                    <?php while( $loop->have_posts()): ?>
                    <?php $loop->the_post(); ?>

                        <div class="carousel-item <?php echo ( $loop->current_post == 0 ) ? 'active' : ''; ?> tab-pane" id="<?php echo str_replace(" ","",get_the_title()); ?>" role="tabpanel" aria-labelledby="<?php echo str_replace(" ","",get_the_title()); ?>-tab">
                            <div class="container">
                                <div class="row mt-4">
                                    <?php the_content(); ?>
                                    <div class="col-xs-12 col-lg-7">
                                        <img class="img-fluid"                                        
                                            src="<?php the_post_thumbnail_url();?>">
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <a class="btn btn-success btn-lg" href="<?php the_field('feature_url'); ?> ">Try <?php the_title(); ?> Now</a>
                                </div>
                            </div>
                        </div>
                       <!-- End of tab content -->
                       <?php endwhile; ?>
                        <!-- reset the main query loop -->
                        <?php wp_reset_postdata(); ?>
                    </div>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
    </section>