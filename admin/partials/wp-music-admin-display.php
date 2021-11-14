<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://wppb.me/
 * @since      1.0.0
 *
 * @package    Wp_Music
 * @subpackage Wp_Music/admin/partials
 */
?>
<div class="wrap">
    <h2> <?php esc_attr_e('Wp Music Settings', 'plugin_name'); ?></h2>

    <form method="post" name="<?php echo $this->plugin_name; ?>" action="options.php">
        <?php
        //Grab all options
        $options = get_option($this->plugin_name);
        $selected_currency = (isset($options['currency']) && !empty($options['currency'])) ? esc_attr($options['currency']) : 'USD'; //default USD

        $selected_page = (isset($options['results']) && !empty($options['results'])) ? esc_attr($options['results']) : 10; //default 10
        settings_fields($this->plugin_name);
        do_settings_sections($this->plugin_name);
        $currencies = [
            'USD' => 'USD',
            'CAD' => 'CAD',
            'INR' => 'INR'
        ];

        $per_pages = [
            10, 20, 30, 50
        ];
        ?>

        <!-- Select -->
        <fieldset>
            <p><?php esc_attr_e('Select Currency.', $this->plugin_name); ?></p>
            <legend class="screen-reader-text">
                <span><?php esc_attr_e('Select Currency', $this->plugin_name); ?></span>
            </legend>
            <label for="currency">
                <select name="<?php echo $this->plugin_name; ?>[currency]"
                        id="<?php echo $this->plugin_name; ?>-currency">
                    <?php foreach ($currencies as $currency => $currencyVal): ?>
                        <option <?php if ($selected_currency == $currency) echo 'selected="selected"'; ?>
                                value="<?php echo $currency ?>"><?php echo $currencyVal ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>
        </fieldset>

        <fieldset>
            <p><?php esc_attr_e('Result per Page.', $this->plugin_name); ?></p>
            <legend class="screen-reader-text">
                <span><?php esc_attr_e('Result per Page', $this->plugin_name); ?></span>
            </legend>
            <label for="currency">
                <select name="<?php echo $this->plugin_name; ?>[results]"
                        id="<?php echo $this->plugin_name; ?>-results">
                    <?php foreach ($per_pages as $page): ?>
                        <option <?php if ($selected_page == $page) echo 'selected="selected"'; ?>
                                value="<?php echo $page ?>"><?php echo $page ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>
        </fieldset>


        </fieldset>


        <?php submit_button(__('Save all changes', 'plugin_name'), 'primary', 'submit', TRUE); ?>
    </form>
</div>


<!-- This file should primarily consist of HTML with a little bit of PHP. -->
