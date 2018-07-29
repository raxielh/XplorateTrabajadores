<table class="table table-responsive" id="estados-table">
    <thead>
        <tr>
            <th>Descripcion</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($estados as $estados)
        <tr>
            <td>{!! $estados->nombre !!}</td>
            <td>
                {!! Form::open(['route' => ['estados.destroy', $estados->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('estados.show', [$estados->id]) !!}" class='btn btn-default btn-xl'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('estados.edit', [$estados->id]) !!}" class='btn btn-default btn-xl'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xl', 'onclick' => "return confirm('Estas seguro?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>