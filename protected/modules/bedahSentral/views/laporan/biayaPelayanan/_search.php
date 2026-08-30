<div class="search-form">
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'type' => 'horizontal',
        'id' => 'searchLaporan',
        'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
    ));

    $format = new MyFormatter;
    ?>
    <style>
        #penjamin label.checkbox {
            width: 100px;
            display: inline-block;
        }
    </style>
    <div class="row">
        <div class="col-sm-6">
            <div class="control-group">
                <?php echo CHtml::hiddenField('type', ''); ?>
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
            <div id='searching'>
                <fieldset>
                    <?php
                    $cri = new CDbCriteria();
                    $cri->join = "JOIN kelasruangan_m kr ON kr.kelaspelayanan_id = t.kelaspelayanan_id";
                    $cri->addCondition(" t.kelaspelayanan_aktif = TRUE ");
                    $cri->addCondition(" kr.ruangan_id = '" . Yii::app()->user->getState('ruangan_id') . "' ");
                    $cri->order = "t.kelaspelayanan_nama ASC";

                    $kelas = KelaspelayananM::model()->findAll($cri);
                    ?>

                    <div class="control-group">
                        <label class="control-label">Kelas pelayanan</label>
                        <div class="controls">
                            <?php echo CHtml::checkBox('cek_all', true, array("id" => "checkSemuaid", 'value' => 'cek', "onclick" => "checkSemua()")) . '<label for="checkSemuaid">Pilih Semua</label><br>'; ?>
                            <?php echo $form->checkBoxList($model, 'kelaspelayanan_id', CHtml::listData($kelas, 'kelaspelayanan_id', 'kelaspelayanan_nama')); ?>
                        </div>
                    </div>

                    <?php
                    // $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                    //     'id' => 'kunjungan',
                    //     'slide' => true,
                    //     'content' => array(
                    //         'content2' => array(
                    //             'header' => 'Berdasarkan Kelas pelayanan',
                    //             'isi' => CHtml::checkBox('cek_all', true, array("id" => "checkSemuaid", 'value' => 'cek', "onclick" => "checkSemua()")) . '<label for="checkSemuaid">Pilih Semua</label><br>
                    //                         <table class="penjamin">                                            
                    //                         <tr>
                    //                                 <td>' .
                    //                 $form->checkBoxList($model, 'kelaspelayanan_id', CHtml::listData($kelas, 'kelaspelayanan_id', 'kelaspelayanan_nama'))
                    //                 . '</td>
                    //                         </tr>
                    //                         </table>',
                    //             'active' => true,
                    //         ),
                    //     ),
                    //     //                                    'htmlOptions'=>array('class'=>'aw',)
                    // ));
                    ?>
                </fieldset>
            </div>
        </div>

        <div class='col-md-6'>
            <div class="control-group">
                <label class="control-label">Filter</label>
                <div class="controls">
                    <?php
                    echo '<table>
                            <tr>
                                <td style="width: 120px;">' . CHtml::radioButton('tampilGrafik', true, array('name' => 'dataGrafik', 'value' => 'kelaspelayanan', 'id' => 'rkelaspelayanan',)) . ' <label for="rkelaspelayanan">Kelas Pelayanan</label></td>                                               
                                <td>' . CHtml::radioButton('tampilGrafik', false, array('name' => 'dataGrafik', 'value' => 'carabayar', 'id' => 'rcarabayar',)) . ' <label for="rcarabayar">Jenis Penjamin</label></td>                                               
                            </tr>                                        										
                        </table>';
                    ?>
                </div>
            </div>

            <?php
            // $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
            //     'id' => 'kunjungan5',
            //     'slide' => true,
            //     'content' => array(
            //         'content5' => array(
            //             'header' => 'Opsi Grafik',
            //             'isi' => '<table>
            //                             <tr>
            //                                 <td style="width: 120px;">' . CHtml::radioButton('tampilGrafik', true, array('name' => 'dataGrafik', 'value' => 'kelaspelayanan', 'id' => 'rkelaspelayanan',)) . ' <label for="rkelaspelayanan">Kelas Pelayanan</label></td>                                               
            // 								<td>' . CHtml::radioButton('tampilGrafik', false, array('name' => 'dataGrafik', 'value' => 'carabayar', 'id' => 'rcarabayar',)) . ' <label for="rcarabayar">Jenis Penjamin</label></td>                                               
            //                             </tr>                                        										
            //                         </table>',
            //             'active' => TRUE,
            //         ),
            //     ),
            //     //                                    'htmlOptions'=>array('class'=>'aw',)
            // ));
            ?>

            <div class="control-group">
                <?php echo CHtml::hiddenField('filter', 'carabayar', array('disabled' => 'disabled')); ?>
                <label class="control-label">Jenis Penjamin</label>
                <div class="controls">
                    <?php echo $form->dropDownList($model, 'carabayar_id', CHtml::listData($model->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama'), array(
                        'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                        'ajax' => array(
                            'type' => 'POST',
                            'url' => Yii::app()->createUrl('ActionDynamic/GetPenjaminPasien', array('encode' => false, 'namaModel' => '' . $model->getNamaModel() . '')),
                            'update' => '#' . CHtml::activeId($model, 'penjamin_id') . '', //selector to update
                        ),
                    )); ?>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Penjamin</label>
                <div class="controls">
                    <?php echo $form->dropDownList($model, 'penjamin_id', CHtml::listData($model->getPenjaminItems(), 'penjamin_id', 'penjamin_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?>
                </div>
            </div>

            <?php
            // $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
            //     'id' => 'kunjungana',
            //     'slide' => true,
            //     'content' => array(
            //         'content22' => array(
            //             'header' => 'Berdasarkan Jenis Penjamin',
            //             'isi' => '<table><tr>
            //     <td>' . CHtml::hiddenField('filter', 'carabayar', array('disabled' => 'disabled')) . '<label>Jenis Penjamin</label></td>
            //     <td>' . $form->dropDownList($model, 'carabayar_id', CHtml::listData($model->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama'), array(
            //                 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
            //                 'ajax' => array(
            //                     'type' => 'POST',
            //                     'url' => Yii::app()->createUrl('ActionDynamic/GetPenjaminPasien', array('encode' => false, 'namaModel' => '' . $model->getNamaModel() . '')),
            //                     'update' => '#' . CHtml::activeId($model, 'penjamin_id') . '', //selector to update
            //                 ),
            //             )) . '</td>
            //         </tr><tr>
            //     <td><label>Penjamin</label></td><td>' .
            //                 $form->dropDownList($model, 'penjamin_id', CHtml::listData($model->getPenjaminItems(), 'penjamin_id', 'penjamin_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",)) . '</td></tr></table>',
            //             'active' => true,
            //         ),
            //     ),
            // ));
            ?>
        </div>
    </div>

    <div class="form-actions">
        <?php
        echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
            array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan', 'onclick' => 'pilihPencarian();')
        );
        ?>
        <?php
        echo CHtml::link(
            Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
            Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''),
            array(
                'title' => 'Ulang',
                'class' => 'btn btn-default',
                'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = "' . Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . '') . '";}); return false;'
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

<?php Yii::app()->clientScript->registerScript('cekAll', '
  $("#big").find("input").attr("checked", "checked");
  $("#kelasPelayanan").find("input").attr("checked", "checked");
', CClientScript::POS_READY);
?>

<script>
    function checkAll() {
        if ($("#checkAllKelas").is(":checked")) {
            $('#kelasPelayanan input[name*="kelaspelayanan_id"]').each(function() {
                $(this).attr('checked', true);
            })
        } else {
            $('#kelasPelayanan input[name*="kelaspelayanan_id"]').each(function() {
                $(this).removeAttr('checked');
            })
        }

        if ($("#checkAllCaraBayar").is(":checked")) {
            $('#penjamin input[name*="penjamin_id"]').each(function() {
                $(this).attr('checked', true);
            })
        } else {
            $('#penjamin input[name*="penjamin_id"]').each(function() {
                $(this).removeAttr('checked');
            })
        }
    }

    function konfirmasi() {
        location.reload();
    }

    function pilihPencarian() {
        //var idCaraBayar = parseFloat($('#BSLaporanbiayapelayanan_carabayar_id').val());
        //if (!jQuery.isNumeric(idCaraBayar)) {
        //   myAlert('Silakan pilih cara bayar terlebih dahulu!')
        //  return false;
        // } else {
        //   $('#searchLaporan').submit();
        // }
    }

    function checkSemua() {
        if ($("#checkSemuaid").is(":checked")) {
            $('.penjamin input[name*="BSLaporanbiayapelayanan"]').each(function() {
                $(this).attr('checked', true);
            })
        } else {
            $('.penjamin input[name*="BSLaporanbiayapelayanan"]').each(function() {
                $(this).removeAttr('checked');
            })
        }
        //setAll();
    }
</script>
<?php $this->renderPartial('_jsFunctions', array('model' => $model)); ?>