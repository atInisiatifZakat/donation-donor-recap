<?php

declare(strict_types=1);

return [
    'queue' => [
        'connection' => env('RECAP_QUEUE_CONNECTION', env('QUEUE_CONNECTION', 'sync')),

        'name' => env('RECAP_QUEUE_NAME', env('SQS_QUEUE', 'donation-donor-recap')),
    ],

    'recording' => [
        'donor_table_name' => env('RECORDING_DONOR_TABLE_NAME', 'edonation.donors'),

        'donor_phone_table_name' => env('RECORDING_DONOR_PHONE_TABLE_NAME', 'edonation.donor_phones'),

        'donor_branch_table_name' => env('RECORDING_DONOR_BRANCH_TABLE_NAME', 'edonation.branches'),

        'donor_employee_table_name' => env('RECORDING_DONOR_EMPLOYEE_TABLE_NAME', 'edonation.employees'),

        'donor_partner_table_name' => env('RECORDING_DONOR_PARTNER_TABLE_NAME', 'edonation.partners'),

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

    'notification' => [
        'whatsapp' => [
            'channel_id' => env('RECAP_NOTIFICATION_WHATSAPP_CHANNEL', env('DONATION_QONTAK_CHANNEL_ID')),

            'template_id' => env('RECAP_NOTIFICATION_WHATSAPP_TEMPLATE', '63777d87-173f-4fcb-906e-f50d91e0d04c'),
        ],

        'email' => [
            'sender_name' => env('RECAP_NOTIFICATION_EMAIL_SENDER_NAME', 'Inisiatif Zakat Indonesia'),

            'sender_address' => env('RECAP_NOTIFICATION_EMAIL_SENDER_ADDRESS', 'no-reply@izi.or.id'),
        ],
    ],
];
