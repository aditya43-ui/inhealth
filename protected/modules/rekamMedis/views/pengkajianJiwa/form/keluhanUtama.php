<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Keluhan Utama</div>
    </div>
    <div class="panel-body">
        <div class="row-fluid">
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'keluhanutama', array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$model, 'attribute'=>'keluhanutama', 'toolbar'=>'mini','height'=>'100px')) ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo $form->labelEx($det, 'diagnosakesehatanjiwa_id', array('class'=>'control-label')); ?>
                    <div class="controls">
                        <div id="panel_diagnosajiwa">
                            <?php 
                            echo $form->checkBoxList($det, 'diagnosakesehatanjiwa_id[diagnosa_gangguan][keluhanutama]', CHtml::listData(DiagnosakesehatanjiwaM::model()->findAllByAttributes(array(
                                'isaktif'=>true, 'jenisdiagnosa' => 'diagnosa_gangguan', 'kelompokdiagnosa' => 'keluhanutama',
                            ), array('order'=>'diagnosakesehatanjiwa_id')), 'diagnosakesehatanjiwa_id', 'diagnosakesehatanjiwa_nama'), array('uncheckValue'=>null)); ?>
                        </div>
                        <?php echo CHtml::htmlButton('+ Tambah Diagnosa', array(
                            'class'=>'btn btn-success', 'onclick'=>"dialogTambahDiagnosa('panel_diagnosajiwa', 'diagnosa_gangguan', 'keluhanutama');"
                        )); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




