<div class="span-3">
    <div class="control-group">
        <?php echo CHtml::label("BB", 'beratbadan', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model, 'beratbadan', array('class' => 'span2 integer', 'onblur' => 'setBMI(this);', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> kg </label>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Tanda Vital", ' ', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model, 'tekanandarah_sistolik', array('class' => 'span1 integer', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> / </label>
            <?php echo $form->textField($model, 'tekanandarah_diastolik', array('class' => 'span1 integer', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> mmHg </label>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("RR", ' ', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model, 'respiration_rate', array('class' => 'span2 integer', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> x / menit</label>
        </div>
    </div>
</div>

<div class="span-3">
    <div class="control-group">
        <?php echo CHtml::label("TB", 'tinggibadan', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model, 'tinggibadan', array('class' => 'span2 integer', 'onblur' => 'setBMI(this);', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> cm </label>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Nadi", ' ', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model, 'nadi', array('class' => 'span1 integer', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> x / menit</label>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Skor Nyeri", ' ', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model, 'skor_nyeri', array('class' => 'span2 integer', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
        </div>
    </div>
</div>


<div class="span-3">
    <div class="control-group">
        <?php echo CHtml::label("BMI", 'bodymassindex', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model, 'bodymassindex', array('class' => 'span2 integer','readonly' => true ,'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Temperatur", ' ', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model, 'suhu', array('class' => 'span1 integer', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?> <label> &#176; C</label>
        </div>
    </div>
</div>