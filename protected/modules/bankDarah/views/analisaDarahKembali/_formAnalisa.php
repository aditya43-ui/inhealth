<?php

$radioTemplate = '{input} <span style="margin-right: 30px;">{label}</span>';

?>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Analisa Darah Kembali</div>
    </div>
    <div class="panel-body">
        <div class="control-group ">
            <?php echo $form->labelEx($model, 'tgl_analisa', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'tgl_analisa',
                    'mode' => 'datetime',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        // 'maxDate' => 'd',
                    ),
                    'htmlOptions' => array('class'=>'span3', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)"
                    ),
                ));
                ?>
                <?php echo $form->error($model, 'tgl_analisa'); ?>
            </div>
        </div>
    </div>
    <div class="panel-body">
        <div class="col-sm-6">
            <div class="control-group ">
                <?php echo $form->labelEx($model, 'is_kadaluarsa', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->radioButtonList($model, 'is_kadaluarsa', array(1 => 'Ya', 2 => 'Tidak'),
                    array(
                        'class'=>'cek_analisa',
                        'readonly'=>false, 
                        'template'=>$radioTemplate
                    )); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo $form->labelEx($model, 'is_sealer_habis', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->radioButtonList($model, 'is_sealer_habis', array(1 => 'Ya', 2 => 'Tidak'),
                    array(
                        'class'=>'cek_analisa',
                        'readonly'=>false, 
                        'template'=>$radioTemplate
                    )); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo $form->labelEx($model, 'is_bocor', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->radioButtonList($model, 'is_bocor', array(1 => 'Ya', 2 => 'Tidak'),
                    array(
                        'class'=>'cek_analisa',
                        'readonly'=>false, 
                        'template'=>$radioTemplate
                    )); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo $form->labelEx($model, 'is_tabung_terbuka', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->radioButtonList($model, 'is_tabung_terbuka', array(1 => 'Ya', 2 => 'Tidak'),
                    array(
                        'class'=>'cek_analisa',
                        'readonly'=>false, 
                        'template'=>$radioTemplate
                    )); ?>
                </div>
            </div>
            
            
        </div>
        <div class="col-sm-6">
            <div class="control-group ">
                <?php echo $form->labelEx($model, 'is_plasma_pink', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->radioButtonList($model, 'is_plasma_pink', array(1 => 'Ya', 2 => 'Tidak'),
                    array(
                        'class'=>'cek_analisa',
                        'readonly'=>false, 
                        'template'=>$radioTemplate
                    )); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo $form->labelEx($model, 'is_gumpalan_plasma', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->radioButtonList($model, 'is_gumpalan_plasma', array(1 => 'Ya', 2 => 'Tidak'),
                    array(
                        'class'=>'cek_analisa',
                        'readonly'=>false, 
                        'template'=>$radioTemplate
                    )); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo $form->labelEx($model, 'is_hemolisis', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->radioButtonList($model, 'is_hemolisis', array(1 => 'Ya', 2 => 'Tidak'),
                    array(
                        'class'=>'cek_analisa',
                        'readonly'=>false, 
                        'template'=>$radioTemplate
                    )); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo $form->labelEx($model, 'is_endapan', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->radioButtonList($model, 'is_endapan', array(1 => 'Ya', 2 => 'Tidak'),
                    array(
                        'class'=>'cek_analisa',
                        'readonly'=>false, 
                        'template'=>$radioTemplate
                    )); ?>
                </div>
            </div>
        </div>
        <div class="clear"></div>

    </div>
    <div class='panel-body'>
        <div class="control-group ">
            <?php echo $form->labelEx($model, 'kesimpulan', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'kesimpulan', array(
                'readonly'=>true, 
                'class'=>'span3',
                'onblur'=>'return false;',
                )); ?>
            </div>
        </div>
        
        <div class="control-group">
            <?php echo $form->labelEx($model, 'petugas_analisa_id', array(
                'class'=>'control-label',
                'label'=>'Petugas Penerima Darah Kembali',
            )); ?>
            <div class="controls">
                <?php
                    echo $form->hiddenField($model, 'petugas_analisa_id', array(
                        'class'=>'petugas_analisa_id',
                    ));

                    $petugas_analisa_nama = "";

                    // --- kondisi jika ada data-nya
                    if (!empty($model->petugas_analisa_id)) {
                        $peg = PegawaiM::model()->findByPk($model->petugas_analisa_id);
                        $petugas_analisa_nama = $peg->nama_pegawai;
                    }

                    echo $form->textField($model, 'petugas_analisa_nama', array(
                        'readonly'=>true, 
                        'class'=>'span3 required',
                        'onblur'=>'return false;',
                    )); 
                    // --- end

                ?>
            
            </div>
        </div>
    </div>
</div>