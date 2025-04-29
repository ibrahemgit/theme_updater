jQuery(document).ready(function($){
  // عند الضغط على الأزرار التي تحتوي على الكلاسات المحددة
  $('.submit, .whatsapp, .phone').on('click', function(e){
      
      var buttonClass = $(this).attr('class'); // جلب الكلاس
      var postId = $('body').attr('id'); // الحصول على معرف المنشور (الصفحة أو المقالة)
      
      var data = {
          action: 'track_button_clicks',
          button_class: buttonClass,
          post_id: postId // إرسال معرف المنشور (صفحة أو مقال)
      };
      
      // إجراء طلب AJAX
      $.post(ajax_object.ajax_url, data, function(response) {
        // هنا يمكنك إضافة كود لعرض النتيجة إذا أردت
      });
  });
});


function validatePhoneInput(input) {
    let value = input.value;

    // تحويل الأرقام العربية إلى أرقام إنجليزية
    let arabicToEnglishMap = {
        '٠': '0', '١': '1', '٢': '2', '٣': '3', '٤': '4',
        '٥': '5', '٦': '6', '٧': '7', '٨': '8', '٩': '9'
    };

    value = value.replace(/[٠-٩]/g, function(match) {
        return arabicToEnglishMap[match];
    });

    // السماح فقط بالأرقام وعلامة "+"
    value = value.replace(/[^0-9+]/g, '');

    // التأكد من أن "+" لا يظهر إلا في بداية الرقم فقط
    if (value.includes('+')) {
        value = '+' + value.replace(/\+/g, '');
    }

    // تحديث قيمة الإدخال
    input.value = value;
}



jQuery(document).ready(function($) {

  $('.projects_slide').slick({
    rtl: true, // تفعيل دعم RTL
    autoplay: true,
    accessibility: true, // هذه القيمة تمكن الوصول وتحسن التوافق مع ARIA
    dots: true,
    infinite: true,
    speed: 300,
    slidesToShow: 3,
    arrows: false, // تأكد من عدم وجود تكرار للخاصية
    responsive: [
      {
        breakpoint: 1024, // عرض الشاشة 1024 بكسل أو أقل
        settings: {
          slidesToShow: 2, // عرض شريحتين
          infinite: true,
          dots: true
        }
      },
      {
        breakpoint: 768, // عرض الشاشة 768 بكسل أو أقل
        settings: {
          slidesToShow: 1, // عرض شريحة واحدة
        }
      }
    ]
  });

  $('.gallry_imgs').slick({
    rtl: true, // دعم RTL
    autoplay: true,
    accessibility: true,
    dots: false,
    infinite: true,
    speed: 500,
    slidesToShow: 3, // عرض 3 لوجوهات فقط في نفس الوقت
    slidesToScroll: 1,
    centerMode: true, // تفعيل وضع المركزية
    variableWidth: true, // السماح للأحجام المتغيرة
    focusOnSelect: true, // تمكين التركيز عند النقر
    arrows: true,
    responsive: [
      {
        breakpoint: 1024, // للشاشات المتوسطة
        settings: {
          slidesToShow: 3,
              infinite: true,
              centerMode: true
            }
          },
          {
            breakpoint: 768, // للشاشات الصغيرة
            settings: {
                infinite: true,
                slidesToShow: 2,
                centerMode: true
            }
        }
    ]
});



	
  $('.contact_us .submit').on('click', function(event) {
      event.preventDefault();

    var form = $(this).closest('form'); 

      // التحقق من صحة النموذج قبل الإرسال
      if (!form[0].checkValidity()) {
          form[0].reportValidity(); // عرض رسائل التنبيه الافتراضية للمتصفح
          return; // إيقاف التنفيذ إذا كان هناك خطأ
      }

    var phone = form.find('input[name="phone"]').val().trim();
	  
    var phonePattern = /^[+\d]+$/; // يسمح فقط بالأرقام وحرف +

    if (!phonePattern.test(phone) || phone.length < 10) {
        alert('يجب إدخال رقم هاتف صالح .');
        return; // إيقاف التنفيذ إذا كان الرقم غير صالح
    }
	  
	      function cleanURL(url) {
        var urlObj = new URL(url);
        var paramsToRemove = ["utm_medium", "utm_source", "utm_id", "utm_content", "utm_term", "utm_campaign", "fbclid"];
        paramsToRemove.forEach(param => urlObj.searchParams.delete(param));
        return urlObj.origin + urlObj.pathname;
    }

	  
    var ifprshorshort = form.hasClass('prshorshort');
    var ifunitform = form.hasClass('unform');
    var timeZone = Intl.DateTimeFormat().resolvedOptions().timeZone;
    var pUrl = cleanURL(location.href);
    var PTitle = document.title;
    var pageTitle = PTitle + "\n -- \n" + pUrl;
    var post_id = $('body').attr('id');
    
    var formData = {
        action: 'submit_contact_form', 
        name: form.find('input[name="name"]').val(), 
        message: form.find('textarea[name="message"]').val(), 
        phone: form.find('input[name="phone"]').val(), 
        email: form.find('input[name="email"]').val(), 
        preferred_time: form.find('select[name="selc-time"]').val(), 
        preferred_time: form.find('select[name="selc-time"]').val(), 
        contact: form.find('input[name="contact[]"]:checked').map(function() {
          return $(this).val();
        }).get(),
        is_prshorshort: ifprshorshort ? "1" : "0",
        is_unitform: ifunitform ? "1" : "0",
        timeZone: timeZone,
        pageTitle: pageTitle,
        post_id: post_id, 
    };
  

    console.log(ajax_object);  // اطبع اسم الكاتب هنا في وحدة التحكم

    
    $.ajax({
      url: ajax_object.ajax_url,
      type: 'POST',
      dataType: 'json',
      data: {
          action: 'submit_to_google_form_action',
          name: formData.name,
          phone: formData.phone,
          title: PTitle,
          url: pUrl,
          zone : timeZone,
          team: ajax_object.author_name,
      },
      success: function(response) {
        console.log('✅ Response:', response);
      },
      error: function(xhr, status, error) {
        console.error('❌ AJAX Error:', status, error);
        console.error('Response Text:', xhr.responseText);
      }
    });
    


    $.ajax({
        url: ajax_object.ajax_url,
        type: 'POST',
        data: formData,
        success: function(response) {
          
          form.find('input[type="text"], input[type="phone"]').val('');

          if (ajax_object.thank_you_url) {
            window.location.href = ajax_object.thank_you_url;
          }
          
        },
        error: function(xhr, status, error) {
        }
    });




  });
  

  $('.mobile-menu').on('click', function() {
    $('.mobilemenu').toggleClass( "active" );
  });
  
  $('.mobilemenu .menu-item-has-children > a').on('click', function(event) {
    event.preventDefault(); // منع السلوك الافتراضي للرابط
});
$('.mobilemenu .menu-item-has-children').click(function(){
	$(this).toggleClass('active')
    $(this).find('ul.sub-menu').toggleClass('active')
});

$('.flx-thx').click(function(){
  $('.flx-thx').removeClass( "active" );
  $('.aqaarop').removeClass('active');
});




$('.aqaarop .close, .aqaarop .bgclos').on('click', function() {
  $('.aqaarop').removeClass('active');
});

$('.towitem .subform').on('click', function() {
  $('.aqaarop').addClass('active');
});

});





