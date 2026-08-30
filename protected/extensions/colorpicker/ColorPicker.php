<?php
/**
 * Redactorjs widget
 *
 * @author Vincent Gabriel
 * v 1.0
 */
class ColorPicker extends CInputWidget {
	/**
	 * Editor language
	 * Supports: de, en, fr, lv, pl, pt_br, ru, ua
	 */
	//public $lang = 'en';
	/**
	 * Editor toolbar
	 * Supports: default, mini
	 */
	//public $toolbar = 'default';
	/**
	 * Html options that will be assigned to the text area
	 */
	public $htmlOptions = array();
	/**
	 * Editor options that will be passed to the editor
	 */
	public $colorOptions = array();
        public $colors = array();
        
        //public $colorsDefault = array("ffffff", "000000", "111FFF", "C0C0C0", "FFF000");
        public $pickerDefault = '';
        //public $warnaValue;
        public $swatch = false;
        
        public $disable;
	/**
	 * Debug mode
	 * Used to publish full js file instead of min version
	 */
	//public $debugMode = false;
	/**
	 * Editor width
	 */
        
	public $width = '';
	/**
	 * Editor height
	 */
	public $height = '';
        
        public $rel = 'colorPicker';
	/**
	 * Display editor
	 */
    public function run() {
	
		// Resolve name and id
        list($name, $id) = $this->resolveNameID();

		// Get assets dir
        $baseDir = dirname(__FILE__);
        $assets = Yii::app()->getAssetManager()->publish($baseDir.DIRECTORY_SEPARATOR.'assets');

		// Publish required assets
        $cs = Yii::app()->getClientScript();
        
        if (empty($this->colors)){
            $colors = array();
            $this->height = '30px';
        }
        else{
            $colors = array('colors' => $this->colors);
        }
        
        $this->style();
        
        $jsFile = 'jquery.colorPicker.js';
        $cs->registerScriptFile($assets.'/' . $jsFile);
        $cs->registerCssFile($assets.'/colorPicker.css');
        
        $this->htmlOptions['id'] = $id;
        if (!empty($this->colors)){
            $this->htmlOptions['colors'] = implode(',', $this->colors);
        }
        $this->htmlOptions['rel'] = $this->rel;
        //$this->htmlOptions['warnaValue'] = $this->warnaValue;
        
        $options = CJSON::encode(array_merge($this->colorOptions,$colors));
        
                $js =<<<EOP
        $('input[rel="{$this->rel}"]').colorPicker({$options});
EOP;
        // Register js code
        $cs->registerScript('Yii.'.get_class($this).'#'.$id, $js, CClientScript::POS_READY);

        // Do we have a model
        if($this->hasModel()) {
            $html = CHtml::activeTextField($this->model, $this->attribute, $this->htmlOptions);
        } else {
            $html = CHtml::textField($name, $this->value, $this->htmlOptions);
        }

		echo $html;
    }
    
    protected function style(){
        
        if (!empty($this->width)){
            $this->width = str_replace("px", "", strtolower($this->width));
        }
        
        echo '<style>'.PHP_EOL;
        echo 'div.colorPicker-swatch {'.PHP_EOL;
        if ($this->swatch == true){
            echo 'height: 20px;'.PHP_EOL;
            echo 'width: 20px;'.PHP_EOL;                      
        }else{
            if (!empty($this->height))
                echo 'height: '.$this->height.';'.PHP_EOL;
            if (!empty($this->width))
                echo 'width: '.($this->width-10).'px;'.PHP_EOL;               
        }
        echo '}'.PHP_EOL;
        echo 'div.colorPicker-picker {'.PHP_EOL;
        if (!empty($this->height))
            echo 'height: '.$this->height.';'.PHP_EOL;
        if (!empty($this->width))
            echo 'width: '.$this->width.'px;'.PHP_EOL;                      
        echo '}'.PHP_EOL;
        echo 'div.colorPicker-palette{'.PHP_EOL;
        echo 'width:'.($this->width-4).'px;'.PHP_EOL;
        echo '}'.PHP_EOL;
        
        if ($this->disable == true){
            echo '.colorPicker_palette-1{';
            echo 'display:none;';
            echo '}';
        }
        echo '</style>'.PHP_EOL;
    }
    
}
?>
