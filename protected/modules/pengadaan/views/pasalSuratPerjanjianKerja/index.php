<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <b> Pasal Perjanjian Kerja </b>
        </div>
    </div>
    <div class="panel-body">
        <?php 
        
        $this->widget('bootstrap.widgets.BootAlert');
        
        $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'id'=>'form-pasal-surat',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'htmlOptions'=>array(
                'onKeyPress'=>'return disableKeyPress(event);', 
                'onsubmit'=>'return requiredCheck(this);',
                // 'enctype' => 'multipart/form-data',
            ),
        )); ?>

        <?php
        
        echo $this->renderPartial($this->path_view.'_infoSurat', array(
            'form'=>$form,
            'model'=>$model,
        ), true);
        
        
        echo $this->renderPartial($this->path_view.'_dasarPengerjaan', array(
            'form'=>$form,
            'model'=>$model,
        ), true);
        
        echo $this->renderPartial($this->path_view.'_formPasal', array(
            'form'=>$form,
            'model'=>$model,
        ), true);
        
        ?>
        
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
            
            echo CHtml::link(Yii::t('mds', '{icon} Cetak', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:;', array('class' => 'btn btn-succes', 'onclick' => 'print();'));

            ?>
            
            <?php
                $tips = array(
                    '0' => 'tanggal',
                    '1' => 'cari',
                    '2' => 'ulang'
                );
                $content = $this->renderPartial('pengadaan.views.tips.tipsPasal',array('tips'=>$tips),true);
                $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
            ?>
        </div>

        <?php $this->endWidget(); ?>
    </div>
</div>

<script>
    function print() {
        window.open('<?php echo $this->createUrl('print', array('id' => $model->suratperjanjiankerja_id)); ?>', 'printwin', 'left=100,top=100,width=640,height=480');
    }
</script>

<?php echo $this->renderPartial($this->path_view."_jsFunctions", array(
), true); ?>
