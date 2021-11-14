<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://wppb.me/
 * @since      1.0.0
 *
 * @package    Wp_Music
 * @subpackage Wp_Music/public/partials
 */
?>
<h1>binesh</h1>

<?php
if ($musics->have_posts()): ?>
    <div class="musics">
        <?php
        while ($musics->have_posts()) : $musics->the_post(); ?>
            <div class="music">
                <?php
                global $post;
                $custom = get_post_custom($post->ID);
                ?>
                <?php the_title(); ?>
                <p><?php _e('Composer Name:', $this->plugin_name); ?> <?php echo $custom["composer_name"][0] ?></p>
                <p><?php _e('Publisher:', $this->plugin_name); ?>: <?php echo $custom["publisher"][0] ?></p>
                <p><?php _e('Year:', $this->plugin_name); ?>: <?php echo $custom["year_recording"][0] ?></p>
                <p><?php _e('Additional Contributors:', $this->plugin_name); ?>: <?php echo $custom["contributors"][0] ?></p>
                <p><?php _e('URL:', $this->plugin_name); ?>: <a href="<?php echo $custom["url"][0] ?>">Listen </a></>
                <p><?php _e('Price:', $this->plugin_name); ?>: <?php echo $custom["price"][0] ?></p>
            </div>
        <?php
        endwhile;
        wp_reset_postdata();
        ?>
    </div>
<?php endif; ?>
