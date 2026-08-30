<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-user"></i> Data <b>Pasien</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-5">
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modPendaftaran, 'tgl_pendaftaran', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modPendaftaran, 'tgl_pendaftaran', array('class' => 'span4', 'readonly' => true)); ?>
                    </div>
                </div>

                <div class="control-group">
                    <?php echo CHtml::activeLabel($modPendaftaran, 'no_pendaftaran', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modPendaftaran, 'no_pendaftaran', array('class' => 'span4', 'readonly' => true)); ?>
                    </div>
                </div>

                <div class="control-group">
                    <?php echo CHtml::activeLabel($modPendaftaran, 'umur', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modPendaftaran, 'umur', array('class' => 'span4', 'readonly' => true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modPendaftaran, 'jeniskasuspenyakit_id', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php
                        if (!empty($modPendaftaran->jeniskasuspenyakit_id))
                            echo CHtml::activeTextField($modPendaftaran->jeniskasuspenyakit, 'jeniskasuspenyakit_nama', array('class' => 'span4', 'readonly' => true));
                        else
                            echo CHtml::activeTextField($modPendaftaran, 'jeniskasuspenyakit_id', array('class' => 'span4', 'readonly' => true));
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-5">
                <div class="control-group">
                    <?php echo CHtml::Label('No. Rekam Medik <span class="required">*</span>', 'no_rekam_medik', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php
                        if (!empty($readOnlyNoRm) || (isset($_GET['pendaftaran_id']) && !empty($_GET['pendaftaran_id']))) {
                            echo CHtml::activeTextField($modPasien, 'no_rekam_medik', array('readonly' => true));
                        } else {
                            $this->widget('MyJuiAutoComplete', array(
                                'model' => $modPasien,
                                'attribute' => 'no_rekam_medik',
                                'value' => '',
                                'sourceUrl' => $this->createUrl('AutocompletePasienJenazah'),
                                'options' => array(
                                    'showAnim' => 'fold',
                                    'minLength' => 3,
                                    'focus' => 'js:function( event, ui ) {
                                        $(this).val( ui.item.label);

                                        return false;
                                    }',
                                    'select' => 'js:function( event, ui ) {
                                          $("#' . CHtml::activeId($modPendaftaran, 'tgl_pendaftaran') . '").val(ui.item.tgl_pendaftaran);
                                          $("#' . CHtml::activeId($modPendaftaran, 'no_pendaftaran') . '").val(ui.item.no_pendaftaran);
                                          $("#' . CHtml::activeId($modPendaftaran, 'umur') . '").val(ui.item.umur);
                                          $("#' . CHtml::activeId($modPendaftaran, 'jeniskasuspenyakit_id') . '").val(ui.item.jeniskasuspenyakit_nama);
                                          $("#' . CHtml::activeId($modPendaftaran, 'kelaspelayanan_id') . '").val(ui.item.kelaspelayanan_id);
                                          $("#' . CHtml::activeId($modPendaftaran, 'carabayar_id') . '").val(ui.item.carabayar_id);
                                          $("#' . CHtml::activeId($modPendaftaran, 'kelompokumur_id') . '").val(ui.item.kelompokumur_id);
                                          $("#' . CHtml::activeId($modPendaftaran, 'pendaftaran_id') . '").val(ui.item.pendaftaran_id);
                                          $("#' . CHtml::activeId($modPasien, 'nama_pasien') . '").val(ui.item.nama_pasien);
                                          $("#' . CHtml::activeId($modPasien, 'jeniskelamin') . '").val(ui.item.jeniskelamin);
                                          $("#pasienmasukpenunjang_id").val(ui.item.pasienmasukpenunjang_id);
                                          $("#kelaspelayanan_idNew").val(ui.item.kelaspelayanan_id);
                                      }',
                                ),
                                'tombolDialog' => array('idDialog' => 'dialogPasien'),
                                'htmlOptions' => array(
                                    'class' => 'span4 required',
                                    'placeholder' => 'No. Rekam Medik',
                                ),
                            ));
                        }
                        ?>
                    </div>
                </div>

                <div class="control-group">
                    <?php echo CHtml::activeLabel($modPasien, 'jeniskelamin', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modPasien, 'jeniskelamin', array('class' => 'span4', 'readonly' => true)); ?>
                    </div>
                </div>

                <div class="control-group">
                    <?php echo CHtml::activeLabel($modPasien, 'nama_pasien', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modPasien, 'nama_pasien', array('class' => 'span4', 'readonly' => true)); ?>
                    </div>
                </div>

                <div class="control-group">
                    <?php echo CHtml::activeLabel($modPasien, 'nama_bin', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modPasien, 'nama_bin', array('class' => 'span4', 'readonly' => true)); ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-2">
                <?php
                if (!empty($modPasien->photopasien)) {
                    echo CHtml::image(Params::urlPhotoPasienDirectory() . $modPasien->photopasien, 'Foto pasien', array('width' => 120));
                } else {
                    echo CHtml::image(Params::urlPhotoPasienDirectory() . 'no_photo.jpeg', 'Foto pasien', array('width' => 120));
                }
                ?>
            </div>
        </div>
    </div>
</div>
