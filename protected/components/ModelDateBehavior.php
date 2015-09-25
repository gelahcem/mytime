<?php

/**
 * Description of ModelDateBehavior
 *
 * @author Marco Careddu
 */
class ModelDateBehavior extends CModelBehavior {
    
    public $createDateField;
    public $updateDateField;
    public $deleteDateField;
    
    // correctly date formatted properties
    public function getCreateDateCustom() {
        if($this->createDateField && isset($this->owner->{$this->createDateField})) {
            $dt=$this->_toLocalTimeZone($this->owner->{$this->createDateField});
            return $dt->format(Yii::app()->params['stdDateDisplayFormat']);
        }
        else return null;
    }
    
    public function getUpdateDateCustom() {
        if($this->updateDateField && isset($this->owner->{$this->updateDateField})) {
            $dt=$this->_toLocalTimeZone($this->owner->{$this->updateDateField});
            return $dt->format(Yii::app()->params['stdDateDisplayFormat']);
        }
        else return null;
    }
    
    public function getDeleteDateCustom() {
        if($this->deleteDateField && isset($this->owner->{$this->deleteDateField})) {
            $dt=$this->_toLocalTimeZone($this->owner->{$this->deleteDateField});
            return $dt->format(Yii::app()->params['stdDateDisplayFormat']);
        }
        else return null;
    }
    
    /**
     * Convert a datetime in UTC in a datetime in local timezone
     * @param string $datetime UTC datetime in Y-m-d H:i:S
     * @return DateTime Local timezone datetime in Y-m-d H:i:S
     */
    private function _toLocalTimeZone($datetime) {
         // create a new DateTime object with the time from the database
        // and the timezone of GMT
        $date = new DateTime($datetime, new DateTimeZone('GMT'));
        // translate to the system timezone
        return $date->setTimezone(new DateTimeZone(Yii::app()->timeZone));
    }
    
}

?>
