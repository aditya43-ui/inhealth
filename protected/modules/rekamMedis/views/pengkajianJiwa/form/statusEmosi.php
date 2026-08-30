<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Status Mental : Status Emosi & Persepsi</div>
    </div>
    <div class="panel-body">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">Status Emosi</div>
            </div>
            <div class="panel-body">
                <br/>
                <div class="panel panel-darkk">
                    <span class="group-title">
                        Alam Perasaan
                    </span>
                    <div class="panel-body">
                        <div class="row-fluid">
                            <div class="col-sm-6">
                                <?php echo $form->checkBoxListRow($model, 'alamperasaan', LookupM::getItemsUrutan('askepjiwa_alamperasaan'), array('uncheckValue'=>null)); ?>
                                <div class="control-group">
                                    <?php echo $form->labelEx($model, 'pembicaraan_penjelasan', array('class'=>'control-label')); ?>
                                    <div class="controls">
                                        <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$model, 'attribute'=>'pembicaraan_penjelasan', 'toolbar'=>'mini','height'=>'100px')) ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="control-group">
                                    <?php echo $form->labelEx($det, 'diagnosakesehatanjiwa_id', array('class'=>'control-label', 'label'=>'Diagnosa Gangguan')); ?>
                                    <div class="controls">
                                        <div id="panel_diagnosagangguan_alamperasaan">
                                            <?php echo $form->checkBoxList($det, 'diagnosakesehatanjiwa_id[diagnosa_gangguan][alamperasaan]', CHtml::listData(DiagnosakesehatanjiwaM::model()->findAllByAttributes(array(
                                                'isaktif'=>true, 'jenisdiagnosa' => 'diagnosa_gangguan', 'kelompokdiagnosa' => 'alamperasaan',
                                            ), array('order'=>'diagnosakesehatanjiwa_id')), 'diagnosakesehatanjiwa_id', 'diagnosakesehatanjiwa_nama'), array('uncheckValue'=>null)); ?>
                                        </div>
                                        <?php echo CHtml::htmlButton('+ Tambah Diagnosa', array(
                                            'class'=>'btn btn-success', 'onclick'=>"dialogTambahDiagnosa('panel_diagnosagangguan_alamperasaan', 'diagnosa_gangguan', 'alamperasaan');"
                                        )); ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <?php echo $form->labelEx($det, 'diagnosakesehatanjiwa_id', array('class'=>'control-label', 'label'=>'Diagnosa Psikososial')); ?>
                                    <div class="controls">
                                        <div id="panel_diagnosapsikososial_alamperasaan">
                                            <?php echo $form->checkBoxList($det, 'diagnosakesehatanjiwa_id[diagnosa_psikososial][alamperasaan]', CHtml::listData(DiagnosakesehatanjiwaM::model()->findAllByAttributes(array(
                                                'isaktif'=>true, 'jenisdiagnosa' => 'diagnosa_psikososial', 'kelompokdiagnosa' => 'alamperasaan',
                                            ), array('order'=>'diagnosakesehatanjiwa_id')), 'diagnosakesehatanjiwa_id', 'diagnosakesehatanjiwa_nama'), array('uncheckValue'=>null)); ?>
                                        </div>
                                        <?php echo CHtml::htmlButton('+ Tambah Diagnosa', array(
                                            'class'=>'btn btn-success', 'onclick'=>"dialogTambahDiagnosa('panel_diagnosapsikososial_alamperasaan', 'diagnosa_psikososial', 'alamperasaan');"
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
                        Afek
                    </span>
                    <div class="panel-body">
                        <div class="row-fluid">
                            <div class="col-sm-6">
                                <?php echo $form->checkBoxListRow($model, 'afek', LookupM::getItemsUrutan('askepjiwa_afek'), array('uncheckValue'=>null)); ?>
                                <div class="control-group">
                                    <?php echo $form->labelEx($model, 'afek_penjelasan', array('class'=>'control-label')); ?>
                                    <div class="controls">
                                        <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$model, 'attribute'=>'afek_penjelasan', 'toolbar'=>'mini','height'=>'100px')) ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="control-group">
                                    <?php echo $form->labelEx($det, 'diagnosakesehatanjiwa_id', array('class'=>'control-label', 'label'=>'Diagnosa Gangguan')); ?>
                                    <div class="controls">
                                        <div id="panel_diagnosagangguan_afek">
                                            <?php echo $form->checkBoxList($det, 'diagnosakesehatanjiwa_id[diagnosa_gangguan][afek]', CHtml::listData(DiagnosakesehatanjiwaM::model()->findAllByAttributes(array(
                                                'isaktif'=>true, 'jenisdiagnosa' => 'diagnosa_gangguan', 'kelompokdiagnosa' => 'afek',
                                            ), array('order'=>'diagnosakesehatanjiwa_id')), 'diagnosakesehatanjiwa_id', 'diagnosakesehatanjiwa_nama'), array('uncheckValue'=>null)); ?>
                                        </div>
                                        <?php echo CHtml::htmlButton('+ Tambah Diagnosa', array(
                                            'class'=>'btn btn-success', 'onclick'=>"dialogTambahDiagnosa('panel_diagnosagangguan_afek', 'diagnosa_gangguan', 'afek');"
                                        )); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">Persepsi</div>
            </div>
            <div class="panel-body">
                <div class="row-fluid">
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'halusinasi', array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->checkBoxList($model, 'halusinasi', LookupM::getItemsUrutan('askepjiwa_halusinasi')) ?>
                                <div class="control-group">
                                    <?php echo $form->labelEx($model, 'halusinasi_penjelasan', array('class'=>'control-label')); ?>
                                    <div class="controls">
                                        <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$model, 'attribute'=>'halusinasi_penjelasan', 'toolbar'=>'mini','height'=>'100px')) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'ilusi', array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$model, 'attribute'=>'ilusi', 'toolbar'=>'mini','height'=>'100px')) ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'depersonalisasi', array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$model, 'attribute'=>'depersonalisasi', 'toolbar'=>'mini','height'=>'100px')) ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'derelisasi', array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$model, 'attribute'=>'derelisasi', 'toolbar'=>'mini','height'=>'100px')) ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($det, 'diagnosakesehatanjiwa_id', array('class'=>'control-label', 'label'=>'Diagnosa Gangguan')); ?>
                            <div class="controls">
                                <div id="panel_diagnosagangguan_persepsi">
                                    <?php echo $form->checkBoxList($det, 'diagnosakesehatanjiwa_id[diagnosa_gangguan][persepsi]', CHtml::listData(DiagnosakesehatanjiwaM::model()->findAllByAttributes(array(
                                        'isaktif'=>true, 'jenisdiagnosa' => 'diagnosa_gangguan', 'kelompokdiagnosa' => 'persepsi',
                                    ), array('order'=>'diagnosakesehatanjiwa_id')), 'diagnosakesehatanjiwa_id', 'diagnosakesehatanjiwa_nama'), array('uncheckValue'=>null)); ?>
                                </div>
                                <?php echo CHtml::htmlButton('+ Tambah Diagnosa', array(
                                    'class'=>'btn btn-success', 'onclick'=>"dialogTambahDiagnosa('panel_diagnosagangguan_persepsi', 'diagnosa_gangguan', 'persepsi');"
                                )); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>