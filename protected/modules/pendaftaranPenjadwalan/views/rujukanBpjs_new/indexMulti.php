<div class="panel panel-gradient">
    <!-- <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-search"></i> <b>Pencarian Rujukan BPJS Multi Record</b>
        </div>
    </div> -->
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

        <?php
        if (isset($_GET['sukses'])) {
            Yii::app()->user->setFlash('success', "Data Pemesanan Kamar berhasil dibuat !");
        }
        ?>
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php
        $this->widget('bootstrap.widgets.BootTabbable', array(
            'type' => 'tabs',
            'placement' => 'above', // 'above', 'right', 'below' or 'left'
            'tabs' => array(
                array('label' => 'Rujukan PCare', 'content' => $this->renderPartial($this->path_view . '_formFKTP_1', array('form' => $form), true)),
                array('label' => 'Rujukan Rumah Sakit', 'content' => $this->renderPartial($this->path_view . '_formFKTL_1', array('form' => $form), true)),
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
<?php $this->renderPartial($this->path_view . '_jsFunctions', array()); ?>