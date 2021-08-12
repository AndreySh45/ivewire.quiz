<div class="container container-quiz mt-sm-5 my-1">
    <div class="question ml-sm-5 pl-sm-5 pt-2">
        <form>
            <div class="py-2 h5"><b>{{$question}}</b></div>
            <div class="ml-md-3 ml-sm-3 pl-md-5 pt-sm-0 pt-3" id="options">
                @foreach($options as $key => $option)
                <label class="options">{{$option}}
                    <input type="radio" name="radio" wire:model="answer" value="{{$key}}"> <span class="checkmark"></span>
                </label>
            @endforeach
            </div>
            @if(is_null($answer) === false)
                <p>Ваш ответ : {{$options[$answer]}}</p>
            @endif
            <div class="d-flex align-items-center pt-3 justify-content-evenly">
                <div class="ml-auto mr-sm-5">
                    <button class="btn btn-success" {{ is_null($answer) ? 'disabled': '' }}>Следующий</button>
                </div>
            </div>
        </form>
    </div>
</div>
