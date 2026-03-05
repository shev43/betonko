<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\SoftDeletes;

    class BusinessFactories extends Model {
        use HasFactory;
        use SoftDeletes;

        public function contacts() {
            return $this->hasMany(BusinessContacts::class, 'business_id', 'business_id');
        }

        public function products() {
            return $this->hasMany(BusinessProducts::class, 'factories_id', 'id');

        }

        public function product() {
            return $this->hasOne(BusinessProducts::class, 'factories_id', 'id');

        }

        public function business() {
            return $this->belongsTo(Business::class);
        }

        public function reports() {
            return $this->hasMany(Report::class, 'technic_id', 'id');
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
