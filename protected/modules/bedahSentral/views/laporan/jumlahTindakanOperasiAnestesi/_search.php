<div class="search-form">
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'type' => 'horizontal',
        'id' => 'laporan-search',
        'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
    ));

    $format = new MyFormatter();
    ?>

    <?php //echo CHtml::hiddenField('type', ''); 
    ?>
    <?php //echo CHtml::hiddenField('src', ''); 
    ?>
    <div class="row">
        <div class="col-sm-6">
            <?php echo CHtml::hiddenField('type', ''); ?>
            <div class="control-group">
                <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'span2')); ?>
                <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'span2')); ?>
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
            echo CHtml::hiddenField('filter', 'carabayar', array('disabled' => 'disabled')) .
                '
                <div class="control-group">
                    ' . CHtml::label('Dokter Operator', 'dokteranastesi_id', array('class' => 'control-label')) . ' 
                    <div class="controls">												 
                        ' . $form->dropDownList(
                    $model,
                    'dokteranastesi_id',
                    CHtml::listData($model->getDokterItems(Yii::app()->user->getState('ruangan_id')), 'pegawai_id', 'namaLengkap'),
                    array('class' => 'form-control', 'multiple' => 'multiple')
                ) . '
                    </div>
                </div>';

            // $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
            //     'id' => 'instalasi',
            //     'slide' => true,
            //     'content' => array(
            //         'content4' => array(
            //             'multi' => 'multi',
            //             'header' => 'Berdasarkan Dokter Anastesi',
            //             'isi' => CHtml::hiddenField('filter', 'carabayar', array('disabled' => 'disabled')) .
            //                 '
			// 					<div class="control-group">
			// 						' . CHtml::label('Dokter Operator', 'dokteranastesi_id', array('class' => 'control-label')) . ' 
			// 						<div class="controls">												 
			// 							' . $form->dropDownList(
            //                     $model,
            //                     'dokteranastesi_id',
            //                     CHtml::listData($model->getDokterItems(Yii::app()->user->getState('ruangan_id')), 'pegawai_id', 'namaLengkap'),
            //                     array('class' => 'form-control', 'multiple' => 'multiple')
            //                 ) . '
			// 						</div>
			// 					</div>',
            //             'active' => true,
            //         ),
            //     ),
            // ));
            ?>
        </div>
    </div>
    <div class="row">

    </div>
    <div class="form-actions">
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
</div>

<?php
$this->endWidget();
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrintLembarPoli = Yii::app()->createUrl('print/lembarPoliRJ', array('pendaftaran_id' => ''));
?>

<?php //$this->renderPartial('_jsFunctions', array('model' => $model)); 
?>

<script>
    $(document).ready(function() {
        dropMulti('<?php echo CHtml::activeId($model, 'dokteranastesi_id') ?>');
    });
</script>