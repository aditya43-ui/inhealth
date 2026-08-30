<div id="search-form">
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'type' => 'horizontal',
        'id' => 'search-laporan',
        'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
    ));
    ?>
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="entypo-search"></i> Pencarian
            </div>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-12">
                    <?php echo CHtml::hiddenField('type', ''); ?>
                    <div class="control-group">
                        <?php echo $form->hiddenField($model, 'jns_periode', array('class' => 'span2')); ?>
                        <?php echo $form->hiddenField($model, 'bln_awal', array('class' => 'span2')); ?>
                        <?php echo $form->hiddenField($model, 'bln_akhir', array('class' => 'span2')); ?>
                        <?php echo $form->hiddenField($model, 'thn_awal', array('class' => 'span2')); ?>
                        <?php echo $form->hiddenField($model, 'thn_akhir', array('class' => 'span2')); ?>
                        <?php echo CHtml::label("Periode Laporan", 'tgl_rekam', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <div class="daterange daterange-inline add-ranges input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
                                <i class="entypo-calendar"></i>
                                <span><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                                <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                                <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-actions">
                <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan')); ?>
                <?php echo CHtml::link(
                    Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                    Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''),
                    array(
                        'class' => 'btn btn-default',
                        'onclick' => 'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = "' . Yii::app()->createUrl($this->route) . '";}); return false;'
                    )
                );  ?>
                <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Cancel', array('{icon}' => '<i class="entypo-cancel"></i>')), array('class' => 'btn btn-default', 'onclick' => 'konfirmasiBatal()', 'onKeypress' => 'return formSubmit(this,event)')); ?>
                <!--</div>-->
            </div>
        </div>
    </div>
    <?php //$this->widget('TipsMasterData', array('type' => 'create')); 
    ?>
</div>
<?php $this->endWidget(); ?>