<?php
$url = $this->createUrl('FrameGrafikLaporanPermintaanPenawaran&id=1');
Yii::app()->clientScript->registerScript('search', "
$('#search-laporan').submit(function(){
    $('#Grafik').attr('src','').css('height','0px');
	$.fn.yiiGridView.update('tableLaporan', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">Laporan <strong>Permintaan Penawaran (Obat Alkes)</strong></div>
            </div>
            <div class="panel-body">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title"><i class="entypo-search"></i> Pencarian</div>
                    </div>
                    <div class="panel-body box">						
						<?php $this->renderPartial($this->path_view.'_search',array('model'=>$model,'format'=>$format)); ?>						
                    </div>
                </div>								
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">Tabel <strong>Permintaan Penawaran (Obat Alkes)</strong></div>
                    </div>
                    <div class="panel-body" style="overflow-x: scroll">
						<div class="block-tabel">
							<?php $this->renderPartial($this->path_view.'_table',array('model'=>$model,'format'=>$format)); ?>
						</div>
                    </div>
                </div>								
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">Grafik</div>
                    </div>
                    <div class="panel-body">
						<div class="block-tabel">
							<?php $this->renderPartial($this->path_view.'_tab'); ?>
							<iframe class="biru" src="" id="Grafik" width="100%" height='0' onload="javascript:resizeIframe(this);">
							</iframe>
						</div>
                    </div>
                </div>								
				<?php        
				$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
				$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
				$urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/printLaporanPermintaanPenawaran');
				$this->renderPartial($this->path_view.'_footer', array('urlPrint'=>$urlPrint, 'url'=>$url));
				?>		
            </div>
        </div>
    </div>
</div>
