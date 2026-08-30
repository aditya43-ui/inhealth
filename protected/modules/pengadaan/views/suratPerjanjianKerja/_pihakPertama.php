<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title"> <b> Pihak Pertama</b></div>
    </div>
    <div class="panel-body">
        <div class="col-sm-6">
            <div class="control-group ">
                <?php echo $form->labelEx($model, 'no_putusanpenggunaanggaran', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'no_putusanpenggunaanggaran', array(
                    'readonly'=>true, 
                    'class'=>'span3',
                    'onblur'=>'return false;',
                    )); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo $form->labelEx($model, 'tglputusanpenggunaanggaran', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'tglputusanpenggunaanggaran', array(
                    'readonly'=>true, 
                    'class'=>'span3',
                    'onblur'=>'return false;',
                    )); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo $form->labelEx($model, 'namapembuatkomitmen', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->hiddenField($model, 'pejabatpembuatkomitmen_id', array(
                    'readonly'=>true, 
                    'class'=>'span3',
                    'onblur'=>'return false;',
                    )); ?>
                    <?php echo $form->textField($model, 'namapembuatkomitmen', array(
                    'readonly'=>true, 
                    'class'=>'span3',
                    'onblur'=>'return false;',
                    )); ?>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="control-group ">
                <?php echo $form->labelEx($model, 'noindukpegawai', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'noindukpegawai', array(
                    'readonly'=>true, 
                    'class'=>'span3',
                    'onblur'=>'return false;',
                    )); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo $form->labelEx($model, 'jabatan', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'jabatan', array(
                    'readonly'=>true, 
                    'class'=>'span3',
                    'onblur'=>'return false;',
                    )); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo $form->labelEx($model, 'alamat', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'alamat', array(
                    'readonly'=>true, 
                    'class'=>'span3',
                    'onblur'=>'return false;',
                    )); ?>
                </div>
            </div>
        </div>
        <div class="clear"></div>
    </div>
</div>
