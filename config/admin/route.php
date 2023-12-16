<?php
return [
    /*---------------------------------------------------------------------------*/
    'default' => [
        'url' => '/',
        'method' => 'get',
        'action' => 'AuthController@Default',
        'secure' => false,
        'localized' => false,
        'unlocalized_url' => '/',
    ],
    'login' => [
        'url' => 'login',
        'method' => 'get',
        'action' => 'AuthController@Login',
        'secure' => false,
        'localized' => true,
        'unlocalized_url' => null,
    ],
    'login-autorized' => [
        'url' => 'login-autorized',
        'method' => 'post',
        'action' => 'AuthController@LoginAutorized',
        'secure' => false,
        'localized' => false,
        'unlocalized_url' => '/login-autorized',
    ],
    'login-logauth'=>[
        'url' => 'login-logauth',
        'method' => 'get',
        'action' => 'AuthController@LogAuth',
        'secure' => true,
        'localized' => false,
        'unlocalized_url' => '/login-logauth',
    ],
    /*---------------------------------------------------------------------------*/
    /*---------------------------------------------------------------------------*/
    /*---------------------------------------------------------------------------*/
    'dashboard' => [
        'url' => 'dashboard',
        'method' => 'get',
        'action' => 'DashboardController@Dashboard',
        'secure' => true,
        'localized' => true,
        'unlocalized_url' => null,
    ],
    /*---------------------------------------------------------------------------*/
    'company-list' => [
        'url' => 'company-list',
        'method' => 'get',
        'action' => 'CompanyController@List',
        'secure' => true,
        'localized' => true,
        'unlocalized_url' => null,
    ],
    /*---------------------------------------------------------------------------*/
    'users-list' => [
        'url' => 'users-list',
        'method' => 'get',
        'action' => 'UserController@List',
        'secure' => true,
        'localized' => true,
        'unlocalized_url' => null,
    ],
    /*---------------------------------------------------------------------------*/
    'services-list' => [
        'url' => 'services-list',
        'method' => 'get',
        'action' => 'ServiceController@List',
        'secure' => true,
        'localized' => true,
        'unlocalized_url' => null,
    ],
    /*---------------------------------------------------------------------------*/
    'ticket-list' => [
        'url' => 'ticket-list',
        'method' => 'get',
        'action' => 'TicketController@List',
        'secure' => true,
        'localized' => true,
        'unlocalized_url' => null,
    ],
    /*---------------------------------------------------------------------------*/
    'position-list' => [
        'url' => 'position-list',
        'method' => 'get',
        'action' => 'PositionController@List',
        'secure' => true,
        'localized' => true,
        'unlocalized_url' => null,
    ],
    /*---------------------------------------------------------------------------*/
    'collaborator-list' => [
        'url' => 'collaborator-list',
        'method' => 'get',
        'action' => 'CollaboratorController@List',
        'secure' => true,
        'localized' => true,
        'unlocalized_url' => null,
    ],
    /*---------------------------------------------------------------------------*/
    'collaborator-contract-list' => [
        'url' => 'collaborator-contract-list',
        'method' => 'get',
        'action' => 'CollaboratorContractController@List',
        'secure' => true,
        'localized' => true,
        'unlocalized_url' => null,
    ],
    /*---------------------------------------------------------------------------*/
    /*---------------------------------------------------------------------------*/
    /*---------------------------------------------------------------------------*/
    'clear' => [
        'url' => 'clear',
        'method' => 'get',
        'action' => 'GeneralController@Clear',
        'secure' => false,
        'localized' => true,
        'unlocalized_url' => null,
    ],
    /*---------------------------------------------------------------------------*/
    //jelipe
    'products-list' => [
        'url' => 'products-list',
        'method'=> 'get',
        'action' => 'ProductController@index',
        'secure' => true,
        'localized' => true,
        'unlocalized_url'=> null,
    ],
    'ubication-list'=>[
        'url'=>'ubication-list',
        'method'=>'get',
        'action'=>'UbicationController@index',
        'secure'=>true,
        'localized'=>true,
        'unlocalized_url'=>null,
    ],
    'types-list' =>[
        'url'=>'types-list',
        'method'=>'get',
        'action'=>'TypesController@index',
        'secure'=>true,
        'localized'=>true,
        'unlocalized_url'=>null
    ],
    'currency-list' =>[
        'url'=>'currency-list',
        'method'=>'get',
        'action'=>'CurrencyController@index',
        'secure'=>true,
        'localized'=>true,
        'unlocalized_url'=>null
    ],
    'groups-list' =>[
        'url'=>'groups-list',
        'method'=>'get',
        'action'=>'ProductGroupController@index',
        'secure'=>true,
        'localized'=>true,
        'unlocalized_url'=>null
    ],
    'categories-list' =>[
        'url'=>'categories-list',
        'method'=>'get',
        'action'=>'CategoriesController@index',
        'secure'=>true,
        'localized'=>true,
        'unlocalized_url'=>null
    ],
    'contacts-list' =>[
        'url'=>'contacts-list',
        'method'=>'get',
        'action'=>'ContactController@index',
        'secure'=>true,
        'localized'=>true,
        'unlocalized_url'=>null
    ],
    'cupons-list'=>[
        'url'=>'cupons-list',
        'method'=>'get',
        'action'=>'DashboardController@Dashboard',
        'secure'=>true,
        'localized'=>true,
        'unlocalized_url'=>null
    ],
    'warehouses-stores-list'=>[
        'url'=>'warehouses-stores-list',
        'method'=>'get',
        'action'=>'DashboardController@Dashboard',
        'secure'=>true,
        'localized'=>true,
        'unlocalized_url'=>null
    ],
    'sales-list'=>[
        'url'=>'sales-list',
        'method'=>'get',
        'action'=>'SaleController@index',
        'secure'=>true,
        'localized'=>true,
        'unlocalized_url'=>null
    ],
    'customers-list'=>[
        'url'=>'customers-list',
        'method'=>'get',
        'action'=>'CustomerController@index',
        'secure'=>true,
        'localized'=>true,
        'unlocalized_url'=>null
    ],
    'subscribers-list'=>[
        'url'=>'subscribers-list',
        'method'=>'get',
        'action'=>'SuscriberController@index',
        'secure'=>true,
        'localized'=>true,
        'unlocalized_url'=>null
    ],
    'idioms-list'=>[
        'url'=>'idioms-list',
        'method'=>'get',
        'action'=>'DashboardController@Dashboard',
        'secure'=>true,
        'localized'=>true,
        'unlocalized_url'=>null
    ],
    'parameters-list'=>[
        'url'=>'parameters-list',
        'method'=>'get',
        'action'=>'ParameterController@index',
        'secure'=>true,
        'localized'=>true,
        'unlocalized_url'=>null
    ],
    'doc-electronic-list'=>[
        'url'=>'doc-electronic-list',
        'method'=>'get',
        'action'=>'ElectronicDocumentController@index',
        'secure'=>true,
        'localized'=>true,
        'unlocalized_url'=>null
    ],
    'specification-list'=>[
        'url'=>'specification-list',
        'method'=>'get',
        'action'=>'SpecificationController@index',
        'secure'=>true,
        'localized'=>true,
        'unlocalized_url'=>null
    ],
    'list-electronics-document-customer'=>[
        'url'=>'list-electronics-document-customer',
        'method'=>'get',
        'action'=>'ElectronicsController@index',
        'secure'=>false,
        'localized'=>true,
        'unlocalized_url'=>null
    ],
    'list-electronic-document'=>[
        'url'=>'list-electronic-document',
        'method'=>'get',
        'action'=>'ElectronicsController@list',
        'secure'=>false,
        'localized'=>true,
        'unlocalized_url'=>null
    ],
    'send-electronic-billing'=>[
        'url'=>'send-electronic-billing',
        'method'=>'post',
        'action'=>'ElectronicBillingController@GenerateBill',
        'secure'=>true,
        'localized'=>false,
        'unlocalized_url'=>'/send-electronic-billing',
    ],
    'send-invoided-billing'=>[
        'url'=>'send-invoided-billing',
        'method'=>'post',
        'action'=>'ElectronicBillingController@GenerateSummary',
        'secure'=>true,
        'localized'=>false,
        'unlocalized_url'=>'/send-invoided-billing',
    ],
    'send-email-document'=>[
        'url'=>'send-email-document',
        'method'=>'post',
        'action'=>'ElectronicDocumentController@sendEmailDocument',
        'secure'=>true,
        'localized'=>false,
        'unlocalized_url'=>'/send-email-document',
    ],
    'send-notify-email-sale'=>[
        'url'=>'send-notify-email-sale',
        'method'=>'post',
        'action'=>'SaleController@statusReceptorSendEmail',
        'secure'=>true,
        'localized'=>false,
        'unlocalized_url'=>'/send-notify-email-sale',
    ],
    'dowload-template-product'=>[
        'url'=>'dowload-template-product',
        'method'=>'post',
        'action'=>'ProductController@downloadtemplate',
        'secure'=>true,
        'localized'=>false,
        'unlocalized_url'=>'/dowload-template-product',
    ],
    'import-template-product'=>[
        'url'=>'import-template-product',
        'method'=>'post',
        'action'=>'ProductController@ImportTemplate',
        'secure'=>true,
        'localized'=>false,
        'unlocalized_url'=>'/import-template-product',
    ],
    'get-heading-data'=>[
        'url'=>'get-heading-data',
        'method'=>'post',
        'action'=>'ProductController@getHeader',
        'secure'=>true,
        'localized'=>false,
        'unlocalized_url'=>'/get-heading-data',
    ],
    'dowload-excel-product-name'=>[
        'url'=>'dowload-excel/product-name',
        'method'=>'post',
        'action'=>'ProductController@ExcelNameProducts',
        'secure'=>true,
        'localized'=>false,
        'unlocalized_url'=>'/dowload-excel-product-name',
    ],
    'delete-image-product'=>[
        'url'=>'delete/image-product',
        'method'=>'post',
        'action'=>'ProductController@DeleteImage',
        'secure'=>true,
        'localized'=>false,
        'unlocalized_url'=>'/delete/image-product',
    ],
    'upload-image-massive'=>[
        'url'=>'upload/image-massive',
        'method'=>'post',
        'action'=>'ProductController@UploadImageProducts',
        'secure'=>true,
        'localized'=>false,
        'unlocalized_url'=>'/upload/image-massive',
    ],
    'upload-image-categories'=>[
        'url'=>'upload-image/categories',
        'method'=>'post',
        'action'=>'CategoriesController@uploadImage',
        'secure'=>true,
        'localized'=>false,
        'unlocalized_url'=>'upload-image/categories',
    ],
    'delete-image-categories'=>[
        'url'=>'delete-image/categories',
        'method'=>'post',
        'action'=>'CategoriesController@deteleImageCategories',
        'secure'=>true,
        'localized'=>false,
        'unlocalized_url'=>'delete-image/categories'
    ],
    'statistical-charts-list'=>[
        'url'=>'statistical-charts-list',
        'method'=>'get',
        'action'=>'StatisticalchartsController@index',
        'secure'=>true,
        'localized'=>true,
        'unlocalized_url'=>null
    ],
    'parameter-create-delete-card'=>[
        'url'=>'parameter/create-delete-card',
        'method'=>'post',
        'action'=>'ParameterController@UpdateDeleteCardOrBanner',
        'secure'=>true,
        'localized'=>false,
        'unlocalized_url'=>'/parameter/create-delete-card',
    ],
    'chart-grafics-save-data'=>[
        'url'=>'chart-grafics/save-data',
        'method'=>'post',
        'action'=>'StatisticalchartsController@saveDataUrl',
        'secure'=>true,
        'localized'=>true,
        'unlocalized_url'=>null,
    ],
    'tracing-list'=>[
        'url'=>'tracing-list',
        'method'=>'get',
        'action'=>'TracingController@index',
        'secure'=>true,
        'localized'=>true,
        'unlocalized_url'=>null,
    ],
];