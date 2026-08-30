<?php ?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'saalatmedis-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#' . CHtml::activeId($model, 'instalasi_nama')
        ));
?>
<div class="panel panel-primary panel-success">
    <div class="panel-heading">
        <div class="panel-title">Informasi Penerimaan Kantong Darah</div>
    </div>
    <div class="panel-body">
        <?php echo CHtml::beginForm(); ?>
        <div class="row-fluid">
            <div class="row-fluid">
                <div class="col-sm-6">
                    <div class="control-group">

                        <?php echo CHtml::label('No. Penerimaan', '', array('class' => 'control-label')); ?>


                        <div class="controls">	
                            <?php echo CHtml::activeTextField($model, 'no_terimakantong', array('readonly' => true, 'class' => 'span3')); ?>
                        </div>

                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="control-group">

                        <?php echo CHtml::label('Suhu', '', array('class' => 'control-label')); ?>

                        <div class="controls">

                            <?php echo CHtml::activeTextField($model, 'suhu_terima', array('readonly' => true, 'class' => 'span3 numbers-only')); ?>

                        </div>
                        <div class="controls">

                            <label><sup>o</sup>C</label>

                        </div>

                    </div>
                </div>
            </div>    
            <div class="col-sm-6">
                <div class="control-group">

                    <?php echo CHtml::label('Ruangan Asal', '', array('class' => 'control-label')); ?>


                    <div class="controls">

                        <?php echo CHtml::activeTextField($model, 'ruangankirim_nama', array('readonly' => true, 'class' => 'span3')); ?>
                    </div>

                </div>
            </div>
            <div class="col-sm-6">
                <div class="control-group">

                    <?php echo CHtml::label('Petugas Penerima', '', array('class' => 'control-label')); ?>


                    <div class="controls">

                        <?php echo CHtml::activeTextField($model, 'pegawaiterima_nama', array('readonly' => true, 'class' => 'span3')); ?>
                    </div>

                </div>
            </div> 
            <div class="col-sm-6">
                <div class="control-group">

                    <?php echo CHtml::label('Waktu Penerimaan', '', array('class' => 'control-label')); ?>


                    <div class="controls">

                        <?php echo CHtml::activeTextField($model, 'tglterimakantong', array('readonly' => true, 'class' => 'span3')); ?>
                    </div>

                </div>
            </div> 
            <?php echo CHtml::endForm(); ?>
        </div>
    </div>
</div>
<div class="panel panel-primary panel-success">
    <div class="panel-heading">
        <div class="panel-title">Tabel Penerimaan Kantong Darah</div>
    </div>
    <div class="panel-body">

        <div class="panel panel-primary panel-success">
            <div class="panel-body table-responsive">
                <?php $this->renderPartial('_tableDetailPenerimaanKantongDarah', array('modDetail' => $detail)); ?>
            </div>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>
