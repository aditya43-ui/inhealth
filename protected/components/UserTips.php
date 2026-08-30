<?php
/**
 * Class untuk mengenerate Tips/Petunjuk pembuatan master data
 */

class UserTips extends CWidget
{   
    public $type; //type sudah tidak digunakan
    public $content;
    public function run()
    {
         $this->render('userTips/tipsDefault',array('content'=>$this->content));
    }
}
?>
