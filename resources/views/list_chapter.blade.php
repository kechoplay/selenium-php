@extends('main')

@section('content')
    <h3>{{ $comicName }}</h3>
    <button type="button" class="btn btn-primary" id="downloadAll">Tải đầy đủ</button>
    <div class="table-responsive">
        <input type="hidden" name="comic" id="comic" value="{{ $comic->id }}">
        <table class="table table-hover">
            <thead>
            <tr>
                <th>Tên chapter</th>
                <th>Link gốc</th>
                <th>Tải</th>
            </tr>
            </thead>
            <tbody>
            @foreach($listChapters as $listChapter)
                <tr>
                    <td><span>{{ $listChapter['chapter_name'] }}</span></td>
                    <td><a href="{{ $listChapter['chapter_link'] }}"
                           target="_blank">{{ $listChapter['chapter_link'] }}</a></td>
                    <td>
                        <button class="btn btn-primary">Tải</button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
@push('js')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#downloadAll').on('click', function () {
            var linkDownload = [];
            var chapterName = [];
            $('table a').each(function () {
                linkDownload.push($(this).attr('href'));
            });
            $('table span').each(function () {
                chapterName.push($(this).text());
            })
            console.log(chapterName)

            $.ajax({
                type: 'post',
                url: '/download/comic/download-chap',
                dataType: 'json',
                data: {
                    linkDownload: linkDownload,
                    chapterName: chapterName,
                    type: 'all',
                    comic_id: $('#comic').val()
                },
                success: function (data) {
                    location.reload();
                }
            })
        })
    </script>
@endpush
