<?php
/**
 * Plugin Name:       Blupry Table Lite FREE Version
 * Plugin URI:        https://blupry.io
 * Description:       A FREE version of the Blupry Comparison Table plugin. Includes basic features and upgrade options.
 * Version:           1.1.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Blupry
 * Author URI:        https://blupry.io
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       blupry-table-lite
 */

// Admin Menu
function bct_add_theme_page() {
    add_menu_page('Comparison Table Settings FREE Version', 'Comparison Table FREE Version', 'manage_options', 'bct-plugin-option', 'bct_create_page', 'dashicons-chart-bar', 102);
}
add_action('admin_menu', 'bct_add_theme_page');

// Admin CSS + JS
function bct_add_admin_assets($hook) {
    if ($hook !== 'toplevel_page_bct-plugin-option') return;

    wp_enqueue_style('bct-admin-style', plugins_url('css/bct-admin-style.css', __FILE__), false, '1.0.0');
    wp_enqueue_style('bct-preview-css', plugins_url('css/bct-premium.css', __FILE__), false, '1.0.0');

    wp_enqueue_script('bct-admin-js', plugins_url('js/bct-admin-script.js', __FILE__), array('jquery'), '1.0.0', true);
}

add_action('admin_enqueue_scripts', 'bct_add_admin_assets');

// Frontend CSS
function bct_enqueue_assets() {
    if (is_admin()) {
        wp_enqueue_style('bct-preview-css', plugins_url('css/bct-premium.css', __FILE__));
    }
    
    wp_enqueue_style('bct-premium-style', plugins_url('css/bct-premium.css', __FILE__));
    wp_enqueue_script('bct-frontend-js', plugins_url('js/bct-frontend.js', __FILE__), array('jquery'), '1.0.0', true);
}
add_action("wp_enqueue_scripts", "bct_enqueue_assets");

// Admin Page
function bct_create_page() {
    ?>
    <div class="bnb_main_area">
        <div class="bnb_body_area">
            <h3>Blupry Comparison Table Settings</h3>
            <form action="options.php" method="post">
                <?php settings_fields('bct-settings-group'); do_settings_sections('bct-settings-group'); ?>

                <label>Table Title</label>
                <input type="text" name="bct-table-title" value="<?php echo esc_attr(get_option('bct-table-title', 'Why Choose Us?')); ?>">

                <label>Custom Header Text</label>
                <input type="text" name="bct-header-text" value="<?php echo esc_attr(get_option('bct-header-text', 'Feature')); ?>">

                <label>Custom Us Text</label>
                <input type="text" name="bct-us-text" value="<?php echo esc_attr(get_option('bct-us-text', 'Us')); ?>">

                <label>Custom Competitor Text</label>
                <input type="text" name="bct-competitor-text" value="<?php echo esc_attr(get_option('bct-competitor-text', 'Competitor')); ?>">

                <label>Table Items</label>
                <div id="bct-table-items-container">
                    <?php
                    $table_items = get_option('bct-table-items', []);
                    if (!empty($table_items) && is_array($table_items)) {
                        foreach ($table_items as $index => $row) {
                            ?>
                            <div class="bct-table-item">
                                <input type="text" name="bct-table-items[<?php echo $index; ?>][feature]" placeholder="Feature" value="<?php echo esc_attr($row['feature']); ?>" />
                                <input type="text" name="bct-table-items[<?php echo $index; ?>][us]" placeholder="Us" value="<?php echo esc_attr($row['us']); ?>" />
                                <input type="text" name="bct-table-items[<?php echo $index; ?>][competitor]" placeholder="Competitor" value="<?php echo esc_attr($row['competitor']); ?>" />
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
                <button type="button" id="add-bct-item">+ Add Feature</button>

                <label>Display On</label>
<select name="bct-visibility">
    <option value="all" <?php selected(get_option('bct-visibility'), 'all'); ?>>All Pages</option>
    <option value="home" <?php selected(get_option('bct-visibility'), 'home'); ?>>Homepage Only</option>
    <option value="specific" <?php selected(get_option('bct-visibility'), 'specific'); ?>>Specific Page</option>
    <option value="shortcode" <?php selected(get_option('bct-visibility'), 'shortcode'); ?>>Shortcode (add this: [blupry_comparison_table] )</option>
</select>


                <label>Specific Page Slug (if selected above)</label>
                <input type="text" name="bct-specific-page" value="<?php echo esc_attr(get_option('bct-specific-page')); ?>">
<!-- 🔐 Premium Locked Options -->
<div id="premium-lock-wrapper" style="position: relative; margin-top: 30px;">
    <div class="bct-premium-blur-area">
        <div class="bct-premium-blur-group">

            <label>Color Scheme</label>
            <input type="color" value="#0047ff" readonly>

            <label>Background Color</label>
            <input type="color" value="#ffffff" readonly>

            <label>Header Background Color</label>
            <input type="color" value="#1e1e28" readonly>

            <label>Text Color</label>
            <input type="color" value="#141419" readonly>

            <label>Border Color</label>
            <input type="color" value="#e6e6f0" readonly>

            <label>Row Hover Background</label>
            <input type="color" value="#f5f8ff" readonly>

            <label>Row Hover Text Color</label>
            <input type="color" value="#000000" readonly>

            <label>Header Font Size (px)</label>
            <input type="number" value="20" readonly>

            <label>Cell Padding (px)</label>
            <input type="number" value="18" readonly>

            <label>Row Hover Animation</label>
            <select disabled><option>scale</option></select>

            <label>Row Separator Style</label>
            <select disabled><option>dashed</option></select>

            <label>Border Radius (px)</label>
            <input type="number" value="14" readonly>

            <label>Font Size (px)</label>
            <input type="number" value="17" readonly>

            <label>Animation Type</label>
            <select disabled><option>fade</option></select>

            <label>Mobile Layout</label>
            <select disabled><option>stack</option></select>

        </div>
    </div>

    <style>
    .bct-premium-blur-area {
        filter: blur(0.4px);
        pointer-events: none;
        position: relative;
        opacity: 0.85;
    }

    .bct-premium-blur-group label,
    .bct-premium-blur-group input,
    .bct-premium-blur-group select {
        position: relative;
        display: block;
        margin-bottom: 14px;
        filter: none;
        pointer-events: auto;
        opacity: 0.6;
        transition: all 0.2s ease;
    }

    .bct-premium-blur-group input,
    .bct-premium-blur-group select {
        cursor: not-allowed;
    }

    .bct-premium-blur-group label::after,
    .bct-premium-blur-group input::after,
    .bct-premium-blur-group select::after {
        content: "🚫";
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 14px;
        color: #cc0000;
        pointer-events: none;
    }

    .bct-premium-blur-group input:hover::before,
    .bct-premium-blur-group select:hover::before,
    .bct-premium-blur-group label:hover::before {
        content: "🚫 Available in Pro";
        position: absolute;
        right: 50%;
        top: -32px;
        transform: translateX(50%);
        background: #222;
        color: #fff;
        font-size: 12px;
        padding: 6px 10px;
        border-radius: 6px;
        white-space: nowrap;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
        z-index: 999;
        pointer-events: none;
    }
</style>


    <!-- 🔗 CTA Overlay -->
    <div style="
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        z-index: 200;
        backdrop-filter: blur(2px);
        background: rgba(255, 255, 255, 0.55);
        border-radius: 12px;
        text-align: center;
        padding: 32px;
    ">
        <h3 style="font-size: 20px; font-weight: 600; margin-bottom: 10px;">
            🔒 Premium Features Locked
        </h3>
        <p style="margin: 0 0 10px; font-size: 14px;">Upgrade to unlock all customization options</p>
        <p style="margin: 0 0 20px; font-size: 13px; color: #666;">Unlocking also removes the table watermark</p>
        <a href="https://checkout.stripe.com/pay/cs_test_YourStripeLinkHere" target="_blank" style="
            background: #0047ff;
            color: white;
            padding: 10px 26px;
            border-radius: 6px;
            font-weight: 600;
            text-decoration: none;
            transition: background 0.3s;
        " onmouseover="this.style.background='#0031cc'" onmouseout="this.style.background='#0047ff'">
            Unlock via Stripe
        </a>
    </div>
</div>




                <?php submit_button(); ?>
            </form>
            <h3 style="margin-top: 40px;">Live Preview</h3>
<div id="bct-preview-wrapper" style="margin-top: 20px;">
    <?php echo bct_render_table(true);  ?>
</div>

        </div>
        <div class="bnb_sidebar_area">
            <h3>Blupry</h3>
            <p><img src="<?php echo plugin_dir_url(__FILE__) . 'img/blupry.com (1).svg'; ?>" style="max-width: 100%; height: auto;" alt="Blupry Logo"></p>
            <p><strong>Blupry</strong> builds high-end WordPress plugins and nocode tools.</p>
            <p><a href="mailto:bluprycs@gmail.com">bluprycs@gmail.com</a></p>
            <p><a href="https://blupry.io" target="_blank" class="btn">Visit Blupry.io</a></p>
        </div>
    </div>
    <?php
}

function bct_render_table($is_preview = false) {
    $items = get_option('bct-table-items', []);

    if ($is_preview && empty($items)) {
        // Default dummy data for preview only
        $items = [
            ['feature' => 'Full Customization Panel', 'us' => '✅ Live control', 'competitor' => '❌ Basic toggles'],
            ['feature' => 'One-time Purchase', 'us' => '✅ Pay once', 'competitor' => '❌ Subscription'],
            ['feature' => 'Modern UI', 'us' => '✅ Animations + Icons', 'competitor' => '❌ Plain table']
        ];
    }

    if (!$is_preview && empty($items)) return '';

    // Public (Free) options
    $title = get_option('bct-table-title', 'Why Choose Us?');
    $header_text = get_option('bct-header-text', 'Feature');
    $us_text = get_option('bct-us-text', 'Us');
    $competitor_text = get_option('bct-competitor-text', 'Competitor');

    // Premium styling options (hardcoded for FREE version)
    $color = '#0047ff';
    $bg_color = '#ffffff';
    $header_bg = '#1e1e28';
    $text_color = '#141419';
    $border_color = '#e6e6f0';
    $hover_bg = '#f5f8ff';
    $hover_text = '#000000';
    $header_font_size = 20;
    $cell_padding = 18;
    $row_separator = 'dashed';
    $radius = 14;
    $font_size = 17;
    $animation = 'fade';
    $mobile_layout = 'stack';

    // CSS variables for inline styling
    $css_vars = sprintf('
        --bct-radius: %dpx;
        --bct-color: %s;
        --bct-font-size: %dpx;
        --bct-text-color: %s;
        --bct-border-color: %s;
        --bct-header-bg: %s;
        --bct-bg-color: %s;
        --bct-hover-bg: %s;
        --bct-hover-text: %s;
        --bct-header-font-size: %dpx;
        --bct-cell-padding: %dpx;
        --bct-row-separator: %s;
    ',
        $radius,
        esc_attr($color),
        $font_size,
        esc_attr($text_color),
        esc_attr($border_color),
        esc_attr($header_bg),
        esc_attr($bg_color),
        esc_attr($hover_bg),
        esc_attr($hover_text),
        $header_font_size,
        $cell_padding,
        esc_attr($row_separator)
    );

    ob_start(); ?>
    <div class="bct-table-wrapper" data-animation="<?php echo esc_attr($animation); ?>" style="<?php echo $css_vars; ?>">
        <?php if ($is_preview): ?>
            <div style="text-align:center; margin-bottom: 8px; font-size: 14px; font-weight: 600; color: #999;">
                Live Preview
            </div>
        <?php endif; ?>

        <h2 style="text-align:center; margin-bottom: 20px; color: <?php echo esc_attr($color); ?>; font-size: <?php echo $font_size + 6; ?>px;">
            <?php echo esc_html($title); ?>
        </h2>

        <table class="bct-table" data-hover="scale">
            <thead>
                <tr>
                    <th><?php echo esc_html($header_text); ?></th>
                    <th><?php echo esc_html($us_text); ?></th>
                    <th><?php echo esc_html($competitor_text); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $row): 
                    if (empty($row['feature']) && empty($row['us']) && empty($row['competitor'])) continue;
                ?>
                    <tr>
                        <td data-label="<?php echo esc_attr($header_text); ?>"><?php echo esc_html($row['feature']); ?></td>
                        <td data-label="<?php echo esc_attr($us_text); ?>"><?php echo esc_html($row['us']); ?></td>
                        <td data-label="<?php echo esc_attr($competitor_text); ?>"><?php echo esc_html($row['competitor']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div style="text-align: right; padding: 8px; font-size: 12px; color: #888;">
            made by <a href="https://blupry.io/" target="_blank" style="color: #0047ff; text-decoration: none;">Blupry.io</a>
        </div>
    </div>
    <?php
    return ob_get_clean();
}


// Register Settings
function bct_register_settings() {
    $settings = [
        'bct-accent-color',
        'bct-bg-color',
        'bct-header-bg-color',
        'bct-text-color',
        'bct-border-color',
        'bct-hover-bg-color',
        'bct-hover-text-color',
        'bct-header-font-size',
        'bct-cell-padding',
        'bct-hover-animation',
        'bct-row-separator-style',
        'bct-radius',
        'bct-font-size',
        'bct-animation',
        'bct-mobile-layout',
        'bct-table-title',
        'bct-header-text',
        'bct-us-text',
        'bct-competitor-text',
        'bct-visibility',
        'bct-specific-page',
        'bct-table-items'
    ];

    foreach ($settings as $s) {
        register_setting('bct-settings-group', $s);
    }
}
add_action('admin_init', 'bct_register_settings');



function bct_display_table_auto() {
    $visibility = get_option('bct-visibility');
    $current_slug = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

    if ($visibility === 'shortcode') return;

    if (
        ($visibility === 'home' && !is_front_page()) ||
        ($visibility === 'specific' && $current_slug !== trim(get_option('bct-specific-page')))
    ) return;

    echo bct_render_table();
}


// Default settings for Blupry Table Lite
function bct_set_default_options() {
    if (get_option('bct-accent-color') === false) update_option('bct-accent-color', 'rgb(0, 102, 255)');
    if (get_option('bct-bg-color') === false) update_option('bct-bg-color', 'rgb(255, 255, 255)');
    if (get_option('bct-header-bg-color') === false) update_option('bct-header-bg-color', 'rgb(30, 30, 40)');
    if (get_option('bct-text-color') === false) update_option('bct-text-color', 'rgb(20, 20, 25)');
    if (get_option('bct-border-color') === false) update_option('bct-border-color', 'rgb(230, 230, 240)');
    if (get_option('bct-hover-bg-color') === false) update_option('bct-hover-bg-color', 'rgb(245, 248, 255)');
    if (get_option('bct-hover-text-color') === false) update_option('bct-hover-text-color', 'rgb(0, 0, 0)');
    if (get_option('bct-header-font-size') === false) update_option('bct-header-font-size', 20);
    if (get_option('bct-cell-padding') === false) update_option('bct-cell-padding', 18);
    if (get_option('bct-hover-animation') === false) update_option('bct-hover-animation', 'scale');
    if (get_option('bct-row-separator-style') === false) update_option('bct-row-separator-style', 'dashed');
    if (get_option('bct-radius') === false) update_option('bct-radius', 14);
    if (get_option('bct-font-size') === false) update_option('bct-font-size', 17);
    if (get_option('bct-animation') === false) update_option('bct-animation', 'fade');
    if (get_option('bct-mobile-layout') === false) update_option('bct-mobile-layout', 'stack');
}
add_action('admin_init', 'bct_set_default_options');

add_action('wp_body_open', 'bct_display_table_auto');

add_shortcode('blupry_comparison_table', 'bct_render_table');  