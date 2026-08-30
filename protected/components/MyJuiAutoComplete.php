<?php

Yii::import('zii.widgets.jui.CJuiAutoComplete');

class MyJuiAutoComplete extends CJuiAutoComplete
{
        /**
	 * @var mixed the entries that the autocomplete should choose from. This can be
	 * <ul>
	 * <li>an Array with local data</li>
         * <li>a String, specifying a URL that returns JSON data as the entries.</li>
         * <li>a javascript callback. Please make sure you prefix the callback name with "js:" in this case.</li>
         * </ul>
	 */
	public $source = array();
	/**
	 * @var mixed the URL that will return JSON data as the autocomplete items.
	 * CHtml::normalizeUrl() will be applied to this property to convert the property
	 * into a proper URL. When this property is set, the {@link source} property will be ignored.
	 */
	public $sourceUrl;
        
        /**
         *untuk menambahkan satu tombol untuk menampilkan dialog
         * @var type array()
         */
        public $tombolDialog = array();
        
        /**
         *untuk menambahkan satu tombol untuk menampilkan modal dialog
         * @var type array()
         */
        public $tombolModal = array();
        
        /**
         *untuk menambahkan satu atau lebih tombol untuk menampilkan dialog
         * @var type array()
         */
        public $tombolDialogS = array();
		
		public $htmlStyle = false;

	/**
	 * Run this widget.
	 * This method registers necessary javascript and renders the needed HTML code.
	 */
	public function run()
	{
		if ($this->htmlStyle == false){
            $this->htmlOptions['style'] = 'float:left;';
		}else{
			$this->htmlOptions['style'] = $this->htmlOptions['style'];
		}
		list($name,$id)=$this->resolveNameID();

		if(isset($this->htmlOptions['id']))
			$id=$this->htmlOptions['id'];
		else
			$this->htmlOptions['id']=$id;

		if(isset($this->htmlOptions['name']))
			$name=$this->htmlOptions['name'];

                echo '<div class="input-append">';
		if($this->hasModel())
			echo CHtml::activeTextField($this->model,$this->attribute,$this->htmlOptions);
		else
			echo CHtml::textField($name,$this->value,$this->htmlOptions);
                if(!empty($this->tombolModal['idModal']))
                {
					if ($this->htmlStyle == false){
						echo '<span class="add-on">';
					}else{
						echo '<span class="add-on-center">';
					}
                    echo CHtml::link('<i class="icon-list"></i><i class="entypo-search"></i>', 'javascript:void(0);', 
                        array(
                            'onclick'=>(empty($this->tombolModal['jsFunction'])) ? '$("#'.$this->tombolModal['idModal'].'").modal("show");return false;' : $this->tombolModal['jsFunction'],
                            'id'=>(!empty($this->tombolModal['idTombol'])) ? $this->tombolModal['idTombol']:'',
                        )
                    );
                    echo '</span>';                    
                } else if(!empty($this->tombolDialog['idDialog']))
                {
                    if ($this->htmlStyle == false){
						echo '<span class="add-on">';
					}else{
						echo '<span class="add-on-center">';
					}
                    echo CHtml::link('<i class="icon-list"></i><i class="entypo-search"></i>', 'javascript:void(0);', 
                        array(
                            'onclick'=>(empty($this->tombolDialog['jsFunction'])) ? '$("#'.$this->tombolDialog['idDialog'].'").dialog("open");return false;' : $this->tombolDialog['jsFunction'],
                            'id'=>(!empty($this->tombolDialog['idTombol'])) ? $this->tombolDialog['idTombol']:'',
                        )
                    );
                    echo '</span>';
                } else if(!empty($this->tombolDialogS)){
                    if ($this->htmlStyle == false){
						echo '<span class="add-on">';
					}else{
						echo '<span class="add-on-center">';
					}
                    foreach($this->tombolDialogS as $i=>$tombol)
                    {
                        echo CHtml::link('<i class="icon-list"></i><i class="entypo-search"></i>', 'javascript:void(0);', 
                            array(
                                'onclick'=>(empty($tombol['jsFunction'])) ? '$("#'.$tombol['idDialog'].'").dialog("open");return false;' : $tombol['jsFunction'],
                                'id'=>(!empty($tombol['idTombol'])) ? $tombol['idTombol']:'',
                            )
                        );
                    }
                    echo '</span>';
                } else {
					if ($this->htmlStyle == false){
						echo '<span class="add-on"><i class="icon-list"></i></span>';
					}else{
						echo '<span class="add-on-center"><i class="icon-list"></i></span>';
					}
                        
                }
                echo '</div>';

		if($this->sourceUrl!==null)
			$this->options['source']=CHtml::normalizeUrl($this->sourceUrl);
		else
			$this->options['source']=$this->source;

		$options=CJavaScript::encode($this->options);

		$js = "jQuery('#{$id}').autocomplete($options);";

		$cs = Yii::app()->getClientScript();
		$cs->registerScript(__CLASS__.'#'.$id, $js);
	}
}
?>
