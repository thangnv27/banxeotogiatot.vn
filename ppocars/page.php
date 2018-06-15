<?php get_header(); ?>
<!--BREADCRUMB-->
<div id="breadcrumbs">
    <div class="container">
        <?php if ( function_exists('yoast_breadcrumb') ) { yoast_breadcrumb('<div class="breadcrumbs">','</div>'); } ?>
    </div>
</div>
<!--/BREADCRUMB-->

<section id="main">
    <div class="container">
        <div class="page">
            <div class="row">
                <div class="main-left col-lg-9 col-md-8 col-sm-7 col-xs-6">
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

                <?php get_sidebar() ?>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>