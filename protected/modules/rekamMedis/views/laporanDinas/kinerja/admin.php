<?php
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai

$this->breadcrumbs = array(
    'Laporan Dinas' => array('/' . $module . '/' . $controller),
    'Kinerja'
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#Grafik').attr('src','').css('height','0px');
	$('#tableLaporan').addClass('animation-loading');
	$.fn.yiiGridView.update('tableLaporan', {
		data: $(this).serialize()
	});
	return false;
});
");

?>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-newspaper"></i> Laporan <b>Kinerja</b>
                </div>
            </div>
            <div class="panel-body">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="entypo-search"></i> Pencarian
                        </div>
                    </div>
                    <div class="panel-body">
                        <!--fieldset class="box search-form"-->
                        <?php $this->renderPartial($this->path_view . 'kinerja._searchV2', array(
                            'model' => $model,
                        )); ?>
                        <!--</fieldset>-->
                        <!--search-form-->

                    </div>
                </div>
                <?php echo $this->renderPartial($this->path_view . '_tabMenu', array(), true); ?>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="entypo-credit-card"></i> Tabel <b>Kinerja</b>
                        </div>
                    </div>
                    <div class="panel-body table-responsive">
                        <?php $this->renderPartial($this->path_view . 'kinerja._table', array('model' => $model)); ?>
                    </div>
                </div>
                <!--
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
        <i class="fas fa-chart-bar"></i> Grafik
    </div>
                    </div>
                    <div class="panel-body">
						<div class="block-tabel">
							<?php //$this->renderPartial($this->path_view.'_tab'); 
                            ?>
							<iframe class="biru" src="" id="Grafik" width="100%" height='0'  onload="javascript:resizeIframe(this);">
							</iframe>        
						</div>
                    </div>
                </div>				
	-->
                <?php //echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="entypo-search"></i>')),'#',array('class'=>'search-button btn')); 
                ?>
                <?php


                $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/printLaporanKinerja');
                $url = Yii::app()->createUrl($module . '/' . $controller . '/FrameGrafikLaporanKinerja&id=1');
                $this->renderPartial($this->path_view . '_footer', array('urlPrint' => $urlPrint, 'url' => $url)); ?>
            </div>
        </div>
    </div>
</div>

<script>

</script>