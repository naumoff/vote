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
                            <th>Animal</th>
                            <th>Score</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($myAnimals AS $animal)
                            <tr>
                                <td>
                                    <img src="{{asset($animal->photo)}}"
                                         class="img-rounded img-responsive"
                                         alt="picture" width="200" height="150">
                                </td>
                                <td>
                                    {{$animal->type}}: <b>{{$animal->name}}</b><br>
                                    @if($animal->kitten !== null)
                                        fur: {{$animal->kitten->fur}}<br>
                                    @elseif($animal->puppy !== null)
                                        type: {{$animal->puppy->type}}<br>
                                    @endif
                                    <hr>
                                    victories: <b>{{$animal->victories}}</b><br>
                                    failures: <b>{{$animal->failures}}</b><br>
                                    <b style="color:red">score: </b><b>{{$animal->score}}</b>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $myAnimals->links() }}
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
