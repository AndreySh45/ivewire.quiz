<div class="container mt-sm-5 my-1 col-8">
    @if(session()->has('message'))
        <div class="alert alert-success" role="alert">
            {{ session('message') }}
        </div>
    @endif
    <form wire:submit.prevent="saveQuestion">
        <div class="mb-3">
            <label for="question" class="form-label">Вопрос</label>
            <input type="text" class="form-control @error('question') is-invalid @enderror" wire:model.lazy="question"
                wire:dirty.class="border border-danger border-2" name="question" id="question">
            @error('question')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
            @enderror
        </div>
        @foreach($options as $index => $option)
            <div class="mb-3" wire:key="option-field-{{ $index }}">
                <label for="option{{$index}}" class="form-label">Вариант ответа №{{$index + 1}}</label>
                <input type="text" class="form-control @error('options.'.$index) is-invalid @enderror" wire:model="options.{{ $index }}" id="option{{$index}}">
                @error('options.'.$index)
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                @enderror
            </div>
        @endforeach
        @error('options')
            <p class="text-start text-danger">{{$message}}</p>
        @enderror
        <div class="mb-3" {{ $index == 4 ? 'hidden': '' }}> {{-- Скрывает кнопку, если ответов уже 5 --}}
            <button class="btn btn-info hidden" type="button" wire:click="addEmptyOption">Добавить ответ</button>
        </div>
        <div class="mb-3">
            <label for="right_answer" class="form-label">Правильный вариант</label>
            <select class="form-select @error('right_answer') is-invalid @enderror" wire:model="right_answer">
                @foreach($options as $index => $option)
                    @if(!empty($option))
                        <option value="{{$index}}" wire:key="right-answer-{{ $index }}">{{ $option }}</option>
                    @endif
                @endforeach
            </select>
            @error('right_answer')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Добавить вопрос</button>
    </form>
</div>
