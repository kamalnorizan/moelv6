@extends('layouts.app')
@section('head')

<style>
    .calfonts{
        font-size: 8pt;
    }


</style>
@endsection
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Title</div>
                <div class="card-body">
                    @foreach ($monthsOfYear as $key=>$month)
                        <button class="btn btn-primary monthOfYear" data-month="{{$key+1}}">{{$month}}</button>
                    @endforeach
                    <div id="kehadiranTable" class="loading">
                        {!!$table!!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="loading\loadingoverlay.js"></script>
<script>


    $('.monthOfYear').click(function (e) {
        $('#kehadiranTable').LoadingOverlay("show");
        e.preventDefault();
        $month = $(this).attr('data-month');
        $.ajax({
            type: "get",
            url: "/takwim/"+$month+"/"+{{date('Y')}},
            dataType: "json",
            success: function (response) {
                console.log(response);
                $('#kehadiranTable').empty();
                $('#kehadiranTable').html(response.table);
                $('#kehadiranTable').LoadingOverlay("hide");

            }
        });
    });
</script>
@endsection

