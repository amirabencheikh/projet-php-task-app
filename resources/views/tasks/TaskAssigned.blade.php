@extends('layouts.app')

@section('content')
<h1 class="text-3xl text-black-500 mb-3 mt-10">Mes taches</h1>
@foreach ($tasks as $item)
<a href="{{route('task.show', ['task'=>$item->id])}}">
    <div class="px-2 py-5 shadow-sm hover:shadow-md rounded border mb-4 border-gray-200">
        <h1 class="text-xl font-bold text-black-800">{{$item->name}}</h1>
        <p class="text-md text-gray-800">{{$item->description}}</p>
        <p class="mt-2">Date debut : {{$item->start_date}}</p>
        <p class="mt-2">Date d'échéance : {{$item->due_date}}</p>
        <span class="py-2 px-2 {{$item->statusColor()}} inline-block mt-2 rounded-md text-white">{{$item->status}}</span>
        <div class="flex-column">
            @if ($item->status=='en cours')
            <form action="{{route('task.maskAsTermined', ['task'=>$item->id])}}" method="post">
                @csrf
                <button class="bg-green-500 px-2 py-1 rounded-md text-white mt-3 font-bold" type="submit">Marquer comme terminer</button>
            </form>
            @endif
            @if ($item->isActive())
            <form action="{{route('task.startTask', ['task'=>$item->id])}}" method="post">
                @csrf
                <button class="bg-green-500 px-2 py-1 rounded-md text-white mt-3 font-bold" type="submit">Commencer la tache</button>
            </form>
            @endif
        </div>

    </div>
</a>
@endforeach
<br>
<a href="{{route('home')}}" class="font-medium bg-blue-500 px-4 py-2 text-white rounded-md hover:none">Back</a>
@endsection