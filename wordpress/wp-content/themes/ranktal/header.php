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

  <!-- Google Tag Manager -->
  <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
  new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
  j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
  'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
  })(window,document,'script','dataLayer','GTM-TRPFQH5');</script>
  <!-- End Google Tag Manager -->
</head>

<body>

  <!-- Google Tag Manager (noscript) -->
  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TRPFQH5"
  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
  <!-- End Google Tag Manager (noscript) -->

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

          <!-- Upper Left Menu -->
          <?php dynamic_sidebar('left-menu'); ?>

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
        <?php if ( is_archive() ) : ?>
          <?php the_archive_title(); ?>
          <?php else :?>
          <?php single_post_title(); ?>
          <?php endif; ?>
         </h1>
        <p class="lead font-weight-normal">
          <?php        
            if ( is_single() ) {   
              // if inside the single post page 
              echo get_the_excerpt();
            }
            if ( is_home() ){
              // inside the posts page
              echo get_the_excerpt( get_option('page_for_posts') );
            }
            if (is_archive()){
              echo get_the_archive_description();
            }
          ?>
           </p>
      </div>
    </div>
  </section>