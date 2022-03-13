<?php

namespace App\Http\Controllers\Admin;
use DB;
use File;
use App\CompanyLogo;
use App\MaintenanceBlog;
use App\MaintenanceSubscriptions;
use App\Pagecontent;
use App\Homepage;
use App\CustomerService;
use App\MaintenanceAbout;
use App\MaintenanceNda;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Alert;
use App\UserLocale;
use App\MaintenanceLocale;

class PagecontentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      //fetching pagecontents table
      $pagecontents = Pagecontent::where('id', '1')->first();
      //fetching customerservicesupports table
      $customerservicesupports = CustomerService::where('id', '1')->first();
     
      $about1 = MaintenanceAbout::where('id','1')->first();
      $about2 = MaintenanceAbout::where('id','2')->first();
      $about3 = MaintenanceAbout::where('id','3')->first();

      $nda = MaintenanceNda::where('id','1')->first();

      $extras = MaintenanceLocale::where('id','485')->orWhere('id','486')->orWhere('id','487')->orWhere('id','488')->orWhere('id','489')->get();
      
      return view('admin.maintenance.index', compact('extras', 'nda', 'about1', 'about2', 'about3', 'customerservicesupports', 'pagecontents'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function download($id) {

        $documents = MaintenanceNda::where('id', $id)->first();

        $file_path = public_path('nda/'.$documents->file);
        $replace = str_replace('/', "\'", $file_path);
        $final = str_replace("'", "", $replace);

        return response()->download($final);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {     

        DB::beginTransaction();
            try {

                $id = $request->get('locale_id');

                $extra = MaintenanceLocale::find($id);
                $extra->name = $request->get('locale_name');
                $extra->translated = $request->get('locale_translated');
                $extra->save();

                DB::commit();

                alert()->success(MaintenanceLocale::getLocale(258),'');
                return redirect('admin/maintenance');

            } catch (\Exception $ex) {
                DB::rollback();
                return response()->json(['error' => $ex->getMessage()], 500);
            }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Pagecontent  $pagecontent
     * @return \Illuminate\Http\Response
     */
    public function show(Pagecontent $pagecontent)
    {
         
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Pagecontent  $pagecontent
     * @return \Illuminate\Http\Response
     */
    public function edit(Pagecontent $pagecontent)
    {
    
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $resquest
     * @param  \App\Pagecontent  $pagecontent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        // ******************** Company Logo **************************
        if ($request->has($request['btnLogo'])) {

            DB::beginTransaction();
            try {
            
                if($request->hasfile('photo_name')) {
                    
                    $files = $request->file('photo_name');
                    $destinationPath = public_path('/company_logo/');    

                    $profileImage = date('YmdHis');
                    $extension = $files->getClientOriginalExtension();
                    $files->move($destinationPath, $profileImage.".".$extension);

                    $imagemodel= CompanyLogo::find($id);
                    $imagemodel->photo_name = $profileImage.".".$extension;
                    $imagemodel->save();
    
                    DB::commit();
    
                    alert()->success(MaintenanceLocale::getLocale(258),'');
                    return redirect('admin/maintenance');
                }
    
            } catch (\Exception $ex) {
                DB::rollback();
                return response()->json(['error' => $ex->getMessage()], 500);
            }

        // ******************** Login Page **************************
        } else if ($request->has($request['btnLogin'])) {

            DB::beginTransaction();
            try {
            
                if($request->hasfile('photo_other1')) {
                    
                    $files = $request->file('photo_other1');
                    $destinationPath = public_path('/login-images/');
                    $profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
                    $files->move($destinationPath, $profileImage);
                    $imagemodel= Pagecontent::find($id);
                    $imagemodel->login = $profileImage;
                    $imagemodel->save();
    
                    DB::commit();
    
                    alert()->success(MaintenanceLocale::getLocale(258),'');
                    return redirect('admin/maintenance');
                }
    
            } catch (\Exception $ex) {
                DB::rollback();
                return response()->json(['error' => $ex->getMessage()], 500);
            }

        // ******************** Registration Page **************************
        } else if ($request->has($request['btnReg'])) {

            DB::beginTransaction();
            try {
            
                if($request->hasfile('photo_other4')) {
                    
                    $files = $request->file('photo_other4');
                    $destinationPath = public_path('/login-images/');
                    $profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
                    $files->move($destinationPath, $profileImage);
                    $imagemodel= Pagecontent::find($id);
                    $imagemodel->register = $profileImage;
                    $imagemodel->save();
    
                    DB::commit();
    
                    alert()->success(MaintenanceLocale::getLocale(258),'');
                    return redirect('admin/maintenance');
                }
    
            } catch (\Exception $ex) {
                DB::rollback();
                return response()->json(['error' => $ex->getMessage()], 500);
            }

        // ******************** Contact Support Page **************************
        } else if ($request->has($request['btnContact'])) {

            DB::beginTransaction();
            try {
            
                if($request->hasfile('photo_other2')) {
                    
                    $files = $request->file('photo_other2');
                    $destinationPath = public_path('/login-images/');
                    $profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
                    $files->move($destinationPath, $profileImage);
                    $imagemodel= Pagecontent::find($id);
                    $imagemodel->contact = $profileImage;
                    $imagemodel->save();
    
                    DB::commit();
    
                    alert()->success(MaintenanceLocale::getLocale(258),'');
                    return redirect('admin/maintenance');
                }
    
            } catch (\Exception $ex) {
                DB::rollback();
                return response()->json(['error' => $ex->getMessage()], 500);
            }

        // ******************** Feedback Page **************************
        } else if ($request->has($request['btnFeedback'])) {

            DB::beginTransaction();
            try {
            
                if($request->hasfile('photo_other3')) {
                    
                    $files = $request->file('photo_other3');
                    $destinationPath = public_path('/login-images/');
                    $profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
                    $files->move($destinationPath, $profileImage);
                    $imagemodel= Pagecontent::find($id);
                    $imagemodel->feedback = $profileImage;
                    $imagemodel->save();
    
                    DB::commit();
    
                    alert()->success(MaintenanceLocale::getLocale(258),'');
                    return redirect('admin/maintenance');
                }
    
            } catch (\Exception $ex) {
                DB::rollback();
                return response()->json(['error' => $ex->getMessage()], 500);
            }

        // ******************** NDA **************************
        } else if ($request->has($request['btnNDA'])) {

            DB::beginTransaction();
            try {
            
                if($request->hasfile('nda')) {
                    
                    $files = $request->file('nda');
                    $destinationPath = public_path('/NDA/');    
                    $profileImage = date('YmdHis') . "." . $files->getClientOriginalExtension();
                    $files->move($destinationPath, $profileImage);
                    $imagemodel= MaintenanceNda::firstOrNew(array('id' => '1'));
                    $imagemodel->file = $profileImage;
                    $imagemodel->save();
    
                    DB::commit();
    
                    alert()->success(MaintenanceLocale::getLocale(258),'');
                    return redirect('admin/maintenance');
                }
    
            } catch (\Exception $ex) {
                DB::rollback();
                return response()->json(['error' => $ex->getMessage()], 500);
            }

        // ******************** HOW IT WORKS **************************
        } else if ($request->has($request['btnHow'])) {

            DB::beginTransaction();
            try {

                $home = Pagecontent::find($id);
                $home->url = $request->input('pageurl');

                $home->save();

                DB::commit();
    
                alert()->success(MaintenanceLocale::getLocale(258),'');
                return redirect('admin/maintenance');
                
    
            } catch (\Exception $ex) {
                DB::rollback();
                return response()->json(['error' => $ex->getMessage()], 500);
            }

        // ******************** Home Page **************************
        } else if ($request->has($request['btnHome'])) {

            DB::beginTransaction();
            try {
             
                $home = Pagecontent::find($id);
                
                $check_users = '';
                if($request->has('check_users') ){
                    $check_users = true;
                } else {
                    $check_users = false;
                }

                $home->users = $check_users;

                $home->save();

                if($request->hasfile('photo_home0')) {
                    
                    $files = $request->file('photo_home0');
                    $destinationPath = public_path('/login-images/');  

                    $profileImage = date('YmdHis')."1";
                    $extension = $files->getClientOriginalExtension();
                    $files->move($destinationPath, $profileImage.".".$extension);

                    $about = Pagecontent::find($id);
                    $about->head = $profileImage.".".$extension;
                    $about->save();
                }

                if($request->hasfile('photo_home1')) {
                    
                    $files = $request->file('photo_home1');
                    $destinationPath = public_path('/login-images/');    
                    
                    $profileImage = date('YmdHis')."2";
                    $extension = $files->getClientOriginalExtension();
                    $files->move($destinationPath, $profileImage.".".$extension);

                    $about = Pagecontent::find($id);
                    $about->picture1 = $profileImage.".".$extension;
                    $about->save();
                }

                if($request->hasfile('photo_home2')) {
                    
                    $files = $request->file('photo_home2');
                    $destinationPath = public_path('/login-images/');    
                    
                    $profileImage = date('YmdHis')."3";
                    $extension = $files->getClientOriginalExtension();
                    $files->move($destinationPath, $profileImage.".".$extension);

                    $about = Pagecontent::find($id);
                    $about->picture2 = $profileImage.".".$extension;
                    $about->save();
                }
    
                DB::commit();
    
                alert()->success(MaintenanceLocale::getLocale(258),'');
                return redirect('admin/maintenance');

    
            } catch (\Exception $ex) {
                DB::rollback();
                return response()->json(['error' => $ex->getMessage()], 500);
            }

        // ******************** Customer Service Support Line ********************* *****
        } else if ($request->has($request['btnService'])) {

            DB::beginTransaction();
            try {
            
                $customerservicesupports = Customerservice::find($id);
                $customerservicesupports->email = $request->input('email');
                $customerservicesupports->password = $request->input('password');
                $customerservicesupports->address = $request->input('address');
                $customerservicesupports->phone = $request->input('phone');
                $customerservicesupports->telephone = $request->input('telephone');
                $customerservicesupports->save();
    
                DB::commit();
    
                alert()->success(MaintenanceLocale::getLocale(258),'');
                return redirect('admin/maintenance');
    
            } catch (\Exception $ex) {
                DB::rollback();
                return response()->json(['error' => $ex->getMessage()], 500);
            }

        // ******************** About Us **************************   
        } else if ($request->has($request['btnAbout'])) {

            DB::beginTransaction();
            try {
            
    
                if($request->hasfile('photo_name1')) {
                    
                    $files = $request->file('photo_name1');
                    $destinationPath = public_path('/login-images/'); 

                    $profileImage = date('YmdHis')."1";
                    $extension = $files->getClientOriginalExtension();
                    $files->move($destinationPath, $profileImage.".".$extension);

                    $about1 = MaintenanceAbout::firstOrNew(array('id' => 1));
                    $about1->picture = $profileImage.".".$extension;
                    $about1->save();
                }

               

                if($request->hasfile('photo_name2')) {
                    
                    $files = $request->file('photo_name2');
                    $destinationPath = public_path('/login-images/');    
                    
                    $profileImage = date('YmdHis')."2";
                    $extension = $files->getClientOriginalExtension();
                    $files->move($destinationPath, $profileImage.".".$extension);

                    $about2 = MaintenanceAbout::firstOrNew(array('id' => 2));
                    $about2->picture = $profileImage.".".$extension;
                    $about2->save();
                }
    
                DB::commit();

                alert()->success(MaintenanceLocale::getLocale(258),'');
                return redirect('admin/maintenance');
    
            } catch (\Exception $ex) {
                DB::rollback();
                return response()->json(['error' => $ex->getMessage()], 500);
            }
  
        }
        

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pagecontent  $pagecontent
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pagecontent $pagecontent)
    {
        //

    }
}
