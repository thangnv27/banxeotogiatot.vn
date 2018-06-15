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
            <div class="main-left col-lg-9">
                <?php
                while (have_posts()) : the_post();
                    /*
                     * Include the post format-specific template for the content. If you want to
                     * use this in a child theme, then include a file called called content-___.php
                     * (where ___ is the post format) and that will be used instead.
                     */
                    get_template_part('content', 'product');
                
                    $related_posts_id = get_field('related_posts');
                    $args = array(
                        'post_type' => 'post',
                        'showposts' => 2,
                        'orderby' => 'rand'
                    );
                    if(!empty($related_posts_id)){
                        $args = array(
                            'post_type' => 'post',
                            'post__in' => $related_posts_id,
                            'showposts' => -1,
                        );
                    }
                    $date_format = get_option( 'date_format' );
                    $time_format = get_option( 'time_format' );
                    $loop = new WP_Query($args);
                    if($loop->post_count > 0):
                    ?>
                    <div class="related-posts">
                        <h2 class="block-title"><?php _e('Bạn nên đọc', SHORT_NAME) ?></h2>
                        <div class="block-title-border"></div>
                        <div class="row">
                            <?php while ($loop->have_posts()) : $loop->the_post(); ?>
                            <div class="col-sm-6">
                                <div class="entry" itemscope="" itemtype="http://schema.org/Article">
                                    <a class="thumbnail" href="<?php the_permalink(); ?>" onclick="_gaq.push(['_trackEvent', 'Xem tin', 'Xem tin', '<?php the_title(); ?>']);">
                                        <img src="<?php the_post_thumbnail_url('450x267'); ?>" alt="<?php the_title(); ?>" itemprop="image" onError="this.src=no_image_url" />
                                    </a>
                                    <h3 class="entry-title" itemprop="name">
                                        <a href="<?php the_permalink(); ?>" itemprop="url" onclick="_gaq.push(['_trackEvent', 'Xem tin', 'Xem tin', '<?php the_title(); ?>']);"><?php the_title(); ?></a>
                                    </h3>
                                    <div class="entry-meta">
                                        <span><?php the_time($time_format); ?></span> | 
                                        <span itemprop="datePublished"><?php echo date($date_format, strtotime($post->post_date)); //the_date($date_format); ?></span>
                                    </div>
                                </div>
                            </div>
                            <?php endwhile; ?>
                        </div>
                    </div>
                    <?php
                    wp_reset_query();
                    endif;
                endwhile;
                ?>
            </div>
            
            <?php get_sidebar(); ?>
        </div>

        <div id="other_products" class="product-grid-container recent-posts-widget">
            <h3 class="block-title"><?php _e('Sản phẩm khác', SHORT_NAME) ?></h3>
            <div class="block-title-border"></div>
            <div class="owl-carousel">
                <?php
                $loop = new WP_Query(array(
                    'post_type' => 'product',
                    'showposts' => -1,
                    'post__not_in' => array(get_the_ID()),
                ));
                while($loop->have_posts()) : $loop->the_post();
                ?>
                <div class="entry">
                    <a class="thumbnail" href="<?php the_permalink() ?>">
                        <img alt="<?php the_title() ?>" src="<?php the_post_thumbnail_url('300x170') ?>" />
                    </a>
                    <h3><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h3>
                    <div class="price"><?php echo number_format(get_field('price'), 0, ",", "."); ?> VNĐ</div>
                    <span class="sale_tag">Sale</span>
                </div>
                <?php
                endwhile;
                wp_reset_query();
                ?>
            </div>
        </div><!--/.other-product-widget-->
    </div>
</section>

<?php get_footer(); ?>