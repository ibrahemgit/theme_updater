<?php
        // remove_role('ib_sub_admin'); // حذف الرول الحالي

function create_ib_sub_admin_role() {
    // التأكد من أن الرول غير موجود بالفعل
    if (!get_role('ib_sub_admin')) {
        // إضافة الرول الجديد
        add_role(
            'ib_sub_admin', // اسم الرول
            'Ib Sub Admin', // الاسم الظاهر للرول
            array(
                // الصلاحيات المتاحة للمستخدمين في هذا الرول
                'read' => true, // الصلاحية الأساسية لقراءة المحتوى
                'edit_posts' => true, // التعديل على المقالات
                'edit_pages' => true, // التعديل على الصفحات
                'edit_others_posts' => true, // التعديل على المقالات الخاصة بالآخرين
                'delete_posts' => true, // حذف المقالات
                'delete_others_posts' => true, // حذف مقالات الآخرين
                'publish_posts' => true, // نشر المقالات
                'edit_private_posts' => true, // تعديل المقالات الخاصة
                'edit_published_posts' => true, // تعديل المقالات المنشورة
                'read_private_posts' => true, // قراءة المقالات الخاصة
                'edit_private_pages' => true, // تعديل الصفحات الخاصة
                'edit_published_pages' => true, // تعديل الصفحات المنشورة
                'read_private_pages' => true, // قراءة الصفحات الخاصة
                'manage_options' => true, // لا يمكن إدارة الإعدادات
                'install_plugins' => false, // لا يمكن تحميل الإضافات
                'update_plugins' => false, // لا يمكن تحديث الإضافات
                'delete_plugins' => false, // لا يمكن حذف الإضافات
                'edit_plugins' => false, // لا يمكن تعديل الإضافات
                'install_themes' => false, // لا يمكن رفع ثيمات
                'edit_themes' => false, // لا يمكن تعديل الثيمات
                'delete_themes' => false, // لا يمكن حذف الثيمات
                'switch_themes' => false, // لا يمكن تغيير الثيم النشط
                'activate_plugins' => false, // لا يمكن تفعيل/تعطيل الإضافات
                'edit_users' => false, // لا يمكن تعديل المستخدمين
                'create_users' => false, // لا يمكن إضافة مستخدمين جدد
                'delete_users' => false, // لا يمكن حذف مستخدمين
                'promote_users' => false, // لا يمكن ترقية أو تعديل رتبة المستخدمين
                'remove_users' => false, // لا يمكن إزالة مستخدمين من الأدوار
            )
        );
    }
}
add_action('init', 'create_ib_sub_admin_role');
