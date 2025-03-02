<?php
// config/csp.php
return [
    'policies' => [
        'default-src' => "'self'",
        'script-src' => [
            "'self'",
            "'wasm-unsafe-eval'",
            "'inline-speculation-rules'",
            'https://code.jquery.com',         // Allow jQuery CDN
            'https://cdn.datatables.net',      // Allow DataTables CDN
        ],
        // Add other directives as needed
    ],
];
