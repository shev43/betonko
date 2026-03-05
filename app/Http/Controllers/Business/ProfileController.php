<?php

    namespace App\Http\Controllers\Business;

    use App\Helper\UploadFile;
    use App\Http\Controllers\Controller;
    use App\Models\Notification;
    use App\Models\NotificationMessage;
    use App\Models\Subscription;
    use App\Models\User;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Hash;
    use Illuminate\Support\Facades\Validator;

    class ProfileController extends Controller {

        use UploadFile;

        protected $phone;

        public function __construct() {

        }

        public function index() {
            $profile = User::find(\request()->user()->id);
            $subscription = Subscription::where('seller_id', \request()->user()->id)->latest()->first();
            return view('business.settings.profile.index', ['profile' => $profile, 'subscription' => $subscription]);

        }

        public function update(Request $request) {
            $validator = Validator::make($request->all(), [
                'first_name' => 'required|max:255', 'last_name' => 'required|max:255', 'phone' => 'required',
                'email' => 'required', 'password' => 'nullable|min:8',
                'password_confirmation' => 'nullable|same:password|min:8',]);
            if($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput()->with('danger', 'При сохранении произошла ошибка, подробности смотрите ниже');

            }

            $this->phone = str_replace([' ', '-', '+', '(', ')'], '', $request->get('phone'));
            $profile = User::find(\request()->user()->id);
            $profile->first_name = $request->first_name;
            $profile->last_name = $request->last_name;

            if($profile->email !== $request->email) {
                $notificationText = NotificationMessage::select('id')->where('action','business.email.changed')->first();
                $notification = new Notification;
                $notification->user_id = $profile->id;
                $notification->notification_messages_id = $notificationText->id;
                $notification->is_customer = 0;
                $notification->is_sendmail = 0;
                $notification->is_new = 1;
                $notification->save();

                $profile->email = $request->email;
            }

            if($profile->phone !== $this->phone) {
                $notificationText = NotificationMessage::select('id')->where('action','business.phone.changed')->first();
                $notification = new Notification;
                $notification->user_id = $profile->id;
                $notification->notification_messages_id = $notificationText->id;
                $notification->is_customer = 0;
                $notification->is_sendmail = 0;
                $notification->is_new = 1;
                $notification->save();

                $profile->phone = $this->phone;
            }

            $profile->photo = ($request->photo ?? null);

            if(!empty($request->password)) {
                $notificationText = NotificationMessage::select('id')->where('action','business.password.changed')->first();
                $notification = new Notification;
                $notification->user_id = $profile->id;
                $notification->notification_messages_id = $notificationText->id;
                $notification->is_customer = 0;
                $notification->is_sendmail = 0;
                $notification->is_new = 1;
                $notification->save();

                $profile->password = Hash::make($request->password);
            }

            $profile->save();
            return redirect()->route('business::setting.profile.index', ['lang' => app()->getLocale()])->with('success', 'Success');
        }

        public function uploadFile(Request $request) {
            if($file = $request->file('photo')) {
                $photo = $this->uploadPhoto($file, 'users', 300, 300);
                return $photo;
            }
        }

        public function removeFile(Request $request) {
            $srcPath = public_path('storage/users/' . $request->filename);
            if(file_exists($srcPath) && !empty($request->filename)) {
                $user = User::where('photo', $request->filename)->first();
                if($user) {
                    $user->photo = null;
                    $user->save();
                }
                unlink($srcPath);
                return true;
            }

        }

    }
