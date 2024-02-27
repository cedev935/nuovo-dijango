@if(!empty($content))
<style>
    .change-img-bg-color{
        background: rgba(20,6,62,1);
    }
</style>
<div class="d-flex p-0 image_content" style="flex-direction:column; gap: .5rem;">
    @if(isset($content) && data_get($content, '0.image'))
        @foreach($content[0]->image as $key=>$c)
            <div class="
                {{isset($content[(sizeof($content)-1)]->col)?$content[(sizeof($content)-1)]->col:''}} mt-2
                d-flex align-items-center
            " style="gap: 2rem;">
                <div class="form-group m-0">
                    <img
                        src="{{asset('uploads/image/')}}{{'/'.$c}}"
                        onclick="clickimg(this)"
                        class="img-thumbnail"
                        alt="image{{$key}}"
                        width="100px"
                        height="100px"
                        srcset=""
                    />

                    <input
                        type="radio"
                        style="display:none"
                        name="imgradiogroup"
                        data-key="{{$key+1}}"
                        id="{{$question->id}}"
                        class="form-check-input {{' imagebox_'.$key}}"
                        value="{{data_get($content, [0, 'score', $key])}}"
                        data-score="{{data_get($content, [0, 'score', $key])}}"
                    />
                </div>

                @if($description = data_get($content, [0, 'description', $key]))
                    <div>
                        {{ $description }}
                    </div>
                @endif
            </div>
        @endforeach
    @endif
</div>
@endif
@push('after-scripts')
    <script>
        function clickimg(ele){
            if($('#percent').val() == 1000  && $('#reported').val() == 10){
                alert('You can not edit your answers!');
            }else {
                $('.change-img-bg-color').each(function(){
                    $(this).removeClass('change-img-bg-color');
                });

                $(ele).addClass('change-img-bg-color');
                $(ele).next().prop("checked", true);
            }
        }
    </script>
@endpush