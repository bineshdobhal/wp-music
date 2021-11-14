<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://wppb.me/
 * @since      1.0.0
 *
 * @package    Wp_Music
 * @subpackage Wp_Music/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Wp_Music
 * @subpackage Wp_Music/public
 * @author     Binesh Dobhal <bineshdobhal@gamail.com>
 */
class Wp_Music_Public
{

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $plugin_name The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $version The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @param string $plugin_name The name of the plugin.
     * @param string $version The version of this plugin.
     * @since    1.0.0
     */
    public function __construct($plugin_name, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Wp_Music_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Wp_Music_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/wp-music-public.css', array(), $this->version, 'all');

    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Wp_Music_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Wp_Music_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/wp-music-public.js', array('jquery'), $this->version, false);

    }

    function music($atts = array())
    {
        $options = get_option($this->plugin_name);
        $per_page = (isset($input['results']) && !empty($input['results'])) ? esc_attr($input['results']) : 10;
        $param = shortcode_atts(
            array(
                'year' => '',
                'genre' => '',
            ),
            $atts
        );
        $args = [
            'post_type' => 'music',
            'posts_per_page' => $per_page,
            'orderby' => 'ASC',
        ];

        $musics = new WP_Query($args);
        if ($param['year']) {
            $args['meta_query'] = [
                [
                    'key' => 'year',
                    'compare' => '=',
                    'value' => $param['year'],
                ],
            ];
        }
        if ($param['genre']) {
            $args['tax_query'] = [
                [
                    'taxonomy' => 'year',
                    'field' => 'slug',
                    'value' => $param['genre'],
                ],
            ];
        }
        $count = $musics->found_posts;
        include('partials/' . $this->plugin_name . '-public-display.php');
    }

}
