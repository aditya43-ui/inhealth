<div class="row">
    <div class="col-sm-6">
        <div class="control-group serological-hiv">
            <?php echo CHtml::label('A. Serological Test for HIV', '', array('class' => 'control-label', 'style' => 'text-align:left;')); ?>
            <div class='controls'>
                <?php echo $form->checkBox($modSuratStudiLuar, 'serologicalhiv_positive', array(($modSuratStudiLuar->serologicalhiv_positive != "") ? ' ' : 'checked' => false, 'class' => 'pilih')); ?> <label>Positive</label> 
                <?php echo $form->checkBox($modSuratStudiLuar, 'serologicalhiv_negative', array('class' => '')); ?> <label>Negative</label>
                
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('B. Serological Test for Shyphilis', '', array('class' => 'control-label', 'style' => 'text-align:left;')); ?>
            <div class='controls'>
                <span class="serological-sifilis">
                    <?php echo $form->checkBox($modSuratStudiLuar, 'serologicalsyphilis_positive', array(($modSuratStudiLuar->serologicalsyphilis_positive != "") ? ' ' : 'checked' => false, 'class' => 'pilih')); ?> <label>Positive</label> 
                    <?php echo $form->checkBox($modSuratStudiLuar, 'serologicalsyphilis_negative', array('class' => '')); ?> <label>Negative</label>                         
                </span>
                &emsp;/&emsp;
                <span class="vdrl-tpha">
                    <?php echo $form->checkBox($modSuratStudiLuar, 'serologicalsyphilis_vdrl', array(($modSuratStudiLuar->serologicalsyphilis_vdrl != "") ? ' ' : 'checked' => false, 'class' => 'pilih')); ?> <label>VDRL</label> 
                    <?php echo $form->checkBox($modSuratStudiLuar, 'serologicalsyphilis_tpha', array('class' => '')); ?> <label>TPHA</label>
                </span>
            
            </div>
        </div>
        <div class="control-group hepatitis-b">
            <?php echo CHtml::label('C. Hepatitis B Surface Antingen Test', '', array('class' => 'control-label', 'style' => 'text-align:left;')); ?>
            <div class='controls'>
                <?php echo $form->checkBox($modSuratStudiLuar, 'hepatitis_b_positive', array(($modSuratStudiLuar->hepatitis_b_positive != "") ? ' ' : 'checked' => false, 'class' => 'pilih')); ?> <label>Positive</label> 
                <?php echo $form->checkBox($modSuratStudiLuar, 'hepatitis_b_negative', array('class' => '')); ?> <label>Negative</label>                         
                
            </div>
        </div>
        <div class="control-group blood-malaria">
            <?php echo CHtml::label('D. Blood Film for Malaria', '', array('class' => 'control-label', 'style' => 'text-align:left;')); ?>
            <div class='controls'>
                <?php echo $form->checkBox($modSuratStudiLuar, 'blood_malaria_positive', array(($modSuratStudiLuar->blood_malaria_positive != "") ? ' ' : 'checked' => false, 'class' => 'pilih' , 'onClick' => 'ubahBloodMalaria(this);')); ?> <label>Positive</label> 
                <?php echo $form->checkBox($modSuratStudiLuar, 'blood_malaria_negative', array('class' => '')); ?> <label>Negative</label>                         
                <br>
                <?php echo $form->textField($modSuratStudiLuar, 'blood_malaria_species', array('class' => 'span3','readonly'=>true)); ?>
            </div>
        </div>
        <div class="control-group chest-xray">
            <?php echo CHtml::label('E. Chest X-Ray for Tuberculosis', '', array('class' => 'control-label', 'style' => 'text-align:left;')); ?>
            <div class='controls'>
                <?php echo $form->checkBox($modSuratStudiLuar, 'tuberculosis_positive', array(($modSuratStudiLuar->tuberculosis_positive != "") ? ' ' : 'checked' => false, 'class' => 'pilih')); ?> <label>Normal</label> 
                <?php echo $form->checkBox($modSuratStudiLuar, 'tuberculosis_negative', array('class' => '')); ?> <label>Abnormal</label>                         
            </div>
        </div>
        <div class="control-group stool-parasites">
            <?php echo CHtml::label('F. Stool Examination for Parasites', '', array('class' => 'control-label', 'style' => 'text-align:left;')); ?>
            <div class='controls'>
                <?php echo $form->checkBox($modSuratStudiLuar, 'stool_parasites_positive', array(($modSuratStudiLuar->stool_parasites_positive != "") ? ' ' : 'checked' => false, 'class' => 'pilih', 'onClick' => 'ubahStoolParasites(this);')); ?> <label>Positive</label> 
                <?php echo $form->checkBox($modSuratStudiLuar, 'stool_parasites_negative', array('class' => '')); ?> <label>Negative</label>                         
                <br>
                <?php echo $form->textField($modSuratStudiLuar, 'stool_parasites_species', array('class' => 'span3','readonly'=>true)); ?>
            </div>
        </div>
        <div class="control-group haematology">
            <?php echo CHtml::label('G. Haematology Test', '', array('class' => 'control-label', 'style' => 'text-align:left;')); ?>
            <div class='controls'>
                <?php echo $form->checkBox($modSuratStudiLuar, 'haematology_normal', array(($modSuratStudiLuar->haematology_normal != "") ? ' ' : 'checked' => false, 'class' => 'pilih')); ?> <label>Normal</label> 
                <?php echo $form->checkBox($modSuratStudiLuar, 'haematology_abnormal', array('class' => '')); ?> <label>Abnormal</label>                         
            </div>
        </div>
        <div class="control-group urinalysis">
            <?php echo CHtml::label('H. Urinalysis Test', '', array('class' => 'control-label', 'style' => 'text-align:left;')); ?>
            <div class='controls'>
                <?php echo $form->checkBox($modSuratStudiLuar, 'urinalysis_normal', array(($modSuratStudiLuar->urinalysis_normal != "") ? ' ' : 'checked' => false, 'class' => 'pilih')); ?> <label>Normal</label> 
                <?php echo $form->checkBox($modSuratStudiLuar, 'urinalysis_abnormal', array('class' => '')); ?> <label>Abnormal</label>                         
            </div>
        </div>
        <div class="control-group pregnancy">
            <?php echo CHtml::label('I. Pregnancy Test', '', array('class' => 'control-label', 'style' => 'text-align:left;')); ?>
            <div class='controls'>
                <?php echo $form->checkBox($modSuratStudiLuar, 'pregnancy_positive', array(($modSuratStudiLuar->pregnancy_positive != "") ? ' ' : 'checked' => false, 'class' => 'pilih')); ?> <label>Positive</label> 
                <?php echo $form->checkBox($modSuratStudiLuar, 'pregnancy_negative', array('class' => '')); ?> <label>Negative</label>                         
            </div>
        </div>
        <div class="control-group amphetamine">
            <?php echo CHtml::label('J. Urine Test for Amphetamine', '', array('class' => 'control-label', 'style' => 'text-align:left;')); ?>
            <div class='controls'>
                <?php echo $form->checkBox($modSuratStudiLuar, 'urinetest_amphetamine_positive', array(($modSuratStudiLuar->urinetest_amphetamine_positive != "") ? ' ' : 'checked' => false, 'class' => 'pilih')); ?> <label>Positive</label> 
                <?php echo $form->checkBox($modSuratStudiLuar, 'urinetest_amphetamine_negative', array('class' => '')); ?> <label>Negative</label>                         
            </div>
        </div>
        <div class="control-group morphine">
            <?php echo CHtml::label('K. Urine Test for Morphine', '', array('class' => 'control-label', 'style' => 'text-align:left;')); ?>
            <div class='controls'>
                <?php echo $form->checkBox($modSuratStudiLuar, 'urinetest_morphine_positive', array(($modSuratStudiLuar->urinetest_morphine_positive != "") ? ' ' : 'checked' => false, 'class' => 'pilih')); ?> <label>Positive</label> 
                <?php echo $form->checkBox($modSuratStudiLuar, 'urinetest_morphine_negative', array('class' => '')); ?> <label>Negative</label>                         
            </div>
        </div>
        <div class="control-group mariyuana">
            <?php echo CHtml::label('L. Mariyuana', '', array('class' => 'control-label', 'style' => 'text-align:left;')); ?>
            <div class='controls'>
                <?php echo $form->checkBox($modSuratStudiLuar, 'mariyuana_positive', array(($modSuratStudiLuar->mariyuana_positive != "") ? ' ' : 'checked' => false, 'class' => 'pilih')); ?> <label>Positive</label> 
                <?php echo $form->checkBox($modSuratStudiLuar, 'mariyuana_negative', array('class' => '')); ?> <label>Negative</label>                         
            </div>
        </div>
    </div>
    <div class="col-sm-6">
    </div>
</div>