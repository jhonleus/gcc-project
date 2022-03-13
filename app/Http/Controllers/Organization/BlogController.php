<?php

namespace App\Http\Controllers\Organization;

use DB;
use Auth;
use Alert;

use App\User;
use App\MaintenanceBlog;
use App\EmployerDetail;
use App\Http\Controllers\Controller;
use Intervention\Image\ImageManagerStatic as Image;

use Illuminate\Http\Request;

class BlogController extends Controller {

    public function index() {
        $usersId = Auth::user()->id;

		$pendings = MaintenanceBlog::where('usersId', $usersId)->where("status", 0)->paginate(10);
		$approveds = MaintenanceBlog::where('usersId', $usersId)->where("status", 1)->paginate(10);
        $rejecteds = MaintenanceBlog::where('usersId', $usersId)->where("status", 2)->paginate(10);
        
        return view('organization.blogs.index', compact( 'pendings', 'approveds', 'rejecteds'));
    }

    public function create() {
        $blogs = null;

        return view('organization.blogs.create', compact('blogs'));
    }

    public function store(Request $request) {
        $attributes = request()->validate([
            'photo'             => 'required',
            'title'             => 'required',
            'subtitle'          => 'required',
            'content'           => 'required',
            'type'              => 'required|int',
        ]);

        DB::beginTransaction();
        try {
            if($request->hasfile('photo')) {
                $usersId            = Auth::user()->id;
                $files              = $request->file('photo');
                $destinationPath    = "blogs";    
                $profileImage       = time() . "." . $files->getClientOriginalExtension();
                //$files->move(public_path()."/".$destinationPath, $profileImage);

                $image_resize = Image::make($files->getRealPath());              
                $image_resize->resize(350, 350);
                $image_resize->save(public_path()."/".$destinationPath, $profileImage);

                $blog               = new MaintenanceBlog();
                $blog->usersId      = Auth::user()->id;
                $blog->title        = $request->get('title');
                $blog->subtitle     = $request->get('subtitle');
                $blog->type         = $request->get('type');
                $blog->content      = $request->get('content');
                $blog->filename     = $profileImage;
                $blog->save();

                DB::commit();

                alert()->success('SUCCESSFULLY POSTED','');
                return redirect('organization/blogs');
            }
        } 

        catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }

    public function edit($id) {
        $usersId = Auth::user()->id;
        $blogs = MaintenanceBlog::where('id', $id)->where("usersId", $usersId)->first();

        return view('organization.blogs.create', compact('blogs'));
    }

    public function update(Request $request, $id) {
        $attributes = request()->validate([
            'title'             => 'required',
            'subtitle'          => 'required',
            'content'           => 'required',
            'type'              => 'required|int',
        ]);
        
        DB::beginTransaction();
        try {
            $usersId = Auth::user()->id;

            $blog           = MaintenanceBlog::find($id);
            $blog->title    = $request->get('title');
            $blog->subtitle = $request->get('subtitle');
            $blog->content  = $request->get('content');

            if($request->hasfile('photo')) {
                $files              = $request->file('photo');

                $destinationPath    = $usersId . "/images/blogs";    
                File::delete(public_path().$destinationPath.$blog->filename);
                
                $profileImage       = time() . "." . $files->getClientOriginalExtension();
                $image_resize = Image::make($files->getRealPath());              
                $image_resize->resize(350, 350);
                $image_resize->save(public_path()."/".$destinationPath, $profileImage);

                $blog->filename = $profileImage;
            }

            $blog->save();
            DB::commit();

            alert()->success('SUCCESSFULLY UPDATED','');
            return redirect('organization/blogs');
        } 

        catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }

    public function destroy($id) {
        DB::beginTransaction();
        try {
            $usersId = Auth::user()->id;

            MaintenanceBlog::where('id', $id)->where('usersId', $usersId)->delete();
            alert()->success('SUCCESSFULLY DELETED', '');
            return redirect('organization/blogs');
        } 

        catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }
}
