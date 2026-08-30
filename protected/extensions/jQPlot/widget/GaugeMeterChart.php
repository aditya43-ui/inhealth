<?php
Yii::import('ext.jQPlot.widget.plotWidget');
class GaugeMeterChart extends plotWidget {

    public $template = '{items}';

    /**
     * Renders the widget.
     */
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
            if (isset($this->autoUpdate['url'])){
                $this->renderAutoUpdate();
            }
        }
    }
    
    /**
     * create script to render graph dinamically on head so you can call in body
     * @return string
     */
    public function renderEmbedScript(){
        $id = $this->htmlOptions['id'];
        if (count($this->rendererOptions) > 0){
            $rendererOptions = json_encode($this->rendererOptions);
            $rendererOptions = ",rendererOptions: $rendererOptions";
        }
        return "
        function setValue_$id(obj){
           var_$id = obj;
          
           plot_$id = $.jqplot('$id',[[var_$id]],{
               seriesDefaults: {
                   renderer: $.jqplot.MeterGaugeRenderer,
                   animation: {
                        show: true
                   }
                   $rendererOptions
               }
           })
        }";
    }

    /**
     * with parameter id and script you create core of graph in ready
     * @param type string
     * @param type string
     */
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
        $cs->registerScriptFile($baseUrl . '/plugins/jqplot.meterGaugeRenderer.min.js', CClientScript::POS_HEAD);
//        $cs->registerScriptFile($baseUrl . '/plugins/jqplot.highlighter.min.js', CClientScript::POS_HEAD);
//        $cs->registerScriptFile($baseUrl . '/plugins/jqplot.cursor.min.js', CClientScript::POS_HEAD);
//        $cs->registerScriptFile($baseUrl . '/plugins/jqplot.logAxisRenderer.min.js', CClientScript::POS_HEAD);
//        $cs->registerScriptFile($baseUrl . '/plugins/jqplot.canvasTextRenderer.min.js', CClientScript::POS_HEAD);
//        $cs->registerScriptFile($baseUrl . '/plugins/jqplot.canvasAxisLabelRenderer.min.js', CClientScript::POS_HEAD);
//        $cs->registerScriptFile($baseUrl . '/plugins/jqplot.canvasAxisTickRenderer.min.js', CClientScript::POS_HEAD);
//        $cs->registerScriptFile($baseUrl . '/plugins/jqplot.dateAxisRenderer.min.js', CClientScript::POS_HEAD);
//        $cs->registerScriptFile($baseUrl . '/plugins/jqplot.pointLabels.min.js', CClientScript::POS_HEAD);
//        $cs->registerScriptFile($baseUrl . '/plugins/jqplot.barRenderer.min.js', CClientScript::POS_HEAD);
//        $cs->registerScriptFile($baseUrl . '/plugins/jqplot.categoryAxisRenderer.min.js', CClientScript::POS_HEAD);
//        $cs->registerScriptFile($baseUrl . '/plugins/jqplot.pieRenderer.min.js', CClientScript::POS_HEAD);
    }
}