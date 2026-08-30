<style>
    body {
        color: black;
    }
    
    .table tfoot td {
        color: black !important;
    }
    
    .base_det .det_label, .base_det .det_label2 {
        vertical-align: top;
    }
    
    .det_label {
        display: inline-block;
        width: 150px;
    }
    
    .det_val {
        display: inline-block;
        width: calc(100% - 155px);
    }
    
    .det_label2 {
        display: inline-block;
        width: 150px;
    }
    
    .det_val2 {
        display: inline-block;
        width: calc(100% - 155px);
    }
</style>
<?php

$skoring = array(
    "wbs" => "Wong Baker Faces Pain Scale",
    "flaccs" => "Skala FLACCS",
    "nrs" => "Numerical Rating Scale (NRS)",
    "vas" => "Visual Analog Scale (VAS)",
    "bps_tanpaventilator" => "Behavioural Pain Scale Tanpa Ventilator",
    "bps_ventilator" => "Behavioural Pain Scale Ventilator",
    "nips" => "Neonatal Infant Pain Score",
);

?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Detail Pengkajian Nyeri</div>
    </div>
    <div class="panel-body">
        <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'id'=>'pengkajiannyeri-t-view',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
            'focus'=>'#',
        )); ?>
        
        <div class="row-fluid">
            <div class="col-sm-6">
                <div class="base_det">
                    <div class="det_label">Tanggal Pendaftaran</div>
                    <div class="det_val">: 
                        <?php echo MyFormatter::formatDateTimeForUser($model->pendaftaran->tgl_pendaftaran); ?>
                    </div>
                </div>
                <div class="base_det">
                    <div class="det_label">Instalasi/Ruangan</div>
                    <div class="det_val">: 

                        <?php echo $model->ruangan->instalasi->instalasi_nama." / ".$model->ruangan->ruangan_nama; ?>
                    </div>
                </div>
                <div class="base_det">
                    <div class="det_label">Tgl/Jam Pengkajian Nyeri</div>
                    <div class="det_val">: 
                        <?php echo MyFormatter::formatDateTimeForUser($model->waktupengkajian); ?>
                    </div>
                </div>
                
            </div>
            <div class="col-sm-6">
                <div class="base_det">
                    <div class="det_label">Petugas Pengisi</div>
                    <div class="det_val">: 
                        <?php echo $model->petugaspengkaji->namaLengkap; ?>
                    </div>
                </div>
                <div class="base_det">
                    <div class="det_label">Sistem Skoring</div>
                    <div class="det_val">: 
                        <?php echo $skoring[$model->sistemskoring]; ?>
                    </div>
                </div>
            </div>
        </div>
        
        
        <?php
        
        $view_skoring = array(
            "wbs" => $this->renderPartial($this->path_view.'skoring_view/_skalaNyeri', array(
                'model'=>$model, 'view'=>1,
            ), true),
            "flaccs" => $this->renderPartial($this->path_view.'skoring_view/_flaccs', array(
                'model'=>$model, 'form'=>$form, 'view'=>1,
            ), true),
            "nrs" => $this->renderPartial($this->path_view.'skoring_view/_nrs', array(
                'model'=>$model, 'form'=>$form, 'view'=>1,
            ), true),
            "vas" => $this->renderPartial($this->path_view.'skoring_view/_vas', array(
                'model'=>$model, 'form'=>$form, 'view'=>1,
            ), true),
            "bps_tanpaventilator" => $this->renderPartial($this->path_view.'skoring_view/_bps_tanpaventilator', array(
                'model'=>$model, 'form'=>$form, 'view'=>1,
            ), true),
            "bps_ventilator" => $this->renderPartial($this->path_view.'skoring_view/_bps_ventilator', array(
                'model'=>$model, 'form'=>$form, 'view'=>1,
            ), true),
            "nips" => $this->renderPartial($this->path_view.'skoring_view/_nips', array(
                'model'=>$model, 'form'=>$form, 'view'=>1,
            ), true),
        );
        
        echo $view_skoring[$model->sistemskoring];
        
        ?>
        
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">Tipe & Deskripsi Nyeri</div>
            </div>
            <div class="panel-body">
                <?php echo $this->renderPartial($this->path_view."_detail_view", array('model' => $model), true); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">Tatalaksana Nyeri</div>
            </div>
            <div class="panel-body">
                <?php echo $model->tatalaksananyeri; ?>
            </div>
        </div>
        
        <?php $this->endWidget(); ?>
        <div class="form-action">
            <?php echo CHtml::link('Kembali', $this->createUrl('create', array('pendaftaran_id'=>$pendaftaran_id,'type'=>(!empty($_GET['type'])?$_GET['type']:""))), array(
                'class'=>'btn btn-danger'
            )); ?>
        </div>
    </div>
</div>

