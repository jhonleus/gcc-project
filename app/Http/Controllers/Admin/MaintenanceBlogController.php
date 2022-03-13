<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\MaintenanceBlog;
use DB;
use File;
use Illuminate\Http\Request;
use Alert;
use App\UserLocale;
use App\MaintenanceLocale;

class MaintenanceBlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $admins = MaintenanceBlog::where("usersId", 0)->where("selected", 0)->orderBy('id', 'desc')->get();
        $pendings = MaintenanceBlog::with('users')->where("status", 0)->where("usersId", "!=", 0)->orderBy('id', 'desc')->get();
		$approveds = MaintenanceBlog::with('users')->where("status", 1)->where("selected", 0)->where("usersId", "!=", 0)->orderBy('id', 'desc')->get();
        $rejecteds = MaintenanceBlog::with('users')->where("status", 2)->where("usersId", "!=", 0)->orderBy('id', 'desc')->get();
        $displayeds = MaintenanceBlog::with('users')->where("status", 1)->where("selected", 1)->orderBy('id', 'desc')->get();

        //after getting all the data from the table, it will return the data to the blade
        return view('admin.blog.index', compact('admins', 'pendings', 'approveds', 'rejecteds', 'displayeds'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $blogs = null;

        return view('admin.blog.create', compact('blogs'));
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

            if($request->hasfile('photo')) {
                
                $files = $request->file('photo');
                $destinationPath = public_path('/blogs/');    
                $profileImage = date('YmdHis');
                $extension = $files->getClientOriginalExtension();
                $files->move($destinationPath, $profileImage.".".$extension);

                $blog = new MaintenanceBlog();
                $blog->usersId = 0;
                $blog->title = $request->get('title');
                $blog->subtitle = $request->get('subtitle');
                $blog->type = $request->get('type');
                $blog->content = $request->get('content');
                $blog->filename = $profileImage.".".$extension;
                $blog->status = 1;
                $blog->save();

                
                DB::commit();
                alert()->success(MaintenanceLocale::getLocale(291),'');
                return redirect('admin/blog');
            }


        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
        }

       
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\MaintenanceBlog  $maintenanceBlog
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\MaintenanceBlog  $maintenanceBlog
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $blogs = MaintenanceBlog::where('id', $id)->first();

        return view('employer.blogs.create', compact('blogs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MaintenanceBlog  $maintenanceBlog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // ******************** UPDATE BLOG **************************
        if ($request->has($request['btnBlog'])) {

            DB::beginTransaction();
            try {

                if($request->hasfile('photo')) {
                    
                    $files = $request->file('photo');
                    $destinationPath = public_path('/blogs/');    
                    $profileImage = date('YmdHis');
                    $extension = $files->getClientOriginalExtension();
                    $files->move($destinationPath, $profileImage.".".$extension);

                    $blog = MaintenanceBlog::find($id);
                    $blog->usersId = 0;
                    $blog->title = $request->get('title');
                    $blog->subtitle = $request->get('subtitle');
                    $blog->content = $request->get('content');
                    $blog->filename = $profileImage.".".$extension;
                    $blog->save();
                    
                    DB::commit();

                    alert()->success(MaintenanceLocale::getLocale(258),'');
                    return redirect('admin/blog');
                }

            } catch (\Exception $ex) {
                DB::rollback();
                return response()->json(['error' => $ex->getMessage()], 500);
            }   

        // ******************** APPROVE **************************
        } if ($request->has($request['btnApprove'])) {

            DB::beginTransaction();
            try {
            
                $blog = MaintenanceBlog::find($id);
                $blog->status = 1;
                $blog->save();
    
                DB::commit();
    
                alert()->success(MaintenanceLocale::getLocale(247),'');
                return redirect('admin/blog');
    
            } catch (\Exception $ex) {
                DB::rollback();
                return response()->json(['error' => $ex->getMessage()], 500);
            }

        // ******************** REJECT **************************
        } if ($request->has($request['btnReject'])) {

            DB::beginTransaction();
            try {
            
                $blog = MaintenanceBlog::find($id);
                $blog->status = 2;
                $blog->save();
    
                DB::commit();
    
                alert()->success(MaintenanceLocale::getLocale(246),'');
                return redirect('admin/blog');
    
            } catch (\Exception $ex) {
                DB::rollback();
                return response()->json(['error' => $ex->getMessage()], 500);
            }
        
        // ******************** MOVE TO PENDING **************************
        } if ($request->has($request['btnPending'])) {

            DB::beginTransaction();
            try {
            
                $blog = MaintenanceBlog::find($id);
                $blog->status = 0;
                $blog->save();
    
                DB::commit();
    
                alert()->success(MaintenanceLocale::getLocale(266),'');
                return redirect('admin/blog');
    
            } catch (\Exception $ex) {
                DB::rollback();
                return response()->json(['error' => $ex->getMessage()], 500);
            }
        
        // ******************** DISPLAY **************************
        } if ($request->has($request['btnDisplay'])) {

            $displayeds = MaintenanceBlog::with('users')->where("status", 1)->where("selected", 1)->get();
            $total_display = $displayeds->count();

            if ($total_display >= 5) {

                alert()->error(MaintenanceLocale::getLocale(267),'');
                return redirect('admin/blog');

            } else {

                DB::beginTransaction();
                try {
                
                    $blog = MaintenanceBlog::find($id);
                    $blog->selected = 1;
                    $blog->save();
        
                    DB::commit();
        
                    alert()->success(MaintenanceLocale::getLocale(268),'');
                    return redirect('admin/blog');
        
                } catch (\Exception $ex) {
                    DB::rollback();
                    return response()->json(['error' => $ex->getMessage()], 500);
                }

            }
        
        // ******************** UNDISPLAY **************************
        } if ($request->has($request['btnUnDisplay'])) {

            DB::beginTransaction();
            try {
            
                $blog = MaintenanceBlog::find($id);
                $blog->selected = 0;
                $blog->save();
    
                DB::commit();
    
                alert()->success(MaintenanceLocale::getLocale(269),'');
                return redirect('admin/blog');
    
            } catch (\Exception $ex) {
                DB::rollback();
                return response()->json(['error' => $ex->getMessage()], 500);
            }
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MaintenanceBlog  $maintenanceBlog
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        MaintenanceBlog::findOrFail($id)->delete();
        alert()->success(MaintenanceLocale::getLocale(256), '');
        return redirect('admin/blog');
    }
}
