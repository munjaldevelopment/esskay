<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use App\Models\Banner;
use App\Models\Event;
use App\Models\Gallery;
use App\Models\Page;
use App\Models\Volunteer;
use App\UsersDevice;

Route::get('/', function () {
	$pageInfo = Page::getPageInfo(1);
	$pageData = json_decode($pageInfo['extras']);
	
	$content = $pageInfo['content'];
	
	$title = $pageData->meta_title;
	$description = $pageData->meta_description;
	$keywords =  $pageData->meta_keywords;
	
	// Banner Data
	$galleries = Gallery::getGalleries();
	$galleryData = array();
	
	foreach($galleries as $k => $gallery)
	{
		$img = Image::make(public_path($gallery->image));
		$img->resize(100, 45);
		$fileSmall = str_replace("uploads/gallery", "uploads/gallery/thumbnail", $gallery->image);
		$img->save(public_path($fileSmall));
		
		$img = Image::make(public_path($gallery->image));
		$img->resize(1200, 537);
		$fileLarge = str_replace("uploads/gallery", "uploads/gallery/large", $gallery->image);
		$img->save(public_path($fileLarge));
		
		$galleryData[$k] = array('id' => $gallery->id, 'gallery_title' => $gallery->gallery_title, 'gallery_url' => $gallery->gallery_url, 'image' => URL::to('/').'/'.$gallery->image, 'thumbnail' => URL::to('/').'/'.$fileSmall, 'large' => URL::to('/').'/'.$fileLarge, 'description' => $gallery->description);
	}
	
	// Volunteer Data
	$volunteers = Volunteer::getVolunteers();
	$volunteerData = array();
	
	foreach($volunteers as $k => $volunteer)
	{
		$volunteerData[$k] = array('id' => $volunteer->id, 'name' => $volunteer->name, 'job_title' => $volunteer->job_title, 'image' => URL::to('/').'/'.$volunteer->image);
	}
	
	// Event Data
	$events = Event::getEvents();
	$eventData = array();
	
	foreach($events as $k => $event)
	{
		$img = Image::make(public_path($event->image));
		$img->resize(400, 400);
		$fileLarge = str_replace("uploads", "uploads/thumbnail", $event->image);
		$img->save(public_path($fileLarge));
		
		$eventData[$k] = array('id' => $event->id, 'title' => $event->title, 'content' => $event->content, 'date' => $event->date, 'location' => $event->location, 'image' => URL::to('/').'/'.$fileLarge);
	}
	//dd($eventData);
	
	return view('home', ['banners' => $galleryData, 'volunteers' => $volunteerData, 'events' => $eventData]);
    //return view('welcome');
});

Route::get('/send-notification', function () {
	$userDevices = UsersDevice::getUserDevice();
	
	if($userDevices)
	{
		foreach($userDevices as $userDevice)
		{
			$title = "Tiger's Rider";
			$message = 'Tiger riders cordially invites you for tennis ball cricket tournament. Date: Sunday 19 May, Venue: VIP ground, Near Airport, Assemble & toss - 5:15 am, Match starts- 5.25 am- 8:00am';
			$dataContent = array('title' => $title, 'message' => $message);
			$registrationIds = $userDevice['registration_id'];
			//echo $registrationIds; exit;
			$notification = array(
				'body' => $message,
				'title' => $title,
				'sound' => "default",
				'image' => 'http://tigersrider.samrudh.international/uploads/thumbnail/tiger_logo.png'
			);
			
			$data = array(
				"click_action" => "FLUTTER_NOTIFICATION_CLICK",
				"id" => "1",
				"status" => "done",
				'image' => 'http://tigersrider.samrudh.international/uploads/thumbnail/tiger_logo.png',
				'event_url' => 'http://tigersrider.samrudh.international/event_info/4',
				'body' => $message,
				'title' => $title
			);
			$output = UsersDevice::sendMessage($notification, $data, $registrationIds);
			print_r($output);
		}
	}
});

Route::get('/send-mail', function () {
	$ridersData = \DB::table('rider_data')->get();
	dd($ridersData);
	$contactData = array('contact_name' => 'Munjal Mayank', 'contact_username' => 'munjalmayank');
	
	$tempUserData = array('email' => 'munjaldevelopment@gmail.com', 'name' => 'Munjal Mayank');
	Mail::send('emails.event', $contactData, function ($message) use ($tempUserData) {
		$message->to($tempUserData['email'], $tempUserData['name'])->subject('Your registration has confirmed.');
		$message->from('tigersrider@microcrm.in', 'Tiger Riders');
	});
});

Route::get('event_info/{event_id}', ['as' => 'event', 'uses' => 'EventController@info']);////{id}', function () {

Route::post('contact_us', 'HomeController@contactUs');


