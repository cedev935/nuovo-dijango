<?php

namespace App\Http\Controllers\Backend\Admin;


use App\Models\Question;
use App\Models\QuestionsOption;
use App\Models\Test;
use App\Models\Course;

use function foo\func;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreQuestionsRequest;
use App\Http\Requests\Admin\UpdateQuestionsRequest;
use App\Http\Controllers\Traits\FileUploadTrait;
use Yajra\DataTables\Facades\DataTables;
use DB;
use PhpParser\Node\Stmt\Break_;
use Validator;
use Illuminate\Support\Facades\Storage;

class QuestionsController extends Controller
{
    use FileUploadTrait;

    /**
     * Display a listing of Question.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        if (!Gate::allows('question_access')) {
            return abort(401);
        }
        
        $courses = Course::where('published', '=', 1)->pluck('title', 'id')->prepend('Please select', '');
        $tests = [];

        if (isset($request->course_id) && $request->course_id!='') {
            $tests = Test::where('published', '=', 1)->where('course_id', $request->course_id)->pluck('title', 'id')->prepend('Please select', '');
        } else {
            $tests = Test::where('published', '=', 1)->pluck('title', 'id')->prepend('Please select', '');
        }

        return view('backend.questions.index', compact('courses', 'tests'));
    }


    /**
     * Display a listing of Questions via ajax DataTable.
     *
     * @return \Illuminate\Http\Response
     */
    public function getData(Request $request)
    {
        $has_view = false;
        $has_delete = false;
        $has_edit = false;

        /*TODO:: Show All questions if Admin, Show related if  Teacher*/
        if ($request->test_id == "") {
            if (isset($request->course_id) && $request->course_id != "") {
                $test_ids = Test::where('published', '=', 1)->where('course_id', $request->course_id)
                ->pluck('id')->toArray();
                $questions = DB::table('questions')
                ->join('question_test','question_test.question_id','=','questions.id')
                ->select('questions.*', 'question_test.test_id','question_test.page_number')
                ->whereIn('question_test.test_id', $test_ids)
                ->orderBy('questionorder','asc')->get();
            } else {
                $questions = DB::table('questions')
                ->select('questions.*')
                ->orderBy('questionorder','asc')->get();
            }
        }
        else 
        {
            $questions = DB::table('questions')
                ->join('question_test','question_test.question_id','=','questions.id')
                ->select('questions.*', 'question_test.test_id','question_test.page_number')
                ->where('question_test.test_id',$request->test_id)
                ->orderBy('questionorder','asc')->get();
        }

        if (!auth()->user()->role('administrator')) {
            $questions->where('user_id', '=', auth()->user()->id);
        }

        if ($request->show_deleted == 1) {
            if (!Gate::allows('question_delete')) {
                return abort(401);
            }
            $questions->onlyTrashed()->get();
        }

        if (auth()->user()->can('question_view')) {
            $has_view = true;
        }
        if (auth()->user()->can('question_edit')) {
            $has_edit = true;
        }
        if (auth()->user()->can('question_delete')) {
            $has_delete = true;
        }
        $has_view = true;  
        $has_edit = true;
        $has_delete = true;

        return DataTables::of($questions)
            ->addIndexColumn()
            ->addColumn('actions', function ($q) use ($has_view, $has_edit, $has_delete, $request) {
                $view = "";
                $edit = "";
                $delete = "";
                if ($request->show_deleted == 1) {
                    return view('backend.datatable.action-trashed')->with(['route_label' => 'admin.questions', 'label' => 'id', 'value' => $q->id]);
                }
                if ($has_view) {
                    $view = view('backend.datatable.action-view')
                        ->with(['route' => route('admin.questions.show', ['question' => $q->id])])->render();
                }
                if ($has_edit) {
                    $edit = view('backend.datatable.action-edit')
                        ->with(['route' => route('admin.questions.edit', ['question' => $q->id])])
                        ->render();
                    $view .= $edit;
                }

                if ($has_delete) {
                    $delete = view('backend.datatable.action-delete')
                        ->with(['route' => route('admin.questions.destroy', ['question' => $q->id, 'test_id' => $request->test_id??''])])
                        ->render();
                    $view .= $delete;
                }
                return $view;
            })
            ->addColumn('conditionlogic', function ($q) {
                $len= count(json_decode($q->logic));
                return ($len >0) ? 'Existing':'';
            })
            ->addColumn('page_no', function ($q) use($request){
                if($request->test_id == '') return '';
                return '<input type="number" class="page_no" id="'.$q->id.'" value="'.$q->page_number.'" name="page_no[]">';
            })
            ->editColumn('questionimage', function ($q) {
                $images = json_decode($q->questionimage);

                if(filled($q->questionimage) && is_null($images)) {
                    $images = [$q->questionimage];
                }
                
                return !empty($images) ? '<img object-fit="fill" height="30px" width="40px" src="' . asset('uploads/image/' . $images[0]) . '">' : 'N/A';
            })
            ->rawColumns(['questionimage', 'actions','question','page_no'])
            ->make();
    }

    public function create()
    {
        if (!Gate::allows('question_create')) {
            return abort(401);
        }

        $courses = \App\Models\Course::ofTeacher()
            ->get();
            
        $courses_ids = request()->has('course_id') 
            ? [request()->get('course_id')]
            : $courses->pluck('id');

        $courses = $courses->pluck('title', 'id')
            ->prepend('Please select', '');

        $course_list = DB::table('tests')            
            ->join('courses', 'tests.course_id', '=', 'courses.id')
            ->select('course_id','courses.title')
            ->groupBy('course_id')
            ->get();

        $course_list= json_decode(json_encode($course_list),true);

        $n_course_list = count($course_list);//add ckd
        $course_test_list = [];//add :Luna

        for ($i=0;$i<$n_course_list;$i++)
        {
            $temp =DB::table('tests')
                ->select('id','title')
                ->where('course_id',$course_list[$i]['course_id'])->get();
            $course_test_list[$i] = json_decode(json_encode($temp),true);                
        }
      
        $tests =DB::table('tests')
            ->select('title','id', 'color1', 'color2')
            ->whereIn('course_id', $courses_ids)
            ->get();

        $last_q_id = DB::table('questions')->select('id')->orderBy('id','DESC')->first();
        $last_id = 1;

        if($last_q_id != null)
            $last_id = $last_q_id->id;

        $question_count = DB::table('questions')->count();
        $question_list = [];// add :Luna

        if ( $question_count==0)
        {
            $question_infos="";
            $question_list="";

            return view('backend.questions.create')
                ->with('tests', $tests)
                ->with('courses',$courses)
                ->with('course_list',$course_list)
                ->with('course_test_list',$course_test_list)
                ->with('last_q_id', $last_id);
        }
        else
        {
            $test_list =DB::table('question_test')
                ->select('test_id')
                ->groupBy('test_id')->get();

            $test_list= json_decode(json_encode($test_list),true);
            $tn = count($test_list);

            for ($i=0;$i < $tn;$i++)
            {
                $temp =DB::table('questions')
                    ->join('question_test','questions.id','=','question_test.question_id' )
                    ->select('id', 'question', 'questiontype', 'score')
                    ->where('question_test.test_id',$test_list[$i]['test_id'])->get();
                    
                $question_list[$test_list[$i]['test_id']] = json_decode(json_encode($temp),true);                
            }

            $question_infos = DB::table('questions')
                ->join('question_test','questions.id','=','question_test.question_id' )
                ->join('tests', 'tests.id', '=', 'question_test.test_id')
                ->select('questions.id','questions.logic','questions.content','question_test.test_id','questions.questiontype', 'tests.title')
                ->orderBy('question_test.test_id','asc')->get();

            return view('backend.questions.create')
                ->with('question_infos', $question_infos)
                ->with('courses',$courses)
                ->with('tests', $tests)
                ->with('course_list',$course_list)
                ->with('course_test_list',$course_test_list)
                ->with('test_list',$test_list)
                ->with('question_list',$question_list)
                ->with('last_q_id', $last_id);
        }
        
    }

    public function upload_images(Request $request)
    {
        
        $destinationPath = 'uploads/image/';
        $img_name = [];

        if($request->hasfile('file'))
        {
            foreach($request->file('file') as $file)
            {
                $name = time().rand(1,100).'.'.$file->extension();
                $file->move($destinationPath, $name);  
                array_push($img_name,$name);
            }
        }

        $output = array(
            'success'  => 'Images uploaded successfully',
            'img_name' =>$img_name
        );
        
        return response()->json($output);
    }
    public function test(Request $request)
    {
        # code...
        dd($request);
    }

    public function user_upload_images(Request $request)
    {
        
        $destinationPath = 'uploads/storage/';
        if($request->hasfile('file'))
        {
            $file = $request->file('file');
            $name = time().rand(1,100).'.'.$file->extension();
            $check = $file->move($destinationPath, $name);
            $img_name[] = $name; 
        }
        if(is_array($img_name)){
            if(count($img_name)==1){
                $img_name=$img_name[0];
            }
            else{
                $img_name = $img_name;
            }
        }
        $output = array(
            'success'  => 'Images uploaded successfully',
            'img_name' =>$img_name,
            'q_id' => $request->q_id
        );
        return response()->json($output);
    }

    public function store(Request  $request)
    {   

        // return $request;
            // $request->validate([
            //     'question_content' => 'required',
            //     'image_widht' => 'required',
            //     'image_height' => 'required',
            //     'size' => 'required'
            // ]);
            // dd('stop');
            $validator = Validator::make($request->all(), [
                'question' => 'required',
                'test_ids' => 'required',
                'type_id' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'success' => false,
                    'error' =>
                    $validator->errors()->toArray()
                ], 400);
            }

            // dd($request->matrix_data);
            if($request->matrix_data !== NULL){
                $content = $request->matrix_data;
                $content = str_replace('contenteditable="true"','contenteditable="false"',$content);
                $content = str_replace('id="delete_matrix_row"','id=""',$content);
                $content = str_replace('class="btn btn-danger"','class="hide_btn"',$content);
                $content = str_replace('<th class="custom-hide">Action</th>','<th class="custom-hide"></th>',$content);

            }else{
                $content = $request->content;//add ckd
                //$content = $request->getContent();
            }

            $order = DB::table('questions')->max('questionorder');
            if($order===null){
                $order=1;
            }
            else{
                $order+=1;
            }

            $tests = $request->test_ids;
            $user_id = auth()->user()->id;
            $data = $request->all();

            // $output = array(
            // 'success'  => 'gfjghfjdghjkghfkjhgjf'
            // );
            $last_id= DB::table('questions')->insertGetId([
                'question' => $request->question,
                'help_info' => $request->help_info ?? '',
                'hint_info' => $request->hint_info ?? '',
                'access_help_info' => $request->hint ?? '',
                'access_hint_info' => $request->hintaccess ?? '',
                'questionimage' => json_encode(data_get($data, 'questionimage', [])),
                'score' => $request->score ?? '',
                'userid' =>$user_id,
                'test_id' => json_encode($tests),
                'questiontype' => $request->type_id ?? '',
                //'questionpage' => $request->data['page'],
                'questionorder' => $order,
                'width' => $request->width ?? '',
                'indent' => $request->indent ?? '',
                'required' => $request->required ?? '',

                'state' => $request->state ?? '',
                'help_info_location' => $request->help_info_location ?? '',
               
                //'ttile_location' => $request->ttile_location ?? '',
                'max_width' => $request->max_width ?? '',
                'min_width' => $request->min_width ?? '',
                'size' => $request->size ?? '',
                'question_bg_color' => $request->question_bg_color,
                'more_than_one_answer' => $request->more_than_one_answer ?? '',
                'fontsize' => $request->fontsize ?? '',
                'titlelocation' => $request->titlelocation,
                'imagefit' => $request->imagefit ?? '',
                'imagewidth' => $request->imagewidth ?? '',
                'imageheight' => $request->imageheight ?? '',
                'answerposition' => $request->answerposition,
                'image_aligment' => $request->image_aligment,
                'answer_aligment' => $request->answer_aligment,

                'color1' => $request->color1,
                'color2' => $request->color2,

                'imageposition' => $request->imageposition,
                'content' =>$content ?? '',
                'logic' =>$request->logic ?? '',
                
                'layout_properties' => json_encode($request->layout_properties)
            ]);
            
            //** the add condition logic questions of other tests to specific test */
            //@start
            
            $logics = json_decode($request->logic);
            if(is_array($logics) || is_object($logics)){
                foreach($logics as $key => $logic){
                    $tests_question = DB::table('question_test')->where('question_id', $logic[1])->get();
                    $exists = false;
                    foreach($tests_question as $q){
                        if(!in_array($q->test_id, $tests)){
                            $exists = false;
                            break;
                        }
                    }
                    if($exists == false){
                        foreach($tests as $test){
                            DB::table('question_test')->where('question_id', $logic[1])->where('test_id', $test)->delete();
                            DB::table('question_test')->insert([
                                'question_id' => $logic[1],
                                'test_id' => $test
                            ]);
                        }
                    }
                }
            }

            //@end
            if($request->matrix_data != NULL){
                $content = str_replace('[q_id]', $last_id, $content);
                $content = str_replace('[type]', $request->type_id, $content);
            }
            if($last_id>0){
                DB::table('questions')->where('id',$last_id)->update([
                    'content'=> $content
                ]);
            }
            foreach($tests as $test)
            { 
                DB::table('question_test')->insert([
                    'test_id' => $test,
                    'question_id' => $last_id,    
        
                ]);
            }         

            $output = array(
            'success'  => 'data is saved successfully',
            'add' => 1
            );

         return response()->json($output); 
    }

    public function get_test_default(Request $request)
    {
        $test_id = $request->test_id;
        $data =DB::table('tests')
                ->select('text1','text2','color1','color2')
                ->where('id',$test_id)->get();
        return json_encode($data);   

    }
    public function update(Request $request)
    {  
        $tests = $request->test_ids; 
        $data = $request->all();

        $content = '';

        if(isset($data['matrix_data']) && $data['matrix_data'] != NULL){
            $content = $data['matrix_data'];
            $content = str_replace('contenteditable="true"','contenteditable="false"',$content);
            $content = str_replace('id="delete_matrix_row"','id=""',$content);
            $content = str_replace('class="btn btn-danger"','class="hide_btn"',$content);
            $content = str_replace('<th>Action</th>','<th></th>',$content);
        }else if(isset($data['content'])){
            $content = $data['content'];
        }

        $question = Question::findOrFail($data['question_id']);

        if($request->matrix_data != NULL){
            $content = str_replace('[q_id]', $question->id, $content);
            $content = str_replace('[type]', $request->type_id, $content);
        }

        $question->update([
            'question' => $data['question'],
            'help_info' => $data['help_info'],
            'hint_info' => $data['hint_info'] ?? '',
            'access_help_info' => $data['hint'] ?? '',
            'access_hint_info' => $data['hintaccess'] ?? '',
            'score' => $data['score'],    
            'test_id' => json_encode($tests),
            'questiontype' => $data['type_id'],
            //'questionpage' => $request->data['page'],
            'width' => $data['width'] ?? '',
            'indent' => $data['indent'] ?? '',
            'required' => $data['required'] ?? '',
            'questionimage' => data_get($data, 'questionimage', []),

            'state' => $data['state'] ?? '',
            'help_info_location' => $data['help_info_location'] ?? '',
            //'ttile_location' => $data['ttile_location'] ?? '',
            'max_width' => $data['max_width'] ?? '',
            'min_width' => $data['min_width'] ?? '',
            'size' => $data['size'] ?? '',
            'question_bg_color' => $request->question_bg_color,
            'more_than_one_answer' => $data['more_than_one_answer'] ?? '',
            'fontsize' => $data['fontsize'] ?? '',
            'titlelocation' => $data['titlelocation'] ?? '',
            'imagefit' => $data['imagefit'] ?? '',
            'imagewidth' => $data['imagewidth'] ?? '',
            'imageheight' => $data['imageheight'] ?? '',
            'answerposition' => $request->answerposition,
            'imageposition' => $request->imageposition,       
            'content' =>$content,
            'logic' =>$data['logic'],
            'image_aligment' => $request->image_aligment,
            'answer_aligment' => $request->answer_aligment,
            'layout_properties' => $request->layout_properties ?? [],

            'color1' => $request->color1,
            'color2' => $request->color2,
        ]);

        DB::table('question_test')->where('question_id',$data['question_id'])->delete();
        for ($i =0; $i<count($tests); $i++){           
            DB::table('question_test')
                ->where('question_id',$data['question_id'])
                ->insert([
                    'test_id' => $tests[$i],
                    'question_id' => $data['question_id']
            ]);
        }
        $logics = json_decode($data['logic']);
        if(is_array($logics) || is_object($logics)){
            foreach($logics as $key => $logic){
                $tests_question = DB::table('question_test')->where('question_id', $logic[1])->get();
                $exists = false;
                foreach($tests_question as $q){
                    if(!in_array($q->test_id, $tests)){
                        $exists = false;
                        break;
                    }
                }
                if($exists == false){
                    foreach($tests as $test){
                        DB::table('question_test')->where('question_id', $logic[1])->where('test_id', $test)->delete();
                        DB::table('question_test')->insert([
                            'question_id' => $logic[1],
                            'test_id' => $test
                        ]);
                    }
                }
            }
        }
        $output = array(
            'success'  => 'data is updated successfully'
            );
         echo json_encode($output); 
    }

    public function order_edit(Request  $request)
    {
             $data = json_decode($request->id_info);
             $test_id = $request->test_id;
             $min_order =min($data);
            //  return $test_id;
            for ($i = 0; $i<count($data); $i++){
                DB::table('questions')
                ->where('id', $data[$i])
                ->update(['questionorder' => $i+$min_order]);               
                if($test_id != ''){
                    DB::table('question_test')
                    ->where('question_id', $data[$i])
                    ->where('test_id', $test_id)
                    ->update(['question_order' => $i+$min_order]); 
                }

            }  

         $output = array(
             'success'  => 'The order is updated successfully'
             );

         echo json_encode($output); 
    }

    public function page_update(Request  $request)
    {
        $page_no = $request->page_no;
        $question_id = $request->question_id;
        $test_id = $request->test_id;
        DB::table('question_test')
        ->where('test_id', $test_id)
        ->where('question_id', $question_id)
        ->update(['page_number' => $page_no]);               

    $output = array(
        'success'  => 'The order is updated successfully'
        );

    echo json_encode($output); 
    }

    public function get_info(Request  $request)
    {
        $qtypes = ["Single Input", "Check Box", "RadioGroup", "Image", "Matrix", "Rating", "Dropdown", "File", "Stars", "Range", "€"];
        $qa= DB::table('questions')->where('id','=',$request->id)->first();  

        $is_condition_logic = count(json_decode($qa->logic))>0 ? ' - <strong>condition Logic</strong>' : '';
        $score_htm = '';
        if ($qa->content!=null) {
            $t = json_decode($qa->content);
            if (is_array($t)) {
                foreach ($t as $cont) {
                    if (isset($cont->score) && $cont->score!=null)
                    {
                        $score_htm.=json_encode($cont->score).', ';
                    }
                }
            }
        }
        if ($score_htm!='') $score_htm = ' <b>Score:'.$score_htm.'</b>';
        $in_html = '<span class="type-' . $qa->questiontype. '"><i class="fa fa-folder"></i></span>'. $qa->id .'. '. strip_tags($qa->question) .' - <span>['. $qtypes[$qa->questiontype] .']</span>'. $score_htm.$is_condition_logic;
        echo json_encode(array(
            'data' => $qa,
            'in_html' => $in_html
        ));      
    }

    /**
     * Show the form for editing Question.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!Gate::allows('question_edit')) {
            return abort(401);
        }

        $question = Question::findOrFail($id);

        $courses = \App\Models\Course::ofTeacher()
            ->get();
            
        $courses_ids = request()->has('course_id') 
            ? [request()->get('course_id', $question->course_id)]
            : $courses->pluck('id');

        $courses = $courses->pluck('title', 'id')
            ->prepend('Please select', '');
        
        $current_tests =DB::table('question_test')->join('tests', 'question_test.test_id', '=', 'tests.id')
                        ->select('test_id', 'tests.course_id', 'tests.color1', 'tests.color2')->where('question_id', $id)->get();
        
            
        $course_list =DB::table('tests')            
            ->join('courses', 'tests.course_id', '=', 'courses.id')
            ->select('course_id','courses.title')
            ->groupBy('course_id')->get();

        $course_list= json_decode(json_encode($course_list),true);

        for($i = 0; $i < count($course_list); $i++)
        {
            $temp =DB::table('tests')
                ->select('id','title')
                ->where('course_id',$course_list[$i]['course_id'])->get();
            $course_test_list[$i] = json_decode(json_encode($temp),true);                
        }        
    
        $tests =DB::table('tests')
            ->select('title','id', 'color1', 'color2')
            ->whereIn('course_id', $courses_ids)
            ->get();

        $test_list =DB::table('question_test')    
            ->select('test_id')
            ->groupBy('test_id')->get();

        $test_list= json_decode(json_encode($test_list),true);

        for ($i=0;$i <count($test_list);$i++)
        {
            $temp =DB::table('questions')
                ->join('question_test','questions.id','=','question_test.question_id' )
                ->select('id', 'question', 'questiontype', 'content', 'logic')
                ->where('question_test.test_id',$test_list[$i]['test_id'])->get();
                
            $question_list[$test_list[$i]['test_id']] = json_decode(json_encode($temp),true);                
        }
    
        $question_tests = DB::table('question_test')->select('test_id')->where('question_id',$question->id)->get();
    
        return view('backend.questions.edit')
            ->with('courses', $courses)
            ->with('current_question',$question)
            ->with('current_tests',$current_tests)
            ->with('tests', $tests)
            ->with('course_list',$course_list)
            ->with('course_test_list',$course_test_list)
            ->with('test_list',$test_list)
            ->with('question_list',$question_list)
            ->with('question', $question)
            ->with('question_tests',$question_tests);
    }
    public function ajax_add_condition(Request $request)
    {  
        $condition_id = json_decode($request->condition_id);

        $course_list =DB::table('tests')            
        ->join('courses', 'tests.course_id', '=', 'courses.id')
        ->select('course_id','courses.title')
        ->groupBy('course_id')->get();
        $course_list= json_decode(json_encode($course_list),true);

        $qtypes = ["Single Input", "Check Box", "RadioGroup", "Image", "Matrix", "Rating", "Dropdown", "File", "Stars", "Range", "€"];
        $question_list=[];
        for ($i=0; $i<count($course_list); $i++)
        {
            $temp =DB::table('tests')
                ->select('id','title')
                ->where('course_id',$course_list[$i]['course_id'])->get();
            $course_test_list[$i] = json_decode(json_encode($temp),true);                
        }        
    
        $tests = DB::table('tests')->select('title','id')->get();
        $question_count = DB::table('questions')->count();
        if ($question_count>0) {
            $test_list =DB::table('question_test')    
            ->select('test_id')
            ->groupBy('test_id')->get();
            $test_list= json_decode(json_encode($test_list),true);

            for ($i=0;$i <count($test_list);$i++)
            {
                $temp =DB::table('questions')
                    ->join('question_test','questions.id','=','question_test.question_id' )
                    ->select('id', 'question', 'questiontype', 'content', 'logic')
                    ->where('question_test.test_id',$test_list[$i]['test_id'])->get();
                    
                $question_list[$test_list[$i]['test_id']] = json_decode(json_encode($temp),true);                
            }
        }
        $html = '<div class="row mt-3 condition" id="condition_'.$condition_id.'">
        <div class="col-sm-3">
            <i style="font-size:24px" class="fa float-left fa-link pt-2 pr-2"></i>
            <select style="width:auto;" class="form-control float-left btn-primary first_operator" name="first_operator" placeholder="Options">
                <option value="0">And</option>
                <option value="1">Or</option>
            </select>
        </div>
        <div class="col-sm-7">                                            
        <div class="qt_name form-control"></div>
            <div class="logic_tree" style="display:none;">
                <ul class="treecontent">';
        $tk=0;
        for ($i=0; $i<count($course_list); $i++) {
            $html.='<li>'.$course_list[$i]['title'];
                $html.='<ul>';
                for ($j=0; $j<count($course_test_list[$i]); $j++) {
                    $html.='<li>'.$course_test_list[$i][$j]['title'];
                        $html.='<ul>';
                        $tk=  $course_test_list[$i][$j]['id'];
                        if (isset($question_list[$tk])) {
                            foreach ($question_list[$tk] as $question) {
                                $is_condition_logic = count(json_decode($question['logic']))>0 ? ' - <strong>condition Logic</strong>' : '';
                                $score_htm = '';
                                if ($question['content']!=null) {
                                    $t = json_decode($question['content']);
                                    if (is_array($t)) {
                                        foreach ($t as $cont) {
                                            if (isset($cont->score) && $cont->score!=null)
                                            {
                                                $score_htm.=json_encode($cont->score).', ';
                                            }
                                        }
                                    }
                                }
                                if ($score_htm!='') $score_htm = ' <b>Score:'.$score_htm.'</b>';
                                $html.='<li class="type-'.$question['questiontype'].'">'.$question['id'].'. '.strip_tags($question['question']).' <span>['.$qtypes[$question['questiontype']].']</span>'.$score_htm.$is_condition_logic.'</li>';
                            }
                        }
                        $html.='</ul>';
                    $html.='</li>';
                }
                $html.='</ul>';
            $html.='</li>' ;
        }
        $html .= '</ul>                   
            </div>
        </div>
        <input class="qt_type" type="hidden" value="" />
        <div class="col-sm-2">                                    
            <select class="form-control btn-warning operators" name="operators" placeholder="Options">';
        $operators=["equals","not equals","contains","not contains","greater","less","greater or equals","less or equals"];
            for($i=0; $i<count($operators); $i++) {
                $html .= '<option value="'.$i.'">'.$operators[$i].'</option>';
            }                                       
        $html .= '</select>
            </div>
            <div class="col-12 logic-content">
            </div>
            <a class="del-condition-btn" href="javascript:del_condition('.$condition_id.');"><i class="fa fa-close"></i></a>
            <a class="clone-condition-btn" href="javascript:clone_condition('.$condition_id.');"><i class="fa fa-clone"></i></a>
        </div>';
        echo $html;
    }

    public function show($id)
    {
        if (!Gate::allows('question_view')) {
            return abort(401);
        }
        $questions_options = \App\Models\QuestionsOption::where('question_id', $id)->get();
        $tests = \App\Models\Test::whereHas(
            'questions',
            function ($query) use ($id) {
                $query->where('id', $id);
            }
        )->get();

        $question = Question::findOrFail($id);
            // return $question; 
        return view('backend.questions.show', compact('question', 'questions_options', 'tests'));
    }


    /**
     * Remove Question from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!Gate::allows('question_delete')) {
            return abort(401);
        }
        $question = Question::findOrFail($id);
        if (request()->get('test_id')) {
            DB::table('question_test')->where('question_id', $id)->where('test_id', request()->get('test_id'))->delete();
            // DB::table('questions')->where('id', $id)->where('test_id', request()->get('test_id'))->delete();
            DB::table('user_answer')->where('question_id', $id)->where('test_id', request()->get('test_id'))->delete();
            $logics = json_decode($question->logic);
            if(count($logics) > 0){
                foreach($logics as $logic){
                    $conditions = DB::table('questions')->where('id', $logic[1])->first();
                    $conditions_tests = json_decode($conditions->test_id);
                    if(!in_array(request()->get('test_id'), $conditions_tests)){
                        DB::table('question_test')->where('question_id', $logic[1])->where('test_id', request()->get('test_id'))->delete();
                    }
                    DB::table('user_answer')->where('question_id', $logic[1])->where('test_id', request()->get('test_id'))->delete();
                }
            }
        } else {
            $ques = DB::table('questions')->where('id', $id)->first();
            $ques_tests = DB::table('question_test')->where('question_id', $id)->get();
            $ques_logics = json_decode($ques->logic);
            if(count($ques_logics) > 0) {
                foreach($ques_logics as $logic){
                    $cond_ques = DB::table('questions')->where('id', $logic[1])->first();
                    $cond_ques_tests = json_decode($cond_ques->test_id);
                    foreach ($ques_tests as $t) {
                        if(!in_array($t->test_id, $cond_ques_tests)){
                            DB::table('question_test')->where('question_id', $logic[1])->where('test_id', $t->test_id)->delete();
                        }
                        DB::table('user_answer')->where('question_id', $logic[1])->where('test_id', $t->test_id)->delete();
                    }
                }
            }
            DB::table('question_test')->where('question_id', $id)->delete();
            DB::table('questions')->where('id', $id)->delete();
            DB::table('user_answer')->where('question_id', $id)->delete();
        }

        // $question->delete();

        return redirect()->route('admin.questions.index')->withFlashSuccess(trans('alerts.backend.general.deleted'));
        // return '111111';
    }

    /**
     * 
     * Delete selected question from charts
     * @param id: question id
     */

     public function delQuestionFromCharts($id)
     {
        $charts = DB::table('charts')->get();

     }

    /**
     * 
     * Delete selected question from a chart content
     * @param id: question id, content: chart content
     * 
     */

     public function changeChartContent($id, $content)
     {
        $question_id = $id;
     }

    /**
     * Delete all selected Question at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (!Gate::allows('question_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Question::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }


    /**
     * Restore Question from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (!Gate::allows('question_delete')) {
            return abort(401);
        }
        $question = Question::onlyTrashed()->findOrFail($id);
        $question->restore();

        return redirect()->route('admin.questions.index')->withFlashSuccess(trans('alerts.backend.general.restored'));
    }

    /**
     * Permanently delete Question from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        if (!Gate::allows('question_delete')) {
            return abort(401);
        }
        $question = Question::onlyTrashed()->findOrFail($id);
        $question->forceDelete();

        // return redirect()->route('admin.questions.index')->withFlashSuccess(trans('alerts.backend.general.deleted'));
    }

    // public function editorFileUpload(Request $request){
    //     if(isset($_FILES['upload']['name'])){
    //         $file = $_FILES['upload']['tmp_name'];
    //         $file_name = $_FILES['upload']['name'];
    //         $file_name_array = explode(".", $file_name);
    //         $extension = end($file_name_array);
    //         $new_image_name = $file_name_array[0].rand().'.'.$extension;
    //         chmod('storage/photos/1/', 0777);
    //         $allowed_extention = array("jpg", "gif", "png");
    //         if(in_array($extension, $allowed_extention)){
    //             move_uploaded_file($file, 'storage/photos/1/'.$new_image_name);
    //             $function_number = $_GET['CKEditorFuncNum'];
    //             $url = $_SERVER['HTTP_ORIGIN'].'/storage/photos/1/'.$new_image_name;
    //             $message = '';
    //             echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($function_number, '$url', '$message');</script>";
    //         }
    //     }

    // }

    public function editorFileUpload(Request $request)
{
    if (isset($_FILES['upload']['name'])) {
        $file = $_FILES['upload']['tmp_name'];
        $file_name = $_FILES['upload']['name'];
        $file_name_array = explode(".", $file_name);
        $extension = end($file_name_array);
        $new_image_name = $file_name_array[0] . rand() . '.' . $extension;
        
        // Ensure that the target directory exists
        $directory = 'storage/photos/1/';
        if (!file_exists($directory)) {
            mkdir($directory, 0777, true);
        }

        // Set permissions for the target directory
        chmod($directory, 0777);

        $allowed_extention = array("jpg", "gif", "png");
        if (in_array($extension, $allowed_extention)) {
            move_uploaded_file($file, $directory . $new_image_name);
            $function_number = $_GET['CKEditorFuncNum'];
            // $url = $_SERVER['HTTP_ORIGIN'] . '/storage/photos/1/' . $new_image_name;
            $url = url(Storage::url('photos/1/' . $new_image_name));
            $message = '';
            echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($function_number, '$url', '$message');</script>";
        }
    }
}


}
