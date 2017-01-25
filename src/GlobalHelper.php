<?php namespace Nima\PersianUtil;


class GlobalHelper
{
    public static function formatPrice($price, $round = 2)
    {
        return JalaliDate::toPersianNumber(number_format(round($price, -$round))) . ' تومان';
    }

    public static function formatTime($time)
    {
        $output = [];
        $periods = [86400 => 'روز', 3600 => 'ساعت', 60 => 'دقیقه'];

        foreach ($periods as $key => $period)
        {

            if ( $time > $key )
            {
                $output[] = ((int)($time / $key)) . ' ' . $period;
                $time %= $key;
            }
        }

        return JalaliDate::toPersianNumber(implode(' و ', $output));

    }

    public static function word2uni($word)
    {

        $new_word = array();
        $char_type = array();
        $isolated_chars = array('ا', 'د', 'ذ', 'أ', 'آ', 'ر', 'ؤ', 'ء', 'ز', 'و', 'ى', 'ة', 'إ');
        $alef = array('أ', 'ا', 'إ', 'آ');
        $lam = array('ل');
        $al_char = array();
        $all_chars = array
        (
            'ا' => array(
                'la_beg' => 'ﻻ',
                'la_end' => 'ﻼ',
                'middle' => 'ﺎ',

                'isolated' => 'ﺍ'
            ),
            'إ' => array(
                'la_beg' => 'ﻹ',
                'la_end' => 'ﻺ',
                'middle' => 'ﺈ',

                'isolated' => 'ﺇ'
            ),

            'ؤ' => array(

                'middle' => 'ﺅ',

                'isolated' => 'ﺆ'
            ),
            'ء' => array(
                'middle' => 'ﺀ',
                'isolated' => 'ﺀ'
            ),
            'أ' => array(
                'la_beg' => 'ﻷ',
                'la_end' => 'ﻸ',
                'middle' => 'ﺄ',

                'isolated' => 'ﺃ'
            ),
            'آ' => array(
                'la_beg' => 'ﻵ',
                'la_end' => 'ﻶ',
                'middle' => 'ﺂ',

                'isolated' => 'ﺁ'
            ),
            'ى' => array(

                'middle' => 'ﻰ',

                'isolated' => 'ﻯ'
            ),
            'ب' => array(
                'beginning' => 'ﺑ',
                'middle' => 'ﺒ',
                'end' => 'ﺐ',
                'isolated' => 'ﺏ'
            ),
            'ت' => array(
                'beginning' => 'ﺗ',
                'middle' => 'ﺘ',
                'end' => 'ﺖ',
                'isolated' => 'ﺕ'
            ),
            'ث' => array(
                'beginning' => 'ﺛ',
                'middle' => 'ﺜ',
                'end' => 'ﺚ',
                'isolated' => 'ﺙ'
            ),
            'ج' => array(
                'beginning' => 'ﺟ',
                'middle' => 'ﺠ',
                'end' => 'ﺞ',
                'isolated' => 'ﺝ'
            ),
            'ح' => array(
                'beginning' => 'ﺣ',
                'middle' => 'ﺤ',
                'end' => 'ﺢ',
                'isolated' => 'ﺡ'
            ),
            'خ' => array(
                'beginning' => 'ﺧ',
                'middle' => 'ﺨ',
                'end' => 'ﺦ',
                'isolated' => 'ﺥ'
            ),
            'د' => array(
                'middle' => 'ﺪ',
                'isolated' => 'ﺩ'
            ),
            'ذ' => array(
                'middle' => 'ﺬ',
                'isolated' => 'ﺫ'
            ),
            'ر' => array(
                'middle' => 'ﺮ',
                'isolated' => 'ﺭ'
            ),
            'ز' => array(
                'middle' => 'ﺰ',
                'isolated' => 'ﺯ'
            ),
            'س' => array(
                'beginning' => 'ﺳ',
                'middle' => 'ﺴ',
                'end' => 'ﺲ',
                'isolated' => 'ﺱ'
            ),
            'ش' => array(
                'beginning' => 'ﺷ',
                'middle' => 'ﺸ',
                'end' => 'ﺶ',
                'isolated' => 'ﺵ'
            ),
            'ص' => array(
                'beginning' => 'ﺻ',
                'middle' => 'ﺼ',
                'end' => 'ﺺ',
                'isolated' => 'ﺹ'
            ),
            'ض' => array(
                'beginning' => 'ﺿ',
                'middle' => 'ﻀ',
                'end' => 'ﺾ',
                'isolated' => 'ﺽ'
            ),
            'ط' => array(
                'beginning' => 'ﻃ',
                'middle' => 'ﻄ',
                'end' => 'ﻂ',
                'isolated' => 'ﻁ'
            ),
            'ظ' => array(
                'beginning' => 'ﻇ',
                'middle' => 'ﻈ',
                'end' => 'ﻆ',
                'isolated' => 'ﻅ'
            ),
            'ع' => array(
                'beginning' => 'ﻋ',
                'middle' => 'ﻌ',
                'end' => 'ﻊ',
                'isolated' => 'ﻉ'
            ),
            'غ' => array(
                'beginning' => 'ﻏ',
                'middle' => 'ﻐ',
                'end' => 'ﻎ',
                'isolated' => 'ﻍ'
            ),
            'ف' => array(
                'beginning' => 'ﻓ',
                'middle' => 'ﻔ',
                'end' => 'ﻒ',
                'isolated' => 'ﻑ'
            ),
            'ق' => array(
                'beginning' => 'ﻗ',
                'middle' => 'ﻘ',
                'end' => 'ﻖ',
                'isolated' => 'ﻕ'
            ),
            'ك' => array(
                'beginning' => 'ﻛ',
                'middle' => 'ﻜ',
                'end' => 'ﻚ',
                'isolated' => 'ﻙ'
            ),
            'ل' => array(
                'beginning' => 'ﻟ',
                'middle' => 'ﻠ',
                'end' => 'ﻞ',
                'isolated' => 'ﻝ'
            ),
            'م' => array(
                'beginning' => 'ﻣ',
                'middle' => 'ﻤ',
                'end' => 'ﻢ',
                'isolated' => 'ﻡ'
            ),
            'ن' => array(
                'beginning' => 'ﻧ',
                'middle' => 'ﻨ',
                'end' => 'ﻦ',
                'isolated' => 'ﻥ'
            ),
            'ه' => array(
                'beginning' => 'ﻫ',
                'middle' => 'ﻬ',
                'end' => 'ﻪ',
                'isolated' => 'ﻩ'
            ),
            'و' => array(
                'middle' => 'ﻮ',
                'isolated' => 'ﻭ'
            ),
            'ي' => array(
                'beginning' => 'ﻳ',
                'middle' => 'ﻴ',
                'end' => 'ﻲ',
                'isolated' => 'ﻱ'
            ),
            'ئ' => array(
                'beginning' => 'ﺋ',
                'middle' => 'ﺌ',
                'end' => 'ﺊ',
                'isolated' => 'ﺉ'
            ),
            'ة' => array(
                'middle' => 'ﺔ',
                'isolated' => 'ﺓ'
            )
        );

        if ( in_array($word[0] . $word[1], $isolated_chars) )
        {
            $new_word[] = $all_chars[$word[0] . $word[1]]['isolated'];
            $char_type[] = 'not_normal';
            $al_char[] = false;
        }
        else
        {
            if ( in_array($word[0] . $word[1], $lam) AND in_array($word[2] . $word[3], $alef) )
            {
                $new_word[] = $all_chars [$word[2] . $word[3]]['la_beg'];
                $char_type[] = 'not_normal';

                $al_char[] = true;
            }
            else
            {

                $new_word[] = $all_chars[$word[0] . $word[1]]['beginning'];
                $char_type[] = 'normal';
                $al_char[] = false;
            }

        }

        if ( strlen($word) > 4 )
        {
            if ( $char_type[0] == 'not_normal' )
            {
                if ( in_array($word[2] . $word[3], $isolated_chars) )
                {
                    if ( $al_char[count($al_char) - 1] == false )
                    {
                        $new_word[] = $all_chars[$word[2] . $word[3]]['isolated'];
                        $char_type[] = 'not_normal';

                    }
                    $al_char[] = false;

                }
                else
                {
                    if ( in_array($word[2] . $word[3], $lam) AND in_array($word[4] . $word[5], $alef) )
                    {
                        $new_word[] = $all_chars[$word[4] . $word[5]]['la_beg'];
                        $char_type[] = 'not_normal';
                        $al_char[] = true;
                    }
                    else
                    {
                        $new_word[] = $all_chars[$word[2] . $word[3]]['beginning'];
                        $char_type[] = 'normal';
                        $al_char[] = false;
                    }

                }
            }
            else
            {
                if ( in_array($word[2] . $word[3], $lam) AND in_array($word[4] . $word[5], $alef) )
                {

                    $new_word[] = $all_chars[$word[4] . $word[5]]['la_end'];
                    $char_type[] = 'not_normal';
                    $al_char[] = true;
                }
                else
                {
                    $new_word[] = $all_chars[$word[2] . $word[3]]['middle'];
                    if ( in_array($word[2] . $word[3], $isolated_chars) )
                    {
                        $char_type[] = 'not_normal';
                        $al_char[] = false;
                    }
                    else
                    {
                        $char_type[] = 'normal';
                        $al_char[] = false;
                    }
                }

            }
            $x = 4;
        }
        else
        {
            $x = 2;
        }

        for ($x = 4; $x < (strlen($word) - 4); $x++)
        {
            if ( $char_type[count($char_type) - 1] == 'not_normal' AND $x % 2 == 0 )
            {
                if ( in_array($word[$x] . $word[$x + 1], $isolated_chars) )
                {
                    if ( $al_char[count($al_char) - 1] == false )
                    {
                        $new_word[] = $all_chars[$word[$x] . $word[$x + 1]]['isolated'];
                        $char_type[] = 'not_normal';

                    }
                    $al_char[] = false;
                }
                elseif ( in_array($word[$x] . $word[$x + 1], $lam) AND in_array($word[$x + 2] . $word[$x + 3], $alef) )
                {

                    $new_word[] = $all_chars[$word[$x + 2] . $word[$x + 3]]['la_beg'];
                    $char_type[] = 'not_normal';
                    $al_char[] = true;
                }
                else
                {

                    $new_word[] = $all_chars[$word[$x] . $word[$x + 1]]['beginning'];
                    $char_type[] = 'normal';
                    $al_char[] = false;
                }
            }
            elseif ( $char_type[count($char_type) - 1] == 'normal' AND $x % 2 == 0 )
            {

                if ( in_array($word[$x] . $word[$x + 1], $isolated_chars) )
                {
                    if ( $al_char[count($al_char) - 1] == false )
                    {
                        $new_word[] = $all_chars[$word[$x] . $word[$x + 1]]['middle'];
                        $char_type[] = 'not_normal';
                    }
                    $al_char[] = false;
                }
                elseif ( in_array($word[$x] . $word[$x + 1], $lam) AND in_array($word[$x + 2] . $word[$x + 3], $alef) )
                {

                    $new_word[] = $all_chars[$word[$x + 2] . $word[$x + 3]]['la_end'];
                    $char_type[] = 'not_normal';
                    $al_char[] = true;
                }
                else
                {

                    $new_word[] = $all_chars[$word[$x] . $word[$x + 1]]['middle'];
                    $char_type[] = 'normal';
                    $al_char[] = false;
                }
            }

        }
        if ( strlen($word) > 6 )
        {
            if ( $char_type[count($char_type) - 1] == 'not_normal' )
            {
                if ( in_array($word[$x] . $word[$x + 1], $isolated_chars) )
                {
                    if ( $al_char[count($al_char) - 1] == false )
                    {
                        $new_word[] = $all_chars[$word[$x] . $word[$x + 1]]['isolated'];
                        $char_type[] = 'not_normal';
                    }
                    $al_char[] = false;
                }
                else
                {

                    if ( $word[strlen($word) - 2] . $word[strlen($word) - 1] == 'ء' )
                    {
                        if ( $al_char[count($al_char) - 1] == true )
                        {
                            $new_word[] = $all_chars[$word[$x] . $word[$x + 1]]['isolated'];
                            $char_type[] = 'normal';
                        }
                        $al_char[] = false;
                    }
                    elseif ( in_array($word[$x] . $word[$x + 1], $lam) AND in_array($word[$x + 2] . $word[$x + 3], $alef) )
                    {

                        $new_word[] = $all_chars[$word[$x + 2] . $word[$x + 3]]['la_end'];
                        $char_type[] = 'not_normal';
                        $al_char[] = true;
                    }
                    else
                    {
                        $new_word[] = $all_chars[$word[$x] . $word[$x + 1]]['beginning'];
                        $char_type[] = 'normal';
                        $al_char[] = false;
                    }

                }

                $x += 2;
            }
            elseif ( $char_type[count($char_type) - 1] == 'normal' AND $al_char[count($al_char) - 1] == false )
            {

                if ( in_array($word[$x] . $word[$x + 1], $isolated_chars) )
                {
                    if ( $al_char[count($al_char) - 1] == false )
                    {
                        $new_word[] = $all_chars[$word[$x] . $word[$x + 1]]['middle'];
                        $char_type[] = 'not_normal';
                    }
                    $al_char[] = false;
                }
                elseif ( in_array($word[$x] . $word[$x + 1], $lam) AND in_array($word[$x + 2] . $word[$x + 3], $alef) )
                {

                    $new_word[] = $all_chars[$word[$x + 2] . $word[$x + 3]]['la_end'];
                    $char_type[] = 'not_normal';
                    $al_char[] = true;
                }
                else
                {

                    $new_word[] = $all_chars[$word[$x] . $word[$x + 1]]['middle'];
                    $char_type[] = 'normal';
                    $al_char[] = false;
                }

                $x += 2;
            }


        }

        if ( $char_type[count($char_type) - 1] == 'not_normal' )
        {

            if ( in_array($word[$x] . $word[$x + 1], $isolated_chars) )
            {
                if ( $al_char[count($al_char) - 1] == false )
                {
                    $new_word[] = $all_chars[$word[$x] . $word[$x + 1]]['isolated'];
                }

            }
            else
            {
                $new_word[] = $all_chars[$word[$x] . $word[$x + 1]]['isolated'];

            }

        }
        else
        {
            if ( in_array($word[$x] . $word[$x + 1], $isolated_chars) )
            {

                $new_word[] = $all_chars[$word[$x] . $word[$x + 1]]['middle'];

            }
            else
            {

                $new_word[] = $all_chars[$word[$x] . $word[$x + 1]]['end'];

            }
        }

        return implode('', array_reverse($new_word));
    }

    public static function generateRandomString($chars = 8)
    {

        $tokens = 'ABCDEFGHJKMNPQRSTUVWXYZ123456789';


        $string = '';


        for ($j = 0; $j < $chars; $j++)
        {
            $string .= $tokens[rand(0, strlen($tokens) - 1)];
        }


        return $string;

    }
}