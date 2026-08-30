<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'penilaian-alokasi-t-search',
    'type' => 'horizontal',
));
?>
<div class="row">
    <div class="col-sm-6">
        <div id='searching'>
            <?php
            echo CHtml::hiddenField('filter', 'instalasi_id', array('disabled' => 'disabled')) .
                '<div class="control-group">
                        ' . CHtml::label('Instalasi', 'instalasi_id', array('class' => 'control-label')) . ' 
                        <div class="controls">
                            ' . $form->dropDownList($model, 'instalasi_id', CHtml::listData(InstalasiM::model()->findAll('instalasi_aktif = true ORDER BY instalasi_nama ASC'), 'instalasi_id', 'instalasi_nama'), array(
                    'class' => 'form-control', 'multiple' => 'multiple'
                )) . '
                        </div>
                    </div>
                    <div class="control-group">
                        ' . CHtml::label('Ruangan', 'ruangan_id', array('class' => 'control-label')) . ' 
                        <div class="controls">												 
                            ' . $form->dropDownList(
                    $model,
                    'ruangan_id',
                    array(),
                    array('class' => 'form-control', 'multiple' => 'multiple')
                ) . '
                        </div>
                    </div>';

            // $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
            //     'id' => 'instalasi',
            //     'slide' => true,
            //     'content' => array(
            //         'content3' => array(
            //             'multi' => 'multi',
            //             'header' => 'Berdasarkan Instalasi dan Ruangan',
            //             'isi' => CHtml::hiddenField('filter', 'instalasi_id', array('disabled' => 'disabled')) .
            //                 '<div class="control-group">
            // 							' . CHtml::label('Instalasi', 'instalasi_id', array('class' => 'control-label')) . ' 
            // 							<div class="controls">
            // 								' . $form->dropDownList($model, 'instalasi_id', CHtml::listData(InstalasiM::model()->findAll('instalasi_aktif = true ORDER BY instalasi_nama ASC'), 'instalasi_id', 'instalasi_nama'), array(
            //                     'class' => 'form-control', 'multiple' => 'multiple'
            //                 )) . '
            // 							</div>
            // 						</div>
            // 						<div class="control-group">
            // 							' . CHtml::label('Ruangan', 'ruangan_id', array('class' => 'control-label')) . ' 
            // 							<div class="controls">												 
            // 								' . $form->dropDownList(
            //                     $model,
            //                     'ruangan_id',
            //                     array(),
            //                     array('class' => 'form-control', 'multiple' => 'multiple')
            //                 ) . '
            // 							</div>
            // 						</div>',
            //             'active' => true,
            //         ),
            //     ),
            // ));
            ?>
        </div>
    </div>

    <div class="col-sm-6">
        <?php echo CHtml::hiddenField('type', ''); ?>
        <div class="control-group">

            <?php echo CHtml::label("Periode Laporan", 'tglterimabahan', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'tahun', CustomFunction::getTahun(80, 0), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'prompt' => '-- Pilih --')); ?>
            </div>
        </div>
        <div class="control-group">

            <?php echo CHtml::label("Pembina Mengetahui", 'pegawai_id', array('class' => 'control-label')) ?>
            <div class="controls">

                <?php echo $form->dropDownList(
                    $model,
                    'pegawai_id',
                    Chtml::listData(PegawaiV::model()->findAllByAttributes(array('pegawai_aktif' => true)), 'pegawai_id', 'namaLengkap'),
                    array('onkeypress' => "return $(this).focusNextInputField(event)")
                ); ?>
            </div>
        </div>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
</div>

<?php $this->endWidget(); ?>
<script>
    function checkPilihan(event) {
        var namaPeriode = $('#PeriodeName').val();

        if (namaPeriode == '') {
            myAlert('Silakan pilih kategori pencarian!');
            event.preventDefault();
            $('#dtPicker3').datepicker("hide");
            return true;;
        }
    }

    function checkAll() {
        if ($('#checkAllRuangan').is(':checked')) {
            $('#laporan-search input[name*="ruangan_id"]').each(function() {
                $(this).attr('checked', true);
            });
        } else {
            $('#laporan-search input[name*="ruangan_id"]').each(function() {
                $(this).removeAttr('checked');
            });
        }
    }

    $(document).ready(function() {
        var ins = jQuery('#<?php echo CHtml::activeId($model, 'instalasi_id') ?>');
        var ru = jQuery('#<?php echo CHtml::activeId($model, 'ruangan_id') ?>');
        var cara = jQuery('#<?php echo CHtml::activeId($model, 'carabayar_id') ?>');
        var penj = jQuery('#<?php echo CHtml::activeId($model, 'penjamin_id') ?>');
        var prop = jQuery('#<?php echo CHtml::activeId($model, 'propinsi_id') ?>');
        var kab = jQuery('#<?php echo CHtml::activeId($model, 'kabupaten_id') ?>');
        var pelayanan = jQuery('#<?php echo CHtml::activeId($model, 'kelaspelayanan_id') ?>');
        var tujuan = jQuery('#<?php echo CHtml::activeId($model, 'ruangantujuan_id') ?>');
        var penunjang = jQuery('#<?php echo CHtml::activeId($model, 'ruanganpenunj_id') ?>');
        var obat = jQuery('#<?php echo CHtml::activeId($model, 'jenisobatalkes_id') ?>');
        var cara_keluar = jQuery('#<?php echo CHtml::activeId($model, 'carakeluar') ?>');
        var tindakan = jQuery('#<?php echo CHtml::activeId($model, 'tindakansudahbayar_id') ?>');
        var jenispenjualan = jQuery('#<?php echo CHtml::activeId($model, 'jenispenjualan') ?>');
        var statusbayar = jQuery('#<?php echo CHtml::activeId($model, 'statusbayar') ?>');
        var instalasiasal_nama = jQuery('#<?php echo CHtml::activeId($model, 'instalasiasal_nama') ?>');
        var ruanganasal_nama = jQuery('#<?php echo CHtml::activeId($model, 'ruanganasal_nama') ?>');
        var obatalkes_kategori = jQuery('#<?php echo CHtml::activeId($model, 'obatalkes_kategori') ?>');
        var pegawai = jQuery('#<?php echo CHtml::activeId($model, 'pegawai_id') ?>');
        var kunjungan = jQuery('#<?php echo CHtml::activeId($model, 'kunjungan') ?>');
        var instalasiasal_id = jQuery('#<?php echo CHtml::activeId($model, 'instalasiasal_id') ?>');
        var ruanganasal_id = jQuery('#<?php echo CHtml::activeId($model, 'ruanganasal_id') ?>');
        var asalrujukan_id = jQuery('#<?php echo CHtml::activeId($model, 'asalrujukan_id') ?>');
        var namaperujuk = jQuery('#<?php echo CHtml::activeId($model, 'namaperujuk') ?>');
        var nama_pegawai = jQuery('#<?php echo CHtml::activeId($model, 'nama_pegawai') ?>');
        var supplier_id = jQuery('#<?php echo CHtml::activeId($model, 'supplier_id') ?>');
        var kondisi_barang = jQuery('#<?php echo CHtml::activeId($model, 'kondisi_barang') ?>');
        var stok = jQuery('#<?php echo CHtml::activeId($model, 'stok') ?>');

        jQuery(instalasiasal_id).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true,
            onChange: function(element, checked) {
                var ins = jQuery('#<?php echo CHtml::activeId($model, 'instalasiasal_id') ?>');
                var ins_all = jQuery('#<?php echo CHtml::activeId($model, 'instalasiasal_id') ?>   option:selected');
                var ru = jQuery('#<?php echo CHtml::activeId($model, 'ruanganasal_id') ?>');
                var brands = ins_all;
                var selected = [];
                $(brands).each(function(index, brand) {
                    selected.push($(this).val());
                });
                ru.addClass('animation-loading');
                //alert(selected);
                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('/ActionDynamic/GetRuanganByMultiSelect') ?>',
                    dataType: "json",
                    data: {
                        instalasi_id: selected
                    },
                    success: function(data) {
                        if (data.sukses != '1') {
                            //toastr.error(data.pesan);
                            ru.addClass('animation-loading');
                        } else {
                            //alert(data.ruangan);
                            ru.html(data.ruangan);
                            ru.multiselect('rebuild');
                            ru.removeClass('animation-loading');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                    }
                });
            },
            onSelectAll: function() {
                var ins = jQuery('#<?php echo CHtml::activeId($model, 'instalasiasal_id') ?>');
                var ins_all = jQuery('#<?php echo CHtml::activeId($model, 'instalasiasal_id') ?>   option:selected');
                var ru = jQuery('#<?php echo CHtml::activeId($model, 'ruanganasal_id') ?>');
                var brands = ins_all;
                var selected = [];
                $(brands).each(function(index, brand) {
                    selected.push($(this).val());
                });
                ru.addClass('animation-loading');
                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('/ActionDynamic/GetRuanganByMultiSelect') ?>',
                    dataType: "json",
                    data: {
                        instalasi_id: selected
                    },
                    success: function(data) {
                        if (data.sukses != '1') {
                            //toastr.error(data.pesan);
                            ru.addClass('animation-loading');
                        } else {
                            //alert(data.ruangan);
                            ru.html(data.ruangan);
                            ru.multiselect('rebuild');
                            ru.removeClass('animation-loading');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                    }
                });
            },
            onDeselectAll: function() {
                var ins = jQuery('#<?php echo CHtml::activeId($model, 'instalasiasal_id') ?>');
                var ins_all = jQuery('#<?php echo CHtml::activeId($model, 'instalasiasal_id') ?>   option:selected');
                var ru = jQuery('#<?php echo CHtml::activeId($model, 'ruanganasal_id') ?>');
                var brands = ins_all;
                var selected = '';
                ru.addClass('animation-loading');
                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('/ActionDynamic/GetRuanganByMultiSelect') ?>',
                    dataType: "json",
                    data: {
                        instalasi_id: selected
                    },
                    success: function(data) {
                        if (data.sukses != '1') {
                            //toastr.error(data.pesan);
                            ru.addClass('animation-loading');
                        } else {
                            //alert(data.ruangan);
                            ru.html(data.ruangan);
                            ru.multiselect('rebuild');
                            ru.removeClass('animation-loading');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                    }
                });
            }
        }).hide();

        jQuery(instalasiasal_nama).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true,
            onChange: function(element, checked) {
                var ins = jQuery('#<?php echo CHtml::activeId($model, 'instalasiasal_nama') ?>');
                var ins_all = jQuery('#<?php echo CHtml::activeId($model, 'instalasiasal_nama') ?>   option:selected');
                var ru = jQuery('#<?php echo CHtml::activeId($model, 'ruanganasal_nama') ?>');

                var brands = ins_all;
                var selected = [];

                $(brands).each(function(index, brand) {
                    selected.push($(this).val());
                });

                ru.addClass('animation-loading');
                //alert(selected);

                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('/ActionDynamic/GetRuanganAsalByMultiSelect') ?>',
                    dataType: "json",
                    data: {
                        instalasiasal_nama: selected
                    },
                    success: function(data) {

                        if (data.sukses != '1') {

                            //toastr.error(data.pesan);
                            ru.addClass('animation-loading');
                        } else {
                            //alert(data.ruangan);
                            ru.html(data.ruangan_nama);
                            ru.multiselect('rebuild');
                            ru.removeClass('animation-loading');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);

                    }
                });

            },
            onSelectAll: function() {
                var ins = jQuery('#<?php echo CHtml::activeId($model, 'instalasiasal_nama') ?>');
                var ins_all = jQuery('#<?php echo CHtml::activeId($model, 'instalasiasal_nama') ?>   option:selected');
                var ru = jQuery('#<?php echo CHtml::activeId($model, 'ruanganasal_nama') ?>');

                var brands = ins_all;
                var selected = [];

                $(brands).each(function(index, brand) {
                    selected.push($(this).val());
                });

                ru.addClass('animation-loading');

                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('/ActionDynamic/GetRuanganAsalByMultiSelect') ?>',
                    dataType: "json",
                    data: {
                        instalasiasal_nama: selected
                    },
                    success: function(data) {

                        if (data.sukses != '1') {

                            //toastr.error(data.pesan);
                            ru.addClass('animation-loading');
                        } else {
                            //alert(data.ruangan);
                            ru.html(data.ruangan_nama);
                            ru.multiselect('rebuild');
                            ru.removeClass('animation-loading');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);

                    }
                });

            },
            onDeselectAll: function() {
                var ins = jQuery('#<?php echo CHtml::activeId($model, 'instalasiasal_nama') ?>');
                var ins_all = jQuery('#<?php echo CHtml::activeId($model, 'instalasiasal_nama') ?>   option:selected');
                var ru = jQuery('#<?php echo CHtml::activeId($model, 'ruanganasal_nama') ?>');

                var brands = ins_all;
                var selected = '';


                ru.addClass('animation-loading');

                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('/ActionDynamic/GetRuanganAsalByMultiSelect') ?>',
                    dataType: "json",
                    data: {
                        instalasiasal_nama: selected
                    },
                    success: function(data) {

                        if (data.sukses != '1') {

                            //toastr.error(data.pesan);
                            ru.addClass('animation-loading');
                        } else {
                            //alert(data.ruangan);
                            ru.html(data.ruangan_nama);
                            ru.multiselect('rebuild');
                            ru.removeClass('animation-loading');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);

                    }
                });

            }
        }).hide();

        jQuery(ins).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true,
            onChange: function(element, checked) {
                var ins = jQuery('#<?php echo CHtml::activeId($model, 'instalasi_id') ?>');
                var ins_all = jQuery('#<?php echo CHtml::activeId($model, 'instalasi_id') ?>   option:selected');
                var ru = jQuery('#<?php echo CHtml::activeId($model, 'ruangan_id') ?>');

                var brands = ins_all;
                var selected = [];

                $(brands).each(function(index, brand) {
                    selected.push($(this).val());
                });

                ru.addClass('animation-loading');
                //alert(selected);

                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('/ActionDynamic/GetRuanganByMultiSelect') ?>',
                    dataType: "json",
                    data: {
                        instalasi_id: selected
                    },
                    success: function(data) {

                        if (data.sukses != '1') {

                            //toastr.error(data.pesan);
                            ru.addClass('animation-loading');
                        } else {
                            //alert(data.ruangan);
                            ru.html(data.ruangan);
                            ru.multiselect('rebuild');
                            ru.removeClass('animation-loading');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);

                    }
                });

            },
            onSelectAll: function() {
                var ins = jQuery('#<?php echo CHtml::activeId($model, 'instalasi_id') ?>');
                var ins_all = jQuery('#<?php echo CHtml::activeId($model, 'instalasi_id') ?>   option:selected');
                var ru = jQuery('#<?php echo CHtml::activeId($model, 'ruangan_id') ?>');

                var brands = ins_all;
                var selected = [];

                $(brands).each(function(index, brand) {
                    selected.push($(this).val());
                });

                ru.addClass('animation-loading');

                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('/ActionDynamic/GetRuanganByMultiSelect') ?>',
                    dataType: "json",
                    data: {
                        instalasi_id: selected
                    },
                    success: function(data) {

                        if (data.sukses != '1') {

                            //toastr.error(data.pesan);
                            ru.addClass('animation-loading');
                        } else {
                            //alert(data.ruangan);
                            ru.html(data.ruangan);
                            ru.multiselect('rebuild');
                            ru.removeClass('animation-loading');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);

                    }
                });

            },
            onDeselectAll: function() {
                var ins = jQuery('#<?php echo CHtml::activeId($model, 'instalasi_id') ?>');
                var ins_all = jQuery('#<?php echo CHtml::activeId($model, 'instalasi_id') ?>   option:selected');
                var ru = jQuery('#<?php echo CHtml::activeId($model, 'ruangan_id') ?>');

                var brands = ins_all;
                var selected = '';


                ru.addClass('animation-loading');

                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('/ActionDynamic/GetRuanganByMultiSelect') ?>',
                    dataType: "json",
                    data: {
                        instalasi_id: selected
                    },
                    success: function(data) {

                        if (data.sukses != '1') {

                            //toastr.error(data.pesan);
                            ru.addClass('animation-loading');
                        } else {
                            //alert(data.ruangan);
                            ru.html(data.ruangan);
                            ru.multiselect('rebuild');
                            ru.removeClass('animation-loading');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);

                    }
                });

            }
        }).hide();

        jQuery(ru).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true
        }).hide();

        /**
         * multi select cara bayar dan penjamin
         */

        jQuery(cara).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true,
            onChange: function(element, checked) {
                var cara = jQuery('#<?php echo CHtml::activeId($model, 'carabayar_id') ?>');
                var cara_all = jQuery('#<?php echo CHtml::activeId($model, 'carabayar_id') ?>   option:selected');
                var penj = jQuery('#<?php echo CHtml::activeId($model, 'penjamin_id') ?>');

                var brands = cara_all;
                var selected = [];

                $(brands).each(function(index, brand) {
                    selected.push($(this).val());
                });

                penj.addClass('animation-loading');
                //alert(selected);

                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('/ActionDynamic/GetPenjaminByMultiSelect') ?>',
                    dataType: "json",
                    data: {
                        carabayar_id: selected
                    },
                    success: function(data) {

                        if (data.sukses != '1') {

                            //toastr.error(data.pesan);
                            penj.addClass('animation-loading');
                        } else {
                            //alert(data.ruangan);
                            penj.html(data.penjamin);
                            penj.multiselect('rebuild');
                            penj.removeClass('animation-loading');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);

                    }
                });

            },
            onSelectAll: function() {
                var cara = jQuery('#<?php echo CHtml::activeId($model, 'carabayar_id') ?>');
                var cara_all = jQuery('#<?php echo CHtml::activeId($model, 'carabayar_id') ?>   option:selected');
                var penj = jQuery('#<?php echo CHtml::activeId($model, 'penjamin_id') ?>');

                var brands = ins_all;
                var selected = [];

                $(brands).each(function(index, brand) {
                    selected.push($(this).val());
                });

                penj.addClass('animation-loading');

                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('/ActionDynamic/GetRuanganByMultiSelect') ?>',
                    dataType: "json",
                    data: {
                        carabayar_id: selected
                    },
                    success: function(data) {

                        if (data.sukses != '1') {

                            //toastr.error(data.pesan);
                            penj.addClass('animation-loading');
                        } else {
                            //alert(data.ruangan);
                            penj.html(data.penjaminan);
                            penj.multiselect('rebuild');
                            penj.removeClass('animation-loading');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);

                    }
                });

            },
            onDeselectAll: function() {
                var cara = jQuery('#<?php echo CHtml::activeId($model, 'carabayar_id') ?>');
                var cara_all = jQuery('#<?php echo CHtml::activeId($model, 'carabayar_id') ?>   option:selected');
                var penj = jQuery('#<?php echo CHtml::activeId($model, 'penjamin_id') ?>');

                var brands = ins_all;
                var selected = '';


                penj.addClass('animation-loading');

                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('/ActionDynamic/GetRuanganByMultiSelect') ?>',
                    dataType: "json",
                    data: {
                        carabayar_id: selected
                    },
                    success: function(data) {

                        if (data.sukses != '1') {

                            //toastr.error(data.pesan);
                            penj.addClass('animation-loading');
                        } else {
                            //alert(data.ruangan);
                            penj.html(data.penjamin);
                            penj.multiselect('rebuild');
                            penj.removeClass('animation-loading');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);

                    }
                });

            }
        }).hide();

        jQuery(penj).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true
        }).hide();

        /**
         * multi select propinsi dan kabupaten
         */

        jQuery(prop).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true,
            onChange: function(element, checked) {
                var prop = jQuery('#<?php echo CHtml::activeId($model, 'propinsi_id') ?>');
                var prop_all = jQuery('#<?php echo CHtml::activeId($model, 'propinsi_id') ?>   option:selected');
                var kab = jQuery('#<?php echo CHtml::activeId($model, 'kabupaten_id') ?>');

                var brands = prop_all;
                var selected = [];

                $(brands).each(function(index, brand) {
                    selected.push($(this).val());
                });

                kab.addClass('animation-loading');
                //alert(selected);

                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('/ActionDynamic/GetKabupatenByMultiSelect') ?>',
                    dataType: "json",
                    data: {
                        propinsi_id: selected
                    },
                    success: function(data) {

                        if (data.sukses != '1') {

                            //toastr.error(data.pesan);
                            kab.addClass('animation-loading');
                        } else {
                            //alert(data.ruangan);
                            kab.html(data.kabupaten);
                            kab.multiselect('rebuild');
                            kab.removeClass('animation-loading');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);

                    }
                });

            },
            onSelectAll: function() {
                var prop = jQuery('#<?php echo CHtml::activeId($model, 'propinsi_id') ?>');
                var prop_all = jQuery('#<?php echo CHtml::activeId($model, 'propinsi_id') ?>   option:selected');
                var kab = jQuery('#<?php echo CHtml::activeId($model, 'kabupaten_id') ?>');

                var brands = prop_all;
                var selected = [];

                $(brands).each(function(index, brand) {
                    selected.push($(this).val());
                });

                kab.addClass('animation-loading');

                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('/ActionDynamic/GetKabupatenByMultiSelect') ?>',
                    dataType: "json",
                    data: {
                        propinsi_id: selected
                    },
                    success: function(data) {

                        if (data.sukses != '1') {

                            //toastr.error(data.pesan);
                            kab.addClass('animation-loading');
                        } else {
                            //alert(data.ruangan);
                            kab.html(data.kabupaten);
                            kab.multiselect('rebuild');
                            kab.removeClass('animation-loading');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);

                    }
                });

            },
            onDeselectAll: function() {
                var prop = jQuery('#<?php echo CHtml::activeId($model, 'propinsi_id') ?>');
                var prop_all = jQuery('#<?php echo CHtml::activeId($model, 'propinsi_id') ?>   option:selected');
                var kab = jQuery('#<?php echo CHtml::activeId($model, 'kabupaten_id') ?>');

                var brands = prop_all;
                var selected = '';


                kab.addClass('animation-loading');

                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('/ActionDynamic/GetKabupatenByMultiSelect') ?>',
                    dataType: "json",
                    data: {
                        propinsi_id: selected
                    },
                    success: function(data) {

                        if (data.sukses != '1') {

                            //toastr.error(data.pesan);
                            kab.addClass('animation-loading');
                        } else {
                            //alert(data.ruangan);
                            kab.html(data.kabupaten);
                            kab.multiselect('rebuild');
                            kab.removeClass('animation-loading');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);

                    }
                });

            }
        }).hide();

        jQuery(kab).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true
        }).hide();

        jQuery(pelayanan).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true
        }).hide();

        jQuery(tujuan).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true
        }).hide();

        jQuery(penunjang).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true
        }).hide();

        jQuery(obat).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true
        }).hide();

        jQuery(cara_keluar).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true
        }).hide();

        jQuery(tindakan).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true
        }).hide();

        jQuery(jenispenjualan).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true
        }).hide();

        jQuery(statusbayar).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true
        }).hide();

        jQuery(instalasiasal_nama).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true
        }).hide();

        jQuery(ruanganasal_nama).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true
        }).hide();

        jQuery(obatalkes_kategori).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true
        }).hide();

        jQuery(pegawai).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true
        }).hide();

        jQuery(kunjungan).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true
        }).hide();

        jQuery(ruanganasal_id).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true
        }).hide();

        jQuery(asalrujukan_id).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true
        }).hide();

        jQuery(namaperujuk).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true
        }).hide();

        jQuery(nama_pegawai).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true
        }).hide();

        jQuery(supplier_id).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true
        }).hide();

        jQuery(kondisi_barang).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true
        }).hide();

        jQuery(stok).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true
        }).hide();

    });
</script>