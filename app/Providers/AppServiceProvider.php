<?php

namespace App\Providers;

use View;
use Auth;
use \Carbon\Carbon;
use App\User;
use App\CompanyLogo;
use App\UserLocale;
use App\UserDocument;
use App\Feedback;
use App\MaintenanceBlog;
use App\SubscriberReviews;
use App\UserCourses;
use App\NewsAndEvent;
use App\MaintenanceNda;
use App\EmployerDetail;
use App\SchoolDetail;
use App\EmployerJob;
use App\Pagecontent;
use App\SchoolCourse;
use App\UserApplication;
use App\SubscriptionDetails;
use App\SubscriberOtc;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('path.public', function() {
          return base_path().'/public_html';
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('*', function ($view) {
            /*get company logo*/
            $company_logo = CompanyLogo::where('id','1')->first();
   
            // CHECK IF USER EXISTS CHANGED LANGUAGE
            $check_locale = UserLocale::where('token', csrf_token())->first();

            $pagecontents = Pagecontent::where('id','1')->first();

            $nda = MaintenanceNda::where('id','1')->first();

            $id = "";
            if (Auth::check()) {
                $id = Auth::user()->id;
            }

            $message =  array('ER:00:00' => 'Course Title is required.',
                            'ER:00:01'  => 'Course Title may not be greater than 255 characters.',
                            'ER:00:02'  => 'Location is required.',
                            'ER:00:03'  => 'Currency is required.',
                            'ER:00:04'  => 'Tuition Fee is required.',
                            'ER:00:05'  => 'Tuition Fee is integer only.',
                            'ER:00:06'  => 'Tuition Fee may not be greater than 255 characters.',
                            'ER:00:07'  => 'Class Start is required.',
                            'ER:00:08'  => 'Class Start may not be less than date today.',
                            'ER:00:09'  => 'Class End is required.',
                            'ER:00:10'  => 'Class End may not be less than Date Today.',
                            'ER:00:11'  => 'Class End may not be less than Class Start.',
                            'ER:00:12'  => 'Registration End is required.',
                            'ER:00:13'  => 'Registration End may not be less than Date Today.',
                            'ER:00:14'  => 'Class Schedule is required.',
                            'ER:00:15'  => 'Course Details is required.',
                            'ER:00:16'  => 'Affilations is required.',
                            'ER:00:17'  => 'Partners is required.',
                            'ER:00:18'  => 'ID is required.',
                            'ER:00:19'  => 'Branch Name is required.',
                            'ER:00:20'  => 'Branch Name may not be greater than 255 characters.',
                            'ER:00:21'  => 'Contact Number is required.',
                            'ER:00:22'  => 'Contact Number may not be greater than 255 characters.',
                            'ER:00:23'  => 'Country is required.',
                            'ER:00:24'  => 'City is required.',
                            'ER:00:25'  => 'City may not be greater than 255 characters.',
                            'ER:00:26'  => 'Street is required.',
                            'ER:00:27'  => 'Street may not be greater than 255 characters.',
                            'ER:00:28'  => 'Zip Code is required.',
                            'ER:00:29'  => 'Zip Code may not be greater than 11 characters.',
                            'ER:00:30'  => 'Zip Code is integer only.',
                            'ER:00:31'  => 'Company Name is required.',
                            'ER:00:32'  => 'Company Name may not be greater than 255 characters.',
                            'ER:00:33'  => 'Email Address is required.',
                            'ER:00:34'  => 'Email Address may not be greater than 255 characters.',
                            'ER:00:35'  => 'Industry is required.',
                            'ER:00:36'  => 'Company Type is required.',
                            'ER:00:37'  => 'About is required.',
                            'ER:00:38'  => 'Mission is required.',
                            'ER:00:39'  => 'Philosophy is required.',
                            'ER:00:40'  => 'Why You Choose Us is required.',
                            'ER:00:41'  => 'Job Title is required.',
                            'ER:00:42'  => 'Job Title may not be greater than 255 characters.',
                            'ER:00:43'  => 'Employment Type is required.',
                            'ER:00:44'  => 'Position Level is required.',
                            'ER:00:45'  => 'Job Location is required.',
                            'ER:00:46'  => 'Job\'s City or Region is required.',
                            'ER:00:47'  => 'Job\'s City or Region may not be greater than 255 characters.',
                            'ER:00:48'  => 'Specialization is required.',
                            'ER:00:49'  => 'Currency is required.',
                            'ER:00:50'  => 'Minimum Salary is required.',
                            'ER:00:51'  => 'Minimum Salary is integer only.',
                            'ER:00:52'  => 'Minimum Salary is may not be greater than 11 characters.',
                            'ER:00:53'  => 'Maximum Salary is required.',
                            'ER:00:54'  => 'Maximum Salary is integer only.',
                            'ER:00:55'  => 'Minimum Salary is may not be greater than 11 characters.',
                            'ER:00:56'  => 'Responsibility is required.',
                            'ER:00:57'  => 'Qualification is required.',
                            'ER:00:58'  => 'Job Description is required.',
                            'ER:00:59'  => 'Job Order is required.',
                            'ER:00:60'  => 'Affilation ID is invalid.',
                            'ER:00:61'  => 'Application ID is required.',
                            'ER:00:62'  => 'Application ID is invalid.',
                            'ER:00:63'  => 'Applicant Name is required.',
                            'ER:00:64'  => 'Applicant Name may not be greater than 255 characters.',
                            'ER:00:65'  => 'Subject is required.',
                            'ER:00:66'  => 'Subject may not be greater than 255 characters.',
                            'ER:00:67'  => 'Message is required.',
                            'ER:00:68'  => 'Template is required.',
                            'ER:00:69'  => 'Appointment Date is required.',
                            'ER:00:70'  => 'Appointment Date may not be less than date today.',
                            'ER:00:71'  => 'Industry ID is invalid.',
                            'ER:00:72'  => 'Organization Type ID is invalid.',
                            'ER:00:73'  => 'Country ID is invalid.',
                            'ER:00:74'  => 'Employment ID is invalid.',
                            'ER:00:75'  => 'Position Level ID is invalid.',
                            'ER:00:76'  => 'Specialization ID is invalid.',
                            'ER:00:77'  => 'Currency ID is invalid.',
                            'ER:00:78'  => 'Job ID is required.',
                            'ER:00:79'  => 'Job ID is invalid.',
                            'ER:00:80'  => 'Partners ID is invalid.',
                            'ER:00:81'  => 'Job Status is required.',
                            'ER:00:82'  => 'Job Status is integer only.',
                            'ER:00:83'  => 'Branch ID is invalid.',
                            'ER:00:84'  => 'School Name is required.',
                            'ER:00:85'  => 'School Name may not be greater than 255 characters.',
                            'ER:00:86'  => 'Location ID is invalid.',
                            'ER:00:87'  => 'Course ID is required.',
                            'ER:00:88'  => 'Course ID is invalid.',
                            'ER:00:89'  => 'Blog Title is required.',
                            'ER:00:90'  => 'Blog Subtitle is required.',
                            'ER:00:91'  => 'Blog Content is required.',
                            'ER:00:92'  => 'Blog Cover Photo is required.',
                            'ER:00:93'  => 'Blog Type is integer only.',
                            'ER:00:94'  => 'Blog Type is required.',
                            'ER:00:95'  => 'Blog ID is required.',
                            'ER:00:96'  => 'Blog ID is invalid.',
                            'ER:00:97'  => 'Applicant ID is required.',
                            'ER:00:98'  => 'Applicant ID is invalid.',
                            'ER:00:99'  => 'Certificate Type is required.',
                            'ER:01:00'  => 'Certificate Type may not be greater than 255 characters.',
                            'ER:01:01'  => 'Certificate File is required.',
                            'ER:01:02'  => 'Certificate Number is required.',
                            'ER:01:03'  => 'Certificate Number may not be greater than 255 characters.',
                            'ER:01:04'  => 'Accreditor is required.',
                            'ER:01:05'  => 'Accreditor may not be greater than 255 characters.',
                            'ER:01:06'  => 'Date Issued is required.',
                            'ER:01:07'  => 'Date Issued may not be greater than Date Today.',
                            'ER:01:08'  => 'Education Level is required.',
                            'ER:01:09'  => 'Education Level ID is invalid.',
                            'ER:01:10'  => 'Class Start may not be greater than 255 characters.',
                            'ER:01:11'  => 'Class End may not be greater than 255 characters.',
                            'ER:01:12'  => 'Strong Points is required.',
                            'ER:01:13'  => 'Weak Points is required.',
                            'ER:01:14'  => 'Position is required.',
                            'ER:01:15'  => 'Position may not be greater than 255 characters.',
                            'ER:01:16'  => 'Invitation ID is required.',
                            'ER:01:17'  => 'Invitation ID is invalid.',
                            'ER:01:18'  => 'Job Response ID is required.',
                            'ER:01:19'  => 'Job Response ID is invalid.',
                            'ER:01:20'  => 'Course Response ID is required.',
                            'ER:01:21'  => 'Course Response ID is invalid.',
                            'ER:01:22'  => 'Availability Date is invalid.',
                            'ER:01:23'  => 'Availability Date may not be less than Date Today.',
                            'ER:01:24'  => 'First Name is required.',
                            'ER:01:25'  => 'First Name may not be greater than 255 characters.',
                            'ER:01:26'  => 'Last Name is required.',
                            'ER:01:27'  => 'Last Name may not be greater than 255 characters.',
                            'ER:01:28'  => 'Username is required.',
                            'ER:01:29'  => 'Username may not be greater than 255 characters.',
                            'ER:01:30'  => 'Username has already been taken.',
                            'ER:01:31'  => 'Email Address has already been taken.',
                            'ER:01:32'  => 'Email Address is invalid.',
                            'ER:01:33'  => 'Birth Date is required.',
                            'ER:01:34'  => 'Birth Date may not be greater than date today.',
                            'ER:01:35'  => 'Gender is required.',
                            'ER:01:36'  => 'Gender ID is invalid.',
                            'ER:01:37'  => 'Civil Status is required.',
                            'ER:01:38'  => 'Civil ID is invalid.',
                            'ER:01:39'  => 'Religion is required.',
                            'ER:01:40'  => 'Religion ID is invalid.',
                            'ER:01:41'  => 'Preferred Salary may not be greater than 11 digits.',
                            'ER:01:42'  => 'Preferred Salary is integer only.',
                            'ER:01:43'  => 'Type of Visa is required.',
                            'ER:01:44'  => 'Type of Visa ID is invalid.',
                            'ER:01:45'  => 'Result is required.',
                            'ER:01:46'  => 'Result is integer only.',
                            'ER:01:47'  => 'Result may not be greater than 8 digits.',
                            'ER:01:48'  => 'Hobby ID is invalid.',
                        );

            $view->with('pagecontents',$pagecontents)->with('nda',$nda)->with('check_locale',$check_locale)->with('company_logo',$company_logo)->with('message',$message);
        });

        // View Composer
        View::composer('admin*', function ($view) {

            // Global Career Creation Blogs
            $maintenance_blogs = MaintenanceBlog::all();

            // Users Feedbacks
            $feedbacks = Feedback::where('status','0')->get();

            $allcourses = SchoolCourse::orderBy('id', 'desc')->get();
            $alljobs = EmployerJob::orderBy('id', 'desc')->get();

            $documents = UserDocument::with('requirements')->where('filetype', 'document3')->get();
        
            $num = 0;
            foreach($documents as $document) {
                
                $num++;
            }

            $registered = User::where('rolesId', '!=', 0)->orderBy('id', 'desc')->paginate(3);
            $registered2 = User::where('rolesId', '!=', 0)->orderBy('id', 'desc')->get();

            $pending_job = EmployerJob::orderBy('id', 'desc')->count();
            $pending_rev = SubscriberReviews::orderBy('id', 'desc')->count();

            $otcs = SubscriberOtc::orderBy('id', 'desc')->count();
           
            $view->with('otcs',$otcs)->with('allcourses',$allcourses)->with('alljobs',$alljobs)->with('registered2',$registered2)->with('registered',$registered)->with('maintenance_blogs',$maintenance_blogs)->with('feedbacks',$feedbacks)->with('documents',$documents)->with('num',$num)->with('pending_job',$pending_job)->with('pending_rev',$pending_rev);

        });

        /*FOR ORGANIZATIONS*/

        View::composer('organization*', function ($view) {
            /*get user id*/
            $id = "";
            if (Auth::check()) {
                $id = Auth::user()->id;
            }
            $now = Carbon::now()->format('Y-m-d');

            /* count of posted job */
            $posted_jobs = EmployerJob::where('usersId', $id)->count();

            $applicant_list = UserApplication::where("companyId", $id)->count();

            $isSubscriptionEnded = SubscriptionDetails::join("maintenance_subscriptions as ms", "ms.id", "=", "subscriber_details.subscriptionId")->where('usersId', $id)
                ->where(function($q) use($now) {
                    $q->where('last_day', '>', $now)->orWhere('last_day', null);
                })->orderBy('subscriber_details.id', 'DESC')->first();

                $canPostBlog = true;
            // $canPostBlog = SubscriptionDetails::join("maintenance_subscriptions as ms", "ms.id", "=", "subscriber_details.subscriptionId")->where('usersId', $id)->where(function($q) use($now) {
            //         $q->where('last_day', '>', $now)->orWhere('last_day', null);
            //     })->where("ms.check_blogs", 1)->orderBy('subscriber_details.id', 'DESC')->count();
            
            /*check if users subscriber to a subscription that can save applicants*/
            $canSavedApplicant = SubscriptionDetails::join("maintenance_subscriptions as ms", "ms.id", "=", "subscriber_details.subscriptionId")->where('usersId', $id)->where('last_day', '>', $now)->where("ms.check_reserve", 1)->orderBy('subscriber_details.id', 'DESC')->count();
            
            $canViewProfile = SubscriptionDetails::join("maintenance_subscriptions as ms", "ms.id", "=", "subscriber_details.subscriptionId")->where('usersId', $id)->where('last_day', '>', $now)->where("ms.check_profile", 1)->orderBy('subscriber_details.id', 'DESC')->count();

            $canSendEmail = SubscriptionDetails::join("maintenance_subscriptions as ms", "ms.id", "=", "subscriber_details.subscriptionId")->where('usersId', $id)->where('last_day', '>', $now)->where("ms.check_email", 1)->orderBy('subscriber_details.id', 'DESC')->count();
            
            /*check if user has a complete details*/
            $completeProfile  = EmployerDetail::where('usersId', $id)->first();

            $view->with('canSavedApplicant',$canSavedApplicant)->with('canViewProfile',$canViewProfile)->with('completeProfile',$completeProfile)->with('posted_jobs', $posted_jobs)->with('applicant_list', $applicant_list)->with('canSendEmail', $canSendEmail)->with('isSubscriptionEnded', $isSubscriptionEnded)->with('canPostBlog', $canPostBlog);
        });

        View::composer('support*', function ($view) {
            /*get user id*/
            $id = "";
            if (Auth::check()) {
                $id = Auth::user()->id;
            }
            $now = Carbon::now()->format('Y-m-d');

            /* count of posted job */
            $posted_jobs = EmployerJob::where('usersId', $id)->count();

            $applicant_list = UserApplication::where("companyId", $id)->count();

            $isSubscriptionEnded = SubscriptionDetails::join("maintenance_subscriptions as ms", "ms.id", "=", "subscriber_details.subscriptionId")->where('usersId', $id)
                ->where(function($q) use($now) {
                    $q->where('last_day', '>', $now)->orWhere('last_day', null);
                })->orderBy('subscriber_details.id', 'DESC')->first();

                $canPostBlog = true;
            // $canPostBlog = SubscriptionDetails::join("maintenance_subscriptions as ms", "ms.id", "=", "subscriber_details.subscriptionId")->where('usersId', $id)->where(function($q) use($now) {
            //         $q->where('last_day', '>', $now)->orWhere('last_day', null);
            //     })->where("ms.check_blogs", 1)->orderBy('subscriber_details.id', 'DESC')->count();
            
            /*check if users subscriber to a subscription that can save applicants*/
            $canSavedApplicant = SubscriptionDetails::join("maintenance_subscriptions as ms", "ms.id", "=", "subscriber_details.subscriptionId")->where('usersId', $id)->where('last_day', '>', $now)->where("ms.check_reserve", 1)->orderBy('subscriber_details.id', 'DESC')->count();
            
            $canViewProfile = SubscriptionDetails::join("maintenance_subscriptions as ms", "ms.id", "=", "subscriber_details.subscriptionId")->where('usersId', $id)->where('last_day', '>', $now)->where("ms.check_profile", 1)->orderBy('subscriber_details.id', 'DESC')->count();

            $canSendEmail = SubscriptionDetails::join("maintenance_subscriptions as ms", "ms.id", "=", "subscriber_details.subscriptionId")->where('usersId', $id)->where('last_day', '>', $now)->where("ms.check_email", 1)->orderBy('subscriber_details.id', 'DESC')->count();
            
            /*check if user has a complete details*/
            $completeProfile  = EmployerDetail::where('usersId', $id)->first();

            $view->with('canSavedApplicant',$canSavedApplicant)->with('canViewProfile',$canViewProfile)->with('completeProfile',$completeProfile)->with('posted_jobs', $posted_jobs)->with('applicant_list', $applicant_list)->with('canSendEmail', $canSendEmail)->with('isSubscriptionEnded', $isSubscriptionEnded)->with('canPostBlog', $canPostBlog);
        });

        View::composer('employer*', function ($view) {
            /*get user id*/
            $id = "";
            if (Auth::check()) {
                $id = Auth::user()->id;
            }
            $now = Carbon::now()->format('Y-m-d');

            /* count of posted job */
            $posted_jobs = EmployerJob::where('usersId', $id)->count();

            $applicant_list = UserApplication::where("companyId", $id)->count();

            $isSubscriptionEnded = SubscriptionDetails::join("maintenance_subscriptions as ms", "ms.id", "=", "subscriber_details.subscriptionId")->where('usersId', $id)
                ->where(function($q) use($now) {
                    $q->where('last_day', '>', $now)->orWhere('last_day', null);
                })->orderBy('subscriber_details.id', 'DESC')->first();

                $canPostBlog = true;
            // $canPostBlog = SubscriptionDetails::join("maintenance_subscriptions as ms", "ms.id", "=", "subscriber_details.subscriptionId")->where('usersId', $id)->where(function($q) use($now) {
            //         $q->where('last_day', '>', $now)->orWhere('last_day', null);
            //     })->where("ms.check_blogs", 1)->orderBy('subscriber_details.id', 'DESC')->count();

            /*check if users subscriber to a subscription that can save applicants*/
            $canSavedApplicant = SubscriptionDetails::join("maintenance_subscriptions as ms", "ms.id", "=", "subscriber_details.subscriptionId")->where('usersId', $id)->where(function($q) use($now) {
                    $q->where('last_day', '>', $now)->orWhere('last_day', null);
                })->where("ms.check_reserve", 1)->orderBy('subscriber_details.id', 'DESC')->count();

            $canViewProfile = SubscriptionDetails::join("maintenance_subscriptions as ms", "ms.id", "=", "subscriber_details.subscriptionId")->where('usersId', $id)->where(function($q) use($now) {
                    $q->where('last_day', '>', $now)->orWhere('last_day', null);
                })->where("ms.check_profile", 1)->orderBy('subscriber_details.id', 'DESC')->count();
            
            $canSendEmail = 0;

            /*check if user has a complete details*/
            $completeProfile  = EmployerDetail::where('usersId', $id)->first();
           
            $view->with('canSavedApplicant',$canSavedApplicant)->with('canViewProfile',$canViewProfile)->with('completeProfile',$completeProfile)->with('posted_jobs', $posted_jobs)->with('applicant_list', $applicant_list)->with('canSendEmail', $canSendEmail)->with('isSubscriptionEnded', $isSubscriptionEnded)->with('canPostBlog', $canPostBlog);
        });

        View::composer('subscriber*', function ($view) {
            /*get user id*/
            $id = "";
            $rolesId = "";
            if (Auth::check()) {
                $id = Auth::user()->id;
                $rolesId = Auth::user()->rolesId;
            }
            $now = Carbon::now()->format('Y-m-d');

            /*check if users subscriber to a subscription that can save applicants*/
            $canSavedApplicant = SubscriptionDetails::join("maintenance_subscriptions as ms", "ms.id", "=", "subscriber_details.subscriptionId")->where('usersId', $id)->where(function($q) use($now) {
                    $q->where('last_day', '>', $now)->orWhere('last_day', null);
                })->where("ms.check_reserve", 1)->orderBy('subscriber_details.id', 'DESC')->count();

            $canViewProfile = SubscriptionDetails::join("maintenance_subscriptions as ms", "ms.id", "=", "subscriber_details.subscriptionId")->where('usersId', $id)->where(function($q) use($now) {
                    $q->where('last_day', '>', $now)->orWhere('last_day', null);
                })->where("ms.check_profile", 1)->orderBy('subscriber_details.id', 'DESC')->count();
            
            if($rolesId == 2) {
                $canSendEmail = 0;
            }
            else {
                $canSendEmail = SubscriptionDetails::join("maintenance_subscriptions as ms", "ms.id", "=", "subscriber_details.subscriptionId")->where('usersId', $id)->where(function($q) use($now) {
                        $q->where('last_day', '>', $now)->orWhere('last_day', null);
                    })->where("ms.check_email", 1)->orderBy('subscriber_details.id', 'DESC')->count();
            }

            $view->with('canSavedApplicant',$canSavedApplicant)->with('canViewProfile',$canViewProfile)->with('canSendEmail', $canSendEmail);
        });

        View::composer('school*', function ($view) {
            /*get user id*/
            $id = "";
            if (Auth::check()) {
                $id = Auth::user()->id;
            }

            /* count of posted job */
            $posted_course = SchoolCourse::where('usersId', $id)->count();

            $student_list = UserCourses::where("companyId", $id)->count();

            /*check if user has a complete details*/
            $schoolProfile = SchoolDetail::where('usersId', $id)->first();
           
            $view->with('schoolProfile', $schoolProfile)->with('posted_course', $posted_course)->with('student_list', $student_list);
        });
    }  
}