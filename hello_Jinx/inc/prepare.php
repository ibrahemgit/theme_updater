<?php 
add_action('after_switch_theme', 'auto_install_plugins_on_theme_activation');

function auto_install_plugins_on_theme_activation() {
    include_once ABSPATH . 'wp-admin/includes/file.php';
    include_once ABSPATH . 'wp-admin/includes/misc.php';
    include_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
    include_once ABSPATH . 'wp-admin/includes/plugin-install.php';
    include_once ABSPATH . 'wp-admin/includes/plugin.php';

    // =======================
    // 1. بلجن GitHub (Ibrahem)
    // =======================
    $plugin_folder_github    = 'page_builder_br';
    $plugin_main_file_github = 'page_builder_br/plugin.php';
    $plugin_zip_url_github   = 'https://github.com/ibrahemgit/page_builder_br/archive/refs/heads/main.zip';

    if (!is_dir(WP_PLUGIN_DIR . '/' . $plugin_folder_github)) {
        $tmp_file = download_url($plugin_zip_url_github);
        if (!is_wp_error($tmp_file)) {
            $upgrader = new Plugin_Upgrader(new WP_Ajax_Upgrader_Skin());
            $result = $upgrader->install($plugin_zip_url_github);

            if (!is_wp_error($result)) {
                // أعد تسمية فولدر البلجن لو نزل باسم مختلف
                $source_folder = WP_PLUGIN_DIR . '/' . $plugin_folder_github . '-main';
                $final_folder  = WP_PLUGIN_DIR . '/' . $plugin_folder_github;

                if (is_dir($source_folder)) {
                    rename($source_folder, $final_folder);
                }
            }
        }
    }

    if (file_exists(WP_PLUGIN_DIR . '/' . $plugin_main_file_github) && !is_plugin_active($plugin_main_file_github)) {
        activate_plugin($plugin_main_file_github);
    }

    // ===========================
    // 2. بلجن Google Site Kit
    // ===========================
    $sitekit_slug      = 'google-site-kit';
    $sitekit_main_file = 'google-site-kit/google-site-kit.php';

    if (!is_dir(WP_PLUGIN_DIR . '/' . $sitekit_slug)) {
        $upgrader = new Plugin_Upgrader(new WP_Ajax_Upgrader_Skin());
        $upgrader->install('https://downloads.wordpress.org/plugin/' . $sitekit_slug . '.latest-stable.zip');
    }

    if (file_exists(WP_PLUGIN_DIR . '/' . $sitekit_main_file) && !is_plugin_active($sitekit_main_file)) {
        activate_plugin($sitekit_main_file);
    }
}

// إنشاء بوست thankyou وقت تفعيل الثيم
function create_thxyou_post_on_theme_activation() {
    $existing_post = get_page_by_title('thankyou', OBJECT, 'thankyou');

    if (!$existing_post) {
        $post_data = array(
            'post_title'    => 'thankyou',
            'post_status'   => 'publish',
            'post_type'     => 'thankyou'
        );

        wp_insert_post($post_data);
    }
}

add_action('after_switch_theme', 'create_thxyou_post_on_theme_activation');
