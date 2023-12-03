@extends('layouts.app')

@section('content')


<div class="row">

    <div class="col-lg-12 margin-tb">

        <div class="pull-left">

            <h2> Show User</h2>

        </div>


    </div>

</div>



<div class="row">

    <div class="col-xs-12 col-sm-12 col-md-12">

        <div class="form-group">

            <strong>Name:</strong>

            {{ $users->name }}

        </div>

    </div>

    <div class="col-xs-12 col-sm-12 col-md-12">

        <div class="form-group">

            <strong>email: </strong>

            {{ $users->email }}

        </div>

    </div>

    <div class="col-xs-12 col-sm-12 col-md-12">

        <div class="form-group">

            <strong>Role :</strong>

            <th scope="row" class="px-6 py-4 font-medium text-black whitespace-nowrap ">
                    @foreach ($users->roles as $role)
                    {{$role->name}}
                    @endforeach
                </th>

        </div>

    </div>


</div>


<a href="{{route('admin.users.index')}}" class="inline-flex items-center mt-10 px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
    Retour
</a>

</div>

@endsection