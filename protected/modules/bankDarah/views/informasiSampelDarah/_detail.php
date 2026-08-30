<?php
/**
* - digunakan sebagai detail skrining
* @author : Elham Budianto <elhambudianto1@gmail.com>
**/
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <b> Skrining Infeksi Menular Lewat Transfusi Darah </b>
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
                <div class="col-sm-6">
                    <div class="control-group">
                        <?php echo CHtml::label('Nomor Barcode Sampel', '', array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo CHtml::textField('barcode_kantong', $kantong->nomorbarcode_sample_imltd, array('readonly'=>true)); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Jenis Kantong Darah', '', array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo CHtml::textField('barcode', $kantong->jeniskantongdarah->nama_jenis, array('readonly'=>true)); ?>

                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Tgl. Penerimaan Kantong', '', array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo CHtml::textField('tgl_terima', MyFormatter::formatDateTimeForUser($kantong->tglpencatatan), array('readonly'=>true)); ?>

                        </div>
                    </div>
                </div>
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo CHtml::label('Golongan Darah', '', array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php 
                                $donor = PendonorM::model()->findByPk($kantong->pendonor_id);

                                echo CHtml::textField('golongan_darah', $donor->gol_darah, array('readonly'=>true)); ?>

                            </div>
                        </div>
                        <div class="control-group">
                            <?php 
                            $ruangan = RuanganM::model()->findByPk($kantong->create_ruangan);
                            echo CHtml::label('Rhesus', '', array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php echo CHtml::textField('rhesus', $donor->rhesus, array('readonly'=>true)); ?>

                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Ruangan Asal', '', array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php echo CHtml::textField('ruangan_asal', $ruangan->ruangan_nama, array('readonly'=>true)); ?>

                            </div>
                        </div>

                    </div>

            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    Skrining Infeksi Menular
                </div>
            </div>
            <div class="panel-body">
                <div class="col-sm-6">
                    <?php $template = "{input} {label}&emsp;"; ?>
                    <?php echo $form->radioButtonListRow($model, 'hbsag', array(1 => 'Reaktif', 0 => 'Non Reaktif'), array('class'=>'rd_reaksi', 'template'=>$template, 'disabled' => true, 'onchange'=>'cekReaktif();')); ?>
                    <?php echo $form->radioButtonListRow($model, 'antihiv', array(1 => 'Reaktif', 0 => 'Non Reaktif'), array('class'=>'rd_reaksi', 'template'=>$template, 'disabled' => true, 'onchange'=>'cekReaktif();')); ?>
                    <?php echo $form->radioButtonListRow($model, 'antihvc', array(1 => 'Reaktif', 0 => 'Non Reaktif'), array('class'=>'rd_reaksi', 'template'=>$template, 'disabled' => true, 'onchange'=>'cekReaktif();')); ?>
                    <?php echo $form->radioButtonListRow($model, 'sifilis', array(1 => 'Reaktif', 0 => 'Non Reaktif'), array('class'=>'rd_reaksi', 'template'=>$template, 'disabled' => true, 'onchange'=>'cekReaktif();')); ?>
                </div>
                <div class="col-sm-6">
                    <?php echo $form->textAreaRow($model, 'ket_skrining',array('readonly'=>true)); ?>
                    <?php echo $form->textFieldRow($model, 'hasil_skrining', array('readonly'=>true)); ?>
                </div>
                <div class="clear"></div>
                <hr/>
                <div class="col-sm-6">
                    <div class="control-group ">
                        <?php echo $form->labelEx($model, 'tglskrining', array(
                            'class' => 'control-label', 'label'=>'Tgl. Skrining'
                        )) ?>
                        <div class="controls">
                            <?php echo $form->textField($model, 'tglskrining', array('readonly'=>true)); ?>
                            <?php echo $form->error($model, 'tglpencatatan'); ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">

                    <div class="control-group ">
                        <?php echo Chtml::label("Petugas <font style='color:red'>*</font>", 'petugasskrining_id', array(
                            'class'=>'control-label',
                        )); ?>
                        <div class="controls">
                            <?php echo $form->hiddenField($model, 'petugasskrining_id',array('class' => 'required','readonly'=>true)); ?>
                            <?php

                            $petugas = "";
                            if (!empty($model->petugasskrining_id)) {
                                $petugas = $model->petugasskrining->nama_pegawai;
                            }
                            echo Chtml::textField('petugasskrining_id',$petugas, array('readonly'=>true));
                                                       ?>
                        </div>
                    </div>  
                </div>
            </div>
        </div>
        <div class="clear"></div>
        <?php $this->endWidget(); ?>
    </div>
</div>