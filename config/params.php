<?php

return [
    'adminEmail' => 'admin@example.com',
    'senderEmail' => 'noreply@example.com',
    'senderName' => 'Example.com mailer',
    'DBCompanyName' => 'Tenwek Hospital Community-TEST$',

    'powered' => 'Iansoft Ltd',
    'NavisionUsername'=> 'Portal',
    'NavisionPassword'=> 'TenwekPortal@2021',

    'server'=>'navisionsql',
    'WebServicePort'=>'7047',
    'ServerInstance'=>'BC140',
    'CompanyName'=> 'Tenwek%20Hospital%20Community-TEST',
    'DBCompanyName' => 'Tenwek Hospital Community-TEST$',

    'codeUnits' => [
        //'Portal_Workflows', //50019
        'JobApplication', //50002
        'AppraisalWorkflow', //50228 ********
        'PortalReports', //50064
        //'ContractRenewalStatusChange', // 50024
        'PortalFactory', // 50062
        'ImprestManagement', // 50017
        'EmployeeExitManagement',
    ],

    'ServiceName'=>[

        /**************************Companies*************************************/
        'Companies' => 'Companies', //357 (Page)
        'SupplierAplicationList'=>'SupplierAplicationList', //66050 Page
        'VendorCard'=>'VendorCard', //66051
        'SupplierCategory'=>'SupplierCategory', // 66057 Page
        'PostalCodes'=>'PostalCodes',//367 Page
        'SupplierPartnerDetails'=>'SupplierPartnerDetails', //66056 Page,
        'Countries'=>'Countries', //10 Page
        'SupplierBankAccounts'=>'SupplierBankAccounts',//66058 Page
        'BankBranches'=>'BankBranches',// 66068 Page
        'KenyaBanks'=>'KenyaBanks', //66067 Page
        'SupplierCategories'=>'SupplierCategories',// 66065 Page

        /********************CODE UNITS SERVICES***************************************/
        'PortalFactory' => 'PortalFactory', //Code Unit 50062
    ],

];
