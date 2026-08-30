<style>
    .yellow td {
        background-color: yellow !important;
    }
    .integer-decimal{
      text-align: right;
    }
</style>

<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
        'id'=>'iurbeapasien-form',
        'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);'),//DIMATIKAN KARENA PAKAI VERIFIKASI FORM >> , 'onsubmit'=>'return requiredCheck(this);'
        'focus'=>'#instalasi_id',
)); ?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">Transaksi <strong>Iur Bea Pasien</strong></div>
            </div>
            <div class="panel-body">

               
                <div class="panel panel-success panel-shadow" id="form-datakunjungan">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <span class='judul' style="float:left;">Data Kunjungan </span>
                            <?php echo CHtml::htmlButton('<i class="'.MyIcon::getIcons('ulang').'"></i>',array('class'=>'btn btn-danger btn-mini tombol','onclick'=>'setKunjunganReset();','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk mengulang data kunjungan','style'=>'display:none;')); ?>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="row-fluid">
                            <?php $this->renderPartial($this->path_view.'_formInfoKunjungan', array('form'=>$form,'modKunjungan'=>$modKunjungan)); ?>
                        </div>
                    </div>
                </div>
                <div class="panel panel-success panel_naikkelas">
                    <div class="panel-heading">
                        <div class="panel-title"><strong><?= CHtml::checkBox('Alokasi[is_naikkelas]', false, ['id' => 'checkBoxNaikKelas']) ?> Pasien Naik Kelas</strong></div>
                    </div>
                    <div class="panel-body body_naikkelas <?= $model->isNewRecord ? "hide" : ""; ?>">
                        <?php $this->renderPartial($this->path_view . '_formPasienNaikKelas', ['form' => $form, 'model'=>$model]) ?>
                    </div>
                </div>
                
                
                <div class="form-actions">
                    <?php
                        if(empty($_GET['sukses'])){
                            echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button', 'onclick'=>'setVerifikasi();', 'onkeypress'=>'setVerifikasi();')); //formSubmit(this,event)
                        }else{
                            echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button', 'onclick'=>'return false', 'onkeypress'=>'return false', 'disabled'=>true, 'style'=>'cursor:not-allowed;'));
                        }

                        echo "&nbsp;";

                        if (!$model->isNewRecord) {
                            echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-info', 'type'=>'button', 'onclick'=>'printBea();')); //formSubmit(this,event)
                        } else {
                            echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('disabled'=>true, 'class'=>'btn btn-info', 'type'=>'button', 'onclick'=>'return false;')); //formSubmit(this,event)
                        }
                    ?>
                    <?php
                        if(!isset($_GET['frame'])){
                            echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),
                            $this->createUrl($this->id.'/index'),
                            array('class'=>'btn btn-danger',
                            'onclick'=>'return refreshForm(this);'));
                        }
                    ?>
                    
                    <?php
                        $content = $this->renderPartial($this->path_view.'tips/tipsPembayaranTagihanPasien',array(),true);
                        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
                    ?>
                </div>
                <?php // $this->renderPartial($this->path_view.'_jsFunctions', array('modKunjungan'=>$modKunjungan,'model'=>$model,'modTandabukti'=>$modTandabukti,'modPemakaianuangmuka'=>$modPemakaianuangmuka, 'modPiutangAsuransi'=> $modPiutangAsuransi)); ?>
                <?php $this->renderPartial($this->path_view.'_jsFunctions', array('modKunjungan'=>$modKunjungan,'model'=>$model)); ?>
                    
            </div>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>

