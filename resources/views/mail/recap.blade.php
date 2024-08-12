@extends('inisiatif::mail.layouts.app')

@section('content')
    @component('inisiatif::mail.components.paragraph', ['align' => 'left'])
        <b>Assalamu'alaikum, Bapak/Ibu {{ $donorName }}</b>
    @endcomponent

    @component('inisiatif::mail.components.paragraph', ['align' => 'left'])
        Teriring salam, semoga Allah SWT senantiasa melimpahkan rahmat dan ridha serta kebahagiaan bagi <b>Bapak/Ibu
            {{ $donorName }}.</b> Kami mengucapkan terima kasih telah mempercayakan penyaluran ZISWAF melalui Inisiatif Zakat
        Indonesia.
    @endcomponent

    @component('inisiatif::mail.components.paragraph', ['align' => 'left'])
        Semoga ALLAH SWT memberikan pahala atas apa yang telah <b>Bapak/Ibu {{ $donorName }}</b> tunaikan, semoga ALLAH SWT
        memberikan keberkahan atas harta yang tertinggal dan semoga ZISWAF ini menjadi pembersih bagi jiwa dan harta. Semoga
        dengan keutamaan ZISWAF ini menjadi asbab Allah mudahkan hajat dan urusan, dilimpahkan kesehatan, ketenangan dan Allah
        ganti dengan yang lebih baik lagi. Aamiin.
    @endcomponent

    @component('inisiatif::mail.components.paragraph', ['align' => 'left'])
        <b>Berikut ini kami kirimkan Laporan Rekapitulasi Transaksi ZISWAF Bapak/Ibu {{ $donorName }} periode
            {{ $period }}</b>
    @endcomponent

    @component('inisiatif::mail.components.paragraph', ['align' => 'left'])
        Demikian terima kasih, jika menghadapi kendala, silakan langsung menghubungi Inisiatif Zakat Indonesia di telp <a
            href="tel:+62 21 1500047">(021)
            1500047</a> atau email <a href="mailto:salam@izi.or.id">salam@izi.or.id</a>.
    @endcomponent
@endsection
