<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END);

$this->widget('bootstrap.widgets.BootAlert');

$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'notadinaspptk-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
        ));
?>
<?php
if (isset($_GET['sukses'])) {
    Yii::app()->user->setFlash('success', "Data Berhasil disimpan");
}
$this->widget('bootstrap.widgets.BootAlert');
?>
<style>
    .control-label{
        width: 195px !important; 
    }
</style>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Transaksi <strong>Nota Dinas PPTK</strong></div>
    </div>
    <div class="panel-body">
        <?php echo CHtml::hiddenField("norow", "", array('readonly' => true)); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">Data <b> Referensi </b></div>
            </div>
            <div class="panel-body">
                <?php echo $this->renderPartial('_formPersiapanpengadaan', array('model' => $model, 'form' => $form, 'format' => $format), true); ?>
            </div>
        </div>
        <div class="panel panel-success" id="formKontrak">
            <div class="panel panel-heading">
                <div class="panel-title"> <b> Kontrak </b> </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial('_formKontrak', array('model' => $model, 'form' => $form))?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title"> <b> Nota Dinas PPTK </b></div>
            </div>
            <div class="panel-body">
                <?php echo $this->renderPartial('_formNotadinas', array('model' => $model, 'form' => $form), true); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title"> <b> Rincian </b></div>
            </div>
            <div class="panel-body" style="overflow-x: auto; max-width: 100%">
                <table class="table table-bordered table-striped table-condensed" id="tabelRincian">
                    <thead>
                        <tr>
                            <th style="text-align: center">No.</th>
                            <th style="text-align: center">Uraian</th>
                            <th style="text-align: center">Volume</th>
                            <th style="text-align: center">Satuan</th>
                            <th style="text-align: center">Pajak <br> (%) </th>
                            <th style="text-align: center">Harga</th>
                            <th style="text-align: center">Sebelum <br> Pajak</th>
                            <th style="text-align: center">Jumlah</th>
                            <th style="text-align: center">Pagu </th>
                            <th style="text-align: center">Serapan</th>
                            <th style="text-align: center">Sisa</th>
                            <th style="text-align: center">Keterangan</th>
                            <th style="text-align: center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($_GET['ubah'])) { ?>
                            <?php 
                                $modDetails = NotadinaspptkdetT::model()->findAllByAttributes(array('notadinaspptk_id' => $model->notadinaspptk_id));
                                foreach($modDetail as $modDetail){
                                    $modDPA = DokumenpelaksanaananggarandetT::model()->findByPk($modDetail->dokumenpelaksanaananggarandet_id);
                                    $modDetail->sisapagu_pengadaan = number_format($modDPA->sisapagu_pengadaan, 2, ',', '.');
                                    $modDetail->sisavolume_pengadaan = number_format($modDPA->sisavolume_pengadaan, 2, ',', '.');
                                    $modDetail->volume_awal = number_format($modDetail->barang_volume, 2, ',', '.');
                                    $modDetail->jumlah_awal = number_format($modDetail->jumlah_diterima, 2, ',', '.');
                                    $modDetail->jumlah_harga = number_format($modDetail->jumlah_harga, 2, ',', '.');
                                    $modDetail->jumlah_diterima = number_format($modDetail->jumlah_diterima, 2, ',', '.');
                                    $modDetail->barang_volume = number_format($modDetail->barang_volume, 2, ',', '.');
                                    $modDetail->pajak_persen = number_format($modDetail->pajak_persen, 2, ',', '.');
                                    $modDetail->harga_satuan = number_format($modDetail->harga_satuan, 2, ',', '.');
                                    $modDetail->pagu = number_format($modDetail->pagu, 2, ',', '.');
                                    $modDetail->serapan = number_format($modDetail->serapan, 2, ',', '.');
                                    $modDetail->sisa = number_format($modDetail->sisa, 2, ',', '.');
                                    echo $this->renderPartial('_rowRincian', array('modDetail' => $modDetail)); 
                                }
                            ?>
                        <?php } ?>
                    </tbody>
                </table>
                <?php 
                    echo $form->textFieldRow($model, 'jumlah_harga', array('class' => 'span3 integer-decimal', 'readonly' => true)); 
                    echo $form->textFieldRow($model, 'jumlah_pajak', array('class' => 'span3 integer-decimal', 'readonly' => true)); 
                    echo $form->textFieldRow($model, 'jumlah_diterima', array('class' => 'span3 integer-decimal', 'readonly' => true));
                    echo $form->textFieldRow($model, 'sisa_pagu', array('class' => 'span3 integer-decimal', 'readonly' => true)); 
                ?>
            </div>
        </div>
        <div class="row-fluid">
            <div class="form-actions">
                <?php
                if (!empty($_GET['sukses'])) {
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary',
                        'type' => 'button', 'disabled' => true));
                } else {
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('id' => 'btn_submit', 'class' => 'btn btn-primary', 'onclick' => 'cekForm(); return false;',
                        'type' => 'button'));
                }
                echo "&nbsp;";
                if (!isset($_GET['frame']) || $_GET['frame'] != 1) {
                    echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl($this->id . '/index'), array('class' => 'btn btn-danger',
                        'onclick' => 'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));
                    echo "&nbsp;";
                }

                if (!empty($_GET['notadinaspptk_id'])) {
                    echo "&nbsp;";
                    echo CHtml::link(Yii::t('mds', '{icon} Cetak Nota Dinas', array('{icon}' => '<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "window.open('" . $this->createUrl('/pengadaan/informasiNotadinaspptk/printNotadinas', array('id' => $model->notadinaspptk_id)) . "', 'printwin', 'left=100,top=100,width=790,height=1120')"));
                    echo "&nbsp;";
                    echo CHtml::link(Yii::t('mds', '{icon} Cetak Uraian', array('{icon}' => '<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "window.open('" . $this->createUrl('/pengadaan/informasiNotadinaspptk/printUraian', array('id' => $model->notadinaspptk_id)) . "', 'printwin', 'left=100,top=100,width=1120,height=790')"));
                    echo "&nbsp;";
                }
                if (!empty($_GET['ubah'])) {
                    echo CHtml::link(Yii::t('mds', '{icon} Kembali', array('{icon}' => '<i class="entypo-back"></i>')), $this->createUrl('InformasiNotadinaspptk/Index'), array('class' => 'btn btn-green'));
                }
                ?>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
<?php $this->renderPartial('_dialog', array('model' => $model))?>
<?php 
    $modDetails = new NotadinaspptkdetT(); 
?>

<script type="text/javascript">
    function cekNomorDokumen(){
        var nomor_notadinas = $("#<?php echo CHtml::activeId($model, 'nomor_notadinas') ?>").val();
        var notadinaspptk_id = <?php echo !empty($model->notadinaspptk_id) ? $model->notadinaspptk_id : 0 ?>;
        $.ajax({
            type: 'POST',
            data: {nomor_notadinas, notadinaspptk_id},
            url: '<?php echo $this->createUrl('cekNomorDokumen'); ?>',
            dataType: "json",
            success: function (data) {
                if (data.ok === 0) {
                    toastr.error(data.pesan, 'Perhatian!');
                    $("#<?php echo CHtml::activeId($model, 'nomor_notadinas') ?>").val('');
                } 
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
</script>
<?php $this->renderPartial('_jsFunctions', array('model' => $model, 'modDetails' => $modDetails)); ?>