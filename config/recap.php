<?php

declare(strict_types=1);

return [
    'queue' => [
        'connection' => env('RECAP_QUEUE_CONNECTION', env('QUEUE_CONNECTION', 'sync')),

        'name' => env('RECAP_QUEUE_NAME', env('SQS_QUEUE', 'donation-donor-recap')),
    ],

    'recording' => [
        'donor_table_name' => env('RECORDING_DONOR_TABLE_NAME', 'edonation.donors'),

        'donation_table_name' => env('RECORDING_DONATION_TABLE_NAME', 'edonation.donations'),

        'donation_detail_table_name' => env('RECORDING_DONATION_DETAIL_TABLE_NAME', 'edonation.donation_details'),

        'donation_funding_type_table_name' => env('RECORDING_FUNDING_TYPE_TABLE_NAME', 'edonation.funding_types'),

        'donation_program_table_name' => env('RECORDING_PROGRAM_TABLE_NAME', 'edonation.programs'),
    ],

    'file' => [
        'disk' => env('RECAP_STORAGE_DISK', env('FILESYSTEM_DISK', 'public')),

        /**
         * Directory generated file pdf
         */
        'generated' => 'recap',

        /**
         * Directory result file pdf, generated file + template
         */
        'result' => 'recap',
    ],

    'puppeteer' => [
        'npm' => env('RECAP_PUPPETEER_NPM_BINARY'),

        'node' => env('RECAP_PUPPETEER_NODE_BINARY'),

        'paper_size_format' => env('RECAP_PUPPETEER_LETTER_SIZE', 'Letter'),
    ],
];
