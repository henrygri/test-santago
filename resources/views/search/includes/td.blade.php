@foreach($columns as $column)
<td>{{ $column }}</td>
@endforeach
<td>
    <a class="btn btn-info btn-sm mr-1" href="{{$url}}">
        <i class="fas fa-pencil-alt"></i>
        {{ __('Apri') }}
    </a>
</td>