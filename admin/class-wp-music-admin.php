<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://wppb.me/
 * @since      1.0.0
 *
 * @package    Wp_Music
 * @subpackage Wp_Music/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp_Music
 * @subpackage Wp_Music/admin
 * @author     Binesh Dobhal <bineshdobhal@gamail.com>
 */
class Wp_Music_Admin
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
     * @param string $plugin_name The name of this plugin.
     * @param string $version The version of this plugin.
     * @since    1.0.0
     */
    public function __construct($plugin_name, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

    }

    /**
     * Register the stylesheets for the admin area.
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

        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/wp-music-admin.css', array(), $this->version, 'all');

    }

    /**
     * Register the JavaScript for the admin area.
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

        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/wp-music-admin.js', array('jquery'), $this->version, false);

    }


    // Save custom fields
    public function save_meta_options()
    {

        if (!current_user_can('edit_posts')) return;
        global $post;
        update_post_meta($post->ID, "composer_name", $_POST["composer_name"]);
        update_post_meta($post->ID, "publisher", $_POST["publisher"]);
        update_post_meta($post->ID, "year_recording", $_POST["year_recording"]);
        update_post_meta($post->ID, "contributors", $_POST["contributors"]);
        update_post_meta($post->ID, "url", $_POST["url"]);
        update_post_meta($post->ID, "price", $_POST["price"]);
    }

    /* Create a meta box for our custom fields */
    public function rerender_meta_options()
    {
        add_meta_box("music-meta", "Music Details", array($this, "display_meta_options"), "music", "normal", "low");

    }

// Display meta box and custom fields
    public function display_meta_options()
    {

        global $post;
        $custom = get_post_custom($post->ID);

        $composer_name = $custom["composer_name"][0];
        ?>
        <label><?php _e('Composer Name:', $this->plugin_name); ?></label><input name="composer_name"
                                                                                value="<?php echo $composer_name; ?>"/>
        <br/>
        <?php

        $publisher = $custom["publisher"][0];
        ?>
        <label><?php _e('Publisher:', $this->plugin_name); ?></label><input name="publisher"
                                                                            value="<?php echo $publisher; ?>"/>
        <br/>
        <?php

        $year_recording = $custom["year_recording"][0];
        ?>
        <label><?php _e('Year of recording:', $this->plugin_name); ?></label><input name="year_recording"
                                                                                    value="<?php echo $year_recording; ?>"/>
        <br/>

        <?php

        $contributors = $custom["contributors"][0];
        ?>
        <label><?php _e('Additional Contributors:', $this->plugin_name); ?></label><input name="contributors"
                                                                                          value="<?php echo $contributors; ?>"/>
        <br/>
        <?php

        $url = $custom["url"][0];
        ?>
        <label><?php _e('Url:', $this->plugin_name); ?></label><input name="url" value="<?php echo $url; ?>"/>
        <br/>
        <?php

        $price = $custom["price"][0];
        ?>
        <label><?php _e('Price:', $this->plugin_name); ?></label><input name="price" value="<?php echo $price; ?>"/>
        <br/>

        <?php

    }

    function create_menu()
    {
        add_submenu_page('edit.php?post_type=music', $this->plugin_name, 'Settings', 'administrator', $this->plugin_name, array(
            $this,
            'display_plugin_setup_page'
        ), null);
    }


    /**
     * Render the settings page for this plugin.
     *
     * @since    1.0.0
     */
    public function display_plugin_setup_page()
    {

        include_once('partials/' . $this->plugin_name . '-admin-display.php');
    }

    public function options_update()
    {
        register_setting($this->plugin_name, $this->plugin_name, array(
            'sanitize_callback' => array($this, 'validate'),
        ));
    }

    /**
     * Validate fields from admin area plugin settings form ('exopite-lazy-load-xt-admin-display.php')
     * @param mixed $input as field form settings form
     * @return mixed as validated fields
     */
    public function validate($input)
    {
        $options = get_option($this->plugin_name);
        $options['currency'] = (isset($input['currency']) && !empty($input['currency'])) ? esc_attr($input['currency']) : 'USD';
        $options['results'] = (isset($input['results']) && !empty($input['results'])) ? esc_attr($input['results']) : 10;
        return $options;
    }

}
