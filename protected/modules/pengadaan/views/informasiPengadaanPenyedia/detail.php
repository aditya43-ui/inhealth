<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); 
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); 

$this->widget('bootstrap.widgets.BootAlert');

$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
	'id' => 'persiapanpengadaan-t-form',
	'enableAjaxValidation' => false,
	'type' => 'horizontal',
        
	'htmlOptions' => array(
            'enctype'=>'multipart/form-data',
            'onKeyPress' => 'return disableKeyPress(event)'
            ),
	//'focus' => '#'.CHtml::activeId($model, 'persiapanpengadaan_tanggal').'',
    ));
?>
<div class="panel panel-success">
    <div class="panel panel-heading">
        <div class="panel-title"> <b> Detil Pekerjaan </b> </div>
    </div>
    <div class="panel-body">
        <div class="control-group">
                <?php echo CHtml::label("Tanggal Diumumkan", 'diumumkan_tanggal', array('class' => 'control-label')) ?>
            <div class = "controls">
                <?php echo $form->textField($model, 'diumumkan_tanggal', array('readonly' => true, 'class' => 'span6', 'placeholder' => 'Ketik Nomor Kantong Darah')) ?>
            </div>
        </div>
        <div class="control-group">
                <?php echo CHtml::label("Nomor Persiapan Pengadaan", 'rencanaumumpengadaan_nomor', array('class' => 'control-label')) ?>
            <div class = "controls">
                <?php echo $form->textField($modRencana, 'rencanaumumpengadaan_nomor', array('readonly' => true, 'class' => 'span6', 'placeholder' => 'Ketik Nomor Kantong Darah')) ?>
            </div>
        </div>
        <div class="control-group">
                <?php echo CHtml::label("Nama Pekerjaan", 'nama_pekerjaan', array('class' => 'control-label')) ?>
            <div class = "controls">
                <?php echo $form->textField($modRencana, 'nama_pekerjaan', array('readonly' => true, 'class' => 'span6', 'placeholder' => 'Ketik Nomor Kantong Darah')) ?>
            </div>
        </div>
        <div class="control-group">
                <?php echo CHtml::label("Jenis Pengadaan", 'jenispengadaan_nama', array('class' => 'control-label')) ?>
            <div class = "controls">
                <?php echo $form->textField($modJenis, 'jenispengadaan_nama', array('readonly' => true, 'class' => 'span6', 'placeholder' => 'Ketik Nomor Kantong Darah')) ?>
            </div>
        </div>
        <div class="control-group">
                <?php echo CHtml::label("Metode Pengadaan", 'metodepengadaan_nama', array('class' => 'control-label')) ?>
            <div class = "controls">
                <?php echo $form->textField($model, 'metodepengadaan_nama', array('readonly' => true, 'class' => 'span6')) ?>
            </div>
        </div>
        <div class="control-group">
                <?php echo CHtml::label("Uraian", 'uraian_pekerjaan', array('class' => 'control-label')) ?>
            <div class = "controls">
                <?php echo $form->textArea($modRencana, 'uraian_pekerjaan', array('readonly' => true, 'class' => 'span6')) ?>
            </div>
        </div>
        <div class="control-group">
                <?php echo CHtml::label("Volume", 'volume_pekerjaan', array('class' => 'control-label')) ?>
            <div class = "controls">
                <?php echo $form->textField($modRencana, 'volume_pekerjaan', array('readonly' => true, 'class' => 'span6')) ?>
            </div>
        </div>
        <div class="control-group">
                <?php echo CHtml::label("Pemanfaatan Barang / Jasa", 'pemanfaatan', array('class' => 'control-label')) ?>
            <div class = "controls">
                <?php 
                if (!empty($modRencana->pemanfaatanbarang_tglawal && $modRencana->pemanfaatanbarang_tglakhir)) {
                    $model->pemanfaatan = MyFormatter::formatDateTimeForUser($modRencana->pemanfaatanbarang_tglawal)." - ".MyFormatter::formatDateTimeForUser($modRencana->pemanfaatanbarang_tglakhir);
                    echo $form->textField($model, 'pemanfaatan ', array('readonly' => true, 'class' => 'span6', 'value' => $model->pemanfaatan));
                } else {
                    $model->pemanfaatan = "-";
                    echo $form->textField($model, 'pemanfaatan ', array('readonly' => true, 'class' => 'span6', 'value' => "-"));
                }
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Pelaksanaan Kontrak", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php 
                if (!empty($modRencana->pelaksanaankontrak_tglawal && $modRencana->pelaksanaankontrak_tglakhir)) {
                    $model->pelaksanaanKontrak = MyFormatter::formatDateTimeForUser($modRencana->pelaksanaankontrak_tglawal)." - ".MyFormatter::formatDateTimeForUser($modRencana->pelaksanaankontrak_tglakhir);
                    echo $form->textField($model, 'pelaksanaanKontrak ', array('readonly' => true, 'class' => 'span6', 'value' => $model->pelaksanaanKontrak));
                } else {
                    $model->pelaksanaanKontrak = "-";
                    echo $form->textField($model, 'pelaksanaanKontrak ', array('readonly' => true, 'class' => 'span6', 'value' => "-"));
                }
                ?>
                
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Pelaksanaan Pemilihan Penyedia", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php 
                if (!empty($modRencana->pemilihanpenyedia_tglawal && $modRencana->pemilihanpenyedia_tglakhir)) {
                    $model->pemilihanPenyedia = MyFormatter::formatDateTimeForUser($modRencana->pemilihanpenyedia_tglawal)." - ".MyFormatter::formatDateTimeForUser($modRencana->pemilihanpenyedia_tglakhir);
                    echo $form->textField($model, 'pemilihanPenyedia ', array('readonly' => true, 'class' => 'span6', 'value' => $model->pemilihanPenyedia));
                } else {
                    $model->pemilihanPenyedia = "-";
                    echo $form->textField($model, 'pemilihanPenyedia ', array('readonly' => true, 'class' => 'span6', 'value' => "-"));
                }
                ?>
                
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Dokumen Penyedia", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php 
                    if (!empty($modDokumen)) {
                        echo '<ul>';
                        foreach($modDokumen as $mod){
                            echo '<li>'.CHtml::link("Dokumen Penyedia", $this->createUrl('Unduh', array('id' => $mod->dokumenpendukungpengadaan_id)), array('title' => 'Unduh Lisensi', 'rel' => 'tooltip')) . '</li>'; 
                            
                        }
                        echo '</ul>';
                    } else {
                        echo '<label>'."Tidak Ada Dokumen yang Diunggah Sebelumnya".'</label>';
                    }
                ?>
            </div>
        </div>
        <?php echo CHtml::link('<i class="entypo-back" style="color: white;"></i> Kembali', '#', array('class'=>'btn btn-success','onclick'=>'window.history.back(); return false;', 'style'=>'color: white;'));?>

        <?php if(!isset($_GET['loginpemakai_id'])){ ?>
            <div class="form-actions" style="margin-left: 800px">
                <?php echo CHtml::htmlButton(Yii::t('mds', '{icon}  Ajukan Penawaran', array('{icon}' => '<i class="fa fa-cloud-upload"></i>')), array('class' => 'btn btn-green', 'type' => 'button', 'onclick' => "$('#persiapanpengadaan_id').val(".$model->persiapanpengadaan_id."); $('#logindialog').dialog('open');",));?>
            </div>
        <?php } ?>
    </div>
    
</div>

<?php $this->endWidget(); ?>

<?php
$this->renderPartial($this->path_view . '_jsFunction', array(
    'model' => $model,
));
?>
<?php
$this->renderPartial($this->path_view . '_formLogin', array(
    'id' => 'detail' //untuk param pembeda antara index dan detail
));
?>