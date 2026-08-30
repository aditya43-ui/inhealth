<div class="row">
    <div class="span12">
            <?php echo CHtml::label('Have you ever had the following disease?', '', array('style' => 'text-align:left;')); ?>
    </div>
    <div class="col-sm-6">
        <div class="control-group heart-disease">
            <?php echo CHtml::label('A. Heart Disease', '', array('class' => 'control-label', 'style' => 'text-align:left;')); ?>
            <div class='controls'>
                <?php echo $form->checkBox($modSuratStudiLuar, 'heartdease_yes', array(($modSuratStudiLuar->heartdease_yes != "") ? ' ' : 'checked' => false, 'class' => 'pilih')); ?> <label>Yes</label> 
                <?php echo $form->checkBox($modSuratStudiLuar, 'heartdease_no', array('class' => '')); ?> <label>No</label>                         
            </div>
        </div>
        <div class="control-group hypertension">
            <?php echo CHtml::label('B. Hypertension', '', array('class' => 'control-label', 'style' => 'text-align:left;')); ?>
            <div class='controls'>
                <?php echo $form->checkBox($modSuratStudiLuar, 'hypertension_yes', array(($modSuratStudiLuar->hypertension_yes != "") ? ' ' : 'checked' => false, 'class' => 'pilih')); ?> <label>Yes</label> 
                <?php echo $form->checkBox($modSuratStudiLuar, 'hypertension_no', array('class' => '')); ?> <label>No</label>                         
            </div>
        </div>
        <div class="control-group lung-disease">
            <?php echo CHtml::label('C. Lung Disease', '', array('class' => 'control-label', 'style' => 'text-align:left;')); ?>
            <div class='controls'>
                <?php echo $form->checkBox($modSuratStudiLuar, 'lungdisease_yes', array(($modSuratStudiLuar->lungdisease_yes != "") ? ' ' : 'checked' => false, 'class' => 'pilih')); ?> <label>Yes</label> 
                <?php echo $form->checkBox($modSuratStudiLuar, 'lungdisease_no', array('class' => '')); ?> <label>No</label>                         
            </div>
        </div>
        <div class="control-group asthma">
            <?php echo CHtml::label('D. Asthma', '', array('class' => 'control-label', 'style' => 'text-align:left;')); ?>
            <div class='controls'>
                <?php echo $form->checkBox($modSuratStudiLuar, 'asthma_yes', array(($modSuratStudiLuar->asthma_yes != "") ? ' ' : 'checked' => false, 'class' => 'pilih')); ?> <label>Yes</label> 
                <?php echo $form->checkBox($modSuratStudiLuar, 'asthma_no', array('class' => '')); ?> <label>No</label>                         
            </div>
        </div>
        <div class="control-group liver-disease">
            <?php echo CHtml::label('E. Liver Disease', '', array('class' => 'control-label', 'style' => 'text-align:left;')); ?>
            <div class='controls'>
                <?php echo $form->checkBox($modSuratStudiLuar, 'liverdisease_yes', array(($modSuratStudiLuar->liverdisease_yes != "") ? ' ' : 'checked' => false, 'class' => 'pilih')); ?> <label>Yes</label> 
                <?php echo $form->checkBox($modSuratStudiLuar, 'liverdisease_no', array('class' => '')); ?> <label>No</label>                         
            </div>
        </div>
        <div class="control-group diabetes">
            <?php echo CHtml::label('F. Diabetes', '', array('class' => 'control-label', 'style' => 'text-align:left;')); ?>
            <div class='controls'>
                <?php echo $form->checkBox($modSuratStudiLuar, 'diabetes_yes', array(($modSuratStudiLuar->diabetes_yes != "") ? ' ' : 'checked' => false, 'class' => 'pilih')); ?> <label>Yes</label> 
                <?php echo $form->checkBox($modSuratStudiLuar, 'diabetes_no', array('class' => '')); ?> <label>No</label>                         
            </div>
        </div>
        <div class="control-group kidney-disease">
            <?php echo CHtml::label('G. Kidney Disease', '', array('class' => 'control-label', 'style' => 'text-align:left;')); ?>
            <div class='controls'>
                <?php echo $form->checkBox($modSuratStudiLuar, 'kidneydisease_yes', array(($modSuratStudiLuar->kidneydisease_yes != "") ? ' ' : 'checked' => false, 'class' => 'pilih')); ?> <label>Yes</label> 
                <?php echo $form->checkBox($modSuratStudiLuar, 'kidneydisease_no', array('class' => '')); ?> <label>No</label>                         
            </div>
        </div>
        <div class="control-group leprosy">
            <?php echo CHtml::label('H. Leprosy', '', array('class' => 'control-label', 'style' => 'text-align:left;')); ?>
            <div class='controls'>
                <?php echo $form->checkBox($modSuratStudiLuar, 'leprosy_yes', array(($modSuratStudiLuar->leprosy_yes != "") ? ' ' : 'checked' => false, 'class' => 'pilih')); ?> <label>Yes</label> 
                <?php echo $form->checkBox($modSuratStudiLuar, 'leprosy_no', array('class' => '')); ?> <label>No</label>                         
            </div>
        </div>
        <div class="control-group sexually">
            <?php echo CHtml::label('I. Sexually Transmitted Infections', '', array('class' => 'control-label', 'style' => 'text-align:left;')); ?>
            <div class='controls'>
                <?php echo $form->checkBox($modSuratStudiLuar, 'sexsuallytransmiedinfection_yes', array(($modSuratStudiLuar->sexsuallytransmiedinfection_yes != "") ? ' ' : 'checked' => false, 'class' => 'pilih')); ?> <label>Yes</label> 
                <?php echo $form->checkBox($modSuratStudiLuar, 'sexsuallytransmiedinfection_no', array('class' => '')); ?> <label>No</label>                         
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group pshychiatric">
            <?php echo CHtml::label('J. Pshychiatric Illness', '', array('class' => 'control-label', 'style' => 'text-align:left;')); ?>
            <div class='controls'>
                <?php echo $form->checkBox($modSuratStudiLuar, 'pyschiatricillnes_yes', array(($modSuratStudiLuar->pyschiatricillnes_yes != "") ? ' ' : 'checked' => false, 'class' => 'pilih')); ?> <label>Yes</label> 
                <?php echo $form->checkBox($modSuratStudiLuar, 'pyschiatricillnes_no', array('class' => '')); ?> <label>No</label>                         
            </div>
        </div>
        <div class="control-group hepatitis">
            <?php echo CHtml::label('K. Hepatitis', '', array('class' => 'control-label', 'style' => 'text-align:left;')); ?>
            <div class='controls'>
                <?php echo $form->checkBox($modSuratStudiLuar, 'hepatitis_yes', array(($modSuratStudiLuar->hepatitis_yes != "") ? ' ' : 'checked' => false, 'class' => 'pilih')); ?> <label>Yes</label> 
                <?php echo $form->checkBox($modSuratStudiLuar, 'hepatitis_no', array('class' => '')); ?> <label>No</label>                         
            </div>
        </div>
        <div class="control-group drug-use">
            <?php echo CHtml::label('L. Drug Use', '', array('class' => 'control-label', 'style' => 'text-align:left;')); ?>
            <div class='controls'>
                <?php echo $form->checkBox($modSuratStudiLuar, 'druguse_yes', array(($modSuratStudiLuar->druguse_yes != "") ? ' ' : 'checked' => false, 'class' => 'pilih')); ?> <label>Yes</label> 
                <?php echo $form->checkBox($modSuratStudiLuar, 'druguse_no', array('class' => '')); ?> <label>No</label>                         
            </div>
        </div>
        <div class="control-group epilepsi">
            <?php echo CHtml::label('M. Epilopsi', '', array('class' => 'control-label', 'style' => 'text-align:left;')); ?>
            <div class='controls'>
                <?php echo $form->checkBox($modSuratStudiLuar, 'epilepsi_yes', array(($modSuratStudiLuar->epilepsi_yes != "") ? ' ' : 'checked' => false, 'class' => 'pilih')); ?> <label>Yes</label> 
                <?php echo $form->checkBox($modSuratStudiLuar, 'epilepsi_no', array('class' => '')); ?> <label>No</label>                         
            </div>
        </div>
        <div class="control-group malaria">
            <?php echo CHtml::label('N. Malaria', '', array('class' => 'control-label', 'style' => 'text-align:left;')); ?>
            <div class='controls'>
                <?php echo $form->checkBox($modSuratStudiLuar, 'malaria_yes', array(($modSuratStudiLuar->malaria_yes != "") ? ' ' : 'checked' => false, 'class' => 'pilih')); ?> <label>Yes</label> 
                <?php echo $form->checkBox($modSuratStudiLuar, 'malaria_no', array('class' => '')); ?> <label>No</label>                         
            </div>
        </div>
        <div class="control-group tubercolosis">
            <?php echo CHtml::label('O. Tubercolosis', '', array('class' => 'control-label', 'style' => 'text-align:left;')); ?>
            <div class='controls'>
                <?php echo $form->checkBox($modSuratStudiLuar, 'tubercolosis_yes', array(($modSuratStudiLuar->tubercolosis_yes != "") ? ' ' : 'checked' => false, 'class' => 'pilih')); ?> <label>Yes</label> 
                <?php echo $form->checkBox($modSuratStudiLuar, 'tubercolosis_no', array('class' => '')); ?> <label>No</label>                         
            </div>
        </div>
        <div class="control-group hiv">
            <?php echo CHtml::label('P. HIV/AIDS', '', array('class' => 'control-label', 'style' => 'text-align:left;')); ?>
            <div class='controls'>
                <?php echo $form->checkBox($modSuratStudiLuar, 'hiv_aids_yes', array(($modSuratStudiLuar->hiv_aids_yes != "") ? ' ' : 'checked' => false, 'class' => 'pilih')); ?> <label>Yes</label> 
                <?php echo $form->checkBox($modSuratStudiLuar, 'hiv_aids_no', array('class' => '')); ?> <label>No</label>                         
            </div>
        </div>
        <div class="control-group dengue">
            <?php echo CHtml::label('Q. Dengue Hemorrhagic Fever', '', array('class' => 'control-label', 'style' => 'text-align:left;')); ?>
            <div class='controls'>
                <?php echo $form->checkBox($modSuratStudiLuar, 'denguehemorrhagicfever_yes', array(($modSuratStudiLuar->denguehemorrhagicfever_yes != "") ? ' ' : 'checked' => false, 'class' => 'pilih')); ?> <label>Yes</label> 
                <?php echo $form->checkBox($modSuratStudiLuar, 'denguehemorrhagicfever_no', array('class' => '')); ?> <label>No</label>                         
            </div>
        </div>
        <div class="control-group others1">
            <?php echo CHtml::label('Others', '', array('class' => 'control-label', 'style' => 'text-align:left;')); ?>
            <div class='controls'>
                 <?php echo $form->checkBox($modSuratStudiLuar, 'otherdisease_yes', array('onclick' => 'ubahKeteranganDisease(this);')); ?> <label>Yes</label>                         
                <?php echo $form->textField($modSuratStudiLuar, 'otherdisease_keterangan', array('class' => 'span3','readonly'=>true)); ?>
            </div>
        </div>
    </div>
</div>