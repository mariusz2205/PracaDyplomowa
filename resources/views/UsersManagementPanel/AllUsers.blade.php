@extends('layouts.app')

@section('content')

<div class="container col-md-8 col-md-offset-2">
    <form action="{{ route('setRolesFilterSessionVariable') }}" method="POST">
        {!! csrf_field() !!}

        <div class="form-group">
            <label for="search" > Wyszukaj</label>
            <input type="text" class="form-control" name = "search">
        </div>

        @if(count($roles)>0)
            @foreach($roles as $role)
                @if(Session::has('rolesFilters') && in_array($role->role_name, Session::get('rolesFilters')))

                    <input type="checkbox" checked name="rolesFilters[]" value="{{ $role->role_name }}"> {{ $role->role_name }}<br>

                @elseif(!Session::has('rolesFilters'))
                    <input type="checkbox" checked name="rolesFilters[]" value="{{ $role->role_name }}"> {{ $role->role_name }}<br>
                @else
                    <input type="checkbox" name="rolesFilters[]" value="{{ $role->role_name }}"> {{ $role->role_name }}<br>
                @endif

            @endforeach
        @endif
        <input type="submit" class="btn btn-default" value="Wyszukaj"><br>
        <br>
    </form>
</div>


{{--http://bootsnipp.com/snippets/featured/table-with-users--}}

<div class="well col-md-8 col-md-offset-2">
    <table class="table">
        <thead>
        <tr>
            <th>#</th>
            <th>Imie</th>
            <th>Nazwisko</th>
            <th>Email</th>
            <th>Role w systemie</th>
            <th style="width: 36px;"></th>
        </tr>
        </thead>
        <tbody>

    @foreach($users as $key=>$user)
        <tr>
            <td>{{ $key+1 +24*($currentPage-1)}}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->surname }}</td>
            <td>{{ $user->email }}</td>
            <td id="user{{ $user->id }}">
                @foreach($user->roles as $role)
                   {{ $role->role_name }}
                @endforeach
            </td>

            <td>
                <a href="{{ route('DeleteUser',$user->id) }}" ><i class="glyphicon glyphicon-trash"></i></a>
            </td>

            <td data-userId=" {{ $user->id }}">
                <a href="" data-userId=" {{ $user->id }}"><i class="glyphicon glyphicon-edit edit" data-userId=" {{ $user->id }} "></i></a>
            </td>

        </tr>

    @endforeach

        </tbody>
    </table>
</div>

<div class="container text-center" style="clear: both;">

    <nav>
        <ul class="pagination">
            @if( $currentPage != 1)
                <li>
                    <a href="{{ route('ShowUsers',$currentPage - 1) }}" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
            @endif

            @for($i = 0 ; $i < $totalNumOfPages ; $i++)

                @if($i + 1 == $currentPage)
                    <li class="active" ><a href="{{ route('assortment',$i+1) }}" >{{ $i + 1 }}</a></li>
                @else
                    <li><a href="{{ route('ShowUsers',$i+1) }}">{{ $i + 1 }}</a></li>
                @endif

            @endfor

            @if($totalNumOfPages != $currentPage)
                <li>
                    <a href="{{ route('ShowUsers',$currentPage + 1) }}" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            @endif

        </ul>
    </nav>
</div>

<div class="modal fade" id="edit-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Edytuj Role użytkownika</h4>
            </div>
            <div class="modal-body" id="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Zamknij</button>
                <button type="button" class="btn btn-primary" id="modal-save">Zapisz zmiany</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<script>
    var token = '{{Session::token()}}';
    var urlJsonUserDetail = '{{ url('/JsonUserDetail') }}';
    var urlJsonAllRoles = '{{ url('/JsonAllRoles') }}';
    var urlEditUserRole = '{{ route('EditUserRole') }}';

</script>
@endsection
