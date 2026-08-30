<?php

class MATeknisipemeliharaanasetT extends TeknisipemeliharaanasetT
{     
    public $internal_id, $eksternal_id;
    
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }	
}
?>
