<?php

    namespace App\Http\Controllers\Amicms\v1;

    use App\Http\Controllers\AmicmsController;
    use App\Models\Business;
    use App\Models\User;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Validator;
    use Config;
    use Illuminate\Validation\Rule;

    class BusinessProfileController extends AmicmsController {
        private $layout = [];
        private $phone;

        public function __construct() {
            $this->is_profile_auth();
            $this->layout['title'] = 'Підприємства';

        }

        public function index($business_id) {
            $business = Business::where('id', $business_id)->withTrashed()->first();
            $business_profile = User::where('id', $business->user_id)->withTrashed()->first();
            return view('amicms.business.profile.view', ['layout' => $this->layout, 'business' => $business, 'business_id'=>$business_id, 'business_profile' => $business_profile]);

        }

        public function store(Request $request, $business_id) {
            $business = Business::where('id', $business_id)->withTrashed()->first();

            $this->phone = str_replace([' ', '-', '+', '(', ')'], '', $request->get('phone'));
            $request->merge([
                'phone' => $this->phone,
            ]);

            $validator = Validator::make($request->all(), [
                'first_name' => 'required|max:255',
                'last_name' => 'required|max:255',
                'phone' => ['required', Rule::unique('users')->ignore($business->user_id)],
                'email' => ['required', Rule::unique('users')->ignore($business->user_id)],
                'address' => 'required',

            ]);

            if($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput()->with('danger', 'При збереженні сталася помилка, подробиці дивіться нижче');

            }

            $business_profile = User::where('id', $business->user_id)->withTrashed()->first();
            $business_profile->first_name = $request->first_name;
            $business_profile->last_name = $request->last_name;
            $business_profile->phone = $request->phone;
            $business_profile->email = $request->email;
            $business_profile->address = $request->address;
            $business_profile->save();

            return redirect()->back()->with('success', 'Дані успішно збережені');

        }


    }
