<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            Distribusi Darah
        </div>
    </div>
    <div class="panel-body">
        <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'id'=>'form-distribusi-darah',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'htmlOptions'=>array(
                'onKeyPress'=>'return disableKeyPress(event);', 
                'onsubmit'=>'return requiredCheck(this);',
            ),
            'focus'=>'#no_kantongdarah',
        )); ?>

        <?php
        
        echo $this->renderPartial($this->path_view."_pengiriman", array(
            'form'=>$form, 'model'=>$model,
        ), true);
        
        echo $this->renderPartial($this->path_view."_tabel", array(
            'form'=>$form, 'model'=>$model,
        ), true);
        
        echo $this->renderPartial($this->path_view."_form", array(
            'form'=>$form, 'model'=>$model,
        ), true);
        
        ?>
        
        <div class="form-actions">
            <?php
            
            $disabled = !$model->isNewRecord;
            
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary '.($disabled ? '' :'submit'), 
                'disabled'=>$disabled,
                'type' => 'submit'));
            echo "&nbsp;";
            if (!isset($_GET['frame']) || $_GET['frame'] != 1) {
                echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), $this->createUrl($this->id . '/index'), array('class' => 'btn btn-danger',
//                                      'onclick'=>'if(!confirm("Apakah anda ingin mengulang ini ?")) return false;'));
                'onclick' => 'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = '.$this->createUrl('index').';}); return false;'));
                echo "&nbsp;";
            }

            echo CHtml::link(Yii::t('mds', '{icon} Cetak', array('{icon}' => '<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array(
                'class' => 'btn btn-info', 
                'onclick' => "printLabel();return false",
                "disabled"=>!$disabled,
                ));
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