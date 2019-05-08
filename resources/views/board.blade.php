@php($box = 0)
@php($letter = range('a', 'i'))
@for ($i = 0; $i < 3; $i++)
    <div class="row text-center">
        @for ($j = 0; $j < 3; $j++)
            @php($index = $letter[$box])
            @if(isset($board[$index]))
                <div id="box{{$box}}" class="col-md-2 col-xs-4 square">
                    <span>{{ $board[$index] }}</span>
                    <input type="hidden" name="box[{{ $index }}]" value="{{ $board[$index] }}">
                </div>
            @else
                <div id="box{{$box}}" class="col-md-2 col-xs-4 square" onclick="actionBoxClick({{ $box }})">
                    <span></span>
                    <input type="hidden" name="box[{{ $index }}]" value="">
                </div>
            @endif
            @php($box++)
        @endfor
    </div>
@endfor