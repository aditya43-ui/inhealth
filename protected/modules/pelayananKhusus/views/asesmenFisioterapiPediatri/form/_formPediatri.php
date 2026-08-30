<?php echo $form->hiddenField($model,'pendaftaran_id',array('readonly' => true)); ?>
<?php echo $form->hiddenField($model,'pasien_id',array('readonly' => true)); ?>
<?php echo $form->hiddenField($model,'pasienadmisi_id',array('readonly' => true)); ?>
<?php echo $form->hiddenField($model,'pasienmasukpenunjang_id',array('readonly' => true)); ?>
<div class="col-sm-7">
    <div class="control-group">        
        <div class="controls">
            <label>a. Antropometri</label>
        </div>
    </div>
    
    <div class="control-group">          
        <div class="controls">
            &nbsp;&nbsp;&nbsp;&nbsp;<label>1. &nbsp;&nbsp;&nbsp;&nbsp; Bone Length</label>
        </div>
        <div class="controls">
            <label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</label>
        </div>
        <div class="controls">
            <label>Dextra</label>
        </div>
        <div class="controls">
            <label> : </label> <?php echo $form->textField($model,'antropometri_bonelength_dextra',array('class' => 'span1 angkacoma-only')) ?>
        </div>
        <div class="controls">
            <label>cm&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
        </div>
        <div class="controls">
            <label>Sinistra</label>
        </div>
        <div class="controls">
            <label> : </label> <?php echo $form->textField($model,'antropometri_bonelength_sinistra',array('class' => 'span1 angkacoma-only')) ?>
        </div>
        <div class="controls">
            <label>cm</label>
        </div>
    </div>
    
    <div class="control-group">        
        <div class="controls">
            &nbsp;&nbsp;&nbsp;&nbsp;<label>2. &nbsp;&nbsp;&nbsp;&nbsp; True Length</label>
        </div>
        <div class="controls">
            <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</label>
        </div>
        <div class="controls">
            <label>Dextra</label>
        </div>
        <div class="controls">
            <label> : </label> <?php echo $form->textField($model,'antropometri_truelength_dextra',array('class' => 'span1 angkacoma-only')) ?>
        </div>
        <div class="controls">
            <label>cm&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
        </div>
        <div class="controls">
            <label>Sinistra</label>
        </div>
        <div class="controls">
            <label> : </label> <?php echo $form->textField($model,'antropometri_truelength_sinistra',array('class' => 'span1 angkacoma-only')) ?>
        </div>
        <div class="controls">
            <label>cm</label>
        </div>
    </div>
    
    <div class="control-group">        
        <div class="controls">
            &nbsp;&nbsp;&nbsp;&nbsp;<label>3. &nbsp;&nbsp;&nbsp;&nbsp; Apparent Length</label>
        </div>
        <div class="controls">
            <label>:</label>
        </div>
        <div class="controls">
            <label>Dextra</label>
        </div>
        <div class="controls">
            <label> : </label> <?php echo $form->textField($model,'antropometri_apparentlength_dextra',array('class' => 'span1 angkacoma-only')) ?>
        </div>
        <div class="controls">
            <label>cm&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
        </div>
        <div class="controls">
            <label>Sinistra</label>
        </div>
        <div class="controls">
            <label> : </label> <?php echo $form->textField($model,'antropometri_apparentlength_sinistra',array('class' => 'span1 angkacoma-only')) ?>
        </div>
        <div class="controls">
            <label>cm</label>
        </div>
    </div>      
    
    <div class="control-group">        
        <div class="controls">
            <label>b. Sensibiltas</label>
        </div>
    </div>
    
     <div class="control-group">        
        <div class="controls">
            <?php echo $form->textArea($model,'sensibilitas',array('class' => 'span5 autorow')) ?>    
        </div>
    </div>    
</div>
<div class="col-sm-5"> 
     <div class="control-group">        
        <div class="controls">
            <label>c. Refleks Patologis</label>
        </div>
    </div>
    
     <div class="control-group">        
        <div class="controls">
            <?php echo $form->textArea($model,'refleks_patologis',array('class' => 'span4 autorow')) ?>    
        </div>
    </div>         
    
    <div class="control-group">        
        <div class="controls">
            <label>d. Test Khusus Sesuai Kelainan/Penyakit/Gangguan (DDST, GMFM, dll)</label>
        </div>
    </div>
    
     <div class="control-group">        
        <div class="controls">
            <?php echo $form->textArea($model,'test_khusus',array('class' => 'span4 autorow')) ?>    
        </div>
    </div>     
</div>
