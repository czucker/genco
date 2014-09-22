<?php

class utility {

    static $random = '';

    // generates a random password
    // By default of length 12 having special characters
    static function generate_password($length = 12, $special_chars = true) {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        if ($special_chars)
            $chars .= '!@#$%^&*_-()';

        $password = '';
        for ($i = 0; $i < $length; $i++)
            $password .= substr($chars, self::generate_random_number(0, strlen($chars) - 1), 1);
        return $password;
    }

    // generates a random number between $min and $max
    static function generate_random_number($min = 0, $max = 0) {
        // generate seed. TO-DO: Look for a better seed value everytime
        $seed = mt_rand();

        // generate $random
        // special thing about random is that it is 32(md5) + 40(sha1) + 40(sha1) = 112 long
        // hence if we cut the 1st 8 characters everytime, we can get upto 14 random numbers
        // each time the length of $random decreases and when it is less than 8, new 112 long $random is generated
        if (strlen(self::$random) < 8) {
            self::$random = md5(uniqid(microtime() . mt_rand(), true) . $seed);
            self::$random .= sha1(self::$random);
            self::$random .= sha1(self::$random . $seed);
        }

        // take first 8 characters
        $value = substr(self::$random, 0, 8);

        // strip first 8 character, leaving remainder for next call
        self::$random = substr(self::$random, 8);

        $value = abs(hexdec($value));
        // Reduce the value to be within the min - max range. 4294967295 = 0xffffffff = max random number
        if ($max != 0)
            $value = $min + (($max - $min + 1) * ($value / (4294967295 + 1)));
        return abs(intval($value));
    }

}

?>