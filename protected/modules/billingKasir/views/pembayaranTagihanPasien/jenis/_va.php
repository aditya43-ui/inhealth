<div class="panel_jenispembayaran panel_jenispembayaran_va">
    <div class="control-group">
        <?php echo CHtml::activeLabel($modJenis, 'pemilikvirtualaccount', array('class'=>'control-label', 'label'=>'Nama Pemilik Kartu <span class="required">*</span>')); ?>
        <div class="controls">
            <?php echo CHtml::activeTextField($modJenis, '[detail]['.$i.']pemilikvirtualaccount', array('class'=>'span3 pemilikvirtualaccount')); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::activeLabel($modJenis, 'norekening', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::activeTextField($modJenis, '[detail]['.$i.']norekening', array('class'=>'span3 norekening')); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::activeLabel($modJenis, 'namavirtualaccountpenerima', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::activeTextField($modJenis, '[detail]['.$i.']namavirtualaccountpenerima', array('class'=>'span3 namavirtualaccountpenerima')); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::activeLabel($modJenis, 'novirtualaccount', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::activeTextField($modJenis, '[detail]['.$i.']novirtualaccount', array('class'=>'span3 novirtualaccount')); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::activeLabel($modJenis, 'notelpvirtualaccount', array('class'=>'control-label', 'label'=>'No. Telepon <span class="required">*</span>')); ?>
        <div class="controls">
            <?php echo CHtml::activeTextField($modJenis, '[detail]['.$i.']notelpvirtualaccount', array('class'=>'span3 notelpvirtualaccount')); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::activeLabel($modJenis, 'emailvirtualaccount', array('class'=>'control-label', 'label'=>'Email <span class="required">*</span>')); ?>
        <div class="controls">
            <?php echo CHtml::activeTextField($modJenis, '[detail]['.$i.']emailvirtualaccount', array('class'=>'span3 emailvirtualaccount')); ?>
        </div>
    </div>
</div>
