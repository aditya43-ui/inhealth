<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/dropdownMulti.js', CClientScript::POS_END);

$this->breadcrumbs = array(
    'Laporan Cuti Pegawai',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('laporancutipegawai-v-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<?php
//$this->breadcrumbs=array(
//	'Laporan',
//	'Laporan Cuti Pegawai',
//);


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('laporancutipegawai-v-grid', {
		data: $(this).serialize()
	});
	return false;
});
");

$row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-newspaper"></i> Laporan <b>Cuti Pegawai</b>
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
                    <i class="entypo-credit-card"></i> Tabel <b>Cuti Pegawai</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'laporancutipegawai-v-grid',
                    'dataProvider' => $model->search(),
                    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                    'template' => "{summary}\n{items}\n{pager}",
                    'columns' => array(
                        array(
                            'header' => 'No.',
                            'value' => $row
                        ),
                        'jeniscuti_nama',
                        //'pegawai_id',
                        //'gelardepan',
                        array(
                            'header' => 'Nama Pegawai',
                            'value' => '$data->namaLengkap'
                        ),
                        array(
                            'header' => 'Tanggal Cuti',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->tglmulaicuti)." s/d ".MyFormatter::formatDateTimeForUser($data->tglakhircuti)'
                            //                                                'value' => ''
                        ),
                        array(
                            'header' => 'Lama',
                            'value' => '$data->lamacuti." Hari"',
                            'htmlOptions' => array(
                                'style' => 'text-align: right;'
                            )
                        ),
                        'keperluancuti',
                        array(
                            'header' => 'Tgl. Ditetapkan',
                            //                        'name'=>'tglditetapkanskcuti',
                            'value' => '(!empty($data->tglditetapkanskcuti)?MyFormatter::formatDateTimeForUser($data->tglditetapkanskcuti):"")',
                        ),
                        array(
                            'name' => 'nama_menyetujui',
                            'value' => '$data->gelardepan_menyetujui.$data->nama_menyetujui.", ".$data->gelarbelakang_menyetujui',
                        ),
                        array(
                            'header' => 'Status',
                            'value' => function ($data) {
                                if (empty($data->status_cuti)) {
                                    return 'PENGAJUAN';
                                } else {
                                    return $data->status_cuti;
                                }
                            }
                        ),

                        array(
                            'name' => 'nama_pengganti',
                            'value' => '$data->gelardepan_pengganti.$data->nama_pengganti.", ".$data->gelarbelakang_pengganti',
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
    window.open("${urlPrint}/"+$('#laporan-cuti-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px, scrollbars=yes');
}
JSCRIPT;
            Yii::app()->clientScript->registerScript('print', $jsx, CClientScript::POS_HEAD);
            ?>

        </div>
    </div>
</div>