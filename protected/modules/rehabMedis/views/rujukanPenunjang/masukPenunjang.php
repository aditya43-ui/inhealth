<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'masukpenunjang-re-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    'focus' => '#',
)); ?>

<?php echo $form->errorSummary(array($modPenunjangSave, $modHasilPemeriksaan, $modTindakanPelayanan, $modTindakanKomponen)); ?>

<?php $this->renderPartial('_ringkasDataPasien', array('modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien)); ?>

<table style="width: 100%; border: none;">
    <tr>
        <td>
            <?php
            foreach ($modRiwayatKirimKeUnitLain as $i => $riwayat) {
                $modPermintaan = PermintaankepenunjangT::model()->with('daftartindakan', 'tindakanrm')->findAllByAttributes(array('pasienkirimkeunitlain_id' => $riwayat->pasienkirimkeunitlain_id));
                foreach ($modPermintaan as $j => $permintaan) {
                    $modTarif = TariftindakanM::model()->findByAttributes(array(
                        'kelaspelayanan_id' => $riwayat->kelaspelayanan_id,
                        'daftartindakan_id' => $permintaan->tindakanrm->daftartindakan_id,
                        'komponentarif_id' => Params::KOMPONENTARIF_ID_TOTAL
                    ));
                    $tarif[$i][$j] = (!empty($modTarif->harga_tariftindakan)) ? $modTarif->harga_tariftindakan : 0;
                    $persencyto[$i][$j] = (!empty($modTarif->persencyto_tind)) ? $modTarif->persencyto_tind : 0;
                }
                $arrInputPemeriksaan[$i] = $modPermintaan;
            }

            ?>
            <?php foreach ($modJenisTindakan as $i => $jenisTindakan) {
            ?>
                <div class="boxtindakan">
                    <h6><?php echo $jenisTindakan->jenistindakanrm_nama; ?></h6>
                    <?php foreach ($modTindakan as $j => $tindakanrm) {
                        $ceklist = (!empty($arrInputPemeriksaan)) ? cekPilihan($tindakanrm->tindakanrm_id, $arrInputPemeriksaan) : false;
                        if ($jenisTindakan->jenistindakanrm_id == $tindakanrm->jenistindakanrm_id) {
                            echo CHtml::checkBox("tindakan_id[]", $ceklist, array(
                                'value' => $tindakanrm->tindakanrm_id,
                                'onclick' => "inputperiksa(this)"
                            ));
                            echo "<span>" . $tindakanrm->tindakanrm_nama . "</span><br>";
                        }
                    } ?>
                </div>
            <?php } ?>
        </td>
        <td>
            <table id="tblFormTindakanRM" class="table table-condensed">
                <thead>
                    <tr>
                        <th>Jenis Tindakan/<br>Tindakan</th>
                        <th>Tarif</th>
                        <th>Jumlah</th>
                        <th>Satuan</th>
                        <th>Cyto</th>
                        <th>Tarif Cyto</th>
                    </tr>
                </thead>
                <?php
                if (!empty($arrInputPemeriksaan)) {
                    foreach ($arrInputPemeriksaan as $i => $itemPemeriksaan) {
                        foreach ($itemPemeriksaan as $j => $item) {
                ?>
                            <tr id="tindakan_<?php echo $item->tindakanrm_id; ?>">
                                <td>
                                    <?php echo CHtml::hiddenField("permintaanPenunjang[$i][idPasienKirimKeUnitLain]", $item->pasienkirimkeunitlain_id, array('class' => 'inputFormTabel lebar2', 'readonly' => true)); ?>
                                    <?php echo JenistindakanrmM::model()->findByPk($item->tindakanrm->jenistindakanrm_id)->jenistindakanrm_nama ?> /
                                    <?php echo $item->tindakanrm->tindakanrm_nama; ?>
                                    <?php echo CHtml::hiddenField("RMTindakanpelayananT[daftartindakan_id][]", $item->tindakanrm->daftartindakan_id, array('class' => 'inputFormTabel', 'readonly' => true)); ?>
                                    <?php echo CHtml::hiddenField("tindakanrm_id[]", $item->tindakanrm_id, array('class' => 'inputFormTabel', 'readonly' => true)); ?>
                                </td>
                                <td>
                                    <?php echo CHtml::textField("RMTindakanpelayananT[tarif_tindakan][]", $tarif[$i][$j], array('class' => 'inputFormTabel lebar3 currency', 'readonly' => true)); ?>
                                </td>
                                <td><?php echo CHtml::textField("RMTindakanpelayananT[qty_tindakan][]", $item->qtypermintaan, array('class' => 'inputFormTabel lebar1')); ?></td>
                                <td><?php echo CHtml::dropDownList("RMTindakanpelayananT[satuantindakan][]", 'KALI', LookupM::getItems('satuantindakan'), array('class' => 'inputFormTabel lebar3',)); ?></td>
                                <td>
                                    <?php echo CHtml::dropDownList("RMTindakanpelayananT[cyto_tindakan][]", '0', array('1' => 'Ya', '0' => 'Tidak'), array('class' => 'inputFormTabel lebar2-5', 'onchange' => 'hitungCyto(this)')); ?>
                                    <?php echo CHtml::hiddenField("RMTindakanpelayananT[persencyto_tind][]", $persencyto[$i][$j], array('class' => 'inputFormTabel lebar2', 'readonly' => true)); ?>
                                </td>
                                <td><?php echo CHtml::textField("RMTindakanpelayananT[tarif_cyto][]", '', array('class' => 'inputFormTabel lebar2-5 currency', 'readonly' => true)); ?></td>
                            </tr>
                <?php }
                    }
                } ?>
            </table>

            <div class="form-actions">
                <?php echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                    array('class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
                ); ?>
            </div>
        </td>
    </tr>
</table>
<?php $this->endWidget(); ?>

<script type="text/javascript">
    function inputperiksa(obj) {
        if ($(obj).is(':checked')) {
            var idPemeriksaanRM = obj.value;
            var idKelasPelayanan = <?php echo $modPendaftaran->kelaspelayanan_id ?>;
            jQuery.ajax({
                'url': '<?php echo $this->createUrl('loadFormRehabMedisMasuk') ?>',
                'data': {
                    idPemeriksaanRM: idPemeriksaanRM,
                    kelasPelayanan_id: idKelasPelayanan
                },
                'type': 'post',
                'dataType': 'json',
                'success': function(data) {
                    if (data.form == '\n') {
                        alert('Tindakan Bukan Termasuk kelas Pelayanan Yang Digunakan');
                        $(obj).removeAttr('checked');
                    }
                    $('#tblFormTindakanRM').append(data.form);
                    renameInput('permintaanPenunjang', 'inputoperasi');
                    renameInput('permintaanPenunjang', 'inputtarifoperasi');
                    renameInput('permintaanPenunjang', 'inputqty');
                    renameInput('permintaanPenunjang', 'satuan');
                    renameInput('permintaanPenunjang', 'cyto');
                    renameInput('permintaanPenunjang', 'persencyto');
                    renameInput('permintaanPenunjang', 'tarifcyto');
                    renameInput('permintaanPenunjang', 'kegiatanoperaiNama');
                    renameInput('permintaanPenunjang', 'operasiNama');
                    renameInput('permintaanPenunjang', 'idDaftarTindakan');
                },
                'cache': false
            });
        } else {
            myConfirm("Apakah Anda akan membatalkan operasi ini?", "Perhatian!",
                function(r) {
                    if (r) {
                        batalPeriksa(obj.value);
                    } else {
                        $(obj).attr('checked', 'checked');
                    }
                });
        }
    }

    function renameInput(modelName, attributeName) {
        var trLength = $('#tblFormTindakanRM tr').length;
        var i = -1;
        $('#tblFormTindakanRM tr').each(function() {
            if ($(this).has('input[name$="[inputoperasi]"]').length) {
                i++;
            }
            $(this).find('input[name$="[' + attributeName + ']"]').attr('name', modelName + '[' + i + '][' + attributeName + ']');
            $(this).find('input[name$="[' + attributeName + ']"]').attr('id', modelName + '_' + i + '_' + attributeName + '');
            $(this).find('select[name$="[' + attributeName + ']"]').attr('name', modelName + '[' + i + '][' + attributeName + ']');
            $(this).find('select[name$="[' + attributeName + ']"]').attr('id', modelName + '_' + i + '_' + attributeName + '');
        });
    }

    function batalPeriksa(idTindakan) {
        $('#tblFormTindakanRM #tindakan_' + idTindakan).detach();
    }

    function hitungCyto(id, obj) {
        if (obj == 1) {
            var persen_cytotind = $('#RMTindakanpelayananT_persencyto_tind').val();
            var harga_tarif = $('#RMTindakanpelayananT_tarif_tindakan').val();
            var tarif_cyto = harga_tarif * (persen_cytotind / 100);

            $('#RMTindakanpelayananT_tarif_cyto').val(tarif_cyto);
        } else {
            $('#RMTindakanpelayananT_tarif_cyto').val(0);
        }

    }
</script>

<?php
function cekPilihan($tindakan_id, $arrInputPemeriksaan)
{
    $cek = false;
    foreach ($arrInputPemeriksaan as $i => $items) {
        foreach ($items as $j => $item) {
            if ($tindakan_id == $item->tindakanrm_id) $cek = true;
        }
    }
    return $cek;
}
?>