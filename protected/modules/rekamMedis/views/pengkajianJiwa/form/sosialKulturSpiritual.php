<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Sosial-Kultur-Spiritual</div>
    </div>
    <div class="panel-body">
        <br/>
        <div class="panel panel-darkk">
            <span class="group-title">
                Konsep Diri
            </span>
            <div class="panel-body">
                <div class="row-fluid">
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'konsepdiri_citratubuh', array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$model, 'attribute'=>'konsepdiri_citratubuh', 'toolbar'=>'mini','height'=>'100px')) ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'konsepdiri_identitas', array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$model, 'attribute'=>'konsepdiri_identitas', 'toolbar'=>'mini','height'=>'100px')) ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'konsepdiri_peran', array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$model, 'attribute'=>'konsepdiri_peran', 'toolbar'=>'mini','height'=>'100px')) ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'konsepdiri_idealdiri', array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$model, 'attribute'=>'konsepdiri_idealdiri', 'toolbar'=>'mini','height'=>'100px')) ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'konsepdiri_hargadiri', array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$model, 'attribute'=>'konsepdiri_hargadiri', 'toolbar'=>'mini','height'=>'100px')) ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($det, 'diagnosakesehatanjiwa_id', array('class'=>'control-label', 'label'=>'Diagnosa Gangguan')); ?>
                            <div class="controls">
                                <div id="panel_diagnosagangguan_hargadiri">
                                    <?php echo $form->checkBoxList($det, 'diagnosakesehatanjiwa_id[diagnosa_gangguan][konsepdiri]', CHtml::listData(DiagnosakesehatanjiwaM::model()->findAllByAttributes(array(
                                        'isaktif'=>true, 'jenisdiagnosa' => 'diagnosa_gangguan', 'kelompokdiagnosa' => 'konsepdiri',
                                    ), array('order'=>'diagnosakesehatanjiwa_id')), 'diagnosakesehatanjiwa_id', 'diagnosakesehatanjiwa_nama'), array('uncheckValue'=>null)); ?>
                                </div>
                                <?php echo CHtml::htmlButton('+ Tambah Diagnosa', array(
                                    'class'=>'btn btn-success', 'onclick'=>"dialogTambahDiagnosa('panel_diagnosagangguan_hargadiri', 'diagnosa_gangguan', 'konsepdiri');"
                                )); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($det, 'diagnosakesehatanjiwa_id', array('class'=>'control-label', 'label'=>'Diagnosa Psikososial')); ?>
                            <div class="controls">
                                <div id="panel_diagnosapsikososial_hargadiri">
                                    <?php echo $form->checkBoxList($det, 'diagnosakesehatanjiwa_id[diagnosa_psikososial][konsepdiri]', CHtml::listData(DiagnosakesehatanjiwaM::model()->findAllByAttributes(array(
                                        'isaktif'=>true, 'jenisdiagnosa' => 'diagnosa_psikososial', 'kelompokdiagnosa' => 'konsepdiri',
                                    ), array('order'=>'diagnosakesehatanjiwa_id')), 'diagnosakesehatanjiwa_id', 'diagnosakesehatanjiwa_nama'), array('uncheckValue'=>null)); ?>
                                </div>
                                <?php echo CHtml::htmlButton('+ Tambah Diagnosa', array(
                                    'class'=>'btn btn-success', 'onclick'=>"dialogTambahDiagnosa('panel_diagnosapsikososial_hargadiri', 'diagnosa_psikososial', 'konsepdiri');"
                                )); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br/>
        <div class="panel panel-darkk">
            <span class="group-title">
                Hubungan Sosial
            </span>
            <div class="panel-body">
                <div class="row-fluid">
                    <div class="col-sm-6">
                        
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'hubsosial_orangterdekat', array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textArea($model, 'hubsosial_orangterdekat', array('row'=>4)) ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'hubsosial_peransertadlmkegiatan', array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$model, 'attribute'=>'hubsosial_peransertadlmkegiatan', 'toolbar'=>'mini','height'=>'100px')) ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'hubsosial_hambatandlmhubdgnoranglain', array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$model, 'attribute'=>'hubsosial_hambatandlmhubdgnoranglain', 'toolbar'=>'mini','height'=>'100px')) ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo $form->labelEx($det, 'diagnosakesehatanjiwa_id', array('class'=>'control-label', 'label'=>'Diagnosa Gangguan')); ?>
                            <div class="controls">
                                <div id="panel_diagnosagangguan_hubsosial">
                                    <?php echo $form->checkBoxList($det, 'diagnosakesehatanjiwa_id[diagnosa_gangguan][hubungan_sosial]', CHtml::listData(DiagnosakesehatanjiwaM::model()->findAllByAttributes(array(
                                        'isaktif'=>true, 'jenisdiagnosa' => 'diagnosa_gangguan', 'kelompokdiagnosa' => 'hubungan_sosial',
                                    ), array('order'=>'diagnosakesehatanjiwa_id')), 'diagnosakesehatanjiwa_id', 'diagnosakesehatanjiwa_nama'), array('uncheckValue'=>null)); ?>
                                </div>
                                <?php echo CHtml::htmlButton('+ Tambah Diagnosa', array(
                                    'class'=>'btn btn-success', 'onclick'=>"dialogTambahDiagnosa('panel_diagnosagangguan_hubsosial', 'diagnosa_gangguan', 'hubungan_sosial');"
                                )); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($det, 'diagnosakesehatanjiwa_id', array('class'=>'control-label', 'label'=>'Diagnosa Psikososial')); ?>
                            <div class="controls">
                                <div id="panel_diagnosapsikososial_hubsosial">
                                    <?php echo $form->checkBoxList($det, 'diagnosakesehatanjiwa_id[diagnosa_psikososial][hubungan_sosial]', CHtml::listData(DiagnosakesehatanjiwaM::model()->findAllByAttributes(array(
                                        'isaktif'=>true, 'jenisdiagnosa' => 'diagnosa_psikososial', 'kelompokdiagnosa' => 'hubungan_sosial',
                                    ), array('order'=>'diagnosakesehatanjiwa_id')), 'diagnosakesehatanjiwa_id', 'diagnosakesehatanjiwa_nama'), array('uncheckValue'=>null)); ?>
                                </div>
                                <?php echo CHtml::htmlButton('+ Tambah Diagnosa', array(
                                    'class'=>'btn btn-success', 'onclick'=>"dialogTambahDiagnosa('panel_diagnosapsikososial_hubsosial', 'diagnosa_psikososial', 'hubungan_sosial');"
                                )); ?>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
        <br/>
        <div class="panel panel-darkk">
            <span class="group-title">
                Spritual
            </span>
            <div class="panel-body">
                <div class="row-fluid">
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'spiritual_nilaikeyakinan', array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$model, 'attribute'=>'spiritual_nilaikeyakinan', 'toolbar'=>'mini','height'=>'100px')) ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'spiritual_kegiatanibadah', array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$model, 'attribute'=>'spiritual_kegiatanibadah', 'toolbar'=>'mini','height'=>'100px')) ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'spiritual_pengaruhterhadapkoping', array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$model, 'attribute'=>'spiritual_pengaruhterhadapkoping', 'toolbar'=>'mini','height'=>'100px')) ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($det, 'diagnosakesehatanjiwa_id', array('class'=>'control-label', 'label'=>'Diagnosa Gangguan')); ?>
                            <div class="controls">
                                <div id="panel_diagnosagangguan_spiritual">
                                    <?php echo $form->checkBoxList($det, 'diagnosakesehatanjiwa_id[diagnosa_gangguan][spiritual]', CHtml::listData(DiagnosakesehatanjiwaM::model()->findAllByAttributes(array(
                                        'isaktif'=>true, 'jenisdiagnosa' => 'diagnosa_gangguan', 'kelompokdiagnosa' => 'spiritual',
                                    ), array('order'=>'diagnosakesehatanjiwa_id')), 'diagnosakesehatanjiwa_id', 'diagnosakesehatanjiwa_nama'), array('uncheckValue'=>null)); ?>
                                </div>
                                <?php echo CHtml::htmlButton('+ Tambah Diagnosa', array(
                                    'class'=>'btn btn-success', 'onclick'=>"dialogTambahDiagnosa('panel_diagnosagangguan_spiritual', 'diagnosa_gangguan', 'spiritual');"
                                )); ?>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>