<?php
/**
 * tabulasi - tabulasi menu
 * 
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id> 
 * @author Elham Budianto <elhambudianto1@gmail.com> 
 * @author Andyka Putra <andykaputra@.com>
 * @link    <http://172.9.1.15/simpp/docs/>
 * @link    <http://piindonesia.co.id>
 * @link    <http://.com>
 */
$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
         array('label'=>'Tipe Risiko', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tab-default','onclick'=>'setTab(this);', 'tab'=>$this->getUrlTipeResiko())),
         array('label'=>'Sub Tipe Risiko', 'url'=>'javascript:void(0);', 'itemOptions'=>array('id'=>'tab-default','onclick'=>'setTab(this);', 'tab'=>$this->getUrlSubTipeResiko())),
         array('label'=>'Detectability', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$this->getUrlDetectability())),
    	 array('label'=>'Konsekuensi', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$this->getUrlKonsekuensi())),
    	 array('label'=>'Peluang', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$this->getUrlPeluang())),
        array('label'=>'Tingkat Risiko', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$this->getUrlTingkatresiko())),
        array('label'=>'Grading Risiko', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>$this->getUrlGradingresiko())),
    ),
));
?>