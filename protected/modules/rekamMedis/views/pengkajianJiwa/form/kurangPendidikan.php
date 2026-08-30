<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Kurangnya Pendidikan & Aspek Medis</div>
    </div>
    <div class="panel-body">
        <br/>
        <div class="panel panel-darkk">
            <span class="group-title">
                Kurangnya Pendidikan
            </span>
            <div class="panel-body">
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'kurangnyapendidikan', array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->checkBoxList($model, 'kurangnyapendidikan', LookupM::getItemsUrutan('askepjiwa_kurangnyapendidikan'), array('uncheckValue'=>null)) ?>
                    </div>
                </div>
            </div>
        </div>
        <br/>
        <div class="panel panel-darkk">
            <span class="group-title">
                Aspek Medis
            </span>
            <div class="panel-body">
                <div class="row-fluid">
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'diagnosamedik', array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$model, 'attribute'=>'diagnosamedik', 'toolbar'=>'mini','height'=>'100px')) ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'terapimedik', array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$model, 'attribute'=>'terapimedik', 'toolbar'=>'mini','height'=>'100px')) ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'riwayat_penggunaanobat', array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$model, 'attribute'=>'riwayat_penggunaanobat', 'toolbar'=>'mini','height'=>'100px')) ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'hasilperiksa_lab', array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$model, 'attribute'=>'hasilperiksa_lab', 'toolbar'=>'mini','height'=>'100px')) ?>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
