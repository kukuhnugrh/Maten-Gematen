@extends('admin/layout_admin')
@section('info-halaman', 'List Transaksi Berlangsung')

@section('content-CSS')
<style>
    .active-color {
        color: black !important;
        font-weight: bold;
    }

    .items-shadow {
        box-shadow: rgba(50, 50, 93, 0.25) 0px 2px 5px -1px, rgba(0, 0, 0, 0.3) 0px 1px 3px -1px;
    }
</style>
@endsection

@section('content')
<div id="main-content" class="d-flex flex-column">

    <div class="card">
        <div class="card-body">
            
        </div>
    </div>
</div>

@endsection

@section('content-JS')
<script>
    $("#update-status-button").click(function(e) {
        e.preventDefault();
        $("#status-update-form").submit();
    });
</script>
@endsection