<?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pengisisansaldoawal-grid',
    'dataProvider' => $model->searchTable(),
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
    'columns' => array(
        array(
            'header' => 'Tanggal Pengisian Saldo Awal',
            'value' => '$data->tglpengisiansaldo',
            'type' => 'raw',
            'filter' => false,
        ),
        array(
            'header' => 'Cabang',
            'value' => '$data->getNamaRumahsakit()',
            // 'value'=>'(isset($data->daftartindakan_nama) ? $data->daftartindakan_nama : "")."<br/>".$data->getNamaLengkap()',
            'type' => 'raw',
            'filter' => false,
        ),
        array(
            'header' => 'Ruangan',
            'value' => '$data->getRuanganNama()',
            'type' => 'raw',
            // 'htmlOptions'=>array('style'=>'text-align:right;'),
            'filter' => false,
        ),
        array(
            'header' => 'Shift',
            'value' => 'empty($data->shift) ? "" : $data->shift->shift_nama',
            'type' => 'raw',
            // 'htmlOptions'=>array('style'=>'text-align:right;'),
            'filter' => false,
        ),
        array(
            'header' => 'Pegawai',
            'value' => 'empty($data->pegawai) ? "" : $data->pegawai->nama_pegawai',
            'type' => 'raw',
            // 'htmlOptions'=>array('style'=>'text-align:right;'),
            'filter' => false,
        ),
        array(
            'header' => 'Nilai Saldo',
            'value' => 'MyFormatter::formatNumberForUser($data->nilaisaldoawal)',
            'type' => 'raw',
            'htmlOptions' => array('style' => 'text-align:right;'),
            'filter' => false,
        ),
        array(
            'header' => 'Keterangan',
            'value' => '$data->keterangan',
            'type' => 'raw',
            'filter' => false,
        ),
        array(
            'header' => 'Rincian',
            'value' => 'CHtml::link("<i class=\"icon-print\"></i>", "javascript:void(0);", array("onclick"=>"print($data->pengisiansaldoawal_id);return false;","rel"=>"tooltip","title"=>"Klik untuk melihat rincian"))',
            'type' => 'raw',
        ),
        array(
            'header' => Yii::t('zii', 'Update'),
            'class' => 'bootstrap.widgets.BootButtonColumn',
            'template' => '{update}',
            'buttons' => array(
                'update' => array(
                    'options' => array('rel' => 'tooltip', 'title' => 'Ubah Saldo Awal'),
                    'visible' => 'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
                ),
            ),
        ),
        array(
            'header' => 'Batal',
            'value' => '($data->isClosing($data->pengisiansaldoawal_id) ? "SALDO SUDAH DI CLOSING" :  $data->tglpembatalan) ? "Dibatalkan Oleh ".(empty($data->pegawaibatal) ? "-" : $data->pegawaibatal->nama_pegawai)." Pada ".MyFormatter::formatDateTimeForUser($data->tglpembatalan) :  CHtml::link("<icon class=\'icon-form-silang\'></icon> ", Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/batal", array("id"=>$data->pengisiansaldoawal_id,"frame"=>true)), array("target"=>"frameBatal","rel"=>"tooltip", "title"=>"Klik untuk Membatalkan", "onclick"=>"$(\'#dialogBatal\').dialog(\'open\');"))',
            // 'value'=>'CHtml::link("<i class=\"icon-remove\"></i>", "javascript:void(0);", array("onclick"=>"hapus(this,$data->pengisiansaldoawal_id);return false;","rel"=>"tooltip","title"=>"Klik untuk menghapus data"))',
            'type' => 'raw',
            'htmlOptions' => array('style' => 'text-align:center;'),
            'filter' => false,
        ),
        array(
            'header' => 'Status Closing',
            // 'value' => '($data->isClosing($data->pengisiansaldoawal_id) ? "SUDAH" :  "BELUM")',
            'value' => function($data)
            {
                // $closing = ClosingkasirT::model()->findByAttributes(array('pengisiansaldoawal_id'=>$data->pengisiansaldoawal_id));
                // var_dump($closing);die;
                if(!empty($data->closingkasir_id)){
                    return "SUDAH";
                }else{
                    return "BELUM";
                }
            },
            'type' => 'raw',
            'htmlOptions' => array('style' => 'text-align:center;'),
            'filter' => false,
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
)); ?>
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogBatal',
    'options' => array(
        'title' => 'Transaksi Pembatalan Pengisian Saldo Awal',
        'autoOpen' => false,
        'modal' => true,
        'width' => 500,
        'height' => 300,
        'resizable' => false,
        'close' => "js:function(){ $.fn.yiiGridView.update('pengisisansaldoawal-grid', {
					data: $(this).serialize()
				}); }",
    ),
));
?>
<iframe name='frameBatal' width="100%" height="100%"></iframe>
<?php $this->endWidget(); ?>
<?php
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/printRincian'); //
$url =  Yii::app()->createAbsoluteUrl($module . '/' . $controller);
$js = <<< JSCRIPT
function print(obj)
{
window.open("${urlPrint}/"+"&pengisiansaldoawal_id="+obj,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
?>