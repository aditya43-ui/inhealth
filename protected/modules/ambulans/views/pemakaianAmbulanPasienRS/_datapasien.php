<fieldset>
    <legend>Data Pasien</legend>
    <table class="table table-condensed">
        <tr>
            <td>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modPasien, 'tgl_pendaftaran', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modPasien, 'tgl_pendaftaran', array('readonly' => true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">No. Pendaftaran</label>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modPasien, 'no_pendaftaran', array('readonly' => true, 'class' => 'span2')); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modPasien, 'umur', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modPasien, 'umur', array('readonly' => true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modPasien, 'jeniskasuspenyakit_nama', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modPasien, 'jeniskasuspenyakit_nama', array('readonly' => true)); ?>
                    </div>
                </div>
                 <div class="control-group">
                <label class="control-label">Diagnosa</label>
                    <div class="controls">
                        <?php echo CHtml::textField('diagnosa_nama', '', array('readonly' => true)); ?>
                    </div>
                </div>
            </td>
            <td>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modPasien, 'no_rekam_medik', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $modPasien,
                            'attribute' => 'no_rekam_medik',
                            'value' => '',
                            'sourceUrl' => $this->createUrl('AutocompletePasienRJ'),
                            'options' => array(
                                'showAnim' => 'fold',
                                'minLength' => 3,
                                'focus' => 'js:function( event, ui ) {
                                        $(this).val( ui.item.label);

                                        return false;
                                    }',
                                'select' => 'js:function( event, ui ) {
                                          $("#' . CHtml::activeId($modPasien, 'tgl_pendaftaran') . '").val(ui.item.tgl_pendaftaran);
                                          $("#' . CHtml::activeId($modPasien, 'no_pendaftaran') . '").val(ui.item.no_pendaftaran);   
                                          $("#' . CHtml::activeId($modPasien, 'umur') . '").val(ui.item.umur);     
                                          $("#' . CHtml::activeId($modPasien, 'jeniskasuspenyakit_nama') . '").val(ui.item.jeniskasuspenyakit_nama);
                                          $("#' . CHtml::activeId($modPasien, 'no_pendaftaran') . '").val(ui.item.no_pendaftaran);   
                                          $("#' . CHtml::activeId($modPasien, 'nama_pasien') . '").val(ui.item.nama_pasien);     
                                          $("#' . CHtml::activeId($modPasien, 'jeniskelamin') . '").val(ui.item.jeniskelamin);  
                                          $("#' . CHtml::activeId($modPasien, 'no_pendaftaran') . '").val(ui.item.no_pendaftaran);  
                                          $("#' . CHtml::activeId($modPasien, 'nama_bin') . '").val(ui.item.nama_bin);   
                                          if (!jQuery.isNumeric(ui.item.diagnosa_id)){
                                              ui.item.diagnosa_id = 0;
                                          }
                                          $("#' . CHtml::activeId($model, 'diagnosa_id') . '").val(ui.item.diagnosa_id); 
                                          //setRiwayat();
                                              }',
                            ),
                        ));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modPasien, 'jeniskelamin', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modPasien, 'jeniskelamin', array('readonly' => true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modPasien, 'nama_pasien', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modPasien, 'nama_pasien', array('readonly' => true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modPasien, 'nama_bin', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modPasien, 'nama_bin', array('readonly' => true)); ?>
                    </div>
                </div>
            </td>
        </tr>
    </table>
</fieldset>

    
