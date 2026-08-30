<div class="panel panel-dark">   
        <span class="group-title">
            <b></b>
        </span>
    <div class="panel-body">
        <div class="col-sm-12">
            <div class="control-group">
                <?php echo CHtml::label('Hasil Pop Smeer','',array('class'=>'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textArea($modMcuPemeriksaanlainlain,'hasil_pap_smeer',array('class'=>'span7')); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label('Pemeriksaan Mamma','',array('class'=>'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textArea($modMcuPemeriksaanlainlain,'pemeriksaan_mamma',array('class'=>'span7')); ?>
                </div>
            </div>
            <div class="mata">
                    <div class="control-group">
                      <?php echo CHtml::label('Mata','',array('class'=>'control-label')); ?>
                        <div class='controls'>
                        <?php echo $form->checkBox($modMcuPemeriksaanlainlain,'mata_normal',array()); ?> <label>Normal</label> 
                        <?php echo $form->checkBox($modMcuPemeriksaanlainlain,'mata_abnormal',array('class'=>'negatif-kepala')); ?> <label>Abnormal</label>                         
                        
                        <?php echo $form->textField($modMcuPemeriksaanlainlain,'mata_keterangan', array('placeholder'=>'Keterangan','class' => 'span5','readonly'=>false)) ?>
                        </div>
                    </div>
            </div>
            <div class="control-group">
                    <?php echo CHtml::label('Visus Kanan','',array('class'=>'control-label')); ?>
                <div class="controls">
                        <?php echo $form->textField($modMcuPemeriksaanlainlain,'visus_kanan', array('placeholder'=>'','class' => 'span5','readonly'=>false)) ?>
                </div>
            </div>
            <div class="control-group">
                    <?php echo CHtml::label('Visus Kiri','',array('class'=>'control-label')); ?>
                <div class="controls">
                        <?php echo $form->textField($modMcuPemeriksaanlainlain,'visus_kiri', array('placeholder'=>'','class' => 'span5','readonly'=>false)) ?>
                </div>
            </div>
            <div class="control-group">
                    <?php echo CHtml::label('Refraksi','',array('class'=>'control-label')); ?>
                <div class="controls">
                        <?php echo $form->textField($modMcuPemeriksaanlainlain,'refraksi', array('placeholder'=>'','class' => 'span5','readonly'=>false)) ?>
                </div>
            </div>
            <div class="control-group">
                    <?php echo CHtml::label('Tekanan Bola Mata','',array('class'=>'control-label')); ?>
                <div class="controls">
                        <?php echo $form->textField($modMcuPemeriksaanlainlain,'tekanan_bola_mata', array('placeholder'=>'','class' => 'span5','readonly'=>false)) ?>
                </div>
            </div>
            <div class="control-group">
                    <?php echo CHtml::label('Persepsi Warna','',array('class'=>'control-label')); ?>
                <div class="controls">
                        <?php echo $form->textField($modMcuPemeriksaanlainlain,'persepsi_warna', array('placeholder'=>'','class' => 'span5','readonly'=>false)) ?>
                </div>
            </div>
            <div class="control-group">
                    <?php echo CHtml::label('Kacamata Lama','',array('class'=>'control-label')); ?>
                <div class="controls">
                        <?php echo $form->textField($modMcuPemeriksaanlainlain,'kecamata_lama', array('placeholder'=>'','class' => 'span5','readonly'=>false)) ?>
                </div>
            </div>
             <div class="control-group">
                <?php echo CHtml::label('Key','',array('class'=>'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textArea($modMcuPemeriksaanlainlain,'key_lainlain',array('class'=>'span7')); ?>
                </div>
            </div>
             <div class="control-group">
                <?php echo CHtml::label('THT','',array('class'=>'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textArea($modMcuPemeriksaanlainlain,'tht',array('class'=>'span7')); ?>
                </div>
            </div>
        </div>
        
    </div>
</div>