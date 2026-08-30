<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-search"></i> <b>Pencarian Rujukan BPJS</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'pencarian-rujukan-bpjs-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array(
                'onKeyPress' => 'return disableKeyPress(event);',
                'onsubmit' => 'return requiredCheck(this);'
            ),
            'focus' => '#',
        ));
        ?>

        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php
        $this->widget('bootstrap.widgets.BootTabbable', array(
            'type' => 'tabs',
            'placement' => 'above', // 'above', 'right', 'below' or 'left'
            'tabs' => array(
                array('label' => 'Rujukan Berdasarkan Nomor Rujukan / Peserta (1 Record)', 'content' => $this->renderPartial($this->path_view . 'index', array('form' => $form), true)),
                array('label' => 'Rujukan Berdasarkan Nomor Kartu (Multi Record)', 'content' => $this->renderPartial($this->path_view . 'indexMulti', array('form' => $form), true)),
            ),
            //				'htmlOptions'=>array('onclick'=>'setTab(this);')
        ));
        ?>

        <!--	<div class="form-actions">
		<?php // echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info','type'=>'button','disabled'=>true,'onclick'=>'printRujukanBpjs(\'PRINT\')')); 
        ?>
		<?php // echo CHtml::htmlButton(Yii::t('mds','Lihat Riwayat',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-primary btn-riwayat','type'=>'button','disabled'=>true,'onclick'=>'lihatRiwayat(\'PRINT\')')); 
        ?>
	</div>-->
    </div>
</div>
<?php $this->endWidget(); ?>