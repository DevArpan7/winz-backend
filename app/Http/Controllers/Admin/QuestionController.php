<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\SubjectCategory;
use App\Models\Category;
use App\Models\Chapter;
use App\Models\Course;
use App\Models\SubChapter;
use DB;

class QuestionController extends BaseController
{
    public function index($subChapterId = 0)
    {
        $questions = Question::select('*');
        if($subChapterId>0){
            $questions  = $questions->where('subChapterId',$subChapterId);
        }else{
            $subChapterId = 0;
        }
       
        $questions = $questions->orderBy('id')->paginate(10);
        return view('admin.question.index', compact('questions','subChapterId'));
    }
    public function create($chapterId=0,$subChapterId=0)
    {
       // $sub_category = SubjectCategory::all();
        if($chapterId>0)
        {
            $chapterId = $chapterId;
        }else{
            $chapterId=0;
        }

        if($subChapterId>0)
        {
            $subChapterId = $subChapterId;
        }else{
            $subChapterId = 0;
        }

        $categories = Category::all();
        $courses = Course::orderBy('course_name', 'asc')->get();
        return view('admin.question.create',compact('categories','courses','chapterId','subChapterId'));
    }

    public function ChapterFetch($id){
        $Chapter = Chapter::orderBy('name', 'asc')
        ->select('id', 'name')
        ->where('courseId', $id)
        ->get();
        return response()->json(['name' => $Chapter]);
    }
    public function SubChapterFetch($id){
        $SubChapter = SubChapter::orderBy('name', 'asc')
        ->select('id', 'name')
        ->where('chapterId', $id)
        ->get();
        return response()->json(['name' => $SubChapter]);
    }
    public function store(Request $req)
    {
        $req->validate([
            //'question' => 'mimes:jpeg,jpg,png,gif,webp|required', // max 10000kb
            //'mark_scheme' => 'mimes:jpeg,jpg,png,gif,webp|required', // max 10000kb
    		// 'description' => 'required|max:500|string',
    		'difficulty' => 'required|numeric|min:1',
    		'category' => 'required|numeric|min:1',
    		'chapters' => 'required|numeric|min:1',
    		'subchapter' => 'required|numeric|min:1',
            //'answer1' => 'required|string',
            // 'answer2' => 'required|string',
            // 'answer3' => 'required|string',
            // 'answer4' => 'required|string',
    	]);
        $question = new Question();
        $upload_path_question = "upload/questions/";
        $upload_path_mark = "upload/questions/markScheme/";
        if($req->hasFile('question')){
            $image = $req->file('question');
            $imageName = time()."_".mt_rand().".".$image->getClientOriginalExtension();
            $image->move(public_path().'/'.$upload_path_question, $imageName);
            $uploadedImage = $imageName;
            $question->question = $upload_path_question.$uploadedImage;
        }
        if($req->hasFile('mark_scheme')){
            $image = $req->file('mark_scheme');
            $imageName_mark = time()."_".mt_rand().".".$image->getClientOriginalExtension();
            $image->move(public_path().'/'.$upload_path_mark, $imageName_mark);
            $uploadedImage_mark = $imageName_mark;
            $question->mark_scheme = $upload_path_mark.$uploadedImage_mark;
        }

        // $subChapterId = $req->subChapterId;
        // $categoryId = DB::table('sub_chapters')->where('id',$subChapterId)->first();
        // $chapterId =  $req->chapterId;
        // $categoryId =  $categoryId->categoryId;
        $chapterId = $req->chapters;
       $subChapterId = $req->subchapter;

        $question->question_title = $req->question_title;
        $question->categoryId = $req->category;
        $question->courseId = $req->courses;
        $question->chapterId = $chapterId;
        $question->subChapterId = $subChapterId;
        $question->description = $req->description;
        $question->difficulty = $req->difficulty;
        $question->answer1 = $req->answer1;
        $question->answer2 = $req->answer2;
        $question->answer3 = $req->answer3;
        $question->answer4 = $req->answer4;
        $question->save();
        
        return redirect()->route('admin.question.index');
       // return $this->responseRedirect('admin.questions.index', 'Question Added successfully' ,'success',false, false);
    }
    public function edit($id)
    {
        $categories = Category::all();
        $question = Question::find($id);
        $courses = Course::orderBy('course_name', 'asc')->get();
        return view('admin.question.edit', compact('question', 'categories', 'courses'));
    }
    
    public function update(Request $req)
    {
        
        $req->validate([
            // 'question_id' => 'required|numeric|min:1',
            // 'chapterId' => 'required|numeric|min:1',
            // 'subChapterId' => 'required|numeric|min:1',
            'category' => 'required|numeric|min:1',
    		'chapters' => 'required|numeric|min:1',
    		'subchapter' => 'required|numeric|min:1',
            // 'description' => 'required|max:500|string',
            'difficulty' => 'required|numeric|min:1',
            'answer1' => 'required|string',
            // 'answer2' => 'required|string',
            // 'answer3' => 'required|string',
            // 'answer4' => 'required|string',
        ]);
        $question = Question::find($req->question_id);
        
        $upload_path_question = "upload/questions/";
        $upload_path_mark = "upload/questions/markScheme/";
        if($req->hasFile('question')){
            $image = $req->file('question');
            $imageName = time()."_".mt_rand().".".$image->getClientOriginalExtension();
            $image->move(public_path().'/'.$upload_path_question, $imageName);
            $uploadedImage = $imageName;
            $question->question = $upload_path_question.$uploadedImage;
        }
        if($req->hasFile('mark_scheme')){
            $image = $req->file('mark_scheme');
            $imageName_mark = time()."_".mt_rand().".".$image->getClientOriginalExtension();
            $image->move(public_path().'/'.$upload_path_mark, $imageName_mark);
            $uploadedImage_mark = $imageName_mark;
            $question->mark_scheme = $upload_path_mark.$uploadedImage_mark;
        }
        $question->question_title = $req->question_title;
        $subChapterId = $req->subchapter;
        $chapterId =  $req->chapters;
        $question->courseId = $req->courses;
        $question->chapterId = $req->chapters;
        $question->subChapterId = $req->subchapter;
        $question->categoryId = $req->category;
        $question->description = $req->description;
        $question->difficulty = $req->difficulty;
        $question->answer1 = $req->answer1;
        $question->answer2 = $req->answer2;
        $question->answer3 = $req->answer3;
        $question->answer4 = $req->answer4;
        $question->save();
        return redirect()->route('admin.question.index');

        //return $this->responseRedirect('admin.question.index', 'Question Updated successfully' ,'success',false, false);
    }

    public function delete($id)
    {
        $response = Question::find($id)->delete();
        if (!$response) {
            return $this->responseRedirectBack('Error occurred while deleting.', 'error', true, true);
        }
        return $this->responseRedirect('admin.question.index', 'Question deleted successfully' ,'success',false, false);
    }
}
