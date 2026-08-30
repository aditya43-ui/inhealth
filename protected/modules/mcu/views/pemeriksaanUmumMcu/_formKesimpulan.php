<br>
<div class="panel panel-dark">   
        <span class="group-title">
            <b></b>
        </span>
    <div class="panel-body">
        <div class='col-sm-6'>
            <?php echo $form->radioButtonListInlineRow($modpemeriksaanumum, 'kesimpulan_kesehatan', array('Sehat'=>'Sehat','Ada Kelainan'=>'Ada Kelainan'), array('onkeyup'=>"return $(this).focusNextInputField(event)", 'onchange'=>"setNamaDepan()", 'class'=>'')); ?>
            <div class="control-group">
                <?php echo Chtml::label('','',array('class'=>'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($modpemeriksaanumum,'kesimpulan_keterangan',array('class'=>'span3')); ?>
                </div>
            </div>
            <div class="control-group">
            <?php echo Chtml::label('Dugaan Diagnosis','',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo $form->textArea($modpemeriksaanumum,'dugaan_diagnosis',array('class'=>'span3')); ?>
            </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="control-group">
            <?php echo Chtml::label('Terapi','',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo $form->textArea($modpemeriksaanumum,'terapi',array('class'=>'span3')); ?>
            </div>
            </div>
            <div class="control-group">
            <?php echo Chtml::label('Saran','',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo $form->textArea($modpemeriksaanumum,'saran',array('class'=>'span3')); ?>
            </div>
            </div>  
        </div>
    </div>
</div>

