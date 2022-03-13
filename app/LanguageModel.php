<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class LanguageModel extends Model
{
    public static function locale() {
        // GET ALL LANGUAGE
        $locales = DB::table('maintenance_locales')->get();

        // CHECK IF USER EXISTS CHANGED LANGUAGE
        $check_locale = UserLocale::where('token', csrf_token())->first();
 
        // GET TITLE FROM SELECTED LANGUAGE
        $title = "";
        foreach($locales as $locale) { 
            if ($locale->id == 1) {
                if ($check_locale) {
                    if ($check_locale->token == csrf_token()) {
                        if ($check_locale->locale == 1) {
                            $title = $locale->name;
                        } else { 
                            $title = $locale->translated;
                        }
                    } else { 
                        $title = $locale->name;
                    }
                } else { 
                    $title = $locale->name;
                }
            }
        }

        return array($title, $locales, $check_locale);
    }
}
