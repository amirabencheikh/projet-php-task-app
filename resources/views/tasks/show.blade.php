@extends('layouts.app')

@section('content')

<h1 class="text-3xl text-black-500 mb-3 mt-10">{{$tasks->name}}</h1>
<div>
    <p>
        {{$tasks->description}}
    </p>

    <div class="mt-3">
        <span class="text-gray-500">Publier par
            @if (Auth::user()->id == $tasks->user_created_by)
            vous
            @else
            {{$tasks->name}}
            @endif {{$tasks->created_at}}</span>
    </div>

    <a href="{{route('task.index')}}" class="inline-flex items-center mt-10 px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
        Retour
    </a>

</div>

@endsection