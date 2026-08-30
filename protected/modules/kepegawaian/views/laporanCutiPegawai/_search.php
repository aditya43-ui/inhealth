<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'type' => 'horizontal',
    'id' => 'laporan-cuti-search',
)); ?>
<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label("Tgl. Mulai Cuti", 'tgl_rekam', array('class' => 'control-label')) ?>
            <div class="controls">
                <div class="daterange daterange-inline input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
                    <i class="entypo-calendar"></i>
                    <span><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                    <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                    <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <?php
        echo '<div class="control-group">
                                ' . CHtml::label('Status', 'labklinikrujukan_id', array('class' => 'control-label')) . ' 
                                <div class="controls">
                                    ' . $form->dropDownList($model, 'status_cuti', Params::getStatusCuti(), array(
            'class' => 'form-control', 'multiple' => 'multiple'
        )) . '
                                </div>
                            </div>';
        // $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
        //     'id' => 'grafik',
        //     'content' => array(
        //         'content5' => array(
        //             'multi' => 'multi',
        //             'header' => 'Berdasarkan Status',
        //             'isi' =>
        //             '<div class="control-group">
        // 							' . CHtml::label('Status', 'labklinikrujukan_id', array('class' => 'control-label')) . ' 
        // 							<div class="controls">
        // 								' . $form->dropDownList($model, 'status_cuti', Params::getStatusCuti(), array(
        //                 'class' => 'form-control', 'multiple' => 'multiple'
        //             )) . '
        // 							</div>
        // 						</div>',
        //             'active' => TRUE,
        //         ),
        //     ),
        // ));
        ?>
    </div>
</div>
<div class="actions clear">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan')
    ); ?>
    <?php
    echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl($this->id . '/index'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    );
    ?>
</div>
<?php $this->endWidget(); ?>
<script>
    jQuery(document).ready(function() {
        dropMulti('<?php echo CHtml::activeId($model, 'status_cuti') ?>');
    });
</script>