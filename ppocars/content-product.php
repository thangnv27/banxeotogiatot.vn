<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <meta itemscope itemprop="mainEntityOfPage"  itemType="https://schema.org/WebPage" itemid="<?php the_permalink() ?>"/>
    <meta itemprop="datePublished" content="<?php echo get_the_date( 'l, d/m/Y, h:i A', get_the_ID() ); ?>"/>
    <meta itemprop="dateModified" content="<?php echo get_the_date( 'l, d/m/Y, h:i A', get_the_ID() ); ?>"/>
    <header class="entry-header">
        <?php the_title('<h1 class="entry-title product-title" itemprop="name">', '</h1>'); ?>
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

    <div class="entry-content product-content">
        <div class="row">
            <div class="col-sm-7">
                <?php
                $gallery = get_field("gallery");

                if(count($gallery) > 0):
                ?>
                <a href="#" class="product-gallery__trigger"><img draggable="false" class="emoji" alt="🔍" src="https://s.w.org/images/core/emoji/2.2.1/svg/1f50d.svg"></a>
                <div id="gallery_slider" class="flexslider">
                    <ul class="slides">
                        <?php foreach ($gallery as $_gallery) { ?>
                        <li>
                            <img data-large_image="<?php echo $_gallery['url']; ?>" data-large_image_width="<?php echo $_gallery['sizes']['large-width']; ?>" 
                                data-large_image_height="<?php echo $_gallery['sizes']['large-height']; ?>" src="<?php echo $_gallery['url']; ?>" 
                                alt="<?php echo $_gallery['title']; ?>" />
                        </li>
                        <?php } ?>
                    </ul>
                </div>
                <div id="gallery_nav" class="flexslider">
                    <ul class="slides">
                        <?php foreach ($gallery as $_gallery) { ?>
                        <li>
                            <img src="<?php echo $_gallery['sizes']['thumbnail']; ?>" alt="<?php echo $_gallery['title']; ?>" />
                        </li>
                        <?php } ?>
                    </ul>
                </div>

                <!-- Root element of PhotoSwipe. Must have class pswp. -->
                <div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">

                    <!-- Background of PhotoSwipe. 
                         It's a separate element as animating opacity is faster than rgba(). -->
                    <div class="pswp__bg"></div>

                    <!-- Slides wrapper with overflow:hidden. -->
                    <div class="pswp__scroll-wrap">

                        <!-- Container that holds slides. 
                            PhotoSwipe keeps only 3 of them in the DOM to save memory.
                            Don't modify these 3 pswp__item elements, data is added later on. -->
                        <div class="pswp__container">
                            <div class="pswp__item"></div>
                            <div class="pswp__item"></div>
                            <div class="pswp__item"></div>
                        </div>

                        <!-- Default (PhotoSwipeUI_Default) interface on top of sliding area. Can be changed. -->
                        <div class="pswp__ui pswp__ui--hidden">
                            <div class="pswp__top-bar">

                                <!--  Controls are self-explanatory. Order can be changed. -->
                                <div class="pswp__counter"></div>
                                <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>
                                <button class="pswp__button pswp__button--share" title="Share"></button>
                                <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>
                                <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>

                                <!-- Preloader demo http://codepen.io/dimsemenov/pen/yyBWoR -->
                                <!-- element will get class pswp__preloader--active when preloader is running -->
                                <div class="pswp__preloader">
                                    <div class="pswp__preloader__icn">
                                        <div class="pswp__preloader__cut">
                                            <div class="pswp__preloader__donut"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                                <div class="pswp__share-tooltip"></div> 
                            </div>
                            <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)"></button>
                            <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)"></button>
                            <div class="pswp__caption">
                                <div class="pswp__caption__center"></div>
                            </div>
                        </div>
                    </div>
                </div><!--/.pswp-->
                <?php endif; ?>
                
                <?php show_share_socials(); ?>
            </div>
            
            <div class="col-sm-5">
                <div class="product-price">
                    <div class="label"><?php _e('Giá bán', SHORT_NAME) ?>:</div>
                    <div class="price"><?php echo number_format(get_field('price'), 0, ",", ".") ?> VNĐ</div>
                </div>
                <div class="product-info">
                    <div class="table-responsive">
                        <table class="table">
                            <tr>
                                <th><strong><?php _e('Khuyến mại', SHORT_NAME) ?>:</strong></th>
                                <td><?php the_field('promo') ?></td>
                            </tr>
                            <tr>
                                <th><strong><?php _e('Xuất xứ', SHORT_NAME) ?>:</strong></th>
                                <td><?php the_field('madein') ?></td>
                            </tr>
                            <tr>
                                <th><strong><?php _e('Năm sản xuất', SHORT_NAME) ?>:</strong></th>
                                <td><?php the_field('nam_sx') ?></td>
                            </tr>
                            <tr>
                                <th><strong><?php _e('Bảo hành', SHORT_NAME) ?>:</strong></th>
                                <td><?php the_field('guarantee') ?></td>
                            </tr>
                            <tr>
                                <th><strong><?php _e('Tình trạng', SHORT_NAME) ?>:</strong></th>
                                <td><?php the_field('status') ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="meta-product">
                    <div class="code-banner">
                        <a href="<?php echo get_option(SHORT_NAME . "_promoURL") ?>" target="_blank">
                            <img alt="Khuyến mại" src="<?php echo get_option(SHORT_NAME . "_promoBanner") ?>" />
                        </a>
                    </div>
                    <div class="call-pro">
                        <a href="tel:<?php echo get_option(SHORT_NAME . "_hotline") ?>" class="call">
                            <i class="fa fa-phone"></i> Gọi ngay HOTLINE
                            <span>(Tư vấn thủ tục mua xe, mua xe trả góp)</span>
                        </a>
                        <a class="btn btn-primary order" data-toggle="modal" href="#myModal">
                            Đăng ký báo giá + lái thử
                            <span>(Đăng ký báo giá để có giá tốt nhất, lái thử tận nơi)</span>
                        </a>
                    </div>
                </div>
<!--                <div class="product-contact">
                    <a href="tel:<?php echo get_option(SHORT_NAME . "_hotline") ?>">
                        <span><?php _e('Đặt hàng', SHORT_NAME) ?></span>
                        <?php _e('Liên hệ', SHORT_NAME); ?>: <?php echo get_option(SHORT_NAME . "_hotline") ?>
                    </a>
                </div>-->
            </div>
        </div>
        
        <div id="product-content-tabs">
            <ul>
                <li><a href="#tabs-1"><?php _e('Thông Tin Chi Tiết', SHORT_NAME) ?></a></li>
                <li><a href="#tabs-2"><?php _e('Video', SHORT_NAME) ?></a></li>
                <li><a href="#tabs-3"><?php _e('Hướng dẫn', SHORT_NAME) ?></a></li>
                <li><a href="#tabs-4"><?php _e('Bình luận & Đánh giá', SHORT_NAME) ?></a></li>
            </ul>
            <div id="tabs-1">
                <?php the_content() ?>
            </div>
            <div id="tabs-2" style="display: none">
                <?php the_field('video') ?>
            </div>
            <div id="tabs-3" style="display: none">
                <?php the_field('user_guide') ?>
            </div>
            <div id="tabs-4" style="display: none">
                <?php
                // If comments are open or we have at least one comment, load up the comment template.
                if (comments_open() || get_comments_number()) {
                    comments_template();
                }
                ?>
            </div>
        </div>
    </div><!-- .entry-content -->

    <?php the_tags('<footer class="entry-meta"><span class="tag-links"><i class="fa fa-tags"></i> ', ', ', '</span></footer>'); ?>
</article><!-- #post-## -->