<?php

    namespace App\Http\Controllers\Business;

    use App\Helper\UploadFile;
    use App\Http\Controllers\Controller;
    use App\Models\Business;
    use App\Models\BusinessFactories;
    use App\Models\BusinessFactoryContacts;
    use App\Models\Notification;
    use App\Models\NotificationMessage;
    use App\Models\Subscription;
    use Config;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Validator;

    class FactoriesController extends Controller {
        use UploadFile;

        public function __construct() {

        }

        public function index() {
            $business = Business::where('user_id', \request()->user()->id)->first();
            $factories = BusinessFactories::where('business_id', $business->id)->paginate(env('PER_PAGE', 20));
            $subscription = Subscription::where('seller_id', \request()->user()->id)->latest()->first();
            if(empty($factories)) {
                return $this->create();
            }
            return view('business.settings.factories.index', ['factories' => $factories, 'subscription' => $subscription]);

        }

        public function create() {
            $business = Business::with('contacts')->where('user_id', \request()->user()->id)->first();
            if(count($business->contacts) == 0) {
                return redirect()->route('business::setting.contacts.create', ['lang' => app()->getLocale()]);
            }
            return view('business.settings.factories.create', ['business' => $business]);

        }

        public function store(Request $request) {
            $business = Business::where('user_id', \request()->user()->id)->first();
            $subscription = Subscription::where('seller_id', \request()->user()->id)->latest()->first();

            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255', 'address' => 'required', 'contacts' => 'required',]);
            if($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput()->with('danger', 'При сохранении произошла ошибка, подробности смотрите ниже');

            }

            $latestEntry = BusinessFactories::get();
            $factory = new BusinessFactories;
            $factory->business_id = $business->id;
            $factory->contacts_id = implode(',', $request->get('contacts'));
            $factory->factory_number = str_pad(($latestEntry) ? count($latestEntry) + 1 : 1, 8, "0", STR_PAD_LEFT);
            $factory->name = $request->name;
            $factory->address = $request->address;
            $factory->region = $this->address_component($request->marker_latitude, $request->marker_longitude);
            $factory->photo = ($request->photo ?? null);
            $factory->map_latitude = ($request->map_latitude ?? Config::get('map.default.map_latitude'));
            $factory->map_longitude = ($request->map_longitude ?? Config::get('map.default.map_longitude'));
            $factory->map_zoom = ($request->map_zoom ?? Config::get('map.default.map_zoom'));
            $factory->map_rotate = ($request->map_rotate ?? Config::get('map.default.map_rotate'));
            $factory->marker_latitude = ($request->marker_latitude ?? Config::get('map.default.marker_latitude'));
            $factory->marker_longitude = ($request->marker_longitude ?? Config::get('map.default.marker_longitude'));
            $factory->save();

            if(empty($subscription)) {
                $notificationText = NotificationMessage::select('id')->where('action', 'business.factory.adding')->first();
                $notification = new Notification;
                $notification->user_id = request()->user()->id;
                $notification->business_id = $business->id;
                $notification->business_factories_id = $factory->id;
                $notification->notification_messages_id = $notificationText->id;
                $notification->is_customer = 0;
                $notification->is_sendmail = 0;
                $notification->is_new = 1;
                $notification->save();
            }


            return redirect()->route('business::setting.factories.index', ['lang' => app()->getLocale()])->with('success', 'Success');

        }

        public function edit($lang, $factory_id) {
            $factory = BusinessFactories::with('contacts')->find($factory_id);
            return view('business.settings.factories.edit', ['factory' => $factory]);

        }

        public function update(Request $request, $lang, $factory_id) {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255', 'address' => 'required', 'contacts' => 'required',]);
            if($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput()->with('danger', 'При сохранении произошла ошибка, подробности смотрите ниже');

            }
            $factory = BusinessFactories::find($factory_id);
            $factory->contacts_id = implode(',', $request->get('contacts'));
            $factory->name = $request->name;
            $factory->address = $request->address;
            $factory->region = $this->address_component($request->marker_latitude, $request->marker_longitude);
            $factory->photo = ($request->photo ?? null);
            $factory->map_latitude = ($request->map_latitude ?? Config::get('map.default.map_latitude'));
            $factory->map_longitude = ($request->map_longitude ?? Config::get('map.default.map_longitude'));
            $factory->map_zoom = ($request->map_zoom ?? Config::get('map.default.map_zoom'));
            $factory->map_rotate = ($request->map_rotate ?? Config::get('map.default.map_rotate'));
            $factory->marker_latitude = ($request->marker_latitude ?? Config::get('map.default.marker_latitude'));
            $factory->marker_longitude = ($request->marker_longitude ?? Config::get('map.default.marker_longitude'));
            $factory->save();
            return redirect()->route('business::setting.factories.index', ['lang' => $lang])->with('success', 'Success');

        }


        protected function address_component($latitude, $longitude) {
            $key = env('APP_DEBUG') == true ? env('GOOGLE_API_KEY_TEST') : env('GOOGLE_API_KEY_PRODUCTION');
            $url = "https://maps.googleapis.com/maps/api/geocode/json?latlng=".$latitude.",".$longitude."&sensor=false&language=uk-UK&key=".$key;

            $json = file_get_contents($url);

            $json = json_decode($json, true);
            $parse_address_component = [];

            foreach($json['results'][0]['address_components'] as $results) {
                if($results['types'][0] == 'administrative_area_level_1' && !empty($results['long_name'])) {
                    $parse_address_component = $results['long_name'];
                } else if($results['types'][0] == 'locality' && !empty($results['long_name'])) {
                    if($results['long_name'] == 'Київ' || $results['long_name'] == 'місто Київ') {
                        $parse_address_component = 'Київська область';
                    } else {
                        $parse_address_component = $results['long_name'];
                    }
                }
            }

//        dd($parse_address_component );
            return $parse_address_component;
        }


        public function uploadFile(Request $request) {
            if($file = $request->file('photo')) {
                $photo = $this->uploadPhoto($file, 'factory', 300, 300);
                return $photo;

            }
        }

        public function removeFile(Request $request) {
            $srcPath = public_path('storage/factory/' . $request->filename);
            if(file_exists($srcPath) && !empty($request->filename)) {
                $user = BusinessFactories::where('photo', $request->filename)->first();
                if($user) {
                    $user->photo = null;
                    $user->save();
                }
                unlink($srcPath);
                return true;
            }

        }

    }
