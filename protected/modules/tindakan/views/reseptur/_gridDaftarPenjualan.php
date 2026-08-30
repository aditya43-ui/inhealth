            <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                'id' => 'daftarpasien-v-grid',
                'dataProvider' => $modPenjualanResep->searchRiwayatResep(),
                'template' => "{summary}\n{items}\n{pager}",
                "replaceUrl" => true,
                'itemsCssClass' => 'table table-striped table-condensed',
                'columns' => [
                    [
                        'header' => 'No',
                        'value' => '$row+1',
                    ],
                    [
                        'header' => 'Tanggal Penjualan',
                        'value' => function ($data) {
                            return MyFormatter::formatDateTimeForUser($data->tglpenjualan);
                        }
                    ],
                    [
                        'header' => 'Tanggal Resep',
                        'value' => function ($data) {
                            return MyFormatter::formatDateTimeForUser($data->tglresep);
                        }
                    ],
                    [
                        'header' => 'No Resep',
                        'value' => function ($data) {
                            return $data->noresep;
                        }
                    ],
                    [
                        'header' => 'PPDS',
                        'value' => function ($data) {
                            return $data->ppds_nama ?? "-";
                        }
                    ],
                    [
                        'header' => 'Nama Dokter',
                        'value' => function ($data) {
                            return !empty($data->pegawai_id) ? $data->dokterpeg->namaLengkap : "";
                        }
                    ],
                    [
                        'header' => 'Detail Penjualan',
                        'type' => 'raw',
                        'value' => function ($data) {
                            return "<center>" . CHtml::link("<i class='icon-eye-open'></i>", '#', array('onclick' => 'viewDetailPenjualan("' . $data->penjualanresep_id . '","' . $data->pendaftaran_id . '");return false;', 'rel' => 'tooltip', 'title' => 'Klik untuk melihat detail resep'));
                        }
                    ],
                    [
                        'header' => 'Copy Resep',
                        'type' => 'raw',
                        'value' => function ($data) {
                            return  "<center>" . CHtml::link("<i class='fa fa-copy'></i>", '#', array('onclick' => 'copy_resep(' . $data->penjualanresep_id . ');return false;', 'class' => '')) . "</center>";
                        }
                    ],
                ],
                'afterAjaxUpdate' => 'function(id, data){
                jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
                disableLink();}',
            )); ?>


            <script>
                /**
                 * Fungsi copy resep 
                 */
                const copy_resep = (penjualanresep_id) => {
                    var hitung = 0;
                    var rke = $("#table-obatalkespasien tbody tr:last-child td").find('input[name*="[rke]"]').val();
                    $('#table-obatalkespasien > tbody > tr').each(function() {
                        var det_id = $(this).find('.penjualanresep_id').val();
                        if (penjualanresep_id == det_id) {
                            hitung++;
                        }
                    });

                    if (hitung >= 1) {
                        myAlert("Data Penjualan Resep sudah ada di tabel. Silahkan pilih yang lain.", "Perhatian!");
                        return false;
                    }

                    if (rke == undefined) {
                        rke = 1;
                    } else {
                        rke++;
                    }

                    $.ajax({
                        type: 'POST',
                        url: '<?php echo $this->createUrl('copyResep'); ?>',
                        data: {
                            penjualanresep_id: penjualanresep_id,
                            rke: rke,
                        },
                        dataType: "json",
                        success: function(data) {
                            $('#table-obatalkespasien > tbody').append(data.tr);
                            renameInputRowObatAlkes($("#table-obatalkespasien"));

                            var row = 0;

                            $("#table-obatalkespasien").find("tbody > tr").each(function() {
                                $(this).find(".r").val(row + 1);
                                $(this).find(".rke").val(row + 1);
                               
                                row++;
                            });
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.log(errorThrown);
                        }
                    });
                }
            </script>