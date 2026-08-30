<?php
/**
 * FCBKcomplete widget
 * v 1.0
 */
class FCBKcomplete extends CInputWidget {
	/**
	 * Html options that will be assigned to the text area
	 */
	public $htmlOptions = array();
	/**
	 * Debug mode
	 * Used to publish full js file instead of min version
	 */
	public $debugMode = false;
        
        public $data = array();
        
        public $options = array();
        
        public $width = 200;

        public $height = 10;

        public function run() {
	
		// Resolve name and id
		list($name, $id) = $this->resolveNameID();

		// Get assets dir
                $baseDir = dirname(__FILE__);
                $assets = Yii::app()->getAssetManager()->publish($baseDir.DIRECTORY_SEPARATOR.'assets');

		// Publish required assets
		$cs = Yii::app()->getClientScript();
		
		$jsFile = $this->debugMode ? 'jquery.fcbkcomplete.js' : 'jquery.fcbkcomplete.min.js';
		$cs->registerScriptFile($assets.'/' . $jsFile);
		$cs->registerCssFile($assets.'/css/style.css');

                $this->htmlOptions['id'] = $id;
                $this->htmlOptions['class'] = 'hide';

                if (!array_key_exists('height', $this->options)) {
                    $this->options['height'] = $this->height;
                }
                if (!array_key_exists('width', $this->options)) {
                    $this->options['width'] = $this->width;
                }

		$options = CJSON::encode(array_merge($this->options));

		        $js =<<<EOP
		$('#{$id}').fcbkcomplete({$options});
EOP;
                
                if(!empty($this->data)){
                    foreach ($this->data as $key => $value) {
                        $data[$value] = $value;
                    }
                    $this->data = $data;
                }
                
//                $this->data = array(0=>'satu',1=>'dua',2=>'tiga');
		// Register js code
		$cs->registerScript('Yii.'.get_class($this).'#'.$id, $js, CClientScript::POS_READY);
	
		// Do we have a model
		if($this->hasModel()) {
                    $html = $this->activeDropDownList($this->model, $this->attribute, $this->data, $this->htmlOptions);
                } else {
                    $html = $this->dropDownList($name, $this->value, $this->data, $this->htmlOptions);
                }

		echo $html;
    }
    
    protected function activeDropDownList($model,$attribute,$data,$htmlOptions=array())
    {
            CHtml::resolveNameID($model,$attribute,$htmlOptions);
            $selection= CHtml::resolveValue($model,$attribute);
            $options="\n". $this->listOptions($selection,$data,$htmlOptions);
            
            if($model->hasErrors($attribute))
                    CHtml::addErrorCss($htmlOptions);
            if(isset($htmlOptions['multiple']))
            {
                    if(substr($htmlOptions['name'],-2)!=='[]')
                            $htmlOptions['name'].='[]';
            }
            return self::tag('select',$htmlOptions,$options);
    }
    
    protected function dropDownList($name,$select,$data,$htmlOptions=array())
    {
            $htmlOptions['name']=$name;
            if(!isset($htmlOptions['id']))
                    $htmlOptions['id']= CHtml::getIdByName($name);
            else if($htmlOptions['id']===false)
                    unset($htmlOptions['id']);
            
            $options="\n".$this->listOptions($select,$data,$htmlOptions);
            return self::tag('select',$htmlOptions,$options);
    }
    
    public static function tag($tag,$htmlOptions=array(),$content=false,$closeTag=true)
    {
            $html='<' . $tag . CHtml::renderAttributes($htmlOptions);
            if($content===false)
                    return $closeTag ? $html.' />' : $html.'>';
            else
                    return $closeTag ? $html.'>'.$content.'</'.$tag.'>' : $html.'>'.$content;
    }
    
    public static function listOptions($selection,$listData,&$htmlOptions)
    {
            $raw=isset($htmlOptions['encode']) && !$htmlOptions['encode'];
            $content='';
            
            foreach($listData as $key=>$value)
            {
                if(trim($value!='')){
                    $attributes=array('value'=>(string)$key, 'encode'=>!$raw);
                    $attributes['selected']='selected';
                    $attributes['class']='selected';
                    $content.=self::tag('option',$attributes,$raw?(string)$value : CHtml::encode((string)$value))."\n";
                }
            }

            unset($htmlOptions['key']);

            return $content;
    }
}
?>
