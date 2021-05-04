<?php
/*
 Template Name: LP用レイアウト
*/
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <?php get_header(); ?>
</head>

<body>

<?php get_template_part('includes/nav'); ?> 

<?php while (have_posts()) : the_post(); ?>

  <!-- Page Header -->
  <!-- <header class="masthead" style="background-image: url('<?php echo get_template_directory_uri(); ?>/img/contact-bg.jpg')">
    <div class="overlay"></div>
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
          <div class="page-heading">
            <h1><?php the_title(); ?></h1>
            <span class="meta">Posted by
                <?php the_author(); ?>
                on <?php the_time('Y/m/d/g:ia'); ?></span>
          </div>
        </div>
      </div>
    </div>
  </header> -->

  <!-- Main Content -->
  <div class="container">
    <div class="row">
      <div class="col-lg-8 col-md-10 mx-auto">
        <?php the_content(); ?>
      </div>
    </div>
  </div>

  <hr>

  <?php endwhile; ?>

  <?php get_template_part('includes/footer02'); ?>

  <?php get_footer(); ?>

</body>

</html>
