<?php

return [
    'exports' => [

        /*
        |--------------------------------------------------------------------------
        | Chunk size
        |--------------------------------------------------------------------------
        |
        | When using FromQuery, the query is automatically chunked.
        | Here you can specify how big the chunk should be.
        |
        */
        'chunk_size' => 1000,

        /*
        |--------------------------------------------------------------------------
        | Pre-calculate formulas during export
        |--------------------------------------------------------------------------
        */
        'pre_calculate_formulas' => false,

        /*
        |--------------------------------------------------------------------------
        | Enable strict null comparison
        |--------------------------------------------------------------------------
        */
        'strict_null_comparison' => false,

        /*
        |--------------------------------------------------------------------------
        | CSV Settings
        |--------------------------------------------------------------------------
        |
        | Configure e.g. delimiter, enclosure, line ending, etc.
        |
        */
        'csv' => [
            'delimiter' => ',',
            'enclosure' => '"',
            'line_ending' => PHP_EOL,
            'use_bom' => false,
            'include_separator_line' => false,
            'excel_compatibility' => false,
            'output_encoding' => '',
        ],

        /*
        |--------------------------------------------------------------------------
        | Worksheet properties
        |--------------------------------------------------------------------------
        |
        | Configure e.g. default title, creator, lastModifiedBy, etc.
        |
        */
        'properties' => [
            'creator' => '',
            'lastModifiedBy' => '',
            'title' => '',
            'description' => '',
            'subject' => '',
            'keywords' => '',
            'category' => '',
            'manager' => '',
            'company' => '',
        ],
    ],

    'imports' => [

        /*
        |--------------------------------------------------------------------------
        | Read Only
        |--------------------------------------------------------------------------
        |
        | When dealing with imports, you might only be interested in the
        | data that the sheet exists. By default we ignore all styles,
        | however if you want to preserve styles, set this to false.
        |
        */
        'read_only' => true,

        /*
        |--------------------------------------------------------------------------
        | Ignore Empty
        |--------------------------------------------------------------------------
        |
        | When dealing with imports, you might want to ignore empty rows.
        | By default False.
        |
        */
        'ignore_empty' => false,

        /*
        |--------------------------------------------------------------------------
        | Heading Row Formatter
        |--------------------------------------------------------------------------
        |
        | Configure the heading row formatter.
        | Available options: None|Slug
        |
        */
        'heading_row' => [
            'formatter' => 'slug',
        ],

        /*
        |--------------------------------------------------------------------------
        | CSV Settings
        |--------------------------------------------------------------------------
        |
        | Configure e.g. delimiter, enclosure, line ending, etc.
        |
        */
        'csv' => [
            'delimiter' => null,
            'enclosure' => '"',
            'escape_character' => '\\',
            'contiguous' => false,
            'input_encoding' => 'UTF-8',
        ],

        /*
        |--------------------------------------------------------------------------
        | Worksheet properties
        |--------------------------------------------------------------------------
        |
        | Configure e.g. default title, creator, lastModifiedBy, etc.
        |
        */
        'properties' => [
            'creator' => '',
            'lastModifiedBy' => '',
            'title' => '',
            'description' => '',
            'subject' => '',
            'keywords' => '',
            'category' => '',
            'manager' => '',
            'company' => '',
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Extension detector
    |--------------------------------------------------------------------------
    |
    | Configure here which writer/reader type should be used when the
    | filename extension is not recognized.
    |
    */
    'extension_detector' => [
        'xlsx'     => \Maatwebsite\Excel\Files\ExcelExtensions::XLSX,
        'xlsm'     => \Maatwebsite\Excel\Files\ExcelExtensions::XLSM,
        'xltx'     => \Maatwebsite\Excel\Files\ExcelExtensions::XLTX,
        'xltm'     => \Maatwebsite\Excel\Files\ExcelExtensions::XLTM,
        'xls'      => \Maatwebsite\Excel\Files\ExcelExtensions::XLS,
        'xlt'      => \Maatwebsite\Excel\Files\ExcelExtensions::XLT,
        'ods'      => \Maatwebsite\Excel\Files\ExcelExtensions::ODS,
        'ots'      => \Maatwebsite\Excel\Files\ExcelExtensions::OTS,
        'slk'      => \Maatwebsite\Excel\Files\ExcelExtensions::SLK,
        'xml'      => \Maatwebsite\Excel\Files\ExcelExtensions::XML,
        'gnumeric' => \Maatwebsite\Excel\Files\ExcelExtensions::GNUMERIC,
        'htm'      => \Maatwebsite\Excel\Files\ExcelExtensions::HTM,
        'html'     => \Maatwebsite\Excel\Files\ExcelExtensions::HTML,
        'csv'      => \Maatwebsite\Excel\Files\ExcelExtensions::CSV,
        'tsv'      => \Maatwebsite\Excel\Files\ExcelExtensions::TSV,

        /*
        |--------------------------------------------------------------------------
        | PDF Extension
        |--------------------------------------------------------------------------
        |
        | Configure here which Pdf driver should be used by default.
        | Available options: Excel::MPDF | Excel::TCPDF | Excel::DOMPDF
        |
        */
        'pdf' => \Maatwebsite\Excel\Excel::DOMPDF,
    ],

    /*
    |--------------------------------------------------------------------------
    | Value Binder
    |--------------------------------------------------------------------------
    |
    | PhpSpreadsheet's cell Value Binder provides a mechanism for injecting
    | custom validation and formatting of cell values at time of assignment
    | to a cell object. By default, it converts string values with numeric
    | formatting to numbers.
    |
    */
    'value_binder' => [
        /*
        |--------------------------------------------------------------------------
        | Default Value Binder
        |--------------------------------------------------------------------------
        |
        | This option is used to set the default value binder. It can be the
        | name of a class that extends PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder
        | or 'strict'.
        |
        */
        'default' => 'Maatwebsite\Excel\Cell::bindValue',
    ],

    'cache' => [
        /*
        |--------------------------------------------------------------------------
        | Cache Implementation
        |--------------------------------------------------------------------------
        |
        | By default, we utilize Laravel's cache driver. You can opt to use
        | a specific cache store or even implement your own cache driver.
        |
        */
        'driver' => env('EXCEL_CACHE_DRIVER', 'file'),

        /*
        |--------------------------------------------------------------------------
        | Cache Settings
        |--------------------------------------------------------------------------
        |
        | These are additional cache settings that can be applied. See the
        | cache configuration in Laravel's config/cache.php for more info.
        |
        */
        'settings' => [
            'memory_cache_size' => '64MB',
            'cache_time'        => 600,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Transaction Handler
    |--------------------------------------------------------------------------
    |
    | By default, the import is wrapped in a transaction. This can be
    | disabled by setting this option to null.
    |
    */
    'transactions' => [
        'handler' => 'db',
        'model' => [
            'connection' => null,
        ],
    ],

    'temporary_files' => [

        /*
        |--------------------------------------------------------------------------
        | Local Temporary Path
        |--------------------------------------------------------------------------
        |
        | When exporting and importing files, we use a temporary file, before
        | storing reading or downloading. Here you can customize that path.
        |
        */
        'local_path' => storage_path('framework/cache/laravel-excel'),

        /*
        |--------------------------------------------------------------------------
        | Remote Temporary Disk
        |--------------------------------------------------------------------------
        |
        | When dealing with a multi-server setup with queues in which you
        | cannot rely on having a shared local temporary path, you might
        | want to configure a remote temporary path.
        |
        */
        'remote_disk' => null,
        'remote_prefix' => null,

        /*
        |--------------------------------------------------------------------------
        | Force Resync
        |--------------------------------------------------------------------------
        |
        | When dealing with a multi-server setup as above, it's possible
        | for the clean up to fail. For this, we enable a force resync
        | option to overwrite existing cached files.
        |
        */
        'force_resync_remote' => null,
    ],
];