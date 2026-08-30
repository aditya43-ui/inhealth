<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            Analisa Darah Kembali
        </div>
    </div>
    <div class="panel-body">
        <?php 
        $this->widget('bootstrap.widgets.BootAlert');
        
        $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'id'=>'analisa-darah-kembali-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'htmlOptions'=>array(
                'onKeyPress'=>'return disableKeyPress(event);', 
                'onsubmit'=>'return requiredCheck(this);',
                // 'enctype' => 'multipart/form-data',
            ),
            //'focus'=>'#',
        )); 
        
        ?>
            <?php
                if(!empty($_GET['returdarah_id'])){
            ?>
            <?php echo $this->renderPartial($this->path_view."_formKantongDetail", array(
                'model'=>$model,
                'form'=>$form,
            ), true); ?>
            <?php
                }else{
            ?>
            <?php echo $this->renderPartial($this->path_view."_formKantong", array(
                'model'=>$model,
                'form'=>$form,
            ), true); ?>
            <?php
                }
            ?>
            <?php echo $this->renderPartial($this->path_view."_formAnalisa", array(
                'model'=>$model,
                'form'=>$form,
            ), true); ?>
        
            <div class="form-actions">
                <?php

                echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary submit',
                    'type' => 'submit'));
                echo "&nbsp;";
                if (!isset($_GET['frame']) || $_GET['frame'] != 1) {
                    echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), $this->createUrl($this->id . '/index'), array('class' => 'btn btn-danger',
    //                                      'onclick'=>'if(!confirm("Apakah anda ingin mengulang ini ?")) return false;'));
                    'onclick' => 'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = '.$this->createUrl('index').';}); return false;'));
                    echo "&nbsp;";
                }
                if($link!=NULL){
                    echo CHtml::link(Yii::t('mds','{icon} Kembali',array('{icon}'=>'<i class="entypo-left-bold"></i>')), 
                        Yii::app()->createUrl('bankDarah/InformasiReturDarah/index'),
                        array('class'=>'btn btn-success')); 
                }
                echo "&nbsp;";

                $content = $this->renderPartial($this->path_view.'tips/transaksi', array(), true);
                $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));

                ?>
            </div> 
        
        <?php $this->endWidget(); ?>
    </div>
</div>
<?php echo $this->renderPartial($this->path_view."_dialog", array(), true); ?>
<?php echo $this->renderPartial($this->path_view."_jsFunctions", array(), true); ?>