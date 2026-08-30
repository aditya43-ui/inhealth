<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('A. Height', '', array('class' => 'control-label', 'style' => 'text-align:left;')); ?>
            <div class='controls'>
                <?php echo $form->textField($modSuratStudiLuar, 'height', array('class' => 'span2 integer2')); ?> <label>cm</label>                         
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('B. Weight', '', array('class' => 'control-label', 'style' => 'text-align:left;')); ?>
            <div class='controls'>
                <?php echo $form->textField($modSuratStudiLuar, 'weight', array('class' => 'span2 integer2')); ?> <label>kg</label>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('C. Blood Pressure', '', array('class' => 'control-label', 'style' => 'text-align:left;')); ?>
            <div class='controls'>
                <?php echo $form->textField($modSuratStudiLuar, 'diastolic_bloodpressure', array('class' => 'span1 integer2')); ?> <label>/</label>
                <?php echo $form->textField($modSuratStudiLuar, 'sistolic_bloodpressure', array('class' => 'span1 integer2')); ?> <label>mmHg</label>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('D. Pulse', '', array('class' => 'control-label', 'style' => 'text-align:left;')); ?>
            <div class='controls'>
                <?php echo $form->textField($modSuratStudiLuar, 'pulse', array('class' => 'span2 integer2')); ?> <label>mm</label>
            </div>
        </div>
        <div class="control-group skin">
            <?php echo CHtml::label('E. Skin', '', array('class' => 'control-label', 'style' => 'text-align:left;')); ?>
            <div class='controls'>
                <?php echo $form->checkBox($modSuratStudiLuar, 'skin_normal', array(($modSuratStudiLuar->skin_normal != "") ? ' ' : 'checked' => false, 'class' => 'pilih')); ?> <label>Normal</label> 
                <?php echo $form->checkBox($modSuratStudiLuar, 'skin_abnormal', array('class' => '')); ?> <label>Abnormal</label>                         
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('F. Vision', '', array('class' => 'control-label', 'style' => 'text-align:left;')); ?>
            <div class='controls'>
                <?php echo $form->textField($modSuratStudiLuar, 'vision_right', array('class' => 'span1','placeholder'=>'Left')); ?>
                <?php echo $form->textField($modSuratStudiLuar, 'vision_left', array('class' => 'span1','placeholder'=>'Right')); ?>
            </div>
        </div>
        <div class="control-group ears">
            <?php echo CHtml::label('G. Ears', '', array('class' => 'control-label', 'style' => 'text-align:left;')); ?>
            <div class='controls'>
                <?php echo $form->checkBox($modSuratStudiLuar, 'ears_normal', array(($modSuratStudiLuar->ears_normal != "") ? ' ' : 'checked' => false, 'class' => 'pilih')); ?> <label>Normal</label> 
                <?php echo $form->checkBox($modSuratStudiLuar, 'ears_abnormal', array('class' => '')); ?> <label>Abnormal</label>                         
            </div>
        </div>
        <div class="control-group eyes">
            <?php echo CHtml::label('H. Eyes', '', array('class' => 'control-label', 'style' => 'text-align:left;')); ?>
            <div class='controls'>
                <?php echo $form->checkBox($modSuratStudiLuar, 'eyes_normal', array(($modSuratStudiLuar->eyes_normal != "") ? ' ' : 'checked' => false, 'class' => 'pilih')); ?> <label>Normal</label> 
                <?php echo $form->checkBox($modSuratStudiLuar, 'eyes_abnormal', array('class' => '')); ?> <label>Abnormal</label>                         
            </div>
        </div>
        <div class="control-group heart">
            <?php echo CHtml::label('I. Heart', '', array('class' => 'control-label', 'style' => 'text-align:left;')); ?>
            <div class='controls'>
                <?php echo $form->checkBox($modSuratStudiLuar, 'heart_normal', array(($modSuratStudiLuar->heart_normal != "") ? ' ' : 'checked' => false, 'class' => 'pilih')); ?> <label>Normal</label> 
                <?php echo $form->checkBox($modSuratStudiLuar, 'heart_abnormal', array('class' => '')); ?> <label>Abnormal</label>                         
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group lung">
            <?php echo CHtml::label('J. Lung', '', array('class' => 'control-label', 'style' => 'text-align:left;')); ?>
            <div class='controls'>
                <?php echo $form->checkBox($modSuratStudiLuar, 'lungs_normal', array(($modSuratStudiLuar->lungs_normal != "") ? ' ' : 'checked' => false, 'class' => 'pilih')); ?> <label>Normal</label> 
                <?php echo $form->checkBox($modSuratStudiLuar, 'lungs_abnormal', array('class' => '')); ?> <label>Abnormal</label>                         
            </div>
        </div>
        <div class="control-group liver">
            <?php echo CHtml::label('K. Liver', '', array('class' => 'control-label', 'style' => 'text-align:left;')); ?>
            <div class='controls'>
                <?php echo $form->checkBox($modSuratStudiLuar, 'liver_normal', array(($modSuratStudiLuar->liver_normal != "") ? ' ' : 'checked' => false, 'class' => 'pilih')); ?> <label>Normal</label> 
                <?php echo $form->checkBox($modSuratStudiLuar, 'liver_abnormal', array('class' => '')); ?> <label>Abnormal</label>                         
            </div>
        </div>
        <div class="control-group spleen">
            <?php echo CHtml::label('L. Spleen', '', array('class' => 'control-label', 'style' => 'text-align:left;')); ?>
            <div class='controls'>
                <?php echo $form->checkBox($modSuratStudiLuar, 'spleen_normal', array(($modSuratStudiLuar->spleen_normal != "") ? ' ' : 'checked' => false, 'class' => 'pilih')); ?> <label>Normal</label> 
                <?php echo $form->checkBox($modSuratStudiLuar, 'spleen_abnormal', array('class' => '')); ?> <label>Abnormal</label>                         
            </div>
        </div>
        <div class="control-group thyroid">
            <?php echo CHtml::label('M. Thyroid Gland', '', array('class' => 'control-label', 'style' => 'text-align:left;')); ?>
            <div class='controls'>
                <?php echo $form->checkBox($modSuratStudiLuar, 'tyrhoidgland_normal', array(($modSuratStudiLuar->tyrhoidgland_normal != "") ? ' ' : 'checked' => false, 'class' => 'pilih')); ?> <label>Normal</label> 
                <?php echo $form->checkBox($modSuratStudiLuar, 'tyrhoidgland_abnormal', array('class' => '')); ?> <label>Abnormal</label>                         
            </div>
        </div>
        <div class="control-group lymph">
            <?php echo CHtml::label('N. Lymph Abnormaldes', '', array('class' => 'control-label', 'style' => 'text-align:left;')); ?>
            <div class='controls'>
                <?php echo $form->checkBox($modSuratStudiLuar, 'lymphnodes_normal', array(($modSuratStudiLuar->lymphnodes_normal != "") ? ' ' : 'checked' => false, 'class' => 'pilih')); ?> <label>Normal</label> 
                <?php echo $form->checkBox($modSuratStudiLuar, 'lymphnodes_abnormal', array('class' => '')); ?> <label>Abnormal</label>                         
            </div>
        </div>
        <div class="control-group external-genitalia">
            <?php echo CHtml::label('O. External Genitalia', '', array('class' => 'control-label', 'style' => 'text-align:left;')); ?>
            <div class='controls'>
                <?php echo $form->checkBox($modSuratStudiLuar, 'ekternalgenitalia_normal', array(($modSuratStudiLuar->ekternalgenitalia_normal != "") ? ' ' : 'checked' => false, 'class' => 'pilih')); ?> <label>Normal</label> 
                <?php echo $form->checkBox($modSuratStudiLuar, 'ekternalgenitalia_abnormal', array('class' => '')); ?> <label>Abnormal</label>                         
            </div>
        </div>
        <div class="control-group hemia">
            <?php echo CHtml::label('P. Hemia', '', array('class' => 'control-label', 'style' => 'text-align:left;')); ?>
            <div class='controls'>
                <?php echo $form->checkBox($modSuratStudiLuar, 'hemia_normal', array(($modSuratStudiLuar->hemia_normal != "") ? ' ' : 'checked' => false, 'class' => 'pilih')); ?> <label>Normal</label> 
                <?php echo $form->checkBox($modSuratStudiLuar, 'hemia_abnormal', array('class' => '')); ?> <label>Abnormal</label>                         
            </div>
        </div>
        <div class="control-group mental">
            <?php echo CHtml::label('Q. Mental', '', array('class' => 'control-label', 'style' => 'text-align:left;')); ?>
            <div class='controls'>
                <?php echo $form->checkBox($modSuratStudiLuar, 'mental_normal', array(($modSuratStudiLuar->mental_normal != "") ? ' ' : 'checked' => false, 'class' => 'pilih')); ?> <label>Normal</label> 
                <?php echo $form->checkBox($modSuratStudiLuar, 'mental_abnormal', array('class' => '')); ?> <label>Abnormal</label>                         
            </div>
        </div>
        <div class="control-group others2">
            <?php echo CHtml::label('Others', '', array('class' => 'control-label', 'style' => 'text-align:left;')); ?>
            <div class='controls'>
                <?php echo $form->checkBox($modSuratStudiLuar, 'otherphyscal_yes', array('onClick' => 'ubahKeteranganPhisical(this);')); ?> <label>Yes</label>                         
                <?php echo $form->textField($modSuratStudiLuar, 'otherphyscal_keterangan', array('class' => 'span3','readonly'=>true)); ?>
            </div>
        </div>
    </div>
</div>