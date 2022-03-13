<?php

namespace App\Console\Commands;

use DB;
use \Carbon\Carbon;

use App\User;
use App\EmailModel;
use App\EmployerJob;
use App\SubscriptionDetails;

use Illuminate\Console\Command;

class ApplicantList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'applicants:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a Daily list of applicant \'s that fits on required fields on a job to Premium Accounts' ;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $now = Carbon::now()->format('Y-m-d');

        $employers = SubscriptionDetails::join("maintenance_subscriptions as ms", "ms.id", "=", "subscriber_details.subscriptionId")->join('users as u', 'u.id', '=', 'subscriber_details.usersId')->where(function($q) use($now) {
                    $q->where('last_day', '>', $now)->orWhere('last_day', null);
                })->where("ms.check_applicant", 1)->get();

        foreach ($employers as $employerKey => $employer) {
            $jobs = EmployerJob::where("usersId", $employer->usersId)->where('isActive', 1)->where('isDeleted', 0)->where('isValidate', 1)->where('last_day', ">", $now)->get();

            foreach ($jobs as $jobKey => $job) {
                $get_spe        = $job->specializationId;
                $get_loc        = $job->locationId;
                $get_curr       = $job->currencyId;
                $get_salary     = $job->min;
                $get_title      = $job->title;

                $users = User::query()->with('details', 'address', 'contacts', 'documents', 'specialization', 'location')->where("users.rolesId", 1)
                    ->where(function($q) use($get_spe) {
                        $q->whereHas('specialization', function($r) use($get_spe) {
                            $r->where('specializationId', $get_spe); 
                        })->orWhereHas('applications', function($s) use($get_spe) {
                            $s->join('employer_jobs', "user_applications.jobId", '=', "employer_jobs.id")->where('specializationId', $get_spe);
                        });
                    })
                    ->where(function($q) use($get_loc) {
                        $q->whereHas('location', function($r) use($get_loc) {
                            $r->where('countryId', $get_loc); 
                        })->orWhereHas('address', function($s) use($get_loc) {
                            $s->where('countryId', $get_loc); 
                        })->orWhereHas('applications', function($s) use($get_loc) {
                            $s->join('employer_jobs', "user_applications.jobId", '=', "employer_jobs.id")->where('locationId', $get_loc); 
                        });
                    })
                    ->where(function($q) use($get_curr) {
                        $q->whereHas('details', function($r) use($get_curr) {
                            $r->where('currencyId', $get_curr); 
                        })->orWhereHas('applications', function($s) use($get_curr) {
                            $s->join('employer_jobs', "user_applications.jobId", '=', "employer_jobs.id")->where('currencyId', $get_curr);
                        });
                    })
                    ->where(function($q) use($get_salary) {
                        $q->whereHas('details', function($r) use($get_salary) {
                            $r->where('number', "<=", $get_salary)->where('number', ">=", $get_salary);
                        })->orWhereHas('applications', function($s) use($get_salary) {
                            $s->join('employer_jobs', "user_applications.jobId", '=', "employer_jobs.id")->where('min', '<=', $get_salary)->where('max', ">=", $get_salary);
                        });
                    })
                    ->where(function($q) use($get_title) {
                        $q->whereHas('works', function($r) use($get_title) {
                            $r->where('position', 'like', '%'.$get_title.'%'); 
                        })->orWhereHas('applications', function($s) use($get_title) {
                            $s->join('employer_jobs', "user_applications.jobId", '=', "employer_jobs.id")->where('title', 'like', '%'.$get_title.'%');
                        });
                    })->get();

                $actions = "Check the list <a href='".url('subscriber/matched/'.$job->usersId.'')."'>here!</a>";

                $parameters = array("receiver_email" => $employer->email, 'receiver_name' => $employer->firstName." ".$employer->lastName, 'message' => "New matched applicant to your job post.", "subject" => 'Matched Applicant on '.$get_title.'', 'actions' => $actions, 'users' => $users);

                EmailModel::sendEmail2($parameters);

                $this->info("SEND SUCCESSFULLY");
            }
        }
    }
}
