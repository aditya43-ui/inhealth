<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/dropdownMulti.js', CClientScript::POS_END);
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/js/bootstrap-multiselect/css/bootstrap-multiselect.css');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/bootstrap-multiselect/js/bootstrap-multiselect.js', CClientScript::POS_END);

$this->breadcrumbs = array(
    'Laporan Realisasi Lembur',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('laporanrealisasilembur-v-grid', {
		data: $(this).serialize()
	});
	return false;
});
");

$row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';

$prov = clone $model->search();

$totalUpahLembur = 0;
foreach ($prov->data as $dataModRealisasi) {
    $totalUpahLembur += ($dataModRealisasi->upah_lembur_jam1 + $dataModRealisasi->upah_lembur_jam2 + $dataModRealisasi->upah_lembur_jam3);
}

?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-newspaper"></i> Laporan <b>Realisasi Lembur</b>
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
                <?php $this->renderPartial('_search', array(
                    'model' => $model,
                )); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Realisasi Lembur</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('ext.bootstrap.widgets.MergeHeaderGroupGridView', array(
                    'id' => 'laporanrealisasilembur-v-grid',
                    'dataProvider' => $model->search(),
                    // 'filter'=>$model,
                    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                    'mergeHeaders' => array(
                        array(
                            'name' => '<p style="margin: 0; text-align: center;">Upah Lembur</p>',
                            'start' => '13',
                            'end' => '15',
                        ),
                    ),
                    'columns' => array(
                        array(
                            'header' => 'No.',
                            'value' => $row
                        ),
                        array(
                            'header' => 'No/Tanggal Realisasi',
                            'type' => 'raw',
                            'value' => '$data->norealisasi."/<br> ".MyFormatter::formatDateTimeForUser($data->tglrealisasi)',
                        ),
                        array(
                            'header' => 'Nama Pegawai',
                            'value' => function ($data) {
                                if (!empty($data->nama_pegawai)) {
                                    $peg = PegawaiM::model()->find(" LOWER(nama_pegawai) = '" . trim(strtolower($data->nama_pegawai)) . "' ");

                                    if (!empty($peg)) {
                                        return $peg->namaLengkap;
                                    } else {
                                        return '-';
                                    }
                                } else {
                                    return '-';
                                }
                            }
                        ),
                        'alasanlembur',
                        array(
                            'header' => 'Pemberi Tugas',
                            'value' => '$data->namaLengkapPemberi'
                        ),
                        array(
                            'header' => 'Menyetujui',
                            'value' => '$data->namaLengkapMenyetujui',
                        ),

                        array(
                            'header' => 'Instalasi',
                            'value' => function ($data) {
                                $ruangan = RuanganM::model()->findByPk($data->create_ruangan);
                                return empty($ruangan->instalasi) ? "-" : $ruangan->instalasi->instalasi_nama;
                            },
                            'footer' => '<b>Total</b>',
                            'footerHtmlOptions' => array('style' => 'text-align:right;', 'colspan' => 9)
                        ),

                        'create_ruangan_nama',
                        array(
                            'header' => 'Jenis Lembur',
                            'type' => 'raw',
                            'value' => '$data->jenislembur'
                        ),
                        array(
                            'header' => 'Total Jam Lembur',
                            'name' => 'total_jam',
                            'value' => 'number_format($data->total_jam)',
                            'htmlOptions' => array(
                                'style' => 'text-align: right;'
                            ),
                            'footer' => 'sum(total_jam)',
                            'footerHtmlOptions' => array('style' => 'text-align:right;')
                        ),
                        array(
                            'header' => 'Jam Normal',
                            'name' => 'total_jam_normal',
                            'value' => 'number_format($data->total_jam_normal)',
                            'htmlOptions' => array(
                                'style' => 'text-align: right;'
                            ),
                            'footer' => 'sum(total_jam_normal)',
                            'footerHtmlOptions' => array('style' => 'text-align:right;')
                        ),
                        array(
                            'header' => 'Upah Sejam Lembur Hari Kerja',
                            'name' => 'upahsejamlembur',
                            'value' => 'number_format($data->upahsejamlembur)',
                            'htmlOptions' => array(
                                'style' => 'text-align: right;'
                            ),
                            'footer' => 'sum(upahsejamlembur)',
                            'footerHtmlOptions' => array('style' => 'text-align:right;')
                        ),
                        array(
                            'header' => 'Upah Bulanan',
                            'name' => 'upah_bulanan',
                            'value' => 'number_format($data->upah_bulanan)',
                            'htmlOptions' => array(
                                'style' => 'text-align: right;'
                            ),
                            'footer' => 'sum(upah_bulanan)',
                            'footerHtmlOptions' => array('style' => 'text-align:right;')
                        ),
                        array(
                            'header' => 'Jam ke 1',
                            'name' => 'nilai_lembur',
                            'value' => 'number_format($data->nilai_lembur)',
                            'htmlOptions' => array(
                                'style' => 'text-align: right;'
                            ),
                            'footer' => 'sum(nilai_lembur)',
                            'footerHtmlOptions' => array('style' => 'text-align:right;')
                        ),
                        array(
                            'header' => 'Jam ke 2',
                            'name' => 'upah_lembur_jam2',
                            'value' => 'number_format($data->upah_lembur_jam2)',
                            'htmlOptions' => array(
                                'style' => 'text-align: right;'
                            ),
                            'footer' => 'sum(upah_lembur_jam2)',
                            'footerHtmlOptions' => array('style' => 'text-align:right;')
                        ),
                        array(
                            'header' => 'Jam ke 3',
                            'name' => 'upah_lembur_jam3',
                            'value' => 'number_format($data->upah_lembur_jam3)',
                            'htmlOptions' => array(
                                'style' => 'text-align: right;'
                            ),
                            'footer' => 'sum(upah_lembur_jam3)',
                            'footerHtmlOptions' => array('style' => 'text-align:right;')
                        ),

                        //                                 array(
                        //                        'header' => 'Upah Lembur',
                        //                    'value' => 'number_format(($data->upah_lembur_jam1 + $data->upah_lembur_jam2 + $data->upah_lembur_jam3))',
                        //                        'htmlOptions'=>array(
                        //                            'style'=>'text-align: right;'
                        //                        ),
                        //                        'footer'=>number_format($totalUpahLembur),
                        //                        'footerHtmlOptions'=>array('style' => 'text-align:right;')
                        //                    ),
                        array(
                            'header' => 'Total',
                            'name' => 'total_nilai_lembur',
                            'value' => 'number_format($data->total_nilai_lembur)',
                            'htmlOptions' => array(
                                'style' => 'text-align: right;'
                            ),
                            'footer' => 'sum(total_nilai_lembur)',
                            'footerHtmlOptions' => array('style' => 'text-align:right;')
                        ),
                        array(
                            'header' => 'Alasan Lembur',
                            'type' => 'raw',
                            'value' => '$data->alasanlembur'
                        ),
                    ),
                )); ?>

            </div>
        </div>
        <div class="form-actions">
            <?php
            $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
            $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
            $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
            $content = $this->renderPartial('kepegawaian.views.tips.laporan_presensi', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));

            $jsx = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#laporan-lembur-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px, scrollbars=yes');
}
JSCRIPT;
            Yii::app()->clientScript->registerScript('print', $jsx, CClientScript::POS_HEAD);
            ?>

        </div>
    </div>
</div>