<?php

/**
 * Helper class for generic purposes (controllers etc.)
 *
 * @author Carlos Manzo
 */
class UtilityHelper {
    
    /**
     * Retrieve ID..
     * The predefined source is the db table timesheet.
     * @return string the string in integer format. Return false if not found (tipically errors).
     */
    public static function sa() {
            $res = '2015-09-04';
            return "{$res}";
    }
}