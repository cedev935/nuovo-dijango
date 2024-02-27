<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\File;

/**
 * Class Question
 *
 * @package App
 * @property text $question
 * @property string $question_image
 * @property integer $score
 */
class Question extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'questionimage' => 'array',
        'layout_properties' => 'array',
    ];

    /**
     * Perform any actions required after the model boots.
     *
     * @return void
     */
    protected static function booted()
    {
        // if (auth()->check()) {
        //     if (auth()->user()->hasRole('teacher')) {
        //         static::addGlobalScope('filter', function (Builder $builder) {
        //             $courses = auth()->user()->courses->pluck('id');
        //             $builder->whereHas('tests', function ($q) use ($courses) {
        //                 $q->whereIn('tests.course_id', $courses);
        //             });
        //         });
        //     }
        // }

        static::deleting(function ($question) { // before delete() method call this
            if ($question->isForceDeleting()) {
                if (File::exists(public_path('/storage/uploads/' . $question->question_image))) {
                    File::delete(public_path('/storage/uploads/' . $question->question_image));
                }
            }
        });

    }

    /**
     * Set attribute to money format
     * @param $input
     */
    public function setScoreAttribute($input)
    {
        $this->attributes['score'] = $input ? $input : null;
    }

    public function options()
    {
        return $this->hasMany('App\Models\QuestionsOption');
    }

    public function isAttempted($result_id){
        $result = TestsResultsAnswer::where('tests_result_id', '=', $result_id)
            ->where('question_id', '=', $this->id)
            ->first();
        if($result != null){
            return true;
        }
        return false;
    }

    public function tests()
    {
        return $this->belongsToMany(Test::class, 'question_test');
    }

    public function getGridTemplateAttribute()
    {
        $column = 'auto';
        $positions = [
            'top' => [0, 1],
            'center' => [1, 1],
            'bottom' => [2, 1],
            'left' => [0, 0],
            'right' => [0, 2],
        ];

        $template = [
            ['.', '.', '.'],
            ['.', '.', '.'],
            ['.', '.', '.'],
        ];

        /** TITLE */
        $titlePosition = data_get($positions, $this->titlelocation, null);

        if($titlePosition) {
            data_set($template, $titlePosition, 'title');
        }
        
        /** ANSWER */
        $answerPosition = data_get($positions, $this->answerposition, null);

        $answerPosition = filled($answerPosition) && $answerPosition == $titlePosition
            ? [$titlePosition[0] + 1, $titlePosition[1]]
            : $answerPosition;

        if($answerPosition) {
            data_set($template, $answerPosition, 'answer');
        }

        $template = array_values(array_filter(
            $template,
            fn(array $positions) => array_filter(
                $positions,
                fn(string $position) => $position !== '.'
            )
        ));

        /** IMAGE */
        if(filled($this->questionimage)) {
            $this->imageposition = $this->imageposition == 'default'
                ? 'left'
                : $this->imageposition;
                
            if(in_array($this->imageposition, ['left', 'right'])) {
                $positionIndex = $this->imageposition == 'left' ? 0 : 2;

                collect($template)->keys()->each(function (int $index) use (&$template, $positionIndex) {
                    data_set($template, [$index, $positionIndex], 'image');
                });

                $column = $this->imageposition == 'left' ? 'max-content auto' : 'auto max-content';
            } else {
                $imagePosition = data_get($positions, $this->imageposition, $positions['left']);

                while(data_get($positions, $imagePosition) === '.') {
                    $index = $imagePosition[0] > 0
                        ? [$imagePosition[0], $imagePosition[1] + 1]
                        : [$imagePosition[0] + 1, $imagePosition[1]];

                    $imagePosition = data_get($positions, $index, null);
                }

                if($imagePosition) {
                    data_set($template, $imagePosition, 'image');
                }
            }
        }

        $template = collect($template)
            ->map(function(array $positions) use ($template) {
                return collect($positions)->filter(
                    fn(string $position, int $index) => $position !== '.' || count(
                        array_filter($template, fn(array $_positions) => data_get($_positions, $index) !== '.')
                    ) > 0
                )->toArray();
            })
            ->map(
                fn($positions) => "'" . join(' ', $positions) . "'"
            )
            ->join("\n");

        return [
            'template' => $template,
            'column' => $column
        ];
    }
}
