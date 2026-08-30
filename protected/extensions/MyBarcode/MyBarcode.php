<?php

class MyBarcode extends CWidget
{
    public $imageOptions=array();
    public $barcodeAction = 'myBarcode';
    public $code;

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
            if(!isset($this->imageOptions['id']))
                    $this->imageOptions['id']=$this->getId();

            $url=$this->getController()->createUrl($this->barcodeAction,
                array(
                    'code'=>$this->code,
                    'is_text'=>(isset($this->imageOptions['alt'])?true:false)
                )
            );
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
