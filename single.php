<?php get_header(); ?>
<div class="page-inner full-width">
  <div class="page-main" id="pg-newsDetail">
    <div class="main-container">
      <div class="main-wrapper">
        <?php
        if (have_posts()) :
          while (have_posts()) : the_post();
        ?>
        <div class="news">
          <time class="time"><?php the_time('Y.m.d'); ?></time>
          <p class='title'><?php the_title(); ?></p>
          <div class="news-body">
            <?php the_content(); ?>
          </div>
        </div>
        <div class="more-news">
          <div class="next">
            <a class="another-link" href="#">NEXT</a>
          </div>
          <div class="prev">
            <a class="another-link" href="#">PREV</a>
          </div>
        </div>
        <?php
        endwhile;
      endif; 
      ?>
      </div>
    </div>
  </div>
</div>
<?php get_footer(); ?>