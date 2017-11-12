<div class="form-group">
    <label for="select-animal-sub-type">
        @if($fieldName === 'puppySubtype')
            Select puppy purpose type (required):
        @elseif($fieldName === 'kittenSubtype')
            Select kitten fur type (required):
        @endif
    </label>
    <select class="form-control" name="subtype" id="select-animal-sub-type">
        @foreach($list AS $item)
            @if($item == $subtype)
                <option value="{{$item}}" selected>{{$item}}</option>
            @else
                <option value="{{$item}}">{{$item}}</option>
            @endif
        @endforeach
    </select>
</div>