@extends('inisiatif::mail.layouts.app')

@section('content')
    @component('inisiatif::mail.components.paragraph', ['align' => 'left'])
        Assalamu'alaikum {{ $employeeName }}
    @endcomponent

    @component('inisiatif::mail.components.paragraph', ['align' => 'left'])
        Laporan Rekapitulasi dengan template {{ $templateName }} untuk periode {{ $period }} sudah selesai di proses.
        Total laporan yang dibuat sebanyak {{ $donorCount }}, silahkan klik link di bawah untuk melihat detail laporan.
    @endcomponent

    @component('inisiatif::mail.components.button', ['url' => $url])
        Lihat Laporan
    @endcomponent
@endsection
