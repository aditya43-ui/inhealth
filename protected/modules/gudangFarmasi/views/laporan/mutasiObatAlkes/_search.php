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
        <div class="col-sm-6">
            <?php
            echo CHtml::hiddenField('filter', 'jenisobatalkes_id', array('disabled' => 'disabled')) .
                '<div class="control-group">
                    ' . CHtml::label('Ruangan Asal', 'jenisobatalkes_id', array('class' => 'control-label')) . ' 
                    <div class="controls">
                        ' . $form->dropDownList($model, 'ruanganasal_id', CHtml::listData(RuanganM::model()->findAll(), 'ruangan_id', 'ruangan_nama'), array(
                    'class' => 'form-control', 'multiple' => 'multiple', 'disabled' => true, 'options' => array(Yii::app()->user->getState('ruangan_id') => array('selected' => true))
                )) . '
                    </div>
                </div>'
            ?>
        </div>
        <div class="col-sm-6">
            <?php echo $form->textFieldRow($model, 'nomutasioa', array('placeholder' => 'No. Mutasi', 'class' => 'numberOnly')); ?>
        </div>
    </div>
    <!--<div class="row">
        <div class="col-sm-6">-->
    <?php
    // $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
    //     'id' => 'ruanganasal',
    //     'slide' => true,
    //     'content' => array(
    //         'content2' => array(
    //             'multi' => 'multi',
    //             'header' => 'Berdasarkan Ruangan Asal',
    //             'isi' => CHtml::hiddenField('filter', 'jenisobatalkes_id', array('disabled' => 'disabled')) .
    //                 '<div class="control-group">
    //                         ' . CHtml::label('Ruangan Asal', 'jenisobatalkes_id', array('class' => 'control-label')) . ' 
    //                         <div class="controls">
    //                             ' . $form->dropDownList($model, 'ruanganasal_id', CHtml::listData(RuanganM::model()->findAll(), 'ruangan_id', 'ruangan_nama'), array(
    //                     'class' => 'form-control', 'multiple' => 'multiple', 'disabled' => true, 'options' => array(Yii::app()->user->getState('ruangan_id') => array('selected' => true))
    //                 )) . '
    //                         </div>
    //                     </div>',
    //             'active' => true,
    //         ),
    //     ),
    // ));
    ?>
    <?php //echo $form->dropDownListRow($model, 'ruanganasal_id', CHtml::listData(RuanganM::model()->findAll(), 'ruangan_id', 'ruangan_nama'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)",
    //'empty' => '-- Pilih --', 'disabled' => true, 'options' => array(Yii::app()->user->getState('ruangan_id') => array('selected' => true))));
    ?>
    <!--</div>
    </div>-->
    <div class="form-actions">
        <?php echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
            array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
        ); ?>
        <?php echo CHtml::link(
            Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
            $this->createUrl('laporanMutasiObatAlkes'),
            array(
                'title' => 'Ulang',
                'class' => 'btn btn-default',
                'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
            )
        ); ?>
        <?php //echo CHtml::htmlButton(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), array('class' => 'btn btn-default', 'type' => 'reset')); 
        ?>
    </div>
    <?php $this->endWidget(); ?>
</div>
<?php $this->renderPartial($this->path_view_gudang . '_jsFunctions', array('model' => $model)); ?>