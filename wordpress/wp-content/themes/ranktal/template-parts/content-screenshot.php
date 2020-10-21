<!-- Labtop with img section
================================================== -->
<section>
<div class="text-center mt-2 mb-2">
    <h2 class="my-3">
    <?php the_field('screenshot_header'); ?>
    </h2>
</div>

<div class="laptop-container">
    <div class="monitor">
    <div class="screen">
        <div class="content">
        <img src="<?php echo get_field('screenshot')['url']; ?>" class="img-fluid" />
        </div>
    </div>
    </div>
    <!-- <div class="monitor-stand">
    </div> -->
</div>
<div class="labtop-bottom"></div>
</section>