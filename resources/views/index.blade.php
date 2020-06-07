@extends('main')
@section('content')
    <form method="get" action="{{ route('getListCollect') }}">
{{--        {{ csrf_field() }}--}}
        <div class="col-md-12">
            <label>Link truyện: </label>
            <input type="text" name="link" id="link" style="width: 50%;">
        </div>
        <div class="col-md-12" style="margin-top: 15px">
            <button type="submit" id="findLink" class="btn btn-success">Tìm kiếm</button>
        </div>
    </form>
@endsection
