<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'id'=>'rjkonsul-poli-t-formupdate',
    'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#',
)); ?>
            <div class="control-group">
                <label class="control-label">Tanggal dan Jam Jawab</label>
                <div class="controls" style="width: calc(100% - 150px);">
                    <?php echo $form->textField($modKonsul, 'tgljawabpoli', array('style'=>'width: 100%','onkeypress' => "return $(this).focusNextInputField(event);", 'disabled' => true)); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Sesuai Permohonan Konsultasi, Pada Kasus Ini Dijumpai</label>
                <div class="controls" style="width: calc(100% - 150px);">
                    <?php echo $form->textArea($modKonsul, 'jawaban_konsul', array('style'=>'width: 100%', 'onkeypress' => "return $(this).focusNextInputField(event);", 'disabled' => true)); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Diagnosa</label>
                <div class="controls">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Kelompok Diagnosa</th>
                                <th>Kode Diagnosa</th>
                                <th>Nama Diagnosa</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if(count((array)$modMorbiditas)){
                                foreach ($modMorbiditas as $key => $value) {
                                    echo "
                                        <tr>
                                            <td>".$value->kelompokdiagnosa->kelompokdiagnosa_nama."</td>
                                            <td>".$value->diagnosa->diagnosa_kode."</td>
                                            <td>".$value->diagnosa->diagnosa_nama."</td>
                                        </tr>
                                    ";
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Saran Tindak Medik / Pengobatan</label>
                <div class="controls" style="width: calc(100% - 150px);">
                    <?php echo $form->textArea($modKonsul, 'saran_tindakan', array('style'=>'width: 100%', 'onkeypress' => "return $(this).focusNextInputField(event);", 'disabled' => true)); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Prof. / dr. / Spesialis</label>
                <div class="controls" style="width: calc(100% - 150px);">
                    <?php echo $form->textField($modKonsul, 'nama_pegawai', array('style'=>'width: 100%', 'onkeypress' => "return $(this).focusNextInputField(event);", 'disabled' => true)); ?>
                </div>
            </div>
<div class="form-actions">
    <?php echo CHtml::link(Yii::t('mds', 'Kembali', array('{icon}' => '<i class="icon-rewind icon-white"></i>')), Yii::app()->request->urlReferrer, array('class' => 'btn btn-danger'));
    ?>
</div>

<?php $this->endWidget(); ?>