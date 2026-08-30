<div class="col-sm-6">
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="glyphicon glyphicon-file"></i> Data <b>Tim Operasi</b>
            </div>
        </div>
        <div class="panel-body">
            <div class="control-group">
                <?php echo CHtml::label('Nama Ahli Bedah', '', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php
                    $val = (empty($rencana) || empty($rencana->dokter1)) ? "" : ($rencana->dokter1->namaLengkap);
                    echo CHtml::textField('dokter_operator', $val, array('class' => 'span4', 'readonly' => true));
                    ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label('Nama Asisten Bedah', '', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php
                    $val = (empty($rencana) || empty($rencana->dokter2)) ? "" : ($rencana->dokter2->namaLengkap);
                    echo CHtml::textField('dokter_operator', $val, array('class' => 'span4', 'readonly' => true));
                    ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label('Nama Perawat', '', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php
                    $val = (empty($rencana) || empty($rencana->perawatsirkuler)) ? "" : ($rencana->perawatsirkuler->namaLengkap);
                    echo CHtml::textField('perawat_1', $val, array('class' => 'span4', 'readonly' => true));
                    ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label('Nama Ahli Anestesi', '', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php
                    $val = (empty($anestesi) || empty($anestesi->dokteranastesi)) ? "" : ($anestesi->dokteranastesi->namaLengkap);
                    echo CHtml::textField('dokter_anestesiologi', $val, array('class' => 'span4', 'readonly' => true));
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-sm-6">
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                Waktu Operasi
            </div>
        </div>
        <div class="panel-body">
            <div class="control-group">
                <?php echo CHtml::label('Tgl. Operasi', '', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php
                    echo CHtml::activeTextField($model, 'tanggal_operasi', array('class' => 'span3', 'readonly' => true));
                    ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo CHtml::label('Jam Operasi Dimulai', '', array('class' => 'control-label')); ?>
                <?php //echo $form->labelEx($model, 'jam_mulaioperasi', array('class' => 'control-label')) 
                ?>
                <div class="controls">
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'jam_mulaioperasi',
                        'mode' => 'time',

                        'options' => array(
                            'showOn' => false,
                        ),
                        'htmlOptions' => array(
                            'readonly' => TRUE,
                            'class' => 'span2',
                            'placeholder' => '00:00:00',
                            'onkeyup' => "return $(this).focusNextInputField(event),",
                        ),
                    ));
                    ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo CHtml::label('Jam Operasi Selesai', '', array('class' => 'control-label')); ?>
                <?php //echo $form->labelEx($model, 'jam_selesaioperasi', array('class' => 'control-label')) 
                ?>
                <div class="controls">
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'jam_selesaioperasi',
                        'mode' => 'time',

                        'options' => array(
                            'showOn' => false,
                        ),
                        'htmlOptions' => array(
                            'readonly' => TRUE,
                            'class' => 'span2',
                            'placeholder' => '00:00:00',
                            'onkeyup' => "return $(this).focusNextInputField(event),",
                        ),
                    ));
                    ?>
                </div>
            </div>
            <!-- <div class="control-group">
                <?php //echo CHtml::label('Jam Operasi Dimulai', '', array('class' => 'control-label')); 
                ?>
                <div class="controls">
                    <?php
                    //echo CHtml::activeTextField($model, 'jam_mulaioperasi', array('class' => 'span3', 'readonly' => true));
                    ?>
                </div>
            </div>
            <div class="control-group">
                <?php //echo CHtml::label('Jam Operasi Selesai', '', array('class' => 'control-label')); 
                ?>
                <div class="controls">
                    <?php
                    //echo CHtml::activeTextField($model, 'jam_selesaioperasi', array('class' => 'span3', 'readonly' => true));
                    ?>
                </div>
            </div> -->
            <div class="control-group">
                <?php echo CHtml::label('Lamanya Operasi Berlangsung', '', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php
                    echo CHtml::activeTextField($model, 'lamaoperasi', array('class' => 'span3', 'readonly' => true));
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="clear"></div>
<div class="col-sm-6">
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                Diagnosa
            </div>
        </div>
        <div class="panel-body">
            <div class="control-group">
                <?php echo CHtml::label('Diagnosa Pre-Operatif', '', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php
                    $diag = empty($diagnosa) ? "" : ($diagnosa->diagnosa->diagnosa_kode . " - " . $diagnosa->diagnosa->diagnosa_nama);
                    echo CHtml::textArea('diagnosa_prabedah', $diag, array('class' => 'span3', 'readonly' => true));
                    ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label('Diagnosa Post-Operatif', '', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php
                    $signout = OperasisignoutT::model()->findByAttributes(array(
                        'pasienmasukpenunjang_id' => $penunjang->pasienmasukpenunjang_id,
                    ));
                    $diag = empty($signout->signout_diagnosapostop) ? "" : ($signout->signout_diagnosapostop);
                    echo CHtml::textArea('diagnosa_postbedah', $diag, array('class' => 'span3', 'readonly' => true));
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-sm-6">
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                Jenis Anestesi & Jenis Operasi
            </div>
        </div>
        <div class="panel-body">
            <div class="control-group">
                <?php echo CHtml::label('Jenis Anestesi', '', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php
                    //                        var_dump($anestesi->jenisanastesi); die;
                    $val = (empty($anestesi) || empty($anestesi->jenisanastesi)) ? "" : ($anestesi->jenisanastesi->jenisanastesi_nama);
                    echo CHtml::textField('jenis_anestesi', $val, array('class' => 'span3', 'readonly' => true));
                    ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label('Jenis Operasi', '', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php
                    $val = (empty($rencana) || empty($rencana->operasi) || empty($rencana->operasi->kegiatanoperasi)) ? "" : ($rencana->operasi->kegiatanoperasi->kegiatanoperasi_nama);
                    echo CHtml::textField('jenis_operasi', $val, array('class' => 'span3', 'readonly' => true));
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="clear"></div>