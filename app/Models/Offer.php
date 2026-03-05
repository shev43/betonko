<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Offer extends Model {
        use HasFactory;

        public function order() {
            return $this->belongsTo(Order::class, 'order_id', 'id')->with(['client', 'seller']);
        }

        public function factory() {
            return $this->hasOne(BusinessFactories::class, 'id', 'factory_id')->with('business');
        }

        public function seller() {
            return $this->hasOne(User::class, 'id', 'seller_id');
        }

    }
