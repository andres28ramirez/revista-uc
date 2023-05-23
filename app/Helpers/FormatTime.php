<?php
namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;

class FormatTime {

    public static function LongTimeFilter($date) {
        if ($date == null) {
            if(App::isLocale('en'))
                return "Without date";
            else
                return "Sin fecha";
        }

        $start_date = $date;
        $since_start = $start_date->diff(new \DateTime(date("Y-m-d") . " " . date("H:i:s")));

        if ($since_start->y == 0) {
            if ($since_start->m == 0) {
                if ($since_start->d == 0) {
                    if ($since_start->h == 0) {
                        if ($since_start->i == 0) {
                            if ($since_start->s == 0) {
                                $result = App::isLocale('en') ? $since_start->s .' seconds' : $since_start->s .' segundos';
                            } else {
                                if ($since_start->s == 1) {
                                    $result = App::isLocale('en') ? $since_start->s .' second' : $since_start->s .' segundo';
                                } else {
                                    $result = App::isLocale('en') ? $since_start->s .' seconds' : $since_start->s .' segundos';
                                }
                            }
                        } else {
                            if ($since_start->i == 1) {
                                $result = App::isLocale('en') ? $since_start->i .' minute' : $since_start->i .' minuto';
                            } else {
                                $result = App::isLocale('en') ? $since_start->i .' minutes' : $since_start->i .' minutos';
                            }
                        }
                    } else {
                        if ($since_start->h == 1) {
                            $result = App::isLocale('en') ? $since_start->h .' hour' : $since_start->h .' hora';
                        } else {
                            $result = App::isLocale('en') ? $since_start->h .' hours' : $since_start->h .' horas';
                        }
                    }
                } else {
                    if ($since_start->d == 1) {
                        $result = App::isLocale('en') ? $since_start->d .' day' : $since_start->d .' día';
                    } else {
                        $result = App::isLocale('en') ? $since_start->d .' days' : $since_start->d .' días';
                    }
                }
            } else {
                if ($since_start->m == 1) {
                    $result = App::isLocale('en') ? $since_start->m .' month' : $since_start->m .' mes';
                } else {
                    $result = App::isLocale('en') ? $since_start->m .' months' : $since_start->m .' meses';
                }
            }
        } else {
            if ($since_start->y == 1) {
                $result = App::isLocale('en') ? $since_start->y .' year' : $since_start->y .' año';
            } else {
                $result = App::isLocale('en') ? $since_start->y .' years' : $since_start->y .' años';
            }
        }

        return App::isLocale('en') ? $result . " ago" : "Hace " . $result;
    }
}
