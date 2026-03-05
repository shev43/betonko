<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use function request;

    class Order extends Model {
        use HasFactory;

        public function client() {
            return $this->hasOne(User::class, 'id', 'client_id');
        }

        public function seller() {
            return $this->hasOne(User::class, 'id', 'seller_id');
        }

        public function offer() {
            return $this->hasOne(Offer::class, 'order_id', 'id')->where('seller_id', request()->user()->id);
        }

        public function offers() {
            return $this->hasMany(Offer::class, 'order_id', 'id')->with('factory', 'seller');
        }

        public function active_offers() {
            return $this->hasMany(Offer::class, 'order_id', 'id')->where('status', '!=', 'canceled')->with('factory', 'seller');
        }

        public function getPhoneFormattedAttribute() {
            $phone = preg_replace("/[^0-9]/","", $this->phone); //Remove all non-numers
            return '+' . substr($phone,0,2).' ('.substr($phone,2,3).') '.substr($phone,5,3).'-'.substr($phone,8,2).'-'.substr($phone,10,2);

        }

    }
