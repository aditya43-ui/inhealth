<?php
$this->breadcrumbs = array(
    'Laporan Pemakaian Ambulans',
);

if (isset($_GET['sukses'])) {
    Yii::app()->user->setFlash('success', "Data berhasil disimpan!");
}

$this->widget('bootstrap.widgets.BootAlert');
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Laporan <b>Pemakaian Ambulans</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $url = Yii::app()->createUrl('ambulans/laporanAmbulans/frameGrafikPemakaianAmbulans&id=1');
        Yii::app()->clientScript->registerScript('search', "
			$('#laporan-search').submit(function(){
				$.fn.yiiGridView.update('laporan-grid', {
					data: $(this).serialize()
				});
				return false;
			});
			");
        ?>
        <?php $this->renderPartial('pemakaianAmbulansT/_search', array('model' => $model, 'format' => $format)); ?>
        <div class="panel panel-success" style="margin-top: 17px;">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pemakaian Ambulans</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->renderPartial('pemakaianAmbulansT/_table', array('model' => $model)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="fas fa-chart-bar"></i> Grafik
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial('_tab'); ?>
                <iframe class="biru" src="" id="Grafik" width="100%" height='0' onload='javascript:resizeIframe(this);'></iframe>
            </div>
        </div>
        <?php
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/printPemakaianAmbulans');
        $this->renderPartial('_footer_pisah', array('urlPrint' => $urlPrint, 'url' => $url));
        ?>
    </div>
</div>
<script type="text/javascript">
    function batalPakai(idPemakaian, idPemesanan) {
        myConfirm("Anda yakin akan membatalkan pemakaian ambulans?", "Perhatian!", function(r) {
            if (r) {
                $.post('<?php echo $this->createUrl('batalPakai'); ?>', {
                    idPemakaian: idPemakaian,
                    idPemesanan: idPemesanan
                }, function(data) {
                    if (data.status == 'berhasil') {
                        $.fn.yiiGridView.update('pemakaianambulans-t-grid', {
                            data: $(this).serialize()
                        });
                        return false;
                    }
                }, 'json');
            }
        });
    }
</script>