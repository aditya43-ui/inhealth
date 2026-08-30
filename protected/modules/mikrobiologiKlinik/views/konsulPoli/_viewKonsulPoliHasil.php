<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'id'=>'rjkonsul-poli-t-formupdate',
    'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#',
)); ?>
<table style="width: 100%; border: none;">
    <tr>
        <td>
            <div class="control-group">
                <label class="control-label">Tanggal dan Jam Jawab</label>
                <div class="controls">
                    <?php echo $form->textField($modKonsul, 'tgljawabpoli', array('class' => 'col-sm-6', 'onkeypress' => "return $(this).focusNextInputField(event);", 'disabled' => true)); ?>
                </div>
            </div>
            <?php  if(Yii::app()->user->getState('modul_id') != Params::MODUL_ID_RJ){ ?>
            <div class="control-group">
                <label class="control-label">Sesuai Permohonan Konsultasi, Pada Kasus Ini Dijumpai</label>
                <div class="controls">
                    <?php echo $form->textArea($modKonsul, 'jawaban_konsul', array('class' => 'col-sm-6', 'onkeypress' => "return $(this).focusNextInputField(event);", 'disabled' => true)); ?>
                </div>
            </div>
            <?php } ?>
            <?php  //if(Yii::app()->user->getState('modul_id') == Params::MODUL_ID_RJ){ ?>
            <div class="col-sm-12">
                <br />
                <div>Sesuai Permohonan Konsultasi, Pada Kasus Ini Dijumpai</div>
                <br />
                <br />
            </div>
    <tr width="50%">
        <td width="50%">
            <div class="control-group">
                <label class="control-label">Uraian Konsul</label>
                <div class="controls">
                    <?= CHtml::textArea('', preg_replace('#</?p.*?>#is', '', $modKonsul->uraian_konsul), array('class'
                    => '', 'style' => 'text-align:left', 'readonly' => true)) ?>
                </div>
            </div>
        </td>
    </tr>
    <tr width="50%">
        <td width="50%">
            <div class="control-group">
                <label class="control-label">Jawaban Konsul</label>
                <div class="controls">
                    <?= CHtml::textArea('', preg_replace('#</?p.*?>#is', '', $modKonsul->uraian_konsuljjawaban), array('class'
                    => '', 'style' => 'text-align:left', 'readonly' => true)) ?>
                </div>
            </div>
        </td>
    </tr>
    <?php //} ?>
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
        <div class="controls">
            <?php echo $form->textArea($modKonsul, 'saran_tindakan', array('class' => 'col-sm-6', 'onkeypress' => "return $(this).focusNextInputField(event);", 'disabled' => true)); ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Prof. / dr. / Spesialis</label>
        <div class="controls">
            <?php echo $form->textField($modKonsul, 'nama_pegawai', array('class' => 'col-sm-6', 'onkeypress' => "return $(this).focusNextInputField(event);", 'disabled' => true)); ?>
        </div>
    </div>
    </td>
    </tr>
</table>
<div class="form-actions">
    <?php echo CHtml::link(Yii::t('mds', '{icon} Ok', array('{icon}' => '<i class="entypo-check"></i>')), '#', array('class' => 'btn btn-danger', 'onclick' => '$("#dialogDetailKonsul").dialog("close");return false;'));
    ?>
</div>

<?php $this->endWidget(); ?>