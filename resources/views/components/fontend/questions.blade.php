<div class="questions-container-{{ $question->id }}">
    @if($question->titlelocation !== 'default')
        <div 
            class="title"
            style="
                padding-top: {{ data_get($settings, 'description.top', 40) }}px;
                padding-bottom: {{ data_get($settings, 'description.down', 0) }}px;
                padding-left: {{ data_get($settings, 'description.left', 20) }}px;
                padding-right: {{ data_get($settings, 'description.right', 0) }}px;
                justify-content: {{ data_get($settings, 'description.align', 'left') }};
                align-items: baseline;
                display: flex;
            "
        >
            <div id="dynamic_chart{{$question->id}}">
                {!! $question->question !!}
            </div>
        </div>
    @endif

    @if(filled($question->questionimage))
        <div 
            class="image"
            
            style="
                padding-top: {{ data_get($settings, 'image.top', 30) }}px;
                padding-bottom: {{ data_get($settings, 'image.down', 0) }}px;
                padding-left: {{ data_get($settings, 'image.left', 10) }}px;
                padding-right: {{ data_get($settings, 'image.right', 0) }}px;
                justify-content: {{ data_get($question, 'image_aligment', 'left') }};
                align-items: baseline;
                display: flex;
            "
        >
            <img 
                src="{{asset('uploads/image/'.$question->questionimage[0])}}" 
                style="object-fit: {{ $question->imagefit }}"
                width="{{$question->imagewidth}}"
                height="{{$question->imageheight}}"
            />
        </div>
    @endif

    <div 
        class="answers"
        style="
            padding-top: {{ data_get($settings, 'answer.top', 20) }}px;
            padding-bottom: {{ data_get($settings, 'answer.down', 0) }}px;
            padding-left: {{ data_get($settings, 'answer.left', 20) }}px;
            padding-right: {{ data_get($settings, 'answer.right', 0) }}px;
            justify-content: {{ data_get($question, 'answer_aligment', 'left') }};
            align-items: baseline;
            display: flex;
        "
    >
        <div 
            class="w-100"
            style="
                @if(filled($question->min_width))
                    min-width: {{ $question->min_width }}px !important;
                @endif

                @if(filled($question->max_width))
                    max-width: {{ $question->max_width }}px !important;
                @endif

                @if(filled($question->width))
                    width: {{ $question->width }}px !important;
                @endif

                justify-content: {{ data_get($question, 'answer_aligment', 'left') }};
                align-items: baseline;
                display: flex;
            "
        >
            @include('frontend.components.questions.inputs')
        </div>
    </div>
</div>

@foreach (collect($question->questionimage)->except(0) as $image)
    <img 
        src="{{asset('uploads/image/'.$image)}}" 
        style="object-fit: {{ $question->imagefit }}"
        width="{{$question->imagewidth}}"
        height="{{$question->imageheight}}"
    />
@endforeach

<style>
    .questions-container-{{ $question->id }} {
        display: grid;
        grid-template-columns: {{ $template['column'] }};
        grid-template-rows: minmax(5px, auto);
        grid-template-areas: {!! $template['template'] !!};
    }

    .image {
        grid-area: image;
    }

    .title {
        grid-area: title;
    }

    .answers {
        grid-area: answer;
    }
</style>