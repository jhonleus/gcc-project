<?php
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
Auth::routes(['verify' => true]);

Route::get('/clear', function() {

   Artisan::call('config:clear');
   Artisan::call('config:cache');

   return "Cleared!";

});

Route::namespace('Admin')->prefix('admin')->middleware('admin')->name('admin.')->group(function() {

	Route::get('/', 'AdminController@index');
	Route::get('/alljobs', 'PostedController@jobs');
	Route::get('/allcourses', 'PostedController@courses');
	Route::resource('/approval', 'ApprovalController');
	Route::resource('/banks', 'BankController');
	Route::resource('/civil', 'CivilController');
	Route::resource('/countries', 'CountriesController');
	Route::resource('/currencies', 'CurrencyController');
	Route::resource('/employment', 'EmploymentController');
	Route::resource('/hobbies', 'HobbiesController');
	Route::resource('/industries', 'IndustryController');
	Route::resource('/attainment', 'LevelController');
	Route::resource('/position', 'PositionController');
	Route::resource('/religion', 'ReligionController');
	Route::resource('/specialization', 'SpecializationnController');
	Route::resource('/language', 'LanguageController');
	Route::resource('/faq', 'MaintenanceFaqsController');
	Route::get('/approval/download/{file}', 'ApprovalController@download');
	Route::resource('/posts', 'AdminController');
	Route::resource('/trigger', 'AdminController');
	Route::resource('/maintenance','PagecontentController');
	Route::get('/maintenance/download/{file}', 'PagecontentController@download');
	Route::resource('/subscriptions','SubscriptionController');
	Route::resource('/blog','MaintenanceBlogController');
	Route::resource('/password','AdminSettingController');
	Route::resource('/feedback','FeedbacklistController');
	Route::resource('/systemupdate','SystemUpdateController');
	Route::get('/feedback/{id}','FeedbacklistController@destroy');
	Route::get('/destroy/{id}','FeedbacklistController@destroy');
	Route::resource('/sales','SalesController');
	Route::get('/reports/applicantlist/download/{file}', 'ApplicantlistController@download');
	Route::resource('reports/applicantlist','ApplicantlistController');
	Route::resource('reports/companylist','EmployerlistController');
	Route::resource('reports/daterange', 'DateRangeController');
	Route::resource('reports/toprating', 'TopRatingController');
	Route::resource('reports/documents', 'DocumentController');
	Route::resource('reports/topsubscriber', 'TopSubscriberController');
	Route::resource('reports/organizationlist', 'OrganizationlistController');
	Route::resource('reports/schoolslist', 'SchoollistController');

	Route::resource('over-the-counter', 'OtcController');
	Route::resource('jobs', 'JobController');
	Route::resource('reviews', 'ReviewController');
	Route::resource('types', 'TypeController');
	Route::resource('results', 'ResultController');
	Route::resource('featured', 'FeaturedController');
});

Route::namespace('Applicant')->prefix('applicant')->middleware('applicant', 'verified')->name('applicant.')->group(function() {

	Route::get('/', 'ApplicantController@home');

	Route::resource('/profile', 'ApplicantController', ['except' => ['update', 'edit', 'show', 'create']]);

	/*WORK EXPERIENCE*/
	Route::resource('/work_experience', 'WorkController', ['except' => ['show']]);
	Route::post("delete_work/{id}", 'WorkController@destroy')->name("delete_work");
	Route::get("work_experience/create", 'WorkController@create');
	

	/*EDUCATION*/
	Route::resource('/education', 'EducationController', ['except' => ['show']]);
	Route::post("delete_education/{id}", 'EducationController@destroy')->name("delete_education");

	Route::resource('/personal', 'PersonalController', ['except' => ['create', 'store', 'destroy']]);
	Route::get('/ApplicantController/{id}', 'ApplicantController@show');
	Route::resource('/personal', 'PersonalController', ['except' => ['create', 'store', 'destroy']]);
	Route::resource('/skills', 'SkillController', ['except' => ['show', 'destroy']]);
	Route::get('/profile/download/{file}', 'ApplicantController@download');
	Route::resource('/certificate', 'CertificateController', ['except' => ['update', 'edit', 'show']]);
	Route::get('/certificate/download/{file}', 'CertificateController@download');
	Route::get('/skills/create/{skill}', 'SkillController@create');
	Route::get('/skills/{id}/edit/{skill}', 'SkillController@edit');
	
	Route::resource('/jobs', 'JobController');
	Route::get('/invitations', 'JobController@invitations');
	Route::post('/invitations_response', 'JobController@invitations_response')->name('invitations_response');
	Route::get('/savedjobs', 'JobController@jobs');
	Route::post('/saved_job', 'JobController@saved')->name('saved_job');
	Route::post('/accept_job', 'JobController@response')->name('accept_job');
});

Route::namespace('Student')->prefix('student')->middleware('student', 'verified')->name('student.')->group(function() {

	Route::get('/', 'ApplicantController@home');

	Route::resource('/profile', 'ApplicantController', ['except' => ['update', 'edit', 'show', 'create']]);

	/*WORK EXPERIENCE*/
	Route::resource('/work_experience', 'WorkController', ['except' => ['show']]);
	Route::post("delete_work/{id}", 'WorkController@destroy')->name("delete_work");
	Route::get("work_experience/create", 'WorkController@create');
	

	/*EDUCATION*/
	Route::resource('/education', 'EducationController', ['except' => ['show']]);
	Route::post("delete_education/{id}", 'EducationController@destroy')->name("delete_education");

	Route::resource('/personal', 'PersonalController', ['except' => ['create', 'store', 'destroy']]);
	Route::get('/ApplicantController/{id}', 'ApplicantController@show');
	Route::resource('/personal', 'PersonalController', ['except' => ['create', 'store', 'destroy']]);
	Route::resource('/skills', 'SkillController', ['except' => ['show', 'destroy']]);
	Route::get('/profile/download/{file}', 'ApplicantController@download');
	Route::resource('/certificate', 'CertificateController', ['except' => ['update', 'edit', 'show']]);
	Route::get('/certificate/download/{file}', 'CertificateController@download');
	Route::get('/skills/create/{skill}', 'SkillController@create');
	Route::get('/skills/{id}/edit/{skill}', 'SkillController@edit');


	Route::resource('/courses', 'CourseController');
	Route::get('/savedcourses', 'CourseController@courses');
	Route::post('/saved_course', 'CourseController@saved')->name('saved_course');
	Route::post('/accept_course', 'CourseController@response')->name('accept_course');
});

// Route::get('/register/{role}', function($role) {
// 	$decrypt = Crypt::decrypt($role);
// 	$account = App\ExtraRole::find($decrypt);

// 	return view('auth.register', compact('decrypt', 'account'));
// });

Route::get('/adminjoblist', function () {
    return view('company.profile.adminjoblist');
});

/*frontend*/
Route::get('/', function() {

	$subscribers = App\FeaturedSubscriber::all();
	// GET DETAILS TO SUBSCRIPTION
	$subscriptions = App\MaintenanceSubscriptions::all();

	$pagecontents = App\Pagecontent::where('id', '1')->first();

	//fetching all the applicant counts records to admin dashboard 
	$users1 = App\User::where('rolesId','1')->count();

	//fetching all the employers counts records to admin dashboard 
	$users2 = App\User::where('rolesId','2')->count();

	//fetching all the organization counts records to admin dashboard 
	$users3 = App\User::where('rolesId','3')->count();

	//fetching all the school counts records to admin dashboard 
	$users4 = App\User::where('rolesId','4')->count();

	$about1 = App\MaintenanceAbout::where('id','1')->first();
    $about2 = App\MaintenanceAbout::where('id','2')->first();

    $japanblogs = App\MaintenanceBlog::with('users')->where("status", 1)->where("type",0)->orderBy('id', 'desc')->get();
    $philippineblogs = App\MaintenanceBlog::with('users')->where("status", 1)->where("type",1)->orderBy('id', 'desc')->get();

	return view('front.index', compact('about1', 'about2', 'pagecontents', 'subscriptions', 'users1', 'users2', 'users3', 'users4','japanblogs','philippineblogs', 'subscribers'));
});

/*for employer*/
Route::namespace('Employer')->prefix('employer')->middleware('employer', 'verified')->name('employer.')->group(function() {

	/*employer details*/
	Route::get('/', 'EmployerController@index');
	Route::get('/profile', 'EmployerController@profile');
	Route::resource('/details', 'EmployerController'); 

	Route::resource('/subscription', 'SubscriptionController'); 
	Route::resource('/recruiters', 'RecruiterController'); 
	Route::post('/recruiters/search', 'RecruiterController@search');
	Route::get('/recruiters/search', function () { return abort(404); });

	/*employer posted jobs*/
	Route::resource('/jobs', 'JobController');
	Route::post('/close', 'JobController@close')->name('close');
	Route::post('/delete', 'JobController@delete')->name('delete');

	Route::resource('/blogs', 'BlogController');
	Route::resource('/applicants', 'ApplicantController');
	Route::get('/invitations', 'ApplicantController@invitations');

	Route::post('/approve', 'ApplicantController@approve')->name('approve');
	Route::post('/approve2', 'ApplicantController@approve2')->name('approve2');
	Route::post('/reject', 'ApplicantController@reject')->name('reject');
	Route::post('/reject2', 'ApplicantController@reject2')->name('reject2');
	
	Route::get('/saved', 'ApplicantController@saved');

	Route::resource('/branches', 'BranchController');
	Route::post('/verifyBranch', 'BranchController@verify')->name('verifyBranch');

	Route::resource('/affilations', 'AffilationController');
	Route::post('/verifyAffilation', 'AffilationController@verify')->name('verifyAffilation');

	/*summary of jobs*/
	Route::get('/summary/jobs', 'JobController@summary');

	/*summary of applicants*/
	Route::get('/summary/applicants', 'ApplicantController@summary');
	Route::post('/summary/applicants/search', 'ApplicantController@search');
	Route::get('/summary/applicants/search', function () { return abort(404); });
	
	Route::get('/summary/applicants/{id}', 'ApplicantController@applications');
	Route::get('/summary/applicants/{type}/{id}', 'ApplicantController@applicationsByType');

	Route::resource('/payment', 'PaymentInformationController');
});

/*for organization*/
Route::namespace('Organization')->prefix('organization')->middleware('organization', 'verified')->name('organization.')->group(function() {

	/*organization details*/
	Route::get('/', 'OrganizationController@index');
	Route::get('/profile', 'OrganizationController@profile');
	Route::resource('/details', 'OrganizationController');

	Route::resource('/blogs', 'BlogController');
	
	/*organization posted job*/
	Route::post('/close', 'JobController@close')->name('close');
	Route::post('/delete', 'JobController@delete')->name('delete');
	Route::resource('/jobs', 'JobController');

	/*for list of applicants*/
	Route::resource('/companies', 'CompanyController');
	Route::post('/companies/search', 'CompanyController@search');
	Route::get('/companies/search', function () { return abort(404); });
	Route::get('/invitations', 'ApplicantController@invitations');

	Route::post('/approve', 'ApplicantController@approve')->name('approve');
	Route::post('/approve2', 'ApplicantController@approve2')->name('approve2');
	Route::post('/reject', 'ApplicantController@reject')->name('reject');
	Route::post('/reject2', 'ApplicantController@reject2')->name('reject2');
	
	/*saved applicant*/
	Route::resource('/applicants', 'ApplicantController');
	Route::get('/saved', 'ApplicantController@saved');

	Route::resource('/branches', 'BranchController');
	Route::post('/verifyBranch', 'BranchController@verify')->name('verifyBranch');

	Route::resource('/partners', 'PartnerController');
	Route::post('/verifyPartner', 'PartnerController@verify')->name('verifyPartner');

	Route::resource('/affilations', 'AffilationController');
	Route::post('/verifyAffilation', 'AffilationController@verify')->name('verifyAffilation');

	/*summary of jobs*/
	Route::get('/summary/jobs', 'JobController@summary');

	/*summary of applicants*/
	Route::get('/summary/applicants', 'ApplicantController@summary');
	Route::post('/summary/applicants/search', 'ApplicantController@search');
	Route::get('/summary/applicants/search', function () { return abort(404); });
	Route::get('/summary/applicants/{id}', 'ApplicantController@applications');
	Route::get('/summary/applicants/{type}/{id}', 'ApplicantController@applicationsByType');

	Route::resource('/payment', 'PaymentInformationController');
	Route::resource('/subscription', 'SubscriptionController'); 
});

/*for support*/
Route::namespace('Support')->prefix('support')->middleware('support', 'verified')->name('support.')->group(function() {

	/*organization details*/
	Route::get('/', 'OrganizationController@index');
	Route::get('/profile', 'OrganizationController@profile');
	Route::resource('/details', 'OrganizationController');

	Route::resource('/blogs', 'BlogController');
	
	Route::resource('/branches', 'BranchController');
	Route::post('/verifyBranch', 'BranchController@verify')->name('verifyBranch');

	Route::resource('/partners', 'PartnerController');
	Route::post('/verifyPartner', 'PartnerController@verify')->name('verifyPartner');

	Route::resource('/affilations', 'AffilationController');
	Route::post('/verifyAffilation', 'AffilationController@verify')->name('verifyAffilation');

	Route::resource('/payment', 'PaymentInformationController');
	Route::resource('/subscription', 'SubscriptionController'); 
});

/*for school*/
Route::namespace('School')->prefix('school')->middleware('school', 'verified')->name('school.')->group(function() {
	/*school details*/
	Route::get('/', 'SchoolController@index');
	Route::get('/profile', 'SchoolController@profile');
	Route::resource('/details', 'SchoolController');

	Route::resource('/blogs', 'BlogController');

	/*school posted courses*/
	Route::resource('/course', 'CourseController');
	Route::post('/close', 'CourseController@close')->name('close');
	Route::post('/delete', 'CourseController@delete')->name('delete');
	Route::post('/update', 'CourseController@update')->name('update');
   
	/*students*/
	Route::resource('/students', 'StudentsController');
	Route::get('/student/{id}', 'StudentsController@student');
	Route::post('/approve', 'StudentsController@approve')->name('approve');
	Route::post('/approve2', 'StudentsController@approve2')->name('approve2');
	Route::post('/reject', 'StudentsController@reject')->name('reject');
	Route::post('/reject2', 'StudentsController@reject2')->name('reject2');

	Route::resource('/branches', 'BranchController');
	Route::post('/verifyBranch', 'BranchController@verify')->name('verifyBranch');

	Route::resource('/partners', 'PartnerController');
	Route::post('/verifyPartner', 'PartnerController@verify')->name('verifyPartner');

	Route::resource('/affilations', 'AffilationController');
	Route::post('/verifyAffilation', 'AffilationController@verify')->name('verifyAffilation');

	Route::get('/summary/courses', 'CourseController@summary');
	Route::get('/summary/students', 'StudentsController@summary');
	Route::post('/summary/search/students', 'StudentsController@search');
	Route::get('/summary/search/students', 'StudentsController@search');
	
	Route::get('/summary/students/{id}', 'StudentsController@applications');
	Route::get('/summary/students/{type}/{id}', 'StudentsController@applicationsByType');

	Route::resource('/payment', 'PaymentInformationController');
	Route::resource('/subscription', 'SubscriptionController'); 
});



Route::namespace('Subscriber')->prefix('subscriber')->middleware('subscriber', 'verified')->name('subscriber.')->group(function() {
	/*applicant*/
	Route::resource('/applicants', 'ApplicantController');
	Route::post('/applicants/search', 'ApplicantController@search');
	Route::get('/applicants/search', function () { return abort(404); });
	Route::post('/saved_applicant', 'ApplicantController@store')->name('saved_applicant');
	Route::post('/send_invitation', 'ApplicantController@send_invitation')->name('send_invitation');
	Route::get('/matched/{id}', 'ApplicantController@matched');
});

/*for subscribers*/
Route::namespace('Subscriber')->middleware('subscriber', 'verified')->group(function() {
    Route::group(['middleware' => 'requirement'], function(){
		Route::get('/pricing', 'SubscriptionsController@index');
		Route::get('/subscription/{id}', 'Payment\PaymentsController@show');
		Route::get('/subscription/over-the-counter/{id}', 'Payment\PaymentsController@otc');
		Route::post('/payment/otc', 'Payment\PaymentsController@otcpayment')->name('payment.otc');
	    Route::post('/payment/subscribe', 'Payment\PaymentsController@subscribe')->name('payment.subscribe');
	    Route::resource('/payment', 'Payment\PaymentsController');
	    Route::post('/payment/createtoken', 'Payment\PaymentsController@createtoken')->name('payment.createtoken');
	    Route::post('/payment/deletetoken', 'Payment\PaymentsController@deletetoken')->name('payment.deletetoken');












	    Route::post('/checkout', 'Payment\PaymentController@createPayment')->name('create-payment');
	    Route::get('/confirm', 'Payment\PaymentController@confirmPayment')->name('confirm-payment');


	    


	    Route::post('/cancelsubscription', 'Payment\PaymentsController@cancelsubscription')->name('payment.cancelsubscription');
	    
	    /*email templates*/
	    Route::resource('/templates', 'SubscriberTemplate');
	    Route::post('/templates/store', 'SubscriberTemplate@store')->name("store");
	    Route::post('/templates/show', 'SubscriberTemplate@show')->name("show");
		Route::post('/templates/update', 'SubscriberTemplate@update')->name("update");
		
	    Route::resource('/applicants', 'ApplicantController');
		Route::post('/applicants/search', 'ApplicantController@search')->name('saved_applicant');
		Route::get('/applicants/search', function () { return abort(404); });
	    
	    //Route::resource('/branches', 'BranchController');
    });

    /*for requirements*/
    Route::resource('/requirement', 'RequirementController');
	Route::get('/requirement/download/{file}', 'RequirementController@download');
});

Route::namespace('Front')->group(function() {
	/*jobs*/
	Route::resource('/jobs', 'JobsController', ['except' => ['search']]);
	Route::post('/jobs/search', 'JobsController@search');
	Route::get('/jobs/search', function () { return abort(404); });

	/*courses*/
	Route::resource('/courses', 'CoursesController', ['except' => ['search']]);
	Route::post('/courses/search', 'CoursesController@search');
	Route::get('/courses/search', function () { return abort(404); });

	/*company ratings*/
	Route::get('/companies', 'CompanyController@companies');
	Route::get('/companies/name/{sort}', 'CompanyController@sortn');
	Route::get('/companies/rating/{sort}', 'CompanyController@sortr');

	/*frequently asked questions*/
	Route::resource('/faqs', 'FaqsController');

	/*school profile*/
	Route::get('/school/{id}', 'SchoolController@index');

	/*company profile*/
	Route::get('/company/{id}', 'CompanyController@index');

	/*reviews and ratings to employer*/
	Route::resource('/review', 'SubscriberReview');
	Route::resource('/rate', 'SubscriberRating');
});



	Route::get('/destroy/{id}','BlogController@destroy');

	//Route::resource('/email','Email\EmailController');
	Route::get('/locale/{id}', 'HomeController@locale');
	Route::get('/nda/download', 'HomeController@nda');

	/*footer*/
	Route::resource('/about','AboutController');
	Route::resource('/blog', 'BlogController');
	Route::get('/testimony', 'FeedbackController@testimony');
	Route::resource('/contact', 'ContactController');
	Route::resource('/feedback', 'FeedbackController');
	Route::get('/privacy', function () { return view('front.privacy'); });
	Route::get('/terms', function () { return view('front.terms'); });

	
	Route::post('/payments', 'Subscriber\Payment\PaymentController@confirmSubscription')->name('payments');
	Route::get('/payments', 'Subscriber\Payment\PaymentController@confirmSubscription')->name('payments');

	

	
	/*company details*/

    
