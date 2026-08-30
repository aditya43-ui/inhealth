<br>
<style type="text/css">
    .simbol-plus {
        font-size: 20px;
    }
    
</style>
<div class="panel panel-dark">   
        <span class="group-title">
            <b>Pemeriksaan Laboratorium</b>
        </span>
    <div class="panel-body">
        <div class='col-sm-6'>
            <div class="control-group">
            <?php echo Chtml::label('BILL D','',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($modpemeriksaanumum,'bill_d',array('class'=>'span3 float2')); ?>
            </div>
            </div>
             <div class="control-group">
            <?php echo Chtml::label('BILL T','',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($modpemeriksaanumum,'bill_t',array('class'=>'span3 float2')); ?>
            </div>
            </div>
             <div class="control-group">
            <?php echo Chtml::label('LDL','',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($modpemeriksaanumum,'ldl',array('class'=>'span3 float2')); ?>
            </div>
            </div>
             <div class="control-group">
            <?php echo Chtml::label('Hb','',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($modpemeriksaanumum,'hb',array('class'=>'span3 float2')); ?>
                <label>g%</label>
            </div>
            </div>
             <div class="control-group">
            <?php echo Chtml::label('Lekosit','',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($modpemeriksaanumum,'lekosit',array('class'=>'span3 numbers-only')); ?>
                <label>/mm<sup>3</sup></label>
            </div>
            </div>
             <div class="control-group">
            <?php echo Chtml::label('Hitung Jenis','',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($modpemeriksaanumum,'hitungjenis_eo',array('placeholder'=>'eo','class'=>'span3 float2')); ?>
            </div>
            </div>
             <div class="control-group">
            <?php echo Chtml::label('','',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($modpemeriksaanumum,'hitungjenis_ba',array('placeholder'=>'ba','class'=>'span3 float2')); ?>
            </div>
            </div>
             <div class="control-group">
            <?php echo Chtml::label('','',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($modpemeriksaanumum,'hitungjenis_st',array('placeholder'=>'st','class'=>'span3 float2')); ?>
            </div>
            </div>
             <div class="control-group">
            <?php echo Chtml::label('','',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($modpemeriksaanumum,'hitungjenis_sgm',array('placeholder'=>'sgm','class'=>'span3 float2')); ?>
            </div>
            </div>
             <div class="control-group">
            <?php echo Chtml::label('','',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($modpemeriksaanumum,'hitungjenis_ly',array('placeholder'=>'ly','class'=>'span3 float2')); ?>
            </div>
            </div>
             <div class="control-group">
            <?php echo Chtml::label('','',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($modpemeriksaanumum,'hitungjenis_h',array('placeholder'=>'h','class'=>'span3 float2')); ?>
            </div>
            </div>
             <div class="control-group">
            <?php echo Chtml::label('BSN','',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($modpemeriksaanumum,'bsn',array('class'=>'span3 numbers-only')); ?>
            <label>mg%</label>
            </div>
            </div>
             <div class="control-group">
            <?php echo Chtml::label('2J PP','',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($modpemeriksaanumum,'dua_jpp',array('class'=>'span3 numbers-only')); ?>
            <label>mg%</label>
            </div>
            </div>
             <div class="control-group">
            <?php echo Chtml::label('Kolestrol Total','',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($modpemeriksaanumum,'kolesterol_total',array('class'=>'span3 numbers-only')); ?>
            <label>mg%</label>
            </div>
            </div>
             <div class="control-group">
            <?php echo Chtml::label('SGOT','',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($modpemeriksaanumum,'sgot',array('class'=>'span3 numbers-only')); ?>
            <label>S FU</label>
            </div>
            </div>
            <div class="control-group">
            <?php echo Chtml::label('SGPT','',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($modpemeriksaanumum,'sgpt',array('class'=>'span3 numbers-only')); ?>
            <label>S FU</label>
            </div>
            </div>
           
        </div>
        
        <div class='col-sm-6'>
            <div class="control-group">
            <?php echo Chtml::label('ALK','',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($modpemeriksaanumum,'alk',array('class'=>'span3 float2')); ?>
            </div>
            </div>
             <div class="control-group">
            <?php echo Chtml::label('HDL','',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($modpemeriksaanumum,'hdl',array('class'=>'span3 float2')); ?>
            </div>
            </div>
             <div class="control-group">
            <?php echo Chtml::label('LED','',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($modpemeriksaanumum,'led',array('class'=>'span3')); ?>
            </div>
            </div>
            <div class="control-group">
            <?php echo Chtml::label('Golongan Darah','',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($modpemeriksaanumum,'golongandarah', LookupM::getItems('golongandarah'),array('empty'=>'-- Pilih --')) ?>
            </div>
            </div>
            <div class="urine">
                    <div class="control-group">
                      <?php echo CHtml::label('Urine','',array('class'=>'control-label')); ?>
                        <div class='controls'>
                        <?php echo $form->checkBox($modpemeriksaanumum,'urine_normal',array()); ?> <label>Normal</label> 
                        <?php echo $form->checkBox($modpemeriksaanumum,'urine_abnormal',array('class'=>'negatif-urine')); ?> <label>Abnormal</label>                         
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('','',array('class'=>'control-label')); ?>
                        <div class='controls'>
                        <?php echo $form->textField($modpemeriksaanumum,'urine_keterangan', array('placeholder'=>'Penyebab','class' => 'span3','readonly'=>false)) ?>
                        </div>
                    </div>
            </div>
            <div class="foses">
                    <div class="control-group">
                      <?php echo CHtml::label('Foses','',array('class'=>'control-label')); ?>
                        <div class='controls'>
                        <?php echo $form->checkBox($modpemeriksaanumum,'foses_normal',array()); ?> <label>Normal</label> 
                        <?php echo $form->checkBox($modpemeriksaanumum,'foses_abnormal',array('class'=>'negatif-foses')); ?> <label>Abnormal</label>                         
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('','',array('class'=>'control-label')); ?>
                        <div class='controls'>
                        <?php echo $form->textField($modpemeriksaanumum,'foses_keterangan', array('placeholder'=>'Penyebab','class' => 'span3','readonly'=>false)) ?>
                        </div>
                    </div>
            </div>
             <div class="control-group">
            <?php echo Chtml::label('Triglisarida','',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($modpemeriksaanumum,'triglisarida',array('class'=>'span3 numbers-only')); ?>
             <label>mg%</label>
            </div>
            </div>
             <div class="control-group">
            <?php echo Chtml::label('BUN','',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($modpemeriksaanumum,'bun',array('class'=>'span3 numbers-only')); ?>
            <label>mg%</label>
            </div>
            </div>
            <div class="control-group">
            <?php echo Chtml::label('Kreatinin','',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($modpemeriksaanumum,'kreatinin',array('class'=>'span3 numbers-only')); ?>
            <label>mg%</label>
            </div>
            </div>
            <div class="control-group">
            <?php echo Chtml::label('Asam Urat','',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($modpemeriksaanumum,'asamurat',array('class'=>'span3 numbers-only')); ?>
            <label>mg%</label>
            </div>
            </div>
            <div class="hbeag">
                <div class="control-group">
                      <?php echo CHtml::label('HbeAg','',array('class'=>'control-label')); ?>
                    <div class='controls'>
                        <?php echo $form->checkBox($modpemeriksaanumum,'hbeag_positif',array()); ?> <label><B class='simbol-plus'>+</B></label> 
                    </div>
                    <div class='controls'>
                         <?php echo $form->checkBox($modpemeriksaanumum,'hbeag_negatif',array('class'=>'negatif-hbeag')); ?> <label><B class='simbol-plus'>-</B></label>
                    </div>
                </div>
            </div>
            <div class="anti-hbe">
                <div class="control-group">
                      <?php echo CHtml::label('Anti Hbe','',array('class'=>'control-label')); ?>
                    <div class='controls'>
                        <?php echo $form->checkBox($modpemeriksaanumum,'antihbe_positif',array()); ?> <label><B class='simbol-plus'>+</B></label> 
                    </div>
                    <div class='controls'>
                         <?php echo $form->checkBox($modpemeriksaanumum,'antihbe_negatif',array('class'=>'negatif-anti-hbe')); ?> <label><B class='simbol-plus'>-</B></label>
                    </div>
                </div>
            </div>        
        </div>
    </div>
</div>

