<div class="text-sm py-4 grid grid-cols-1">
    <table>
        <tr class="flex">
            <td class="w-32 pl-2 py-1 items-start">ID Donatur</td>
            <td class="w-full py-1 whitespace-normal font-semibold">
                {{ $donor->getAttribute('donor_identification_number') }}
            </td>
        </tr>
        <tr class="flex">
            <td class="w-32 pl-2 py-1 items-start">Nama</td>
            <td class="w-full py-1 whitespace-normal font-semibold">
                {{ $donor->getAttribute('donor_name') }}
            </td>
        </tr>
        <tr class="flex">
            <td class="w-32 pl-2 py-1 items-start">Periode</td>
            <td class="w-full py-1 whitespace-normal font-semibold items-start">
                {{ \sprintf('%s - %s', $recap->getPeriodStartDate()->format('d M Y'), $recap->getPeriodEndDate()->format('d M Y')) }}
            </td>
        </tr>
        <tr class="flex">
            <td class="w-32 pl-2 py-1 items-start">NPWP</td>
            <td class="w-full py-1 whitespace-normal font-semibold">
                {{ $donor->getAttribute('donor_tax_number') ?? '-' }}
            </td>
        </tr>
    </table>
</div>
