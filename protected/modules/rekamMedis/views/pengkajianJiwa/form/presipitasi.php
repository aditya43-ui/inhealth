<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Faktor Presipitasi</div>
    </div>
    <div class="panel-body">
        <div class="control-group">
            <label>1. Peristiwa yang baru dialami dalam waktu dekat</label>
            <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$model, 'attribute'=>'presipitasi_peristiwabrdialami', 'toolbar'=>'mini','height'=>'100px')) ?>
        </div>
        <div class="control-group">
            <label>2. Perubahan aktivitas hidup sehari-hari</label>
            <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$model, 'attribute'=>'presipitasi_perubahanadl', 'toolbar'=>'mini','height'=>'100px')) ?>
        </div>
        <div class="control-group">
            <label>3. Perubahan fisik</label>
            <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$model, 'attribute'=>'presipitasi_perubahanfisik', 'toolbar'=>'mini','height'=>'100px')) ?>
        </div>
        <div class="control-group">
            <label>4. Lingkungan penuh kritik</label>
            <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$model, 'attribute'=>'presipitasi_lingkunganpenuhkritik', 'toolbar'=>'mini','height'=>'100px')) ?>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($det, 'diagnosakesehatanjiwa_id', array('class'=>'control-label')); ?>
            <div class="controls">
                <div id="panel_diagnosapresipitas">
                    <?php echo $form->checkBoxList($det, 'diagnosakesehatanjiwa_id[diagnosa_gangguan][faktorpersipitasi]', CHtml::listData(DiagnosakesehatanjiwaM::model()->findAllByAttributes(array(
                        'isaktif'=>true, 'jenisdiagnosa' => 'diagnosa_gangguan', 'kelompokdiagnosa' => 'faktorpersipitasi',
                    ), array('order'=>'diagnosakesehatanjiwa_id')), 'diagnosakesehatanjiwa_id', 'diagnosakesehatanjiwa_nama'), array('uncheckValue'=>null)); ?>
                </div>
                <?php echo CHtml::htmlButton('+ Tambah Diagnosa', array(
                    'class'=>'btn btn-success', 'onclick'=>"dialogTambahDiagnosa('panel_diagnosapresipitas', 'diagnosa_gangguan', 'faktorpersipitasi');"
                )); ?>
            </div>
        </div>
    </div>
</div>
