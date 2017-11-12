@extends ('layouts.app')

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
                            @include('inclusions.errors')
                            @include('inclusions.success')
                            <form method="post" action="/animals" id="my-animal" enctype="multipart/form-data" >
                                {{csrf_field()}}
                                <div class="form-group">
                                    <label for="animal-name">Animal Name:</label>
                                    <input type="text"
                                           class="form-control"
                                           id="animal-name"
                                           placeholder="Name of animal"
                                           name="animal-name"
                                           value="{{session('animal-name')}}">
                                </div>
                                <div class="radio">
                                    <label>
                                        <input type="radio"
                                               name="type"
                                               value="puppy"
                                               id="puppy-choice"
                                        > Puppy
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input type="radio"
                                               name="type"
                                               value="kitten"
                                               id="kitten-choice"
                                        >Kitten
                                    </label>
                                </div>
                                <div id="form-part-loader"></div>
                                <span class="btn btn-default btn-file">
                                    Photo Download <input type="file" name="photo">
                                </span>
                                <button type="submit" class="btn btn-default" id="submit">Submit</button>
                            </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function(){
            $("#submit").hide("fast");
            $('#my-animal :radio').change(function() {
                if (this.checked) {
                    $("#submit").hide("slow");
                    var type = $('input[name=type]:checked', '#my-animal').val();
                    if(type === 'puppy' || type === 'kitten'){
                        $("#form-part-loader").load('/animals/form-part-loader/'+type+'/'+null);
                        $("#submit").delay(2500).show("fast");
                    }
                }
            });

            var type = "<?= session('type') ?>";
            var subtype = "<?= session('subtype') ?>";

            if(type === 'puppy'){
                $("#puppy-choice").prop("checked", true);
                $("#form-part-loader").load('/animals/form-part-loader/'+type+'/'+subtype);
                $("#submit").delay(2500).show("fast");
            }

            if(type === 'kitten'){
                $("#kitten-choice").prop("checked", true);
                $("#form-part-loader").load('/animals/form-part-loader/'+type+'/'+subtype);
                $("#submit").delay(2500).show("fast");
            }
        });
    </script>
@endsection

