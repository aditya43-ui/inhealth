<div class="search-form">
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'type' => 'horizontal',
        'id' => 'searchLaporan',
        'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
    ));
    ?>

    <div class="row">
        <div class="col-sm-6">
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

            <?php
            echo '<div class="control-group">'
                . CHtml::hiddenField('filter', 'carabayar', array('disabled' => 'disabled')) . '<label class="control-label">Jenis Penjamin</label><div class="controls">'
                . $form->dropDownList($model, 'carabayar_id', CHtml::listData($model->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama'), array(
                    'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                    'ajax' => array(
                        'type' => 'POST',
                        'url' => $this->createUrl('GetPenjaminPasien', array('encode' => false, 'namaModel' => '' . $model->getNamaModel() . '')),
                        'update' => '#' . CHtml::activeId($model, 'penjamin_id') . '', //selector to update
                    ),
                )) . '</div></div>';

            echo '<div class="control-group"><label class="control-label">Penjamin</label><div class="controls">' .
                $form->dropDownList($model, 'penjamin_id', CHtml::listData($model->getPenjaminItems(), 'penjamin_id', 'penjamin_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",)) . '</div></div>';
            ?>
        </div>

        <div class="col-sm-6">
            <div id='searching'>
                <?php
                echo '<div class="control-group">'
                    . CHtml::hiddenField('filter', 'wilayah') . '<label class="control-label">Propinsi</label><div class="controls">' . $form->dropDownList($model, 'propinsi_id', CHtml::listData($model->getPropinsiItems(), 'propinsi_id', 'propinsi_nama'), array(
                        'empty' => '-- Pilih --',
                        'ajax' => array(
                            'type' => 'POST',
                            'url' => $this->createUrl('GetKabupaten', array('encode' => false, 'namaModel' => '' . $model->getNamaModel() . '')),
                            'update' => '#' . CHtml::activeId($model, 'kabupaten_id') . ''
                        ),
                        'onkeypress' => "return $(this).focusNextInputField(event)"
                    )) . '</div></div>'
                    . '<div class="control-group"><label class="control-label">Kabupaten</label><div class="controls">' .
                    $form->dropDownList($model, 'kabupaten_id', array(), array(
                        'empty' => '-- Pilih --',
                        'ajax' => array(
                            'type' => 'POST',
                            'url' => $this->createUrl('GetKecamatan', array('encode' => false, 'namaModel' => '' . $model->getNamaModel() . '')),
                            'update' => '#' . CHtml::activeId($model, 'kecamatan_id') . ''
                        ),
                        'onkeypress' => "return $(this).focusNextInputField(event)"
                    )) . '</div></div>'
                    . '<div class="control-group"><label class="control-label">Kecamatan</label><div class="controls">'
                    . $form->dropDownList($model, 'kecamatan_id', array(), array(
                        'empty' => '-- Pilih --',
                        'class' => 'span3',
                        'ajax' => array(
                            'type' => 'POST',
                            'url' => $this->createUrl('GetKelurahan', array('encode' => false, 'namaModel' => '' . $model->getNamaModel() . '')),
                            'update' => '#' . CHtml::activeId($model, 'kelurahan_id') . ''
                        ),
                        'onkeypress' => "return $(this).focusNextInputField(event)"
                    )) . '</div></div>'
                    . '<div class="control-group"><label class="control-label">Kelurahan</label><div class="controls">' .
                    $form->dropDownList($model, 'kelurahan_id', array(), array(
                        'empty' => '-- Pilih --',
                        'class' => 'span3',
                        'onkeypress' => "return $(this).focusNextInputField(event)"
                    )) . '</div></div>';
                ?>
            </div>
        </div>
    </div>

    <div class="form-actions">
        <?php
        echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
            array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan')
        );
        ?>
        <?php
        echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''), array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'window.parent.myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        ));
        ?>
    </div>

</div>
<?php
$this->endWidget();
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrintLembarPoli = Yii::app()->createUrl('print/lembarPoliRJ', array('pendaftaran_id' => ''));
?>
<?php $this->renderPartial('_jsFunctions', array('model' => $model)); ?>