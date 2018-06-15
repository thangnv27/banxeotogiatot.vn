<?php get_header(); ?>

<section id="main" class="mt30 mb30">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <!--FEATURED POSTS CAROUSEL-->
                <?php
                $date_format = get_option( 'date_format' );
                $time_format = get_option( 'time_format' );
                $args = array(
                    'post_type' => 'post',
                    'showposts' => $instance['number_posts'],
                    'featured' => 'yes',
                    'orderby' => $instance['orderby'],
                    'order' => $instance['order'],
                );
                if(!empty($instance['cat_id']) and $instance['cat_id'] > 0){
                    $args['cat'] = $instance['cat_id'];
                }
                $FeaturedPost_query = new WP_Query($args);
                ?>
                <div class="featured-carousel owl-carousel">
                    <?php
                    while ($FeaturedPost_query->have_posts()) : $FeaturedPost_query->the_post();
                        $title = get_the_title();
                        $permalink = get_permalink();
                        $thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
                        $no_image_url = get_template_directory_uri() . "/assets/images/no_image.png";
                        $date = date($date_format, strtotime($post->post_date));
                        $time = get_the_time($time_format);
                    ?>
                    <div class="entry" itemscope="" itemtype="http://schema.org/Article">
                        <a href="<?php echo $permalink ?>" onclick="_gaq.push(['_trackEvent', 'Xem tin', 'Xem tin', '<?php echo $title ?>']);">
                            <img src="<?php echo $thumbnail_url ?>" alt="<?php echo $title ?>" itemprop="image" onError="this.src=<?php echo $no_image_url ?>" />
                            <span class="caption">
                                <h3 class="entry-title" itemprop="name"><?php echo $title ?></h3>
                                <span class="entry-meta">
                                    <span><?php echo $time ?></span> | <span itemprop="datePublished"><?php echo $date ?></span>
                                </span>
                            </span>
                        </a>
                    </div>
                    <?php
                    endwhile;
                    wp_reset_query();
                    ?>
                </div>
                <!--/FEATURED POSTS CAROUSEL-->
                
                <div class="archive-content">
                    <?php
                    if(have_posts()):
                        while (have_posts()) : the_post();
                            get_template_part('content', get_post_format());
                        endwhile;
                    else:
                    ?>
                    <div class="col-sm-12">
                        <p><?php _e('Chưa có bài viết.', SHORT_NAME) ?></p>
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