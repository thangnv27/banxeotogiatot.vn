<section id="before_footer">
    <article>
        <?php
        $page_id = intval(get_option(SHORT_NAME . "_beforeFooter"));
        $page = get_page($page_id);
        if($page){
            echo do_shortcode($page->post_content);
        }
        ?>
    </article>
</section>