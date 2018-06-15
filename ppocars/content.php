<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 */

if (is_single()) :
?>
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <meta itemscope itemprop="mainEntityOfPage"  itemType="https://schema.org/WebPage" itemid="<?php the_permalink() ?>"/>
        <meta itemprop="datePublished" content="<?php echo get_the_date( 'l, d/m/Y, h:i A', get_the_ID() ); ?>"/>
        <meta itemprop="dateModified" content="<?php echo get_the_date( 'l, d/m/Y, h:i A', get_the_ID() ); ?>"/>
        <header class="entry-header">
            <?php the_title('<h1 class="entry-title">', '</h1>'); ?>

            <div class="entry-meta">
                <?php
                if ('post' == get_post_type())
                    ppo_posted_on();

                /*
                if (!post_password_required() && ( comments_open() || get_comments_number() )) :
                    ?>
                    <span class="comments-link"><?php comments_popup_link(__('<i class="fa fa-comment"></i> Comments', SHORT_NAME), __('<i class="fa fa-comment"></i> 1 Comment', SHORT_NAME), __('<i class="fa fa-comment"></i> % Comments', SHORT_NAME)); ?></span>
                    <?php
                endif;
                */

                edit_post_link(__('<i class="fa fa-pencil"></i> Chỉnh sửa', SHORT_NAME), '<span class="edit-link">', '</span>');
                ?>
            </div><!-- .entry-meta -->
            <?php
            $image_url = get_the_post_thumbnail_url('full');
            if(empty($image_url)){
                $image_url = get_bloginfo('stylesheet_directory') . "/assets/images/no_image.png";
            }
            ?>
            <div itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
                <meta itemprop="url" content="<?php echo $image_url; ?>">
                <meta itemprop="width" content="200">
                <meta itemprop="height" content="200">
            </div>
            <div itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
                <div itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">
                    <meta itemprop="url" content="<?php echo get_option("sitelogo"); ?>">
                    <meta itemprop="width" content="150">
                    <meta itemprop="height" content="150">
                </div>
                <meta itemprop="name" content="<?php echo $_SERVER['HTTP_HOST'] ?>"/>
                <meta itemprop="url" content="<?php bloginfo('siteurl') ?>"/>
            </div>
        </header><!-- .entry-header -->

        <div class="entry-content">
            <?php
            /* translators: %s: Name of current post */
            the_content( sprintf( __('Xem thêm <span class="meta-nav">&rarr;</span>', SHORT_NAME) ) );

            wp_link_pages(array(
                'before' => '<div class="page-links"><span class="page-links-title">' . __('Trang:', SHORT_NAME) . '</span>',
                'after' => '</div>',
                'link_before' => '<span>',
                'link_after' => '</span>',
            ));
            ?>
        </div><!-- .entry-content -->

        <?php the_tags('<footer class="entry-meta"><span class="tag-links"><i class="fa fa-tags"></i> ', ', ', '</span></footer>'); ?>
    </article><!-- #post-## -->
<?php
else:
    $date_format = get_option( 'date_format' );
    $time_format = get_option( 'time_format' );
?>
    <div class="entry" itemscope="" itemtype="http://schema.org/Article">
        <div class="col-md-4">
            <a class="thumbnail" href="<?php the_permalink(); ?>" onclick="_gaq.push(['_trackEvent', 'Xem tin', 'Xem tin', '<?php the_title(); ?>']);">
                <img src="<?php the_post_thumbnail_url('medium'); ?>" alt="<?php the_title(); ?>" itemprop="image" onError="this.src=no_image_url" />
            </a>
        </div>
        <div class="col-md-8">
            <h3 class="entry-title" itemprop="name">
                <a href="<?php the_permalink(); ?>" itemprop="url" onclick="_gaq.push(['_trackEvent', 'Xem tin', 'Xem tin', '<?php the_title(); ?>']);"><?php the_title(); ?></a>
            </h3>
            <div class="entry-meta">
                <span><?php the_time($time_format); ?></span> | 
                <span itemprop="datePublished"><?php echo date($date_format, strtotime($post->post_date)); //the_date($date_format); ?></span>
            </div>
            <div class="description"><?php the_excerpt() ?></div>
        </div>
    </div>
<?php endif; ?>