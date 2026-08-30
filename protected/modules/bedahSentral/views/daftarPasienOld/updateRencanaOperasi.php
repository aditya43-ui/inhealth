<script>
    var items = [];
</script>
<?php
$this->breadcrumbs = array(
    'Informasi Pasien Bedah Sentral' => Yii::app()->request->getUrlReferrer(),
    'Kegiatan Operasi',
);
$this->widget('bootstrap.widgets.BootAlert');
?>
<?php
$form = $this->beginWidget(
    'ext.bootstrap.widgets.BootActiveForm',
    array(
        'id' => 'updaterencanaoperasi-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        'focus' => '#BSRencanaOperasiT_kamarruangan_id',
        'htmlOptions' => array(
            'onKeyPress' => 'return disableKeyPress(event)',
            'onsubmit' => 'return cekInput();'
        ),
    )
);
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Kegiatan Operasi
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->widget('application.extensions.moneymask.MMask', array(
            'element' => '.currency',
            'currency' => 'PHP',
            'config' => array(
                'symbol' => 'Rp ',
                //        'showSymbol'=>true,
                //        'symbolStay'=>true,
                'defaultZero' => true,
                'allowZero' => true,
                'precision' => 0
            )
        ));
        ?>
        <?php
        $this->widget('bootstrap.widgets.BootAlert');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.tiler.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js');

        ?>

        <!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') 
                                    ?></p>-->
        <?php
        echo $form->errorSummary(
            array(
                $modRencanaOperasiAttrib,
                $modAnastesi,
                $modTindakanPelayanan,
                $modTindakanKomponen
            )
        );
        if (isset($_GET['sukses'])) {
            Yii::app()->user->setFlash('success', "Data berhasil disimpan");
        }
        ?>

        <?php
        echo $this->renderPartial(
            '_formDataPasien',
            array(
                'form' => $form,
                'modPasienPenunjang' => $modPasienPenunjang
            )
        );
        ?>

        <?php
        echo $this->renderPartial(
            '_formRencanaOperasi',
            array(
                'form' => $form,
                'modRencanaOperasi' => $modRencanaOperasi,
                'modRencanaOperasiAttrib' => $modRencanaOperasiAttrib,
                'modPenunjang' => $modPenunjang,
                'modPasienPenunjang' => $modPasienPenunjang,
                'modKegiatanOperasi' => $modKegiatanOperasi,
                'modOperasi' => $modOperasi,
                'modAnastesi' => $modAnastesi,
                'modRO' => $modRO,
                'modTindakanPelayanan' => $modTindakanPelayanan,
                'modTindakanKomponen' => $modTindakanKomponen,
                'modViewBahan' => $modViewBahan,
                'modViewBmhp' => $modViewBmhp,
                'format' => $format
            )
        );
        ?>

        <div class='form-actions'>
            <?php
            $cek = $modRencanaOperasiAttrib->statusoperasi;
            if ($cek == 'SELESAI') {
                echo CHtml::htmlButton(
                    $modRO->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) : Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                    array(
                        'id' => 'BSTindakanPelayananT_tombolsimpan',
                        'disabled' => true,
                        'class' => 'btn btn-danger',
                        'type' => isset($_GET['sukses']) ? 'button' : 'submit',
                        'onKeypress' => 'return formSubmit(this,event)'
                    )
                );
            } else {
                echo CHtml::htmlButton(
                    $modRO->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) : Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                    array(
                        'id' => 'BSTindakanPelayananT_tombolsimpan',
                        'class' => 'btn btn-danger',
                        'disabled' => isset($_GET['sukses']) ? true : false,
                        'type' => isset($_GET['sukses']) ? 'button' : 'submit',
                        'onKeypress' => 'return formSubmit(this,event)'
                    )
                );
            }
            echo CHtml::link(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                $this->createUrl(
                    'updateRencana',
                    array(
                        'id' => $modPasienPenunjang->pasienmasukpenunjang_id
                    )
                ),
                array(
                    'class' => 'btn btn-danger'
                )
            );
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => 'penjelasan transaksi'));
            ?>
        </div>

    </div>
</div>
<?php $this->endWidget(); ?>

<script>
    $('#formPeriksaBedah').tile({
        widths: [200]
    });

    function cekInput() {
        $('.currency').each(function() {
            this.value = unformatNumber(this.value)
        });
        return true;
    }



    /*  *
     * 
     * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
     * 
     * Mengambil data pegawai_v dari pencarian autocomplete.
     * Berdasarkan nama pegawai (jika ada).
     * 
     * @param type $term input pencarian autocomplete.
     * 
     */
    function simpanKruPegawai() {
        var id = $("#kruBedahId").val();
        var lookup = $("#lookupKruBedah").val();

        if (lookup == '') {
            $("#lookupKruBedah").attr("style", "border:1px solid red;");
        } else {
            $("#lookupKruBedah").attr("style", "");
        }

        if (id == '') {
            $("#kruBedahNama").attr("style", "border:1px solid red;");
        } else {
            $("#kruBedahNama").attr("style", "");
        }



        if (id != '' && lookup != '') {
            var length = $("#urut-" + lookup.toLowerCase().replace(/\s/g, '-')).find(".pelaksanaoperasi").length;

            $.ajax({
                type: 'POST',
                url: '<?php echo $this->createUrl('AddKruBedah'); ?>',
                data: {
                    id: id,
                    lookup: lookup,
                    length: length
                },
                dataType: "json",
                success: function(data) {
                    if (data.sukses == 1) {
                        var cek = true;
                        $("#urut-" + lookup.toLowerCase().replace(/\s/g, '-')).find(".pelaksanaoperasi").each(function() {
                            if ($(this).find(".krubedah_id").val() == data.id) {
                                alert("Maaf, pegawai ini sudah ditambahkan pada Kru Bedah " + data.look);
                                cek = false;
                            }
                        });

                        if (cek == true) {
                            $("#urut-" + data.lookup).append(data.div);
                            renameInputRowPelaksanaOperasi();
                            $("#kruBedahId").val('');
                            $("#kruBedahNama").val('');
                            $("#lookupKruBedah").val('');
                            $('#dialogKruBedah').dialog('close');
                        } else {
                            return false;
                        }

                    } else {
                        alert(data.pesan);
                        return false;
                    }

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        } else {
            alert("Maaf, Kru Bedah dan Nama Pegawai harus diisi, untuk nama pegawai harus dipilih (dari hasil auto complete)");
            return false;
        }
    }

    function renameInputRowPelaksanaOperasi() {
        var row = 0;

        $(".pelaksanaoperasi").each(function() {
            $(this).find('input,select,textarea').each(function() { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 3) {
                    $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
                    $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
                }
            });


            if (($(this).hasClass('awal'))) {

            } else {
                row++;
            }
        });
    }

    function removeData(obj, st) {
        $(obj).parents('.pelaksanaoperasi').attr('style', 'border:1px solid red;');

        var conf = confirm("Apakah Anda ingin menghapus data ini ?");


        if (conf == true) {
            $(obj).parents('.pelaksanaoperasi').remove();
            renameInputRowPelaksanaOperasi();
            var row = 0;
            $("#urut-" + st.toLowerCase().replace(/\s/g, '-')).find(".pelaksanaoperasi").each(function() {
                if (($(this).hasClass('awal'))) {

                } else {
                    if (row == 0) {
                        $(this).find('.gantilabel').html(st);
                    }
                }
                row++;
            });

        } else {
            $(obj).parents('.pelaksanaoperasi').attr('style', '');
            return false;
        }

    }

    /**
     * - digunakan untuk mengupdate data pegawai kru bedah, yang sudah tersimpan dengan cara dibatalkan
     * @param {type} obj
     * @param {type} st
     * @returns {Boolean} */
    function removeDataFromDb(obj, st) {

        var id = $(obj).attr('krubedah_id');
        $(obj).parents('.pelaksanaoperasi').attr('style', 'border:1px solid red;');

        var conf = confirm("Apakah Anda ingin membatalkan data ini ?");


        if (conf == true) {

            $.ajax({
                type: 'POST',
                url: '<?php echo $this->createUrl('BatalKruBedah'); ?>',
                data: {
                    id: id,
                    lookup: st
                },
                dataType: "json",
                success: function(data) {
                    if (data.sukses == 1) {
                        $(obj).parents('.pelaksanaoperasi').remove();
                        renameInputRowPelaksanaOperasi();
                        var row = 0;
                        $("#urut-" + st.toLowerCase().replace(/\s/g, '-')).find(".pelaksanaoperasi").each(function() {
                            if (($(this).hasClass('awal'))) {

                            } else {
                                if (row == 0) {
                                    $(this).find('.gantilabel').html(st);
                                }
                            }
                            row++;
                        });
                        alert(data.pesan);

                    } else {
                        alert(data.pesan);
                        return false;
                    }

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        } else {
            $(obj).parents('.pelaksanaoperasi').attr('style', '');
            return false;
        }

    }

    function tambahLookup() {
        var p = prompt("Tambah Kru Bedah Baru ");

        if (p === null) {
            return false;
        } else if (p == '') {
            alert("Maaf, kru bedah belum diisi!");
            return false;
        } else {
            var yes = confirm("Apakah Anda yakin ingin menambahkan kru bedah baru ? ");

            if (yes) {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('AddLookupKruBedah'); ?>',
                    data: {
                        krubedah: p
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data.sukses == 1) {
                            var lookup = data.look;
                            alert(data.pesan);
                            $("#lookupKruBedah").html(data.drop);
                            if (data.anestesi == 'ada') {
                                $(".lookupkrubedah-anestesi:last").after("<span id='urut-" + lookup.toLowerCase().replace(/\s/g, '-') + "' class='lookupkrubedah'></span>");
                            } else {
                                $(".lookupkrubedah:last").after("<span id='urut-" + lookup.toLowerCase().replace(/\s/g, '-') + "' class='lookupkrubedah'></span>");
                            }
                        } else {
                            alert(data.pesan);
                            return false;
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                    }
                });
            } else {
                return false;
            }
        }
        /*myPrompt("Tambah Kru Bedah Baru", "", "", function(r) {
        var v = r;
        
        if (v.trim() == "") return false;
        
        myConfirm("Anda yakin untuk menambah kru bedah '" + r + "'?", "Peringatan", function(yes) {
            if (yes) {
                $.ajax({
					type:'POST',
					url:'<?php echo $this->createUrl('AddLookupKruBedah'); ?>',
					data: {krubedah:v},
					dataType: "json",
					success:function(data){
						if (data.sukses == 1){							
							alert(data.pesan);
						}else{
							alert(data.pesan);
							return false;
						}

					},
					error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
				});
            }
        });
    });*/
    }
</script>