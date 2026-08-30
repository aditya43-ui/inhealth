<?php
$this->breadcrumbs = array(
    'Laporan Tahunan'
);
?>
<style>
    ul.yiiPager .selected a{
        background: #81CC74;
        color: #ffffff !important;
    }
    ul.yiiPager a:link, ul.yiiPager a:visited{
        border: solid 1px #81CC74;
        color: #373e4a;
        font-weight: inherit;
        padding: 0 8px;
    }
</style>
<div class="panel panel-gradient">
    <div class="panel panel-heading">
        <div class="panel-title"> Laporan <b> Tahunan </b></div>
    </div>
    <div class="panel-body">
        <div class="panel panel-gradient">
            <div class="panel-body">
                <div class="panel-body overflow-x">
                    <?php $this->renderPartial($this->path_view . '_table', array()); ?>
                </div>
            </div>
        </div>
        <?php
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');
        $this->renderPartial($this->path_view . '_footer', array('urlPrint'=>$urlPrint));
        ?>
    </div>
</div>