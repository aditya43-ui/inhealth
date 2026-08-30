<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Status Mental : Deskripsi Umum</div>
    </div>
    <div class="panel-body">
        <br/>
        <div class="panel panel-darkk">
            <span class="group-title">
                Penampilan
            </span>
            <div class="panel-body">
                <div class="row-fluid">
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'caraberpakaian', array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->checkBoxList($model, 'caraberpakaian', LookupM::getItemsUrutan('askepjiwa_caraberpakaian')) ?>
                                <div class="control-group">
                                    <?php echo $form->labelEx($model, 'caraberpakaian_penjelasan', array('class'=>'control-label')); ?>
                                    <div class="controls">
                                        <?php echo $form->textArea($model, 'caraberpakaian_penjelasan', array('row'=>4)) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'caraberjalan_sikaptubuh', array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$model, 'attribute'=>'caraberjalan_sikaptubuh', 'toolbar'=>'mini','height'=>'100px')) ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'kebersihan', array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$model, 'attribute'=>'kebersihan', 'toolbar'=>'mini','height'=>'100px')) ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'ekspresiwajah', array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$model, 'attribute'=>'ekspresiwajah', 'toolbar'=>'mini','height'=>'100px')) ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($det, 'diagnosakesehatanjiwa_id', array('class'=>'control-label', 'label'=>'Diagnosa Gangguan')); ?>
                            <div class="controls">
                                <div id="panel_diagnosagangguan_penampilan">
                                    <?php echo $form->checkBoxList($det, 'diagnosakesehatanjiwa_id[diagnosa_gangguan][penampilan]', CHtml::listData(DiagnosakesehatanjiwaM::model()->findAllByAttributes(array(
                                        'isaktif'=>true, 'jenisdiagnosa' => 'diagnosa_gangguan', 'kelompokdiagnosa' => 'penampilan',
                                    ), array('order'=>'diagnosakesehatanjiwa_id')), 'diagnosakesehatanjiwa_id', 'diagnosakesehatanjiwa_nama'), array('uncheckValue'=>null)); ?>
                                </div>
                                <?php echo CHtml::htmlButton('+ Tambah Diagnosa', array(
                                    'class'=>'btn btn-success', 'onclick'=>"dialogTambahDiagnosa('panel_diagnosagangguan_penampilan', 'diagnosa_gangguan', 'penampilan');"
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
                Pembicaraan
            </span>
            <div class="panel-body">
                <div class="row-fluid">
                    <div class="col-sm-6">
                        <?php echo $form->radioButtonListRow($model, 'pembicaraan_frekuensi', array('Cepat'=>'Cepat', 'Lambat'=>'Lambat'), array('uncheckValue'=>null)); ?>
                        <?php echo $form->radioButtonListRow($model, 'pembicaraan_volume', array('Keras'=>'Keras', 'Lembut'=>'Lembut'), array('uncheckValue'=>null)); ?>
                        <?php echo $form->radioButtonListRow($model, 'pembicaraan_karakteristik', LookupM::getItemsUrutan('askepjiwa_karakteristipembicaraan'), array('uncheckValue'=>null)); ?>
                    </div>
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'pembicaraan_penjelasan', array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$model, 'attribute'=>'pembicaraan_penjelasan', 'toolbar'=>'mini','height'=>'100px')) ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($det, 'diagnosakesehatanjiwa_id', array('class'=>'control-label', 'label'=>'Diagnosa Gangguan')); ?>
                            <div class="controls">
                                <div id="panel_diagnosagangguan_pembicaraan">
                                    <?php echo $form->checkBoxList($det, 'diagnosakesehatanjiwa_id[diagnosa_gangguan][pembicaraan]', CHtml::listData(DiagnosakesehatanjiwaM::model()->findAllByAttributes(array(
                                        'isaktif'=>true, 'jenisdiagnosa' => 'diagnosa_gangguan', 'kelompokdiagnosa' => 'pembicaraan',
                                    ), array('order'=>'diagnosakesehatanjiwa_id')), 'diagnosakesehatanjiwa_id', 'diagnosakesehatanjiwa_nama'), array('uncheckValue'=>null)); ?>
                                </div>
                                <?php echo CHtml::htmlButton('+ Tambah Diagnosa', array(
                                    'class'=>'btn btn-success', 'onclick'=>"dialogTambahDiagnosa('panel_diagnosagangguan_pembicaraan', 'diagnosa_gangguan', 'pembicaraan');"
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
                Aktivitas Motorik
            </span>
            <div class="panel-body">
                <div class="row-fluid">
                    <div class="col-sm-6">
                        <?php echo $form->radioButtonListRow($model, 'tingkataktivitas', LookupM::getItemsUrutan('askepjiwa_tingkataktivitas'), array('uncheckValue'=>null)); ?>
                        <?php echo $form->checkBoxListRow($model, 'jenisaktivitas', LookupM::getItemsUrutan('askepjiwa_jenisaktivitas'), array('uncheckValue'=>null)); ?>
                        <?php echo $form->radioButtonListRow($model, 'isyarattubuh', LookupM::getItemsUrutan('askepjiwa_isyarattubuh'), array('uncheckValue'=>null)); ?>
                    </div>
                    <div class="col-sm-6">
                        <?php echo $form->checkBoxListRow($model, 'interaksiselama_wawancara', LookupM::getItemsUrutan('askepjiwa_interaksiselamawawancara'), array('uncheckValue'=>null)); ?>
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'aktivitasmotorik_penjelasan', array('class'=>'control-label', 'label'=>'Jelaskan')); ?>
                            <div class="controls">
                                <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$model, 'attribute'=>'aktivitasmotorik_penjelasan', 'toolbar'=>'mini','height'=>'100px')) ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($det, 'diagnosakesehatanjiwa_id', array('class'=>'control-label', 'label'=>'Diagnosa Gangguan')); ?>
                            <div class="controls">
                                <div id="panel_diagnosagangguan_motorik">
                                    <?php echo $form->checkBoxList($det, 'diagnosakesehatanjiwa_id[diagnosa_gangguan][aktivitas_motorik]', CHtml::listData(DiagnosakesehatanjiwaM::model()->findAllByAttributes(array(
                                        'isaktif'=>true, 'jenisdiagnosa' => 'diagnosa_gangguan', 'kelompokdiagnosa' => 'aktivitas_motorik',
                                    ), array('order'=>'diagnosakesehatanjiwa_id')), 'diagnosakesehatanjiwa_id', 'diagnosakesehatanjiwa_nama'), array('uncheckValue'=>null)); ?>
                                </div>
                                <?php echo CHtml::htmlButton('+ Tambah Diagnosa', array(
                                    'class'=>'btn btn-success', 'onclick'=>"dialogTambahDiagnosa('panel_diagnosagangguan_motorik', 'diagnosa_gangguan', 'aktivitas_motorik');"
                                )); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($det, 'diagnosakesehatanjiwa_id', array('class'=>'control-label', 'label'=>'Diagnosa Psikososial')); ?>
                            <div class="controls">
                                <div id="panel_diagnosapsikososial_motorik">
                                    <?php echo $form->checkBoxList($det, 'diagnosakesehatanjiwa_id[diagnosa_psikososial][aktivitas_motorik]', CHtml::listData(DiagnosakesehatanjiwaM::model()->findAllByAttributes(array(
                                        'isaktif'=>true, 'jenisdiagnosa' => 'diagnosa_psikososial', 'kelompokdiagnosa' => 'aktivitas_motorik',
                                    ), array('order'=>'diagnosakesehatanjiwa_id')), 'diagnosakesehatanjiwa_id', 'diagnosakesehatanjiwa_nama'), array('uncheckValue'=>null)); ?>
                                </div>
                                <?php echo CHtml::htmlButton('+ Tambah Diagnosa', array(
                                    'class'=>'btn btn-success', 'onclick'=>"dialogTambahDiagnosa('panel_diagnosapsikososial_motorik', 'diagnosa_psikososial', 'aktivitas_motorik');"
                                )); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>