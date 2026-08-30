<?php
if (!empty($modTindakans)) {
    $this->renderPartial($this->path_view . '_cekvalidTindakanPasien', array('modTindakans' => $modTindakans, 'removeButton' => true));
} else {
?>
    <tr>
        <td rowspan="2">
            <?php
            if (!isset($removeButton)) {
                $removeButton = false;
            }
            echo CHtml::activeHiddenField($modTindakan, '[0]daftartindakan_id', array('readonly' => true, 'class' => 'inputFormTabel daftartindakan_id')) . CHtml::activeCheckBox($modTindakan, '[0]checklist', array('class' => 'checklist-tindakan', 'onclick' => 'setNol(this);', 'uncheckValue' => null));
            echo "<br><br>";

            if ($removeButton) {
                echo CHtml::link("<i class='icon-plus'></i>", '#', array('onclick' => 'addRowTindakan(this);return false;', 'rel' => 'tooltip', 'title' => 'Klik untuk menambah tindakan', 'data-placement' => 'right'));
                echo "<br><br>";
                echo CHtml::link("<i class='icon-minus'></i>", '#', array('onclick' => 'batalTindakan(this);return false;', 'rel' => 'tooltip', 'title' => 'Klik untuk membatalkan tindakan', 'data-placement' => 'right'));
            } else {
                echo CHtml::link("<i class='icon-plus'></i>", '#', array('onclick' => 'addRowTindakan(this);return false;', 'rel' => 'tooltip', 'title' => 'Klik untuk menambah tindakan', 'data-placement' => 'right'));
            }
            ?>
        </td>
        <td><?php echo CHtml::activeTextField($modTindakan, '[0]kategoriTindakanNama', array('readonly' => true, 'class' => 'inputFormTabel')) ?></td>
        <td><?php echo CHtml::activeTextField($modTindakan, '[0]kode_tindakan', array('readonly' => true, 'class' => 'inputFormTabel span2')) ?></td>
        <td><?php echo CHtml::activeHiddenField($modTindakan, '[0]daftartindakan_id', array('readonly' => true, 'class' => 'inputFormTabel daftartindakan_id')) ?>
            <?php $this->widget('MyJuiAutoComplete', array(
                'model' => $modTindakan,
                'attribute' => '[0]daftartindakanNama',
                //'name'=>'daftartindakan_nama',
                'source' => 'js: function(request, response) {
                                   $.ajax({
                                       url: "' . Yii::app()->createUrl('rawatInap/tindakanTRI/DaftarTindakan') . '",
                                       dataType: "json",
                                       data: {
                                           term: request.term,
                                           tipepaket_id: $("#RJTindakanPelayananT_0_tipepaket_id").val(),
                                           kelaspelayanan_id: $("#RJPendaftaranT_kelaspelayanan_id").val(),
                                           penjamin_id: $("#RJPendaftaranT_penjamin_id").val(),
                                       },
                                       success: function (data) {
                                               response(data);
                                       }
                                   })
                                }',
                'options' => array(
                    'showAnim' => 'fold',
                    'minLength' => 2,
                    'focus' => 'js:function( event, ui ) {
                            $(this).val( ui.item.label);
                            return false;
                        }',
                    'select' => 'js:function( event, ui ) {
                            setTindakan($(this), ui.item);
                            return false;
                        }',

                ),
                'tombolDialog' => array("idDialog" => 'dialogDaftarTindakanPaket', 'jsFunction' => "setDialog(this);"),
                'htmlOptions' => array('onkeypress' => "return $(this).focusNextInputField(event)",),
            )); ?>

            <?php echo CHtml::activeHiddenField($modTindakan, '[0]kelaspelayanan_id', array('readonly' => true, 'class' => 'inputFormTabel')) ?>
            <?php echo CHtml::activeHiddenField($modTindakan, '[0]subsidiasuransi_tindakan', array('readonly' => true, 'class' => 'inputFormTabel integer-decimal')) ?>
            <?php echo CHtml::activeHiddenField($modTindakan, '[0]subsidipemerintah_tindakan', array('readonly' => true, 'class' => 'inputFormTabel integer-decimal')) ?>
            <?php echo CHtml::activeHiddenField($modTindakan, '[0]subsisidirumahsakit_tindakan', array('readonly' => true, 'class' => 'inputFormTabel integer-decimal')) ?>
            <?php echo CHtml::activeHiddenField($modTindakan, '[0]iurbiaya_tindakan', array('readonly' => true, 'class' => 'inputFormTabel integer-decimal')) ?>
            <?php echo CHtml::activeHiddenField($modTindakan, '[0]keltindakanid', array('readonly' => true, 'class' => 'inputFormTabel')) ?>
        </td>
        <td><?php echo CHtml::activeTextField($modTindakan, '[0]qty_tindakan', array('onblur' => 'hitungSubtotal(this)', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'inputFormTabel span1 integer numbersOnly')) ?></td>
        <td><?php echo CHtml::activeDropDownList($modTindakan, '[0]satuantindakan', LookupM::getItems('satuantindakan'), array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'inputFormTabel span2')) ?></td>
        <td>
            <?php echo CHtml::activeHiddenField($modTindakan, '[0]persenCyto', array('readonly' => true, 'class' => 'inputFormTabel ineteger-decimal')) ?>
            <?php echo CHtml::activeDropDownList($modTindakan, '[0]cyto_tindakan', array('0' => 'Tidak', '1' => 'Ya'), array('onchange' => 'hitungCyto(this)', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'inputFormTabel span2')) ?>
        </td>
        <td>
            <?php echo CHtml::activeTextField($modTindakan, '[0]tarifcyto_tindakan', array('readonly' => true, 'class' => 'inputFormTabel span2 integer-decimal', 'style' => 'display: none;')) ?>
            <?php echo CHtml::activeTextField($modTindakan, '[0]tarif_satuan', array('readonly' => true, 'class' => 'inputFormTabel span2 integer-decimal')) ?>
        </td>
        <td>
            <?php echo CHtml::activeTextField($modTindakan, '[0]tarif_tindakan', array('readonly' => true, 'class' => 'inputFormTabel span2 integer-decimal')) ?>
        </td>
    </tr>
    <tr>
        <td>
            <div class="input-append"><?php
                                        // $modTindakan->tgl_tindakan = MyFormatter::formatDateTimeForUser($modTindakan->tgl_tindakan);
                                        echo CHtml::activeTextField($modTindakan, '[0]tgl_tindakan', array('readonly' => true, 'class' => 'tanggal dtPicker2 realtime', 'style' => 'float:left;', 'value' =>  MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s')))); ?><span class="add-on"><i class="entypo-calendar"></i><i class="icon-time"></i></span></div>
        </td>
        <td style="text-align: right;"><b>Pemeriksa :</b></td>
        <td colspan="6">
            <table style="margin:0;" class="list_pegawai_tindakan">
                <tr>
                    <td width="20px" style="background-color:transparent;border: 0;">
                        <?php echo CHtml::hiddenField('row', 0, array('readonly' => true, 'class' => 'span1')); ?>
                        <?php echo CHtml::link("<i class='icon-edit' title='Klik untuk merubah dokter / perawat / bidan'></i>", '#', array('id' => 'btnAddDokter_0', 'onclick' => 'addDokterLengkap(this);return false;')); ?>
                    </td>
                    <td style="background-color:transparent;border: 0;" width="250px">
                        <div id="tampilanDokterPemeriksa_0"><?php echo (empty($modTindakan->dokterpemeriksa1_id)) ? "" : "Dokter Pemeriksa : " . $modTindakan->dokterpemeriksa1Nama ?></div>
                    </td>
                    <td style="background-color:transparent;border: 0;"><?php echo CHtml::activeTextField($modTindakan, '[0]keterangantindakan', array('readonly' => false, 'class' => 'inputFormTabel span3', 'placeholder' => 'Keterangan Tindakan')) ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="background-color:transparent;border: 0;" width="250px">
                        <div id="tampilanDokterPemeriksa2_0"><?php echo (empty($modTindakan->dokterpemeriksa2_id)) ? "" : "Dokter Pemeriksa 2 : " . $modTindakan->dokterpemeriksa2Nama ?></div>
                    </td>
                </tr>
                <tr style="display:none" ;>
                    <td></td>
                    <td style="background-color:transparent;border: 0;">
                        <div id="tampilanDokterDelegasi_0"></div>
                    </td>
                </tr>
                <tr style="display:none" ;>
                    <td></td>
                    <td style="background-color:transparent;border: 0;">
                        <div id="tampilanDokterPendamping_0"></div>
                    </td>
                </tr>
                <tr style="display:none" ;>
                    <td></td>
                    <td style="background-color:transparent;border: 0;">
                        <div id="tampilanDokterAnastesi_0"></div>
                    </td>
                </tr>
                <tr style="display:none" ;>
                    <td></td>
                    <td style="background-color:transparent;border: 0;">
                        <div id="dokter6_0"></div>
                    </td>
                </tr>
                <tr style="display:none" ;>
                    <td></td>
                    <td style="background-color:transparent;border: 0;">
                        <div id="dokter7_0"></div>
                    </td>
                </tr>
                <tr style="display:none" ;>
                    <td></td>
                    <td style="background-color:transparent;border: 0;">
                        <div id="dokter8_0"></div>
                    </td>
                </tr>
                <tr style="display:none" ;>
                    <td></td>
                    <td style="background-color:transparent;border: 0;">
                        <div id="dokter9_0"></div>
                    </td>
                </tr>
                <tr style="display:none" ;>
                    <td></td>
                    <td style="background-color:transparent;border: 0;">
                        <div id="dokter10_0"></div>
                    </td>
                </tr>
                <tr style="display:none" ;>
                    <td></td>
                    <td style="background-color:transparent;border: 0;">
                        <div id="tampilanPerawat_0"></div>
                    </td>
                </tr>
                <tr style="display:none" ;>
                    <td></td>
                    <td style="background-color:transparent;border: 0;">
                        <div id="tampilanPerawat2_0"></div>
                    </td>
                </tr>
                <tr style="display:none" ;>
                    <td></td>
                    <td style="background-color:transparent;border: 0;">
                        <div id="tampilanBidan_0"></div>
                    </td>
                </tr>
                <tr style="display:none" ;>
                    <td></td>
                    <td style="background-color:transparent;border: 0;">
                        <div id="tampilanBidan2_0"></div>
                    </td>
                </tr>
                <tr style="display:none" ;>
                    <td></td>
                    <td style="background-color:transparent;border: 0;">
                        <div id="tampilanBidan3_0"></div>
                    </td>
                </tr>
                <tr style="display:none" ;>
                    <td></td>
                    <td style="background-color:transparent;border: 0;">
                        <div id="tampilanSuster_0"></div>
                    </td>
                </tr>
                <tr style="display:none" ;>
                    <td></td>
                    <td style="background-color:transparent;border: 0;">
                        <div id="tampilanSupir_0"></div>
                    </td>
                </tr>
            </table>

            <?php echo CHtml::activeHiddenField($modTindakan, '[0]dokterpemeriksa1_id', array('readonly' => true, 'class' => 'inputFormTabel')) ?>
            <?php echo CHtml::activeHiddenField($modTindakan, '[0]dokterpemeriksa2_id', array('readonly' => true, 'class' => 'inputFormTabel')) ?>
            <?php echo CHtml::activeHiddenField($modTindakan, '[0]dokterpendamping_id', array('readonly' => true, 'class' => 'inputFormTabel')) ?>
            <?php echo CHtml::activeHiddenField($modTindakan, '[0]dokteranastesi_id', array('readonly' => true, 'class' => 'inputFormTabel')) ?>

            <?php echo CHtml::activeHiddenField($modTindakan, '[0]dokter6_id', array('readonly' => true, 'class' => 'inputFormTabel')) ?>
            <?php echo CHtml::activeHiddenField($modTindakan, '[0]dokter7_id', array('readonly' => true, 'class' => 'inputFormTabel')) ?>
            <?php echo CHtml::activeHiddenField($modTindakan, '[0]dokter8_id', array('readonly' => true, 'class' => 'inputFormTabel')) ?>
            <?php echo CHtml::activeHiddenField($modTindakan, '[0]dokter9_id', array('readonly' => true, 'class' => 'inputFormTabel')) ?>
            <?php echo CHtml::activeHiddenField($modTindakan, '[0]dokter10_id', array('readonly' => true, 'class' => 'inputFormTabel')) ?>

            <?php echo CHtml::activeHiddenField($modTindakan, '[0]dokterdelegasi_id', array('readonly' => true, 'class' => 'inputFormTabel')) ?>
            <?php echo CHtml::activeHiddenField($modTindakan, '[0]bidan_id', array('readonly' => true, 'class' => 'inputFormTabel')) ?>
            <?php echo CHtml::activeHiddenField($modTindakan, '[0]bidan2_id', array('readonly' => true, 'class' => 'inputFormTabel')) ?>
            <?php echo CHtml::activeHiddenField($modTindakan, '[0]bidan3_id', array('readonly' => true, 'class' => 'inputFormTabel')) ?>
            <?php echo CHtml::activeHiddenField($modTindakan, '[0]suster_id', array('readonly' => true, 'class' => 'inputFormTabel')) ?>
            <?php echo CHtml::activeHiddenField($modTindakan, '[0]perawat_id', array('readonly' => true, 'class' => 'inputFormTabel')) ?>
            <?php echo CHtml::activeHiddenField($modTindakan, '[0]perawat2_id', array('readonly' => true, 'class' => 'inputFormTabel')) ?>
            <?php echo CHtml::activeHiddenField($modTindakan, '[0]supir_id', array('readonly' => true, 'class' => 'inputFormTabel')) ?>
        </td>
    </tr>
<?php } ?>