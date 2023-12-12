<table class="min-w-full divide-y divide-gray-200">
    <thead>
    <tr>
        <th class="rounded-l-sm bg-izi-green px-4 py-2 text-left text-xs font-bold tracking-wider">
            TANGGAL
        </th>
        <th class="bg-izi-green px-4 py-2 text-left text-xs font-bold tracking-wider">
            TRANSAKSI
        </th>
        <th class="rounded-r-sm bg-izi-green px-4 py-2 text-right text-xs font-bold tracking-wider">
            JUMLAH
        </th>
    </tr>
    </thead>
    <tbody class="bg-white">
    @foreach($items as $item)
        <tr class="h-14">
            <td class="px-3 py-1 whitespace-nowrap border-b border-gray-200">
                {{ $item->getTransactionDate()->format('d M Y') }}
            </td>
            <td class="px-3 py-1 whitespace-normal border-b border-gray-200">
                <p>{{ $item->getAttribute('donation_funding_type_name') }}}</p>
                <p class="text-gray-600 text-sm">
                    {{ $item->getAttribute('donation_program_name') }}}
                </p>
            </td>
            <td class="px-3 py-1 whitespace-nowrap text-right border-b border-gray-200">
                Rp. {{ $item->getAttribute('donation_amount') }}}
            </td>
        </tr>
        @if (($loop->first && $loop->iteration === 9) || (!$loop->first && ($loop->iteration % 15 === 0)))
            <tr class="page-break">
                <td colspan="3" class="border-0"></td>
            </tr>
        @endif
    @endforeach
    </tbody>
</table>
