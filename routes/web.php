<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\laravel_example\UserManagement;
use App\Http\Controllers\dashboard\Analytics;
use App\Http\Controllers\dashboard\Crm;
use App\Http\Controllers\language\LanguageController;
use App\Http\Controllers\layouts\CollapsedMenu;
use App\Http\Controllers\layouts\ContentNavbar;
use App\Http\Controllers\layouts\ContentNavSidebar;
use App\Http\Controllers\layouts\NavbarFull;
use App\Http\Controllers\layouts\NavbarFullSidebar;
use App\Http\Controllers\layouts\Horizontal;
use App\Http\Controllers\layouts\Vertical;
use App\Http\Controllers\layouts\WithoutMenu;
use App\Http\Controllers\layouts\WithoutNavbar;
use App\Http\Controllers\layouts\Fluid;
use App\Http\Controllers\layouts\Container;
use App\Http\Controllers\layouts\Blank;
use App\Http\Controllers\front_pages\Landing;
use App\Http\Controllers\front_pages\Pricing;
use App\Http\Controllers\front_pages\Payment;
use App\Http\Controllers\front_pages\Checkout;
use App\Http\Controllers\front_pages\HelpCenter;
use App\Http\Controllers\front_pages\HelpCenterArticle;
use App\Http\Controllers\apps\Email;
use App\Http\Controllers\apps\Chat;
use App\Http\Controllers\apps\Calendar;
use App\Http\Controllers\apps\Kanban;
use App\Http\Controllers\apps\EcommerceDashboard;
use App\Http\Controllers\apps\EcommerceProductList;
use App\Http\Controllers\apps\EcommerceProductAdd;
use App\Http\Controllers\apps\EcommerceProductCategory;
use App\Http\Controllers\apps\EcommerceOrderList;
use App\Http\Controllers\apps\EcommerceOrderDetails;
use App\Http\Controllers\apps\EcommerceCustomerAll;
use App\Http\Controllers\apps\EcommerceCustomerDetailsOverview;
use App\Http\Controllers\apps\EcommerceCustomerDetailsSecurity;
use App\Http\Controllers\apps\EcommerceCustomerDetailsBilling;
use App\Http\Controllers\apps\EcommerceCustomerDetailsNotifications;
use App\Http\Controllers\apps\EcommerceManageReviews;
use App\Http\Controllers\apps\EcommerceReferrals;
use App\Http\Controllers\apps\EcommerceSettingsDetails;
use App\Http\Controllers\apps\EcommerceSettingsPayments;
use App\Http\Controllers\apps\EcommerceSettingsCheckout;
use App\Http\Controllers\apps\EcommerceSettingsShipping;
use App\Http\Controllers\apps\EcommerceSettingsLocations;
use App\Http\Controllers\apps\EcommerceSettingsNotifications;
use App\Http\Controllers\apps\AcademyDashboard;
use App\Http\Controllers\apps\AcademyCourse;
use App\Http\Controllers\apps\AcademyCourseDetails;
use App\Http\Controllers\apps\LogisticsDashboard;
use App\Http\Controllers\apps\LogisticsFleet;
use App\Http\Controllers\apps\InvoiceList;
use App\Http\Controllers\apps\InvoicePreview;
use App\Http\Controllers\apps\InvoicePrint;
use App\Http\Controllers\apps\InvoiceEdit;
use App\Http\Controllers\apps\InvoiceAdd;
use App\Http\Controllers\apps\UserList;
use App\Http\Controllers\apps\UserViewAccount;
use App\Http\Controllers\apps\UserViewSecurity;
use App\Http\Controllers\apps\UserViewBilling;
use App\Http\Controllers\apps\UserViewNotifications;
use App\Http\Controllers\apps\UserViewConnections;
use App\Http\Controllers\apps\AccessRoles;
use App\Http\Controllers\apps\AccessPermission;
use App\Http\Controllers\pages\UserProfile;
use App\Http\Controllers\pages\UserTeams;
use App\Http\Controllers\pages\UserProjects;
use App\Http\Controllers\pages\UserConnections;
use App\Http\Controllers\pages\AccountSettingsAccount;
use App\Http\Controllers\pages\AccountSettingsSecurity;
use App\Http\Controllers\pages\AccountSettingsBilling;
use App\Http\Controllers\pages\AccountSettingsNotifications;
use App\Http\Controllers\pages\AccountSettingsConnections;
use App\Http\Controllers\pages\Faq;
use App\Http\Controllers\pages\Pricing as PagesPricing;
use App\Http\Controllers\pages\MiscError;
use App\Http\Controllers\pages\MiscUnderMaintenance;
use App\Http\Controllers\pages\MiscComingSoon;
use App\Http\Controllers\pages\MiscNotAuthorized;
use App\Http\Controllers\authentications\LoginBasic;
use App\Http\Controllers\authentications\LoginCover;
use App\Http\Controllers\authentications\RegisterBasic;
use App\Http\Controllers\authentications\RegisterCover;
use App\Http\Controllers\authentications\RegisterMultiSteps;
use App\Http\Controllers\authentications\VerifyEmailBasic;
use App\Http\Controllers\authentications\VerifyEmailCover;
use App\Http\Controllers\authentications\ResetPasswordBasic;
use App\Http\Controllers\authentications\ResetPasswordCover;
use App\Http\Controllers\authentications\ForgotPasswordBasic;
use App\Http\Controllers\authentications\ForgotPasswordCover;
use App\Http\Controllers\authentications\TwoStepsBasic;
use App\Http\Controllers\authentications\TwoStepsCover;
use App\Http\Controllers\wizard_example\Checkout as WizardCheckout;
use App\Http\Controllers\wizard_example\PropertyListing;
use App\Http\Controllers\wizard_example\CreateDeal;
use App\Http\Controllers\modal\ModalExample;
use App\Http\Controllers\cards\CardBasic;
use App\Http\Controllers\cards\CardAdvance;
use App\Http\Controllers\cards\CardStatistics;
use App\Http\Controllers\cards\CardAnalytics;
use App\Http\Controllers\cards\CardGamifications;
use App\Http\Controllers\cards\CardActions;
use App\Http\Controllers\user_interface\Accordion;
use App\Http\Controllers\user_interface\Alerts;
use App\Http\Controllers\user_interface\Badges;
use App\Http\Controllers\user_interface\Buttons;
use App\Http\Controllers\user_interface\Carousel;
use App\Http\Controllers\user_interface\Collapse;
use App\Http\Controllers\user_interface\Dropdowns;
use App\Http\Controllers\user_interface\Footer;
use App\Http\Controllers\user_interface\ListGroups;
use App\Http\Controllers\user_interface\Modals;
use App\Http\Controllers\user_interface\Navbar;
use App\Http\Controllers\user_interface\Offcanvas;
use App\Http\Controllers\user_interface\PaginationBreadcrumbs;
use App\Http\Controllers\user_interface\Progress;
use App\Http\Controllers\user_interface\Spinners;
use App\Http\Controllers\user_interface\TabsPills;
use App\Http\Controllers\user_interface\Toasts;
use App\Http\Controllers\user_interface\TooltipsPopovers;
use App\Http\Controllers\user_interface\Typography;
use App\Http\Controllers\extended_ui\Avatar;
use App\Http\Controllers\extended_ui\BlockUI;
use App\Http\Controllers\extended_ui\DragAndDrop;
use App\Http\Controllers\extended_ui\MediaPlayer;
use App\Http\Controllers\extended_ui\PerfectScrollbar;
use App\Http\Controllers\extended_ui\StarRatings;
use App\Http\Controllers\extended_ui\SweetAlert;
use App\Http\Controllers\extended_ui\TextDivider;
use App\Http\Controllers\extended_ui\TimelineBasic;
use App\Http\Controllers\extended_ui\TimelineFullscreen;
use App\Http\Controllers\extended_ui\Tour;
use App\Http\Controllers\extended_ui\Treeview;
use App\Http\Controllers\extended_ui\Misc;
use App\Http\Controllers\icons\Tabler;
use App\Http\Controllers\icons\FontAwesome;
use App\Http\Controllers\form_elements\BasicInput;
use App\Http\Controllers\form_elements\InputGroups;
use App\Http\Controllers\form_elements\CustomOptions;
use App\Http\Controllers\form_elements\Editors;
use App\Http\Controllers\form_elements\FileUpload;
use App\Http\Controllers\form_elements\Picker;
use App\Http\Controllers\form_elements\Selects;
use App\Http\Controllers\form_elements\Sliders;
use App\Http\Controllers\form_elements\Switches;
use App\Http\Controllers\form_elements\Extras;
use App\Http\Controllers\form_layouts\VerticalForm;
use App\Http\Controllers\form_layouts\HorizontalForm;
use App\Http\Controllers\form_layouts\StickyActions;
use App\Http\Controllers\form_wizard\Numbered as FormWizardNumbered;
use App\Http\Controllers\form_wizard\Icons as FormWizardIcons;
use App\Http\Controllers\form_validation\Validation;
use App\Http\Controllers\tables\Basic as TablesBasic;
use App\Http\Controllers\tables\DatatableBasic;
use App\Http\Controllers\tables\DatatableAdvanced;
use App\Http\Controllers\tables\DatatableExtensions;
use App\Http\Controllers\charts\ApexCharts;
use App\Http\Controllers\charts\ChartJs;
use App\Http\Controllers\Karyawan\Formkaryawan;
use App\Http\Controllers\department\CategoryDepartment;
use App\Http\Controllers\department\CategoryJabatan;
use App\Http\Controllers\hrd\DetailKaryawan;
use App\Http\Controllers\hrd\InformasiKepegawaian;
use App\Http\Controllers\hrd\KontrakKerja;
use App\Http\Controllers\hrd\ProfileKaryawanAdd;
use App\Http\Controllers\hrd\ProfileKaryawanList;
use App\Http\Controllers\Karyawan\EditKeluargaKaryawan;
use App\Http\Controllers\Karyawan\EditPendidikanKaryawan;
use App\Http\Controllers\Karyawan\FormProfile;
use App\Http\Controllers\Karyawan\ViewKaryawan;
use App\Http\Controllers\maps\Leaflet;

// Main Page Route
Route::get('/', [LoginCover::class, 'index'])->name('auth-login-cover');
Route::get('/login', [LoginCover::class, 'index'])->name('auth-login-cover');
Route::post('/login', [LoginCover::class, 'login'])->name('login');
Route::get('/forgot-password', [ForgotPasswordCover::class, 'index'])->name('auth-forgot-password-cover');
Route::get('/verify-email', [VerifyEmailCover::class, 'index'])->name('auth-verify-email-cover');
Route::get('/reset-password-cover', [ResetPasswordCover::class, 'index'])->name('auth-reset-password-cover');
Route::get('/two-steps', [TwoStepsCover::class, 'index'])->name('auth-two-steps-cover');

//auth google
// Route untuk halaman login
Route::get('/auth/login-basic', [LoginBasic::class, 'index'])->name('auth-login-basic');

// Route untuk login menggunakan Google
Route::get('auth/google', [LoginBasic::class, 'redirect'])->name('auth.google');
Route::get('auth/google/callback', [LoginBasic::class, 'callback'])->name('auth.google.callback');

Route::middleware(['auth'])->group(function () {
  Route::get('/dashboard', [LogisticsDashboard::class, 'index'])->name('dashboard');

  Route::get('/get-kabupaten', [FormKaryawan::class, 'getKabupaten']);
  Route::get('/get-kecamatan', [FormKaryawan::class, 'getKecamatan']);
  Route::get('/get-desa', [FormKaryawan::class, 'getDesa']);

  Route::get('karyawan/{userId}/edit', [EditProfileKaryawan::class, 'edit'])->name('karyawan.edit');
  Route::put('karyawan/{userId}', [EditProfileKaryawan::class, 'update'])->name('karyawan.update');

  //karyawan
  Route::get('/view/karyawan', [ViewKaryawan::class, 'index'])->name('view-karywan');
  Route::get('/form/karyawan', [Formkaryawan::class, 'index'])->name('Form-karyawan');
  Route::get('/edit/profile/karyawan', [EditProfileKaryawan::class, 'index'])->name('edit-profile-karyawan');
  Route::get('/edit/pendidikan/karyawan', [EditPendidikanKaryawan::class, 'index'])->name('edit-pendidikan-karyawan');
  Route::get('/edit/keluarga/karyawan', [EditKeluargaKaryawan::class, 'index'])->name('edit-keluarga-karyawan');
  Route::post('/form/karyawan/storeKaryawan', [Formkaryawan::class, 'storeKaryawan'])->name('Form-karyawan-storeKaryawan');
  Route::post('/form/karyawan/storeRiwayatPendidikan', [Formkaryawan::class, 'storeRiwayatPendidikan'])->name('Form-karyawan-storeRiwayatPendidikan');
  Route::post('/form/karyawan/storeKeluarga', [Formkaryawan::class, 'storeKeluarga'])->name('Form-karyawan-storeKeluarga');

  //form karyawan
  Route::get('/form/pribadi/karyawan', [FormProfile::class, 'index'])->name('form-pribadi-karyawan');

  // User
  Route::get('/user/profile', [UserProfile::class, 'index'])->name('pages-profile-user');
  Route::get('/account-settings-account', [AccountSettingsAccount::class, 'index'])->name('pages-account-settings-account');
  Route::patch('/account/update', [AccountSettingsAccount::class, 'update'])->name('account-update');
  Route::post('/account/deactivate', [AccountSettingsAccount::class, 'deactivate'])->name('account-deactivate');

  Route::get('/account-settings-security', [AccountSettingsSecurity::class, 'index'])->name('pages-account-settings-security');
  Route::patch('/account-settings/security/password', [AccountSettingsSecurity::class, 'updatePassword'])
    ->name('security.password.update');

  // laravel example
  Route::get('/users/user-management/view', [UserManagement::class, 'UserManagement'])->name('users-user-management');
  Route::get('/users/user-management', [UserManagement::class, 'index'])->name('users.user-management.index');
  Route::resource('/user-list', UserManagement::class);

  // locale
  Route::get('/lang/{locale}', [LanguageController::class, 'swap']);

  // Logout
  Route::post('/logout', [LoginCover::class, 'logout'])->name('logout');
  Route::post('/logout/karyawan', [LoginBasic::class, 'logout'])->name('logout-basic');

  // data hrd
  Route::get('/profile/list', [ProfileKaryawanList::class, 'index'])->name('hrd-profile-karyawan-list');
  Route::get('/table/profile-karyawan', [ProfileKaryawanList::class, 'getProfileKaryawan']);
  Route::get('/profile/add', [ProfileKaryawanAdd::class, 'index'])->name('hrd-profile-karyawan-add');
  Route::post('/profile/karyawan/storeKaryawan', [ProfileKaryawanAdd::class, 'storeKaryawanHrd'])->name('Hrd-storeKaryawan');
  Route::post('/profile/karyawan/storeRiwayatPendidikan', [ProfileKaryawanAdd::class, 'storeRiwayatPendidikanHrd'])->name('Hrd-storeRiwayatPendidikan');
  Route::post('/profile/karyawan/storeKeluarga', [ProfileKaryawanAdd::class, 'storeKeluargaHrd'])->name('Hrd-storeKeluarga');
  Route::get('/profile-karyawan/{user_id}/edit', [ProfileKaryawanController::class, 'edit'])->name('profile.karyawan.edit');
  Route::get('/detail/karyawan/{id}', [DetailKaryawan::class, 'index'])->name('detail.karyawan.view');

  Route::get('/informasi/kepegawaian', [InformasiKepegawaian::class, 'index'])->name('hrd-informasi-kepegawaian');
  Route::post('/informasi/kepegawaian/store', [InformasiKepegawaian::class, 'store'])->name('informasi-kepegawaian-store');
  Route::get('/table/informasi-kepegawaian', [InformasiKepegawaian::class, 'getall']);
  Route::get('/edit/kepegawaian/{id}', [InformasiKepegawaian::class, 'edit']);
  Route::put('/update/kepegawaian/{id}', [InformasiKepegawaian::class, 'update']); // Untuk memperbarui data
  Route::delete('/delete/kepegawaian/{id}', [InformasiKepegawaian::class, 'delete']); // Untuk menghapus data

  Route::get('/kontrak/kerja', [KontrakKerja::class, 'index'])->name('hrd-kontrak-kerja');
  Route::post('/kontrak-kerja/store', [KontrakKerja::class, 'store'])->name('kontrak-kerja-store');
  Route::get('/table/kontrak-kerja', [KontrakKerja::class, 'getAll']);
  Route::get('/edit/kontrak-kerja/{id}', [KontrakKerja::class, 'edit']);
  Route::put('/update/kontrak-kerja/{id}', [KontrakKerja::class, 'update']); // Untuk memperbarui data
  Route::delete('/delete/kontrak-kerja/{id}', [KontrakKerja::class, 'delete']); // Untuk menghapus data
  //Route::post('/product/store', [EcommerceProductAdd::class, 'store'])->name('karyawan.store');
  //Route::get('/product/category', [EcommerceProductCategory::class, 'index'])->name('app-ecommerce-product-category');
  //Route::get('/products/{id}', [EcommerceProductList::class, 'show']);

  //department
  Route::get('/category/department', [CategoryDepartment::class, 'index'])->name('category-department');
  Route::get('/table/departments', [CategoryDepartment::class, 'getDepartments']);
  Route::post('/category/department/store',[CategoryDepartment::class, 'store'])->name('category-department-store');
  Route::get('/edit/department/{id}', [CategoryDepartment::class, 'edit'])->name('category.departments.edit');
  Route::put('/update/department/{id}', [CategoryDepartment::class, 'update'])->name('category.departments.update');
  Route::delete('/destroy/department/{id}', [CategoryDepartment::class, 'destroy'])->name('category.departments.destroy');

  Route::get('/category/jabatan', [CategoryJabatan::class, 'index'])->name('category-jabatan');
  Route::get('/table/jabatan', [CategoryJabatan::class, 'getJabatan']);
  Route::post('/category/jabatan/store',[CategoryJabatan::class, 'store'])->name('category-jabatan-store');
  Route::get('/edit/jabatan/{id}', [CategoryJabatan::class, 'edit'])->name('category.jabatan.edit');
  Route::put('/update/jabatan/{id}', [CategoryJabatan::class, 'update'])->name('category.jabatan.update');
  Route::delete('/destroy/jabatan/{id}', [CategoryJabatan::class, 'destroy'])->name('category.jabatan.destroy');


  // Route::get('/dashboard/analytics', [Analytics::class, 'index'])->name('dashboard-analytics');
  // Route::get('/dashboard/crm', [Crm::class, 'index'])->name('dashboard-crm');

  // Route::get('/pages/account-settings-notifications', [AccountSettingsNotifications::class, 'index'])->name('pages-account-settings-notifications');

  // layout
  // Route::get('/layouts/collapsed-menu', [CollapsedMenu::class, 'index'])->name('layouts-collapsed-menu');
  // Route::get('/layouts/content-navbar', [ContentNavbar::class, 'index'])->name('layouts-content-navbar');
  // Route::get('/layouts/content-nav-sidebar', [ContentNavSidebar::class, 'index'])->name('layouts-content-nav-sidebar');
  // Route::get('/layouts/navbar-full', [NavbarFull::class, 'index'])->name('layouts-navbar-full');
  // Route::get('/layouts/navbar-full-sidebar', [NavbarFullSidebar::class, 'index'])->name('layouts-navbar-full-sidebar');
  // Route::get('/layouts/horizontal', [Horizontal::class, 'index'])->name('dashboard-analytics');
  // Route::get('/layouts/vertical', [Vertical::class, 'index'])->name('dashboard-analytics');
  // Route::get('/layouts/without-menu', [WithoutMenu::class, 'index'])->name('layouts-without-menu');
  // Route::get('/layouts/without-navbar', [WithoutNavbar::class, 'index'])->name('layouts-without-navbar');
  // Route::get('/layouts/fluid', [Fluid::class, 'index'])->name('layouts-fluid');
  // Route::get('/layouts/container', [Container::class, 'index'])->name('layouts-container');
  Route::get('/layouts/blank', [Blank::class, 'index'])->name('layouts-blank');

  // Front Pages
  Route::get('/front-pages/landing', [Landing::class, 'index'])->name('front-pages-landing');
  Route::get('/front-pages/pricing', [Pricing::class, 'index'])->name('front-pages-pricing');
  Route::get('/front-pages/payment', [Payment::class, 'index'])->name('front-pages-payment');
  Route::get('/front-pages/checkout', [Checkout::class, 'index'])->name('front-pages-checkout');
  Route::get('/front-pages/help-center', [HelpCenter::class, 'index'])->name('front-pages-help-center');
  Route::get('/front-pages/help-center-article', [HelpCenterArticle::class, 'index'])->name('front-pages-help-center-article');

  // apps
  // Route::get('/app/email', [Email::class, 'index'])->name('app-email');
  // Route::get('/app/chat', [Chat::class, 'index'])->name('app-chat');
  // Route::get('/app/calendar', [Calendar::class, 'index'])->name('app-calendar');
  // Route::get('/app/kanban', [Kanban::class, 'index'])->name('app-kanban');
  // Route::get('/app/ecommerce/order/list', [EcommerceOrderList::class, 'index'])->name('app-ecommerce-order-list');
  // Route::get('/app/ecommerce/order/details', [EcommerceOrderDetails::class, 'index'])->name('app-ecommerce-order-details');
  // Route::get('/app/ecommerce/customer/all', [EcommerceCustomerAll::class, 'index'])->name('app-ecommerce-customer-all');
  // Route::get('/app/ecommerce/customer/details/overview', [EcommerceCustomerDetailsOverview::class, 'index'])->name('app-ecommerce-customer-details-overview');
  // Route::get('/app/ecommerce/customer/details/security', [EcommerceCustomerDetailsSecurity::class, 'index'])->name('app-ecommerce-customer-details-security');
  // Route::get('/app/ecommerce/customer/details/billing', [EcommerceCustomerDetailsBilling::class, 'index'])->name('app-ecommerce-customer-details-billing');
  // Route::get('/app/ecommerce/customer/details/notifications', [EcommerceCustomerDetailsNotifications::class, 'index'])->name('app-ecommerce-customer-details-notifications');
  // Route::get('/app/ecommerce/manage/reviews', [EcommerceManageReviews::class, 'index'])->name('app-ecommerce-manage-reviews');
  // Route::get('/app/ecommerce/referrals', [EcommerceReferrals::class, 'index'])->name('app-ecommerce-referrals');
  // Route::get('/app/ecommerce/settings/details', [EcommerceSettingsDetails::class, 'index'])->name('app-ecommerce-settings-details');
  // Route::get('/app/ecommerce/settings/payments', [EcommerceSettingsPayments::class, 'index'])->name('app-ecommerce-settings-payments');
  // Route::get('/app/ecommerce/settings/checkout', [EcommerceSettingsCheckout::class, 'index'])->name('app-ecommerce-settings-checkout');
  // Route::get('/app/ecommerce/settings/shipping', [EcommerceSettingsShipping::class, 'index'])->name('app-ecommerce-settings-shipping');
  // Route::get('/app/ecommerce/settings/locations', [EcommerceSettingsLocations::class, 'index'])->name('app-ecommerce-settings-locations');
  // Route::get('/app/ecommerce/settings/notifications', [EcommerceSettingsNotifications::class, 'index'])->name('app-ecommerce-settings-notifications');
  // Route::get('/app/academy/dashboard', [AcademyDashboard::class, 'index'])->name('app-academy-dashboard');
  // Route::get('/app/academy/course', [AcademyCourse::class, 'index'])->name('app-academy-course');
  // Route::get('/app/academy/course-details', [AcademyCourseDetails::class, 'index'])->name('app-academy-course-details');
  // Route::get('/app/logistics/dashboard', [LogisticsDashboard::class, 'index'])->name('app-logistics-dashboard');
  // Route::get('/app/logistics/fleet', [LogisticsFleet::class, 'index'])->name('app-logistics-fleet');
  // Route::get('/app/invoice/list', [InvoiceList::class, 'index'])->name('app-invoice-list');
  Route::get('/app/invoice/preview', [InvoicePreview::class, 'index'])->name('app-invoice-preview');
  // Route::get('/app/invoice/print', [InvoicePrint::class, 'index'])->name('app-invoice-print');
  // Route::get('/app/invoice/edit', [InvoiceEdit::class, 'index'])->name('app-invoice-edit');
  // Route::get('/app/invoice/add', [InvoiceAdd::class, 'index'])->name('app-invoice-add');
  // Route::get('/app/user/list', [UserList::class, 'index'])->name('app-user-list');
  // Route::get('/app/user/view/account', [UserViewAccount::class, 'index'])->name('app-user-view-account');
  // Route::get('/app/user/view/security', [UserViewSecurity::class, 'index'])->name('app-user-view-security');
  // Route::get('/app/user/view/billing', [UserViewBilling::class, 'index'])->name('app-user-view-billing');
  // Route::get('/app/user/view/notifications', [UserViewNotifications::class, 'index'])->name('app-user-view-notifications');
  // Route::get('/app/user/view/connections', [UserViewConnections::class, 'index'])->name('app-user-view-connections');
  // Route::get('/app/access-roles', [AccessRoles::class, 'index'])->name('app-access-roles');
  // Route::get('/app/access-permission', [AccessPermission::class, 'index'])->name('app-access-permission');

  // pages
  // Route::get('/pages/profile-user', [UserProfile::class, 'index'])->name('pages-profile-user');
  // Route::get('/pages/profile-teams', [UserTeams::class, 'index'])->name('pages-profile-teams');
  // Route::get('/pages/profile-projects', [UserProjects::class, 'index'])->name('pages-profile-projects');
  // Route::get('/pages/profile-connections', [UserConnections::class, 'index'])->name('pages-profile-connections');
  // Route::get('/pages/account-settings-billing', [AccountSettingsBilling::class, 'index'])->name('pages-account-settings-billing');
  // Route::get('/pages/account-settings-connections', [AccountSettingsConnections::class, 'index'])->name('pages-account-settings-connections');

  // Route::get('/pages/faq', [Faq::class, 'index'])->name('pages-faq');
  // Route::get('/pages/pricing', [PagesPricing::class, 'index'])->name('pages-pricing');
  // Route::get('/pages/misc-error', [MiscError::class, 'index'])->name('pages-misc-error');
  // Route::get('/pages/misc-under-maintenance', [MiscUnderMaintenance::class, 'index'])->name('pages-misc-under-maintenance');
  // Route::get('/pages/misc-comingsoon', [MiscComingSoon::class, 'index'])->name('pages-misc-comingsoon');
  // Route::get('/pages/misc-not-authorized', [MiscNotAuthorized::class, 'index'])->name('pages-misc-not-authorized');

  // authentication
  // Route::get('/auth/login-cover', [LoginCover::class, 'index'])->name('auth-login-cover');
  // Route::get('/auth/register-basic', [RegisterBasic::class, 'index'])->name('auth-register-basic');
  // Route::get('/auth/register-cover', [RegisterCover::class, 'index'])->name('auth-register-cover');
  // Route::get('/auth/register-multisteps', [RegisterMultiSteps::class, 'index'])->name('auth-register-multisteps');
  // Route::get('/auth/verify-email-basic', [VerifyEmailBasic::class, 'index'])->name('auth-verify-email-basic');
  // Route::get('/auth/reset-password-basic', [ResetPasswordBasic::class, 'index'])->name('auth-reset-password-basic');
  // Route::get('/auth/forgot-password-basic', [ForgotPasswordBasic::class, 'index'])->name('auth-reset-password-basic');
  // Route::get('/auth/two-steps-basic', [TwoStepsBasic::class, 'index'])->name('auth-two-steps-basic');

  // wizard example
  // Route::get('/wizard/ex-checkout', [WizardCheckout::class, 'index'])->name('wizard-ex-checkout');
  // Route::get('/wizard/ex-property-listing', [PropertyListing::class, 'index'])->name('wizard-ex-property-listing');
  // Route::get('/wizard/ex-create-deal', [CreateDeal::class, 'index'])->name('wizard-ex-create-deal');

  // modal
  // Route::get('/modal-examples', [ModalExample::class, 'index'])->name('modal-examples');

  // cards
  // Route::get('/cards/basic', [CardBasic::class, 'index'])->name('cards-basic');
  // Route::get('/cards/advance', [CardAdvance::class, 'index'])->name('cards-advance');
  // Route::get('/cards/statistics', [CardStatistics::class, 'index'])->name('cards-statistics');
  // Route::get('/cards/analytics', [CardAnalytics::class, 'index'])->name('cards-analytics');
  // Route::get('/cards/gamifications', [CardGamifications::class, 'index'])->name('cards-gamifications');
  // Route::get('/cards/actions', [CardActions::class, 'index'])->name('cards-actions');

  // User Interface
  // Route::get('/ui/accordion', [Accordion::class, 'index'])->name('ui-accordion');
  // Route::get('/ui/alerts', [Alerts::class, 'index'])->name('ui-alerts');
  // Route::get('/ui/badges', [Badges::class, 'index'])->name('ui-badges');
  // Route::get('/ui/buttons', [Buttons::class, 'index'])->name('ui-buttons');
  // Route::get('/ui/carousel', [Carousel::class, 'index'])->name('ui-carousel');
  // Route::get('/ui/collapse', [Collapse::class, 'index'])->name('ui-collapse');
  // Route::get('/ui/dropdowns', [Dropdowns::class, 'index'])->name('ui-dropdowns');
  // Route::get('/ui/footer', [Footer::class, 'index'])->name('ui-footer');
  // Route::get('/ui/list-groups', [ListGroups::class, 'index'])->name('ui-list-groups');
  // Route::get('/ui/modals', [Modals::class, 'index'])->name('ui-modals');
  // Route::get('/ui/navbar', [Navbar::class, 'index'])->name('ui-navbar');
  // Route::get('/ui/offcanvas', [Offcanvas::class, 'index'])->name('ui-offcanvas');
  // Route::get('/ui/pagination-breadcrumbs', [PaginationBreadcrumbs::class, 'index'])->name('ui-pagination-breadcrumbs');
  // Route::get('/ui/progress', [Progress::class, 'index'])->name('ui-progress');
  // Route::get('/ui/spinners', [Spinners::class, 'index'])->name('ui-spinners');
  // Route::get('/ui/tabs-pills', [TabsPills::class, 'index'])->name('ui-tabs-pills');
  // Route::get('/ui/toasts', [Toasts::class, 'index'])->name('ui-toasts');
  // Route::get('/ui/tooltips-popovers', [TooltipsPopovers::class, 'index'])->name('ui-tooltips-popovers');
  // Route::get('/ui/typography', [Typography::class, 'index'])->name('ui-typography');

  // extended ui
  // Route::get('/extended/ui-avatar', [Avatar::class, 'index'])->name('extended-ui-avatar');
  // Route::get('/extended/ui-blockui', [BlockUI::class, 'index'])->name('extended-ui-blockui');
  // Route::get('/extended/ui-drag-and-drop', [DragAndDrop::class, 'index'])->name('extended-ui-drag-and-drop');
  // Route::get('/extended/ui-media-player', [MediaPlayer::class, 'index'])->name('extended-ui-media-player');
  // Route::get('/extended/ui-perfect-scrollbar', [PerfectScrollbar::class, 'index'])->name('extended-ui-perfect-scrollbar');
  // Route::get('/extended/ui-star-ratings', [StarRatings::class, 'index'])->name('extended-ui-star-ratings');
  // Route::get('/extended/ui-sweetalert2', [SweetAlert::class, 'index'])->name('extended-ui-sweetalert2');
  // Route::get('/extended/ui-text-divider', [TextDivider::class, 'index'])->name('extended-ui-text-divider');
  // Route::get('/extended/ui-timeline-basic', [TimelineBasic::class, 'index'])->name('extended-ui-timeline-basic');
  // Route::get('/extended/ui-timeline-fullscreen', [TimelineFullscreen::class, 'index'])->name('extended-ui-timeline-fullscreen');
  // Route::get('/extended/ui-tour', [Tour::class, 'index'])->name('extended-ui-tour');
  // Route::get('/extended/ui-treeview', [Treeview::class, 'index'])->name('extended-ui-treeview');
  // Route::get('/extended/ui-misc', [Misc::class, 'index'])->name('extended-ui-misc');

  // icons
  Route::get('/icons/tabler', [Tabler::class, 'index'])->name('icons-tabler');
  Route::get('/icons/font-awesome', [FontAwesome::class, 'index'])->name('icons-font-awesome');

  // form elements
  // Route::get('/forms/basic-inputs', [BasicInput::class, 'index'])->name('forms-basic-inputs');
  // Route::get('/forms/input-groups', [InputGroups::class, 'index'])->name('forms-input-groups');
  // Route::get('/forms/custom-options', [CustomOptions::class, 'index'])->name('forms-custom-options');
  // Route::get('/forms/editors', [Editors::class, 'index'])->name('forms-editors');
  // Route::get('/forms/file-upload', [FileUpload::class, 'index'])->name('forms-file-upload');
  // Route::get('/forms/pickers', [Picker::class, 'index'])->name('forms-pickers');
  // Route::get('/forms/selects', [Selects::class, 'index'])->name('forms-selects');
  // Route::get('/forms/sliders', [Sliders::class, 'index'])->name('forms-sliders');
  Route::get('/forms/switches', [Switches::class, 'index'])->name('forms-switches');
  Route::get('/forms/extras', [Extras::class, 'index'])->name('forms-extras');

  // form layouts
  Route::get('/form/layouts-vertical', [VerticalForm::class, 'index'])->name('form-layouts-vertical');
  Route::get('/form/layouts-horizontal', [HorizontalForm::class, 'index'])->name('form-layouts-horizontal');
  // Route::get('/form/layouts-sticky', [StickyActions::class, 'index'])->name('form-layouts-sticky');

  // form wizards
  Route::get('/form/wizard-numbered', [FormWizardNumbered::class, 'index'])->name('form-wizard-numbered');
  // Route::get('/form/wizard-icons', [FormWizardIcons::class, 'index'])->name('form-wizard-icons');
  // Route::get('/form/validation', [Validation::class, 'index'])->name('form-validation');

  // tables
  // Route::get('/tables/basic', [TablesBasic::class, 'index'])->name('tables-basic');
  // Route::get('/tables/datatables-basic', [DatatableBasic::class, 'index'])->name('tables-datatables-basic');
  Route::get('/nizar', [DatatableAdvanced::class, 'index'])->name('tables-datatables-advanced');
  Route::get('/tables/datatables-extensions', [DatatableExtensions::class, 'index'])->name('tables-datatables-extensions');

  // charts
  // Route::get('/charts/apex', [ApexCharts::class, 'index'])->name('charts-apex');
  // Route::get('/charts/chartjs', [ChartJs::class, 'index'])->name('charts-chartjs');

  // maps
  // Route::get('/maps/leaflet', [Leaflet::class, 'index'])->name('maps-leaflet');

});
