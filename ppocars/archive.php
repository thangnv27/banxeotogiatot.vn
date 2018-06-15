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
        <div class="row">
            <div class="main-left col-lg-9 col-md-8 col-sm-7 col-xs-6">
                <h1 class="archive-title"><?php single_cat_title() ?></h1>
                <div class="archive-content">
                    <?php
                    if(have_posts()):
                        while (have_posts()) : the_post();
                            get_template_part('content', get_post_format());
                        endwhile;
                    else:
                    ?>
                    <div>
                        <p><?php _e('Không có bài viết nào được tìm thấy trong chuyên mục này.', SHORT_NAME) ?></p>
                        <?php get_search_form(); ?>
                    </div>
                    <?php endif; ?>
                </div>

                <?php getpagenavi();?>
            </div>
            <?php get_sidebar(); ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>