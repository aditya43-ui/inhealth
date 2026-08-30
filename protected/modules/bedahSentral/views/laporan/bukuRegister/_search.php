<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/dropCheck.css');

?>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-search"></i> Pencarian
        </div>
    </div>
    <div class="panel-body">
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
            <div class="row">
                <div class="col-sm-4">
                    <?php $format = new MyFormatter(); ?>

                    <?php echo CHtml::hiddenField('type', ''); ?>
                    <?php echo CHtml::label('Periode Laporan', 'tglpemeriksaan', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($model, 'jns_periode', array('hari' => 'Hari', 'bulan' => 'Bulan', 'tahun' => 'Tahun'), array('class' => 'span2', 'onchange' => 'ubahJnsPeriode();')); ?>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class='control-group hari'>
                        <?php echo CHtml::label('Dari Tanggal', 'dari_tanggal', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal); ?>
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'tgl_awal',
                                'mode' => 'date',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                    'maxDate' => 'd',
                                ),
                                'htmlOptions' => array(
                                    'readonly' => true, 'class' => "span2",
                                    'onkeypress' => "return $(this).focusNextInputField(event)"
                                ),
                            ));
                            ?>
                            <?php $model->tgl_awal = $format->formatDateTimeForDb($model->tgl_awal); ?>
                        </div>

                    </div>
                    <div class='control-group bulan'>
                        <?php echo CHtml::label('Dari Bulan', 'dari_tanggal', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php $model->bln_awal = $format->formatMonthForUser($model->bln_awal); ?>
                            <?php
                            $this->widget('MyMonthPicker', array(
                                'model' => $model,
                                'attribute' => 'bln_awal',
                                'options' => array(
                                    'dateFormat' => Params::MONTH_FORMAT,
                                ),
                                'htmlOptions' => array(
                                    'readonly' => true,
                                    'class' => "span2",
                                    'onkeypress' => "return $(this).focusNextInputField(event)"
                                ),
                            ));
                            ?>
                            <?php $model->bln_awal = $format->formatMonthForDb($model->bln_awal); ?>
                        </div>
                    </div>
                    <div class='control-group tahun'>
                        <?php echo CHtml::label('Dari Tahun', 'dari_tanggal', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            echo $form->dropDownList($model, 'thn_awal', CustomFunction::getTahun(null, null), array('class' => "span2", 'onkeypress' => "return $(this).focusNextInputField(event)"));
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class='control-group hari'>
                        <?php echo CHtml::label('Sampai Dengan', 'sampai_dengan', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php $model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir); ?>
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'tgl_akhir',
                                'mode' => 'date',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                    'maxDate' => 'd',
                                ),
                                'htmlOptions' => array(
                                    'readonly' => true, 'class' => "span2",
                                    'onkeypress' => "return $(this).focusNextInputField(event)"
                                ),
                            ));
                            ?>
                            <?php $model->tgl_akhir = $format->formatDateTimeForDb($model->tgl_akhir); ?>
                        </div>
                    </div>
                    <div class='control-group bulan'>
                        <?php echo CHtml::label('Sampai Dengan', 'sampai_dengan', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php $model->bln_akhir = $format->formatMonthForUser($model->bln_akhir); ?>
                            <?php
                            $this->widget('MyMonthPicker', array(
                                'model' => $model,
                                'attribute' => 'bln_akhir',
                                'options' => array(
                                    'dateFormat' => Params::MONTH_FORMAT,
                                ),
                                'htmlOptions' => array(
                                    'readonly' => true, 'class' => "span2",
                                    'onkeypress' => "return $(this).focusNextInputField(event)"
                                ),
                            ));
                            ?>
                            <?php $model->bln_akhir = $format->formatMonthForDb($model->bln_akhir); ?>
                        </div>
                    </div>
                    <div class='control-group tahun'>
                        <?php echo CHtml::label('Sampai Dengan', 'sampai_dengan', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            echo $form->dropDownList($model, 'thn_akhir', CustomFunction::getTahun(null, null), array('class' => "span2", 'onkeypress' => "return $(this).focusNextInputField(event)"));
                            ?>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <?php
                    $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                        'id' => 'big',
                        'slide' => true,
                        //                            'parent'=>false,
                        //                            'disabled'=>true,
                        //                            'accordion'=>false, //default
                        'content' => array(
                            'content2' => array(
                                'header' => 'Berdasarkan Wilayah',
                                'isi' => '<table><tr><td style="width: 130px;">' . CHtml::hiddenField('filter', 'wilayah') . '<label>Propinsi</label></td><td>' . $form->dropDownList($model, 'propinsi_id', CHtml::listData($model->getPropinsiItems(), 'propinsi_id', 'propinsi_nama'), array(
                                    'empty' => '-- Pilih --',
                                    'ajax' => array(
                                        'type' => 'POST',
                                        'url' => Yii::app()->createUrl('ActionDynamic/GetKabupaten', array('encode' => false, 'model_nama' => '' . $model->getNamaModel() . '')),
                                        'update' => '#' . CHtml::activeId($model, 'kabupaten_id') . ''
                                    ),
                                    'onkeypress' => "return $(this).focusNextInputField(event)",
                                    'onchange' => 'setClearKecamatan();setClearKelurahan();'
                                )) . '</td></tr><tr><td><label>Kabupaten</label></td><td>' .
                                    $form->dropDownList($model, 'kabupaten_id', array(), array(
                                        'empty' => '-- Pilih --',
                                        'ajax' => array(
                                            'type' => 'POST',
                                            'url' => Yii::app()->createUrl('ActionDynamic/GetKecamatan', array('encode' => false, 'model_nama' => '' . $model->getNamaModel() . '')),
                                            'update' => '#' . CHtml::activeId($model, 'kecamatan_id') . ''
                                        ),
                                        'onkeypress' => "return $(this).focusNextInputField(event)",
                                        'onchange' => 'setClearKelurahan();'
                                    )) . '</td></tr><tr><td><label>Kecamatan</label></td><td>'
                                    . $form->dropDownList($model, 'kecamatan_id', array(), array(
                                        'empty' => '-- Pilih --',
                                        'ajax' => array(
                                            'type' => 'POST',
                                            'url' => Yii::app()->createUrl('ActionDynamic/GetKelurahan', array('encode' => false, 'model_nama' => '' . $model->getNamaModel() . '')),
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
                        'id' => 'kunjungan',
                        'slide' => true,
                        'content' => array(
                            'content3' => array(
                                'header' => 'Berdasarkan Jenis Penjamin',
                                'isi' => '<table><tr>
                        <td style="width: 130px;">' . CHtml::hiddenField('filter', 'carabayar', array('disabled' => 'disabled')) . '<label>Jenis Penjamin</label></td>
                        <td>' . $form->dropDownList($model, 'carabayar_id', CHtml::listData($model->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama'), array(
                                    'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                    'ajax' => array(
                                        'type' => 'POST',
                                        'url' => Yii::app()->createUrl('ActionDynamic/GetPenjaminPasien', array('encode' => false, 'namaModel' => '' . $model->getNamaModel() . '')),
                                        'update' => '#' . CHtml::activeId($model, 'penjamin_id') . '', //selector to update
                                    ),
                                )) . '</td>
                            </tr><tr>
                        <td><label>Penjamin</label></td><td>' .
                                    $form->dropDownList($model, 'penjamin_id', CHtml::listData($model->getPenjaminItems(), 'penjamin_id', 'penjamin_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",)) . '</td></tr></table>',
                                'active' => true,
                            ),
                        ),
                    ));
                    ?>
                </div>

                <div class="col-sm-6">
                    <?php $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                        'id' => 'big',
                        'slide' => true,
                        'content' => array(
                            'content4' => array(
                                'header' => 'Berdasarkan Instalasi dan Ruangan',
                                'isi' => '<table>
                                            <tr>
                                                    <td style="width: 130px;">' . CHtml::hiddenField('filter', 'carabayar', array('disabled' => 'disabled')) . '<label>Instalasi</label></td>
                                                    <td>' . $form->dropDownList($model, 'instalasiasal_id', CHtml::listData(InstalasiM::model()->findAll('instalasi_aktif = true ORDER BY instalasi_nama ASC'), 'instalasi_id', 'instalasi_nama'), array(
                                    'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                    'ajax' => array(
                                        'type' => 'POST',
                                        'url' => $this->createUrl('/ActionDynamic/GetRuangAslForDropCheck/', array('encode' => false, 'namaModel' => '' . get_class($model) . '')),
                                        'update' => '#checkboxes3',  //selector to update
                                    ),
                                )) . '
                                                </td>
                                        </tr>
                                        <tr>
                                                <td>
                                                        <label>Ruangan</label>
                                                </td>
                                                <td>
                                                        <div class="multiselect" id="multiselect3">
                                                        <div class="selectBox" onclick="showCheckboxes3();">
                                                            <select id = "dropRuangan">
                                                                <option>-- Pilih --</option>
                                                            </select>
                                                            <div class="overSelect"></div>
                                                        </div>
                                                        <div class="checkboxes" id="checkboxes3">
                                                            ' . $form->checkBoxList($model, 'ruanganasal_id', array(), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",)) . '
                                                        </div>
                                                </td>
                                        </tr>
                                    </table>',
                                'active' => true
                            ),
                        ),
                        //                                    'htmlOptions'=>array('class'=>'aw',)
                    )); ?>

                    <?php
                    $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                        'id' => 'kunjungan5',
                        'content' => array(
                            'content5' => array(
                                'header' => 'Opsi Grafik',
                                'isi' =>  '<table>
                                        <tr>
                                            <td style="width: 120px;">' . CHtml::radioButton('tampilGrafik', true, array('name' => 'dataGrafik', 'value' => 'instalasiasal', 'id' => 'instalasiasal')) . ' <label for="instalasiasal">Instalasi Asal</label></td>
											<td>' . CHtml::radioButton('tampilGrafik', false, array('name' => 'dataGrafik', 'value' => 'ruanganasal', 'id' => 'ruanganasal')) . ' <label for="ruanganasal">Ruangan Asal</label></td>
                                        </tr>
                                        <tr>
                                            <td>' . CHtml::radioButton('tampilGrafik', false, array('name' => 'dataGrafik', 'value' => 'wilayah', 'id' => 'wilayah')) . ' <label for="wilayah">Wilayah</label></td>
											<td>' . CHtml::radioButton('tampilGrafik', false, array('name' => 'dataGrafik', 'value' => 'carabayar', 'id' => 'carabayar')) . ' <label for="carabayar">Jenis Penjamin</label></td>
                                        </tr>
										<tr>                                            
											<td>' . CHtml::radioButton('tampilGrafik', false, array('name' => 'dataGrafik', 'value' => 'penjamin', 'id' => 'penjamin')) . ' <label for="penjamin">Penjamin</label></td>
                                        </tr>
                                    </table>',
                                'active' => TRUE,
                            ),
                        ),
                        //                                    'htmlOptions'=>array('class'=>'aw',)
                    )); ?>
                </div>
            </div>

            <div class="form-actions">
                <?php echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                    array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan')
                ); ?>
                <?php echo CHtml::link(
                    Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                    Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''),
                    array(
                        'title' => 'Ulang',
                        'class' => 'btn btn-default',
                        'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = "' . Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . '') . '";}); return false;'
                    )
                ); ?>
            </div>
        </div>

        <?php
        $this->endWidget();
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrintLembarPoli = Yii::app()->createUrl('print/lembarPoliRJ', array('pendaftaran_id' => ''));
        ?>
        <script>
            function konfirmasi() {
                location.reload();
            }

            function setClearKecamatan() {
                $("#<?php echo CHtml::activeId($model, "kecamatan_id"); ?>").find('option').remove().end().append('<option value="">-- Pilih --</option>').val('');
            }

            function setClearKelurahan() {
                $("#<?php echo CHtml::activeId($model, "kelurahan_id"); ?>").find('option').remove().end().append('<option value="">-- Pilih --</option>').val('');
            }

            function checkAll() {
                if ($("#checkAllInstalasi").is(":checked")) {
                    $('#instalasi input[name*="ruanganasal_id"]').each(function() {
                        $(this).attr('checked', true);
                    })
                    //        myAlert('Checked');
                } else {
                    $('#instalasi input[name*="ruanganasal_id"]').each(function() {
                        $(this).removeAttr('checked');
                    })
                }

                if ($('#checkAllRuangan').is(':checked')) {
                    $('#searchLaporan input[name*="ruanganasal_id"]').each(function() {
                        $(this).attr('checked', true);
                    });
                } else {
                    $('#searchLaporan input[name*="ruanganasal_id"]').each(function() {
                        $(this).removeAttr('checked');
                    });
                }
            }

            checkAll();
        </script>
        <?php $this->renderPartial('_jsFunctions', array('model' => $model)); ?>

        <script>
            function showCheckboxes3() {
                $("#multiselect3").find("#checkboxes3").slideToggle('fast');
            }

            $(document).bind('click', function(e) {
                var $clicked = $(e.target);
                if (!$clicked.parents().hasClass("multiselect")) {
                    $("#checkboxes3").hide();
                }
            });
        </script>