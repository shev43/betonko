<?php

    namespace App\Models;

    use Carbon\Carbon;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Subscription extends Model {
        use HasFactory;

        public function isActive(): bool {
            if(empty($this->active_to)) {
                return false;
            }
            $today = Carbon::now()->endOfDay();
            $activeTo = Carbon::parse($this->active_to)->endOfDay();
            return $today->lessThanOrEqualTo($activeTo);

        }

        public function seller() {
            return $this->hasOne(User::class, 'id', 'seller_id');
        }

        public function business() {
            return $this->hasOne(Business::class, 'id', 'business_id');
        }


    }
