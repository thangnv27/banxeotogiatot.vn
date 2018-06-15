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
                <?php
                // Start the Loop.
                while (have_posts()) : the_post();

                    /*
                     * Include the post format-specific template for the content. If you want to
                     * use this in a child theme, then include a file called called content-___.php
                     * (where ___ is the post format) and that will be used instead.
                     */
                    get_template_part('content', get_post_format());

                    // Previous/next post navigation.
                    ppo_post_nav();

                    $terms = get_the_category();
                    $terms_id = array();
                    foreach ($terms as $term) {
                        array_push($terms_id, $term->term_id);
                    }
                    $date_format = get_option( 'date_format' );
                    $time_format = get_option( 'time_format' );
                    $loop = new WP_Query(array(
                        'post_type' => 'post',
                        'category__in' => $terms_id,
                        'post__not_in' => array(get_the_ID()),
                        'showposts' => 4,
                    ));
                    if($loop->post_count > 0):
                ?>
                    <div class="related-posts">
                        <h2 class="title"><?php _e('Bạn nên đọc', SHORT_NAME) ?></h2>
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

                    // If comments are open or we have at least one comment, load up the comment template.
                    if (comments_open() || get_comments_number()) {
                        comments_template();
                    }
                endwhile;
                ?>
            </div>
            
            <?php get_sidebar(); ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>