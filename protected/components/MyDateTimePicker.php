<?php
Yii::import('ext.CJuiDateTimePicker.CJuiDateTimePicker');
class MyDateTimePicker extends CJuiDateTimePicker
{
    public $gridFilter = false;
    public $clearable = false;
    public $realtime = false;
    public function run()
    {
            $this->options['timeText'] = 'Waktu';
            $this->options['hourText'] = 'Jam';
            $this->options['minuteText'] = 'Menit';
            $this->options['secondText'] = 'Detik';
            $this->options['showSecond'] = true;
            $this->options['timeOnlyTitle'] = 'Pilih Waktu';
            $this->options['timeFormat'] = 'hh:mm:ss';
            $this->options['changeYear'] = true;
            $this->options['changeMonth'] = true;
           
            if (!isset($this->options['showAnim'])) {
                $this->options['showAnim'] = 'fold';
            }
            if (!isset($this->options['yearRange'])){
                $this->options['yearRange'] = '-80y:+20y';
            }
        
            list($name,$id)=$this->resolveNameID();

            if(isset($this->htmlOptions['id']))
                    $id=$this->htmlOptions['id'];
            else
                    $this->htmlOptions['id']=$id;
            if(isset($this->htmlOptions['name']))
                    $name=$this->htmlOptions['name'];
            else
                    $this->htmlOptions['name']=$name;
            
            
            if($this->gridFilter == true){
                    if($this->mode == "datetime"){
                            $width = "width:150px;";
                    }else{
                            $width = "width:100px;";
                    }
                    $this->htmlOptions['style'] = $width."float:left;";
            }
            
            if ($this->realtime == true) {
                if (isset($this->htmlOptions['class'])) {
                    $this->htmlOptions['class'] .= " realtime ";
                } else {
                    $this->htmlOptions['class'] = "realtime ";
                }
            }

            if($this->hasModel()) {
                if ($this->cekIsBackdate()) {
                    $this->textFieldAppend(CHtml::activeTextField($this->model,$this->attribute,$this->htmlOptions));
                } else {
                    echo CHtml::activeTextField($this->model,$this->attribute,$this->htmlOptions);
                }
            } else {
                    $this->textFieldAppend(CHtml::textField($name,$this->value,$this->htmlOptions));
            }
            
            $options=CJavaScript::encode($this->options);
            
            $id_date = $id . '_date';
            $id_date_hapus = $id . '_date_clear';
            $js = "jQuery('#{$id}').{$this->mode}picker($options);";
            $js_date = "jQuery('#{$id_date}').on('click', function(){jQuery('#{$id}').datepicker('show');});";
            $js_date_hapus = "jQuery('#{$id_date_hapus}').on('click', function(){jQuery('#{$id}').val('');});";
            
            if (isset($this->language)){
                    $this->registerScriptFile($this->i18nScriptFile);
                    $js = "jQuery('#{$id}').{$this->mode}picker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional['{$this->language}'], {$options}));";
            }

            $cs = Yii::app()->getClientScript();

            $assets = Yii::app()->getAssetManager()->publish(dirname(__FILE__).DIRECTORY_SEPARATOR.'assets');
            $cs->registerCssFile($assets.self::ASSETS_NAME.'.css');
            $cs->registerScriptFile($assets.self::ASSETS_NAME.'.js',CClientScript::POS_END);

            $cs->registerScript(__CLASS__, 	$this->defaultOptions?'jQuery.{$this->mode}picker.setDefaults('.CJavaScript::encode($this->defaultOptions).');':'');
            $cs->registerScript(__CLASS__.'#'.$id, $js);
            $cs->registerScript(__CLASS__.'#'.$id_date, $js_date);     
            if ($this->clearable) {
                $cs->registerScript(__CLASS__.'#'.$id_date_hapus, $js_date_hapus);   
            }

    }
    
    public function cekIsBackdate() {
        $modul = Yii::app()->controller->module;
        
        if (empty($modul) || empty($this->attribute)) {
            return null;
        }
        
        $cr = new CDbCriteria;
        $cr->join = "join modul_k k on k.modul_id = t.modul_id";
        $cr->compare("lower(k.url_modul)", strtolower($modul->id));
        $cr->compare("lower(t.deskripsi_backdate)", $this->attribute);
        $cr->select = "t.backdate_id, t.isbackdate";
        
        $mod = BackdateK::model()->find($cr);
        
        if (empty($mod)) {
            return true;
        }
        
        return $mod->isbackdate;
    }
    
    private function textFieldAppend($dateTimeInput)
    {
        switch($this->mode){
            case 'date' : $span = '<span id ="'. $this->htmlOptions['id'] . '_date' .'" class="add-on"><i class="entypo-calendar"></i></span>';break;
            case 'time' : $span = '<span id ="'. $this->htmlOptions['id'] . '_date' .'" class="add-on"><i class="icon-time"></i></span>';break;
            case 'datetime' : $span = '<span id ="'. $this->htmlOptions['id'] . '_date' .'" class="add-on"><i class="entypo-calendar"></i><i class="icon-time"></i></span>';break;
            default : $span = '';
        }
        
        if ($this->clearable) {
            $span .= '<span id ="'. $this->htmlOptions['id'] . '_date_clear' .'" class="add-on"><i class="icon-remove"></i></span>';
        }
        
        if (isset($this->htmlOptions['append']))
            if ($this->htmlOptions['append'] == 'hide')
                $span = '';
            
        
        if (!isset($this->htmlOptions['hide'])){
            if (!isset($this->options['line'])){
                echo '<div class="input-append">';
            }
            echo $dateTimeInput;
            echo $span;
            if (!isset($this->options['line'])){
                echo '</div>';
            }
            
        }
    }
}
?>