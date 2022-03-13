<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\UserLocale;
use App\MaintenanceLocale;

class MaintenanceLocale extends Model
{
    public static function getLocale($id) {

        $locales = MaintenanceLocale::get();
        $check_locale = UserLocale::where('token', csrf_token())->first();
        $get_locale = '';

        foreach($locales as $locale) {

            if ($locale->id == $id) {
                if ($check_locale) {
                    if ($check_locale->token == csrf_token()) {
                        if ($check_locale->locale == 1) {
                            $get_locale = $locale->name;
                        } else {
                            $get_locale = $locale->translated;
                        }
                    } else {
                        $get_locale = $locale->name;
                    }
                } else {
                    $get_locale = $locale->name;
                }
            }

        }

        return $get_locale;
    }
}
