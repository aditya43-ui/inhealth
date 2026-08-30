<?php

/**
 * digunakan untuk pencarian
 * 
 * @author          Yusuf Putra Anugrah <yusufputra@.com>
 * @version         2.0.0
 * @link            .com
 * 
 */
?>
<div class="search-form">
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'id' => 'search-laporan',
        'type' => 'horizontal',
        'focus' => '#' . CHtml::activeId($model, 'nomutasioa'),
    ));
    ?>
    <div class="row">
        <div class="col-sm-12">
            <?php echo CHtml::hiddenField('type', ''); ?>
            <?php echo CHtml::hiddenField('filter_tab', 'rekap'); ?>
            <div class="control-group">
                <?php echo $form->hiddenField($model, 'jns_periode', array('class' => 'span2')); ?>
                <?php echo $form->hiddenField($model, 'bln_awal', array('class' => 'span2')); ?>
                <?php echo $form->hiddenField($model, 'bln_akhir', array('class' => 'span2')); ?>
                <?php echo $form->hiddenField($model, 'thn_awal', array('class' => 'span2')); ?>
                <?php echo $form->hiddenField($model, 'thn_akhir', array('class' => 'span2')); ?>
                <?php echo CHtml::label("Periode Laporan", 'tgl_awal', array('class' => 'control-label')) ?>
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
        <div class="col-sm-6">
            <?php echo $form->textFieldRow($model, 'nomutasioa', array('placeholder' => 'No. Mutasi', 'class' => 'numberOnly span4')); ?>
        </div>
        <div class="col-sm-6">
            <?php
            echo CHtml::hiddenField('filter', 'ruangantujuan_id', array('disabled' => 'disabled')) .
                '<div class="control-group">
                    ' . CHtml::label('Jenis Obat Alkes', 'ruangantujuan_id', array('class' => 'control-label')) . ' 
                    <div class="controls">
                        ' . $form->dropDownList($model, 'ruangantujuan_id', CHtml::listData(RuanganM::model()->findAll(array('order' => 'ruangan_nama')), 'ruangan_id', 'ruangan_nama'), array(
                    'class' => 'form-control', 'multiple' => 'multiple'
                )) . '
                    </div>
                </div>';
            ?>
        </div>
    </div>
    <!-- <div class="row">
        <div class="col-sm-6">
            <?php
            // $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
            //     'id' => 'ruangantujuan',
            //     'slide' => true,
            //     'content' => array(
            //         'content2' => array(
            //             'multi' => 'multi',
            //             'header' => 'Berdasarkan Ruangan Tujuan',
            //             'isi' => CHtml::hiddenField('filter', 'ruangantujuan_id', array('disabled' => 'disabled')) .
            //                 '<div class="control-group">
            //                         ' . CHtml::label('Jenis Obat Alkes', 'ruangantujuan_id', array('class' => 'control-label')) . ' 
            //                         <div class="controls">
            //                             ' . $form->dropDownList($model, 'ruangantujuan_id', CHtml::listData(RuanganM::model()->findAll(array('order' => 'ruangan_nama')), 'ruangan_id', 'ruangan_nama'), array(
            //                     'class' => 'form-control', 'multiple' => 'multiple'
            //                 )) . '
            //                         </div>
            //                     </div>',
            //             'active' => true,
            //         ),
            //     ),
            // ));
            ?>

            <?php
            //echo $form->dropDownListRow($model, 'ruangantujuan_id', CHtml::listData(RuanganM::model()->findAll(array('order' => 'ruangan_nama')), 'ruangan_id', 'ruangan_nama'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)",
            //'empty' => '-- Pilih --',));
            ?>
        </div>
    </div> -->
    <div class="form-actions">
        <?php echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
            array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
        ); ?>
        <?php echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
            array(
                'title' => 'Ulang', 'class' => 'btn btn-default', 'type' => 'reset',
                'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
            )
        ); ?>
    </div>
    <?php $this->endWidget(); ?>
</div>
<script>
    function resetForm() {
        setTimeout(function() {
            $('#search-laporan').submit();
        }, 500);
    }
</script>
<?php $this->renderPartial('_jsFunctions', array('model' => $model)); ?>