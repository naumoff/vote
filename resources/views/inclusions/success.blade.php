<div class="container">
    <div class="row">
        <div class="col-*-10">
            @if($flash = session('message'))
                <div class="alert alert-success">
                    {{$flash}}
                </div>
            @endif
        </div>
    </div>
</div>