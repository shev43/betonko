<?php

namespace App\Http\Controllers\Amicms\v1;

use App\Http\Controllers\AmicmsController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UsersController extends AmicmsController {
    private $layout = [];
    private $phone;

    public function __construct() {
        $this->is_profile_auth();
        $this->layout['title'] = 'Адміністратори';

    }

    public function index() {
        $users_array = User::where('account_type', 1)->withTrashed()->paginate(env('AMICMS_PER_PAGE'));
        return view('amicms.users.index', ['layout' => $this->layout, 'users_array' => $users_array]);

    }

    public function create() {
        return view('amicms.users.create', ['layout' => $this->layout]);

    }

    public function store(Request $request) {
        $this->phone = str_replace([' ', '-', '+', '(', ')'], '', $request->get('phone'));
        $request->merge([
            'phone' => $this->phone,
        ]);

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => ['required', Rule::unique('users')],
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('danger', 'При збереженні сталася помилка, подробиці дивіться нижче');
        }


        $latestEntry = User::get();

        $user = new User();
        $user->account_type = 1;
        $user->profile_number = str_pad(($latestEntry) ? count($latestEntry) + 1 : 1, 8, "0", STR_PAD_LEFT);
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->phone = $request->phone ?? null;
        $user->email = $request->email;
        $user->save();

        return redirect()->route('amicms::users.index')->with('success', 'Дані успішно збережені');

    }

    public function edit($user_id) {
        $user = User::find($user_id);
        return view('amicms.users.edit', ['layout' => $this->layout, 'user' => $user]);

    }

    public function update(Request $request, $user_id) {
        $this->phone = str_replace([' ', '-', '+', '(', ')'], '', $request->get('phone'));
        $request->merge([
            'phone' => $this->phone,
        ]);

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => ['required', Rule::unique('users')->ignore($user_id)],

        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('danger', 'При збереженні сталася помилка, подробиці дивіться нижче');

        }

        $user = User::find($user_id);
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->phone = $request->phone ?? null;
        $user->email = $request->email;
        $user->save();


        return redirect()->route('amicms::users.index')->with('success', 'Дані успішно збережені');

    }

    public function destroy($user_id) {
        User::find($user_id)->delete();
        return redirect()->route('amicms::users.index')->with('success', 'Дані успішно видалені');

    }

    public function destroyWithTrash($user_id) {
        User::onlyTrashed()->find($user_id)->forceDelete();
        return redirect()->route('amicms::users.index')->with('success', 'Дані успішно видалені');

    }

    public function restore($user_id) {
        User::onlyTrashed()->find($user_id)->restore();
        return redirect()->route('amicms::users.index')->with('success', 'Дані успішно відновлено');

    }
}
