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

        'donation_funding_category_table_name' => env('RECORDING_FUNDING_CATEGORY_TABLE_NAME', 'edonation.funding_categories'),

        'donation_funding_type_table_name' => env('RECORDING_FUNDING_TYPE_TABLE_NAME', 'edonation.funding_types'),

        'donation_program_table_name' => env('RECORDING_PROGRAM_TABLE_NAME', 'edonation.programs'),
    ],

    'file' => [
        'disk' => env('RECAP_STORAGE_DISK', env('FILESYSTEM_DISK', 'public')),

        /**
         * Base url for recap file, useful for S3
         */
        'disk_url' => env('RECAP_DISK_URL'),

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
