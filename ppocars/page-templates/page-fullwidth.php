<?php 
/*
  Template Name: Full Width
 */
get_header(); 
?>

<!--BREADCRUMB-->
<div id="breadcrumbs" class="mb30">
    <div class="container">
        <div class="pull-left">
            <h1 class="page-title"><?php the_title() ?></h1>
        </div>
        <div class="pull-right">
            <?php if ( function_exists('yoast_breadcrumb') ) { yoast_breadcrumb('<div class="breadcrumbs">','</div>'); } ?>
        </div>
    </div>
</div>
<!--/BREADCRUMB-->

<section id="main">
    <div class="container">
        <div class="page">
            <?php
            // Start the Loop.
            while (have_posts()) : the_post();

                // Include the page content template.
                get_template_part('content', 'page');

                // If comments are open or we have at least one comment, load up the comment template.
                if (comments_open() || get_comments_number()) {
                    comments_template();
                }
            endwhile;
            ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>