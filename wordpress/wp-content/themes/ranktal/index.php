<?php
 get_header();
 ?>

  <!-- Content section
    ================================================== -->
<section class="my-3">
    <div class="container">
    <?php
    if( have_posts() ){
      while (have_posts()){
        the_post();
        get_template_part('template-parts/content','archive');
      }
    }
    // the_posts_pagination(array(
    //     'screen_reader_text' => ' '
    // ));
    if (function_exists("ranktal_wpbs_pagination"))
    {
        ranktal_wpbs_pagination();
        //ranktal_wpbs_pagination($the_query->max_num_pages);
    }

    ?>
    
    </div>
</section>

  <!-- Learn SEO with us section
    ================================================== -->
  <section id="learn-resources" class="bcolor-3">
    <div class="container">
      <div class="row">
        <div class="col-xs-12 m-auto">
          <div class="text-center">
            <h2 class="mt-3 mb-3">More to Learn</h2>
          </div>
        </div>
      </div>
      <div class="row justify-content-center">
        <div class="col-12 col-md-4 icon-card-col d-flex mb-3">
          <div class="card icon-card card-no-border card-transparent">
            <div class="card-body py-4 text-center">
              <div class="mb-3"><img
                  src="https://moz.imgix.net/products/landing-pages/GettingStarted.svg?auto=format&amp;ch=Width&amp;fit=max&amp;q=50&amp;s=e70fcd8269c8c089b81a83ec6fc0e661"
                  alt="Brand-new to SEO?"></div>
              <h5 class="">Brand-new to SEO?</h5>
              <p>Read over 10 million times, it’s the most popular (and most trusted) introduction to SEO on the planet.
              </p>
              <div class="cta-wrapper"><a href="/beginners-guide-to-seo" class="lead link-cta">
                  Read the Beginner's Guide
                </a></div>
            </div>
          </div>
        </div>

        <div class="col-12 col-md-4 icon-card-col d-flex mb-3">
          <div class="card icon-card card-no-border card-transparent">
            <div class="card-body py-4 text-center">
              <div class="mb-3"><img
                  src="https://moz.imgix.net/products/landing-pages/Training.svg?auto=format&amp;ch=Width&amp;fit=max&amp;q=50&amp;s=ca41ca88897dd7e4f791f66bc873f7f9"
                  alt="Free SEO education"></div>
              <h5 class="">Free SEO education</h5>
              <p>Whether you’re a beginner, need advanced on-page tactics, or a refresher on building better traffic,
                we’ve got you covered.</p>
              <div class="cta-wrapper"><a href="/learn/seo" class="lead link-cta">
                  Visit the SEO Learning Center
                </a></div>
            </div>
          </div>
        </div>

        <div class="col-12 col-md-4 icon-card-col d-flex mb-3">
          <div class="card icon-card card-no-border card-transparent">
            <div class="card-body py-4 text-center">
              <div class="mb-3"><img
                  src="https://moz.imgix.net/products/landing-pages/Blogs.svg?auto=format&amp;ch=Width&amp;fit=max&amp;q=50&amp;s=a3284476f4cc0591368f1a86ff4837f8"
                  alt="The Moz Blog"></div>
              <h5 class="">The Ranktal Blog</h5>
              <p>We wrote the blog on SEO — literally. Since its humble beginnings in 2004, this is where SEO happens.
              </p>
              <div class="cta-wrapper"><a href="/blog" class="lead link-cta">
                  Read the latest posts
                </a></div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>

    <!-- Join us section
    ================================================== -->
    <section id="join-us" class="jumbotron px-0 my-0"
    style="background-image: url(https://moz.imgix.net/products/moz-pro-mockup-background-v3.jpg?auto=format&amp;ch=Width&amp;fit=max&amp;q=50&amp;w=2000&amp;s=7495a1000afa619e51f8e5eaecd7ba91);background-position: center center;">
    <div class="container">
      <div class="row">
        <div class="col-md-5">
          <div class="card">
            <div class="card-body">
              <h3 class="card-title">Do better SEO</h3>
              <p>Raise your visibility, improve your rankings, and attract more visitors. We can help.</p>
              <a href="/checkout/freetrial" class="btn btn-success">Get started free</a>
              <p class="mt-3 mb-0"><a href="#">Pick your plan. Cancel anytime.</a></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  
<?php 
get_footer();
?>