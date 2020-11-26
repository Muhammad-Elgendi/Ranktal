<!-- Frequently asked questions section
    ================================================== -->
    <section class="mb-3">
        <div class="col-xs-12 text-center">
            <h2 class="my-3"><?php the_field('faq_title'); ?></h2>
        </div>
        <div class="container pb-3">
            <div class="row">
                <div class="col-10 mx-auto">

                    <!-- Start of accordion -->
                    <div id="accordion">

                    <?php 
                    $loop = new WP_Query(array(
                        'post_type' => 'faq',
                        'orderby' => 'menu_order',
                        'order' => 'ASC',
                        'nopaging' => true
                        ));
                    ?>
                    <?php while( $loop->have_posts()): ?>
                    <?php $loop->the_post(); ?>

                        <div class="card">
                            <div class="card-header" id="heading<?php echo $loop->current_post; ?>">
                                <h5 class="mb-0">
                                    <button class="btn btn-link" data-toggle="collapse" data-target="#collapse<?php echo $loop->current_post; ?>"
                                        aria-expanded="true" aria-controls="collapse<?php echo $loop->current_post; ?>">
                                        <div style="white-space:normal">                                 
                                            <?php the_title(); ?>
                                        </div>
                                    </button>
                                </h5>
                            </div>

                            <div id="collapse<?php echo $loop->current_post; ?>" class="collapse <?php echo ( $loop->current_post == 0 ) ? 'show' : ''; ?>" aria-labelledby="heading<?php echo $loop->current_post; ?>"
                                data-parent="#accordion">
                                <div class="card-body">
                                    <?php echo get_the_content(); ?>
                                </div>
                            </div>
                        </div>     
                        
                    <?php endwhile; ?>
                    <!-- reset the main query loop -->
                    <?php wp_reset_postdata(); ?>

                    </div>
                    <!-- End of accordion -->
                </div>
            </div>
            <!--/row-->
        </div>
        <!--container-->

    </section>