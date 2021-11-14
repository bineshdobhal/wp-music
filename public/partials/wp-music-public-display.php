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
                <p>Composer Name: <?php echo $custom["composer_name"][0] ?></p>
                <p>Publisher: <?php echo $custom["publisher"][0] ?></p>
                <p>Year: <?php echo $custom["year_recording"][0] ?></p>
                <p>Additional Contributors: <?php echo $custom["contributors"][0] ?></p>
                <p>URL: <a href="<?php echo $custom["url"][0] ?>">Listen </a></>
                <p>Price: <?php echo $custom["price"][0] ?></p>
            </div>
        <?php
        endwhile;
        wp_reset_postdata();
        ?>
    </div>
<?php endif; ?>
