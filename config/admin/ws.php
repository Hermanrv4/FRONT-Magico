<?php
return [
    'url' => 'http://api.merlishop',
    'service' => [
        /*---------------------------------------------------------------------------*/
        'authentication' => [
            'group' => 'authentication',
            'email-login' => [
                'url' => 'email-login',
                'method' => 'post',
            ],
            'logauth'=>[
                'url'=>'logauth',
                'method'=>'post',
            ],
        ],
        /*---------------------------------------------------------------------------*/
        'configuration' => [
            'group' => 'config',
            'need-update' => [
                'url' => 'need-update',
                'method' => 'post',
            ],
            'get' => [
                'url' => 'get',
                'method' => 'post',
            ],
            'parameters' => [
                'url' => 'parameters',
                'method' => 'post',
            ],
            'parameters-get' => [
                'url' => 'parameters/get/name',
                'method' => 'post',
            ],
            'parameters-save' => [
                'url' => 'parameters/save',
                'method' => 'post',
            ],
        ],
        /*---------------------------------------------------------------------------*/
        'entity' => [
            'group' => 'entity',
            'company-get' => [
                'url' => 'company/get',
                'method' => 'post',
            ],
            'company-register' => [
                'url' => 'company/register',
                'method' => 'post',
            ],
            'company-delete' => [
                'url' => 'company/delete',
                'method' => 'post',
            ],

            'user-get' => [
                'url' => 'user/get',
                'method' => 'post',
            ],
            'user-get-by-company-id' => [
                'url' => 'user/get-by-company-id',
                'method' => 'post',
            ],
            'user-get-internal' => [
                'url' => 'user/get-internal',
                'method' => 'post',
            ],
            'user-register' => [
                'url' => 'user/register',
                'method' => 'post',
            ],
            'user-delete' => [
                'url' => 'user/delete',
                'method' => 'post',
            ],

            'collaborator-get' => [
                'url' => 'collaborator/get',
                'method' => 'post',
            ],
            'collaborator-register' => [
                'url' => 'collaborator/register',
                'method' => 'post',
            ],
            'collaborator-delete' => [
                'url' => 'collaborator/delete',
                'method' => 'post',
            ],

            'collaborator-contract-get' => [
                'url' => 'collaborator-contract/get',
                'method' => 'post',
            ],
            'collaborator-contract-register' => [
                'url' => 'collaborator-contract/register',
                'method' => 'post',
            ],
            'collaborator-contract-delete' => [
                'url' => 'collaborator-contract/delete',
                'method' => 'post',
            ],

            'position-get' => [
                'url' => 'position/get',
                'method' => 'post',
            ],
            'position-register' => [
                'url' => 'position/register',
                'method' => 'post',
            ],
            'position-delete' => [
                'url' => 'position/delete',
                'method' => 'post',
            ],
            'category-get' => [
                'url'=>'category/get',
                'method'=>'post',
            ],
            'type-get'=>[
                'url'=>'type/get',
                'method'=>'post',
            ],
            'type-group'=>[
                'url'=>"type/type-group/get",
                'method'=>'post',
            ],
            'service-get' => [
                'url' => 'service/get',
                'method' => 'post',
            ],
            'service-register' => [
                'url' => 'service/register',
                'method' => 'post',
            ],
            'service-delete' => [
                'url' => 'service/delete',
                'method' => 'post',
            ],

            'service-key-user-get' => [
                'url' => 'service-key-user/get',
                'method' => 'post',
            ],
            'service-key-user-register' => [
                'url' => 'service-key-user/register',
                'method' => 'post',
            ],
            'service-key-user-delete' => [
                'url' => 'service-key-user/delete',
                'method' => 'post',
            ],
            'type-group'=>[
                'url'=>'type-group/get',
                'method'=>'post',
            ],
            'type-register'=> [
                'url'=>'type/register',
                'method'=>'post',
            ],
            'type-delete'=> [
                'url'=>'type/delete',
                'method'=>'post',
            ],
            //currency crud
            'currency-get' => [
                'url' => 'currency/get',
                'method' => 'post',
            ],
            'currency-register'=>[
                'url'=>'currency/register',
                'method'=>'post',
            ],
            'currency-delete'=>[
                'url'=>'currency/delete',
                'method'=>'post',
            ],
            'ProductGroup-Get'=>[
                'url'=>'product-group/get',
                'method'=>'post',
            ],
            'ProductGroup-Delete'=>[
                'url'=>'product-group/delete',
                'method'=>'post',
            ],
            'ProductGroup-Register'=>[
                'url'=>'product-group/register',
                'method'=>'post',
            ],
            'Product-change-status'=>[
                'url'=>'product/change-status',
                'method'=>'post',
            ],
            //end currency crud
            'product-specification-get'=>[
                'url'=>'product-specification/get',
                'method'=>'post',
            ],
            'ubication-get'=>[
                'url'=>'ubication/get',
                'method'=>'post',
            ],
            'ubication-root-get'=>[
                'url'=>'ubication-root/get',
                'method'=>'post',
            ],
            'ubication-register'=>[
                'url'=>'ubication/register',
                'method'=>'post',
            ],
            'ubication-delete'=>[
                'url'=>'ubication/delete',
                'method'=>'post',
            ],
            'Product-Register'=>[
                'url'=>'product/register',
                'method'=>'post',
            ],
            'Product-Delete'=>[
                'url'=>'product/delete',
                'method'=>'post',
            ],
            'ProductPrice-Get'=>[
                'url'=>'product-price/get',
                'method'=>'post',
            ],
            'ProductPrice-Register'=>[
                'url'=>'product-price/register',
                'method'=>'post',
            ],
            'ProductPrice-Delete'=>[
                'url'=>'product-price/delete',
                'method'=>'post'
            ],
            //end ubication
            'ProductSpecification-Register'=>[
                'url'=>'product-specification/register',
                'method'=>'post',
            ],
            'ProductSpecification-Delete'=>[
                'url'=>'product-specification/delete',
                'method'=>'post',
            ],
            //shipping
            'ShippingPrice-Get'=>[
                'url'=>'shipping-price/get',
                'method'=>'post',
            ],
            'ShippingPrice-Register'=>[
                'url'=>'shipping-price/register',
                'method'=>'post',
            ],
            'ShippingPrice-Delete'=>[
                'url'=>'shipping-price/delete',
                'method'=>'post',
            ],
            'shipping-price-update'=>[
                'url'=>'shipping-price/update-full-ubications',
                'method'=>'post',
            ],
            //category-get
            'category-get'=>[
                'url'=>'category/get',
                'method'=>'post',
            ],
            'category-root-get'=>[
                'url'=>'category-root/get',
                'method'=>'post',
            ],
            'category-register'=>[
                'url'=>'category/register',
                'method'=>'post',
            ],
            'category-delete'=>[
                'url'=>'category/delete',
                'method'=>'post',
            ],
            'suscriber-get'=>[
                'url'=>'suscriber/get',
                'method'=>'post',
            ],
            'suscriber-register'=>[
                'url' => 'suscriber/register',
                'method'=> 'post',
            ],
            'suscriber-delete'=>[
                'url'=> 'suscriber/delete',
                'method'=> 'post',
            ],
            'Contact-Get'=>[
                'url'=>'contact/get',
                'method'=>'post',
            ],
            'Contact-Register'=>[
                'url'=>'contact/register',
                'method'=>'post',
            ],
            'Contact-Delete'=>[
                'url'=>'contact/delete',
                'method'=>'post',
            ],
            'order-get'=>[
                'url'=>'order/get',
                'method'=>'post',
            ],
            'order-change-status'=>[
                'url'=>'order/change-status',
                'method'=>'post',
            ],
            'order-detail-get'=>[
                'url'=>'order-detail/get',
                'method'=>'post',
            ],           
            'Address-Get'=>[
                'url'=>'address/get',
                'method'=>'post',
            ],
            'Address-Register'=>[
                'url'=>'address/register',
                'method'=>'post',
            ],
            'Address-Delete'=>[
                'url'=>'address/delete',
                'method'=>'post',
            ],
            'Customer-Get'=>[
                'url'=>'user/get',
                'method'=>'post',
            ],
            'Customer-Register'=>[
                'url'=>'user/register',
                'method'=>'post',
            ],
            'Customer-Delete'=>[
                'url'=>'user/delete',
                'method'=>'post',
            ],
            'Product-Get'=>[
                'url'=>'product/get',
                'method'=>'post',
            ],
            'Specification-Get'=>[
                'url'=>'specification/get',
                'method'=>'post',
            ],
            'Specification-Register'=>[
                'url'=>'specification/register',
                'method'=>'post',
            ],
            'type-service-get' => [
                'url' => 'type/service/get',
                'method' => 'post',
            ],
            'type-billing-get' => [
                'url' => 'type/billing/get',
                'method' => 'post',
            ],
            'type-service-status-get' => [
                'url' => 'type/service-status/get',
                'method' => 'post',
            ],
            'Specification-Delete'=>[
                'url' => 'specification/delete',
                'method' => 'post',
            ],
            'system-roles-get' => [
                'url' => 'system-roles/get',
                'method' => 'post',
            ],
            'parameter-get' => [
                'url'=>'parameter/get',
                'method'=>'post',
            ],
            'parameter-get-codes'=>[
                'url'=>'parameter/get-codes',
                'method'=>'post',
            ],
            'parameter-register'=>[
                'url'=>'parameter/register',
                'method'=>'post',
            ],
            'parameter-get-codes-all'=>[
                'url'=>'parameter/get-codes-all',
                'method'=>'post'
            ],
            'electronic-billing-sale-get'=>[
                'url'=>'electronic-billing-sale/get',
                'method'=>'post',
            ],
            'electronic-billing-sale-register'=>[
                'url'=>'electronic-billing-sale/register',
                'method'=>'post',
            ],
            'electronic-billing-sale-voided'=>[
                'url'=>'electronic-billing-sale/voided',
                'method'=>'post',
            ],
            'electronic-billing-get-correlative'=>[
                'url'=>'electronic-billing/get-correlative',
                'method'=>'post',
            ],
            'electronic-billing-update'=>[
                'url'=>'electronic-billing/update-correlative',
                'method'=>'post',
            ],
            'order-get-all-billed'=>[
                'url'=>'order-billed/get',
                'method'=>'post',
            ],
            'electronic-billing-sale-exists-order'=>[
                'url'=>'electronic-billing-sale/exists-order',
                'method'=>'post',
            ],
            'order-billed-get-filter'=>[
                'url'=>'order-billed/get-filters',
                'method'=>'post',
            ],
            'ld-product-register'=>[
                'url'=>'ld-product/register',
                'method'=>'post',
            ],
            'ld-category-register'=>[
                'url'=>'ld-category/register',
                'method'=>'post',
            ],
            'ld-product-get'=>[
                'url'=>'ld-product/get',
                'method'=>'post',
            ],
            'ld-category-get'=>[
                'url'=>'ld-category/get',
                'method'=>'post',
            ],
            'ld-product-procedure'=>[
                'url'=>'ld-product/procedure',
                'method'=>'post',
            ],
            'ld-billing-categorie-sale'=>[
                'url'=>'ld-billing/categorie-sale',
                'method'=>'post',
            ],
            'order-get-customer-date'=>[
                'url'=>'order/get-customer-date',
                'method'=>'post'
            ],
            'product-get-order-sale'=>[
                'url'=>'product-get/order-sale',
                'method'=>'post',
            ],
            'product-group-get-order-sale'=>[
                'url'=>'product-group-get/order-sale',
                'method'=>'post',
            ],
            'order-get-status-date'=>[
                'url'=>'order-get/status-date',
                'method'=>'post'
            ],
            'suscriber-get-date'=>[
                'url'=>'suscriber-get/date',
                'method'=>'post',
            ],
            'order-get-status-of-date'=>[
                'url'=>'order-get/status-of-date',
                'method'=>'post',
            ],
            'user-get-register-of-date'=>[
                'url'=>'user-get/register-of-date',
                'method'=>'post',
            ],
            'categories-get-data-billing-date'=>[
                'url'=>'categories-get/data-billing-date',
                'method'=>'post',
            ],
            'product-get-data-billing-of-date'=>[
                'url'=>'product-get/data-billing-of-date',
                'method'=>'post',
            ],
            'product-group-get-data-billing-of-date'=>[
                'url'=>'product-group-get/data-billing-of-date',
                'method'=>'post',
            ],
            'user-get-order-of-date'=>[
                'url'=>'user-get/order-of-date',  
                'method'=>'post',
            ],
            'user-get-billing-of-date'=>[
                'url'=>"user-get/billing-of-date",
                'method'=>'post',
            ],
            'order-get-of-date'=>[
                'url'=>'order-get/of-date',
                'method'=>'post',
            ],
            'tracing-register'=>[
                'url'=>'tracing/register',
                'method'=>'post',
            ],
            'tracing-get-data-or-date'=>[
                'url'=>'tracing-get/data-or-date',
                'method'=>'post',
            ],
            'tracing-get-preview-or-date'=>[
                'url'=>'tracing-get/preview-or-date',
                'method'=>'post',
            ],
            'tracing-get-addCard-or-date'=>[
                'url'=>'tracing-get/addCard-or-date',
                'method'=>'post',
            ],
            'tracing-get-visit-page-usernull'=>[
                'url'=>'tracing-get/visit-page-usernull',
                'method'=>'post'
            ],
            'tracing-get-visit-category'=>[
                'url'=>'tracing-get/visit-category',
                'method'=>'post',
            ],
            'tracings-get-visit-page-for-user'=>[
                'url'=>'tracings-get/visit-page-for-user',
                'method'=>'post',
            ],
            'tracing-get-preview-for-user'=>[
                'url'=>'tracing-get/preview-for-user',
                'method'=>'post',
            ],
            'tracing-get-addcard-for-user'=>[
                'url'=>'tracing-get/addcard-for-user',
                'method'=>'post',
            ],
            'tracing-get-category-visit-for-user'=>[
                'url'=>'tracing-get/category-visit-for-user',
                'method'=>'post',
            ],
            'tracing-get-category-visit-usernull'=>[
                'url'=>'tracing-get/category-visit-usernull',
                'method'=>'post',
            ],
        ],
    ],
];
