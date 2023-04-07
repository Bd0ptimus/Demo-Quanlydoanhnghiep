<link href="{{ asset('css/select2/select2.min.css?v=') . time() }}" rel="stylesheet" />
<script type="text/javascript" src="{{ asset('js/select2/select2.min.js') }}"></script>

<select id="select2FormSingle" class="select2FormSingle form-control @error('{{$select2Name}}') is-invalid @enderror" name="{{$select2Name}}" >
    @foreach($select2Datas as $select2Data)
        <option value="{{$select2Data['value']}}" @if($select2Choice == $select2Data['value']) selected @endif>
        {{ $select2Data['data'] }}</option>
    @endforeach
</select>

<script>
    $(document).ready(() => {
            $('.select2FormSingle').select2();
    })
</script>
