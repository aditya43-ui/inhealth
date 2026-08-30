<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            Skrining Infeksi Menular Lewat Transfusi Darah
        </div>
    </div>
    <div class="panel-body">
        <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'id'=>'kantongdarah-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
        )); ?>
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?> 
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">Kantong Darah</div>
            </div>
            <div class="panel-body">
                <?php echo $this->renderPartial($this->path_view."form/_formKantongDarah", array('model'=>$model, 'kantong'=>$kantong ), true); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    Skrining Infeksi Menular
                </div>
            </div>
            <div class="panel-body">
                <?php echo CHtml::hiddenField('redirect_url', $this->prev_url); ?>
                <?php echo $this->renderPartial($this->path_view."form/_formSkrining", array('form'=>$form, 'model'=>$model, 'kantong'=>$kantong), true); ?>
            </div>
        </div>
        <div class="clear"></div>
        <div class="form-actions">
            <?php
            if (!empty($_GET['sukses'])) {
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary button',
                    'type' => 'button', 'disabled' => true));
            }else{
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary submit', 
                    //'disabled'=>!$model->isNewRecord,
                    'type' => 'submit', 'onclick' => 'formSubmit(this,event);', 'onkeypress' => 'formSubmit(this,event);'));
            }
            echo "&nbsp;";
            if (!isset($_GET['frame'])) {
                echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), $this->createUrl($this->id . '/index'), array('class' => 'btn btn-danger',
//                                      'onclick'=>'if(!confirm("Apakah anda ingin mengulang ini ?")) return false;'));
                    'onclick' => 'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));
                echo "&nbsp;";
                echo CHtml::link(Yii::t('mds','{icon} Kembali',array('{icon}'=>'<i class="entypo-back"></i>')), $this->createUrl('informasiSampelDarah/Index'), array('class' => 'btn btn-danger'));
//                echo CHtml::link(Yii::t('mds','{icon} Kembali',array('{icon}'=>'<i class="entypo-back"></i>')),
//                    '#', 
//                    array('class'=>'btn btn-danger',
//                        'onclick'=>'myConfirm("Apakah Anda yakin ingin Kembali ke informasi sampel darah ?","Perhatian!",function(r) {if(r) window.location = "'.$this->createUrl('informasiSampelDarah/index').'";} ); return false;'));
            }

                echo "&nbsp;";
//             $content = $this->renderPartial('bankDarah/views/tips/skriningImltd', array(), true);
//             $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));

            ?> 
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>