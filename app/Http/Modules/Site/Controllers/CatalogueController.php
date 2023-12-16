<?php

namespace App\Http\Modules\Site\Controllers;

use App\Http\Common\Controllers\BaseSiteController;
use Illuminate\Http\Request;

class CatalogueController extends BaseSiteController {
    public function CatalogueAll(){
        return view(config($this->group.'.ui.ecommerce.catalogue.view'),["category"=>null,"search"=>null]);
    }
    public function CatalogueCategory($category){
        return view(config($this->group.'.ui.ecommerce.catalogue.view'),["category"=>$category,"search"=>null]);
    }
    public function CatalogueCluster($cluster){ 
        return view(config($this->group.'.ui.ecommerce.catalogue.view'),["cluster"=>$cluster]);
    }
    public function CatalogueSale(){
        return view(config($this->group.'.ui.ecommerce.catalogue.view'),["sale"=>true,"search"=>null]);
    }
    public function CatalogueSearch($search){
        return view(config($this->group.'.ui.ecommerce.catalogue.view'),["search"=>$search]);
    }
}
