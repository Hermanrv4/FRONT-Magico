<?php
return [
    'clear' => '/clear',
    'login' => '/login',
    'dashboard' => '/dashboard',
    'company-list' => '/empresas',
    'users-list' => '/usuarios',
    'services-list' => '/servicios',
    'ticket-list' => '/tickets',
    'position-list' => '/posiciones',
    'collaborator-list' => '/colaboradores',
    'collaborator-contract-list' => '/contratos/{code?}',
    //rutas back 
    'products-list'=> '/productos/{code?}',
    'ubication-list'=>'/ubicaciones',
    'categories-list'=>'/categorias',
    'types-list'=>'/Tipos',
    'currency-list'=>'/Moneda',
    'groups-list'=>'/Groups',
    'cupons-list'=>'/Cupones',
    'warehouses-stores-list'=>'/Almacenes-Tiendas',
    'sales-list'=>'/Ventas/{code?}',
    'customers-list'=>'/Clientes',
    'subscribers-list'=>'/Subscriptores',
    'idioms-list'=>'/Lenguajes',
    'parameters-list'=>'/parametros',
    'contacts-list'=>'/Contactos',
    'specification-list'=>'/Especificaciones',
    'doc-electronic-list'=>'/DocumentosElectronicos',
    //rutas para la visualizacion de documentos electronicos para el cliente
    'list-electronic-document'=> '/Lista/DocumentosElectronicos/{param}',
    'list-electronics-document-customer'=>'/Lista/DocumentosElectronicos/Clientes',
    'statistical-charts-list'=>'/Graficos',
    'tracing-list'=>'/rastreadorBitz/{code?}'
];