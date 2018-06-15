<?php
if(!is_home() and ! is_front_page()){
    get_template_part('template/before-footer');
}

$profile_name = get_option(SHORT_NAME . "_ownername");
$profile_hotline = get_option(SHORT_NAME . "_hotline");
$profile_email = get_option(SHORT_NAME . "_email");
$user_avatar = get_option(SHORT_NAME . "_ownerimg2");
if(empty($user_avatar)){
    $user_avatar = get_template_directory_uri() . '/assets/images/tu-van.png';
}
?>
<section id="footer">
    <div class="container">
        <div class="footer-widgets">
            <div class="row">
                <div class="col-sm-4 col-xs-12">
                    <?php if ( is_active_sidebar( 'footer1' ) ) { dynamic_sidebar( 'footer1' ); } ?>
                </div>
                <div class="col-sm-2 col-xs-5 hidden-xs">
                    <?php if ( is_active_sidebar( 'footer2' ) ) { dynamic_sidebar( 'footer2' ); } ?>
                </div>
                <div class="col-sm-3 col-xs-12">
                    <?php if ( is_active_sidebar( 'footer3' ) ) { dynamic_sidebar( 'footer3' ); } ?>
                </div>
                <div class="col-sm-3 col-xs-6 hidden-xs">
                    <?php if ( is_active_sidebar( 'footer4' ) ) { dynamic_sidebar( 'footer4' ); } ?>
                </div>
            </div>
            <div class="t_center">
                <a class="btn-hotline" href="tel:<?php echo $profile_hotline ?>">HOTLINE: <?php echo $profile_hotline ?></a>
            </div>
        </div>
    </div>
    <div class="copyright">
        <div class="container">
            <?php
            $copyright = get_option('copyright_text');
            if(!empty($copyright)):
            ?>
            <span>Copyright &copy; <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo $copyright; ?>"><?php echo $copyright; ?></a>. All rights reserved. </span>
            <a href="http://ppo.vn" title="Thiết kế web chuyên nghiệp" target="_blank"><?php _e('Thiết kế web bởi PPO.VN', SHORT_NAME) ?></a>
            <?php else: ?>
            <span>Copyright &COPY; <a href="http://ppo.vn" title="Thiết kế website">PPO.VN</a>. All rights reserved.</span>
            <?php endif; ?>
        </div>
    </div>
</section>

<div id="myModal" class="modal fade" role="dialog">
    <div class="clickableclose"></div>
    <div class="modal-dialog wide">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" id="close-modal">×</button>
                <h4 class="modal-title hide"><?php _e('Đăng ký tư vấn miễn phí', SHORT_NAME) ?></h4>
            </div>
            <div class="modal-body pdt0">
                <div row>
                    <div class="col-sm-4 t_center">
                        <img alt="Tư vấn miễn phí" src="<?php echo $user_avatar; ?>" />
                        <div class="name"><?php echo $profile_name ?></div>
                    </div>
                    <div class="col-sm-8">
                        <?php echo do_shortcode(stripslashes_deep(get_option(SHORT_NAME . "_contactForm"))) ?>
                    </div>
                    <div class="hotline">Gửi thư về <strong><a href="mailto:<?php echo $profile_email ?>"><?php echo $profile_email ?></a></strong> 
                        hoặc gọi <strong><a class="rf_hotline" href="tel:<?php echo $profile_hotline ?>"><?php echo $profile_hotline ?></a> (<?php echo $profile_name ?>)</strong> để được tư vấn trực tiếp</div>
                </div>
            </div>
            <div class="modal-footer">
                <span data-dismiss="modal"><a href="javascript:void(0)"><?php _e('Đóng', SHORT_NAME) ?></a></span>
            </div>
        </div>
    </div>
</div>

<div class="btn-regiser"><i class="fa fa-usd"></i> <?php _e('Báo giá', SHORT_NAME) ?></div>
<div id="scroll-to-top"></div>
<?php wp_footer(); ?>
<div id="fb-root"></div>
<script>
Modernizr.load({
    load: [
        '<?php echo get_template_directory_uri(); ?>/assets/css/font-awesome.min.css',
        '<?php echo get_template_directory_uri(); ?>/assets/css/animate.min.css',
        '<?php echo get_template_directory_uri(); ?>/assets/css/addquicktag.min.css',
        '<?php echo get_template_directory_uri(); ?>/assets/css/owl.carousel.min.css',
        '<?php echo get_template_directory_uri(); ?>/assets/flexslider/flexslider.css',
        '<?php echo get_template_directory_uri(); ?>/assets/photoswipe/photoswipe.css',
        '<?php echo get_template_directory_uri(); ?>/assets/photoswipe/default-skin/default-skin.css',
        '<?php echo get_template_directory_uri(); ?>/assets/fancybox/jquery.fancybox.min.css',
        '<?php echo get_template_directory_uri(); ?>/assets/css/wp-default.min.css',
        '<?php echo get_template_directory_uri(); ?>/assets/css/common.min.css',
//        'https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js',  
//        '<?php echo get_template_directory_uri(); ?>/assets/js/jquery.min.js',
//        '<?php echo get_template_directory_uri(); ?>/assets/js/jquery-migrate.min.js',
        '<?php echo get_template_directory_uri(); ?>/assets/js/jquery-ui.min.js',
        '<?php echo get_template_directory_uri(); ?>/assets/js/bootstrap.min.js',
        '<?php echo get_template_directory_uri(); ?>/assets/js/jquery-scrolltofixed-min.js',
        '<?php echo get_template_directory_uri(); ?>/assets/js/owl.carousel.min.js',
        '<?php echo get_template_directory_uri(); ?>/assets/flexslider/jquery.flexslider-min.js',
        '<?php echo get_template_directory_uri(); ?>/assets/photoswipe/photoswipe.min.js',
        '<?php echo get_template_directory_uri(); ?>/assets/photoswipe/photoswipe-ui-default.min.js',
        '<?php echo get_template_directory_uri(); ?>/assets/fancybox/jquery.fancybox.min.js',
        '<?php echo get_template_directory_uri(); ?>/assets/js/app.min.js'
//        '<?php echo get_template_directory_uri(); ?>/assets/js/disable-copy.js'
//        '<?php echo includes_url('js/wp-embed.min.js'); ?>'
    ]
});
</script>
<script src="https://apis.google.com/js/platform.js" async defer></script>
</body>
</html>