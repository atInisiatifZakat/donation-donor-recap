<div class="text-sm py-4 grid grid-cols-2">
    <table>
        <tr class="font-semibold">
            <td class="py-2 bg-izi-green-light pl-2 w-28">Total</td>
            <td class="py-2 bg-izi-green-light">Rp. {{ $summaries->getFormattedTotalAmountSummary() }}</td>
        </tr>
        <tr>
            <td class="py-2 min-w-full w-28 pl-2">Total Zakat</td>
            <td class="py-2 whitespace-normal font-semibold">
                Rp. {{ $summaries->getFormattedZakatTotalAmount() }}
            </td>
        </tr>
        <tr>
            <td class="py-2 min-w-full w-28 pl-2">Total Infaq</td>
            <td class="py-2 whitespace-normal font-semibold">
                Rp. {{ $summaries->getFormattedInfaqTotalAmount() }}
            </td>
        </tr>
    </table>
    <table>
        <tr class="font-semibold">
            <td class="py-2 bg-izi-green-light w-28">Jumlah</td>
            <td class="py-2 bg-izi-green-light">
                {{ $items->count() }}
            </td>
        </tr>
        <tr>
            <td class="py-2 min-w-full w-28">Total Qurban</td>
            <td class="py-2 whitespace-normal  font-semibold">
                Rp. {{ $summaries->getFormattedQurbanTotalAmount() }}
            </td>
        </tr>
        <tr>
            <td class="py-2 min-w-full w-25">Total Wakaf</td>
            <td class="py-2 whitespace-normal font-semibold">
                Rp. {{ $summaries->getFormattedWakafTotalAmount() }}
            </td>
        </tr>
    </table>
</div>
