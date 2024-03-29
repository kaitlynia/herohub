<?php
//Name: Alicia Buehner, Evan Wheeler
//Date: 6/10/19
//Description: This file defines the PremiumUser class that has access to hero preferences, role priority

class PremiumUser extends User
{
    private $_heroes;
    private $_role;

    /**
     * PremiumUser constructor.
     *
     * @param string $platform string
     * @param string $email string
     * @param string $passhash string
     */
    public function __construct($platform, $email, $passhash)
    {
        parent::__construct($platform, $email, $passhash);
    }

    /**
     * Gets the PremiumUser hero selections.
     *
     * @return array PremiumUser heroes
     */
    public function getHeroes()
    {
        return $this->_heroes;
    }

    /**
     * Sets the hero selections for a PremiumUser.
     *
     * $heroes must be exactly 3 elements long and contain valid heroes:
     *
     *  array('ana', 'ashe', 'baptiste', 'bastion', 'brigitte', 'doomfist', 'dVa',
     * 'genji', 'hanzo', 'junkrat', 'lucio', 'mccree', 'mei', 'mercy', 'moira',
     * 'orisa', 'pharah', 'reaper', 'reinhardt', 'roadhog', 'soldier76', 'sombra',
     * 'symmetra', 'torbjorn', 'tracer', 'widowmaker', 'winston', 'wreckingBall',
     * 'zarya', 'zenyatta')
     *
     * @param array $heroes
     */
    public function setHeroes($heroes)
    {
        $this->_heroes = $heroes;
    }

    /**
     * Gets the PremiumUser class role priority.
     *
     * @return int PremiumUser role priority.
     */
    public function getRole()
    {
        return $this->_role;
    }

    /**
     * Sets the role priority
     *
     * @param int $role
     */
    public function setRole($role)
    {
        $this->_role = $role;
    }
}