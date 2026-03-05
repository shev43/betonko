<?php

    namespace App\Http\Controllers\Business;

    use App\Helper\UploadFile;
    use App\Http\Controllers\Controller;
    use App\Models\Business;
    use App\Models\BusinessContacts;
    use App\Models\Notification;
    use App\Models\NotificationMessage;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Validator;

    class ContactsController extends Controller {
        use UploadFile;

        protected $phone;

        public function __construct() {

        }

        public function index() {
            $business = Business::where('user_id', \request()->user()->id)->first();
            $contacts = BusinessContacts::where('business_id', $business->id)->paginate(env('PER_PAGE', 20));
            if(empty($contacts)) {
                return $this->create();
            }
            return view('business.settings.contacts.index', ['contacts' => $contacts]);

        }

        public function create() {
            return view('business.settings.contacts.create');

        }

        public function store(Request $request) {
            $business = Business::where('user_id', \request()->user()->id)->first();
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255', 'position' => 'required|max:255', 'phone' => 'required',]);
            if($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput()->with('danger', 'При сохранении произошла ошибка, подробности смотрите ниже');

            }
            $this->phone = str_replace([' ', '-', '+', '(', ')'], '', $request->get('phone'));
            $contact = new BusinessContacts;
            $contact->business_id = $business->id;
            $contact->name = $request->name;
            $contact->photo = ($request->photo ?? null);
            $contact->position = $request->position;
            $contact->phone = $this->phone;
            $contact->save();

            $notificationText = NotificationMessage::select('id')->where('action', 'business.contact.adding')->first();
            $notification = new Notification;
            $notification->user_id = request()->user()->id;
            $notification->business_id = $contact->business_id;
            $notification->business_contacts_id = $contact->id;
            $notification->notification_messages_id = $notificationText->id;
            $notification->is_customer = 0;
            $notification->is_sendmail = 0;
            $notification->is_new = 1;
            $notification->save();

            return redirect()->route('business::setting.contacts.index', ['lang' => app()->getLocale()])->with('success', 'Success');

        }

        public function edit($lang, $contact_id) {
            $contact = BusinessContacts::find($contact_id);
            return view('business.settings.contacts.edit', ['contact' => $contact]);

        }

        public function update(Request $request, $lang, $contact_id) {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255', 'position' => 'required|max:255', 'phone' => 'required',]);
            if($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput()->with('danger', 'При сохранении произошла ошибка, подробности смотрите ниже');

            }
            $this->phone = str_replace([' ', '-', '+', '(', ')'], '', $request->get('phone'));
            $contact = BusinessContacts::find($contact_id);
            $contact->name = $request->name;
            $contact->photo = ($request->photo ?? null);
            $contact->position = $request->position;
            $contact->phone = $this->phone;
            $contact->save();

            $notificationText = NotificationMessage::select('id')->where('action', 'business.contact.edited')->first();
            $notification = new Notification;
            $notification->user_id = request()->user()->id;
            $notification->business_id = $contact->business_id;
            $notification->business_contacts_id = $contact->id;
            $notification->notification_messages_id = $notificationText->id;
            $notification->is_customer = 0;
            $notification->is_sendmail = 0;
            $notification->is_new = 1;
            $notification->save();

            return redirect()->route('business::setting.contacts.index', ['lang' => $lang])->with('success', 'Success');

        }

        public function destroy($lang, $contact_id) {
            $contact = BusinessContacts::find($contact_id);

            $notificationText = NotificationMessage::select('id')->where('action', 'business.contact.deleted')->first();
            $notification = new Notification;
            $notification->user_id = request()->user()->id;
            $notification->business_id = $contact->business_id;
            $notification->business_contacts_id = $contact->id;
            $notification->notification_messages_id = $notificationText->id;
            $notification->is_customer = 0;
            $notification->is_sendmail = 0;
            $notification->is_new = 1;
            $notification->save();

            $contact->delete();
            return redirect()->route('business::setting.contacts.index', ['lang' => $lang])->with('success', 'Success');

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
                $user = BusinessContacts::where('photo', $request->filename)->first();
                if($user) {
                    $user->photo = null;
                    $user->save();
                }
                unlink($srcPath);
                return true;
            }

        }

    }
