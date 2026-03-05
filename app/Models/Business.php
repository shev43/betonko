<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\SoftDeletes;

    /**
     * Class Business
     *
     * @package App\Models
     */
    class Business extends Model {
        use HasFactory;
        use SoftDeletes;

        public function factories() {
            return $this->hasMany(BusinessFactories::class, 'business_id', 'id');
        }

        public function contacts() {
            return $this->hasMany(BusinessContacts::class, 'business_id', 'id');
        }

        public function products() {
            return $this->hasMany(BusinessProducts::class, 'business_id', 'id');
        }

        public function seller() {
            return $this->hasOne(User::class, 'id', 'user_id');
        }

        public function subscription() {
            return $this->hasOne(Subscription::class, 'business_id', 'id')->latest();
        }

        public function subscription_history() {
            return $this->hasManyThrough(SubscriptionHistory::class, Subscription::class)->orderByDesc('created_at');
        }

        public function getPhoneFormattedAttribute() {
            $phone = preg_replace("/[^0-9]/","", $this->phone); //Remove all non-numers
            return '+' . substr($phone,0,2).' ('.substr($phone,2,3).') '.substr($phone,5,3).'-'.substr($phone,8,2).'-'.substr($phone,10,2);

        }

        public function getPhoneSmallAttribute() {
            $phone = preg_replace("/[^0-9]/","", $this->phone); //Remove all non-numers
            return '+' . substr($phone,0,2).' ('.substr($phone,2,3).') ***-**-**';

        }



    }
