<label>a. Pengalaman Masa Lalu yang tidak menyenangkan</label>
<div class="control-group">
    <label class="control-label">&nbsp;</label>
    <div class="controls">
        <?php $this->widget('ext.redactorjs.Redactor', array('model' => $model, 'attribute' => 'pengalamantdk_menyenangkan', 'toolbar' => 'mini', 'height' => '100px')) ?>
        <div class="control-group">
            <?php echo $form->labelEx($det, 'diagnosakesehatanjiwa_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <div id="panel_diagnosa_tidakmenyenangkan">
                    <?php
                    echo $form->checkBoxList($det, 'diagnosakesehatanjiwa_id[diagnosa_gangguan][pengalamantidak_menyenangkan]', CHtml::listData(DiagnosakesehatanjiwaM::model()->findAllByAttributes(array(
                                'isaktif' => true, 'jenisdiagnosa' => 'diagnosa_gangguan', 'kelompokdiagnosa' => 'pengalamantidak_menyenangkan',
                                ), array('order' => 'diagnosakesehatanjiwa_id')), 'diagnosakesehatanjiwa_id', 'diagnosakesehatanjiwa_nama'), array('uncheckValue'=>null));
                    ?>
                </div>
                <?php
                echo CHtml::htmlButton('+ Tambah Diagnosa', array(
                    'class' => 'btn btn-success', 'onclick' => "dialogTambahDiagnosa('panel_diagnosa_tidakmenyenangkan', 'diagnosa_gangguan', 'pengalamantidak_menyenangkan');"
                ));
                ?>
            </div>
        </div>
    </div>
</div>