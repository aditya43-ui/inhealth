<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'masukpenunjang-ibs-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    'focus' => '#',
)); ?>

<?php echo $form->errorSummary(array($modPenunjangSave, $modRencanaOperasi)); ?>

<?php $this->renderPartial('_ringkasDataPasien', array('modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien)); ?>

<?php $this->renderPartial('_formRencanaOperasi', array('form' => $form, 'modRencanaOperasi' => $modRencanaOperasi, 'modPendaftaran' => $modPendaftaran, 'modPasienKirimKeunitLain' => $modPasienKirimKeunitLain)); ?>

<table style="width: 100%; border: none;">
    <tr>

        <td>
            <?php
            foreach ($modRiwayatKirimKeUnitLain as $i => $riwayat) {
                $modPermintaan = PermintaankepenunjangT::model()->with('daftartindakan', 'operasi')->findAllByAttributes(array('pasienkirimkeunitlain_id' => $riwayat->pasienkirimkeunitlain_id));
                foreach ($modPermintaan as $j => $permintaan) {
                    $modTarif = TariftindakanM::model()->findByAttributes(array(
                        'kelaspelayanan_id' => $riwayat->kelaspelayanan_id,
                        'daftartindakan_id' => $permintaan->operasi->daftartindakan_id,
                        'komponentarif_id' => Params::KOMPONENTARIF_ID_TOTAL
                    ));
                    $tarif[$i][$j] = (!empty($modTarif->harga_tariftindakan)) ? $modTarif->harga_tariftindakan : 0;
                    $persencyto[$i][$j] = (!empty($modTarif->persencyto_tind)) ? $modTarif->persencyto_tind : 0;
                }
                $arrInputRencana[$i] = $modPermintaan;
            }

            ?>
            <?php foreach ($modKegiatanOperasi as $i => $kegiatanOperasi) {
            ?>
                <div class="boxtindakan">
                    <h6><?php echo $kegiatanOperasi->kegiatanoperasi_nama; ?></h6>
                    <?php foreach ($modOperasi as $j => $operasi) {
                        $ceklist = (!empty($arrInputRencana)) ? cekPilihan($operasi->operasi_id, $arrInputRencana) : false;
                        if ($kegiatanOperasi->kegiatanoperasi_id == $operasi->kegiatanoperasi_id) {
                            echo CHtml::checkBox("operasi[]", $ceklist, array(
                                'value' => $operasi->operasi_id,
                                'onclick' => "inputperiksa(this)"
                            ));
                            echo "<span>" . $operasi->operasi_nama . "</span><br>";
                        }
                    } ?>
                </div>
            <?php } ?>
        </td>
        <td>
            <table id="tblFormOperasi" class="table table-condensed">
                <thead>
                    <tr>
                        <th>Operasi</th>
                        <th>Tarif</th>
                        <th>Jumlah</th>
                        <th>Satuan*</th>
                        <th>Cyto</th>
                        <th>Tarif Cyto</th>
                    </tr>
                </thead>
                <?php
                if (!empty($arrInputRencana)) {
                    foreach ($arrInputRencana as $i => $itemOperasi) {
                        foreach ($itemOperasi as $j => $item) {
                ?>
                            <tr id="operasi_<?php echo $item->operasi_id; ?>">
                                <td>
                                    <?php echo CHtml::hiddenField("permintaanPenunjang[$i][idPasienKirimKeUnitLain]", $item->pasienkirimkeunitlain_id, array('class' => 'inputFormTabel lebar2', 'readonly' => true)); ?>
                                    <?php echo $item->operasi->operasi_nama; ?>
                                    <?php echo CHtml::hiddenField("BSTindakanPelayananT[daftartindakan_id][]", $item->operasi->daftartindakan_id, array('class' => 'inputFormTabel', 'readonly' => true)); ?>
                                    <?php echo CHtml::hiddenField("operasi_id[]", $item->operasi_id, array('class' => 'inputFormTabel', 'readonly' => true)); ?>
                                </td>
                                <td>
                                    <?php echo CHtml::textField("BSTindakanPelayananT[tarif_tindakan][]", $tarif[$i][$j], array('class' => 'inputFormTabel lebar3 currency', 'readonly' => true)); ?>
                                </td>
                                <td><?php echo CHtml::textField("BSTindakanPelayananT[qty_tindakan][]", $item->qtypermintaan, array('class' => 'inputFormTabel lebar1')); ?></td>
                                <td><?php echo CHtml::dropDownList("BSTindakanPelayananT[satuantindakan][]", 'KALI', LookupM::getItems('satuantindakan'), array('class' => 'inputFormTabel lebar3',)); ?></td>
                                <td>
                                    <?php echo CHtml::dropDownList("BSTindakanPelayananT[cyto_tindakan][]", '0', array('1' => 'Ya', '0' => 'Tidak'), array('class' => 'inputFormTabel lebar2-5')); ?>
                                    <?php echo CHtml::hiddenField("BSTindakanPelayananT[persencyto_tind][]", $persencyto[$i][$j], array('class' => 'inputFormTabel lebar2', 'readonly' => true)); ?>
                                </td>
                                <td><?php echo CHtml::textField("BSTindakanPelayananT[tarif_cyto][]", '', array('class' => 'inputFormTabel lebar2-5 currency', 'readonly' => true)); ?></td>
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
                <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="icon-refresh 	icon-white"></i>')), array('class' => 'btn btn-default', 'type' => 'reset')); ?>
                <?php
                $content = $this->renderPartial('../tips/tips', array(), true);
                $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content)); ?>
            </div>
        </td>
    </tr>
</table>
<?php $this->endWidget(); ?>

<script type="text/javascript">
    function inputperiksa(obj) {
        if ($(obj).is(':checked')) {
            var idOperasi = obj.value;
            var idKelasPelayanan = $('#idkelaspelayanan').val();
            if (!jQuery.isNumeric(idKelasPelayanan)) {
                var idKelasPelayanan = $('#kelaspelayanan_id').val();
            }
            //        myAlert(idKelasPelayanan);
            jQuery.ajax({
                'url': '<?php echo $this->createUrl('loadFormOperasiMasuk') ?>',
                'data': {
                    idOperasi: idOperasi,
                    idKelasPelayanan: idKelasPelayanan
                },
                'type': 'post',
                'dataType': 'json',
                'success': function(data) {
                    if (data.form == '\n') {
                        myAlert('Tindakan Bukan Termasuk kelas Pelayanan Yang Digunakan');
                        $(obj).removeAttr('checked');
                    }
                    $('#tblFormOperasi').append(data.form);
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
            myConfirm("Apakah Anda akan membatalkan operasi ini?", "Perhatian!", function(r) {
                if (r) {
                    batalPeriksa(obj.value);
                } else {
                    $(obj).attr('checked', 'checked');
                }
            });
        }
    }

    function inputKelasPelayanan(obj) {
        $('#operasi:checked').each(function() {
            var idOperasi = $(this).val();
            var idKelasPelayanan = $('#idkelaspelayanan').val();
            batalPeriksa(idOperasi);
            jQuery.ajax({
                'url': '<?php echo $this->createUrl('loadFormOperasiMasuk') ?>',
                'data': {
                    idOperasi: idOperasi,
                    idKelasPelayanan: idKelasPelayanan
                },
                'type': 'post',
                'dataType': 'json',
                'success': function(data) {
                    // if(data.form=='\n')
                    //    {
                    //        myAlert ('Tindakan Bukan Termasuk kelas Pelayanan Yang Digunakan');
                    //        $(obj).removeAttr('checked');
                    //    } 
                    $('#tblFormOperasi').append(data.form);
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
        });
    }

    function renameInput(modelName, attributeName) {
        var trLength = $('#tblFormOperasi tr').length;
        var i = -1;
        $('#tblFormOperasi tr').each(function() {
            if ($(this).has('input[name$="[inputoperasi]"]').length) {
                i++;
            }
            $(this).find('input[name$="[' + attributeName + ']"]').attr('name', modelName + '[' + i + '][' + attributeName + ']');
            $(this).find('input[name$="[' + attributeName + ']"]').attr('id', modelName + '_' + i + '_' + attributeName + '');
            $(this).find('select[name$="[' + attributeName + ']"]').attr('name', modelName + '[' + i + '][' + attributeName + ']');
            $(this).find('select[name$="[' + attributeName + ']"]').attr('id', modelName + '_' + i + '_' + attributeName + '');
        });
    }

    function batalPeriksa(idOperasi) {
        $('#tblFormOperasi #operasi_' + idOperasi).detach();
    }

    function hitungCyto(id, obj) {
        if (obj == 1) {
            var persen_cytotind = $('#BSTindakanPelayananT_persencyto_tind').val();
            var harga_tarif = $('#BSTindakanPelayananT_tarif_tindakan').val();
            var tarif_cyto = harga_tarif * (persen_cytotind / 100);

            $('#BSTindakanPelayananT_tarif_cyto').val(tarif_cyto);
        } else {
            $('#BSTindakanPelayananT_tarif_cyto').val(0);
        }

    }
</script>

<?php
function cekPilihan($operasi_id, $arrInputPemeriksaan)
{
    $cek = false;
    foreach ($arrInputPemeriksaan as $i => $items) {
        foreach ($items as $j => $item) {
            if ($operasi_id == $item->operasi_id) $cek = true;
        }
    }
    return $cek;
}
?>