<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'type' => 'horizontal',
    'id' => 'searchLaporan',
    'focus' => '#BKLaporankunjunganPasien_instalasi_id',
    'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
));
?>

<div class="row">
    <div class="col-sm-6">
        <?php //$format = new MyFormatter(); 
        ?>
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
        <div class="control-group">
            <label class="control-label">Filter</label>
            <div class="controls">
                <?php echo $form->radioButtonList($model, 'pilihanx', $model::berdasarkanStatus(), array('value' => 'pengunjung', 'inline' => true, 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <?php
        echo CHtml::hiddenField('filter', 'instalasi_id', array('disabled' => 'disabled')) .
            '<div class="control-group">
                ' . CHtml::label('Instalasi', 'instalasi_id', array('class' => 'control-label')) . ' 
                <div class="controls">
                    ' . $form->dropDownList($model, 'instalasi_id', CHtml::listData(InstalasiM::model()->findAll(array(
                'condition' => '(instalasi_id in (2,3,4) or (instalasirujukaninternal = true and revenuecenter = true and instalasi_id <> 7)) and instalasi_aktif = true',
                'order' => 'instalasi_id'
            )), 'instalasi_id', 'instalasi_nama'), array(
                'class' => 'form-control', 'multiple' => 'multiple'
            )) . '
                </div>
            </div>';
        ?>
        <?php
        echo '<div class="control-group">
        ' . CHtml::label('Ruangan', 'ruangan_id', array('class' => 'control-label')) . ' 
        <div class="controls">												 
            ' . $form->dropDownList(
            $model,
            'ruangan_id',
            array(),
            array('class' => 'form-control', 'multiple' => 'multiple')
        ) . '
        </div>
    </div>';
        ?>
    </div>
</div>
<!--<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <div id='searching'>
                <?php
                $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                    'id' => 'instalasi',
                    'slide' => true,
                    'content' => array(
                        'content2' => array(
                            'multi' => 'multi',
                            'header' => 'Berdasarkan Wilayah',
                            'isi' => CHtml::hiddenField('filter', 'instalasi_id', array('disabled' => 'disabled')) .
                                '<div class="control-group">
                                        ' . CHtml::label('Instalasi', 'instalasi_id', array('class' => 'control-label')) . ' 
                                        <div class="controls">
                                            ' . $form->dropDownList($model, 'instalasi_id', CHtml::listData(InstalasiM::model()->findAll(array(
                                    'condition' => '(instalasi_id in (2,3,4) or (instalasirujukaninternal = true and revenuecenter = true and instalasi_id <> 7)) and instalasi_aktif = true',
                                    'order' => 'instalasi_id'
                                )), 'instalasi_id', 'instalasi_nama'), array(
                                    'class' => 'form-control', 'multiple' => 'multiple'
                                )) . '
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        ' . CHtml::label('Ruangan', 'ruangan_id', array('class' => 'control-label')) . ' 
                                        <div class="controls">												 
                                            ' . $form->dropDownList(
                                    $model,
                                    'ruangan_id',
                                    array(),
                                    array('class' => 'form-control', 'multiple' => 'multiple')
                                ) . '
                                        </div>
                                    </div>',
                            'active' => true,
                        ),
                    ),
                ));
                ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <div id='searching'>
                <?php
                $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                    'id' => 'kunjungan',
                    'slide' => true,
                    //                                    'parent'=>false,
                    //                                    'disabled'=>true,
                    //                                    'accordion'=>false, //default
                    'content' => array(
                        'content3' => array(
                            'header' => 'Jenis Pengunjung/Kunjungan',
                            'isi' => '<table>
                                            <tr>
                                            <td>' .
                                $form->radioButtonList($model, 'pilihanx', $model::berdasarkanStatus(), array('value' => 'pengunjung', 'inline' => true, 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")) . '</td></tr></table>',
                            'active' => true,
                        ),
                    ),
                    //                                    'htmlOptions'=>array('class'=>'aw',)
                ));
                ?>
            </div>
        </div>
    </div>
</div>-->

<div class="form-actions">
    <?php
    echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan')
    );
    ?>
    <?php
    echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        array('title' => 'Ulang', 'class' => 'btn btn-default', 'onclick' => 'konfirmasi()', 'onKeypress' => 'return formSubmit(this,event)')
    );
    ?>
</div>

<?php
$this->endWidget();
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
?>
<?php $this->renderPartial('_jsFunctions', array('model' => $model)); ?>