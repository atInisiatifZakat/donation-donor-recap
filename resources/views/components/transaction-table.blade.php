<table class="min-w-full divide-y divide-gray-200 mt-4">
    <thead>
        <tr>
            <th class="rounded-l-sm bg-izi-green px-4 py-2 text-left text-xs font-bold tracking-wider">
                TANGGAL
            </th>
            <th class="bg-izi-green px-4 py-2 text-left text-xs font-bold tracking-wider text-center">
                TRANSAKSI
            </th>
            <th class="rounded-r-sm bg-izi-green px-4 py-2 text-right text-xs font-bold tracking-wider">
                JUMLAH
            </th>
        </tr>
    </thead>
    <tbody class="bg-white">
        @if ($items->isEmpty())
            <tr>
                <td colspan="3" class="px-3 py-12 whitespace-nowrap border-b border-gray-200">
                    <p class="text-center font-semibold text-lg text-gray-400">TIDAK ADA DATA</p>
                </td>
            </tr>
        @endif

        @if ($items->isNotEmpty())
            @foreach ($items->splice(0, 7) as $item)
                <tr class="h-14">
                    <td class="px-3 py-1 whitespace-nowrap {{ $loop->last ? '' : 'border-b' }} border-gray-200">
                        {{ $item->getTransactionDate()->format('d M Y') }}
                    </td>
                    <td class="px-3 py-1 whitespace-normal {{ $loop->last ? '' : 'border-b' }} border-gray-200">
                        <p>{{ $item->getAttribute('donation_funding_type_name') }}
                            @if ($item->getAttribute('donation_type') === 'GOOD')
                                ({{ $item->getAttribute('donation_good_name') }}
                                {{ $item->getAttribute('donation_good_quantity') }}
                                {{ $item->getAttribute('donation_good_unit') }})
                            @endif


                        </p>
                        <p class="text-gray-600 text-sm">
                            {{ $item->getAttribute('donation_program_name') }}
                        </p>
                    </td>
                    <td
                        class="px-3 py-1 whitespace-nowrap text-right {{ $loop->last ? '' : 'border-b' }} border-gray-200">
                        <li class="list-none">
                            Rp. {{ \number_format($item->getTotalAmount()) }}
                        </li>
                        <li class="list-none text-gray-500 italic text-sm">
                            ({{ $item->getAttribute('currency') }} {{ \number_format($item->getAttribute('donation_amount'), 0, ',', '.') }})
                        </li>
                    </td>
                </tr>
            @endforeach
        @endif

        @if ($items->isNotEmpty())
            <tr class="page-break">
                <td colspan="3" class="border-0"></td>
            </tr>
        @endif

        @if ($items->isNotEmpty())
            @foreach ($items as $item)
                <tr class="h-14">
                    <td class="px-3 py-1 whitespace-nowrap border-b border-gray-200">
                        {{ $item->getTransactionDate()->format('d M Y') }}
                    </td>
                    <td class="px-3 py-1 whitespace-normal border-b border-gray-200">
                        <p>{{ $item->getAttribute('donation_funding_type_name') }}</p>
                        <p class="text-gray-600 text-sm">
                            {{ $item->getAttribute('donation_program_name') }}
                        </p>
                    </td>
                    <td class="px-3 py-1 whitespace-nowrap text-right border-b border-gray-200">
                        <li class="list-none">
                            Rp. {{ \number_format($item->getTotalAmount()) }}
                        </li>
                        <li class="list-none text-gray-500 italic text-sm">
                            ({{ $item->getAttribute('currency') }} {{ \number_format($item->getAttribute('donation_amount'), 0, ',', '.') }})
                        </li>
                    </td>
                </tr>
                @if ($loop->iteration % 15 === 0 && !$loop->last)
                    <tr class="page-break">
                        <td colspan="3" class="border-0"></td>
                    </tr>
                @endif
            @endforeach
        @endif
    </tbody>
</table>
