<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'correctiveMaintenance-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);', 'onclick' => 'cekDisabled(this);',),
    'focus' => '#',
        ));
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title"><i class="far fa-eye"></i> Corrective Maintance</div>
    </div>
    <?php echo $form->errorSummary($model); ?>
    <div class="panel-body">
        
        <?php $this->renderPartial($this->path_view . '_dataPegawai', array('form' => $form, 'model' => $model)); ?>
        
        <div class="panel panel-primary panel-success">
            <div class="panel-heading">
                <div class="panel-title">											
                    <i class="entypo-credit-card"></i> Pemeliharaan																
                </div>
            </div>
            <div class="panel-body">
                <div class="row-fluid">
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo CHtml::label('Status', '', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'korektifmainten_status', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true)); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Tanggal Permintaan', '', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'korektifmainten_tgl', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true)); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Nomor Permintaan', '', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'korektifmainten_no', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true)); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php
                            if (isset($model->invperalatan_id)) {
                                $modInventarisasi = InvperalatanT::model()->findByPk($model->invperalatan_id);
                                if (isset($modInventarisasi)) {
                                    $model->invperalatan_namabrg = $modInventarisasi->invperalatan_namabrg;
                                    $model->invperalatan_kode = $modInventarisasi->invperalatan_kode;
                                }
                            }
                            ?>
                            <?php echo CHtml::label('Jenis Peralatan', '', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'invperalatan_namabrg', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true)); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Nomor Aset', '', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->hiddenField($model, 'invperalatan_id', array('readonly' => true, 'id' => 'invperalatan_id')) ?>
                                <?php echo $form->hiddenField($model, 'invperalatan_keadaan', array('readonly' => true, 'id' => 'invperalatan_keadaan')) ?>
                                <?php echo $form->textField($model, 'invperalatan_kode', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true)); ?>

                            </div>
                        </div>
                        <?php
                            $tool = '';
                            $tool = !empty($model->kode_internal)?$model->kode_internal:'';
                            $tool .= !empty($model->gedung_nama)?(empty($tool)?'':'&#13;').$model->gedung_nama:'';
                            $tool .= !empty($model->area_nama)?(empty($tool)?'':'&#13;').$model->area_nama:'';
                            $tool .= !empty($model->ruangan_lokasi)?(empty($tool)?'':'&#13;').$model->ruangan_lokasi:'';
                            $tool .= !empty($model->ruangan_nama)?(empty($tool)?'':'&#13;').$model->ruangan_nama:'';
                            $tool .= !empty($model->lokasiaset_namalokasi)?(empty($tool)?'':'&#13;').$model->lokasiaset_namalokasi:'';
    
                        ?>
                         <div class="control-group">
                            <?php echo CHtml::label('Lokasi Aset', '', array('class' => 'control-label')); ?>
                             <div class="controls" style="text-align: left;">
                                <textarea class="span4" cols='70' rows='5' readonly="true"><?= $model->lokasiaset_kode ?><?= $tool ?></textarea>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Keterangan', '', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textArea($model, 'korektifmainten_ket', array('readonly' => true, 'rows' => 4, 'cols' => 70, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                            </div>
                        </div>
                        
                    </div>
                    <div class="col-sm-6">
                        <div class="control-group ">
                            <?php echo CHtml::label('Tanggal Pemeliharaan', 'tglpermintaan', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php $model->korektifmainten_tglpawal = isset($model->korektifmainten_tglpawal) ? $format->formatDateTimeForUser($model->korektifmainten_tglpawal) : ''; ?>
                                <?php echo $form->textField($model, 'korektifmainten_tglpawal', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true)); ?>
                                <label>s/d</label>
                            </div>
                            <div class="controls">
                                <?php $model->korektifmainten_tglpakhir = isset($model->korektifmainten_tglpakhir) ? $format->formatDateTimeForUser($model->korektifmainten_tglpakhir) : ''; ?>
                                <?php echo $form->textField($model, 'korektifmainten_tglpakhir', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true)); ?>

                            </div>
                        </div>   
                        <div class="control-group">
                            <?php echo CHtml::label('Teknisi Internal', '', array('class' => 'control-label')); ?>
                            <?php
                                $tek = TeknisipemeliharaanasetT::model()->findAllByAttributes([
                                    'korektifmainten_id' => $model->korektifmainten_id,
                                    'jenis_teknisi' => 'Internal'
                                ]);
                                $arr = [];
                                foreach($tek as $det){
                                    $arr[] = $det->nama_teknisi;
                                }
                            ?>
                            <div class="controls">
                                <?php echo CHtml::textArea('nama_teknisi', implode(', ',$arr), array('class' => 'span4','rows'=>5,'cols'=>60, 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true)); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Teknisi Eksternal', '', array('class' => 'control-label')); ?>
                            <?php
                                $tek = TeknisipemeliharaanasetT::model()->findAllByAttributes([
                                    'korektifmainten_id' => $model->korektifmainten_id,
                                    'jenis_teknisi' => 'Eksternal'
                                ]);
                                $arr = [];
                                foreach($tek as $det){
                                    $arr[] = $det->nama_teknisi;
                                }
                            ?>
                            <div class="controls">
                                <?php echo CHtml::textField('nama_teknisi', implode(', ',$arr), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true)); ?>
                            </div>
                        </div>
                         <div class="control-group">
                            <?php echo CHtml::label('Catatan Perbaikan', '', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textArea($model, 'korektifmainten_catatan', array('rows'=>4,'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true)); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Kondisi Barang', '', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'invperalatan_keadaan', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true)); ?>
                            </div>
                        </div>
                        

                    </div>
                </div>

            </div>
        </div>
        
        <?php $this->renderPartial($this->path_view . '_riwayat_status', array('form' => $form, 'model' => $model, 'modR'=>$modR)); ?>
        
        <?php
            if (!empty($_GET['id'])) {
                echo CHtml::link('<i class="entypo-back" style="color: white;"></i> Kembali', '#', array('class' => 'btn btn-red', 'onclick' => 'window.history.back(); return false;', 'style' => 'color: white;'));
            }
        ?>
    </div>
</div>
<?php $this->endWidget(); ?>
