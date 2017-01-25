<?php
namespace NimaEbrazi\PersianUtil;

use DateTime;

class JalaliDate
{
    /**
     * Tehran timezone
     */
    const TEHRAN_TIMEZONE = 'Asia/Tehran';

    /**
     * Farsi language
     */
    const FA_LANGUAGE = 'fa';

    /**
     * English language
     */
    const EN_LANGUAGE = 'en';

    /**
     * Persian abbr afternoon
     */
    const AFTERNOON_ABBR = 'ب.ظ';

    /**
     * Persian abbr forenoon
     */
    const FORENOON_ABBR = 'ق.ظ';

    /**
     * Persian afternoon
     */
    const AFTERNOON = 'بعد از ظهر';

    /**
     * Persian forenoon
     */
    const FORENOON = 'قبل از ظهر';

    /**
     * Persian days.
     *
     * @var array
     */
    private static $persianDays = [
        'یک',
        'دو',
        'سه',
        'چهار',
        'پنج',
        'شش',
        'هفت',
        'هشت',
        'نه',
        'ده',
        'یازده',
        'دوازده',
        'سیزده'
        , 'چهارده',
        'پانزده',
        'شانزده',
        'هفده',
        'هجده',
        'نوزده',
        'بیست',
        'بیست و یک',
        'بیست و دو',
        'بیست و سه'
        , 'بیست و چهار',
        'بیست و پنج',
        'بیست و شش',
        'بیست و هفت',
        'بیست و هشت',
        'بیست و نه',
        'سی',
        'سی و یک'
    ];

    /**
     * Persian week.
     *
     * @var array
     */
    private static $persianWeek = [
        'یکشنبه',
        'دوشنبه',
        'سه شنبه',
        'چهارشنبه',
        'پنجشنبه',
        'جمعه',
        'شنبه'
    ];

    /**
     * Persian week abbreviation words.
     *
     * @var array
     */
    private static $persianWeekAbbr = [
        'ی', 'د', 'س', 'چ', 'پ', 'ج', 'ش'
    ];

    /**
     * Persian month.
     *
     * @var array
     */
    private static $persianMonth = [
        'فروردین',
        'اردیبهشت',
        'خرداد',
        'تیر',
        'مرداد',
        'شهریور',
        'مهر',
        'آبان',
        'آذر',
        'دی',
        'بهمن',
        'اسفند'
    ];

    /**
     * Old persian month.
     *
     * @var array
     */
    private static $oldPersianMonth = [
        'حمل',
        'ثور',
        'جوزا',
        'سرطان',
        'اسد',
        'سنبله',
        'میزان',
        'عقرب',
        'قوس',
        'جدی',
        'دلو',
        'حوت'
    ];

    /**
     * Persian month abbreviation words.
     *
     * @var array
     */
    private static $persianMonthAbbr = [
        'فر', 'ار', 'خر', 'تی‍', 'مر', 'شه‍', 'مه‍', 'آب‍', 'آذ', 'دی', 'به‍', 'اس‍'
    ];

    /**
     * Persian season.
     *
     * @var array
     */
    private static $persianSeason = [
        'بهار', 'تابستان', 'پاییز', 'زمستان'
    ];

    /**
     * Persian year words.
     *
     * @var array
     */
    private static $persianYear = [
        'مار', 'اسب', 'گوسفند', 'میمون', 'مرغ', 'سگ', 'خوک', 'موش', 'گاو', 'پلنگ', 'خرگوش', 'نهنگ'
    ];


    /**
     * Similar php date() function.
     *
     * @param        $format
     * @param string $timestamp
     * @param string $none
     * @param string $time_zone
     * @param string $tr_num
     *
     * @return mixed|string
     */
    public static function jdate($format, $timestamp = '', $none = '', $time_zone = self::TEHRAN_TIMEZONE, $tr_num = self::FA_LANGUAGE)
    {

        $T_sec = 0;

        if ( $time_zone != 'local' ) date_default_timezone_set(($time_zone == '') ? self::TEHRAN_TIMEZONE : $time_zone);
        $ts = $T_sec + (($timestamp == '' or $timestamp == 'now') ? time() : self::translateNumber($timestamp));
        $date = explode('_', date('H_i_j_n_O_P_s_w_Y', $ts));
        list($jYear, $jMonth, $jDay) = self::gregorianToJalali($date[8], $date[3], $date[2]);
        $doy = ($jMonth < 7) ? (($jMonth - 1) * 31) + $jDay - 1 : (($jMonth - 7) * 30) + $jDay + 185;
        $kab = ($jYear % 33 % 4 - 1 == (int)($jYear % 33 * .05)) ? 1 : 0;
        $sl = strlen($format);
        $out = '';
        for ($i = 0; $i < $sl; $i++)
        {
            $sub = substr($format, $i, 1);
            if ( $sub == '\\' )
            {
                $out .= substr($format, ++$i, 1);
                continue;
            }
            switch ($sub)
            {

                case'E':
                case'R':
                case'x':
                case'X':
                    $out .= 'http://jdf.scr.ir';
                    break;

                case'B':
                case'e':
                case'g':
                case'G':
                case'h':
                case'I':
                case'T':
                case'u':
                case'Z':
                    $out .= date($sub, $ts);
                    break;

                case'a':
                    $out .= ($date[0] < 12) ? self::FORENOON_ABBR : self::AFTERNOON_ABBR;
                    break;

                case'A':
                    $out .= ($date[0] < 12) ? self::FORENOON : self::AFTERNOON;
                    break;

                case'b':
                    $out .= (int)($jMonth / 3.1) + 1;
                    break;

                case'c':
                    $out .= $jYear . '/' . $jMonth . '/' . $jDay . ' ،' . $date[0] . ':' . $date[1] . ':' . $date[6] . ' ' . $date[5];
                    break;

                case'C':
                    $out .= (int)(($jYear + 99) / 100);
                    break;

                case'd':
                    $out .= ($jDay < 10) ? '0' . $jDay : $jDay;
                    break;

                case'D':
                    $out .= self::dateNumToWords(array('kh' => $date[7]), ' ');
                    break;

                case'f':
                    $out .= self::dateNumToWords(array('ff' => $jMonth), ' ');
                    break;

                case'F':
                    $out .= self::dateNumToWords(array('mm' => $jMonth), ' ');
                    break;

                case'H':
                    $out .= $date[0];
                    break;

                case'i':
                    $out .= $date[1];
                    break;

                case'j':
                    $out .= $jDay;
                    break;

                case'J':
                    $out .= self::dateNumToWords(array('rr' => $jDay), ' ');
                    break;

                case'k';
                    $out .= self::translateNumber(100 - (int)($doy / ($kab + 365) * 1000) / 10, $tr_num);
                    break;

                case'K':
                    $out .= self::translateNumber((int)($doy / ($kab + 365) * 1000) / 10, $tr_num);
                    break;

                case'l':
                    $out .= self::dateNumToWords(array('rh' => $date[7]), ' ');
                    break;

                case'L':
                    $out .= $kab;
                    break;

                case'm':
                    $out .= ($jMonth > 9) ? $jMonth : '0' . $jMonth;
                    break;

                case'M':
                    $out .= self::dateNumToWords(array('km' => $jMonth), ' ');
                    break;

                case'n':
                    $out .= $jMonth;
                    break;

                case'N':
                    $out .= $date[7] + 1;
                    break;

                case'o':
                    $jdw = ($date[7] == 6) ? 0 : $date[7] + 1;
                    $dny = 364 + $kab - $doy;
                    $out .= ($jdw > ($doy + 3) and $doy < 3) ? $jYear - 1 : (((3 - $dny) > $jdw and $dny < 3) ? $jYear + 1 : $jYear);
                    break;

                case'O':
                    $out .= $date[4];
                    break;

                case'p':
                    $out .= self::dateNumToWords(array('mb' => $jMonth), ' ');
                    break;

                case'P':
                    $out .= $date[5];
                    break;

                case'q':
                    $out .= self::dateNumToWords(array('sh' => $jYear), ' ');
                    break;

                case'Q':
                    $out .= $kab + 364 - $doy;
                    break;

                case'r':
                    $key = jdate_words(array('rh' => $date[7], 'mm' => $jMonth));
                    $out .= $date[0] . ':' . $date[1] . ':' . $date[6] . ' ' . $date[4]
                        . ' ' . $key['rh'] . '، ' . $jDay . ' ' . $key['mm'] . ' ' . $jYear;
                    break;

                case's':
                    $out .= $date[6];
                    break;

                case'S':
                    $out .= 'ام';
                    break;

                case't':
                    $out .= ($jMonth != 12) ? (31 - (int)($jMonth / 6.5)) : ($kab + 29);
                    break;

                case'U':
                    $out .= $ts;
                    break;

                case'v':
                    $out .= self::dateNumToWords(array('ss' => ($jYear % 100)), ' ');
                    break;

                case'V':
                    $out .= self::dateNumToWords(array('ss' => $jYear), ' ');
                    break;

                case'w':
                    $out .= ($date[7] == 6) ? 0 : $date[7] + 1;
                    break;

                case'W':
                    $avs = (($date[7] == 6) ? 0 : $date[7] + 1) - ($doy % 7);
                    if ( $avs < 0 ) $avs += 7;
                    $num = (int)(($doy + $avs) / 7);
                    if ( $avs < 4 )
                    {
                        $num++;
                    }
                    elseif ( $num < 1 )
                    {
                        $num = ($avs == 4 or $avs == (($jYear % 33 % 4 - 2 == (int)($jYear % 33 * .05)) ? 5 : 4)) ? 53 : 52;
                    }
                    $aks = $avs + $kab;
                    if ( $aks == 7 ) $aks = 0;
                    $out .= (($kab + 363 - $doy) < $aks and $aks < 3) ? '01' : (($num < 10) ? '0' . $num : $num);
                    break;

                case'y':
                    $out .= substr($jYear, 2, 2);
                    break;

                case'Y':
                    $out .= $jYear;
                    break;

                case'z':
                    $out .= $doy;
                    break;

                default:
                    $out .= $sub;
            }
        }
        return ($tr_num != self::EN_LANGUAGE) ? self::translateNumber($out, self::FA_LANGUAGE, '.') : $out;
    }

    /**
     * Similar php strftime() function.
     *
     * @param        $format
     * @param string $timestamp
     * @param string $none
     * @param string $time_zone
     * @param string $tr_num
     *
     * @return mixed|string
     */
    public static function strFormatTime($format, $timestamp = '', $none = '', $time_zone = self::TEHRAN_TIMEZONE, $tr_num = self::FA_LANGUAGE)
    {

        $T_sec = 0;

        if ( $time_zone != 'local' ) date_default_timezone_set(($time_zone == '') ? self::TEHRAN_TIMEZONE : $time_zone);
        $ts = $T_sec + (($timestamp == '' or $timestamp == 'now') ? time() : self::translateNumber($timestamp));
        $date = explode('_', date('h_H_i_j_n_s_w_Y', $ts));
        list($jYear, $jMonth, $jDay) = self::gregorianToJalali($date[7], $date[4], $date[3]);
        $doy = ($jMonth < 7) ? (($jMonth - 1) * 31) + $jDay - 1 : (($jMonth - 7) * 30) + $jDay + 185;
        $kab = ($jYear % 33 % 4 - 1 == (int)($jYear % 33 * .05)) ? 1 : 0;
        $sl = strlen($format);
        $out = '';
        for ($i = 0; $i < $sl; $i++)
        {
            $sub = substr($format, $i, 1);
            if ( $sub == '%' )
            {
                $sub = substr($format, ++$i, 1);
            }
            else
            {
                $out .= $sub;
                continue;
            }
            switch ($sub)
            {

                /* Day */
                case'a':
                    $out .= self::dateNumToWords(array('kh' => $date[6]), ' ');
                    break;

                case'A':
                    $out .= self::dateNumToWords(array('rh' => $date[6]), ' ');
                    break;

                case'd':
                    $out .= ($jDay < 10) ? '0' . $jDay : $jDay;
                    break;

                case'e':
                    $out .= ($jDay < 10) ? ' ' . $jDay : $jDay;
                    break;

                case'j':
                    $out .= str_pad($doy + 1, 3, 0, STR_PAD_LEFT);
                    break;

                case'u':
                    $out .= $date[6] + 1;
                    break;

                case'w':
                    $out .= ($date[6] == 6) ? 0 : $date[6] + 1;
                    break;

                /* Week */
                case'U':
                    $avs = (($date[6] < 5) ? $date[6] + 2 : $date[6] - 5) - ($doy % 7);
                    if ( $avs < 0 ) $avs += 7;
                    $num = (int)(($doy + $avs) / 7) + 1;
                    if ( $avs > 3 or $avs == 1 ) $num--;
                    $out .= ($num < 10) ? '0' . $num : $num;
                    break;

                case'V':
                    $avs = (($date[6] == 6) ? 0 : $date[6] + 1) - ($doy % 7);
                    if ( $avs < 0 ) $avs += 7;
                    $num = (int)(($doy + $avs) / 7);
                    if ( $avs < 4 )
                    {
                        $num++;
                    }
                    elseif ( $num < 1 )
                    {
                        $num = ($avs == 4 or $avs == (($jYear % 33 % 4 - 2 == (int)($jYear % 33 * .05)) ? 5 : 4)) ? 53 : 52;
                    }
                    $aks = $avs + $kab;
                    if ( $aks == 7 ) $aks = 0;
                    $out .= (($kab + 363 - $doy) < $aks and $aks < 3) ? '01' : (($num < 10) ? '0' . $num : $num);
                    break;

                case'W':
                    $avs = (($date[6] == 6) ? 0 : $date[6] + 1) - ($doy % 7);
                    if ( $avs < 0 ) $avs += 7;
                    $num = (int)(($doy + $avs) / 7) + 1;
                    if ( $avs > 3 ) $num--;
                    $out .= ($num < 10) ? '0' . $num : $num;
                    break;

                /* Month */
                case'b':
                case'h':
                    $out .= self::dateNumToWords(array('km' => $jMonth), ' ');
                    break;

                case'B':
                    $out .= self::dateNumToWords(array('mm' => $jMonth), ' ');
                    break;

                case'm':
                    $out .= ($jMonth > 9) ? $jMonth : '0' . $jMonth;
                    break;

                /* Year */
                case'C':
                    $tmp = (int)($jYear / 100);
                    $out .= ($tmp > 9) ? $tmp : '0' . $tmp;
                    break;

                case'g':
                    $jdw = ($date[6] == 6) ? 0 : $date[6] + 1;
                    $dny = 364 + $kab - $doy;
                    $out .= substr(($jdw > ($doy + 3) and $doy < 3) ? $jYear - 1 : (((3 - $dny) > $jdw and $dny < 3) ? $jYear + 1 : $jYear), 2, 2);
                    break;

                case'G':
                    $jdw = ($date[6] == 6) ? 0 : $date[6] + 1;
                    $dny = 364 + $kab - $doy;
                    $out .= ($jdw > ($doy + 3) and $doy < 3) ? $jYear - 1 : (((3 - $dny) > $jdw and $dny < 3) ? $jYear + 1 : $jYear);
                    break;

                case'y':
                    $out .= substr($jYear, 2, 2);
                    break;

                case'Y':
                    $out .= $jYear;
                    break;

                /* Time */
                case'H':
                    $out .= $date[1];
                    break;

                case'I':
                    $out .= $date[0];
                    break;

                case'l':
                    $out .= ($date[0] > 9) ? $date[0] : ' ' . (int)$date[0];
                    break;

                case'M':
                    $out .= $date[2];
                    break;

                case'p':
                    $out .= ($date[1] < 12) ? self::FORENOON : self::AFTERNOON;
                    break;

                case'P':
                    $out .= ($date[1] < 12) ? self::FORENOON_ABBR : self::AFTERNOON_ABBR;
                    break;

                case'r':
                    $out .= $date[0] . ':' . $date[2] . ':' . $date[5] . ' ' . (($date[1] < 12) ? self::FORENOON : self::AFTERNOON);
                    break;

                case'R':
                    $out .= $date[1] . ':' . $date[2];
                    break;

                case'S':
                    $out .= $date[5];
                    break;

                case'T':
                    $out .= $date[1] . ':' . $date[2] . ':' . $date[5];
                    break;

                case'X':
                    $out .= $date[0] . ':' . $date[2] . ':' . $date[5];
                    break;

                case'z':
                    $out .= date('O', $ts);
                    break;

                case'Z':
                    $out .= date('T', $ts);
                    break;

                /* Time and Date Stamps */
                case'c':
                    $key = self::dateNumToWords(array('rh' => $date[6], 'mm' => $jMonth));
                    $out .= $date[1] . ':' . $date[2] . ':' . $date[5] . ' ' . date('P', $ts)
                        . ' ' . $key['rh'] . '، ' . $jDay . ' ' . $key['mm'] . ' ' . $jYear;
                    break;

                case'D':
                    $out .= substr($jYear, 2, 2) . '/' . (($jMonth > 9) ? $jMonth : '0' . $jMonth) . '/' . (($jDay < 10) ? '0' . $jDay : $jDay);
                    break;

                case'F':
                    $out .= $jYear . '-' . (($jMonth > 9) ? $jMonth : '0' . $jMonth) . '-' . (($jDay < 10) ? '0' . $jDay : $jDay);
                    break;

                case's':
                    $out .= $ts;
                    break;

                case'x':
                    $out .= substr($jYear, 2, 2) . '/' . (($jMonth > 9) ? $jMonth : '0' . $jMonth) . '/' . (($jDay < 10) ? '0' . $jDay : $jDay);
                    break;

                /* Miscellaneous */
                case'n':
                    $out .= "\n";
                    break;

                case't':
                    $out .= "\t";
                    break;

                case'%':
                    $out .= '%';
                    break;

                default:
                    $out .= $sub;
            }
        }
        return ($tr_num != self::EN_LANGUAGE) ? self::translateNumber($out, self::FA_LANGUAGE, '.') : $out;
    }

    /**
     * Similar php mktime() function.
     *
     * @param string $hour
     * @param string $minute
     * @param string $second
     * @param string $jMonth
     * @param string $jDay
     * @param string $jYear
     * @param string $none
     * @param string $timezone
     *
     * @return false|int
     */
    public static function makeTime($hour = '', $minute = '', $second = '', $jMonth = '', $jDay = '', $jYear = '', $none = '', $timezone = self::TEHRAN_TIMEZONE)
    {
        if ( $timezone != 'local' ) date_default_timezone_set($timezone);

        if ( $hour == '' )
        {
            return time();
        }

        else
        {
            list($hour, $minute, $second, $jMonth, $jDay, $jYear) = explode('_', self::translateNumber($hour . '_' . $minute . '_' . $second . '_' . $jMonth . '_' . $jDay . '_' . $jYear));
            if ( $minute == '' )
            {
                return mktime($hour);
            }
            else
            {
                if ( $second == '' )
                {
                    return mktime($hour, $minute);
                }
                else
                {
                    if ( $jMonth == '' )
                    {
                        return mktime($hour, $minute, $second);
                    }
                    else
                    {
                        $jdate = explode('_', self::jdate('Y_j', '', '', $timezone, self::EN_LANGUAGE));
                        if ( $jDay == '' )
                        {
                            list($gy, $gm, $gd) = self::jalaliToGregorian($jdate[0], $jMonth, $jdate[1]);
                            return mktime($hour, $minute, $second, $gm);
                        }
                        else
                        {
                            if ( $jYear == '' )
                            {
                                list($gy, $gm, $gd) = self::jalaliToGregorian($jdate[0], $jMonth, $jDay);
                                return mktime($hour, $minute, $second, $gm, $gd);
                            }
                            else
                            {
                                list($gy, $gm, $gd) = self::jalaliToGregorian($jYear, $jMonth, $jDay);
                                return mktime($hour, $minute, $second, $gm, $gd, $gy);
                            }
                        }
                    }
                }
            }
        }
    }

    /**
     * Similar php getdate() function.
     *
     * @param string $timestamp
     * @param string $none
     * @param string $timezone
     * @param string $tn
     *
     * @return array
     */
    public static function getDate($timestamp = '', $none = '', $timezone = self::TEHRAN_TIMEZONE, $tn = self::EN_LANGUAGE)
    {
        $ts = ($timestamp == '') ? time() : self::translateNumber($timestamp);
        $jdate = explode('_', self::jdate('F_G_i_j_l_n_s_w_Y_z', $ts, '', $timezone, $tn));
        return array(
            'seconds' => self::translateNumber((int)self::translateNumber($jdate[6]), $tn),
            'minutes' => self::translateNumber((int)self::translateNumber($jdate[2]), $tn),
            'hours' => $jdate[1],
            'mday' => $jdate[3],
            'wday' => $jdate[7],
            'mon' => $jdate[5],
            'year' => $jdate[8],
            'yday' => $jdate[9],
            'weekday' => $jdate[4],
            'month' => $jdate[0],
            0 => self::translateNumber($ts, $tn)
        );
    }

    /**
     * Similar php checkdate() function.
     *
     * @param $jMonth
     * @param $jDay
     * @param $jYear
     *
     * @return bool
     */
    public static function checkDate($jMonth, $jDay, $jYear)
    {
        list($jMonth, $jDay, $jYear) = explode('_', $jMonth . '_' . $jDay . '_' . $jYear);
        $l_d = ($jMonth == 12) ? (($jYear % 33 % 4 - 1 == (int)($jYear % 33 * .05)) ? 30 : 29) : 31 - (int)($jMonth / 6.5);
        return ($jMonth > 12 or $jDay > $l_d or $jMonth < 1 or $jDay < 1 or $jYear < 1) ? false : true;
    }

    /**
     * Translate numbers from english to persian and vice versa.
     *
     * @param        $str
     * @param string $mod
     * @param string $mf
     *
     * @return mixed
     */
    public static function translateNumber($str, $mod = self::EN_LANGUAGE, $mf = '٫')
    {
        $english = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '.');
        $persian = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹', $mf);
        return ($mod == self::FA_LANGUAGE) ? str_replace($english, $persian, $str) : str_replace($persian, $english, $str);
    }

    /**
     * Convert numbers as a date to persian string.
     *
     * @param        $array
     * @param string $mod
     *
     * @return string
     */
    public static function dateNumToWords($array, $mod = '')
    {
        foreach ($array as $type => $num)
        {
            $num = (int)self::translateNumber($num);
            switch ($type)
            {

                case'ss':
                    $sl = strlen($num);
                    $xy3 = substr($num, 2 - $sl, 1);
                    $h3 = $h34 = $h4 = '';
                    if ( $xy3 == 1 )
                    {
                        $p34 = '';
                        $k34 = array('ده', 'یازده', 'دوازده', 'سیزده', 'چهارده', 'پانزده', 'شانزده', 'هفده', 'هجده', 'نوزده');
                        $h34 = $k34[substr($num, 2 - $sl, 2) - 10];
                    }
                    else
                    {
                        $xy4 = substr($num, 3 - $sl, 1);
                        $p34 = ($xy3 == 0 or $xy4 == 0) ? '' : ' و ';
                        $k3 = array('', '', 'بیست', 'سی', 'چهل', 'پنجاه', 'شصت', 'هفتاد', 'هشتاد', 'نود');
                        $h3 = $k3[$xy3];
                        $k4 = array('', 'یک', 'دو', 'سه', 'چهار', 'پنج', 'شش', 'هفت', 'هشت', 'نه');
                        $h4 = $k4[$xy4];
                    }
                    $array[$type] = (($num > 99) ? str_replace(array('12', '13', '14', '19', '20')
                                , array('هزار و دویست', 'هزار و سیصد', 'هزار و چهارصد', 'هزار و نهصد', 'دوهزار')
                                , substr($num, 0, 2)) . ((substr($num, 2, 2) == '00') ? '' : ' و ') : '') . $h3 . $p34 . $h34 . $h4;
                    break;

                case'mm':
                    $key = self::$persianMonth;
                    $array[$type] = $key[$num - 1];
                    break;

                case'rr':
                    $key = self::$persianDays;
                    $array[$type] = $key[$num - 1];
                    break;

                case'rh':
                    $key = self::$persianWeek;
                    $array[$type] = $key[$num];
                    break;

                case'sh':
                    $key = self::$persianYear;
                    $array[$type] = $key[$num % 12];
                    break;

                case'mb':
                    $key = self::$oldPersianMonth;
                    $array[$type] = $key[$num - 1];
                    break;

                case'ff':
                    $key = self::$persianSeason;

                    $array[$type] = $key[(int)($num / 3.1)];
                    break;

                case'km':
                    $key = self::$persianMonthAbbr;
                    $array[$type] = $key[$num - 1];
                    break;

                case'kh':
                    $key = self::$persianWeekAbbr;
                    $array[$type] = $key[$num];
                    break;

                default:
                    $array[$type] = $num;
            }
        }
        return ($mod == '') ? $array : implode($mod, $array);
    }

    /**
     * Convert gregorian date to jalali date.
     *
     * @param        $gregorianYear
     * @param        $gregorianMonth
     * @param        $gregorianDay
     * @param string $mod
     *
     * @return array|string
     */
    public static function gregorianToJalali($gregorianYear, $gregorianMonth, $gregorianDay, $mod = '')
    {
        list($gregorianYear, $gregorianMonth, $gregorianDay) = explode('_', self::translateNumber($gregorianYear . '_' . $gregorianMonth . '_' . $gregorianDay));
        $g_d_m = array(0, 31, 59, 90, 120, 151, 181, 212, 243, 273, 304, 334);
        $jYear = ($gregorianYear <= 1600) ? 0 : 979;
        $gregorianYear -= ($gregorianYear <= 1600) ? 621 : 1600;
        $gy2 = ($gregorianMonth > 2) ? ($gregorianYear + 1) : $gregorianYear;
        $days = (365 * $gregorianYear) + ((int)(($gy2 + 3) / 4)) - ((int)(($gy2 + 99) / 100))
            + ((int)(($gy2 + 399) / 400)) - 80 + $gregorianDay + $g_d_m[$gregorianMonth - 1];
        $jYear += 33 * ((int)($days / 12053));
        $days %= 12053;
        $jYear += 4 * ((int)($days / 1461));
        $days %= 1461;
        $jYear += (int)(($days - 1) / 365);
        if ( $days > 365 ) $days = ($days - 1) % 365;
        $jMonth = ($days < 186) ? 1 + (int)($days / 31) : 7 + (int)(($days - 186) / 30);
        $jDay = 1 + (($days < 186) ? ($days % 31) : (($days - 186) % 30));
        return ($mod == '') ? array($jYear, $jMonth, $jDay) : $jYear . $mod . $jMonth . $mod . $jDay;
    }

    /**
     * Convert jalali date to gregorian date.
     *
     * @param        $jYear
     * @param        $jMonth
     * @param        $jDay
     * @param string $mod
     *
     * @return array|string
     */
    public static function jalaliToGregorian($jYear, $jMonth, $jDay, $mod = '')
    {
        list($jYear, $jMonth, $jDay) = explode('_', self::translateNumber($jYear . '_' . $jMonth . '_' . $jDay));
        $gregorianYear = ($jYear <= 979) ? 621 : 1600;
        $jYear -= ($jYear <= 979) ? 0 : 979;
        $days = (365 * $jYear) + (((int)($jYear / 33)) * 8) + ((int)((($jYear % 33) + 3) / 4))
            + 78 + $jDay + (($jMonth < 7) ? ($jMonth - 1) * 31 : (($jMonth - 7) * 30) + 186);
        $gregorianYear += 400 * ((int)($days / 146097));
        $days %= 146097;
        if ( $days > 36524 )
        {
            $gregorianYear += 100 * ((int)(--$days / 36524));
            $days %= 36524;
            if ( $days >= 365 ) $days++;
        }
        $gregorianYear += 4 * ((int)(($days) / 1461));
        $days %= 1461;
        $gregorianYear += (int)(($days - 1) / 365);
        if ( $days > 365 ) $days = ($days - 1) % 365;
        $gregorianDay = $days + 1;
        foreach (array(0, 31, (($gregorianYear % 4 == 0 and $gregorianYear % 100 != 0) or ($gregorianYear % 400 == 0)) ? 29 : 28
                       , 31, 30, 31, 30, 31, 31, 30, 31, 30, 31) as $gregorianMonth => $v)
        {
            if ( $gregorianDay <= $v ) break;
            $gregorianDay -= $v;
        }
        return ($mod == '') ? array($gregorianYear, $gregorianMonth, $gregorianDay) : $gregorianYear . $mod . $gregorianMonth . $mod . $gregorianDay;
    }

    /**
     * Convert english numbers to persian.
     *
     * @param        $str
     * @param string $floatSymbol
     *
     * @return mixed
     */
    public static function toPersianNumber($str, $floatSymbol = '٫')
    {
        return self::translateNumber($str, 'fa', $floatSymbol);
    }

    /**
     * Convert persian numbers to english.
     *
     * @param        $str
     *
     * @return mixed
     *
     */
    public static function toEnglishNumber($str)
    {
        return self::translateNumber($str, 'en');
    }

    /**
     * Find Jalali day.
     *
     * @return int
     */
    public static function getDay()
    {
        return (int)self::getDate()['mday'];
    }

    /**
     * Find Jalali month.
     *
     * @return int
     */
    public static function getMonth()
    {
        return (int)self::getDate()['mon'];
    }

    /**
     * Find Jalali Year.
     *
     * @return int
     */
    public static function getYear()
    {
        return (int)self::getDate()['year'];
    }

    /**
     * Show 'now' persian date format.
     * output : 1395/11/1
     *
     * @param string $splitter
     *
     * @return string
     */
    public static function getPersianDateFormat($splitter = '/')
    {
        return (int)self::getDate()['year'] . $splitter .
        (int)self::getDate()['mon'] . $splitter .
        (int)self::getDate()['mday'];
    }

    /**
     * Find Jalali day persian word.
     *
     * @param $day
     *
     * @return mixed
     */
    public static function getDayWord($day)
    {
        return self::dateNumToWords(["rr" => (int)$day], ' ');
    }

    /**
     * Find Jalali month persian word.
     *
     * @param $month
     *
     * @return mixed
     */
    public static function getMonthWord($month)
    {
        return self::dateNumToWords(["mm" => $month], ' ');
    }

    /**
     * Find Jalali season persian word.
     *
     * @param $month
     *
     * @return mixed
     */
    public static function getSeasonWord($month)
    {
        return self::dateNumToWords(["ff" => $month], ' ');
    }

    /**
     * Show jalali date string.
     * input : 1395/6/12
     * output: دوازده شهریور هزار و سیصد و نود و پنج
     *
     * @param        $jDate
     * @param string $dateSplitter
     * @param string $strSplitter
     *
     * @return string
     */
    public static function getDateWord($jDate, $dateSplitter = '/', $strSplitter = ' ')
    {
        $date = explode($dateSplitter, self::toEnglishNumber($jDate));
        return self::dateNumToWords([
            "rr" => $date[2],
            "mm" => $date[1],
            "ss" => $date[0]
        ], $strSplitter);
    }

    /**
     * Check date is after now date.
     *
     * @param null   $date
     * @param string $splitter
     *
     * @return bool
     */
    public static function isAfterToday($date = null, $splitter = '/')
    {
        return ! (self::isExpired($date, $splitter));
    }

    /**
     * Check date is before now date.
     *
     * @param null   $date
     * @param string $splitter
     *
     * @return bool
     */
    public static function isBeforeToday($date = null, $splitter = '/')
    {
        return self::isExpired($date, $splitter);
    }

    /**
     * Check date is expired from now date.
     *
     * @param null   $date
     * @param string $splitter
     *
     * @return bool
     */
    public static function isExpired($date = null, $splitter = '/')
    {
        if ( is_null($date) )
            throw new \InvalidArgumentException(__CLASS__ . ': Date parameter is null.');

        $year = explode($splitter, $date)[0];
        $month = explode($splitter, $date)[1];
        $day = explode($splitter, $date)[2];

        if ( self::checkDate($month, $day, $year) === false )
            throw new \InvalidArgumentException(__CLASS__ . ': Date range is invalid.');


        if ( $year < self::getYear() ) return true;

        else if ( $year == self::getYear() )
        {
            if ( $month < self::getMonth() )
            {
                return true;
            }
            else if ( $month == self::getMonth() )
            {
                if ( $day < self::getDay() )
                {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Convert UNIX timestamp to Jalali timestamp.
     *
     * @param        $unixTimestamp
     *
     * @param string $timezone
     *
     * @return int
     */
    public static function gregorianToJalaliStrFormat($unixTimestamp, $timezone = self::TEHRAN_TIMEZONE)
    {

        $date = self::unixTimestampToStrFormat($unixTimestamp, $timezone);

        //fetch time and date from timestamp
        $gDate = explode(" ", $date)[0];
        $time = explode(" ", $date)[1];

        //create year, month, day
        $gYear = explode("-", $gDate)[0];
        $gMonth = explode("-", $gDate)[1];
        $gDay = explode("-", $gDate)[2];

        //create hour, minute, second
        $hour = explode(":", $time)[0];
        $minute = explode(":", $time)[1];
        $second = explode(":", $time)[2];

        $jDate = self::gregorianToJalali($gYear, $gMonth, $gDay);

        $jYear = $jDate[0];
        $jMonth = $jDate[1];
        $jDay = $jDate[2];

        return (int)self::makeTime($hour, $minute, $second, $jMonth, $gDay, $jYear, $jDay);
    }

    /**
     * Fetch Jalali date from unix timestamp.
     *
     * @param int    $unixTimestamp
     * @param string $dateSplitter
     * @param string $timeSplitter
     * @param string $timezone
     *
     * @return string
     */
    public static function unixTimestampToJalali($unixTimestamp, $dateSplitter = '/', $timeSplitter = ':', $timezone = self::TEHRAN_TIMEZONE)
    {
        $date = self::unixTimestampToStrFormat($unixTimestamp, $timezone);

        //fetch time and date from timestamp
        $gDate = explode(" ", $date)[0];
        //create year, month, day
        $gYear = explode("-", $gDate)[0];
        $gMonth = explode("-", $gDate)[1];
        $gDay = explode("-", $gDate)[2];

        //create hour, minute, second
        $time = explode(" ", $date)[1];
        $hour = explode(":", $time)[0];
        $minute = explode(":", $time)[1];
        $second = explode(":", $time)[2];

        $jdate = self::gregorianToJalali($gYear, $gMonth, $gDay);

        return
            (string)$jdate[0] . $dateSplitter
            . $jdate[1] . $dateSplitter
            . $jdate[2] . ' '
            . $hour . $timeSplitter
            . $minute . $timeSplitter
            . $second;
    }

    /**
     * Convert unix timestamp by timezone to timestamp.
     *
     * @param $unixTimestamp
     * @param $timezone
     *
     * @return string
     */
    public static function unixTimestampToStrFormat($unixTimestamp, $timezone)
    {
        $dt = new DateTime('@' . $unixTimestamp);
        $dt->setTimeZone(new \DateTimeZone($timezone));
        return $dt->format('Y-m-d H:i:s');
    }
}