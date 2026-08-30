<?php
$this->breadcrumbs = array(
    'Informasi Pasien Operasi',
    'Pengambilan Obat OK',
);
$this->widget('bootstrap.widgets.BootAlert');
?>

<?php 
if($this->gagalsimpan['status'] == 0) : 
?>
<div class="hide">
    <?= $this->gagalsimpan['pesan']; ?>
</div>
<div class="alert alert-error">
    Gagal Simpan {Exception}
</div>
<?php endif; ?>
<?php 
$form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'resepturok-form',
	'enableAjaxValidation'=>false,
    'type'=>'horizontal',
    'focus'=>'#therapiobat_nama',
    'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)',
            'class'=>'form-iframe'
                            ),
)); 
?>

<div class="row">
    <div class="col-sm-12">
        <?php
    $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
        'id' => 'riwayat-pasien',
        'content' => array(
            'content-' => array(
                'header' => 'Riwayat Pasien',
                'isi' => '<iframe src="" id="riwayatPasien" style="width:100%; height: 98%;"></iframe>',
                'active' => true,
            ),
        ),
    ));
    ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <?php 
        // if (!empty($this->modSMS)) {
            $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                'id' => 'riwayat-penjualanresep',
                'content' => array(
                    'content-riwayat-penjualanresep' => array(
                        'header' => '<b>Riwayat Penjualan Resep</b>',
                        'isi' => $this->renderPartial($this->path_view_pengambilanObat . "_riwayatPenjualanResep", array(
                            'modRiwayatPenjualanResep' => $modRiwayatPenjualanResep
                        ), true),
                        'active' => true,
                    ),
                ),
            ));
        // }
        ?>
    </div>
</div>
<div class="col-sm-12">
    <?php 
        $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
            'id' => 'riwayat-resep-pasien',
            'content' => array(
                'content-riwayat-resep-pasien' => array(
                    'header' => '<b>Riwayat Resep Pasien</b>',
                    'isi' => $this->renderPartial($this->path_view_pengambilanObat . "_riwayatResepPasien", array(
                        'riwayatResep' => $riwayatResep,
                        'modReseptur' => $modReseptur,
                        'modPasien' => $modPasien
                    ), true),
                    'active' => true,
                ),
            ),
        ));
    ?>
</div>
<div class="row kumpulanTombol">
    <div class="col-sm-12">
        <div style="float: right;">
            <?php 
                echo CHtml::htmlButton(Yii::t('mds','{icon} Buat Penjualan',array('{icon}'=>'<i class="entypo-form"></i>')),array('class'=>'btn btn-danger', 'type'=>'button','id'=>'btn_reseptur', 'onclick' => 'buatPenjualan()')); 
            ?>
        </div>
    </div>
</div>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-form-circled"></i> Data <b>Resep</b>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->renderPartial($this->path_view_pengambilanObat . '_formDataResep', [
            'form' => $form,
            'modReseptur' => $modReseptur
        ]); ?>
    </div>
</div>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Table <b>Reseptur</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="table-responsive">
            <?php $this->renderPartial($this->path_view_pengambilanObat . '_tableReseptur') ?>
        </div>
    </div>
</div>
<div class="form-actions">
    <?php
        echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),array('class'=>'btn btn-danger', 'type'=>'submit','id'=>'btn_submit')); //formSubmit(this,event)
    ?>
    <?php if(!isset($_GET['frame'])){
        echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl($this->id.'/pengambilanObatOK/&pendaftaran_id='.$_GET['pendaftaran_id'] . '&pasienmasukpenunjang_id=' . $_GET['pasienmasukpenunjang_id']),
        array('class'=>'btn btn-default',
            'onclick'=>'return refreshForm(this);'));
    } ?>

</div>
<?php $this->endWidget(); ?>

<?php $this->renderPartial($this->path_view_pengambilanObat . '_dialogObat') ?>
<?php $this->renderPartial($this->path_view_pengambilanObat . '_dialogAll') ?>
<?php $this->renderPartial($this->path_view_pengambilanObat . '_jsFunctions', ['modPasien' => $modPasien]) ?>
