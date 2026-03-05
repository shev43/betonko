<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\SoftDeletes;

    class BusinessProducts extends Model {
        use HasFactory;
        use SoftDeletes;

        public function factory() {
            return $this->belongsTo(BusinessFactories::class, 'factories_id', 'id')->with(['contacts', 'business']);
        }

        public function factories() {
            return $this->hasMany(BusinessFactories::class, 'business_id', 'business_id');
        }

        public function business() {
            return $this->hasOne(Business::class, 'id', 'business_id');
        }

    }
