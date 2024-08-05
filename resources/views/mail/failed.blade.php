@extends('inisiatif::mail.layouts.app')

@section('content')
    @component('inisiatif::mail.components.paragraph', ['align' => 'left'])
        Assalamu'alaikum {{ $employeeName }}
    @endcomponent

    @component('inisiatif::mail.components.paragraph', ['align' => 'left'])
        Mohon maaf, Laporan Rekapitulasi dengan template {{ $templateName }} untuk periode {{ $period }} gagal di proses.
        silahkan hubungi tim IT untuk pengecekan lebih lanjut.
    @endcomponent
@endsection
