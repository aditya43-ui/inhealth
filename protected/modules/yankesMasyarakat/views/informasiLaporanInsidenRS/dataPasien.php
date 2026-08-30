<div class="row-fluid">
    <div class="span6">   
        <div class="control-group">
            <?php
            echo $form->labelEx($model, 'no_rekam_medik', array(
                'class' => 'control-label-left',
                'label' => '1. No. Rekam Medik <span class="required">*</span>',
            ));
            ?>
            <div class="controls">
                <?php echo CHtml::activeTextField($modPasien, 'no_rekam_medik', array('readonly'=>true)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('2. Nama Pasien <span class="required">*</span>', 'nama_pasien', array('class' => 'control-label-left')) ?>
            <div class="controls"> 
                <?php echo CHtml::activeTextField($modPasien, 'nama_pasien', array('readonly'=>true)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('3. Umur', 'umur', array('class' => 'control-label-left')) ?>
            <div class="controls"> 
                <?php echo CHtml::activeTextField($modPendaftaran, 'umur', array('readonly'=>true)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('4. Jenis Kelamin', 'jeniskelamin', array('class' => 'control-label-left')) ?>
            <div class="controls"> 
                <?php echo CHtml::activeTextField($modPasien, 'jeniskelamin', array('readonly'=>true)); ?>
            </div>
        </div>
    </div>
    <div class="span6">
        <div class="control-group">
            <?php echo CHtml::label('5. Ruangan', 'ruangan_pasien', array('class' => 'control-label-left')) ?>
            <div class="controls"> 
                <?php echo CHtml::activeTextField((!empty($modPendaftaran->ruangan_id)?$modPendaftaran->ruangan:$modPendaftaran), 'ruangan_nama', array('readonly'=>true)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('6. Penanggung Biaya Pasien', 'tanggalmasukrs', array('class' => 'control-label-left')) ?>
            <div class="controls">
                <?php
                    $lookup = LookupM::getItemsUrutan('penanggungbiayapasien');
                    $i = 0;
                    foreach($lookup as $key => $val){
                ?>
                    <?php echo CHtml::activeRadioButton($model, 'penanggungjawab_biaya',array('uncheckValue'=>null, 'value'=>$key, 'class' => 'sponsorkualifikasi', 'disabled' => true)); ?>
                    <label>&nbsp; <?php echo $val; ?></label>
                    <?php } ?>
            </div>
        </div>
    
        <?php if($model->penanggungjawab_biaya == 'Lainnya') : ?>
        <div class="control-group">
            <?php echo CHtml::label('', '', array('class' => 'control-label alig','style'=>'width:20px')) ?>
            <?php echo CHtml::label('', 'penanggungbiaya', array('class' => 'control-label alig')) ?>
            <div class="controls">    
                <?php echo CHtml::activeTextField($model, 'penanggungjawabpasien_lainnya_ket', array('class' => 'span3', 'disabled' => true)); ?>       
            </div>
        </div>
        <?php endif;?>
        <div class="control-group">
            <?php echo CHtml::label('7. Tanggal Masuk RS', 'tanggalmasukrs', array('class' => 'control-label-left')) ?>
            <div class="controls"> 
                <?php 
                $modPendaftaran->tgl_pendaftaran = MyFormatter::formatDateTimeForUser($modPendaftaran->tgl_pendaftaran);
                echo CHtml::activeTextField($modPendaftaran, 'tgl_pendaftaran', array('disabled' => true, 'rows' => 5)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('8. Diagnosa <span class="required">*</span>', 'diagnosa_id', array('class' => 'control-label-left')) ?>
                <div class="controls">
                    <?php
                        echo CHtml::activeTextField($model, 'diagnosa_nama', array('disabled' => true));
                    ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('9. Diagnosa Lainnya <span class="required">*</span>', 'diagnosa_lainnya', array('class' => 'control-label-left')) ?>
        <div class="controls"> 
            <?php echo $form->textArea($model, 'diagnosa_lainnya', array('disabled' => true, 'class' => 'span4')); ?> 
        </div>
    </div>
    </div>
</div>