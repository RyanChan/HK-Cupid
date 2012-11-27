<?php
class Champs_Utility_Helper{
    /**
     * Returns variable name if found. Otherwise, return false.
     *
     * @param type $variable
     * @return boolean|string
     */
    public static function GetVariableName($variable){
        foreach ($GLOBALS as $var_name => $value){
            if ($value == $variable)
                return $var_name;
        }
        return false;
    }
}