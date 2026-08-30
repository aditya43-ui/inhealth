<?php 

/**
 * SATipeanastesiM akan di extends ke TypeAnastesiM yang global.
 * @param string $className active record class name.
 */

class SATipeanastesiM extends TypeAnastesiM
{
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
}
?>