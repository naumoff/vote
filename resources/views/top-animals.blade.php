@extends ('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-md-offset-0">
                <div class="panel panel-default">
                    <div class="panel-heading">Dashboard</div>
                    <div class="panel-body">
                        <h3>Top animals:</h3>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Animal</th>
                                    <th>Score</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($topAnimals AS $animal)
                            <tr>
                                <td>
                                    <img src="{{asset($animal->photo)}}"
                                         class="img-rounded img-responsive"
                                         alt="picture" width="200" height="150">
                                </td>
                                <td>
                                    {{$animal->type}}: <b>{{$animal->name}}</b><br>
                                    owner: <b>{{$animal->user->name}}</b>
                                    <hr>
                                    victories: <b>{{$animal->victories}}</b><br>
                                    failures: <b>{{$animal->failures}}</b><br>
                                    <b style="color:red">score: </b><b>{{$animal->score}}</b>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $topAnimals->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function(){

        });
    </script>
@endsection