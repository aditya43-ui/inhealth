<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Status Mental : Proses Pikir dan Sensori & Kognisi</div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">Proses Pikir</div>
            </div>
            <div class="panel-body">
                <div class="row-fliud">
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'bentukpikir', array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->checkBoxList($model, 'bentukpikir', LookupM::getItemsUrutan('askepjiwa_bentukpikir')) ?>
                                <div class="control-group">
                                    <?php echo $form->labelEx($model, 'bentukpikir_jelaskan', array('class'=>'control-label')); ?>
                                    <div class="controls">
                                        <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$model, 'attribute'=>'bentukpikir_jelaskan', 'toolbar'=>'mini','height'=>'100px')) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'aruspikir', array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->checkBoxList($model, 'aruspikir', LookupM::getItemsUrutan('askepjiwa_aruspikir')) ?>
                                <div class="control-group">
                                    <?php echo $form->labelEx($model, 'aruspikir_jelaskan', array('class'=>'control-label')); ?>
                                    <div class="controls">
                                        <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$model, 'attribute'=>'aruspikir_jelaskan', 'toolbar'=>'mini','height'=>'100px')) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'isipikir', array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->checkBoxList($model, 'isipikir', LookupM::getItemsUrutan('askepjiwa_isipikir')) ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'waham', array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->checkBoxList($model, 'waham', LookupM::getItemsUrutan('askepjiwa_waham')) ?>
                                <div class="control-group">
                                    <?php echo $form->labelEx($model, 'waham_penjelasan', array('class'=>'control-label')); ?>
                                    <div class="controls">
                                        <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$model, 'attribute'=>'waham_penjelasan', 'toolbar'=>'mini','height'=>'100px')) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($det, 'diagnosakesehatanjiwa_id', array('class'=>'control-label', 'label'=>'Diagnosa Gangguan')); ?>
                            <div class="controls">
                                <div id="panel_diagnosagangguan_prosespikir">
                                    <?php echo $form->checkBoxList($det, 'diagnosakesehatanjiwa_id[diagnosa_gangguan][prosespikir]', CHtml::listData(DiagnosakesehatanjiwaM::model()->findAllByAttributes(array(
                                        'isaktif'=>true, 'jenisdiagnosa' => 'diagnosa_gangguan', 'kelompokdiagnosa' => 'prosespikir',
                                    ), array('order'=>'diagnosakesehatanjiwa_id')), 'diagnosakesehatanjiwa_id', 'diagnosakesehatanjiwa_nama'), array('uncheckValue'=>null)); ?>
                                </div>
                                <?php echo CHtml::htmlButton('+ Tambah Diagnosa', array(
                                    'class'=>'btn btn-success', 'onclick'=>"dialogTambahDiagnosa('panel_diagnosagangguan_prosespikir', 'diagnosa_gangguan', 'prosespikir');"
                                )); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">Sensori dan Kognisi</div>
            </div>
            <div class="panel-body">
                <div class="row-fliud">
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'tingkatkesaradaran', array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->checkBoxList($model, 'tingkatkesaradaran', LookupM::getItemsUrutan('askepjiwa_tingkatkesadaran')) ?>
                                <div class="control-group">
                                    <?php echo $form->labelEx($model, 'tingakkesadaran_penjelasan', array('class'=>'control-label')); ?>
                                    <div class="controls">
                                        <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$model, 'attribute'=>'tingakkesadaran_penjelasan', 'toolbar'=>'mini','height'=>'100px')) ?>
                                    </div>
                                </div>
                            </div>
                        </div><div class="control-group">
                            <?php echo $form->labelEx($model, 'dayaingat', array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->checkBoxList($model, 'dayaingat', LookupM::getItemsUrutan('askepjiwa_dayaingat')) ?>
                                <div class="control-group">
                                    <?php echo $form->labelEx($model, 'dayaingat_penjelasan', array('class'=>'control-label')); ?>
                                    <div class="controls">
                                        <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$model, 'attribute'=>'dayaingat_penjelasan', 'toolbar'=>'mini','height'=>'100px')) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'konsentasidanhitung', array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->checkBoxList($model, 'konsentasidanhitung', LookupM::getItemsUrutan('askepjiwa_konsentrasihitung')) ?>
                                <div class="control-group">
                                    <?php echo $form->labelEx($model, 'konsentasidanhitung_penjelasan', array('class'=>'control-label')); ?>
                                    <div class="controls">
                                        <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$model, 'attribute'=>'konsentasidanhitung_penjelasan', 'toolbar'=>'mini','height'=>'100px')) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'insight', array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->checkBoxList($model, 'insight', array(
                                    'Menerima Sakitnya' => 'Menerima Sakitnya',
                                    'Mengingkari gangguan penyakit yang dideritanya' => 'Mengingkari gangguan penyakit yang dideritanya',
                                    'Menyalahkan hal-hal luar lainnya' => 'Menyalahkan hal-hal luar lainnya',
                                ), array('uncheckValue'=>null)) ?>
                                <div class="control-group">
                                    <?php echo $form->labelEx($model, 'insgiht_penjelasan', array('class'=>'control-label')); ?>
                                    <div class="controls">
                                        <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$model, 'attribute'=>'insgiht_penjelasan', 'toolbar'=>'mini','height'=>'100px')) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'pengambilankeputusan', array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$model, 'attribute'=>'pengambilankeputusan', 'toolbar'=>'mini','height'=>'100px')) ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($det, 'diagnosakesehatanjiwa_id', array('class'=>'control-label', 'label'=>'Diagnosa Gangguan')); ?>
                            <div class="controls">
                                <div id="panel_diagnosagangguan_sensorikognisi">
                                    <?php echo $form->checkBoxList($det, 'diagnosakesehatanjiwa_id[diagnosa_gangguan][sensorikognisi]', CHtml::listData(DiagnosakesehatanjiwaM::model()->findAllByAttributes(array(
                                        'isaktif'=>true, 'jenisdiagnosa' => 'diagnosa_gangguan', 'kelompokdiagnosa' => 'sensorikognisi',
                                    ), array('order'=>'diagnosakesehatanjiwa_id')), 'diagnosakesehatanjiwa_id', 'diagnosakesehatanjiwa_nama'), array('uncheckValue'=>null)); ?>
                                </div>
                                <?php echo CHtml::htmlButton('+ Tambah Diagnosa', array(
                                    'class'=>'btn btn-success', 'onclick'=>"dialogTambahDiagnosa('panel_diagnosagangguan_sensorikognisi', 'diagnosa_gangguan', 'sensorikognisi');"
                                )); ?>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>