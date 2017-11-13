@extends ('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-md-offset-0">
                <div class="panel panel-default">
                    <div class="panel-heading">Dashboard</div>
                    <div class="panel-body">
                        PLAY MODE
                        <h3 class="text-center">{{$match['type_0']}} : {{$match['name_0']}}</h3>
                        <div class="container">
                            <img src="{{asset($match['photo_0'])}}"
                                 class="img-circle img-responsive"
                                 style="margin-left: auto; margin-right: auto"
                                 alt="picture" width="200" height="150">
                        </div>
                        <h4>Score:{{$match['score_0']}}</h4>
                        <form action="/matches" method="post">
                            {{csrf_field()}}
                            <input type="text" name="id_0" value="{{$match['id_0']}}" hidden>
                            <input type="text" name="hit_0" value="+1" hidden>
                            <input type="text" name="id_1" value="{{$match['id_1']}}" hidden>
                            <input type="text" name="hit_1" value="-1" hidden>
                            <button type="submit" class="btn btn-default btn-block">
                                Vote for {{$match['name_0']}}
                            </button>
                        </form>
                        <h3 class="text-center">{{$match['type_1']}} : {{$match['name_1']}}</h3>
                        <div class="container">
                            <img src="{{asset($match['photo_1'])}}"
                                 class="img-circle img-responsive"
                                 style="margin-left: auto; margin-right: auto"
                                 alt="picture" width="200" height="150">
                        </div>
                        <h4>Score:{{$match['score_1']}}</h4>
                        <form action="/matches" method="post">
                            {{csrf_field()}}
                            <input type="text" name="id_0" value="{{$match['id_0']}}" hidden>
                            <input type="text" name="hit_0" value="-1" hidden>
                            <input type="text" name="id_1" value="{{$match['id_1']}}" hidden>
                            <input type="text" name="hit_1" value="1" hidden>
                            <button type="submit" class="btn btn-default btn-block">
                                Vote for {{$match['name_1']}}
                            </button>
                        </form>
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