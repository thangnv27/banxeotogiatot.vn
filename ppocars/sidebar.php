<?php
$product_cats = wp_list_categories(array(
    'hide_empty' => 0,
    'taxonomy' => 'product_cat',
    'title_li' => '',
    'echo' => 0,
));

//$profile_img = get_option(SHORT_NAME . "_ownerimg");
$profile_name = get_option(SHORT_NAME . "_ownername");
$profile_position = get_option(SHORT_NAME . "_ownerposition");
$profile_hotline = get_option(SHORT_NAME . "_hotline");
$profile_email = get_option(SHORT_NAME . "_email");
$profile_skype = get_option(SHORT_NAME . "_skype");

$form = do_shortcode(stripslashes_deep(get_option(SHORT_NAME . "_contactForm")));

echo <<<HTML
<div id="sidebar" class="sidebar col-lg-3 col-md-4 col-sm-5 col-xs-6" style="position: inherit">
    <section class="widget widget-categories">
        <h3 class="widget-title">
            <span class="icon"><i class="fa fa-tags" aria-hidden="true"></i></span>
            Danh mục sản phẩm
        </h3>
        <div class="widget-content"><ul>{$product_cats}</ul></div>
    </section>
        
    <section class="widget widget-profile">
        <h3 class="widget-title">
            <span class="icon"><i class="fa fa-user" aria-hidden="true"></i></span>
            Thông tin hỗ trợ
        </h3>
        <div class="row-inf pdt15">
            <div class="pull-left"><i class="fa fa-user" aria-hidden="true"></i> {$profile_name}</div>
            <div class="pull-right">{$profile_position}</div>
            <div class="clearfix"></div>
        </div>
        <div class="row-inf">
            <div class="pull-left"><i class="fa fa-phone" aria-hidden="true"></i> SĐT</div>
            <div class="pull-right">{$profile_hotline}</div>
            <div class="clearfix"></div>
        </div>
        <div class="row-inf">
            <div class="pull-left"><i class="fa fa-envelope" aria-hidden="true"></i> Email</div>
            <div class="pull-right">{$profile_email}</div>
            <div class="clearfix"></div>
        </div>
        <div class="row-inf">
            <div class="pull-left"><i class="fa fa-skype" aria-hidden="true"></i> Skype</div>
            <div class="pull-right">{$profile_skype}</div>
            <div class="clearfix"></div>
        </div>
    </section>
            
    <section class="widget widget-contact">
        <h3 class="widget-title">
            <span class="icon"><i class="fa fa-tags" aria-hidden="true"></i></span>
            Yêu cầu gửi báo giá
        </h3>
        <div class="widget-content">
            {$form}
        </div>
    </section>
</div><!-- #sidebar -->
HTML;
?>