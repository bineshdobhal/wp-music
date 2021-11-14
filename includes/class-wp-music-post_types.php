<?php

/**
 * Register custom post type
 *
 * @link       http://joe.szalai.org
 * @since      1.0.0
 *
 * @package    Exopite_Portfolio
 * @subpackage Exopite_Portfolio/includes
 */
class Wp_Music_Post_Types
{

    /**
     * Register custom post type
     *
     * @link https://codex.wordpress.org/Function_Reference/register_post_type
     */
    private function register_single_post_type($fields)
    {

        /**
         * Labels used when displaying the posts in the admin and sometimes on the front end.  These
         * labels do not cover post updated, error, and related messages.  You'll need to filter the
         * 'post_updated_messages' hook to customize those.
         */
        $labels = array(
            'name' => $fields['plural'],
            'singular_name' => $fields['singular'],
            'menu_name' => $fields['menu_name'],
            'new_item' => sprintf(__('New %s', 'plugin-name'), $fields['singular']),
            'add_new_item' => sprintf(__('Add new %s', 'plugin-name'), $fields['singular']),
            'edit_item' => sprintf(__('Edit %s', 'plugin-name'), $fields['singular']),
            'view_item' => sprintf(__('View %s', 'plugin-name'), $fields['singular']),
            'view_items' => sprintf(__('View %s', 'plugin-name'), $fields['plural']),
            'search_items' => sprintf(__('Search %s', 'plugin-name'), $fields['plural']),
            'not_found' => sprintf(__('No %s found', 'plugin-name'), strtolower($fields['plural'])),
            'not_found_in_trash' => sprintf(__('No %s found in trash', 'plugin-name'), strtolower($fields['plural'])),
            'all_items' => sprintf(__('All %s', 'plugin-name'), $fields['plural']),
            'archives' => sprintf(__('%s Archives', 'plugin-name'), $fields['singular']),
            'attributes' => sprintf(__('%s Attributes', 'plugin-name'), $fields['singular']),
            'insert_into_item' => sprintf(__('Insert into %s', 'plugin-name'), strtolower($fields['singular'])),
            'uploaded_to_this_item' => sprintf(__('Uploaded to this %s', 'plugin-name'), strtolower($fields['singular'])),

            /* Labels for hierarchical post types only. */
            'parent_item' => sprintf(__('Parent %s', 'plugin-name'), $fields['singular']),
            'parent_item_colon' => sprintf(__('Parent %s:', 'plugin-name'), $fields['singular']),

            /* Custom archive label.  Must filter 'post_type_archive_title' to use. */
            'archive_title' => $fields['plural'],
        );

        $args = array(
            'labels' => $labels,
            'description' => (isset($fields['description'])) ? $fields['description'] : '',
            'public' => (isset($fields['public'])) ? $fields['public'] : true,
            'publicly_queryable' => (isset($fields['publicly_queryable'])) ? $fields['publicly_queryable'] : true,
            'exclude_from_search' => (isset($fields['exclude_from_search'])) ? $fields['exclude_from_search'] : false,
            'show_ui' => (isset($fields['show_ui'])) ? $fields['show_ui'] : true,
            'show_in_menu' => (isset($fields['show_in_menu'])) ? $fields['show_in_menu'] : true,
            'query_var' => (isset($fields['query_var'])) ? $fields['query_var'] : true,
            'show_in_admin_bar' => (isset($fields['show_in_admin_bar'])) ? $fields['show_in_admin_bar'] : true,
            'capability_type' => (isset($fields['capability_type'])) ? $fields['capability_type'] : 'post',
            'has_archive' => (isset($fields['has_archive'])) ? $fields['has_archive'] : true,
            'hierarchical' => (isset($fields['hierarchical'])) ? $fields['hierarchical'] : true,
            'supports' => (isset($fields['supports'])) ? $fields['supports'] : array(
                'title',
                'editor',
                'excerpt',
                'author',
                'thumbnail',
                'comments',
                'trackbacks',
                'custom-fields',
                'revisions',
                'page-attributes',
                'post-formats',
            ),
            'menu_position' => (isset($fields['menu_position'])) ? $fields['menu_position'] : 21,
            'menu_icon' => (isset($fields['menu_icon'])) ? $fields['menu_icon'] : 'dashicons-admin-generic',
            'show_in_nav_menus' => (isset($fields['show_in_nav_menus'])) ? $fields['show_in_nav_menus'] : true,
            'show_in_rest' => (isset($fields['show_in_rest'])) ? $fields['show_in_rest'] : true,
        );

        if (isset($fields['rewrite'])) {

            /**
             *  Add $this->plugin_name as translatable in the permalink structure,
             *  to avoid conflicts with other plugins which may use customers as well.
             */
            $args['rewrite'] = $fields['rewrite'];
        }

        /**
         * Register Taxnonmies if any
         * @link https://codex.wordpress.org/Function_Reference/register_taxonomy
         */
        if (isset($fields['taxonomies']) && is_array($fields['taxonomies'])) {
            foreach ($fields['taxonomies'] as $taxonomy) {
                $this->register_single_post_type_taxnonomy($taxonomy);
            }

        }

        register_post_type($fields['slug'], $args);

    }

    private function register_single_post_type_taxnonomy($tax_fields)
    {

        $labels = array(
            'name' => $tax_fields['plural'],
            'singular_name' => $tax_fields['single'],
            'menu_name' => $tax_fields['plural'],
            'all_items' => sprintf(__('All %s', 'plugin-name'), $tax_fields['plural']),
            'edit_item' => sprintf(__('Edit %s', 'plugin-name'), $tax_fields['single']),
            'view_item' => sprintf(__('View %s', 'plugin-name'), $tax_fields['single']),
            'update_item' => sprintf(__('Update %s', 'plugin-name'), $tax_fields['single']),
            'add_new_item' => sprintf(__('Add New %s', 'plugin-name'), $tax_fields['single']),
            'new_item_name' => sprintf(__('New %s Name', 'plugin-name'), $tax_fields['single']),
            'parent_item' => sprintf(__('Parent %s', 'plugin-name'), $tax_fields['single']),
            'parent_item_colon' => sprintf(__('Parent %s:', 'plugin-name'), $tax_fields['single']),
            'search_items' => sprintf(__('Search %s', 'plugin-name'), $tax_fields['plural']),
            'popular_items' => sprintf(__('Popular %s', 'plugin-name'), $tax_fields['plural']),
            'separate_items_with_commas' => sprintf(__('Separate %s with commas', 'plugin-name'), $tax_fields['plural']),
            'add_or_remove_items' => sprintf(__('Add or remove %s', 'plugin-name'), $tax_fields['plural']),
            'choose_from_most_used' => sprintf(__('Choose from the most used %s', 'plugin-name'), $tax_fields['plural']),
            'not_found' => sprintf(__('No %s found', 'plugin-name'), $tax_fields['plural']),
        );

        $args = array(
            'label' => $tax_fields['plural'],
            'labels' => $labels,
            'hierarchical' => (isset($tax_fields['hierarchical'])) ? $tax_fields['hierarchical'] : true,
            'public' => (isset($tax_fields['public'])) ? $tax_fields['public'] : true,
            'show_ui' => (isset($tax_fields['show_ui'])) ? $tax_fields['show_ui'] : true,
            'show_in_nav_menus' => (isset($tax_fields['show_in_nav_menus'])) ? $tax_fields['show_in_nav_menus'] : true,
            'show_tagcloud' => (isset($tax_fields['show_tagcloud'])) ? $tax_fields['show_tagcloud'] : true,
            'meta_box_cb' => (isset($tax_fields['meta_box_cb'])) ? $tax_fields['meta_box_cb'] : null,
            'show_admin_column' => (isset($tax_fields['show_admin_column'])) ? $tax_fields['show_admin_column'] : true,
            'show_in_quick_edit' => (isset($tax_fields['show_in_quick_edit'])) ? $tax_fields['show_in_quick_edit'] : true,
            'update_count_callback' => (isset($tax_fields['update_count_callback'])) ? $tax_fields['update_count_callback'] : '',
            'show_in_rest' => (isset($tax_fields['show_in_rest'])) ? $tax_fields['show_in_rest'] : true,
            'rest_base' => $tax_fields['taxonomy'],
            'rest_controller_class' => (isset($tax_fields['rest_controller_class'])) ? $tax_fields['rest_controller_class'] : 'WP_REST_Terms_Controller',
            'query_var' => $tax_fields['taxonomy'],
            'rewrite' => (isset($tax_fields['rewrite'])) ? $tax_fields['rewrite'] : true,
            'sort' => (isset($tax_fields['sort'])) ? $tax_fields['sort'] : '',
        );

        $args = apply_filters($tax_fields['taxonomy'] . '_args', $args);

        register_taxonomy($tax_fields['taxonomy'], $tax_fields['post_types'], $args);

    }

    /**
     * Assign capabilities to users
     *
     * @link https://codex.wordpress.org/Function_Reference/register_post_type
     * @link https://typerocket.com/ultimate-guide-to-custom-post-types-in-wordpress/
     */
    public function assign_capabilities($caps_map, $users)
    {

        foreach ($users as $user) {

            $user_role = get_role($user);

            foreach ($caps_map as $cap_map_key => $capability) {

                $user_role->add_cap($capability);

            }

        }

    }

    /**
     * Create post types
     */
    public function create_custom_post_type()
    {

        /**
         * This is not all the fields, only what I find important. Feel free to change this function ;)
         *
         * @link https://codex.wordpress.org/Function_Reference/register_post_type
         */
        $post_types_fields = array(
            array(
                'slug' => 'music',
                'singular' => 'Music',
                'plural' => 'Musics',
                'menu_name' => 'Musics',
                'description' => 'Tests',
                'has_archive' => true,
                'hierarchical' => false,
                'menu_icon' => 'dashicons-tag',
                'rewrite' => array(
                    /* The slug to use for individual posts of this type. */
                    'slug' => 'music', // string (defaults to the post type name)
                    /* Whether to show the $wp_rewrite->front slug in the permalink. */
                    'with_front' => true, // bool (defaults to TRUE)
                    /* Whether to allow single post pagination via the <!--nextpage--> quicktag. */
                    'pages' => true, // bool (defaults to TRUE)
                    /* Whether to create feeds for this post type. */
                    'feeds' => true, // bool (defaults to the 'has_archive' argument)
                    /* Assign an endpoint mask to this permalink. */
                    'ep_mask' => EP_PERMALINK, // const (defaults to EP_PERMALINK)
                ),

                'menu_position' => 21,
                'public' => true,
                'publicly_queryable' => true,
                'exclude_from_search' => true,
                'show_ui' => true,
                'show_in_menu' => true,
                'query_var' => true,
                'show_in_admin_bar' => true,
                'show_in_nav_menus' => true,
                'supports' => array(
                    'title',
                    'editor',
                    'excerpt',
                    'author',
                    'thumbnail',
                    'comments',
                    'trackbacks',
                    'custom-fields',
                    'revisions',
                    'page-attributes',
                    'post-formats',
                ),
                'capability_type' => 'post',
                'taxonomies' => array(
                    array(
                        'taxonomy' => 'genre',
                        'plural' => 'Genres',
                        'single' => 'Genre',
                        'post_types' => array('music'),
                        "hierarchical" => true,
                    ),
                    array(
                        'taxonomy' => 'music_tag',
                        'plural' => 'Music Tags',
                        'single' => 'Music Tags',
                        'post_types' => array('music'),
                        'hierarchical' => false,
                    ),

                ),
            ),
        );
        foreach ($post_types_fields as $fields) {
            $this->register_single_post_type($fields);
        }
    }

}
