<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php
if(!empty($modPasien)){
    $modPasien->nama_pasien = $modPasien->namadepan.$modPasien->nama_pasien;
    $modPendaftaran->tgl_pendaftaran = MyFormatter::formatDateTimeForUser($modPendaftaran->tgl_pendaftaran);
    
    $penerima = "";
    $dpjp2 = "";
    $dpjp3 = "";
    
    if (!empty($modAdmisi)){
        if (!empty($modAdmisi->dokterpenerima_id)) {
            $peg = PegawaiM::model()->findByPk($modAdmisi->dokterpenerima_id);
            $penerima = $peg->namaLengkap;
        }
        if (!empty($modAdmisi->dpjp2_id)) {
            $peg = PegawaiM::model()->findByPk($modAdmisi->dpjp2_id);
            $dpjp2 = $peg->namaLengkap;
        }
        if (!empty($modAdmisi->dpjp3_id)) {
            $peg = PegawaiM::model()->findByPk($modAdmisi->dpjp3_id);
            $dpjp3 = $peg->namaLengkap;
        }
    }else{
        $penerima = isset($modPendaftaran->dokter->namaLengkap)? $modPendaftaran->dokter->namaLengkap : ""; 
    }
    
?>

<form class="form-horizontal">
    <div class="panel panel-primary panel-success">
        <div class="panel-heading">
            <div class="panel-title">Data Pasien</div>
        </div>
        <div class="panel-body">
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::activeHiddenField($modPasien, 'nama_bin', array('readonly'=>true)); ?>
                    <?php echo CHtml::activeLabel($modPendaftaran, 'tgl_pendaftaran',array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modPendaftaran, 'tgl_pendaftaran', array('readonly'=>true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modPendaftaran, 'no_pendaftaran',array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modPendaftaran, 'no_pendaftaran', array('readonly'=>true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modPendaftaran, 'umur',array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modPendaftaran, 'umur', array('readonly'=>true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modPendaftaran, 'jeniskasuspenyakit_id',array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modPendaftaran->jeniskasuspenyakit, 'jeniskasuspenyakit_nama', array('readonly'=>true)); ?>
                        <?php 
                            if (empty($modAdmisi)){
                                echo CHtml::activeHiddenField($modPendaftaran, 'kelaspelayanan_id', array('readonly'=>true)); 
                            }else{
                                echo CHtml::activeHiddenField($modAdmisi, 'kelaspelayanan_id', array('readonly'=>true)); 
                            }
                            ?>
                        <?php echo CHtml::activeHiddenField($modPendaftaran, 'carabayar_id', array('readonly'=>true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Dokter Penerima', '', array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::textField('dokterpenerima', $penerima, array('readonly'=>true)); ?>
                    </div>
                </div>                
                
            </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modPasien, 'no_rekam_medik',array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modPasien, 'no_rekam_medik', array('readonly'=>true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modPasien, 'nama_pasien',array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modPasien, 'nama_pasien', array('readonly'=>true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modPasien, 'jeniskelamin',array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modPasien, 'jeniskelamin', array('readonly'=>true)); ?>
                    </div>
                </div>               
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modPendaftaran, 'cara bayar ', array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php 
                            if (!empty($modAdmisi)){
                                echo CHtml::activeTextField($modAdmisi->carabayar, 'carabayar_nama', array('readonly'=>true));                             
                            }else{
                                echo CHtml::activeTextField($modPendaftaran->carabayar, 'carabayar_nama', array('readonly'=>true)); 
                            }
                            ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modPendaftaran->penjamin, 'penjamin', array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php 
                            if (!empty($modAdmisi)){
                                echo CHtml::activeTextField($modAdmisi->penjamin, 'penjamin_nama', array('readonly'=>true));
                            }else{
                                echo CHtml::activeTextField($modPendaftaran->penjamin, 'penjamin_nama', array('readonly'=>true));
                            }
                         ?>
                    </div>
                </div>               
            </div>
        </div>
    </div>
</form>


<?php
} else {
    Yii::app()->user->setFlash('error',"Tidak ada pasien");
    $this->widget('bootstrap.widgets.BootAlert');
}


?>

<?php
//========= Dialog Detail Hasil Pemeriksaaan Lab =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogDetailHasilLab',
    'options' => array(
        'title' => 'Data Hasil Pemeriksaan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 600,
        'resizable' => false,
    ),
));
?>
<iframe src="" name="pesan" width="100%" height="500">
</iframe>
<?php
$this->endWidget();
//=======================================================================
?>

<?php
//========= Dialog Detail Tindakan, Terapi dan Pemakaian Bahan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogDetailData',
    'options' => array(
        'title' => 'Detail Data',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'height' => 600,
        'resizable' => false,
    ),
));
?>
<iframe src="" name="detailDialog" width="100%" height="500">
</iframe>
<?php
$this->endWidget();
?>
