<div class="">
    <div class="row">
        <div class="col-sm-6">
            <div>
                <h5>1. Kondisi Pasien Saat Masuk RS</h5>
            </div>
            <div class="control-group">
                <?php
                echo CHtml::hiddenField('ASResumeaskepR[tglkeluarrs]', $model->tglkeluarrs, array('readonly' => true));
                echo CHtml::activeLabel($model, 'keluhanutamamasuk', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textArea($model, 'keluhanutamamasuk', array('placeholder' => 'Keluhan', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                </div>
            </div>
            <div style="margin-left: 20px;">
                <h5>Keadaan Umum</h5>
            </div>
            <div class="control-group">
                <?php echo CHtml::activeLabel($model, 'keadaanumummasuk', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo CHtml::activeTextField($model, 'keadaanumummasuk', array('placeholder' => 'Kesadaran', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                </div>
            </div>
            <div style="margin-left: 70px;">
                <h5>GCS</h5>
            </div>
            <div class="row-fluid" style="margin-left: 70px;">
                <div class="span3">
                    <div class="control-group">
                        <?php echo CHtml::activeLabel($model, 'gcs_eye', array('class' => 'control-label', 'style' => 'width: 25px;')); ?>
                        <div class="controls">
                            <?php echo CHtml::activeTextField($model, 'gcs_eye', array('placeholder' => '00', 'class' => 'span1 integer numbersOnly', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                        </div>
                    </div>
                </div>
                <div class="span3" style="margin-left: -30px;">
                    <div class="control-group">
                        <?php echo CHtml::activeLabel($model, 'gcs_motorik', array('class' => 'control-label', 'style' => 'width: 35px;')); ?>
                        <div class="controls">
                            <?php echo CHtml::activeTextField($model, 'gcs_motorik', array('placeholder' => '00', 'class' => 'span1 integer numbersOnly', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                        </div>
                    </div>
                </div>
                <div class="span3" style="margin-left: -30px;">
                    <div class="control-group">
                        <?php echo CHtml::activeLabel($model, 'gcs_verbal', array('class' => 'control-label', 'style' => 'width: 35px;')); ?>
                        <div class="controls">
                            <?php echo CHtml::activeTextField($model, 'gcs_verbal', array('placeholder' => '00', 'class' => 'span1 integer numbersOnly', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                        </div>
                    </div>
                </div>
                <div class="span3" style="margin-left: -50px;">
                    <div class="control-group">
                        <?php echo CHtml::label('=', 'gcs_hasil', array('class' => 'control-label', 'style' => 'width: 25px;')); ?>
                        <div class="controls">
                            <?php echo CHtml::activeTextField($model, 'gcs_hasil', array('placeholder' => '00', 'class' => 'span1 integer numbersOnly', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div style="margin-left: 70px;">
                <h5>Tanda Vital</h5>
            </div>
            <div class="control-group" style="margin-left: 50px;">
                <?php echo CHtml::activeLabel($model, 'tekanandarahmasuk', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo CHtml::activeTextField($model, 'tekanandarahmasuk', array('placeholder' => '00', 'class' => 'span2', 'style' => 'text-align:right;', 'onkeyup' => "return $(this).focusNextInputField(event);")) . ' /mmHg'; ?>
                </div>
            </div>
            <div class="control-group" style="margin-left: 50px;">
                <?php echo CHtml::activeLabel($model, 'detaknadimasuk', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo CHtml::activeTextField($model, 'detaknadimasuk', array('placeholder' => '00', 'class' => 'span2 integer numbersOnly', 'onkeyup' => "return $(this).focusNextInputField(event);")) . ' /Menit'; ?>
                </div>
            </div>
            <div class="control-group" style="margin-left: 50px;">
                <?php echo CHtml::activeLabel($model, 'suhutubuhmasuk', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo CHtml::activeTextField($model, 'suhutubuhmasuk', array('placeholder' => '00', 'class' => 'span2 integer numbersOnly', 'onkeyup' => "return $(this).focusNextInputField(event);")) . ' &#8451;'; ?>
                </div>
            </div>
            <div class="control-group" style="margin-left: 50px;">
                <?php echo CHtml::activeLabel($model, 'pernapasanmasuk', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo CHtml::activeTextField($model, 'pernapasanmasuk', array('placeholder' => '00', 'class' => 'span2 integer numbersOnly', 'onkeyup' => "return $(this).focusNextInputField(event);")) . ' /Menit'; ?>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div>
                <h5>3. Kondisi Pasien Saat Keluar RS</h5>
            </div>
            <div class="control-group">
                <?php echo CHtml::activeLabel($model, 'keluhanakhir', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textArea($model, 'keluhanakhir', array('placeholder' => 'Keluhan', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::activeLabel($model, 'keadaanumumakhir', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textArea($model, 'keadaanumumakhir', array('placeholder' => 'Keadaan Umum', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                </div>
            </div>
            <div style="margin-left: 45px;">
                <h5>Tanda Vital</h5>
            </div>
            <div class="control-group" style="margin-left: 35px;">
                <?php echo CHtml::activeLabel($model, 'tekanandarahakhir', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo CHtml::activeTextField($model, 'tekanandarahakhir', array('placeholder' => '00', 'class' => 'span2', 'style' => 'text-align:right;', 'onkeyup' => "return $(this).focusNextInputField(event);")) . ' /mmHg'; ?>
                </div>
            </div>
            <div class="control-group" style="margin-left: 35px;">
                <?php echo CHtml::activeLabel($model, 'detaknadiakhir', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo CHtml::activeTextField($model, 'detaknadiakhir', array('placeholder' => '00', 'class' => 'span2  integer numbersOnly', 'onkeyup' => "return $(this).focusNextInputField(event);")) . ' /Menit'; ?>
                </div>
            </div>
            <div class="control-group" style="margin-left: 35px;">
                <?php echo CHtml::activeLabel($model, 'suhutubuhakhir', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo CHtml::activeTextField($model, 'suhutubuhakhir', array('placeholder' => '00', 'class' => 'span2 integer numbersOnly', 'onkeyup' => "return $(this).focusNextInputField(event);")) . ' &#8451;'; ?>
                </div>
            </div>
            <div class="control-group" style="margin-left: 35px;">
                <?php echo CHtml::activeLabel($model, 'pernapasanakhir', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo CHtml::activeTextField($model, 'pernapasanakhir', array('placeholder' => '00', 'class' => 'span2 integer numbersOnly', 'onkeyup' => "return $(this).focusNextInputField(event);")) . ' /Menit'; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div>
                <h5>2. Kondisi pasien saat dirawat</h5>
            </div>
            <div class="control-group ">
                <?php echo CHtml::activeLabelEx($model, 'diagnosakeperawatan', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo CHtml::activeTextArea($model, 'diagnosakeperawatan', array('placeholder' => 'Diagnosa Keperawatan', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    <?php
                    echo CHtml::htmlButton('<i class="icon-plus-sign icon-white"></i> <i class="icon-white icon-chevron-right"></i>', array(
                        'class' => 'btn btn-primary', 'onclick' => "$('#dialogDiagnosa').dialog('open');",
                        'id' => 'btnDiagnosa', 'onkeypress' => "return $(this).focusNextInputField(event)",
                        'rel' => 'tooltip', 'title' => 'Klik untuk menambah ' . $model->getAttributeLabel('diagnosakeperawatan')
                    ))
                    ?>
                    <?php echo $form->error($model, 'diagnosakeperawatan'); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo CHtml::activeLabelEx($model, 'tindakankeperawatan', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo CHtml::activeTextArea($model, 'tindakankeperawatan', array('placeholder' => 'Tindakan Keperawatan', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    <?php
                    echo CHtml::htmlButton('<i class="icon-plus-sign icon-white"></i> <i class="icon-white icon-chevron-right"></i>', array(
                        'class' => 'btn btn-primary', 'onclick' => "$('#dialogTindakan').dialog('open');",
                        'id' => 'btnTindakan', 'onkeypress' => "return $(this).focusNextInputField(event)",
                        'rel' => 'tooltip', 'title' => 'Klik untuk menambah ' . $model->getAttributeLabel('tindakankeperawatan')
                    ))
                    ?>
                    <?php echo $form->error($model, 'tindakankeperawatan'); ?>
                </div>
            </div>
        </div>
    </div>
</div>