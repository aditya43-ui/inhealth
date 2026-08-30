<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-search"></i> Pencarian
        </div>
    </div>
    <div class="panel-body">
        <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'action' => Yii::app()->createUrl($this->route),
            'method' => 'get',
            'id' => 'search',
            'type' => 'horizontal',
            'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
        ));
        ?>
        <div class="row">
            <div class="col-sm-6">
                <?php echo $form->textFieldRow($modKomposisiBahanMakanan, 'namabahanmakanan', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50, 'autofocus' => true, 'placeholder' => 'Nama Bahan Makanan')); ?>
                <?php //echo $form->textFieldRow($modKomposisiBahanMakanan,'zatgizi_nama',array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50)); 
                ?>
            </div>
        </div>

        <div class="form-actions">
            <?php
            echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                array('class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan')
            );
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), array('class' => 'btn btn-default', 'type' => 'reset'));
            ?>
            <?php
            $content = $this->renderPartial('../tips/informasi', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>

        <?php $this->endWidget(); ?>
    </div>
</div>