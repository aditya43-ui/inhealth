<?php

class MyOdontogram extends CWidget
{
    public $imageOptions=array();
    public $odontogramAction = 'myOdontogram';
    
    /**
     * untuk kode warna, r=red, w=white, n=black, g=green, b=blue
     * searah jarum jam, misal : rwwwg
     * @var type string
     */
    public $code = '';

    /**
     * Renders the widget.
     */
    public function run()
    {
        if(self::checkRequirements()) {
            $this->renderImage();
        } else
            throw new CException(Yii::t('yii','GD and FreeType PHP extensions are required.'));
    }
    
    protected function renderImage()
    {
            if(!empty($_GET['code']))
                $this->code = $_GET['code'];
            
            if(!isset($this->imageOptions['id']))
                $this->imageOptions['id']=$this->getId();

            $url=$this->getController()->createUrl($this->odontogramAction,array('code'=>$this->code));
            $alt=isset($this->imageOptions['alt'])?$this->imageOptions['alt']:'';
            echo CHtml::image($url,$alt,$this->imageOptions);
    }
    
    /**
     * Checks if GD with FreeType support is loaded.
     * @return boolean true if GD with FreeType support is loaded, otherwise false
     * @since 1.1.5
     */
    public static function checkRequirements()
    {
            if (extension_loaded('gd'))
            {
                    $gdinfo=gd_info();
                    if( $gdinfo['FreeType Support'])
                            return true;
            }
            return false;
    }
}   
?>
