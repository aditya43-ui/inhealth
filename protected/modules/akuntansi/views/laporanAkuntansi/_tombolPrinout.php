 <?php
    //echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class' => 'btn btn-danger', 'type'=>'button','onclick'=>'print(\'PRINT\')'));
    //echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class' => 'btn btn-info', 'type'=>'button','onclick'=>'print(\'PDF\')')); 
    //echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class' => 'btn btn-info', 'type'=>'button','onclick'=>'print(\'EXCEL\')'));         
    //echo CHtml::htmlButton(Yii::t('mds','{icon} Grafik',array('{icon}'=>'<i class="entypo-chart-area"></i>')),array('class' => 'btn btn-danger', 'type'=>'button','onclick'=>'print(\'GRAFIK\')'));
    ?>
<?php $this->widget('bootstrap.widgets.BootButtonGroup', array(
    // 'type' => 'info', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
    // 'buttons' => array(
    //     array('label' => 'Print', 'icon' => MyIcon::getIcons('cetak'), 'url' => '#', 'htmlOptions' => array('onclick' => 'print(\'PRINT\')')),
    //     array('label' => '', 'items' => array(
    //         array('label' => 'PDF', 'icon' => MyIcon::getIcons('pdf'), 'url' => '', 'itemOptions' => array('onclick' => 'print(\'PDF\')')),
    //         array('label' => 'Excel', 'icon' => MyIcon::getIcons('excel'), 'url' => '', 'itemOptions' => array('onclick' => 'print(\'EXCEL\')')),
    //         array('label' => 'Grafik', 'icon' => MyIcon::getIcons('grafik'), 'url' => '', 'itemOptions' => array('onclick' => 'print(\'GRAFIK\')')),
    //     )),
    // ),
    //        'htmlOptions'=>array('class'=>'btn')
)); ?>