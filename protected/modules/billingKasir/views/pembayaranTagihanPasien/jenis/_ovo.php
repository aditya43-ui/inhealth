<div class="panel_jenispembayaran panel_jenispembayaran_ovo">
    <div class="control-group">
        <?php echo CHtml::activeLabel($modJenis, 'pemilikovo', array('class'=>'control-label', 'label'=>'Nama Pemilik OVO <span class="required">*</span>')); ?>
        <div class="controls">
            <?php echo CHtml::activeTextField($modJenis, '[detail]['.$i.']pemilikovo', array('class'=>'span3 pemilikovo required')); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::activeLabel($modJenis, 'noovo', array('class'=>'control-label', 'label'=>'No. OVO <span class="required">*</span>')); ?>
        <div class="controls">
            <?php echo CHtml::activeTextField($modJenis, '[detail]['.$i.']noovo', array('class'=>'span3 noovo required', 'placeholder'=>'No. Mobile OVO')); ?>
        </div>
    </div>
    <?php /*
    <div class="control-group">
        <?php echo CHtml::activeLabel($modJenis, 'kodetransaksi', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::activeTextField($modJenis, '[detail]['.$i.']kodetransaksi', array('class'=>'span3 kodetransaksi')); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::activeLabel($modJenis, 'noreferensi', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::activeTextField($modJenis, '[detail]['.$i.']noreferensi', array('class'=>'span3 noreferensi')); ?>
        </div>
    </div>
     * 
     */ ?>
    <div class="control-group">
        <?php echo CHtml::activeLabel($modJenis, 'alamatemailovo', array('class'=>'control-label', 'label'=>'No. OVO <span class="required">*</span>')); ?>
        <div class="controls">
            <?php echo CHtml::activeTextField($modJenis, '[detail]['.$i.']alamatemailovo', array('class'=>'span3 alamatemailovo required')); ?>
        </div>
    </div>
</div>
