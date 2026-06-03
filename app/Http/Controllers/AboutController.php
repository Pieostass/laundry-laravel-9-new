<?php

namespace App\Http\Controllers;

use App\Services\SiteConfigService;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function __construct(private SiteConfigService $siteConfigService) {}

    public function company()
    {
        return view('about.company', [
            'aboutConfig' => $this->siteConfigService->asMap(),
        ]);
    }

    public function soccon()
    {
        return view('about.soccon', [
            'aboutConfig' => $this->siteConfigService->asMap(),
        ]);
    }

    public function pinkmee()
    {
        return view('about.pinkmee', [
            'aboutConfig' => $this->siteConfigService->asMap(),
        ]);
    }
}