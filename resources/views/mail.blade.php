@extends('inisiatif::mail.layouts.app')

@section('content')
    @component('inisiatif::mail.components.title')
        Laporan Rekapitulasi Transaksi ZISWAF
    @endcomponent

    @component('inisiatif::mail.components.paragraph', ['align' => 'left'])
        Assalamu'alaikum Warahmatullahi Wabarakatuh
    @endcomponent

    @component('inisiatif::mail.components.paragraph', ['align' => 'left'])
        Dear Bapak/Ibu {{ $donorName }}
    @endcomponent

    @component('inisiatif::mail.components.paragraph', ['align' => 'left'])
        Berikut ini kami kirimkan Laporan Rekapitulasi Transaksi ZISWAF Bapak/Ibu {{ $donorName }} periode {{ $period }}
    @endcomponent

    @component('inisiatif::mail.components.paragraph', ['align' => 'left'])
        Terimakasih
    @endcomponent

    @component('inisiatif::mail.components.paragraph', ['align' => 'left'])
        Wassalamu'alaikum Warahmatullahi Wabarakatuh
    @endcomponent
@endsection
