<!--fieldset class="white-container"-->
<?php
$this->breadcrumbs = array(
    'Pencarian Pegawai Sakit',
);
//$arrMenu = array();
//               array_push($arrMenu,array('label'=>Yii::t('mds',''), 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
//$this->menu=$arrMenu;
//$this->widget('bootstrap.widgets.BootAlert');
?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'caripasien-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#no_rekam_medik',
    'method' => 'GET',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
));
Yii::app()->clientScript->registerScript('cariPasien', "
$('#caripasien-form').submit(function(){
	$.fn.yiiGridView.update('pencarianpasien-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
$format = new MyFormatter();
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Pencarian <b>Pegawai Sakit</b>
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
                <div class="search-form">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="control-group">
                                <?php echo CHtml::label("Tgl. Pendaftaran", 'tgl_rm_awal', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <div class="daterange daterange-inline input-inline span4" data-format="D MMMM YYYY" data-start-date="<?php echo date('d F Y', strtotime($model->tgl_rm_awal)) ?>" data-end-date="<?php echo date('d F Y', strtotime($model->tgl_rm_akhir)) ?>">
                                        <i class="entypo-calendar"></i>
                                        <span><?php echo date('d F Y', strtotime($model->tgl_rm_awal)) ?> - <?php echo date('d F Y', strtotime($model->tgl_rm_akhir)) ?></span>
                                        <?php echo $form->hiddenField($model, 'tgl_rm_awal', array('class' => 'start')) ?>
                                        <?php echo $form->hiddenField($model, 'tgl_rm_akhir', array('class' => 'end')) ?>
                                    </div>
                                </div>
                            </div>
                            <?php echo $form->textFieldRow($model, 'nama_pasien', array('placeholder' => 'Nama Pasien', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                        </div>
                        <div class="col-sm-6">
                            <div class="control-group">
                                <div class="controls">
                                    <?php //echo $form->labelEx($model,'rt', array('class'=>'control-label inline')) 
                                    ?>
                                    <?php echo $form->textFieldRow($model, 'no_rekam_medik', array('placeholder' => 'No. Rekam Medik', 'class' => 'span4 numbers-only', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                                    <?php echo $form->textFieldRow($model, 'alamat_pasien', array('placeholder' => 'Alamat Pasien', 'class' => 'span4 hurufs-only', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                                    <?php // echo $form->dropDownListRow($model,'statusperiksa', Params::statusPeriksa(), array('empty'=>'-- Pilih --', 'class'=>'span4')); 
                                    ?>
                                    <?php /* echo $form->dropDownListRow($model, 'ruangan_id',
                                                        CHtml::listData(RuanganM::model()->findAll(array('condition'=>'instalasi_id in (2,3,4,8)', 'order'=>'instalasi_id, ruangan_nama')), 'ruangan_id', 'ruangan_nama'),
                                                        array('empty'=>'-- Pilih --', 'class'=>'span4')
                                                ); */ ?>
                                    <?php // echo $form->textFieldRow($model,'nama_bin',array('class'=>'span4','onkeypress'=>"return $(this).focusNextInputField(event)")); 
                                    ?>
                                    <?php // echo $form->textFieldRow($model,'rt', array('onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span1 numberOnly','maxlength'=>3)); 
                                    ?>
                                    <?php //echo $form->textFieldRow($model,'rw', array('onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span1 numberOnly','maxlength'=>3)); 
                                    ?>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <?php echo CHtml::htmlButton(
                            Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                            array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
                        ); ?>
                        <?php echo CHtml::link(
                            Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                            $this->createUrl('PencarianKaryawanSakit/'),
                            array(
                                'title' => 'Ulang', 'class' => 'btn btn-default',
                                'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                            )
                        ); ?>

                        <?php
                        $tips = array(
                            '0' => 'tanggal',
                            '1' => 'cari',
                            '2' => 'ulang'
                        );
                        $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
                        $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pegawai Sakit</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                $this->widget('ext.bootstrap.widgets.HeaderGroupGridView', array(
                    'id' => 'pencarianpasien-grid',
                    'dataProvider' => $model->search(),
                    //                'filter'=>$model,
                    'template' => "{pager}{summary}\n{items}",
                    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                    'mergeHeaders' => array(
                        array(
                            'name' => 'Daftarkan',
                            'start' => 11, //indeks kolom 3
                            'end' => 13, //indeks kolom 4
                        ),
                    ),
                    'columns' => array(
                        array(
                            'name' => 'tgl_pendaftaran',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return date('d M Y H:i:s', strtotime($data->tgl_pendaftaran));
                            },
                        ),
                        array(
                            'name' => 'tgl_rekam_medik',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return date('d M Y', strtotime($data->tgl_rekam_medik));
                            },
                        ),
                        array(
                            'name' => 'no_rekam_medik',
                            'type' => 'raw',
                            'value' => '$data->no_rekam_medik',
                        ),
                        array(
                            'name' => 'nomorindukpegawai',
                            'type' => 'raw',
                            'value' => '$data->nomorindukpegawai',
                        ),
                        array(
                            'header' => 'Nama Karyawan',
                            'name' => 'nama_pasien',
                            'type' => 'raw',
                            'value' => '$data->nama_pasien',
                        ),
                        array(
                            'name' => 'jeniskelamin',
                            'value' => '$data->jeniskelamin',
                        ),
                        array(
                            'name' => 'alamat_pasien',
                            'value' => '$data->alamat_pasien',
                        ),
                        array(
                            'header' => 'Ruangan',
                            'name' => 'ruangan_nama',
                            'type' => 'raw',
                            'value' => '$data->ruangan_nama',
                        ),
                        array(
                            'header' => 'Jabatan',
                            'name' => 'jabatan_nama',
                            'type' => 'raw',
                            'value' => '$data->jabatan_nama',
                        ),
                        array(
                            'header' => 'Status Periksa',
                            'value' => '$data->statusperiksa',
                        ), /*
                                                array(
                                                    'name'=>'Rt/Rw',
                                                    'value'=>'$data->rt." / ".$data->rw',
                                                ), */
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                ));
                ?>
            </div>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>
<?php
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
//$url =  Yii::app()->createAbsoluteUrl($module.'/'.$controller);
$url = Yii::app()->createUrl('print/kartuPasien', array('idPasien' => ''));
$cetak = Yii::app()->createUrl('pendaftaranPenjadwalan/pencarianPasien/printKartu', array('id' => ''));
$urlPendaftaranRJ = Yii::app()->createAbsoluteUrl('pendaftaranPenjadwalan/Pendaftaran/RawatJalan');
$urlPendaftaranRD = Yii::app()->createAbsoluteUrl('pendaftaranPenjadwalan/Pendaftaran/RawatDarurat');
$js = <<< JSCRIPT
//function daftarRj(noRM)
//   {
//           
//            $('#norek').val(noRM);
//            document.getElementById("daftarRJ").submit();
//           
//   }
// ==* Fungsi Print *== //
function print(id,umur)
   {    
//               window.open('${url}'+id+'/umur/'+umur,'printwin','left=100,top=100,width=310,height=200,scrollbars=0');
               window.open('${url}'+id,'printwin','left=100,top=100,width=310,height=200,scrollbars=0');
   }
function getListKunjungan(id){
    if (jQuery.isNumeric(id)){
        $.fn.yiiGridView.update('pencarianlistkunjungan-grid', {
		data: 'PendaftaranT[pasien_id]='+id, 
                success: function (data) {
                        var hasil = $('<div>' + data + '</div>');
                        var updateId = '#pencarianlistkunjungan-grid';
                        var update2 = '#dataPasienKunjungan';
                        $(updateId).replaceWith($(updateId, hasil));
                        $(update2).replaceWith($(update2, hasil));
                        $("#dialogRiwayatKunjungan").dialog("open");
                }
	});
	return false;
    }
}
function daftarKeRJ(pasien_id)
{
    $('#pasien_id').val(pasien_id);
    $('#form_hidden_rj').submit();
}
function daftarKeRD(pasien_id)
{
    $('#pasien_id').val(pasien_id);
    $('#form_hidden_rd').submit();
}
JSCRIPT;
Yii::app()->clientScript->registerScript('jsPencarianPasien', $js, CClientScript::POS_HEAD);
$js = <<< JS
$('.numberOnly').keyup(function() {
var d = $(this).attr('numeric');
var value = $(this).val();
var orignalValue = value;
value = value.replace(/[0-9]*/g, "");
var msg = "Only Integer Values allowed.";
if (d == 'decimal') {
value = value.replace(/\./, "");
msg = "Only Numeric Values allowed.";
}
if (value != '') {
orignalValue = orignalValue.replace(/([^0-9].*)/g, "")
$(this).val(orignalValue);
}
});
JS;
Yii::app()->clientScript->registerScript('numberOnly', $js, CClientScript::POS_READY);
?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogPjP',
    'options' => array(
        'title' => 'Daftar Penanggung Jawab',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 700,
        'height' => 400,
        'resizable' => true,
    ),
));
?>
<iframe src="" name="iframeRincianTagihan" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'form_hidden_rj',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'action' => $urlPendaftaranRJ,
    'htmlOptions' => array('target' => '_new'),
)); ?>
<?php echo CHtml::hiddenField('pasien_id', '', array('readonly' => true)); ?>
<?php //echo CHtml::hiddenField('pendaftaran_id','',array('readonly'=>true));
?>
<?php $this->endWidget(); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'form_hidden_rd',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'action' => $urlPendaftaranRD,
    'htmlOptions' => array('target' => '_new'),
)); ?>
<?php echo CHtml::hiddenField('pasien_id', '', array('readonly' => true)); ?>
<?php //echo CHtml::hiddenField('pendaftaran_id','',array('readonly'=>true));
?>
<?php $this->endWidget(); ?>
<script>
    cekAll();

    function cekAll() {
        if ($("#KPPasienM_ceklis").is(":checked")) {
            $("#KPPasienM_tgl_rm_awal").removeAttr('disabled');
            $("#KPPasienM_tgl_rm_akhir").removeAttr('disabled');
        } else {
            $("#KPPasienM_tgl_rm_awal").attr('disabled', 'true');
            $("#KPPasienM_tgl_rm_akhir").attr('disabled', 'true');
        }
    }
</script>
<!--</fieldset>-->