<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Contracts\CourseContract;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\CourseFeature;
use App\Models\Category;
use App\Models\Chapter;
use App\Models\Teacher;
use DB;

class CourseManagementController extends BaseController
{
	public function __construct(CourseContract $CourseManagementRepository)
    {
        $this->CourseManagementRepository = $CourseManagementRepository;
    }

	// Course Details
    public function index(Request $req )
    {
        $teacher = DB::table('teachers')->where('is_active','1')->get();
    	$course = Course::paginate(10);
    	return view('admin.course.index',compact('course','teacher'));
    }

    public function createCourse(Request $req)
    {
        $category = Category::all();
        //$sub_category = SubjectCategory::all();
        $admin = DB::table('admins')->where('is_active','1')->where('name', 'Admin')->first();
    	return view('admin.course.create',compact('category','admin'));
    }

    public function saveCourse(Request $req)
    {
    	$req->validate([
    		'image' => 'required',
    		'name' => 'required|max:200|string|unique:courses,course_name',
    		'price' => 'required|numeric|min:1|max:99999',
    		'description' => 'required',
    	]);
    	$course = new Course;
		$upload_path = "upload/course/";
    	if($req->hasFile('image')){
			$image = $req->file('image');
			$imageName = time()."_".mt_rand().".".$image->getClientOriginalExtension();
			$image->move(public_path().'/'.$upload_path, $imageName);
			$uploadedImage = $imageName;
			$course->course_image = $upload_path.$uploadedImage;
		}
        $course->teacherId = $req->created_by;
    	$course->course_name = $req->name;
    	$course->price = $req->price;
    	$course->course_description = $req->description;
    	$course->save();
    	return $this->responseRedirect('admin.course', 'Course added successfully' ,'success',false, false);
    }

    // public function deleteCourse(Request $req)
    // {
    // 	$rules = [
    // 		'id' => 'required|min:1|numeric',
    // 		'status' => 'required|in:1,2',
    // 	];
    // 	$validate = validator()->make($req->all(),$rules);
    // 	if(!$validate->fails()){
    // 		$deleted_at = null;
    // 		if($req->status != 1){
    // 			$deleted_at = date('Y-m-d h:i:s');
    // 			CourseLecture::where('course_id',$req->id)->withTrashed()->update(['deleted_at'=>$deleted_at]);
	// 			CourseFeature::where('course_id',$req->id)->withTrashed()->update(['deleted_at'=>$deleted_at]);
    // 		}
    // 		Course::where('id',$req->id)->withTrashed()->update(['deleted_at'=>$deleted_at]);
    		
    // 		return response()->json(['error'=>false,'message'=>'Course Status Updated successfully']);
    // 	}
    // 	return response()->json(['error'=>true,'message'=>$validate->errors()->first()]);
    // }
	public function deleteCourse($id)
    {
        $response = Course::find($id)->delete();
        if (!$response) {
            return $this->responseRedirectBack('Error occurred while deleting.', 'error', true, true);
        }
        return redirect(route('admin.course'))->with('success','Course deleted successfully');
        // return $this->responseRedirect('admin.course.chapters.index', 'Chapter  successfully' ,'success',false, false);
    }
    public function editCourse(Request $req,$courseId)
    {
        $category = Category::all();
        $admin = DB::table('admins')->where('is_active','1')->where('name', 'Admin')->first();
    	$course = Course::where('id',$courseId)->withTrashed()->first();
    	return view('admin.course.edit',compact('course','category','admin'));
    }

    public function updateCourse(Request $req, $id)
    {
    	$req->validate([
    		'name' => 'required|max:200|string',
    		'price' => 'required|numeric|min:1|max:99999',
    		'description' => 'required',
    	]);
    	$check = Course::where('id','!=',$id)->where('course_name',$req->name)->withTrashed()->first();

		$upload_path = "upload/course/";
    	if(!$check){
    		$course = Course::where('id',$id)->withTrashed()->first();
	    	if($req->hasFile('image')){
				$image = $req->file('image');
				$imageName = time()."_".mt_rand().".".$image->getClientOriginalExtension();
				$image->move(public_path().'/'.$upload_path, $imageName);
				$uploadedImage = $imageName;
				$course->course_image = $upload_path.$uploadedImage;
	        }
	    	$course->course_name = $req->name;
            $course->teacherId = $req->created_by;

	    	$course->price = $req->price;
	    	$course->course_description = $req->description;
	    	$course->save();
	    	return $this->responseRedirect('admin.course', 'Course Updated successfully' ,'success',false, false);
    	}
    	$error['name'] = 'The name has already been taken.';
    	return back()->withErrors($error)->withInput($req->all());
    }

    // Course Lecture Details
    public function lectures(Request $req,$courseId)
    {
    	$course = Course::where('id',$courseId)->with('lecture')->withTrashed()->first();
    	return view('admin.course.lecture.index',compact('course'));
    }

    public function saveLecture(Request $req,$courseId)
    {
    	$req->validate([
    		'form' => 'required|in:add', // just for Showing Modal not need in entire logic
    		'title' => 'required|string|max:200',
    		'media' => 'required|string',
    		'description' => 'required|string|max:200',
    	]);
    	DB::beginTransaction();
		try {
			$course = Course::where('id',$courseId)->withTrashed()->first();
	    	$lecture = new CourseLecture();
	    	$lecture->course_id = $course->id;
	    	$lecture->title = $req->title;
	    	$lecture->description = $req->description;
	    	$lecture->media = $req->media;
	    	$lecture->deleted_at = $course->deleted_at;
	    	$lecture->save();
	    	DB::commit();
    		return $this->responseRedirectBack('Lecture added successfully' ,'success',false, false);
    	} catch (Exception $e) {
			DB::rollback();
			$error['description'] = 'Somethig went wrong please try after some time';
			return back()->withErrors($error)->withInput($req->all());
    	}
    }

    public function updateLecture(Request $req,$courseId)
    {
    	$req->validate([
    		'form' => 'required|in:update', // just for Showing Modal not need in entire logic
    		'lectureId' => 'required|min:1|numeric',
    		'title' => 'required|string|max:200',
    		'media' => 'required|string',
    		'description' => 'required|string|max:200',
    	]);
    	DB::beginTransaction();
		try {
	    	$lecture = CourseLecture::where('id',$req->lectureId)->where('course_id',$courseId)->withTrashed()->first();
	    	$lecture->title = $req->title;
	    	$lecture->description = $req->description;
	    	$lecture->media = $req->media;
	    	$lecture->save();
	    	DB::commit();
    		return $this->responseRedirectBack('Lecture updated successfully' ,'success',false, false);
    	} catch (Exception $e) {
			DB::rollback();
			$error['description'] = 'Somethig went wrong please try after some time';
			return back()->withErrors($error)->withInput($req->all());
    	}
    }

    public function deleteLectures(Request $req)
    {
    	$rules = [
    		'id' => 'required|min:1|numeric',
    		'courseId' => 'required|min:1|numeric',
    		'status' => 'required|in:1,2',
    	];
    	$validate = validator()->make($req->all(),$rules);
    	if(!$validate->fails()){
    		$deleted_at = date('Y-m-d h:i:s');
    		if($req->status == 1){
    			$deleted_at = null;
    			Course::where('id',$req->courseId)->update(['deleted_at'=>$deleted_at]);
    		}
    		CourseLecture::where('id',$req->id)->where('course_id',$req->courseId)->update(['deleted_at'=>$deleted_at]);
    		return response()->json(['error'=>false,'message'=>'Lecture Status Updated successfully']);
    	}
    	return response()->json(['error'=>true,'message'=>$validate->errors()->first()]);
    }


    // Course Chapter detials start //
    public function chapters(Request $req, $courseId)
    {
        $chapters = Chapter::where('courseId',$courseId)->get();
        return view('admin.course.chapter.index',compact('chapters'));
    }

    public function editCourseChapter($id,$courseId)
    {
        echo "hi";
    }


    // Course Chapter Details End //

    // Course Features Details
    public function features(Request $req, $courseId)
    {
    	$course = Course::where('id',$courseId)->with('feature')->first();
    	return view('admin.course.feature.index',compact('course'));
    }

    public function saveFeature(Request $req,$courseId)
    {
    	$req->validate([
    		'form' => 'required|in:add', // just for Showing Modal not need in entire logic
    		'feature' => 'required|max:200',
    	]);
    	$check = CourseFeature::where('course_id',$courseId)->where('feature',$req->feature)->withTrashed()->first();
    	if(!$check){
    		DB::beginTransaction();
    		try {
    			$course = Course::where('id',$courseId)->withTrashed()->first();
    			$feature = new CourseFeature();
	    		$feature->course_id = $courseId;
	    		$feature->feature = $req->feature;
	    		$feature->deleted_at = $course->deleted_at;
	    		$feature->save();
    			DB::commit();
    			return $this->responseRedirectBack('Feature added successfully' ,'success',false, false);
    		} catch (Exception $e) {
    			DB::rollback();
    			$error['feature'] = 'Somethig went wrong please try after some time';
    			return back()->withErrors($error)->withInput($req->all());
    		}
    	}
    	$error['feature'] = 'This feature is already exists';
    	return back()->withErrors($error)->withInput($req->all());
    }

    public function updateFeature(Request $req,$courseId)
    {
    	$req->validate([
    		'form' => 'required|in:update', // just for Showing Modal not need in entire logic
    		'featureId' => 'required|min:1|numeric',
    		'feature_name' => 'required|max:200',
    	]);
    	$check = CourseFeature::where('course_id',$courseId)->where('id','!=',$req->featureId)->where('feature',$req->feature_name)->withTrashed()->first();
    	if(!$check){
    		DB::beginTransaction();
    		try {
    			$feature = CourseFeature::where('id',$req->featureId)->withTrashed()->first();
	    		$feature->feature = $req->feature_name;
	    		$feature->save();
    			DB::commit();
    			return $this->responseRedirectBack('Feature updated successfully' ,'success',false, false);
    		} catch (Exception $e) {
    			DB::rollback();
    			$error['feature_name'] = 'Somethig went wrong please try after some time';
    			return back()->withErrors($error)->withInput($req->all());
    		}	
    	}
    	$error['feature_name'] = 'This feature is already exists';
    	return back()->withErrors($error)->withInput($req->all());
    }

    public function deleteFeatures(Request $req)
    {
    	$rules = [
    		'id' => 'required|min:1|numeric',
    		'courseId' => 'required|min:1|numeric',
    		'status' => 'required|in:1,2',
    	];
    	$validate = validator()->make($req->all(),$rules);
    	if(!$validate->fails()){
    		$deleted_at = date('Y-m-d h:i:s');
    		if($req->status == 1){
    			$deleted_at = null;
    			Course::where('id',$req->courseId)->withTrashed()->update(['deleted_at'=>$deleted_at]);
    		}
    		CourseFeature::where('id',$req->id)->where('course_id',$req->courseId)->withTrashed()->update(['deleted_at'=>$deleted_at]);
    		return response()->json(['error'=>false,'message'=>'Feature Status Updated successfully']);
    	}
    	return response()->json(['error'=>true,'message'=>$validate->errors()->first()]);
    }

	public function updateStatus(Request $request){
        $params = $request->except('_token');
        $status = $this->CourseManagementRepository->updateStatus($params);

        if ($status) {
            return response()->json(array('message'=>'Course successfully updated'));
        }
    }

}
