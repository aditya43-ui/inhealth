<div>
    <div class="control-group">
        <?php echo CHtml::label('Bentuk Diet', '', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo Chtml::dropDownList('dlg[tipediet_id]', '', Chtml::listData(TipeDietM::model()->findAllByAttributes(array('tipediet_aktif' => true)), 'tipediet_id', 'tipediet_nama'), array('empty' => '-- Pilih --'));        ?>
        </div>
    </div>
    <div class="control-group" hidden>
        <?php echo CHtml::label('Jenis Makanan', '', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo Chtml::dropDownList('dlg[jenismakanan_id]', '', Chtml::listData(JenismakananM::model()->findAllByAttributes(array('jenismakanan_aktif' => true)), 'jenismakanan_id', 'jenismakanan_nama'), array('empty' => '-- Pilih --')); ?>
        </div>
    </div>
    <div class="control-group ">
        <label class='control-label'>Menu<span class="required">*</span></label> <!-- RSWB-3933 sebelumnya berlabel jenis diet utama -->
        <div class="controls">
            <?php echo CHtml::hiddenField('dlg[pendaftaran_id]', $arr['pendaftaran_id'], array('readonly' => true)); ?>
            <?php echo CHtml::hiddenField('dlg[kelaspelayanan_id]', $arr['kelaspelayanan_id'], array('readonly' => true)); ?>
            <?php echo CHtml::hiddenField('dlg[pasien_id]', $arr['pasien_id'], array('readonly' => true)); ?>
            <?php echo CHtml::hiddenField('dlg[pasienadmisi_id]', $arr['pasienadmisi_id'], array('readonly' => true)); ?>
            <?php echo CHtml::hiddenField('dlg[jenis]', $arr['jenis']); ?>

            <?php echo Chtml::hiddenField('dlg[jenisdiet_id', $arr['jenisdiet_id'], array('empty' => '-- Pilih --','class'=>'permanent' )); ?>
            <?php echo Chtml::textField('dlg[jenisdiet_nama', $arr['jenisdiet_nama'],  array('disabled'=>true,'class'=>'permanent')); ?>

        </div>
    </div>
    <div class="control-group ">
        <label class='control-label'>Jenis Diet</label> <!-- RSWB-3933 sebelumnya berlabel menu diet -->
        <div class="controls">
            <?php echo Chtml::dropDownList('dlg[menudiet_id]', '', CHtml::listData(MenuDietM::model()->findAllByAttributes(array(
                'jenisdiet_id'=>$arr['jenisdiet_id']
            )),'menudiet_id','menudiet_nama'), array('empty' => '-- Pilih --', 'class' => 'menudiet_id', 'onkeypress' => "return $(this).focusNextInputField(event)",'onchange'=>'loadJenisWaktuBaru()')); ?>

        </div>
    </div>
    <div class="control-group ">
        <label class='control-label'>Jumlah Pesanan</label>
        <div class="controls">
            <?php echo Chtml::textField('dlg[jumlah]', 1, array('class' => 'span1 numbers-only', 'onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'text-align:right;')); ?>                
        </div>
    </div>
    
    <div class="control-group" hidden>
        <?php echo CHtml::label('Alat Makan', '', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo Chtml::dropDownList('dlg[alatmakanan_id]', '', $dropAlatByKelas, array('empty' => '-- Pilih --')); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Jenis Waktu', '', array('class' => 'control-label')); ?>
        <div class="controls" id="load_jeniswaktu">

        </div>
    </div>    
    <div class="form-actions">
        <div class="control-group ">
            <?php echo CHtml::label('', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>', array(
                    'onclick' => 'inputMenuDietByDialog();',
                    'class' => 'btn btn-primary',
                    'onkeypress' => "return $(this).focusNextInputField(event)",
                    'rel' => "tooltip",
                    'title' => "Klik untuk menambahkan Menu Diet"
                ));
                ?>
            </div>
        </div>
    </div>
</div>