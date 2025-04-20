<?php 
function check_theme_update_from_github_json($transient) {
    // تأكد أن الكود يعمل فقط في صفحة تحديث الثيمات في لوحة التحكم
    if (!is_admin() || basename($_SERVER['PHP_SELF']) !== 'themes.php') {
        return $transient;
    }

    // التحقق من أنه لا يوجد تحديثات حالياً
    if (empty($transient->checked)) {
        return $transient;
    }

    // اسم الثيم الحالي
    $theme_slug = get_template(); 
    $theme_data = wp_get_theme($theme_slug);
    $current_version = $theme_data->get('Version');

    // رابط ملف JSON على GitHub (raw)
    $json_url = 'https://raw.githubusercontent.com/ibrahemgit/theme/main/theme-update.json';

    // جلب البيانات من ملف JSON
    $response = wp_remote_get($json_url, array(
        'headers' => array(
            'Accept' => 'application/json',
            'User-Agent' => 'WordPress/' . get_bloginfo('version') . '; ' . home_url()
        )
    ));

    // التعامل مع الأخطاء في الرد
    if (is_wp_error($response)) {
        return $transient;
    }

    $code = wp_remote_retrieve_response_code($response);
    $body = wp_remote_retrieve_body($response);

    // تحقق من الاستجابة
    if ($code !== 200 || empty($body)) {
        return $transient;
    }

    $data = json_decode($body);

    // التأكد من أن البيانات تحتوي على النسخة ورابط التنزيل
    if (!isset($data->version) || !isset($data->download_url)) {
        return $transient;
    }

    // مقارنة النسخة الحالية بالنسخة الجديدة
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
