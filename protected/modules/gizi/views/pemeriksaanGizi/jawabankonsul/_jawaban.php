
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            Jawaban Konsultasi
        </div>
    </div>
    <div class="panel-body">
        <div class="col-sm-12">
            <div class="hidden">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'tgljawabpoli',
                    'mode' => 'datetime',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        'maxDate' => 'd',
                    ),
                    'htmlOptions' => array('readonly' => true),
                ));
                ?>
            </div>
        </div>
        <div class="col-sm-12">
            <br/>
            <div>Dari pemeriksaan pada pasien, dijumpai:</div>
            <br/>
            <br/>
        </div>
        <div class="col-sm-12">
            <div class="control-group">
                <div class="controls uraian_konsuljawaban" style="width:80%;">
                   
                    <?php

                        $peg = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
                        if($peg->kelompokpegawai_id !== Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN) {
                            $this->widget('ext.redactorjs.Redactor', array('model' => $model, 'attribute' => 'uraian_konsuljawaban', 'toolbar' => 'mini', 'height' => '200px'));
                        } else {
                            echo CHtml::activeTextArea($model, 'uraian_konsuljawaban', array('style' => 'min-width: 1000px; min-height: 250px; ', 'readonly' => true));
                        }
                    
                    ?>
                   
                </div>
            </div>
        </div> <!-- ./col -->
        <div class="form-actions">
            <?= CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-primary submit', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'id' => 'btn_simpan', 'disabled' => (isset($_GET['sukses'])) ? true : false)); ?>
        </div>
    </div>
</div>
    
