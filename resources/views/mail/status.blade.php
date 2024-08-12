@extends('inisiatif::mail.layouts.app')

@section('content')
    @component('inisiatif::mail.components.paragraph', ['align' => 'left'])
        Assalamu'alaikum {{ $userName }}
    @endcomponent

    @component('inisiatif::mail.components.paragraph', ['align' => 'left'])
        Laporan Rekapitulasi dengan template {{ $templateName }} untuk periode {{ $period }} sudah selesai di proses.
        Total laporan yang dibuat sebanyak {{ $donorCount['all'] }}, dengan rincian status sebagai berikut : {{$donorCount['combined']}} combined, {{$donorCount['combining']}} combining, {{$donorCount['generated']}} generated, {{$donorCount['generating']}} generating, {{$donorCount['collected']}} collected, {{$donorCount['collecting']}} collecting, dan {{$donorCount['new']}} new.
    @endcomponent

    @component('inisiatif::mail.components.button', ['url' => $url])
        Lihat Laporan
    @endcomponent
@endsection
