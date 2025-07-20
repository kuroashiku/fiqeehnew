<?php

use Illuminate\Support\Facades\Route;
use App\Course;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@index')->name('home');
Route::get('/kelas-homapage', 'HomeController@hompageKelas')->name('home_kelas');
Route::get('clear', 'HomeController@clearCache')->name('clear_cache');
Route::get('close-survey/{id}', 'HomeController@closeSurvey')->name('close_survey');


Route::get('installations', 'InstallationController@installations')->name('installations');
Route::get('installations/step/2', 'InstallationController@installationsTwo')->name('installations_step_two');
Route::post('installations/step/2', 'InstallationController@installationPost');
Route::get('installations/step/final', 'InstallationController@installationFinal')->name('installation_final');

/**
 * Authentication 
 */
 
Route::get('login', 'AuthController@login')->name('login')->middleware('guest');
Route::get('login-afiliasi', 'AuthController@loginAfiliasi')->name('login_afiliasi')->middleware('guest');
Route::post('login', 'AuthController@loginPost');

Route::any('logout', 'AuthController@logoutPost')->name('logout');

Route::get('register', 'AuthController@register')->name('register')->middleware('guest');
Route::get('register-afiliasi', 'AuthController@registerAfiliasi')->name('register_afiliasi')->middleware('guest');
Route::get('register/{slug}', 'AuthController@registerCourse')->name('register_course')->middleware('guest');
Route::post('register', 'AuthController@registerPost');

Route::get('forgot-password', 'AuthController@forgotPassword')->name('forgot_password');
Route::post('forgot-password', 'AuthController@sendResetToken');
Route::get('forgot-password/reset/{token}', 'AuthController@passwordResetForm')->name('reset_password_link');
Route::post('forgot-password/reset/{token}', 'AuthController@passwordReset');

Route::group(['prefix' => 'login'], function () {
    //Social login route
    Route::get('facebook', 'AuthController@redirectFacebook')->name('facebook_redirect');
    Route::get('facebook/callback', 'AuthController@callbackFacebook')->name('facebook_callback');

    Route::get('google', 'AuthController@redirectGoogle')->name('google_redirect');
    Route::get('google/callback', 'AuthController@callbackGoogle')->name('google_callback');

    Route::get('twitter', 'AuthController@redirectTwitter')->name('twitter_redirect');
    Route::get('twitter/callback', 'AuthController@callbackTwitter')->name('twitter_callback');

    Route::get('linkedin', 'AuthController@redirectLinkedIn')->name('linkedin_redirect');
    Route::get('linkedin/callback', 'AuthController@callbackLinkedIn')->name('linkin_callback');
});

Route::group(['prefix' => 'afiliasi'], function () { 
    Route::get('login', 'AuthAfiliasiController@login')->name('afiliasi-login')->middleware('guest');
    Route::post('login', 'AuthAfiliasiController@loginPost');

    Route::post('register', 'AuthAfiliasiController@registerPost')->name('afiliasi-register')->middleware('guest');
});
Route::group(['middleware' => ['auth']], function () {
    Route::get('payment-detail', 'AuthController@paymentDetail')->name('payment_detail');
    Route::post('payment-detail', 'AuthController@paymentDetailPost')->name('save_payment_detail');
    Route::get('payment-waiting', 'AuthController@paymentWaiting')->name('payment_waiting');
});
  
Route::get('kelas/{slug?}', 'CourseController@view')->name('course');
Route::get('ketegori/{category_slug}', 'CategoriesController@show')->name('category_view');
Route::get('marketplace/{slug}/{lecture_id}', 'CourseController@lectureView')->name('markeplace_view');

Route::group(['middleware' => ['auth']], function () {
    Route::get('kelas-saya', 'HomeController@sudahDitonton')->name('kelas_saya');
    
    Route::get('kelas-favorite', 'HomeController@kelasFavorite')->name('kelas_favorite');
});

Route::group(['middleware' => ['auth', 'checkPackage']], function () {
    Route::get('beranda', 'HomeController@beranda')->name('beranda');
    Route::get('semua-kelas', 'HomeController@berandaKelas')->name('semua_kelas');

    Route::post('kelas/{slug}/assignment/{assignment_id}', 'CourseController@assignmentSubmitting');
    Route::get('content_complete/{content_id}', 'CourseController@contentComplete')->name('content_complete');
    Route::post('courses-complete/{course_id}', 'CourseController@complete')->name('course_complete');

    Route::get('profile/{id}', 'UserController@profile')->name('profile');
    Route::get('review/{id}', 'UserController@review')->name('review');

    Route::get('kelas', 'HomeController@courses')->name('courses');
    Route::get('featured-courses', 'HomeController@courses')->name('featured_courses');
    Route::get('popular-courses', 'HomeController@courses')->name('popular_courses');

    Route::post('kelas/enroll', 'CourseController@freeEnroll')->name('free_enroll');
    Route::get('kelas/enroll/{slug}', 'CourseController@getFreeEnroll')->name('get_free_enroll');

    Route::get('kelas/{slug}/lecture/{lecture_id}', 'CourseController@lectureView')->name('single_lecture');
    Route::get('kelas/{slug}/assignment/{assignment_id}', 'CourseController@assignmentView')->name('single_assignment');
    Route::get('kelas/{slug}/quiz/{quiz_id}', 'QuizController@quizView')->name('single_quiz');

    Route::get('kelas/{slug}/{lecture_id}', 'CourseController@lectureView')->name('single_lecture_slug');

    Route::get('topics', 'CategoriesController@home')->name('categories');
    //Get Topics Dropdown for course creation category select
    Route::post('get-topic-options', 'CategoriesController@getTopicOptions')->name('get_topic_options');


    //Attachment Download
    Route::get('attachment-download/{hash}', 'CourseController@attachmentDownload')->name('attachment_download');

    Route::get('payment-thank-you', 'PaymentController@thankYou')->name('payment_thank_you_page');

    Route::group(['prefix' => 'checkout'], function () {
        Route::get('/', 'CartController@checkout')->name('checkout');
        Route::post('bank-transfer', 'GatewayController@bankPost')->name('bank_transfer_submit');
        Route::post('paypal', 'GatewayController@paypalRedirect')->name('paypal_redirect');
        Route::post('offline', 'GatewayController@payOffline')->name('pay_offline');
    });

    Route::post('save-review/{course_id?}', 'CourseController@writeReview')->name('save_review');
    Route::post('update-wishlist', 'UserController@updateWishlist')->name('update_wish_list');

    Route::post('discussion/ask-question', 'DiscussionController@askQuestion')->name('ask_question');
    Route::post('discussion/reply/{id}', 'DiscussionController@replyPost')->name('discussion_reply_student');

    Route::post('quiz-start', 'QuizController@start')->name('start_quiz');
    Route::get('quiz/{id}', 'QuizController@quizAttempting')->name('quiz_attempt_url');
    Route::post('quiz/{id}', 'QuizController@answerSubmit');

    //Route::get('quiz/answer/submit', 'QuizController@answerSubmit')->name('quiz_answer_submit');


});

/**
 * Add and remove to Cart
 */
Route::post('add-to-cart', 'CartController@addToCart')->name('add_to_cart');
Route::post('remove-cart', 'CartController@removeCart')->name('remove_cart');

/**
 * Payment Gateway Silent Notification
 * CSRF verification skipped
 */
Route::group(['prefix' => 'gateway-ipn'], function () {
    Route::post('stripe', 'GatewayController@stripeCharge')->name('stripe_charge');
    Route::any('paypal/{transaction_id?}', 'IPNController@paypalNotify')->name('paypal_notify');
});

/**
 * Users,Instructor dashboard area
 */

Route::group(['prefix' => 'dashboard', 'middleware' => ['auth']], function () {
    Route::get('/', 'DashboardController@index')->name('dashboard');

    /**
     * Only instructor has access in this group
     */
    Route::group(['middleware' => ['instructor']], function () {

        Route::post('update-section/{id}', 'CourseController@updateSection')->name('update_section');
        Route::post('delete-section', 'CourseController@deleteSection')->name('delete_section');

        Route::group(['prefix' => 'courses'], function () {
            Route::get('new', 'CourseController@create')->name('create_course');
            Route::post('new', 'CourseController@store');

            Route::get('{course_id}/information', 'CourseController@information')->name('edit_course_information');
            Route::post('{course_id}/information', 'CourseController@informationPost');

            Route::group(['prefix' => '{course_id}/curriculum'], function () {
                Route::get('', 'CourseController@curriculum')->name('edit_course_curriculum');
                Route::get('new-section', 'CourseController@newSection')->name('new_section');
                Route::post('new-section', 'CourseController@newSectionPost');

                Route::post('new-lecture', 'CourseController@newLecture')->name('new_lecture');
                Route::post('update-lecture/{id}', 'CourseController@updateLecture')->name('update_lecture');

                Route::post('new-assignment', 'CurriculumController@newAssignment')->name('new_assignment');
                Route::post('update-assignment/{id}', 'CurriculumController@updateAssignment')->name('update_assignment');

                Route::group(['prefix' => 'quiz'], function () {
                    Route::post('create', 'QuizController@newQuiz')->name('new_quiz');
                    Route::post('update/{id}', 'QuizController@updateQuiz')->name('update_quiz');

                    Route::post('{quiz_id}/create-question', 'QuizController@createQuestion')->name('create_question');
                });
            });

            Route::post('quiz/edit-question', 'QuizController@editQuestion')->name('edit_question_form');
            Route::post('quiz/update-question', 'QuizController@updateQuestion')->name('edit_question');
            Route::post('load-quiz-questions', 'QuizController@loadQuestions')->name('load_questions');
            Route::post('sort-questions', 'QuizController@sortQuestions')->name('sort_questions');
            Route::post('delete-question', 'QuizController@deleteQuestion')->name('delete_question');
            Route::post('delete-option', 'QuizController@deleteOption')->name('option_delete');

            Route::post('edit-item', 'CourseController@editItem')->name('edit_item_form');
            Route::post('delete-item', 'CourseController@deleteItem')->name('delete_item');
            Route::post('curriculum_sort', 'CurriculumController@sort')->name('curriculum_sort');

            Route::post('delete-attachment', 'CurriculumController@deleteAttachment')->name('delete_attachment_item');

            Route::post('load-section-items', 'CourseController@loadContents')->name('load_contents');

            Route::get('{id}/pricing', 'CourseController@pricing')->name('edit_course_pricing');
            Route::post('{id}/pricing', 'CourseController@pricingSet');
            Route::get('{id}/drip', 'CourseController@drip')->name('edit_course_drip');
            Route::post('{id}/drip', 'CourseController@dripPost');
            Route::get('{id}/publish', 'CourseController@publish')->name('publish_course');
            Route::post('{id}/publish', 'CourseController@publishPost');
        });

        Route::get('my-courses', 'CourseController@myCourses')->name('my_courses');
        Route::get('my-courses-reviews', 'CourseController@myCoursesReviews')->name('my_courses_reviews');

        Route::group(['prefix' => 'courses-has-quiz'], function () {
            Route::get('/', 'QuizController@quizCourses')->name('courses_has_quiz');
            Route::get('quizzes/{id}', 'QuizController@quizzes')->name('courses_quizzes');
            Route::get('attempts/{quiz_id}', 'QuizController@attempts')->name('quiz_attempts');
            Route::get('attempt/{attempt_id}', 'QuizController@attemptDetail')->name('attempt_detail');
            Route::post('attempt/{attempt_id}', 'QuizController@attemptReview');
        });

        Route::group(['prefix' => 'assignments'], function () {
            Route::get('/', 'AssignmentController@index')->name('courses_has_assignments');
            Route::get('course/{course_id}', 'AssignmentController@assignmentsByCourse')->name('courses_assignments');
            Route::get('submissions/{assignment_id}', 'AssignmentController@submissions')->name('assignment_submissions');
            Route::get('submission/{submission_id}', 'AssignmentController@submission')->name('assignment_submission');
            Route::post('submission/{submission_id}', 'AssignmentController@evaluation');
        });

        Route::group(['prefix' => 'earning'], function () {
            Route::get('/', 'EarningController@earning')->name('earning');
            Route::get('report', 'EarningController@earningReport')->name('earning_report');
        });
        Route::group(['prefix' => 'withdraw'], function () {
            Route::get('/', 'EarningController@withdraw')->name('withdraw');
            Route::post('/', 'EarningController@withdrawPost');

            Route::get('preference', 'EarningController@withdrawPreference')->name('withdraw_preference');
            Route::post('preference', 'EarningController@withdrawPreferencePost');
        });

        Route::group(['prefix' => 'discussions'], function () {
            Route::get('/', 'DiscussionController@index')->name('instructor_discussions');
            Route::get('reply/{id}', 'DiscussionController@reply')->name('discussion_reply');
            Route::post('reply/{id}', 'DiscussionController@replyPost');
        });
    });

    Route::group(['prefix' => 'media'], function () {
        Route::post('upload', 'MediaController@store')->name('post_media_upload');
        Route::get('load_filemanager', 'MediaController@loadFileManager')->name('load_filemanager');
        Route::post('delete', 'MediaController@delete')->name('delete_media');
        Route::post('upload/editor', 'MediaController@storeEditor')->name('post_media_upload_editor');
    });

    Route::group(['prefix' => 'settings'], function () {
        Route::get('/', 'DashboardController@profileSettings')->name('profile_settings');
        Route::post('/', 'DashboardController@profileSettingsPost');

        Route::get('reset-password', 'DashboardController@resetPassword')->name('profile_reset_password');
        Route::post('reset-password', 'DashboardController@resetPasswordPost');
    });

    Route::get('enrolled-courses', 'DashboardController@enrolledCourses')->name('enrolled_courses');
    Route::get('reviews-i-wrote', 'DashboardController@myReviews')->name('reviews_i_wrote');
    Route::get('wishlist', 'DashboardController@wishlist')->name('wishlist');

    Route::get('my-quiz-attempts', 'QuizController@myQuizAttempts')->name('my_quiz_attempts');

    Route::post('survey-answer', 'DashboardController@surveyAnswer')->name('survey_answer');

    Route::group(['prefix' => 'purchases'], function () {
        Route::get('/', 'DashboardController@purchaseHistory')->name('purchase_history');
        Route::get('view/{id}', 'DashboardController@purchaseView')->name('purchase_view');
    });
});


/**
 * Admin Area
 */


Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'admin']], function () {
    Route::get('/', 'AdminController@index')->name('admin');

    Route::group(['prefix' => 'cms'], function () {
        Route::get('/', 'PostController@posts')->name('posts');
        Route::get('post/create', 'PostController@createPost')->name('create_post');
        Route::post('post/create', 'PostController@storePost');
        Route::get('post/edit/{id}', 'PostController@editPost')->name('edit_post');
        Route::post('post/edit/{id}', 'PostController@updatePost');
        Route::get('{slug}', 'PostController@getArtikel')->name('get_artikel');

        Route::get('page', 'PostController@index')->name('pages');
        Route::get('page/create', 'PostController@create')->name('create_page');
        Route::post('page/create', 'PostController@store');
        Route::get('page/edit/{id}', 'PostController@edit')->name('edit_page');
        Route::post('page/edit/{id}', 'PostController@updatePage');

        Route::get('ebook', 'EbookController@index')->name('ebooks');
        Route::get('ebook/create', 'EbookController@create')->name('create_ebook');
        Route::post('ebook/create', 'EbookController@store');
        Route::get('ebook/edit/{id}', 'EbookController@edit')->name('edit_ebook');
        Route::post('ebook/edit/{id}', 'EbookController@update');
        Route::get('ebook/delete/{id}', 'EbookController@delete')->name('delete_ebook');
        Route::post('ebook/payment/{id}', 'EbookController@payment')->name('save_payment_ebook');
        Route::get('/ebook/list-payment', 'EbookController@bukuList')->name('admin_buku_list');
        Route::post('/ebook/list-payment/{id}', 'EbookController@bukuUpdateStatus')->name('admin_buku_status');
    });

    Route::group(['prefix' => 'media_manager'], function () {
        Route::get('/', 'MediaController@mediaManager')->name('media_manager');
        Route::post('media-update', 'MediaController@mediaManagerUpdate')->name('media_update');
    });

    Route::group(['prefix' => 'categories'], function () {
        Route::get('/', 'CategoriesController@index')->name('category_index');
        Route::get('create', 'CategoriesController@create')->name('category_create');
        Route::post('create', 'CategoriesController@store');
        Route::get('edit/{id}', 'CategoriesController@edit')->name('category_edit');
        Route::post('edit/{id}', 'CategoriesController@update');
        Route::post('delete', 'CategoriesController@destroy')->name('delete_category');
        Route::post('to-home', 'CategoriesController@toHome')->name('category_tohome');
    });

    Route::group(['prefix' => 'courses'], function () {
        Route::get('/', 'AdminController@adminCourses')->name('admin_courses');
        Route::get('popular', 'AdminController@popularCourses')->name('admin_popular_courses');
        Route::get('featured', 'AdminController@featureCourses')->name('admin_featured_courses');
    });

    Route::group(['prefix' => 'plugins'], function () {
        Route::get('/', 'ExtendController@plugins')->name('plugins');
        Route::get('find', 'ExtendController@findPlugins')->name('find_plugins');
        Route::get('action', 'ExtendController@pluginAction')->name('plugin_action');
    });
    Route::group(['prefix' => 'themes'], function () {
        Route::get('/', 'ExtendController@themes')->name('themes');
        Route::post('activate', 'ExtendController@activateTheme')->name('activate_theme');
        Route::get('find', 'ExtendController@findThemes')->name('find_themes');
    });

    Route::group(['prefix' => 'settings'], function () {
        Route::get('theme-settings', 'SettingsController@ThemeSettings')->name('theme_settings');
        Route::get('invoice-settings', 'SettingsController@invoiceSettings')->name('invoice_settings');
        Route::get('general', 'SettingsController@GeneralSettings')->name('general_settings');
        Route::get('lms-settings', 'SettingsController@LMSSettings')->name('lms_settings');

        Route::get('social', 'SettingsController@SocialSettings')->name('social_settings');
        //Save settings / options
        Route::post('save-settings', 'SettingsController@update')->name('save_settings');
        Route::get('payment', 'PaymentController@PaymentSettings')->name('payment_settings');
        Route::get('payment', 'PaymentadsController@PaymentSettings')->name('payment_settings');
        Route::get('storage', 'SettingsController@StorageSettings')->name('storage_settings');
        Route::get('survey', 'SettingsController@SurveySettings')->name('survey_settings');
        Route::get('survey-create', 'SettingsController@SurveyCreate')->name('survey_create');
        Route::post('survey-create', 'SettingsController@SurveyStore')->name('survey_store');
        Route::get('survey-edit/{id}', 'SettingsController@SurveyEdit')->name('survey_edit');
        Route::post('survey-edit/{id}', 'SettingsController@SurveyUpdate')->name('survey_update');
        Route::get('survey-delete/{id}', 'SettingsController@SurveyDelete')->name('survey_delete');
        Route::post('survey-publish', 'SettingsController@SurveyPublish')->name('survey_publish');

        // Komisi setting
        Route::get('komisi', 'SettingsController@KomisiSettings')->name('komisi_settings');
        Route::post('komisi-store', 'SettingsController@KomisiUpdate')->name('komisi_store');

        Route::get('package', 'PackageController@index')->name('packages');
        Route::get('package/create', 'PackageController@create')->name('create_package');
        Route::post('package/create', 'PackageController@store');
        Route::get('package/edit/{id}', 'PackageController@edit')->name('edit_package');
        Route::post('package/edit/{id}', 'PackageController@updatePackage');
        Route::get('package/delete/{id}', 'PackageController@delete')->name('delete_package');

        //link wa setting & blasting setting
        Route::get('link-wa', 'SettingsController@LinkSettings')->name('link_wa');
        Route::get('blasting-setting', 'SettingsController@blastingSettings')->name('blasting_settings');
        Route::get('text-setting', 'SettingsController@textSettings')->name('text_settings');
        Route::post('edit/{id}', 'SettingsController@editLink')->name('edit-link');
        Route::get('create-nomor', 'SettingsController@AddNomorBlasting')->name('create_nomor');
        Route::post('create-nomor', 'SettingsController@NomorBlastingStore')->name('nomor_store');
        Route::get('create-text', 'SettingsController@AddTextBlasting')->name('create_text');
        Route::post('create-text', 'SettingsController@TextBlastingStore')->name('text_store');
        Route::post('blasting-edit/{id}', 'SettingsController@editBlasting')->name('edit-blasting');
        Route::post('text-edit/{id}', 'SettingsController@editText')->name('edit-text');
    });

    Route::get('gateways', 'PaymentController@PaymentGateways')->name('payment_gateways');
    Route::get('withdraw', 'SettingsController@withdraw')->name('withdraw_settings');

    Route::group(['prefix' => 'payments'], function () {
        Route::get('/deleted', 'PaymentController@indexDeleted')->name('deleted_payments');
        Route::get('/', 'PaymentController@index')->name('payments');
        Route::get('view/{id}', 'PaymentController@view')->name('payment_view');
        Route::get('delete/{id}', 'PaymentController@delete')->name('payment_delete');
        Route::get('deletes/{id}', 'PaymentController@deletes')->name('payment_deletes');
        Route::post('edit/{id}', 'PaymentController@editPayment')->name('edit-payment');
        Route::post('update-status/{id}', 'PaymentController@updateStatuss')->name('update_statuss');
        Route::post('follow-up/{id}', 'PaymentController@followUp')->name('follow_up');
        Route::post('follow-up-update', 'PaymentController@followUpText')->name('follow_up_text');
    });
    Route::group(['prefix' => 'paymentsads'], function () {
        Route::get('/', 'PaymentadsController@index')->name('paymentsads');
        Route::get('view/{id}', 'PaymentadsController@view')->name('paymentads_view');
        Route::get('delete/{id}', 'PaymentadsController@delete')->name('paymentads_delete');
        Route::post('edit/{id}', 'PaymentadsController@editPayment')->name('edit-paymentads');
        Route::post('update-status/{id}', 'PaymentadsController@updateStatus')->name('update_status');
        Route::post('follow-up/{id}', 'PaymentadsController@followUp')->name('follow_up');
        Route::post('follow-up-update', 'PaymentadsController@followUpText')->name('follow_up_text');
    });

    Route::group(['prefix' => 'blasting'], function () {
        Route::get('/', 'BlastingController@index')->name('admin_blasting');
        Route::get('/active', 'BlastingController@indexActive')->name('admin_blasting_ac');
        Route::get('delete_auto/{id}', 'BlastingController@deleteAutoBlasing')->name('admin_auto_blasting_delete');
        Route::post('send', 'BlastingController@send')->name('admin_blasting_send');
        Route::post('edit_text', 'BlastingController@editText')->name('admin_blasting_text');
    });

    Route::group(['prefix' => 'afiliasi'], function () {
        Route::get('/', 'AdminAfiliasiController@index')->name('admin_afiliasi');
        Route::get('view/{id}', 'AdminAfiliasiController@view')->name('admin_afiliasi_view');
        Route::get('delete/{id}', 'AdminAfiliasiController@delete')->name('admin_afiliasi_delete');
        Route::post('update-option', 'AdminAfiliasiController@updateOptions')->name('admin_afiliasi_option');
        Route::post('update-status/{id}', 'AdminAfiliasiController@updateStatus')->name('admin_afiliasi_update_status');

        Route::post('add/{id}', 'AdminAfiliasiController@addExpiredAfiliasi')->name('admin_afiliasi_add_expired');

        Route::get('/payment', 'AdminAfiliasiController@indexPayment')->name('admin_afiliasi_payment');
        Route::post('/payment', 'AdminAfiliasiController@indexPaymentPost');

        Route::get('/buku/list', 'AdminAfiliasiController@bukuList')->name('admin_afiliasi_buku_list');
        Route::post('/buku/list/{id}', 'AdminAfiliasiController@bukuUpdateStatus')->name('admin_afiliasi_buku_status');
        Route::get('/buku', 'AdminAfiliasiController@indexBuku')->name('admin_afiliasi_buku');
        Route::get('buku/create', 'AdminAfiliasiController@createBuku')->name('admin_afiliasi_create_buku');
        Route::post('buku/create', 'AdminAfiliasiController@storeBuku');
        Route::get('buku/edit/{id}', 'AdminAfiliasiController@editBuku')->name('admin_afiliasi_edit_buku');
        Route::post('buku/edit/{id}', 'AdminAfiliasiController@updateBuku');
        Route::get('buku/delete/{id}', 'AdminAfiliasiController@deleteBuku')->name('admin_afiliasi_delete_buku');

        Route::post('blasting', 'AdminAfiliasiController@send')->name('admin_afiliasi_blasting');
    });

    Route::group(['prefix' => 'staff'], function () { 
        Route::get('/', 'AdminStaffController@index')->name('admin_staff');
        Route::post('store', 'AdminStaffController@store')->name('admin_staff_add');
        Route::get('view/{id}', 'AdminStaffController@view')->name('admin_staff_view');
        Route::get('delete/{id}', 'AdminStaffController@delete')->name('admin_staff_delete');

        Route::post('update-status/{id}', 'AdminStaffController@updateStatus')->name('admin_staff_update_status');
    }); 

    Route::group(['prefix' => 'reports'], function () {
        Route::get('/', 'DashboardController@reportStudent')->name('reports');
        Route::get('/student', 'DashboardController@reportNewStudent')->name('new_student');
        Route::get('/no_payment', 'DashboardController@reportNoPayment')->name('no_payment');
        Route::get('/payment_only', 'DashboardController@reportPaymentOnly')->name('payment_only');
        Route::get('/report_ads', 'DashboardController@reportAdsOnly')->name('report_ads');
        Route::get('/report_user_ads', 'DashboardController@reportLEAOnly')->name('report_lea');
        Route::get('/report_user', 'DashboardController@reportStudentAja')->name('report_users');
        Route::get('/export/payment-only', 'DashboardController@exportPaymentOnly')->name('export_payment_only');
        Route::get('/export/no-payment', 'DashboardController@exportNoLeads')->name('export_no_leads');
        Route::get('/export/new_expired', 'DashboardController@exportNewExpiredStudent')->name('export_new_expired');
        Route::get('/students/{id_students}', 'DashboardController@reportStudentDetail')->name('reports_students');
        Route::get('/classes', 'DashboardController@reportClass')->name('report_classes');
        Route::get('/article', 'DashboardController@reportArticle')->name('report_article');
        Route::get('/classes/{id_class}', 'DashboardController@reportClassDetail')->name('reports_detail_classes');
        Route::get('/purchases', 'DashboardController@reportPurchases')->name('report_purchases');
        Route::get('/export/students/{id_students}', 'DashboardController@exportStudentDetail')->name('export_students_detail');
        Route::get('/export/classes', 'DashboardController@exportClass')->name('export_classes');
        Route::get('/export/article', 'DashboardController@exportArticle')->name('export_article');
        Route::get('/export/program', 'DashboardController@exportProgram')->name('export_program');
        Route::get('/export/classes/{id_class}', 'DashboardController@exportClassDetail')->name('export_classes_detail');
        Route::get('/export/purchases', 'DashboardController@exportPurchases')->name('export_purchases');
    });

    Route::group(['prefix' => 'datereport'], function () {
        Route::get('/', 'ReportdateController@index')->name('date_report');
        // Route::get('/student', 'DashboardController@reportNewStudent')->name('new_student');
        // Route::get('/no_payment', 'DashboardController@reportNoPayment')->name('no_payment');
        Route::get('/payment_only', 'ReportdateController@reportPaymentOnly')->name('payment_only_date');
        // Route::get('/export/payment-only', 'DashboardController@exportPaymentOnly')->name('export_payment_only');
        // Route::get('/export/no-payment', 'DashboardController@exportNoLeads')->name('export_no_leads');
        // Route::get('/export/new_expired', 'DashboardController@exportNewExpiredStudent')->name('export_new_expired');
        // Route::get('/students/{id_students}', 'DashboardController@reportStudentDetail')->name('reports_students');
        // Route::get('/classes', 'DashboardController@reportClass')->name('report_classes');
        // Route::get('/article', 'DashboardController@reportArticle')->name('report_article');
        // Route::get('/classes/{id_class}', 'DashboardController@reportClassDetail')->name('reports_detail_classes');
        // Route::get('/purchases', 'DashboardController@reportPurchases')->name('report_purchases');
        // Route::get('/export/students/{id_students}', 'DashboardController@exportStudentDetail')->name('export_students_detail');
        // Route::get('/export/classes', 'DashboardController@exportClass')->name('export_classes');
        // Route::get('/export/article', 'DashboardController@exportArticle')->name('export_article');
        // Route::get('/export/program', 'DashboardController@exportProgram')->name('export_program');
        // Route::get('/export/classes/{id_class}', 'DashboardController@exportClassDetail')->name('export_classes_detail');
        // Route::get('/export/purchases', 'DashboardController@exportPurchases')->name('export_purchases');
    });

    Route::group(['prefix' => 'withdraws'], function () {
        Route::get('/', 'AdminController@withdrawsRequests')->name('withdraws');
    });

    Route::group(['prefix' => 'users'], function () {
        Route::get('/', ['as' => 'users', 'uses' => 'UserController@users']);
        Route::get('/progress', 'UserController@usersProgress')->name('progress_users');
        Route::get('/deleted-users', 'UserController@deletedUsers')->name('deleted_users');
        Route::get('create', ['as' => 'add_administrator', 'uses' => 'UserController@addAdministrator']);
        Route::post('create', ['uses' => 'UserController@storeAdministrator']);
        Route::post('add/{id}', 'UserController@addExpiredUser')->name('add-exp-user');
        Route::post('adds/{id}', 'UserController@addAdsUser')->name('add-ads-user');
        Route::post('edit/{id}', 'UserController@editUser')->name('edit-user');
        Route::post('blasting', 'UserController@send')->name('blasting');
        Route::post('store', 'UserController@store')->name('admin_user_add');
        Route::post('storeads', 'UserController@storeads')->name('admin_user_add_ads');
        Route::post('save-edit-text', 'UserController@textBlasting')->name('save_edit_text');
        Route::get('delete/{id}', 'UserController@delete')->name('user_delete');


        Route::get('category-dropdown/{id}','UserController@dropdown')->name('category_dropdown');
        Route::get('category-dropdown','UserController@dropdown')->name('category_dropdown_nl');

        Route::post('block-unblock', ['as' => 'administratorBlockUnblock', 'uses' => 'UserController@administratorBlockUnblock']);
    });

    /**
     * Change Password route
     */
    Route::group(['prefix' => 'account'], function () {
        Route::get('change-password', 'UserController@changePassword')->name('change_password');
        Route::post('change-password', 'UserController@changePasswordPost');
    });
});

/**
 * Afiliasi Area
 */
Route::group(['prefix' => 'afiliasi', 'middleware' => ['auth', 'afiliasi']], function () {
    Route::get('/', 'AfiliasiController@index')->name('afiliasi');
    Route::get('/payment', 'AfiliasiController@payment')->name('payment-afiliasi');
    Route::post('/payment', 'AfiliasiController@paymentPost');
    Route::get('/user', 'UserController@users')->name('user-afiliasi');
    Route::post('/send', 'AfiliasiController@blasting')->name('blasting-afiliasi');
    Route::get('/book/list', 'AfiliasiController@bookList')->name('book-list-afiliasi');
    Route::get('/book', 'AfiliasiController@books')->name('book-afiliasi');
    Route::post('/book', 'AfiliasiController@bookPost');

    Route::group(['prefix' => 'settings'], function () {
        Route::get('/', 'DashboardController@profileSettings')->name('afiliasi-profile-settings');
        Route::post('/', 'DashboardController@profileSettingsPost');

        Route::get('reset-password', 'DashboardController@resetPassword')->name('afiliasi-profile-reset-password');
        Route::post('reset-password', 'DashboardController@resetPasswordPost');
    });

    Route::group(['prefix' => 'account'], function () {
        Route::get('change-password', 'UserController@changePassword')->name('afiliasi_change_password');
        Route::post('change-password', 'UserController@changePasswordPost');
    });
});
/**
 * Single Page
 */
//Route::get('{slug}', 'PostController@singlePage')->name('page');

// Route::get('OrderOnline/{slug}/thanks', 'HomeController@terima_kasih')->name('terima_kasih');
Route::post('getFollowUp', 'PaymentController@followUpFormat')->name('followUpFormat');
Route::get('testFollowUp', 'PaymentController@testFollowUp')->name('testFollowUp');
Route::get('blog', 'PostController@blog')->name('blog');
Route::get('snk', 'PostController@snk')->name('snk');
Route::get('kebijakan-privasi', 'PostController@kbp')->name('kbp');
Route::get('search/{type}', 'HomeController@search')->name('search_type');
Route::get('list-kategori', 'HomeController@listKategori')->name('list_kategori');
Route::get('about-us', 'HomeController@aboutUs')->name('about_us');
 Route::get('buku', 'HomeController@freeEbook')->name('free_ebook');
 Route::get('market', 'HomeController@pageMarket')->name('market');
// Route::get('paid-ebook', 'HomeController@paidEbook')->name('paid_ebook');
Route::get('faq', 'HomeController@faq')->name('faq');
Route::get('testimoni', 'HomeController@testimoni')->name('testimoni');
Route::get('investor', 'HomeController@investor')->name('investor');
// Route::get('page-afiliasi', 'HomeController@afiliasi')->name('afiliasi');
Route::get('konsultasi-bisnis', 'HomeController@konsultasi_bisnis')->name('konsultasi-bisnis');
Route::get('konsultasi-properti', 'HomeController@konsultasi_properti')->name('konsultasi-properti');
Route::get('sertifikat', 'HomeController@sampleCertificate')->name('post');
Route::get('{slug}', 'PostController@postSingle')->name('post');
Route::get('ebook/{slug}', 'EbookController@showPage')->name('ebook');
Route::post('download-ebook/{slug}', 'EbookController@downloadEbook')->name('download_ebook');
Route::get('post/{id?}', 'PostController@postProxy')->name('post_proxy');
Route::get('createPwd/{password?}', 'UserController@createPwd');
Route::get('regenerateJatuhTempo/{password?}', 'UserController@regenerateJatuhTempo');


Route::get('log-activities/export', 'LogActivityController@export');

