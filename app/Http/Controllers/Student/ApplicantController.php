<?php

namespace App\Http\Controllers\Student;
use App\CompanyLogo;
use File;
use DB;
use App\User;
use App\UserWork;
use Auth;
use App\MaintenanceBlog;
use App\UserDocument;
use App\UserEducation;
use App\UserLocale;
use App\MaintenanceLocale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class ApplicantController extends Controller
{
    public function index() {
        $id 	= Auth::user()->id;
        $user 	= User::where('id', $id)->with('details', 'address')->first();
        $image 		= UserDocument::where('usersId', $id)->where('filetype', 'profile')->first();
        $resume 	= UserDocument::where('usersId', $id)->where('filetype', 'resume')->first();
        $tattoos 	= UserDocument::where('usersId', $id)->where('filetype', 'tattoo')->get();
        $works 		= UserWork::where('usersId', $id)->orderBy('id', 'desc')->with('country')->get();
        $educations = UserEducation::where('usersId', $id)->with('levels', 'country')->orderBy('id', 'desc')->get();

        $count = 0;

        if(!is_null($user->details)) {
        	$user_count 	= $user->count();
        }
        else {
        	$user_count 	= 0;
        	$count++;
        }

        if(!empty($image)) {
        	$img_count 		= $image->count();
        }
        else {
        	$img_count 	= 0;
        	$count++;
        }


        if(!empty($resume)) {
        	$resume_count 	= $resume->count();
        }
        else {
        	$resume_count = 0;
        	$count++;
        }


        return view('student.profile.index', compact('user', 'works', 'educations', 'image', 'resume', 'count', 'tattoos', 'user_count', 'img_count', 'resume_count'));
    }
	
    public function home()
    {   

         $displayeds = MaintenanceBlog::with('users')->where("status", 1)->get();
   
        return view('student.index',compact('displayeds'));
    }

    public function download($id) {
        $documents = UserDocument::where('id', $id)->first();
        $file_path = public_path($documents->path.''.$documents->filename);
        $replace = str_replace('/', "\'", $file_path);
        $final = str_replace("'", "", $replace);
        
        return response()->download($final);
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->has($request['btnResume'])) {

            DB::beginTransaction();
            try {
                
                $id = Auth::user()->id;
    
                if($request->hasfile('resume')) {
                    
                    $file = $request->file('resume');
                    $original = $file->getClientOriginalName();
                
                    $users = UserDocument::firstOrNew(array('filetype' => 'resume'));
    
                    $message = "";
                    if ($users->exists) {
                        File::delete(public_path().$users->path . "" . $users->filename);
                        $file->move(public_path().$users->path, $original);
                        $location = $users->path;
                        $message = MaintenanceLocale::getLocale(302);
                    } else {
                        $location = "documents/" . $id . '/resume/';
                        $file->move(public_path().$location, $original);
                        $message = MaintenanceLocale::getLocale(257);
                    }
    
                    $users->usersId = $id;
                    $users->path = $location;
                    $users->filename = $original;
                    $users->filetype = 'resume';
                    $users->save();
    
                    DB::commit();
    
                    alert()->success($message, '');
                    return redirect('applicant/profile');
                }
    
                } catch (\Exception $ex) {
                    DB::rollback();
                    return response()->json(['error' => $ex->getMessage()], 500);
                }
        } else if ($request->has($request['btnTattoo'])) {

            DB::beginTransaction();
            try {    
            
                    $id = Auth::user()->id;

                    $images = $request->file('tattoo');
                    $file_count = count($images);
                    $uploadcount = 0;
            
                    if($request->hasFile('tattoo'))
                    {
                        foreach($request->file('tattoo') as $image)
                        {
                            $documents = new UserDocument();
                            $destinationPath = "images/" . $id . "/tattoo/";
                            $filename = $image->getClientOriginalName();
                            $image->move(public_path().$destinationPath, $filename);
                            $fullPath = $destinationPath;
                        
                            $documents->usersId = $id;
                            $documents->filename = $filename;
                            $documents->filetype = 'tattoo';
                            $documents->path = $fullPath;

                        
                            $documents->save();
                            DB::commit();
                            $uploadcount++;
                            
                            if($uploadcount == $file_count){ 
                                
                                alert()->success(MaintenanceLocale::getLocale(257), '');
                                return redirect('applicant/profile');
                            } 
    
                        }
                    }

                } catch (\Exception $ex) {
                    DB::rollback();
                    return response()->json(['error' => $ex->getMessage()], 500);
                }

        } else {

            DB::beginTransaction();
        try {
            
            $id = Auth::user()->id;
           
            if($request->hasfile('upload')) {
                
                $file = $request->file('upload');
                $extension = $file->getClientOriginalExtension(); // getting image extension
            
                $users = UserDocument::firstOrNew(array('usersId' => $id));

                if ($users->exists) {
                    File::delete(public_path().$users->path . "" . $users->filename);
                    $file->move(public_path().$users->path, 'student.'.$extension);
                    $location = $users->path;
                } else {
                    $location = "images/" . $id . '/profile_pic/';
                    $file->move(public_path().$location, 'student.'.$extension);
                }

                $users->usersId = $id;
                $users->path = $location;
                $users->filename = 'student.'.$extension;
                $users->filetype = 'profile';
                $users->save();

                DB::commit();

                alert()->success(MaintenanceLocale::getLocale(258), '');
                return redirect('applicant/profile');
            }

            } catch (\Exception $ex) {
                DB::rollback();
                return response()->json(['error' => $ex->getMessage()], 500);
            }

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        UserDocument::findOrFail($id)->delete();
        alert()->success(MaintenanceLocale::getLocale(256), '');
        return redirect('applicant/profile');
    }
}