<?php 
function check_theme_update_from_github_json($transient) {


    // تأكد أن هناك ثيمات مثبتة
    if (empty($transient->checked)) {
        return $transient;
    }

    // اسم مجلد الثيم
    $theme_slug = 'hello_Jinx';
    $theme_data = wp_get_theme($theme_slug);
    $current_version = $theme_data->get('Version');

    // رابط ملف JSON على GitHub (raw)
    $json_url = 'https://raw.githubusercontent.com/ibrahemgit/theme_updater/main/hello_Jinx/theme-update.json';

    // جلب بيانات التحديث
    $response = wp_remote_get($json_url, array(
        'headers' => array(
            'Accept' => 'application/json',
            'User-Agent' => 'WordPress/' . get_bloginfo('version') . '; ' . home_url()
        )
    ));

    if (is_wp_error($response)) {
        return $transient;
    }

    $code = wp_remote_retrieve_response_code($response);
    $body = wp_remote_retrieve_body($response);

    if ($code !== 200 || empty($body)) {
        return $transient;
    }

    $data = json_decode($body);

    if (!isset($data->version) || !isset($data->download_url)) {
        return $transient;
    }

    // مقارنة النسخة الحالية بالجديدة
    if (version_compare($current_version, $data->version, '<')) {
        $transient->response[$theme_slug] = array(
            'theme'       => $theme_slug,
            'new_version' => $data->version,
            'url'         => isset($data->details_url) ? $data->details_url : '',
            'package'     => $data->download_url
        );
    }

    return $transient;
}

add_filter('site_transient_update_themes', 'check_theme_update_from_github_json');
