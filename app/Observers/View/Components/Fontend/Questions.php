<?php

namespace App\View\Components\Fontend;

use App\Models\Question;
use Illuminate\View\Component;

class Questions extends Component
{
    public $template;
    public $question;
    
    public $content;

    public function __construct($question, $content)
    {
        $this->question = $question;
        $this->content = $content;
        $this->template = $this->question->gridTemplate;
    }

    public function render()
    {
        return view('components.fontend.questions', [
            'settings' => $this->question->layout_properties,
            'template' => $this->template,
            'question' => $this->question,
            'content' => $this->content,
        ]);
    }
}
