<?php
$this->breadcrumbs = array(
    'Laporan Rencana Diklat'
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	cekJenisDiklat();
	$('#Grafik').attr('src','').css('height','0px');
	$('#tableLaporanInternal').addClass('animation-loading');
	$.fn.yiiGridView.update('tableLaporanInternal', {
		data: $(this).serialize()
	});
	$('#tableLaporanEksternal').addClass('animation-loading');
	$.fn.yiiGridView.update('tableLaporanEksternal', {
		data: $(this).serialize()
	});
	return false;
});
");

?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-newspaper"></i> Laporan <b>Rencana Diklat</b>
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
                <?php $this->renderPartial($this->path_view . 'rencanaDiklat._search', array(
                    'model' => $model,
                )); ?>
                <!--</fieldset>-->
                <!--search-form-->

            </div>
        </div>
        <div class="panel panel-success" id='diklateksternal'>
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Rencana Diklat Eksternal</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->renderPartial($this->path_view . 'rencanaDiklat._tableEksternal', array('model' => $model)); ?>
            </div>
        </div>
        <div class="panel panel-success" id='diklatinternal'>
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Rencana Diklat Internal</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <div class="block-tabel">
                    <?php $this->renderPartial($this->path_view . 'rencanaDiklat._tableInternal', array('modInternal' => $modInternal)); ?>
                </div>
            </div>
        </div>
        <?php /*
					<div class="panel panel-success">
						<div class="panel-heading">
							<div class="panel-title">
        <i class="fas fa-chart-bar"></i> Grafik
    </div>
						</div>
						<div class="panel-body">
							<div class="block-tabel">
								<?php $this->renderPartial($this->path_view.'_tab'); ?>
								<iframe class="biru" src="" id="Grafik" width="100%" height='0'  onload="javascript:resizeIframe(this);">
								</iframe>        
							</div>
						</div>
					</div>			
				 * 
				 */ ?>
        <?php //echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="entypo-search"></i>')),'#',array('class'=>'search-button btn')); 
        ?>
        <?php
        //        echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class' => 'btn btn-danger', 'type'=>'button','onclick'=>'print(\'PDF\')')); 
        //        echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class' => 'btn btn-danger', 'type'=>'button','onclick'=>'print(\'EXCEL\')')); 
        //        echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class' => 'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')')); 
        //        echo CHtml::htmlButton(Yii::t('mds','{icon} Grafik',array('{icon}'=>'<i class="entypo-chart-area"></i>')),array('class' => 'btn btn-danger', 'type'=>'button','onclick'=>'$("#Grafik")[0].contentWindow.test();
        //')); 
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/printRencanaDiklat');
        $url = Yii::app()->createUrl($module . '/' . $controller . '/FrameGrafikRencanaDiklat&id=1');
        $this->renderPartial($this->path_view . '_footerPresensi', array('urlPrint' => $urlPrint, 'url' => $url)); ?>
    </div>
</div>
</div>

<script>
    function cekJenisDiklat() {
        var jenis = $("#<?php echo CHtml::activeId($model, 'jenisdiklat_id') ?>").val();

        if (jenis == '<?php echo Params::JENIS_DIKLAT_INTERNAL ?>') {
            $("#diklatinternal").attr("style", 'display:block;');
            $("#diklateksternal").attr("style", 'display:none;');
        } else if (jenis == '<?php echo Params::JENIS_DIKLAT_EKSTERNAL ?>') {
            $("#diklatinternal").attr("style", 'display:none;');
            $("#diklateksternal").attr("style", 'display:block;');
        }
    }

    $(document).ready(function() {
        cekJenisDiklat();
    });
</script>