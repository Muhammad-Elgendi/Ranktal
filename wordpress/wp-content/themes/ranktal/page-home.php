<?php
/* Template Name: Homepage Template */

 ?> 
<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- favicon -->
  <link rel="icon" href="<?php echo get_template_directory_uri().'/assets/images/favicon.ico'?>">

  <!-- Using Lato and Roboto Slab fonts  -->
  <link href="https://fonts.googleapis.com/css?family=Lato:400,900|Roboto+Slab:400,900&display=swap" rel="stylesheet">

  <?php
  wp_head();
  ?>
</head>

<body>
  <!-- Header
    ================================================== -->
  <header class="site-header" role="banner">
    <!-- Navbar
      ================================================== -->
    <nav class="navbar navbar-expand-lg navbar-light">
      <div class="container d-flex flex-md-row justify-content-between">
        <a class="navbar-brand" href="<?php echo get_site_url(null,'/') ?>">
          <i class="fas fa-location-arrow color-1"></i>
          <?php echo get_bloginfo('name') ?>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">

        <?php
          // wp_nav_menu(
          //   array(
          //     'menu' => 'primary',
          //     'container' => '',
          //     'theme_location' => 'primary',
          //     'items_wrap'=> '<ul class="navbar-nav mr-auto mt-2 mt-lg-0">%3$s</ul>'
          //   )
          // );

          // second solution
          $myMenu = get_nav_menu_locations();
          // get menu ID
          $menuID = $myMenu['primary'];
          // get menu Items
          $menu_items = wp_get_nav_menu_items($menuID);
        ?>

          <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
            <?php foreach($menu_items as $item): ?>
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo $item->url; ?>"> <?php echo $item->title; ?></a>
                </li>
            <?php endforeach; ?>         
          </ul>

          <ul class="navbar-nav flex-row ml-md-auto d-none d-md-flex">
            <li class="nav-item dropdown ">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                EN
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="#">English</a>
                <a class="dropdown-item" href="#">العربية (قريباً)</a>
              </div>
            </li>
          </ul>
          <a class="btn btn-outline-secondary my-2 mx-2" href="http://app.localhost/" target="_blank">Login</a>
          <a class="btn btn-outline-success my-2 mx-2" href="http://app.localhost/en/register" target="_blank">Sign up</a>
        </div>
      </div>
    </nav>
  </header>

 <!-- Header slider section
    ================================================== -->
    <section id="header">
    <div class="position-relative overflow-hidden p-3 p-md-5 text-center">
      <div class="col-md-6 p-lg-5 mx-auto my-5">
        <h1 class="display-4 font-weight-normal">
          <?php single_post_title(); ?>
         </h1>
        <p class="lead font-weight-normal">
          <?php        
            if ( !is_home() ) {   
              // if not inside the posts page 
              the_excerpt();
            }else{
              // inside the posts page
              echo get_the_excerpt( get_option('page_for_posts') );
            }
          ?>
           </p>
           
            <!-- check if the user choose to include CTA button     -->
            <?php if(get_field('enable_cta_button')): ?>
                <a target="_blank" class="btn btn-success btn-lg" href="<?php echo get_field('button_url') ?>"><?php echo get_field('button_text') ?></a>
            <?php endif; ?>
           
      </div>
    </div>
  </section>


  <?php if(get_field('enable_clients_section')) :?>
    <?php get_template_part('template-parts/content','client'); ?>
  <?php endif; ?>

  <?php if(get_field('enable_screenshot_section')) :?>
    <?php get_template_part('template-parts/content','screenshot'); ?>
  <?php endif; ?> 

  <?php if(get_field('enable_features_section')) :?>
    <?php get_template_part('template-parts/content','feature'); ?>
  <?php endif; ?> 



 

  <!-- Numbers section
    ================================================== -->
  <section>
    <div class="container-fluid bcolor-1 white-font">
      <div class="row justify-content-center mt-5">
        <div class="col-xs-12 text-center">
          <h2 class="my-3">Ranktal In Numbers</h2>
        </div>
        <div class="col-xs-12 col-xl-12">
          <p class="mx-5 px-5 text-center ">
            We are proud of our work and our results. By accumulating and processing large volumes of data, we aim to
            provide our clients with the best product, which is now used by over 4 million marketing specialists
            worldwide.
          </p>
        </div>
      </div>
      <div class="row justify-content-center m-3 pb-3">
        <div class="col-md-2 col-xs-12 text-center">
          <div class="figure-counter">
            5
          </div>
          <div class="figure-text">
            million users
          </div>
        </div>
        <div class="col-md-2 col-xs-12 text-center">
          <div class="figure-counter">
            5
          </div>
          <div class="figure-text">
            million users
          </div>
        </div>
        <div class="col-md-2 col-xs-12 text-center">
          <div class="figure-counter">
            5
          </div>
          <div class="figure-text">
            million users
          </div>
        </div>
        <div class="col-md-2 col-xs-12 text-center">
          <div class="figure-counter">
            5
          </div>
          <div class="figure-text">
            million users
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Perks section
    ================================================== -->
  <section>
    <div class="col-xs-12 text-center">
      <h2 class="my-3">More perks</h2>
    </div>

    <div class="row justify-content-center m-3">
      <div class="col-md-3 col-xs-12">
        <span class="perks-icon">
          <img src="https://cdn.ahrefs.com/images/home/support.svg" alt="24/5 customer support">
        </span>
        <div class="perks-content">
          <h4>24/5 customer support</h4>
          <p>Have a question, concern or feedback for us? Our support team is a quick chat or email away — 24 hours a
            day, Monday to Friday.</p>
        </div>
      </div>
      <div class="col-md-3 col-xs-12">
        <span class="perks-icon">
          <img src="https://cdn.ahrefs.com/images/home/community.svg" alt="Private Facebook community">
        </span>
        <div class="perks-content">
          <h4>Private Facebook community</h4>
          <p>Take full advantage of insights from highly-accomplished SEO specialists and digital marketers in our
            customers-only community.</p>
        </div>
      </div>
      <div class="col-md-3 col-xs-12">
        <span class="perks-icon">
          <img src="https://cdn.ahrefs.com/images/home/learning.svg" alt="Tailored learning materials">
        </span>
        <div class="perks-content">
          <h4>Tailored learning materials</h4>
          <p>The marketing tutorials on our blog and YouTube channel, and in the Ahrefs Academy, often feature our
            tools. Unlock their potential with full access.</p>
        </div>
      </div>
      <div class="col-md-3 col-xs-12">
        <span class="perks-icon">
          <img src="https://cdn.ahrefs.com/images/home/rocket.svg" alt="New features released regularly">
        </span>
        <div class="perks-content">
          <h4>New features released regularly</h4>
          <p>Our development cycle is fast. We frequently update existing tools and release new features — many of
            which are heavily influenced by requests from our customers.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Testimonials section
    ================================================== -->
  <section>
    <div class="container-fluid" id="testimonials">
      <div class="row">
        <div class="col-md-8 m-auto">
          <div class="bottom-line text-center">
            <h2 class="my-3">Testimonials</h2>
          </div>
          <div id="myCarousel" class="carousel slide" data-ride="carousel">
            <!-- Carousel indicators -->
            <ol class="carousel-indicators">
              <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
              <li data-target="#myCarousel" data-slide-to="1"></li>
              <li data-target="#myCarousel" data-slide-to="2"></li>
            </ol>
            <!-- Wrapper for carousel items -->
            <div class="carousel-inner">
              <div class="item carousel-item active">
                <div class="img-box"><img src="https://www.tutorialrepublic.com/examples/images/clients/3.jpg" alt="">
                </div>
                <p class="testimonial">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam eu sem tempor,
                  varius quam at, luctus dui. Mauris magna metus, dapibus nec turpis vel, semper malesuada ante. Idac
                  bibendum scelerisque non non purus. Suspendisse varius nibh non aliquet.</p>
                <p class="overview"><b>Paula Wilson</b>, Media Analyst</p>
              </div>
              <div class="item carousel-item">
                <div class="img-box"><img src="https://www.tutorialrepublic.com/examples/images/clients/2.jpg" alt="">
                </div>
                <p class="testimonial">Vestibulum quis quam ut magna consequat faucibus. Pellentesque eget nisi a mi
                  suscipit tincidunt. Utmtc tempus dictum risus. Pellentesque viverra sagittis quam at mattis.
                  Suspendisse potenti. Aliquam sit amet gravida nibh, facilisis gravida odio.</p>
                <p class="overview"><b>Antonio Moreno</b>, Web Developer</p>
              </div>
              <div class="item carousel-item">
                <div class="img-box"><img src="https://www.tutorialrepublic.com/examples/images/clients/3.jpg" alt="">
                </div>
                <p class="testimonial">Phasellus vitae suscipit justo. Mauris pharetra feugiat ante id lacinia. Etiam
                  faucibus mauris id tempor egestas. Duis luctus turpis at accumsan tincidunt. Phasellus risus risus,
                  volutpat vel tellus ac, tincidunt fringilla massa. Etiam hendrerit dolor eget rutrum.</p>
                <p class="overview"><b>Michael Holz</b>, Seo Analyst</p>
              </div>
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

  <!-- User cases section
    ================================================== -->
  <section>
    <div class="container-fluid">
      <div class="row">
        <div class="col-xs-12 m-auto">
          <div class="text-center">
            <h2 class="mt-3 mb-3">Use Cases</h2>
          </div>
        </div>
      </div>
      <div class="row justify-content-center mb-3">
        <div class="col-xs-12 col-md-3">
          <div class="card">
            <img class="card-img-top" src="https://cdn.semrush.com/static/index/stories/wix.d0c3b0c4754e.jpg"
              alt="Card image cap">
            <div class="card-body">
              <h5 class="card-title">Card title</h5>
              <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's
                content.</p>
              <a href="#" class="btn btn-outline-secondary">Go somewhere</a>
            </div>
          </div>
        </div>

        <div class="col-xs-12 col-md-3">
          <div class="card">
            <img class="card-img-top" src="https://cdn.semrush.com/static/index/stories/booking.0aa68f9fbc56.jpg"
              alt="Card image cap">
            <div class="card-body">
              <h5 class="card-title">Card title</h5>
              <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's
                content.</p>
              <a href="#" class="btn btn-outline-secondary">Go somewhere</a>
            </div>
          </div>
        </div>

        <div class="col-xs-12 col-md-3">
          <div class="card">
            <img class="card-img-top" src="https://cdn.semrush.com/static/index/stories/vodafone.fe3faf24d6e3.jpg"
              alt="Card image cap">
            <div class="card-body">
              <h5 class="card-title">Card title</h5>
              <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's
                content.</p>
              <a href="#" class="btn btn-outline-secondary">Go somewhere</a>
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

  <!-- Learn SEO with us section
    ================================================== -->
  <section id="learn-resources">
    <div class="container">
      <div class="row">
        <div class="col-xs-12 m-auto">
          <div class="text-center">
            <h2 class="mt-3 mb-3">Learn SEO</h2>
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
  
<?php 
get_footer();
?>