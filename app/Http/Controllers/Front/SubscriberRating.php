<?php

    namespace App\Http\Controllers\Front;

    use DB;
    use Auth;
    use Crypt;
    use Redirect;

    use App\User;
    use App\SubscriberRatings;
    use App\Http\Controllers\Controller;

    use Illuminate\Http\Request;
    use Illuminate\Contracts\Encryption\DecryptException;

    class SubscriberRating extends Controller {
    	/*rating page*/
        public function show($encrypt) {
            try {
                /*decrypt usersId*/
                $userId = Crypt::decrypt($encrypt);

                /*find users details using id*/
                $user = User::where("id", $userId)->first();

                /*if user role is 2(employer) or is 3(organization)*/
                if($user->rolesId == 2 || $user->rolesId == 3) {
                	$fee 	= "Salary";
                	$class 	= "Work";
                	$env 	= "Employee's Relation";
                }
                /*else 4(school)*/
                else {
                	$fee 	= "Tuition Fee";
                	$class 	= "School";
                	$env 	= "Professor's Teaching";
                }

                return view('front.rating', compact("encrypt", "fee", "class", "env"));
            }

            catch (DecryptException $e) {
                alert()->error('COMPANY IS NOT EXISTING!');
                return Redirect::back();
            }
        }

        /*insert ratings to subscriber_ratings*/
        public function store(Request $request) {
            DB::beginTransaction();
            try {
            	/*create ratings*/
                $ratings 					= new SubscriberRatings();

                /*user id of the company*/
               	$companyId2 			= 	$request->input('companyId');
                $companyId 				= 	Crypt::decrypt($companyId2);
                $ratings->companyId 	= 	$companyId;

           	 	/*find employer details using id*/
                $rolesId = User::where("id", $companyId)->first();

                /*if user is login*/
                if (Auth::check()) {
                	$usersId = Auth::user()->id;
                }
                /*if not*/
                else {
                	$usersId = 0;
                }

                /*id of the user*/
                $ratings->usersId 		= 	$usersId;

                // environment rate
                $environment			= $request->input('environment');
                $ratings->environment 	= $environment;

                // career growth rate
                $career_growth			= $request->input('career_growth');
                $ratings->career_growth = $career_growth;

                // security
                $security				= $request->input('security');
                $ratings->security 		= $security;

                // relation
                $relation 				= $request->input('relation');
                $ratings->relation 		= $relation;

                // salary or tuition
                $fees_rate				= $request->input('fees_rate');
                $ratings->fees 			= $fees_rate;

                /*compute the overall average of the rate*/
                $overall = ($career_growth + $environment + $security + $relation + $fees_rate) / 5;
                /*overall rate*/
                $ratings->overall 		= $overall;

                /*save to database*/
                $ratings->save();
            
                DB::commit();


                alert()->success('SUCCESSFULLY RATED!','');

                /*if user role is 2(employer) or is 3(organization)*/
                if($rolesId->rolesId == 3 || $rolesId->rolesId == 2) {
                    /*redirect to company details*/
                    return redirect('company/'.$companyId2.'');
                }
                /*else 4(school)*/
                else {
                    /*redirect to school details*/
                    return redirect('school/'.$companyId2.'');
                }
            } 

            catch (\Exception $ex) {
                DB::rollback();
                return response()->json(['error' => $ex->getMessage()], 500);
            }
        }
    }
?>