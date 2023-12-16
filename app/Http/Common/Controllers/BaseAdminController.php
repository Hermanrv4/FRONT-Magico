<?php

namespace App\Http\Common\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class BaseAdminController extends Controller {
    public $group;
    public function __construct() {
        $this->group = config('env.app_group_admin');
    }
}
