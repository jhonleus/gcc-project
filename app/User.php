<?php

namespace App;

use DB;
use Carbon\Carbon;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail 
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table   = 'users';
    protected $fillable = [
        'firstName', 'lastName', 'username', 'rolesId', 'email', 'password', 'isActive',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function ratings()
    {
        return $this->hasMany(EmployerRatings::class, 'employer_id');
    }

    public function employerdetails()
    {
        return $this->hasOne(EmployerDetail::class, 'usersId');
    }

    public function details()
    {
        return $this->hasOne(UserDetail::class, 'usersId');
    }

    public function hobbies()
    {
        return $this->hasMany(UserHobby::class, 'usersId');
    }

    public function location()
    {
        return $this->hasMany(UserPrelocation::class, 'usersId');
    }

    public function specialization()
    {
        return $this->hasMany(UserPreSpecialization::class, 'usersId');
    }

    public function contacts()
    {
        return $this->hasOne(UserContact::class, 'usersId');
    }

    public function address()
    {
        return $this->hasOne(UserAddress::class, 'usersId');
    }

    public function skills()
    {
        return $this->hasOne(UserSkill::class, 'usersId');
    }

    public function roles()
    {
        return $this->hasOne(ExtraRole::class, 'id', 'rolesId');
    }

    public function employer()
    {
        return $this->hasOne(EmployerDetail::class, 'usersId');
    }

    public function school()
    {
        return $this->hasOne(SchoolDetail::class,'usersId');
    }

      public function industry()
    {
        return $this->hasMany(ExtraIndustry::class, 'id');
    }

       public function country()
    {
        return $this->hasMany(ExtraCountry::class, 'id','name');
    }

    // public function specializationame()
    // {
    //     return $this->hasMany(ExtraSpecialization::class, 'id','name');
    // }

    public function documents() {
        return $this->hasMany(UserDocument::class, 'usersId', 'id');
    }

    public function works() {
        return $this->hasMany(UserWork::class, 'usersId', 'id');
    }

    public function educations() {
        return $this->hasMany(UserEducation::class, 'usersId', 'id');
    }

    public function applications() {
        return $this->hasMany(UserApplication::class, 'usersId', 'id');
    }

    public function tattoos() {
        return $this->hasMany(UserDocument::class, 'usersId', 'id')->where("filetype", "tattoo")->get();
    }

    public function certificates() {
        return $this->hasMany(UserCertification::class, 'usersId', 'id')
            ->where(function ($query) {
                $query->where('type', "N1")
                      ->orWhere('type', "N2")
                      ->orWhere('type', "N3")
                      ->orWhere('type', "N4")
                      ->orWhere('type', "N5")
                      ->orWhere('type', "Others");
            })->get();
    }

    public function levels() {
        return $this->hasMany(UserCertification::class, 'usersId', 'id');
    }

    public function partners() {
        return SubscriberPartner::where(function ($query) {
                $query->where('usersId', $this->id)
                      ->orWhere('companyId', $this->id);
            })->where("isActive", 1)->get();
    }

    public function branches() {
        return SubscriberBranch::where(function ($query) {
                $query->where('usersId', $this->id)
                      ->orWhere('companyId', $this->id);
            })->where("isActive", 1)->get();
    }

    public function affilations() {
        return SubscriberAffilation::where(function ($query) {
                $query->where('usersId', $this->id)
                      ->orWhere('companyId', $this->id);
            })->where("isActive", 1)->get();
    }

    public function subscriber() 
    {
        $now =  Carbon::now()->format('Y-m-d');
        return SubscriptionDetails::with("subscription")
                ->where('usersId', $this->id)
                ->where("last_day", ">", $now)
                ->orderBy('id', 'desc')->first();
    }

    public function average() {
        $result =  $this->hasOne(SubscriberRatings::class, 'companyId', 'id')->select(DB::raw('avg(overall) average'))->groupBy('companyId')->first();

        if(!empty($result)) {
            return $result->average;
        }
        else {
            return 0;
        }
    }
}
