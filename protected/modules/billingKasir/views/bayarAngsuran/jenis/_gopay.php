<div class="panel_jenispembayaran panel_jenispembayaran_gopay"">
    <div class="control-group">
        <?php echo CHtml::activeLabel($modJenis, 'pemilikgopay', array('class'=>'control-label', 'label'=>'Nama Pemilik Gopay <span class="required">*</span>')); ?>
        <div class="controls">
            <?php echo CHtml::activeTextField($modJenis, '[detail]['.$i.']pemilikgopay', array('class'=>'span3 pemilikgopay')); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::activeLabel($modJenis, 'nogopay', array('class'=>'control-label', 'label'=>'No. Gopay <span class="required">*</span>')); ?>
        <div class="controls">
            <?php echo CHtml::activeTextField($modJenis, '[detail]['.$i.']nogopay', array('class'=>'span3 nogopay', 'placeholder'=>'No. Mobile untuk Gopay')); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::activeLabel($modJenis, 'alamatemailgopay', array('class'=>'control-label', 'label'=>'Email Gopay <span class="required">*</span>')); ?>
        <div class="controls">
            <?php echo CHtml::activeTextField($modJenis, '[detail]['.$i.']alamatemailgopay', array('class'=>'span3 alamatemailgopay')); ?>
        </div>
    </div>
</div>
