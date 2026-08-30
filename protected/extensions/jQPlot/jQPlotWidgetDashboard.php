<?php

/**
 * jQPlotWidget class file.
 *
 * @version 0.1
 */
Yii::import('zii.widgets.CBaseListView');

class jQPlotWidgetDashboard extends CBaseListView {
    const TIPE_BATANG = 'batang';
    const TIPE_PIE = 'pie';
    const TIPE_GARIS = 'garis';

    public $action = array();
    public $options = array();
    public $htmlOptions = array();
    public $type = 'batang'; //batang, pie, garis
    public $template = '{items}';
    public $data = array();
    public $title = array();
    public $autoUpdate = array();
    public $setFunction = false;

    /**
     * Renders the widget.
     */
    public function run() {
        $id = $this->getId();
        $this->htmlOptions['id'] = $id;
        $type = $this->type;
        if (count($this->dataProvider->getData()) > 0){
            echo CHtml::openTag('div', $this->htmlOptions);

            echo CHtml::closeTag('div');

            parent::run();

            $jsOptions = json_encode($this->data);

            if (strtolower($this->type) == self::TIPE_BATANG) {
                $this->options['seriesDefaults']['renderer'] = $this->typeBatang();
            } else if (strtolower($this->type) == self::TIPE_PIE) {
                $this->options['seriesDefaults']['renderer'] = $this->typePie();
                unset($this->options['axes']);
            } else if (strtolower($this->type) == self::TIPE_GARIS){
                $this->options['seriesDefaults']['renderer'] = $this->typeGaris();
            }

            $options = CJavaScript::encode($this->options);

            $script = <<< JS
                var plot_${id} = $.jqplot('${id}',${jsOptions},${options});
JS;
                
                
            $this->registerScripts(__CLASS__ . '#' . $id, $script);
            $this->registerChartProcessScript($id);
            if(isset($this->autoUpdate['url'])){
                if (!is_null($this->autoUpdate['url'])){
                    $this->renderAutoUpdate();
                }                
            }
        }
        else{
            echo '<p>Data Grafik Tidak Ditemukan</p>';
        }
        
    }

    /**
     * this method is totally a messed i will fix it soon 
     */
    public function renderItems() {
//        $seriesNames = $this->dataProvider->model->attributeNames();
        $data = $this->dataProvider->getData();
        $this->data['yData'] = 'data';
        $this->data['xData'] = 'jumlah';
        $ySeries = $this->data['yData'];
        $xSeries = $this->data['xData'];
        $xSeries = 'data';
        $this->data['ticks'] = 'tick';

        foreach ($data as $i=>$x){
            $tick = (isset($x['tick']) ? $x['tick'] : '');
            if ($tick == '')
            {
                $this->data['ticks'] = '';
                $dataTicks = '';
            }
        }
        
//        $this->options['axesDefaults']['max'] = $this->valueMax($ySeries)+10;        
        $this->options['axes']['yaxis']['tickOptions']['formatString'] = '%d';
        $this->options['axesDefaults']['min'] = -1;
        $this->options['axesDefaults']['pad'] = 5;
        if ($this->dataProvider->getTotalItemCount() > 5){
            $this->options['axesDefaults']['tickOptions']['angle'] = -30;
        }else{
            $this->options['axesDefaults']['tickOptions']['angle'] = 0;
        }
        $this->options['legend'] = array('show' => true, 'location' => 'n');
            
        if ($this->type == self::TIPE_PIE){
            if (!empty($this->data['ticks'])){
                $xSeries = $this->data['ticks'];
            }
            $this->data['ticks'] = '';
            $this->options['legend'] = array('show' => true, 'location' => 'e');
            $this->options['seriesDefaults']['rendererOptions']['showDataLabels'] = true;
        }

        $dataTicks = $this->data['ticks'];
        
        if (!empty($dataTicks)) {
            if ((count($this->getLabel($xSeries))*count($this->setGroup($this->data['ticks']))) > 12){
                unset($this->options['seriesDefaults']['rendererOptions']['barWidth']);
                $this->options['legend'] = array('show' => true, 'location'=>'e', 'placement'=>'outsideGrid');
            }
            $yData = $this->getTicks($dataTicks);
            $xData = $this->setGroup($xSeries);
            $label = $this->getLabel($xSeries);

            $varx = array();            
            foreach ($this->setGroup($xSeries) as $i => $v){
                $var1 = array();
                foreach ($this->setGroup($dataTicks) as $j => $val){
                    $var2 = 0;
                    foreach ($data as $x => $value){
                        if ($value[$dataTicks] == $val && $value[$xSeries] == $v){
                            $var2 += $value[$ySeries];
                        }
                    }
                    if ($var2 > 0){
                        $var1[] = $var2;
                    }
                    else{
                        $var1[] = null;
                    }
                }
                $varx[] = $var1;
            }
                       
            $this->options['series'] = $label;
//            $this->options['legend'] = array('show' => true, 'location' => "n");
            $this->options['axes']['xaxis']['ticks'] = $yData;
            $datax = $varx;
        }
        else{
            $ticks = $this->options['axes']['xaxis']['ticks'];

            $datax = array();
            if (count($data)>0){
                if (isset($xSeries) && !is_array($xSeries)) {
                    if (isset($ySeries) && !is_array($ySeries)) {

                        $seriesData = array();
                        foreach ($this->setGroup($xSeries) as $v){
                            $x = 0;
                            foreach ($data as $j => $val) {
                                if ($val[$xSeries] == $v){
                                    $x += floatval($val[$ySeries]);
                                }
                            }
                            $seriesData[] = array($v, $x);
                        }
                        if(isset($this->dataProvider->model)){
                            $serisName = $this->dataProvider->model->getAttributeLabel("$ySeries");
                        }else{
                            $serisName = 'Jumlah';
                        }
                        $this->options['series'] = array(array('label'=>$serisName));
                        $datax[] = $seriesData;
                    }

                    if (isset($ySeries) && is_array($ySeries)){

                        $datax = array();
                        $value = array();

                        foreach($ySeries as $i => $v){

                            $seriesData = array();
                            $x = 0;
                            $ticker = array();
                            $vals = array();
                            foreach ($data as $j => $val) {
                                if (empty($val[$v])){
                                    $val[$v]=0;
                                }
                                if (is_array($v)){
                                    $seriesData[] = array($val[$xSeries], $v[$j]);
                                }else{
                                    if ($ticks == true){
                                        $vals[] = floor($val[$v]);
                                        $ticker[] = "$val[$xSeries]";
                                    } else {
                                        $seriesData[] = array($val[$xSeries], floatval($val[$v]));
                                    }
                                }
                            }
                            $value[] = $vals;
                            $datax[] = $seriesData;

                        }
                    }
                }
            }
            else{
                $datax[] = array(null);

            }

            if (isset($value)){
                $datax = $value;
            }

            if (isset($ticker)){
                $this->options['axes']['xaxis']['ticks'] = $ticker;
            }

            if (empty($data)){
               if ($ticks == true){
                    $datax = $ticks = array(array(array()));
               }
            }
        }
        $this->data = $datax;
    }

    protected function registerScripts($id, $embeddedScript) {
        $basePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR;
        $baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);
        $scriptFile = '/jquery.jqplot.min.js';
        $css = '/jquery.jqplot.min.css';

        $cs = Yii::app()->clientScript;
        $cs->registerCoreScript('jquery');
        $cs->registerCssFile($baseUrl . $css);

        $cs->registerScript($id, $embeddedScript, CClientScript::POS_READY);
    }

    protected function registerChartProcessScript($id) {
        $basePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR;
        $baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);
        $cs = Yii::app()->clientScript;
        $cs->registerScriptFile($baseUrl . '/jquery.jqplot.min.js', CClientScript::POS_HEAD);
        $cs->registerScriptFile($baseUrl . '/plugins/jqplot.highlighter.min.js', CClientScript::POS_HEAD);
        $cs->registerScriptFile($baseUrl . '/plugins/jqplot.cursor.min.js', CClientScript::POS_HEAD);
        $cs->registerScriptFile($baseUrl . '/plugins/jqplot.logAxisRenderer.min.js', CClientScript::POS_HEAD);
        $cs->registerScriptFile($baseUrl . '/plugins/jqplot.canvasTextRenderer.min.js', CClientScript::POS_HEAD);
        $cs->registerScriptFile($baseUrl . '/plugins/jqplot.canvasAxisLabelRenderer.min.js', CClientScript::POS_HEAD);
        $cs->registerScriptFile($baseUrl . '/plugins/jqplot.canvasAxisTickRenderer.min.js', CClientScript::POS_HEAD);
        $cs->registerScriptFile($baseUrl . '/plugins/jqplot.dateAxisRenderer.min.js', CClientScript::POS_HEAD);
        $cs->registerScriptFile($baseUrl . '/plugins/jqplot.pointLabels.min.js', CClientScript::POS_HEAD);
        $cs->registerScriptFile($baseUrl . '/plugins/jqplot.barRenderer.min.js', CClientScript::POS_HEAD);
        $cs->registerScriptFile($baseUrl . '/plugins/jqplot.categoryAxisRenderer.min.js', CClientScript::POS_HEAD);
        $cs->registerScriptFile($baseUrl . '/plugins/jqplot.pieRenderer.min.js', CClientScript::POS_HEAD);
    }

    protected function typeBatang() {
        return 'js:$.jqplot.BarRenderer';
    }

    protected function typePie() {
        return 'js:$.jqplot.PieRenderer';
    }

    protected function typeGaris() {
        return 'js:$.jqplot.LineRenderer';
    }
    
    protected function setGroup($seri){
        $result = array();
        $data = $this->dataProvider->getData();
        foreach ($data as $i=>$v){
            if (!in_array($v[$seri], $result)){
                $result[] = $v[$seri];
            }
        }
        return $result;
    }
    
    protected function getLabel($seri){
        $result = array();
        $data = $this->dataProvider->getData();
        foreach ($data as $i=>$v){
            if (!in_array(array('label' => "$v[$seri]"), $result)){
                $result[] = array('label' => "$v[$seri]");
            }
        }
        return $result;
    }
    
    protected function getTicks($seri){
        $result = array();
        $data = $this->dataProvider->getData();
        foreach ($data as $i=>$v){
            if (!in_array($v[$seri], $result)){
                $result[] ="$v[$seri]";
            }
        }

        return $result;
    }
    
    protected function valueMax($seri){
        $datas = $this->dataProvider->getData();
        $x = 0;
        foreach ($datas as $i=>$v){
            if ($x > $v[$seri]){
                $x = $v[$seri];
            }
        }
        return $v;
    }
    
    public function renderAutoUpdate(){
        $url = $this->autoUpdate['url'];
        $id = $this->htmlOptions['id'];
        Yii::app()->clientScript->registerScript(
            "autoupdate".$id,"
                setInterval(function() {
                    ".((!is_null($this->autoUpdate['bind']['form'])) ? "kirim = $('".$this->autoUpdate['bind']['form']."').serialize();\n$.post('index.php?'+kirim,{data:1,data_id:'$id'},function(hasil){" : "$.post('".$url."',{data:1,data_id:'$id'},function(hasil){")."
                        plot_$id.destroy();
                        plot_$id.series[0].data = hasil.result;
                        plot_$id.axes.xaxis.ticks = hasil.index;
                        ".(($this->type != self::TIPE_PIE) ? "plot_$id.replot({resetAxes:['yaxis'],axes:{yaxis:{min:-1, pad:5}}});" : "plot_$id.replot();")."
                    },'json');
                },3000);
            ",  CClientScript::POS_READY
        );
    }

}