<?php

namespace App\Http\Controllers\Subscriber;

use DB;
use Auth;
use File;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/*user details*/
use App\User;
/*get uploaded document*/
use App\UserDocument;
/*get employer reason of decline*/
use App\EmployerReason;
use App\MaintenanceLocale;

class RequirementController extends Controller
{
    public function index() {
    	if(Auth::user()->isActive != 1) {
    	
    		$id 	= Auth::user()->id;
    		$users 	= User::where('id', $id)->first();
    		$reason = EmployerReason::where('usersId', $id)->first();

    		$document1 = UserDocument::where('usersId', $id)->where('filetype', 'document1')->first();
    		$document2 = UserDocument::where('usersId', $id)->where('filetype', 'document2')->first();
			$document3 = UserDocument::where('usersId', $id)->where('filetype', 'document3')->first();
			
    		return view('subscriber.requirement', compact('reason', 'users', 'document1', 'document2', 'document3'));
    	}
       	else {
        	return redirect('/');
       	}
    }

    public function download($id) {
        $documents = UserDocument::where('id', $id)->first();
        $file_path = public_path($documents->path . '' . $documents->filename);

        $replace 	= str_replace('/', "\'", $file_path);
        $final 		= str_replace("'", "", $replace);

        return response()->download($final);
    }

    public function store(Request $request) {
        $id 	= Auth::user()->id;
		$count 	= 0;
		$status = User::find($id);

		if ($request->has($request['resubmit'])) {
			
			UserDocument::where('usersId', $id)->where('filetype', 'document1')->delete();
			UserDocument::where('usersId', $id)->where('filetype', 'document2')->delete();
			UserDocument::where('usersId', $id)->where('filetype', 'document3')->delete();

			return redirect('requirement');
		} else {

        /*check if user upload a documents*/
        $document1 = UserDocument::where('usersId', $id)->where('filetype', 'document1')->count();
        $document2 = UserDocument::where('usersId', $id)->where('filetype', 'document2')->count();
        $document3 = UserDocument::where('usersId', $id)->where('filetype', 'document3')->count();

        /*check if user upload a DTI Permit or already uploaded a DTI Permit*/
        if ($document1==1 || $request->hasfile('document1')) {
            $count++;
        }

        /*check if user upload a BIR 1702 or already uploaded a BIR 1702*/
        if ($document2==1 || $request->hasfile('document2')) {
            $count++;
        }

        /*check if user upload a Business Permit or already uploaded a Business Permit*/
        if ($document3==1 || $request->hasfile('document3')) {
            $count++;
        }

        /*if user uploaded or upload only 1 document*/
        if ($count < 2) {
            alert()->error(MaintenanceLocale::getLocale(233), '');
        }
        /*if user upload 2 or more than*/
        else {
        	DB::beginTransaction();
        	try {
        		/*if DTI Permit has a file*/
        	    if ($request->hasfile('document1')) {

        	    	/*get DTI Permit file*/
        	        $file 		= $request->file('document1');
        	        /*get file type*/
            		$ext 		= $file->getClientOriginalExtension();

        	        /*create a filename by users id*/
        	        $fileName 	= hash('ripemd160', $id);
        	        $fileName 	= $fileName . "_dpermit." . $ext;

        	       	/*for reference if user has file on the database if yes replace the existing file if not create new data*/
    	            $parameters = array('filetype' 	=> 'document1',
    	        						'usersId' 	=> $id);
        	        $users 		= UserDocument::firstOrNew($parameters);

        	        /*if has file on database*/
        	        if ($users->exists) {
        	        	/*delete old file*/
        	            File::delete($users->path . "" . $users->filename);
        	            /*put new file*/
        	            $file->move(public_path()."/".$users->path, $fileName);
        	            /*location of the file*/
        	            $location = $users->path;
        	        } 
        	        /*if no file on database*/
        	        else {
        	            /*location of the file*/
        	            $location = "documents/requirements/";
        	            /*put new file*/
        	            $file->move(public_path()."/".$location, $fileName);
        	        }

        	        $users->usersId 	= $id;
        	        $users->path 		= $location;
        	        $users->filename 	= $fileName;
        	        $users->filetype 	= 'document1';
        	        /*save to database*/
        	        $users->save();
        	    }

        		/*if BIR 1702 has a file*/
        	    if ($request->hasfile('document2')) {

        	        /*get BIR 1702 file*/
        	        $file 		= $request->file('document2');
        	        /*get file type*/
            		$ext 		= $file->getClientOriginalExtension();

        	        $fileName 	= hash('ripemd160', $id);
        	        $fileName 	= $fileName . "_acert." . $ext;

        	       	/*for reference if user has file on the database if yes replace the existing file if not create new data*/
    	            $parameters = array('filetype' 	=> 'document2',
    	        						'usersId' 	=> $id);
        	        $users 		= UserDocument::firstOrNew($parameters);

        	        /*if has file on database*/
        	        if ($users->exists) {
        	        	/*delete old file*/
        	            File::delete($users->path . "" . $users->filename);
        	            /*put new file*/
        	            $file->move(public_path()."/".$users->path, $fileName);
        	            /*location of the file*/
        	            $location = $users->path;
        	        } 
        	        /*if no file on database*/
        	        else {
        	            /*location of the file*/
        	            $location = "documents/requirements/";
        	            /*put new file*/
        	            $file->move(public_path()."/".$location, $fileName);
        	        }

        	        $users->usersId 	= $id;
        	        $users->path 		= $location;
        	        $users->filename 	= $fileName;
        	        $users->filetype 	= 'document2';
        	        /*save to database*/
        	        $users->save();
        	    }

        	    /*if Business Permit has a file*/
        	    if ($request->hasfile('document3')) {

        	        /*get BIR 1702 file*/
        	        $file 		= $request->file('document3');
        	        /*get file type*/
            		$ext 		= $file->getClientOriginalExtension();

        	        $fileName 	= hash('ripemd160', $id);
        	        $fileName 	= $fileName . "_bpermit." . $ext;

        	       	/*for reference if user has file on the database if yes replace the existing file if not create new data*/
    	            $parameters = array('filetype' 	=> 'document3',
    	        						'usersId' 	=> $id);
        	        $users 		= UserDocument::firstOrNew($parameters);

        	        /*if has file on database*/
        	        if ($users->exists) {
        	        	/*delete old file*/
        	            File::delete($users->path . "" . $users->filename);
        	            /*put new file*/
        	            $file->move(public_path()."/".$users->path, $fileName);
        	            /*location of the file*/
        	            $location = $users->path;
        	        } 
        	        /*if no file on database*/
        	        else {
        	            /*location of the file*/
        	            $location = "documents/requirements/";
        	            /*put new file*/
        	            $file->move(public_path()."/".$location, $fileName);
        	        }

        	        $users->usersId 	= $id;
        	        $users->path 		= $location;
        	        $users->filename 	= $fileName;
        	        $users->filetype 	= 'document3';
        	        /*save to database*/
        	        $users->save();
        	    }

        	    DB::commit();

				if ($request->hasfile('document1') || $request->hasfile('document2') || $request->hasfile('document3')) {

					$users = User::find($id);
					if ($status->isActive == 2) {
						$users->isActive = 3;
					} else {
						$users->isActive = 0;
					}
					$users->save();
	
					alert()->success(MaintenanceLocale::getLocale(241), MaintenanceLocale::getLocale(242))->autoclose(10000);
					return redirect('requirement');

				} else {

					alert()->success(MaintenanceLocale::getLocale(302), '');
					return redirect('requirement');
				}
    	        
        	} 

        	catch (\Exception $ex) {
        	    DB::rollback();
        	    return response()->json(['error' => $ex->getMessage()], 500);
        	}
        }
	}

    }
}
