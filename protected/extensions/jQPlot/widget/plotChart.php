<?php
Yii::import('ext.jQPlot.widget.plotWidget');
class plotChart extends plotWidget {
    const TIPE_BATANG = 'batang';
    const TIPE_PIE = 'pie';
    const TIPE_GARIS = 'garis';
    
    public $template = '{items}';
    public $type = self::TIPE_BATANG;
    
    public function run() {
        parent::run();
        if (count($this->dataProvider->getData()) < 1){
            echo '<p>Data Grafik Tidak Ditemukan</p>';
        }
        else{
            echo CHtml::openTag('div', $this->htmlOptions);
                
            echo CHtml::closeTag('div');
            $embeddedScript = $this->renderEmbedScript();
            $this->registerScripts($this->htmlOptions['id'], $embeddedScript);
            if (!is_null($this->autoUpdate['url'])){
                $this->renderAutoUpdate();
            }
        }
    }
    
    public function renderEmbedScript(){
        $id = $this->htmlOptions['id'];
        if (count($this->rendererOptions) > 0){
            $rendererOptions = json_encode($this->rendererOptions);
            $rendererOptions = ",rendererOptions: $rendererOptions";
        }
        return "
        function setValue_$id(obj){
           var_$id = obj;
           $id = $.jqplot('$id',[[var_$id]],{
               seriesDefaults: {
                   renderer: $.jqplot.BarRenderer,
                   animation: {
                        show: true
                   }
                   $rendererOptions
               }
           })
        }";
    }

    protected function registerScripts($id, $embeddedScript) {
        $basePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . '../assets' . DIRECTORY_SEPARATOR;
        $baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);
        $scriptFile = '/jquery.jqplot.min.js';
        $css = '/jquery.jqplot.min.css';

        $cs = Yii::app()->clientScript;
        $cs->registerCoreScript('jquery');
        $cs->registerCssFile($baseUrl . $css);
        $this->registerChartPlugins();
        if (!is_null($this->dataProvider)){
            $value = $this->dataProvider->totalItemCount;
        }else{
            $value = $this->value;
        }
        $cs->registerScript($id, $embeddedScript, CClientScript::POS_HEAD);
        $cs->registerScript('setvalue_'.$id, 'setValue_'.$id."($value);", CClientScript::POS_READY);
    }

    protected function registerChartPlugins() {
        $basePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . '../assets' . DIRECTORY_SEPARATOR;
        $baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);
        $cs = Yii::app()->clientScript;
        $cs->registerScriptFile($baseUrl . '/jquery.jqplot.min.js', CClientScript::POS_HEAD);
        if ($this->type === self::TIPE_BATANG){
            $cs->registerScriptFile($baseUrl . '/plugins/jqplot.barRenderer.min.js', CClientScript::POS_HEAD);
        }
    }
}
