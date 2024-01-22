<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
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

        .confidential {
            width: 110px;
            margin-left: auto;
            margin-right: auto;
            margin-bottom: 5px;
        }

        @media print {
            @page {
                margin-top: .5cm;
            }

            .paper-a4 {
                border: none;
                overflow-x: hidden;
                margin-top: .5cm;
                margin-left: .5cm;
                margin-right: .5cm;
                box-shadow: none !important;
                border-radius: none !important;
            }

            .paper-a4.landscape {
                overflow-y: hidden;
            }

            div.paper-footer {
                width: 100%;
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
    @include('recap::components.header')

    <h2 class="text-xl font-bold text-center color-izi-green tracking-wide mb-2">
        LAPORAN REKAPITULASI ZISWAF
    </h2>
    <img alt="Confidential" src="https://asset.inisiatif.id/confidential.jpeg" class="confidential" />

    @include('recap::components.divider')

    @include('recap::components.donor-info')

    @include('recap::components.divider')

    @include('recap::components.transaction-summary')

    @include('recap::components.divider')

    @include('recap::components.transaction-table')
</div>

@include('recap::components.footer')
</body>
</html>
