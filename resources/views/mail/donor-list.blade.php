@extends('inisiatif::mail.layouts.app')

@section('content')
<style>
  ul {
    font-size: medium;
  }

  li {
    margin-top: 0.5rem;
    margin-bottom: 0.5rem;
  }
</style>
<body>
  @component('inisiatif::mail.components.paragraph', ['align' => 'left'])
    Assalamu'alaikum, {{ $username }}
  @endcomponent

  @component('inisiatif::mail.components.paragraph', ['align' => 'left'])
    Kami informasikan bahwa rekapitulasi donasi dengan ID Batch: {{ $donationRecapId }} telah selesai diproses. Berikut detail laporan:
  @endcomponent

  @component('inisiatif::mail.components.paragraph', ['align' => 'left'])
    Template : {{ $templateName }}
  @endcomponent
  @component('inisiatif::mail.components.paragraph', ['align' => 'left'])
    Periode : {{ $startAt }} - {{ $endAt }}
  @endcomponent
  @component('inisiatif::mail.components.paragraph', ['align' => 'left'])
    Status : {{ $donationRecapState }}
  @endcomponent
  @component('inisiatif::mail.components.paragraph', ['align' => 'left'])
    Filter Pencarian :
    <ul>
      <li>
        ID Donatur : {{ $filter['donorIdentificationNumber'] ?? '-' }}
      </li>
      <li>
        Nama Donatur : {{ $filter['donorName'] ?? '-' }}
      </li>
      <li>
        Nomor Telepon : {{ $filter['donorPhone'] ?? '-' }}
      </li>
    </ul>
  @endcomponent

  @component('inisiatif::mail.components.button', ['url' => $url])
    Download Rekapitulasi
  @endcomponent
  
  @component('inisiatif::mail.components.paragraph', ['align' => 'left'])
    Terima kasih atas partisipasi dan dukungan Anda. Semoga laporan ini bermanfaat.
  @endcomponent
</body>
</html>
@endsection
