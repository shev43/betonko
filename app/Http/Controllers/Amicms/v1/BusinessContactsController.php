<?php

namespace App\Http\Controllers\Amicms\v1;

use App\Http\Controllers\AmicmsController;
use App\Models\BusinessContacts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BusinessContactsController extends AmicmsController
{
    private $layout = [];

    public function __construct() {
        $this->is_profile_auth();
        $this->layout['title'] = 'Підприємства';

    }

    public function index($business_id) {
        $contacts_array = BusinessContacts::where('business_id', $business_id)->withTrashed()->paginate(env('AMICMS_PER_PAGE'));
        return view('amicms.business.contacts.index', ['layout' => $this->layout, 'business_id' => $business_id, 'contacts_array' => $contacts_array]);

    }

    public function create($business_id) {
        return view('amicms.business.contacts.create', ['layout' => $this->layout, 'business_id' => $business_id]);

    }

    public function store(Request $request, $business_id) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'phone' => 'required',
            'position' => 'required',

        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('danger', 'При збереженні сталася помилка, подробиці дивіться нижче');

        }

        $contacts = new BusinessContacts;
        $contacts->business_id = $business_id;
        $contacts->name = $request->name;
        $contacts->phone = str_replace([' ', '-', '+', '(', ')'], '', $request->get('phone'));
        $contacts->position = $request->position;
        $contacts->save();

        return redirect()->route('amicms::business.contacts.index', ['business_id'=>$business_id])->with('success', 'Дані успішно збережені');

    }

    public function edit($business_id, $contact_id) {
        $contact = BusinessContacts::find($contact_id);

        return view('amicms.business.contacts.edit', ['layout' => $this->layout, 'business_id' => $business_id, 'contact'=>$contact]);

    }

    public function update(Request $request, $business_id, $contact_id) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'phone' => 'required',
            'position' => 'required',

        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('danger', 'При збереженні сталася помилка, подробиці дивіться нижче');

        }

        $contact = BusinessContacts::find($contact_id);
        $contact->name = $request->name;
        $contact->phone = str_replace([' ', '-', '+', '(', ')'], '', $request->get('phone'));
        $contact->position = $request->position;
        $contact->save();

        return redirect()->route('amicms::business.contacts.index', ['business_id'=>$business_id])->with('success', 'Дані успішно збережені');

    }

    public function destroy($business_id, $contact_id) {
        $contact = BusinessContacts::find($contact_id);
        $contact->delete();
        return redirect()->route('amicms::business.contacts.index', ['business_id'=>$business_id])->with('success', 'Дані успішно видалені');

    }

    public function destroyWithTrash($business_id, $contact_id) {
        BusinessContacts::onlyTrashed()->find($contact_id)->forceDelete();
        return redirect()->route('amicms::business.contacts.index', ['business_id'=>$business_id])->with('success', 'Дані успішно видалені');

    }

    public function restore($business_id, $contact_id) {
        BusinessContacts::onlyTrashed()->find($contact_id)->restore();
        return redirect()->route('amicms::business.contacts.index', ['business_id'=>$business_id])->with('success', 'Дані успішно відновлено');

    }


}
