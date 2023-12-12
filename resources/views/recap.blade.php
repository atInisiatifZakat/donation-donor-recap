<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap"
        rel="stylesheet"
    />
    <title>Laporan Rekapitulasi ZIS</title>
    <script src="https://cdn.tailwindcss.com/3.3.5"></script>
    <style>
        body {
            background-color: #ffffff;
            font-family: "Inter", sans-serif;
        }

        .paper-a4 {
            margin-left: auto;
            margin-right: auto;
            width: 21cm;
            background: white;
            border: 1px solid rgb(161, 161, 161);
            overflow-x: auto;
        }

        .paper-a4.landscape {
            overflow-y: scroll;
            width: 29.7cm;
        }

        .color-izi-green {
            color: #85bd00;
        }

        .bg-izi-green {
            background-color: #85bd00;
        }

        .bg-izi-green-light {
            background-color: #84bd001b;
        }

        .page-break {
            page-break-after: always;
            display: none;
        }

        @media print {
            .paper-a4 {
                border: none;
                overflow-x: hidden;
                padding: 2px;
                box-shadow: none !important;
                border-radius: none !important;
            }

            @page {
                margin-top: 1cm; /* Adjust the value as needed for padding on the top */
            }

            .paper-a4.landscape {
                overflow-y: hidden;
            }

            div.paper-footer {
                position: fixed;
                bottom: 0;
            }

            .page-break {
                display: block;
            }

            .no-print {
                display: none !important;
            }
        }
    </style>
</head>
<body>
<div class="paper-a4">
    <div class="py-5">
        @include('recap::components.header')

        <h2 class="text-xl font-bold text-center color-izi-green tracking-wide mb-2">LAPORAN REKAPITULASI ZIS</h2>

        @include('recap::components.divider')

        @include('recap::components.donor-info')

        @include('recap::components.divider')

        @include('recap::components.transaction-summary')

        @include('recap::components.divider')

        @include('recap::components.transaction-table')
    </div>

    @include('recap::components.footer')
</div>
</body>
</html>
