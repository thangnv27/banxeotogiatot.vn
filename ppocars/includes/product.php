<?php

/**
 * Products Menu Page
 */

# Custom product post type
add_action('init', 'create_product_post_type');

function create_product_post_type(){
    register_post_type('product', array(
        'labels' => array(
            'name' => __('Products'),
            'singular_name' => __('Products'),
            'add_new' => __('Add new'),
            'add_new_item' => __('Add new Product'),
            'new_item' => __('New Product'),
            'edit' => __('Edit'),
            'edit_item' => __('Edit Product'),
            'view' => __('View Product'),
            'view_item' => __('View Product'),
            'search_items' => __('Search Products'),
            'not_found' => __('No Product found'),
            'not_found_in_trash' => __('No Product found in trash'),
        ),
        'public' => true,
        'show_ui' => true,
        'publicy_queryable' => true,
        'exclude_from_search' => false,
        'menu_position' => 5,
        'hierarchical' => false,
        'query_var' => true,
        'supports' => array(
            'title', 'editor', 'thumbnail', 'comments', 
            //'custom-fields', 'author', 'excerpt',
        ),
        'rewrite' => array('slug' => 'product', 'with_front' => false),
        'can_export' => true,
        'has_archive' => true,
        'description' => __('Product description here.')
    ));
}

# Custom product taxonomies
add_action('init', 'create_product_taxonomies');

function create_product_taxonomies(){
    register_taxonomy('product_cat', 'product', array(
        'hierarchical' => true,
        'labels' => array(
            'name' => __('Product Categories'),
            'singular_name' => __('Product Categories'),
            'add_new' => __('Add New'),
            'add_new_item' => __('Add New Category'),
            'new_item' => __('New Category'),
            'search_items' => __('Search Categories'),
        ),
        'rewrite' => array('slug' => 'danh-muc', 'with_front' => false),
    ));
}

// Show filter
add_action('restrict_manage_posts','restrict_product_by_product_category');
function restrict_product_by_product_category() {
    global $wp_query, $typenow;
    if ($typenow=='product') {
        $taxonomies = array('product_cat');
        foreach ($taxonomies as $taxonomy) {
            $category = get_taxonomy($taxonomy);
            wp_dropdown_categories(array(
                'show_option_all' =>  __("$category->label"),
                'taxonomy'        =>  $taxonomy,
                'name'            =>  $taxonomy,
                'value_field'     =>  'slug',
                'orderby'         =>  'name',
                'selected'        =>  $wp_query->query['term'],
                'hierarchical'    =>  true,
                'depth'           =>  3,
                'show_count'      =>  true, // Show # listings in parens
                'hide_empty'      =>  true, // Don't show businesses w/o listings
            ));
        }
    }
}


/***************************************************************************/

// ADD NEW COLUMN  
function product_columns_head($defaults) {
    unset($defaults['comments']);
    unset($defaults['date']);
    $defaults['cat'] = __('Categories', SHORT_NAME);
    $defaults['date'] = __('Date');
    return $defaults;
}

// SHOW THE COLUMN
function product_columns_content($column_name, $post_id) {
    switch ($column_name) {
        case 'cat':
            $taxonomy = 'product_cat';
            $terms = get_the_terms($post_id, $taxonomy);
            if(is_array($terms)){
                foreach ($terms as $key => $term) {
                    echo '<a href="' . get_edit_tag_link($term->term_id, $taxonomy) . '" target="_blank">' . $term->name . '</a>';
                    if($key < count($terms) - 1){
                        echo ", ";
                    }
                }
            }
            break;
        default:
            break;
    }
}

add_filter('manage_product_posts_columns', 'product_columns_head');  
add_action('manage_product_posts_custom_column', 'product_columns_content', 10, 2); 