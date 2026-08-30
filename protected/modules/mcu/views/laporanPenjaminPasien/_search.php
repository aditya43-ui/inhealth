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
    <style>
        table {
            margin-bottom: 0;
        }

        .form-actions {
            padding: 4px;
            margin-top: 5px;
        }

        .nav-tabs>li>a {
            display: block;
            cursor: pointer;
        }

        .nav-tabs>.active a:hover {
            cursor: pointer;
        }
    </style>
    <table style="width: 100%; border: none;">
        <tr>
            <td>
                <div class="col-sm-6">
                    <fieldset class="">
                        <?php echo CHtml::hiddenField('type', ''); ?>
                        <?php //echo CHtml::hiddenField('src', ''); 
                        ?>
                        <div class="control-group">
                            <div class='control-label'>Tanggal Kunjungan</div>
                            <div class="controls">
                                <?php
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $model,
                                    'attribute' => 'tgl_awal',
                                    'mode' => 'date',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                    ),
                                    'htmlOptions' => array(
                                        'readonly' => true,
                                        'onkeypress' => "return $(this).focusNextInputField(event)"
                                    ),
                                ));
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Sampai dengan', 'Sampai dengan', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $model,
                                    'attribute' => 'tgl_akhir',
                                    'mode' => 'date',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                    ),
                                    'htmlOptions' => array(
                                        'readonly' => true,
                                        'onkeypress' => "return $(this).focusNextInputField(event)"
                                    ),
                                ));
                                ?>
                            </div>
                        </div>
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    <i class="fas fa-chart-bar"></i> Grafik Pengunjung/Kunjungan
                                </div>
                            </div>

                            <div class="panel-body">
                                <div id='searching'>
                                    <?php echo '<table>
                            <tr>
                                <td>' .
                                        $form->radioButtonList($model, 'pilihanx', $model::berdasarkanStatus(), array('value' => 'pengunjung', 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")) . ''
                                        . '</td></tr></table>';
                                    ?>
                                </div>
                            </div>
                        </div>

                </div>
                </fieldset>
</div>
<div class="col-sm-6">
    <div id='searching'>
        <fieldset>
            <?php
            $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                'id' => 'form-1',
                'content' => array(
                    'content1' => array(
                        'header' => 'Berdasarkan Wilayah',
                        'isi' => '<table><tr><td>' . CHtml::hiddenField('filter', 'wilayah') . '<label>Propinsi</label></td><td>' . $form->dropDownList($model, 'propinsi_id', CHtml::listData($model->getPropinsiItems(), 'propinsi_id', 'propinsi_nama'), array(
                            'empty' => '-- Pilih --',
                            'ajax' => array(
                                'type' => 'POST',
                                'url' => Yii::app()->createUrl('ActionDynamic/GetKabupaten', array('multiple' => 'multiple', 'encode' => false, 'namaModel' => '' . $model->getNamaModel() . '')),
                                'update' => '#' . CHtml::activeId($model, 'kabupaten_id') . ''
                            ),
                            'onkeypress' => "return $(this).focusNextInputField(event)"
                        )) . '</td></tr><tr><td><label>Kabupaten</label></td><td>' .
                            $form->dropDownList($model, 'kabupaten_id', array(), array(
                                'empty' => '-- Pilih --',
                                'ajax' => array(
                                    'type' => 'POST',
                                    'url' => Yii::app()->createUrl('ActionDynamic/GetKecamatan', array('encode' => false, 'namaModel' => '' . $model->getNamaModel() . '')),
                                    'update' => '#' . CHtml::activeId($model, 'kecamatan_id') . ''
                                ),
                                'onkeypress' => "return $(this).focusNextInputField(event)"
                            )) . '</td></tr><tr><td><label>Kabupaten</label></td><td>'
                            . $form->dropDownList($model, 'kecamatan_id', array(), array(
                                'empty' => '-- Pilih --',
                                'ajax' => array(
                                    'type' => 'POST',
                                    'url' => Yii::app()->createUrl('ActionDynamic/GetKelurahan', array('encode' => false, 'namaModel' => '' . $model->getNamaModel() . '')),
                                    'update' => '#' . CHtml::activeId($model, 'kelurahan_id') . ''
                                ),
                                'onkeypress' => "return $(this).focusNextInputField(event)"
                            )) . '</td></tr><tr><td><label>Kelurahan</label></td><td>' .
                            $form->dropDownList($model, 'kelurahan_id', array(), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")) . '</td></tr></table>',
                        'active' => true,
                    ),
                ),
            ));
            ?>
            <?php
            $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                'id' => 'form-2',
                'content' => array(
                    'content2' => array(
                        'header' => 'Berdasarkan Jenis Penjamin',
                        'isi' => '<table><tr>
                                                                                                                    <td>' . CHtml::hiddenField('filter', 'carabayar', array('disabled' => 'disabled')) . '<label>Jenis Penjamin</label></td>
                                                                                                                    <td>' . $form->dropDownList($model, 'carabayar_id', CHtml::listData($model->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama'), array(
                            'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                            'ajax' => array(
                                'type' => 'POST',
                                'url' => $this->createUrl('SetDropdownPenjaminPasien', array('encode' => false, 'namaModel' => get_class($model))),
                                'success' => 'function(data){$("#' . CHtml::activeId($model, "penjamin_id") . '").html(data);}',
                            ),
                            'class' => 'span3',
                        )) . '</td>
                                                                                                                            </tr><tr>
                                                                                                                    <td><label>Penjamin</label></td><td>' .
                            $form->dropDownList($model, 'penjamin_id', CHtml::listData($model->getPenjaminItems($model->carabayar_id), 'penjamin_id', 'penjamin_nama'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3')) . '</td></tr></table>',
                        'active' => false,
                    ),
                ),
            ));
            ?>
        </fieldset>
    </div>
</div>
<div class="clear"></div>



<div class="form-actions">
    <?php
    echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'ajax' => array(
        'type' => 'GET',
        'url' => array("/" . $this->route),
        'update' => '#tableLaporan',
        'beforeSend' => 'function(){
								 $("#tableLaporan").addClass("animation-loading");
							 }',
        'complete' => 'function(){
								 $("#tableLaporan").removeClass("animation-loading");
							 }',
    )));
    ?>
    <?php
    echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''), array(
        'class' => 'btn btn-default',
        'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
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