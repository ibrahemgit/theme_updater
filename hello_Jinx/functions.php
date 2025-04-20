<?php






function ib_files(){
    $theme_version = wp_get_theme()->get('Version');

    wp_enqueue_style('ficons', get_template_directory_uri() . '/assets/ficons.css' , array(), $theme_version);
    
    wp_enqueue_style('slick', get_template_directory_uri() . '/assets/slick/slick.css' , array(), $theme_version);

    wp_enqueue_script('slick-js', get_template_directory_uri() . '/assets/slick/slick.js', array('jquery'), $theme_version, true);
    
    wp_enqueue_style('min_style', get_template_directory_uri() . '/assets/min_style.css' , array(), $theme_version);

    wp_enqueue_style('responsive', get_template_directory_uri() . '/assets/responsive.css' , array(), $theme_version);
    
    wp_enqueue_script('min_scripts', get_template_directory_uri() . '/assets/min_scripts.js', array('jquery'), $theme_version, true);

    $latest_thankyou_post = get_posts(array(
        'post_type'      => 'thankyou',
        'posts_per_page' => 1,
        'orderby'        => 'date',
        'order'          => 'DESC',
    ));

    $thank_you_url = '';

    if (!empty($latest_thankyou_post)) {
        $thank_you_url = get_permalink($latest_thankyou_post[0]->ID);
    }

    // تمرير البيانات إلى JavaScript
    wp_localize_script('min_scripts', 'ajax_object', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'thank_you_url' => $thank_you_url, // ✅ إرسال رابط صفحة الشكر
    ));


}
add_action( 'wp_enqueue_scripts', 'ib_files');

#############################
####  add_theme_support
#############################
function ib_theme_support(){
    add_theme_support('widgets');
    add_theme_support( 'custom-units' );
    add_theme_support( 'responsive-embeds' );
    add_filter('use_default_gallery_style', '__return_false');
	remove_theme_support('widgets-block-editor');
	// remove_theme_support('post-formats');
    // add_filter('use_block_editor_for_post_type', '__return_false');
    // add_filter('gutenberg_can_edit_post_type', '__return_false');


    add_theme_support('title-tag');
	add_theme_support('automatic-feed-links');
	// add_theme_support('post-thumbnails');
	add_theme_support('html5', array('comment-list', 'comment-form', 'search-form', 'gallery', 'caption', 'style', 'script'));
}
add_action( 'after_setup_theme', 'ib_theme_support' );




// الفنكشن التي ستتعامل مع الطلبات
function track_button_clicks() {
    if (isset($_POST['button_class']) && isset($_POST['post_id'])) {
        $button_class = sanitize_text_field($_POST['button_class']);
        $post_id = sanitize_text_field($_POST['post_id']); // الصفحة أو المقالة الحالية
        
        // تحديد المفتاح الفريد بناءً على الكلاس والمقالة أو الصفحة
        $button_key = 'click_count_' . $post_id . '_' . $button_class; // مثال: click_count_123_submit
        
        // الحصول على عدد الضغطات الحالي
        $current_count = get_option($button_key, 0); // الحصول على العدد الحالي
        $current_count++;
        
        // تحديث العدد في قاعدة البيانات
        update_option($button_key, $current_count);
        
        // إرجاع النتيجة
        echo $current_count;
    }
    
    wp_die(); // إنهاء العملية
}
add_action('wp_ajax_track_button_clicks', 'track_button_clicks'); // للمستخدمين المسجلين
add_action('wp_ajax_nopriv_track_button_clicks', 'track_button_clicks'); // للمستخدمين غير المسجلين



require get_template_directory() . '/inc/contact-us-page-functions.php';
require get_template_directory() . '/inc/prepare.php';
require get_template_directory() . '/inc/crateposttype.php';
require get_template_directory() . '/inc/admin-pages.php';
require get_template_directory() . '/inc/update.php';
require get_template_directory() . '/inc/users.php';
require get_template_directory() . '/inc/cusrole.php';

