<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Masalah Psikososial dan Lingkungan</div>
    </div>
    <div class="panel-body">
        <div class="row-fluid">
            <div class="col-sm-6">
                <div class="panel_psiko">
                    <div class="checkbox">
                        <?php echo $form->checkBox($model, 'masalahdlm_dukungankelompok', array('uncheckValue'=>null)); ?>
                        <label>Masalah dengan dukungan kelompok</label>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($model, 'masalahdlm_dukungankelompokket', array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$model, 'attribute'=>'masalahdlm_dukungankelompokket', 'toolbar'=>'mini','height'=>'100px')) ?>
                        </div>
                    </div>
                </div>
                <div class="panel_psiko">
                    <div class="checkbox">
                        <?php echo $form->checkBox($model, 'masalahhub_dengankelompok', array('uncheckValue'=>null)); ?>
                        <label>Masalah hubungan dengan lingkungan</label>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($model, 'masalahhub_dengankelompokket', array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$model, 'attribute'=>'masalahhub_dengankelompokket', 'toolbar'=>'mini','height'=>'100px')) ?>
                        </div>
                    </div>
                </div>
                <div class="panel_psiko">
                    <div class="checkbox">
                        <?php echo $form->checkBox($model, 'masalahdgn_pendidikan', array('uncheckValue'=>null)); ?>
                        <label>Masalah dengan pendidikan</label>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($model, 'masalahdgn_pendidikanket', array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$model, 'attribute'=>'masalahdgn_pendidikanket', 'toolbar'=>'mini','height'=>'100px')) ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="panel_psiko">
                    <div class="checkbox">
                        <?php echo $form->checkBox($model, 'masalahdgn_pekerjaan', array('uncheckValue'=>null)); ?>
                        <label>Masalah dengan pekerjaan</label>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($model, 'masalahdgn_pekerjaanket', array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$model, 'attribute'=>'masalahdgn_pekerjaanket', 'toolbar'=>'mini','height'=>'100px')) ?>
                        </div>
                    </div>
                </div>
                <div class="panel_psiko">
                    <div class="checkbox">
                        <?php echo $form->checkBox($model, 'masalahdgn_perumahan', array('uncheckValue'=>null)); ?>
                        <label>Masalah dengan perumahan</label>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($model, 'masalahdgn_perumahanket', array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php $this->widget('ext.redactorjs.Redactor',array('model'=>$model, 'attribute'=>'masalahdgn_perumahanket', 'toolbar'=>'mini','height'=>'100px')) ?>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>