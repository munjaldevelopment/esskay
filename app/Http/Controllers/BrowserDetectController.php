<?php

namespace App\Http\Controllers;

use Jenssegers\Agent\Agent;




class BrowserDetectController extends Controller
{
	public function index()
	{
		$agent = new Agent();
		
		$device = $agent->device();
		$platform = $agent->platform();
		$version1 = $agent->version($platform);
		$browser = $agent->browser();
		$version = $agent->version($browser);
		$desktop = $agent->isDesktop();
		$mobile = $agent->isMobile();
		$tablet = $agent->isTablet();

		echo $device.",".$platform.",".$version1.",".$browser.",".$version.",".$desktop.",".$mobile.",".$tablet;
	}
}
