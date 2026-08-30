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
        <div class="col-sm-12">
            <!--<fieldset class="">-->
            <?php echo CHtml::hiddenField('type', ''); ?>
            <?php //echo CHtml::hiddenField('src', ''); 
            ?>

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
            <div class="control-group">
                <label class="control-label" for="propinsi_id">Propinsi</label>
                <div class="controls">
                    <?php
                    echo $form->dropDownList($model, 'propinsi_id', CHtml::listData($model->getPropinsiItems(), 'propinsi_id', 'propinsi_nama'), array(
                        'multiple' => 'multiple', 'placeholder' => '-- Pilih --',
                        'ajax' => array(
                            'type' => 'POST',
                            'url' => Yii::app()->createUrl('ActionDynamic/GetKabupaten', array('encode' => false, 'namaModel' => '' . $model->getNamaModel() . '')),
                            'update' => '#' . CHtml::activeId($model, 'kabupaten_id') . ''
                        ),
                        'onkeypress' => "return $(this).focusNextInputField(event)"
                    )); ?>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="kabupaten_id">Kabupaten</label>
                <div class="controls">
                    <?php
                    echo $form->dropDownList($model, 'kabupaten_id', array(), array(
                        'multiple' => 'multiple', 'placeholder' => '-- Pilih --',
                        'ajax' => array(
                            'type' => 'POST',
                            'url' => Yii::app()->createUrl('ActionDynamic/GetKecamatan', array('encode' => false, 'namaModel' => '' . $model->getNamaModel() . '')),
                            'update' => '#' . CHtml::activeId($model, 'kecamatan_id') . ''
                        ),
                        'onkeypress' => "return $(this).focusNextInputField(event)"
                    )); ?>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="kecamatan_id">Kecamatan</label>
                <div class="controls">
                    <?php
                    echo $form->dropDownList($model, 'kecamatan_id', array(), array(
                        'multiple' => 'multiple', 'placeholder' => '-- Pilih --',
                        'ajax' => array(
                            'type' => 'POST',
                            'url' => Yii::app()->createUrl('ActionDynamic/GetKelurahan', array('encode' => false, 'namaModel' => '' . $model->getNamaModel() . '')),
                            'update' => '#' . CHtml::activeId($model, 'kelurahan_id') . ''
                        ),
                        'onkeypress' => "return $(this).focusNextInputField(event)"
                    )); ?>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="kelurahan_id">Kelurahan</label>
                <div class="controls">
                    <?php
                    echo $form->dropDownList($model, 'kelurahan_id', array(), array('multiple' => 'multiple', 'placeholder' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)"));
                    ?>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="control-group">
                <label class="control-label" for="carabayar_id">Jenis Penjamin</label>
                <div class="controls">
                    <?php
                    echo $form->dropDownList($model, 'carabayar_id', CHtml::listData($model->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama'), array(
                        'multiple' => 'multiple', 'placeholder' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                        'ajax' => array(
                            'type' => 'POST',
                            'url' => $this->createUrl('SetDropdownPenjaminPasien', array('encode' => false, 'namaModel' => get_class($model))),
                            'success' => 'function(data){$("#' . CHtml::activeId($model, "penjamin_id") . '").html(data);}',
                        ),
                        'class' => 'span3',
                    )); ?>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="penjamin_id">Penjamin</label>
                <div class="controls">
                    <?php
                    echo $form->dropDownList($model, 'penjamin_id', CHtml::listData($model->getPenjaminItems($model->carabayar_id), 'penjamin_id', 'penjamin_nama'), array('multiple' => 'multiple', 'placeholder' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3')); ?>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Filter</label>
                <div class="controls">
                    <?php
                    echo $form->radioButtonList($model, 'pilihanx', $model::berdasarkanStatus(), array('value' => 'pengunjung', 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)"));
                    ?>
                </div>
            </div>

        </div>

        <!--<div class="col-sm-6">
            <div id='searching'>
                <fieldset>
                    <?php
                    $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                        'id' => 'form-3',
                        'content' => array(
                            'content3' => array(
                                'header' => 'Grafik Kunjungan/Pengunjung',
                                'isi' => '<table><tr><td>' . $form->radioButtonList($model, 'pilihanx', $model::berdasarkanStatus(), array('value' => 'pengunjung', 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")) . '</td></tr></table>',
                                'active' => true,
                            ),
                        ),
                    ));
                    ?>
                </fieldset>
            </div>
        </div>-->
    </div>


    <div class="form-actions">
        <?php
        echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
            array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit', 'ajax' => array(
                'type' => 'GET',
                'url' => array("/" . $this->route),
                'update' => '#tableLaporan',
                'beforeSend' => 'function(){
								 $("#tableLaporan").addClass("animation-loading");
							 }',
                'complete' => 'function(){
								 $("#tableLaporan").removeClass("animation-loading");
							 }',
            ))
        );
        ?>
        <?php
        echo CHtml::link(
            Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
            Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''),
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
<?php $this->renderPartial($this->path_view_mcu . '_jsFunctions', array('model' => $model)); ?>