<div class="text-sm py-4 grid grid-cols-2">
    <table>
        <tr class="font-semibold">
            <td class="py-2 bg-izi-green-light pl-2 w-28">Total</td>
            <td class="py-2 bg-izi-green-light">
                <li class="list-none">
                    Rp. {{ $summaries->getFormattedTotalAmountSummary() }}
                </li>
                <li class="list-none text-gray-500 italic text-sm">
                    ({{ $summaries->getCurrency() }} {{ $summaries->getFormattedAmountSummary() }})
                </li>
            </td>
        </tr>
        <tr>
            <td class="py-2 min-w-full w-28 pl-2">Total Zakat</td>
            <td class="py-2 whitespace-normal font-semibold">
                <li class="list-none">
                    Rp. {{ $summaries->getFormattedZakatTotalAmount() }}
                </li>
                <li class="list-none text-gray-500 italic text-sm">
                    ({{ $summaries->getCurrency() }} {{ $summaries->getFormattedZakatAmount() }})
                </li>
            </td>
        </tr>
        <tr>
            <td class="py-2 min-w-full w-28 pl-2">Total Infaq</td>
            <td class="py-2 whitespace-normal font-semibold">
                <li class="list-none">
                    Rp. {{ $summaries->getFormattedInfaqTotalAmount() }}
                </li>
                <li class="list-none text-gray-500 italic text-sm">
                    ({{ $summaries->getCurrency() }} {{ $summaries->getFormattedInfaqAmount() }})
                </li>
            </td>
        </tr>
    </table>
    <table>
        <tr class="font-semibold">
            <td class="py-2 bg-izi-green-light w-28">Jumlah</td>
            <td class="py-[18px] bg-izi-green-light">
                {{ $items->count() }}
            </td>
        </tr>
        <tr>
            <td class="py-2 min-w-full w-28">Total Qurban</td>
            <td class="py-2 whitespace-normal  font-semibold">
                <li class="list-none">
                    Rp. {{ $summaries->getFormattedQurbanTotalAmount() }}
                </li>
                <li class="list-none text-gray-500 italic text-sm">
                    ({{ $summaries->getCurrency() }} {{ $summaries->getFormattedQurbanAmount() }})
                </li>
            </td>
        </tr>
        <tr>
            <td class="py-2 min-w-full w-25">Total Wakaf</td>
            <td class="py-2 whitespace-normal font-semibold">
                <li class="list-none">
                    Rp. {{ $summaries->getFormattedWakafTotalAmount() }}
                </li>
                <li class="list-none text-gray-500 italic text-sm">
                    ({{ $summaries->getCurrency() }} {{ $summaries->getFormattedWakafAmount() }})
                </li>
            </td>
        </tr>
    </table>
</div>
