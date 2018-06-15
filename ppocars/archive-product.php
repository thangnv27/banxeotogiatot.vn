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
        <h1 class="archive-title"><?php _e('Sản phẩm', SHORT_NAME) ?></h1>
        <div class="product-grid-container">
            <div class="row">
                <?php while (have_posts()) : the_post(); ?>
                <div class="col-md-3 col-sm-4 col-xs-6">
                    <div class="entry">
                        <a class="thumbnail" href="<?php the_permalink() ?>">
                            <img alt="<?php the_title() ?>" src="<?php the_post_thumbnail_url('300x170') ?>" />
                        </a>
                        <h3><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h3>
                        <div class="price"><?php echo number_format(get_field('price'), 0, ",", "."); ?> VNĐ</div>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </div>

        <?php getpagenavi();?>
    </div>
</section>

<?php get_footer(); ?>