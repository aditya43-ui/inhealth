<?php
class plotWidget extends CWidget {
       
    const plugin_highlighter = 'highlighter';
    
    public $rendererOptions = array();
    public $renderer = ''; 
    public $dataProvider;
    public $value;
    public $htmlOptions = array();
    public $autoUpdate = array();
    
    public function run(){
        if (empty($this->htmlOptions['id'])){
            $this->htmlOptions['id'] = $this->getId();
        }
    }
    
    public function init(){
        if($this->dataProvider===null && (is_null($this->value)))
			throw new CException(Yii::t('zii','The "dataProvider" or "value" property cannot be empty.'));
    }
    
    /**
     * method to create an ajax post to create autoupdate function so the action controller can post value
     */
    public function renderAutoUpdate(){
        $url = $this->autoUpdate['url'];
        $id = $this->htmlOptions['id'];
        Yii::app()->clientScript->registerScript(
            "autoupdate".$id,"
                setInterval(function() {
                    ".((!is_null($this->autoUpdate['bind']['form'])) ? "kirim = $('".$this->autoUpdate['bind']['form']."').serialize();\n$.post('index.php?'+kirim,{data:1,data_id:'$id'},function(hasil){" : "$.post('$url',{data:1,data_id:'$id'},function(hasil){")."
                        plot_$id.destroy();
                        setValue_$id(hasil);
                    });
                },3000);
            ",  CClientScript::POS_READY
        );
    }

}