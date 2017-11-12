@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 col-md-offset-0">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if(count($myAnimals)>0)
                    <h3>My animals:</h3>
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Animal Name</th>
                            <th>Score</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($myAnimals AS $animal)
                        <tr>
                            <td>
                                <b>{{$animal['name']}}</b>-
                                {{$animal['type']}}
                                @if(count($animal['kitten'])>0)
                                    <br>fur is {{$animal['kitten']['fur']}}.
                                @elseif(count($animal['puppy'])>0)
                                    <br>type is {{$animal['puppy']['type']}}
                                @endif
                            </td>
                            <td>{{$animal['score']}}</td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                    @else
                            <p>{{\Illuminate\Support\Facades\Auth::user()->name}}, you still have no animals! You can add them here:</p>
                            <a href="animals/create">Add your animal here</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
