<?php
 get_header();
 ?>

  <!-- Content section
    ================================================== -->
<section class="my-3">
    <div class="container">
        <div class="row d-flex justify-content-center">
        <div class="col-md-12">
            <div class="text-center py-2 px-2">
                <h2>Oops!</h2>
                <h2>Page Not Found</h2>
                <div>
                    Sorry, an error has occured, Requested page not found!
                </div>
                <div class="my-2">
                    <a href="<?php echo get_site_url(); ?>" class="btn btn-primary btn-lg"><i class="fas fa-home"></i>
                        Take Me Home </a>
                    <a href="<?php echo get_site_url(null,'/contact-us'); ?>" class="btn btn-default btn-lg"><i class="fas fa-envelope"></i> Contact Support </a>
                </div>                
            </div>
        </div>
     
        <div class="col-md-12">

            <?php
             get_search_form(); 
            ?>

        </div>     
          
    </div>
    </div>
</section>

<?php get_template_part('template-parts/content','before_footer'); ?>

<?php 
get_footer();
?>