<?php

use App\Models\WeeklyClass;
use Carbon\Carbon;
use Webpatser\Uuid\Uuid;

if (!function_exists('generate_field_id_by_title')) {
    function generate_field_id_by_title($title)
    {
        return str_replace([' ', '-'], '_', strtolower($title));
    }
}

if (!function_exists('format_time')) {
    function format_time($time, $is_date = true)
    {
        $format = 'd M,Y';
        if (!$is_date) {
            $format = 'D d M, h:i A';
        }
        return \Carbon\Carbon::parse($time)->format($format);
    }
}

if (!function_exists('beautify_slug')) {
    function beautify_slug($slug)
    {
        return ucwords(str_replace(['-', '_'], ' ', $slug));
    }
}

if (!function_exists('slugify')) {
    function slugify($text, string $divider = '-')
    {
        // replace non letter or digits by divider
        $text = preg_replace('~[^\pL\d]+~u', $divider, $text);
        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);
        // trim
        $text = trim($text, $divider);
        // remove duplicate divider
        $text = preg_replace('~-+~', $divider, $text);
        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return '';
        }

        return $text;
    }
}

if (!function_exists('generate_profile_picture_by_name')) {
    function generate_profile_picture_by_name($name, $size = 47, $font = 18, $color = '#0A5CD6', $background = '#EBF4FF')
    {
        $words = explode(" ", $name);
        $acronym = "";
        foreach ($words as $w) {
            $acronym .= @$w[0];
        }

        return '<div class="align-items-center d-flex justify-content-center rounded-circle user-profileImg"
                 style="background-color:' . $background . '; color:' . $color . ';height:' . $size . 'px;width:' . $size . 'px;font-size:' . $font . 'px">
                    ' . strtoupper(substr($acronym, 0, 2)) . '
                </div>';

        /*$url = \App\Classes\AlQuranConfig::UI_AVATAR_URL.'?name='.$name.'&color='.$color.'&background='.$background;
        return image_html_generator($url, 'Profile Picture', $height,  $width, false, 'rounded-circle');*/
    }
}

if (!function_exists('get_icon_of_resource_file')) {
    function get_icon_of_resource_file($name)
    {

        $img_url = '';
        $name = strtolower($name);
        if (in_array($name, ['pdf', 'png', 'docx', 'txt', 'jpg', 'jpeg', 'dox', 'pptx', 'ppt', 'word'])) {
            $img_url = asset('images/file/' . $name . '.svg');
        } else {
            $img_url = asset('images/file/file.svg');
        }
        return $img_url;
        // switch (($name)) {
        //     case 'docx': {
        //             $img_url = asset('images/file/' . $name . '.svg');
        //             break;
        //         }
        //     case 'dox': {
        //             $img_url = asset('images/file/' . $name . '.svg');
        //             break;
        //         }
        //     case 'pdf': {

        //             $img_url = asset('images/file/' . $name . '.svg');
        //             break;
        //         }
        //         case 'jpeg': {
        //             $img_url = asset('images/file/' . $name . '.svg');
        //             break;
        //         }
        //         case 'jpg': {
        //             $img_url = asset('images/file/' . $name . '.svg');
        //             break;
        //         }
        //         case 'txt': {

        //             $img_url = asset('images/file/' . $name . '.svg');
        //             break;
        //         }
        //         case 'png': {

        //             $img_url = asset('images/file/' . $name . '.svg');
        //             break;
        //         }
        //     case 'pptx': {

        //             $img_url = asset('images/file/' . $name . '.svg');
        //             break;
        //         }

        //     default: {
        //             $img_url = asset('images/file/file.svg');
        //             break;
        //         }
        // }

        // return $img_url;
    }
}


if (!function_exists('settings')) {
    function settings($key = null, $require_active = true, $default = null)
    {
        if (!empty($key)) {
            try {
                $setting = \App\Models\Setting::where('key', $key);
                if ($require_active) {
                    $setting = $setting->where('status', \App\Classes\Enums\StatusEnum::Active);
                }
                $value = $setting->value('value');

                return !empty($value) ? $value : $default;
            } catch (Exception $exception) {
                return $default;
            }
        }
        return null;
    }
}

if (!function_exists('image_html_generator')) {
    function image_html_generator($img, $alt = null, $height = null, $width = null, $lazy = true, $class = '', $id = '')
    {

        if ($lazy) {
            $html = '<img
            ' . (!is_null($height) ? 'height="' . $height . 'px"' : '') . '
            ' . (!is_null($width) ? 'width="' . $width . 'px"' : '') . '
            src="' . asset('landb/defaultLogo.png') . '"
            alt="' . (!is_null($alt) ? $alt : 'Product image') . '"
            loading="lazy"
            class="lazyload ' . $class . '"
            id="' . $id . '"
            data-src="' . (!empty($img) ? $img : asset('images/profile-add.svg')) . '"
            onerror = "this.src=\'' . asset('images/profile-add.svg') . '\'">';
        } else {
            $html = '<img
            ' . (!is_null($height) ? 'height="' . $height . 'px"' : '') . '
            ' . (!is_null($width) ? 'width="' . $width . 'px"' : '') . '
            src="' . $img . '"
            alt="' . (!is_null($alt) ? $alt : 'Alquran image') . '"
            class="' . $class . '"
            id="' . $id . '">';
        }



        return $html;
    }
}

if (!function_exists('generate_notification_by_type')) {
    function generate_notification_by_type($type, $params = [], $extras = [])
    {
        try {
            $insert = array_merge(['type' => $type, 'json' => json_encode($extras)], $params);
            \App\Models\Notification::create($insert);
            return true;
        } catch (Exception $e) {
            return false;
        }
        /*$html = '';
        if(\Illuminate\Support\Facades\View::exists('notifications.'.$type)){
            $html = view('notifications.'.$type, compact('params', 'extras'))->render();
        }

        if(!empty($html)){
            $insert = array_merge(['type' => $type, 'html' => $html], $params);
            \App\Models\Notification::create($insert);
        }*/
    }
}

if (!function_exists('getFilters')) {
    function getFilters($request)
    {
        $where = array();
        foreach ($request->except('page') as $key => $value) {
            if (!empty($value)) {
                if (is_numeric($value)) {
                    $where[] = ['id', '=', $value];
                } else if ($key == 'user_type') {
                    $where[] = [$key, '=', $value];
                } else {
                    $where[] = [$key, 'LIKE', '%' . $value . '%'];
                }
            }
        }
        //dd($where);
        return $where;
    }
}

if (!function_exists('applyWheres')) {
    function applyWheres($model, $where)
    {
        foreach ($where as $field => $value) {
            if (is_array($value)) {
                //dd($value);
                [$field, $condition, $val] = $value;
                switch (strtoupper($condition)) {
                    case 'IN':
                        $model = $model->whereIn($field, $val);
                        break;
                    case 'NOT_IN':
                        $model = $model->whereNotIn($field, $val);
                        break;
                    case 'OR_WHERE':
                        $model = $model->orWhere($field, $value);
                    default:
                        $model = $model->where($field, $condition, $val);
                        break;
                }
            } else {
                $model = $model->where($field, $value);
            }
        }
        return $model;
    }
}

if (!function_exists('humanFileSize')) {
    function humanFileSize($size, $unit = "")
    {
        if ((!$unit && $size >= 1 << 30) || $unit == "GB")
            return number_format($size / (1 << 30), 2) . "GB";
        if ((!$unit && $size >= 1 << 20) || $unit == "MB")
            return number_format($size / (1 << 20), 2) . "MB";
        if ((!$unit && $size >= 1 << 10) || $unit == "KB")
            return number_format($size / (1 << 10), 2) . "KB";
        return number_format($size) . " bytes";
    }
}



if (!function_exists('generate_permission_slug')) {
    function generate_permission_slug($module, $action = 'view')
    {
        $action = filter_page_by_type($action);
        return slugify($action . '-' . $module);
    }
}


if (!function_exists('filter_page_by_type')) {
    function filter_page_by_type($action)
    {
        switch ($action) {
            case 'create':
            case 'save':
                return 'add';
                break;
            case 'edit':
            case 'update':
                return 'edit';
                break;
            case 'destroy':
                return 'delete';
                break;
            case 'list':
                return 'view';
                break;
            default:
                return 'view';
                break;
        }
    }
}

if (!function_exists('convertTimeToUTCzone')) {
    function convertTimeToUTCzone($str, $userTimezone = 'UTC', $format = 'D d M, h:i A')
    {
        $new_str = new DateTime($str, new DateTimeZone($userTimezone));
        $new_str->setTimeZone(new DateTimeZone('UTC'));
        return \Carbon\Carbon::parse($new_str);
    }
}

if (!function_exists('convertTimeToUSERzone')) {
    //this function converts string from UTC time zone to current user timezone
    function convertTimeToUSERzone($str, $userTimezone = 'UTC', $fromTimeZone = 'UTC', $format = 'D d M, h:i A')
    {
        if (empty($str)) {
            return '';
        }
        if (empty($userTimezone)) {
            $userTimezone = 'UTC';    // because we don't set timzone for the customer 
        }

        $new_str = new DateTime($str, new DateTimeZone($fromTimeZone));
        $new_str->setTimeZone(new DateTimeZone($userTimezone));
        return \Carbon\Carbon::parse($new_str);
    }
}


if (!function_exists('ip_info')) {
    function ip_info($ip = NULL, $purpose = "location", $deep_detect = TRUE)
    {
        $output = NULL;
        if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
            $ip = $_SERVER["REMOTE_ADDR"];
            if ($deep_detect) {
                if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
                    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
                    $ip = $_SERVER['HTTP_CLIENT_IP'];
            }
        }
        $purpose    = str_replace(array("name", "\n", "\t", " ", "-", "_"), NULL, strtolower(trim($purpose)));
        $support    = array("country", "countrycode", "state", "region", "city", "location", "address");
        $continents = array(
            "AF" => "Africa",
            "AN" => "Antarctica",
            "AS" => "Asia",
            "EU" => "Europe",
            "OC" => "Australia (Oceania)",
            "NA" => "North America",
            "SA" => "South America"
        );
        if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
            $ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
            if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
                switch ($purpose) {
                    case "location":
                        $output = array(
                            "city"           => @$ipdat->geoplugin_city,
                            "state"          => @$ipdat->geoplugin_regionName,
                            "country"        => @$ipdat->geoplugin_countryName,
                            "country_code"   => @$ipdat->geoplugin_countryCode,
                            "continent"      => @$continents[strtoupper($ipdat->geoplugin_continentCode)],
                            "continent_code" => @$ipdat->geoplugin_continentCode
                        );
                        break;
                    case "address":
                        $address = array($ipdat->geoplugin_countryName);
                        if (@strlen($ipdat->geoplugin_regionName) >= 1)
                            $address[] = $ipdat->geoplugin_regionName;
                        if (@strlen($ipdat->geoplugin_city) >= 1)
                            $address[] = $ipdat->geoplugin_city;
                        $output = implode(", ", array_reverse($address));
                        break;
                    case "city":
                        $output = @$ipdat->geoplugin_city;
                        break;
                    case "state":
                        $output = @$ipdat->geoplugin_regionName;
                        break;
                    case "region":
                        $output = @$ipdat->geoplugin_regionName;
                        break;
                    case "country":
                        $output = @$ipdat->geoplugin_countryName;
                        break;
                    case "countrycode":
                        $output = @$ipdat->geoplugin_countryCode;
                        break;
                }
            }
        }
        $output = !empty($output) ? $output : '--';
        return $output;
    }
}



if (!function_exists('get_client_ip')) {
    function get_client_ip()
    {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if (isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = '--';
        return $ipaddress;
    }
}


if (!function_exists('convert_slot_to_time')) {
    function convert_slot_to_time($slot, $timezone = NULL, $format = 'h:i A')
    {
        // kisi b timezone ka today rat 12 e hota 
        if (is_null($timezone))
            $timezone = config('app.timezone');
        return  Carbon::today($timezone)->addMinutes($slot * 30)->format($format);    // get today date with 12:00 aM time and then add minutes like 1*30=30 -> 12:30 
    }
}

if (!function_exists('convert_slot_to_time_of_a_date')) {
    function convert_slot_to_time_of_a_date($date, $slot, $format = 'h:i A')
    {
        return  Carbon::parse($date)->addMinutes($slot * 30)->format($format);    // get today date with 12:00 aM time and then add minutes like 1*30=30 -> 12:30 
    }
}



if (!function_exists('get_24_hour_timeslots')) {
    function get_24_hour_timeslots($format = true, $slot_id = null)
    {
        // returns us 48 slots with difference of 30 mins
        //$teacher_time = convertTimeToUSERzone(\Carbon\Carbon::now(),$timezoneB);
        $period = new \Carbon\CarbonPeriod('00:00', \App\Classes\AlQuranConfig::TimeSlot . ' minutes', '24:00'); // for create use 24 hours format later change format
        //format later change format
        $slots = [];
        foreach ($period as $item) {
            array_push($slots, $format ? $item->format("h:i A") : $item);
        }

        if (!is_null($slot_id)) {
            return isset($slots[$slot_id]) ? $slots[$slot_id]->format("h:i A") : null;
        }
        return $slots;
    }
}


if (!function_exists('convert_student_schedule')) {
    function convert_student_schedule($student)
    {
        $schedule = array();
        $student_schedule = $student->routine_classes;
        foreach ($student_schedule as $sch) {
            $day = get_current_week()[$sch->availability_slot->day->day_id];
            $slot = $sch->availability_slot->slot_id;
            // $teacherTz = $student->teacher->availability->timezone;
            $teacherTz = $student->teacher->timezone;


            $time = get_24_hour_timeslots(true)[$slot];
            $teacherTime = \Carbon\Carbon::parse($day->format('Y-m-d ') . $time, $teacherTz);

            $studentTime = convertTimeToUSERzone($teacherTime, $student->timezone, $teacherTz);
            $sch->studentTime = $studentTime;
            $schedule[$studentTime->format('w')][] = $sch;
        }
        return $schedule;
    }
}


if (!function_exists('convert_teacher_availability_to_student_timezone')) {
    function convert_teacher_availability_to_student_timezone($student, $teacher)
    {
        $schedule = array();
        $teacher_availabilit_slots = $teacher->availability->slots;
        foreach ($teacher_availabilit_slots as $sch) {
            // get current week returns us an array with days of week except sunday
            $day = get_current_week()[$sch->day->day_id];

            $slot = $sch->slot_id;
            // $teacherTz = $teacher->availability->timezone;
            $teacherTz = $teacher->timezone;


            $time = get_24_hour_timeslots(true)[$slot];
            $teacherTime = \Carbon\Carbon::parse($day->format('Y-m-d ') . $time, $teacherTz);

            $studentTime = convertTimeToUSERzone($teacherTime, $student->timezone, $teacherTz);
            $sch->studentTime = $studentTime;


            //   $studentTime->format('w');     // as this assign 1 to monday but we have 0 to monday so we do -1

            // return get_date_from_day($studentTime->format('l'));    // that a custom fuction that returns 0 for monday else the above gives 1 for monday 
            $schedule[get_date_from_day($studentTime->format('l'))][] = $sch;
        }
        return $schedule;
    }
}


if (!function_exists('get_date_from_day')) {
    function get_date_from_day($index = 'Monday')
    {
        $Days = [
            'Monday' => 0,
            'Tuesday' => 1,
            'Wednesday' => 2,
            'Thursday' => 3,
            'Friday' => 4,
            'Saturday' => 5,
            'Sunday' => 6,

        ];
        return $Days[$index];
    }
}


if (!function_exists('get_current_week')) {
    function get_current_week()
    {
        $startDate = \Carbon\Carbon::now()->startOfWeek();          //monday
        // $endDate = \Carbon\Carbon::now()->endOfWeek()->subDay();    //saturday
        $endDate = \Carbon\Carbon::now()->endOfWeek();    //sunday                if you want to off sunday comment this and uncomment above



        $dateInterval = \DateInterval::createFromDateString('1 day');
        //Init Date Period from start date to end date
        //1 day is added to end date since date period ends before end date. See first comment: http://php.net/manual/en/class.dateperiod.php

        $dateperiod = new \DatePeriod($startDate, $dateInterval, $endDate);
        $days = null;
        foreach ($dateperiod as $key => $day) {
            // $days[$key + 1] = $day;    // incase your sunday is off so we skip zero
            $days[$key] = $day;
        }
        return $days;
    }
}


if (!function_exists('createZoomLinkByClassTime')) {
    function createZoomLinkByClassTime($classTime)
    {
        return \App\Classes\AlQuranConfig::DefaultZoomLink;
    }
}

if (!function_exists('GetShortMonthName')) {
    function GetShortMonthName($monthname)
    {
        return   Carbon::parse($monthname)->formatLocalized('%b ');
    }
}


if (!function_exists('CreateUUId')) {
    function CreateUUId()
    {
        $code = '';
        do {
            $code = (string) Uuid::generate();
            $code[0]="W";
            $code[1]="K";
            $user_code = WeeklyClass::where('session_key', $code)->exists();
        } while ($user_code);
        return $code;
    }
}
