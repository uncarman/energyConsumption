<?php

namespace App\Http\Controllers\Settings;

use App\Service\BuildingServiceApi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingsBaseController extends Controller
{
    protected $bs;

    public function __construct(BuildingServiceApi $bs)
    {
        parent::__construct();
        $this->bs = $bs;
    }

    public function index(Request $request)
    {
        return view('single.settings.base');
    }

    public function ajaxBaseList(Request $request)
    {
        return [];
    }
}
