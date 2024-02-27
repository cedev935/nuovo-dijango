<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Models\Textgroup;
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

class TextGroupsController extends Controller
{
    use FileUploadTrait;

    /**
     * Display a listing of Question.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // if (!Gate::allows('textgroup_access')) {
        //     return abort(401);
        // }        
      
        $courses = Course::where('published', '=', 1)->pluck('title', 'id')->prepend('Please select', '');
        $tests = [];
        if (isset($request->course_id) && $request->course_id!='') {
            $tests = Test::where('published', '=', 1)->where('course_id', $request->course_id)->pluck('title', 'id')->prepend('Please select', '');
        } else {
            $tests = Test::where('published', '=', 1)->pluck('title', 'id')->prepend('Please select', '');
        }

        return view('backend.textgroups.index', compact('courses', 'tests'));
   
    }

    public function getDataForEditor(Request $request)
    {       
        $textgroups = [];
        if (isset($request->test_id) && $request->test_id != "")
        {
            $textgroups = DB::table('textgroups')
                ->join('textgroup_test','textgroup_test.text_id','=','textgroups.id')
                ->select('textgroups.*', 'textgroup_test.test_id')
                ->where('textgroup_test.test_id',$request->test_id)
                ->orderBy('text_order','asc')->get();
        }   
        else 
        {
            if (isset($request->course_id) && $request->course_id != "") {
                $textgroups = DB::table('textgroups')
                    ->join('textgroup_test','textgroup_test.text_id','=','textgroups.id')
                    ->join('tests','tests.id','=','textgroup_test.test_id')
                    ->select('textgroups.*', 'textgroup_test.test_id')
                    ->where('tests.course_id', $request->course_id)
                    ->where('tests.published', '=', 1)
                    ->orderBy('text_order','asc')->get();
            } else {
                $textgroups = DB::table('textgroups')
                    ->join('textgroup_test','textgroup_test.text_id','=','textgroups.id')
                    ->select('textgroups.*', 'textgroup_test.test_id')
                    ->orderBy('text_order','asc')->get();
            }
        }
        return DataTables::of($textgroups)
            ->addIndexColumn()
            ->addColumn('actions', function ($q) use ($request) {
                return '<a href="javascript:insert_short_code(\''.$q->short_code.'\');" class="btn btn-xs btn-info mb-1"><i class="fa fa-file-code-o"></i> Insert Into Editor</a>';
            })
            ->rawColumns(['actions','content'])
            ->make();   
          
    }

    public function getData(Request $request)
    {       
        $has_view = false;
        $has_delete = false;
        $has_edit = false;
        /*TODO:: Show All questions if Admin, Show related if  Teacher*/
        $textgroups = [];
        if (isset($request->test_id) && $request->test_id != "")
        {
            $textgroups = DB::table('textgroups')
                ->join('textgroup_test','textgroup_test.text_id','=','textgroups.id')
                ->select('textgroups.*', 'textgroup_test.test_id')
                ->where('textgroup_test.test_id',$request->test_id)
                ->groupBy('id')
                ->orderBy('text_order','asc')->get();
        }   
        else 
        {
            if (isset($request->course_id) && $request->course_id != "") {
                $textgroups = DB::table('textgroups')
                    ->join('textgroup_test','textgroup_test.text_id','=','textgroups.id')
                    ->join('tests','tests.id','=','textgroup_test.test_id')
                    ->select('textgroups.*', 'textgroup_test.test_id')
                    ->where('tests.course_id', $request->course_id)
                    ->where('tests.published', '=', 1)
                    ->groupBy('id')
                    ->orderBy('text_order','asc')->get();
                    
            } else {
                $textgroups = DB::table('textgroups')
                    ->join('textgroup_test','textgroup_test.text_id','=','textgroups.id')
                    ->select('textgroups.*', 'textgroup_test.test_id')
                    ->groupBy('id')
                    ->orderBy('text_order','asc')->get();
            }
        }
        $has_view = true;  
        $has_edit = true;
        $has_delete = true;
        return DataTables::of($textgroups)
            ->addIndexColumn()
            ->addColumn('actions', function ($q) use ($has_view, $has_edit, $has_delete, $request) {
                $view = "";
                $edit = "";
                $delete = "";
                // if ($request->show_deleted == 1) {
                //     return view('backend.datatable.action-trashed')->with(['route_label' => 'admin.textgroups', 'label' => 'id', 'value' => $q->id]);
                // }
                // if ($has_view) {
                //     $view = view('backend.datatable.action-view')
                //         ->with(['route' => route('admin.textgroups.show', ['textgroup' => $q->id])])->render();
                // }
                if ($has_edit) {
                    $edit = view('backend.datatable.action-edit')
                        ->with(['route' => route('admin.textgroups.edit', ['textgroup' => $q->id])])
                        ->render();
                    $view .= $edit;
                }

                if ($has_delete) {
                    $delete = view('backend.datatable.action-delete')
                        ->with(['route' => route('admin.textgroups.destroy', ['textgroup' => $q->id])])
                        ->render();
                    $view .= $delete;
                }
                return $view;
            })
            ->rawColumns(['actions','content'])
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

        $course_list =DB::table('tests')            
            ->join('courses', 'tests.course_id', '=', 'courses.id')
            ->select('course_id','courses.title')
            ->groupBy('course_id')->get();

        $course_list= json_decode(json_encode($course_list),true);

        for ($i=0;$i <count($course_list);$i++)
        {
            $temp =DB::table('tests')
                ->select('id','title')
                ->where('course_id',$course_list[$i]['course_id'])->get();
            $course_test_list[$i] = json_decode(json_encode($temp),true);                
        }        
      
        $tests = DB::table('tests')
            ->where('published', '=', 1)
            ->whereIn('course_id', $courses_ids)
            ->select('title','id')
            ->get();

        $question_count = DB::table('questions')->count();
        if ( $question_count==0)
        {
            $question_infos=[];
            $question_list=[];

            return view('backend.textgroups.create')
                ->with('tests', $tests)
                ->with('courses', $courses)
                ->with('course_list',$course_list)
                ->with('course_test_list',$course_test_list);
        }
        else
        {

            $test_list =DB::table('question_test')    
            ->select('test_id')
            ->groupBy('test_id')->get();
            $test_list= json_decode(json_encode($test_list),true);

            for ($i=0;$i <count($test_list);$i++)
            {
                $temp =DB::table('questions')
                    ->join('question_test','questions.id','=','question_test.question_id' )
                    ->select('id', 'question', 'questiontype', 'score')
                    ->where('question_test.test_id',$test_list[$i]['test_id'])->get();
                    
                $question_list[$test_list[$i]['test_id']] = json_decode(json_encode($temp),true);                
            }
       
            return view('backend.textgroups.create')
                ->with('tests', $tests)
                ->with('courses', $courses)
                ->with('course_list',$course_list)
                ->with('course_test_list',$course_test_list)
                ->with('test_list',$test_list)
                ->with('question_list',$question_list);
        }
        
    }
   
    public function edit($id)
    {

        $courses = \App\Models\Course::ofTeacher()
            ->get();
            
        $courses_ids = request()->has('course_id') 
            ? [request()->get('course_id', $id)]
            : $courses->pluck('id');

        $courses = $courses->pluck('title', 'id')
            ->prepend('Please select', '');

        $tests = DB::table('tests')
            ->whereIn('course_id', $courses_ids)
            ->where('published', '=', 1)
            ->select('title','id')
            ->get();

        $test_ids =DB::table('textgroup_test')->select('test_id')->where('text_id', $id)->pluck('test_id')->toArray();

        $course_list =DB::table('tests')            
            ->join('courses', 'tests.course_id', '=', 'courses.id')
            ->select('course_id','courses.title')
            ->groupBy('course_id')->get();

        $course_list= json_decode(json_encode($course_list),true);

        for ($i=0;$i <count($course_list);$i++)
        {
            $temp =DB::table('tests')
                ->select('id','title')
                ->where('course_id',$course_list[$i]['course_id'])->get();
            $course_test_list[$i] = json_decode(json_encode($temp),true);                
        }        

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

        $question_infos = DB::table('questions')
        ->select('questions.id','questions.questiontype','questions.question','questions.logic','questions.content', 'questions.score')
        ->orderBy('questions.id','asc')->get();    
        
        $current_textgroup= DB::table('textgroups')
            ->select('*')
            ->where('id', $id)
            ->get()->toArray();

        $current_textgroup =json_decode(json_encode($current_textgroup[0]));
     
        return view('backend.textgroups.edit')
            ->with('question_infos', $question_infos)
            ->with('tests', $tests)
            ->with('courses', $courses)
            ->with('test_ids', $test_ids)
            ->with('current_textgroup', $current_textgroup)
            ->with('course_list',$course_list)
            ->with('course_test_list',$course_test_list)
            ->with('test_list',$test_list)
            ->with('question_list',$question_list);
    }

    public function get_info(Request  $request)
    {
        $qtypes = ["Single Input", "Check Box", "RadioGroup", "Image", "Matrix", "Rating", "Dropdown", "File", "Stars", "Range", "€"];
        $qa= DB::table('questions')->where('id','=',$request->id)->first();  

        if(!$qa) {
            return response()->json([
                'data' => '',
                'in_html' => ''
            ]);
        }

        $is_condition_logic = count(json_decode(data_get($qa, 'logic')) ?? [])>0 ? ' - <strong>condition Logic</strong>' : '';
        $score_htm = '';

        if (data_get($qa, 'content') !=null) {
            $t = json_decode(data_get($qa, 'content'));
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
        $in_html = '<span class="type-' . data_get($qa, 'questiontype', '') . '"><i class="fa fa-folder"></i></span>'. data_get($qa, 'id', '')  .'. ' .' - <span>['. ']</span>'. $score_htm.$is_condition_logic;
        echo json_encode(array(
            'data' => $qa,
            'in_html' => $in_html
        ));   
    }

    public function store(Request  $request)
    {
        $id = DB::table('textgroups')->max('id') + 1;
        $shortcode = '[text id=' . $id . ']';
        $text_order = DB::table('textgroups')->max('text_order') + 1;
        $tests = json_decode($request->data['test_ids']);
        $user_id = auth()->user()->id;
        
        $logics = json_decode($request->data['logic']);
        if(is_array($logics) || is_object($logics)){
            foreach($logics as $logic){
                if(is_array($logic) || is_object($logic)){
                    foreach($logic as $key => $value){
                        $tests_question = DB::table('question_test')->where('question_id', $value[1])->get();
                        $exists = false;
                        foreach($tests_question as $q){
                            if(!in_array($q->test_id, $tests)){
                                $exists = false;
                                break;
                            }
                        }
                        if($exists == false){
                            foreach($tests as $test){
                                DB::table('question_test')->where('question_id', $value[1])->where('test_id', $test)->delete();
                                DB::table('question_test')->insert([
                                    'question_id' => $value[1],
                                    'test_id' => $test
                                ]);
                            }
                        }
                    }
                }
            }
        }
        $last_id = DB::table('textgroups')->insertGetId([
            'title' => $request->data['title'],
            'score' => $request->data['score'],
            'user_id' => $user_id,
            'test_id' => $request->data['test_ids'],
            'text_order' => $text_order,
            'content' => $request->data['content'],
            'logic' => $request->data['logic'],
            'short_code' => $shortcode

        ]);
        // $short_code='[ipt_fsqm_form id="'+ (string)$last_id +'"]';
        // var_dump($short_code);
        // DB::table('textgroups')
        // ->where('id', $last_id)
        // ->update([
        //     'short_code' => $short_code
        // ]);

        for ($i = 0; $i < count($tests); $i++) {
            DB::table('textgroup_test')->insert([
                'test_id' => $tests[$i],
                'text_id' => $last_id
            ]);
        }
        $output = array(
            'success' => 'data is saved successfully'
        );

        echo json_encode($output);
    }

    public function update(Request $request)
    {  
        if (isset($request->data['text_id']) && $request->data['text_id']!='') {
            $tests = json_decode($request->data['test_ids']);
            $user_id = auth()->user()->id;  
            DB::table('textgroups')->where('id',$request->data['text_id'])
            ->update([
                'title' => $request->data['title'],
                'score' => $request->data['score'],
                'test_id' => $request->data['test_ids'],
                'user_id' =>$user_id,
                'content' =>$request->data['content'],
                'logic' =>$request->data['logic']
            ]);
        
            for ($i=0; $i<count($tests); $i++)
            {   
                DB::table('textgroup_test')
                    ->where('text_id',$request->data['text_id'])
                    ->updateOrInsert([
                        'test_id' => $tests[$i],
                        'text_id' => $request->data['text_id']
                ]);
            }

            $logics = json_decode($request->data['logic']);
            if(is_array($logics) || is_object($logics)){
                foreach($logics as $logic){
                    if(is_array($logic) || is_object($logic)){
                        foreach($logic as $key => $value){
                            $tests_question = DB::table('question_test')->where('question_id', $value[1])->get();
                            $exists = false;
                            foreach($tests_question as $q){
                                if(!in_array($q->test_id, $tests)){
                                    $exists = false;
                                    break;
                                }
                            }
                            if($exists == false){
                                foreach($tests as $test){
                                    DB::table('question_test')->where('question_id', $value[1])->where('test_id', $test)->delete();
                                    DB::table('question_test')->insert([
                                        'question_id' => $value[1],
                                        'test_id' => $test
                                    ]);
                                }
                            }
                        }
                    }
                }
            }
            $output = array(
                'success'  => 'data is updated successfully'
                );

            echo json_encode($output); 
        }
        else {
            //insert new record
            $this->store($request);
        }
    }

    public function destroy($id)
    {
        // if (!Gate::allows('textgroup_delete')) {
        //     return abort(401);
        // }
        $textgroup = DB::table("textgroups")->where("id",$id)->get();
    
            DB::table('textgroup_test')->where('text_id', $id)->delete();
            DB::table('textgroups')->where('id', $id)->delete();
        // $textgroup->delete();

        return redirect()->route('admin.textgroups.index')->withFlashSuccess(trans('alerts.backend.general.deleted'));
    }
    
    public function ajax_add_text(Request $request)
    {  
        $text_id = json_decode($request->text_id);
        echo '<div class="row text m-2 p-2 pb-3" id="text_'.$text_id.'">
                <div class="col-12 form-group content-box">
                    <div class="form-group form-md-line-input">                   
                        <label class="control-label pl-2">Text *</label> 
                        <textarea class="form-control text_msg" rows="2" placeholder="Please input the Text..."></textarea>   
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-2">Score *</label>  
                        <div class="col-md-10">  
                            <input class="form-control text_score" type="number" value="" />  
                        </div>
                    </div>      
                </div> 
                <div class="col-12 form-group condition-box"></div>        
                <div class="col-12">    
                    <a class="btn btn-primary condition_add mt-2" href="javascript:add_condition('.$text_id.');"><i class="fa fa-plus"></i> Add Conditon</a>
                </div>     

                <a class="del-text-btn" href="javascript:del_text('.$text_id.');"><i class="fa fa-close"></i></a>
                <a 
                    class="clone-condition-btn" 
                    style="right: 20px; left: auto;"
                    href="javascript:clone_all_condition('.$text_id.');"
                >
                    <i class="fa fa-clone"></i>
                </a>

                <span class="text-label">'.($text_id+1).'</span>                   
            </div>';
    }

    public function ajax_add_tree_questions(Request $request)
    {  
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
        $html = '<ul class="treecontent">';
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
        $html .= '</ul>';
        echo $html;
    }

    public function ajax_add_condition(Request $request)
    {  
        $test_ids = json_decode($request->test_ids);
        $text_id = json_decode($request->text_id);
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
        $html = '<div class="row mt-3 condition" id="condition_'.$text_id.'_'.$condition_id.'">
        <div class="col-sm-2">
            <i style="font-size:24px" class="fa float-left fa-link pt-2 pr-2"></i>
            <select style="width:auto;" class="form-control float-left btn-primary first_operator" name="first_operator" placeholder="Options">
                <option value="0">And</option>
                <option value="1">Or</option>
            </select>
        </div>
        <div class="col-sm-8">                                            
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
            <a class="del-condition-btn" href="javascript:del_condition('.$text_id.', '.$condition_id.');"><i class="fa fa-close"></i></a>
            <a class="clone-condition-btn" href="javascript:clone_condition('.$text_id.', '.$condition_id.');"><i class="fa fa-clone"></i></a>
        </div>';
        echo $html;
    }
   
}
