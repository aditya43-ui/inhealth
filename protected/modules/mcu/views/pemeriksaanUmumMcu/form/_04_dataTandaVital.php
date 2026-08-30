<div class="col-sm-12">
    <div class="control-group">
        <label class="controls"><strong><u>TANDA VITAL</u></strong></label>       
    </div>
</div>

<div class="col-sm-6">    
    <div class="control-group">
        <label class="control-label">Tensi</label>
        <div class="controls">
            <?php echo $form->textField($model, 'tekanandarah_sistolik', array('class' => 'numbers-only span1')); ?>
            <label>/</label>
        </div>
        <div class="controls">
            <?php echo $form->textField($model, 'tekanandarah_diastolik', array('class' => 'numbers-only span1')); ?>
            <label>mmHg</label>
        </div>
    </div>
    
   <div class="control-group">
        <?php echo Chtml::label('Nadi', '', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model, 'nadi', array('class' => 'span3 numbers-only')); ?>
            <label>/menit</label>
        </div>
    </div>
    
    <div class="control-group">
        <?php echo Chtml::label('Tinggi Badan', '', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model, 'tinggibadan', array('class' => 'span3 numbers-only')); ?>
            <label>cm</label>
        </div>
    </div>
</div>

<div class="col-sm-6">  
    <div class="control-group">
        <label class="control-label">Berat Badan</label>
        <div class="controls">
            <?php echo $form->textField($model, 'beratbadan', array('class' => 'numbers-only span1')); ?>
            <label>Kg</label>
        </div>       
    </div>
       
    <div class="control-group">
        <label class="control-label">Suhu</label>
        <div class="controls">
            <?php echo $form->textField($model, 'suhu', array('class' => 'angkacoma-only span1')); ?>
            <label><sup>o</sup>C</label>
        </div>       
    </div>
    
    <div class="control-group">
        <label class="control-label">Pernapasan</label>
        <div class="controls">
            <?php echo $form->textField($model, 'pernafasan', array('class' => 'numbers-only span1')); ?>
            <label>/menit</label>
        </div>       
    </div>
</div>

<div class="clear"></div>

<hr/>