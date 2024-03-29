<?php
//Name: Alicia Buehner, Evan Wheeler
//Date: 6/10/19
//Description: This file contains the validation functions for the account registration/update forms

/**
 * This function checks to see that account registration form
 * is valid.
 *
 * @return boolean
 */
function validForm1()
{
    global $f3;
    $isValid = true;

    if(!validPlatform($f3->get('platform')))
    {
        $isValid = false;
        $f3->set("errors['platform']", 'Please select a valid platform');
    }

    if (!validEmail($f3->get('email'))) {
        $isValid = false;
        $f3->set("errors['email']", 'Please enter a valid email');
    }

    //checks if first pw is valid and fits requirements
    if (!validPassword($f3->get('password'))) {
        $isValid = false;
        $f3->set("errors['password']", 'Please enter a valid password');
    }

    //checks if second password matches first password
    if ($f3->get('password') != $f3->get('password2')) {
        $isValid = false;
        $f3->set("errors['password2']", 'Passwords did not match');
    }

    if (!validMembership($f3->get('membership'))) {
        $isValid = false;
        $f3->set("errors['membership']", 'Not a valid membership option');
    }

    return $isValid;
}

/**
 * This function checks to see that playstyle preferences form
 * is valid.
 *
 * @return boolean
 */
function validForm2()
{
    global $f3;
    $isValid = true;

    if(!validTag($f3->get('tag'))) {
        $isValid = false;
        $f3->set("errors['tag']", 'Please enter a valid id');
    }

    //call validation for region field for pc players only
    if ($_SESSION['user']->getPlatform() == 'pc' && !(isset($_SESSION['platform']) ||
        $_SESSION['platform'] == 'pc')) {
        if(!validRegion($f3->get('region'))) {
            $isValid = false;
            $f3->set("errors['region']", 'Please select a valid region');
        }
    }

    if(!validMic($f3->get('mic'))) {
        $isValid = false;
        $f3->set("errors['mic']", 'Select a valid value');
    }

    if(!validLeadership($f3->get('leadership'))) {
        $isValid = false;
        $f3->set("errors['leadership']", 'Select a valid value');
    }

    return $isValid;
}

/**
 * This function checks to see that hero preferences form
 * is valid.
 *
 * @return boolean
 */
function validForm3()
{
    global $f3;
    $isValid = true;

    //if priority is valid
    if (!validRole($f3->get('role'))) {
        $isValid = false;
        $f3->set("errors['role']", 'Select a valid role');
    }

    //if hero 1 is valid
    if (!validHero($f3->get('hero1'))) {
        $isValid = false;
        $f3->set("errors['hero1']", 'Select a valid hero');
    }
    //if hero 2 is valid
    if (!validHero($f3->get('hero2'))) {
        $isValid = false;
        $f3->set("errors['hero2']", 'Select a valid hero');
    }

    //if hero 3 is valid
    if (!validHero($f3->get('hero3'))) {
        $isValid = false;
        $f3->set("errors['hero3']", 'Select a valid hero');
    }
    return $isValid;
}

/**
 * This function validates that a platform is valid
 *
 * @param String $platform a platform to validate
 * @return boolean
 */
function validPlatform($platform)
{
    global $f3;

    //platform is NOT optional
    if (empty($platform)) {
        return false;
    }
    return array_key_exists($platform, $f3->get('platforms'));
}

/**
 * This function validates that email address is valid value.
 *
 * @param String email An email to validate
 * @return boolean
 */
function validEmail($email)
{
    //return true if valid email and not empty
    return filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($email);
}

/**
 * This function validates that a password is valid value.
 *
 * @param String password A password to validate
 * @return boolean
 */
function validPassword($password)
{
    // alphanumeric, 8-20 chars long, no spaces or special chars
    $regexPattern = "/^[a-zA-Z0-9]{7,19}$/";
    return preg_match($regexPattern, $password);
}

/**
 * This function validates that the Premium account input
 * is a valid value.
 *
 * @param String $membership to validate
 * @return boolean
 */
function validMembership($membership)
{
    global $f3;
    $isValid = true;
    // if it's empty, don't check for in array
    if (!empty($membership)) {
        if (!($membership == $f3->get('memberships'))) {
            $isValid = false;
        }
    }
    return $isValid;
}

/**
 * This function validates that tag is a valid value.
 *
 * @param String tag A user tag to validate
 * @param String user selected platform
 * @return boolean
 */
function validTag($tag)
{
    $isValid = false;
    $platform = $_SESSION['user']->getPlatform();

    if (isset($_SESSION['platform']))
    {
        $platform = $_SESSION['platform'];
    }

    if ($platform == 'pc') {
        /* BattleTag regex - first half must be 3-12 characters long, can only contain
         *                   letters, accented characters, and numbers. Mixed casing
         *                   allowed. Must contain a pound (#) followed by 5-6 numeric
         *                   numbers.
         */
        $regexPattern = "/^[\p{L}\p{Mn}][\p{L}\p{Mn}0-9]{2,11}#[0-9]{4,5}+$/u";
        $isValid = preg_match($regexPattern, $tag);
    }

    elseif ($platform == 'psn') {
        /* Playstation Network ID regex - can only contain letters, numbers, hyphens,
         *                  and underscores, must start with a letter, the
         *                  minimum length 3 characters and the maximum is 16
         */
        $regexPattern = "/^[a-zA-Z]{1}[a-zA-Z0-9_-]{2,15}$/";
        $isValid = preg_match($regexPattern, $tag);
    }

    elseif ($platform == 'xbl') {
        /* Gamertag regex - can only contain letters, numbers, and
         *                  spaces, and can't begin with a number.
         *                  The maximum length of a tag is 15 characters.
         */
        $regexPattern = "/^[a-zA-Z]{1}[a-zA-Z0-9_ ]{0,14}$/";
        $isValid = preg_match($regexPattern, $tag);
    }

    return $isValid;
}

/**
 * This function validates that a User selected region is valid.
 *
 * @param $region User region to validate
 * @return boolean
 */
function validRegion($region)
{
    global $f3;

    //region is NOT an optional field
    if (empty($region)) {
        return false;
    }
    return in_array($region, $f3->get('regions'));
}

/**
 * This function validates a User mic preference.
 *
 * @param int $mic Mic preference to validate
 * @return bool
 */
function validMic($mic)
{
    return in_array($mic, range(1, 5));
}

/**
 * This function validates a User leadership preference.
 *
 * @param int $leadership preference to validate
 * @return boolean
 */
function validLeadership($leadership)
{
    return in_array($leadership, range(-2, 2));
}

/**
 * This function validates a Premium User role priority.
 *
 * @param int $role Role Priority to validate
 * @return boolean
 */
function validRole($role)
{
    return in_array($role, range(1, 3));
}

/**
 * This function validates a PremiumUser selected hero.
 *
 * @param String $hero Selected hero to validate.
 * @return bool
 */
function validHero($hero)
{
    global $f3;
    return array_key_exists($hero, $f3->get('heroes')) || $hero == '';
}
