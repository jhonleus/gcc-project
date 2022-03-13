<?php

    namespace App\Http\Controllers\Front;

    use DB;
    use Auth;
    use Crypt;
    use Redirect;

    use App\User;
    use App\SubscriberReviews;
    use App\Http\Controllers\Controller;

    use Illuminate\Http\Request;
    use Illuminate\Contracts\Encryption\DecryptException;

    class SubscriberReview extends Controller {
    	/*review page*/
        public function show($encrypt) {
            try {
                $companyId     =   Crypt::decrypt($encrypt);

                $rated = false;
                if(!Auth::check()) {
                    $login = false;
                }
                else {
                    $usersId    = Auth::user()->id;
                    $reviews    = SubscriberReviews::where("usersId", $usersId)->first();

                    $login = true;

                    if($reviews) {
                        $rated      = true;
                    }

                    return view('front.review',compact("encrypt", "rated", "login", "reviews"));
                }
            }

            catch (DecryptException $e) {
                alert()->error('COMPANY IS NOT EXISTING!');
                return Redirect::back();
            }
        }

        /*insert reviews to subscriber_reviews*/
        public function store(Request $request) {
            DB::beginTransaction();
            try {

            	/*create reviews*/
                $reviews 					= new SubscriberReviews();

                /*user id of the company*/
               	$companyId2 			= 	$request->input('companyId');
                $companyId 				= 	Crypt::decrypt($companyId2);
                $reviews->companyId 	= 	$companyId;

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
                $reviews->usersId 	= 	$usersId;
                // review summary
                $reviews->summary 	= $request->input('summary');
                // review
                $reviews->review 	= $request->input('review');
                // pros
                $reviews->pros 		= $request->input('pros');
                // cons
                $reviews->cons 		= $request->input('cons');
                // overall rating
                $reviews->rating 	= $request->input('rating');
                // recommend the company if 1 = yes if no = 2
                $reviews->recommend = $request->input('recommend');
                /*review is pending for admin approval*/
                $reviews->isActive 	= 0;

                /*save to database*/
                $reviews->save();
            
                DB::commit();
            } 

            catch (\Exception $ex) {
                DB::rollback();
                return response()->json(['error' => $ex->getMessage()], 500);
            }

            alert()->success('SUCCESSFULLY REVIEWED','');

           	/*if user role is 2(employer) or is 3(organization)*/
           	if($rolesId->rolesId == 3 || $rolesId->rolesId == 2) {
           		/*redirec to company details*/
           		return redirect('company/'.$companyId2.'');
           	}
           	/*else 4(school)*/
           	else {
           		/*redirec to school details*/
           		return redirect('school/'.$companyId2.'');
           	}
        }

        public function update(Request $request, $id) {
            DB::beginTransaction();
            try {
                $companyId = Crypt::decrypt($id);

                /*create reviews*/
                $reviews    = SubscriberReviews::where("companyId", $companyId)
                            ->where("usersId", Auth::user()->id)->first();

                /*find employer details using id*/
                $rolesId = User::where("id", $companyId)->first();

                // review summary
                $reviews->summary   = $request->input('summary');
                // review
                $reviews->review    = $request->input('review');
                // pros
                $reviews->pros      = $request->input('pros');
                // cons
                $reviews->cons      = $request->input('cons');
                // overall rating
                $reviews->rating    = $request->input('rating');
                // recommend the company if 1 = yes if no = 2
                $reviews->recommend = $request->input('recommend');
                /*review is pending for admin approval*/
                $reviews->isActive  = 0;

                /*save to database*/
                $reviews->save();
            
                DB::commit();
            } 

            catch (\Exception $ex) {
                DB::rollback();
                return response()->json(['error' => $ex->getMessage()], 500);
            }

            alert()->success('SUCCESSFULLY REVIEWED!','');

            /*if user role is 2(employer) or is 3(organization)*/
            if($rolesId->rolesId == 3 || $rolesId->rolesId == 2) {
                /*redirec to company details*/
                return redirect('company/'.$id.'');
            }
            /*else 4(school)*/
            else {
                /*redirec to school details*/
                return redirect('school/'.$id.'');
            }
        }
    }
?>