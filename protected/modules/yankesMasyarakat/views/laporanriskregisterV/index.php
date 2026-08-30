<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Laporan <strong>Risk Register</strong></div>
    </div>
    <?php
    $url = Yii::app()->createUrl('yankesMasyarakat/laporaninsidenV/frameGrafikInsiden&id=1');
    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
        });
        $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('tableLaporan', {
                    data: $(this).serialize()
            });
            return false;
        });
        ");
    ?>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title"><i class="entypo-search"></i> Pencarian</div>
            </div>
            <div class="panel-body search-form">
                <?php $this->renderPartial('_search',array('model'=>$model)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">Tabel <strong>Risk Register</strong></div>
            </div>
            <div class="panel-body overflow-x" >
                <div class="block-tabel"> 
                    <?php 
                        $this->renderPartial('_tables', array('model'=>$model, 'tabel' => $tabel)); 
                        $this->widget('CLinkPager', array('pages' => $pages,));
                    ?>
                    
                </div>
            </div>
        </div>		
        <?php
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/printLaporanInsiden');
        $this->renderPartial('_footer', array('urlPrint' => $urlPrint, 'url' => $url));
        ?>
    </div>
</div>
<script>
    $(document).ready(function () {
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
        var instalasipemesan_nama = jQuery('#<?php echo CHtml::activeId($model, 'instalasipemesan_nama') ?>');
        var ruanganpemesan_nama = jQuery('#<?php echo CHtml::activeId($model, 'ruanganpemesan_nama') ?>');
        var obatalkes_kategori = jQuery('#<?php echo CHtml::activeId($model, 'obatalkes_kategori') ?>');
        var pegawai = jQuery('#<?php echo CHtml::activeId($model, 'pegawai_id') ?>');
        var kunjungan = jQuery('#<?php echo CHtml::activeId($model, 'kunjungan') ?>');
        var instalasipemesan_id = jQuery('#<?php echo CHtml::activeId($model, 'instalasipemesan_id') ?>');
        var ruanganpemesan_id = jQuery('#<?php echo CHtml::activeId($model, 'ruanganpemesan_id') ?>');
        var asalrujukan_id = jQuery('#<?php echo CHtml::activeId($model, 'asalrujukan_id') ?>');
        var namaperujuk = jQuery('#<?php echo CHtml::activeId($model, 'namaperujuk') ?>');
        var nama_pegawai = jQuery('#<?php echo CHtml::activeId($model, 'nama_pegawai') ?>');


        jQuery(instalasipemesan_id).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '150px',
            enableCaseInsensitiveFiltering: true,
            onChange: function (element, checked) {
                var ins = jQuery('#<?php echo CHtml::activeId($model, 'instalasipemesan_id') ?>');
                var ins_all = jQuery('#<?php echo CHtml::activeId($model, 'instalasipemesan_id') ?>   option:selected');
                var ru = jQuery('#<?php echo CHtml::activeId($model, 'ruanganpemesan_id') ?>');
                var brands = ins_all;
                var selected = [];
                $(brands).each(function (index, brand) {
                    selected.push($(this).val());
                });
                ru.addClass('animation-loading');
                //alert(selected);
                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('/ActionDynamic/GetRuanganByMultiSelect') ?>',
                    dataType: "json",
                    data: {instalasi_id: selected},
                    success: function (data) {
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
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                    }
                });
            },
            onSelectAll: function () {
                var ins = jQuery('#<?php echo CHtml::activeId($model, 'instalasipemesan_id') ?>');
                var ins_all = jQuery('#<?php echo CHtml::activeId($model, 'instalasipemesan_id') ?>   option:selected');
                var ru = jQuery('#<?php echo CHtml::activeId($model, 'ruanganpemesan_id') ?>');
                var brands = ins_all;
                var selected = [];
                $(brands).each(function (index, brand) {
                    selected.push($(this).val());
                });
                ru.addClass('animation-loading');
                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('/ActionDynamic/GetRuanganByMultiSelect') ?>',
                    dataType: "json",
                    data: {instalasi_id: selected},
                    success: function (data) {
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
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                    }
                });
            },
            onDeselectAll: function () {
                var ins = jQuery('#<?php echo CHtml::activeId($model, 'instalasipemesan_id') ?>');
                var ins_all = jQuery('#<?php echo CHtml::activeId($model, 'instalasipemesan_id') ?>   option:selected');
                var ru = jQuery('#<?php echo CHtml::activeId($model, 'ruanganpemesan_id') ?>');
                var brands = ins_all;
                var selected = '';
                ru.addClass('animation-loading');
                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('/ActionDynamic/GetRuanganByMultiSelect') ?>',
                    dataType: "json",
                    data: {instalasi_id: selected},
                    success: function (data) {
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
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                    }
                });
            }
        }).hide();

        jQuery(instalasipemesan_nama).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '150px',
            enableCaseInsensitiveFiltering: true,
            onChange: function (element, checked) {
                var ins = jQuery('#<?php echo CHtml::activeId($model, 'instalasipemesan_nama') ?>');
                var ins_all = jQuery('#<?php echo CHtml::activeId($model, 'instalasipemesan_nama') ?>   option:selected');
                var ru = jQuery('#<?php echo CHtml::activeId($model, 'ruanganpemesan_nama') ?>');

                var brands = ins_all;
                var selected = [];


                $(brands).each(function (index, brand) {
                    selected.push($(this).val());
                });

                ru.addClass('animation-loading');
                //alert(selected);

                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('/ActionDynamic/GetRuanganpemesanByMultiSelect') ?>',
                    dataType: "json",
                    data: {instalasipemesan_nama: selected},
                    success: function (data) {

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
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);

                    }
                });

            },
            onSelectAll: function () {
                var ins = jQuery('#<?php echo CHtml::activeId($model, 'instalasipemesan_nama') ?>');
                var ins_all = jQuery('#<?php echo CHtml::activeId($model, 'instalasipemesan_nama') ?>   option:selected');
                var ru = jQuery('#<?php echo CHtml::activeId($model, 'ruanganpemesan_nama') ?>');

                var brands = ins_all;
                var selected = [];

                $(brands).each(function (index, brand) {
                    selected.push($(this).val());
                });

                ru.addClass('animation-loading');


                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('/ActionDynamic/GetRuanganpemesanByMultiSelect') ?>',
                    dataType: "json",
                    data: {instalasipemesan_nama: selected},
                    success: function (data) {

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
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);

                    }
                });

            },
            onDeselectAll: function () {
                var ins = jQuery('#<?php echo CHtml::activeId($model, 'instalasipemesan_nama') ?>');
                var ins_all = jQuery('#<?php echo CHtml::activeId($model, 'instalasipemesan_nama') ?>   option:selected');
                var ru = jQuery('#<?php echo CHtml::activeId($model, 'ruanganpemesan_nama') ?>');

                var brands = ins_all;
                var selected = '';



                ru.addClass('animation-loading');


                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('/ActionDynamic/GetRuanganpemesanByMultiSelect') ?>',
                    dataType: "json",
                    data: {instalasipemesan_nama: selected},
                    success: function (data) {

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
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);

                    }
                });

            }
        }).hide();

        jQuery(ins).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '150px',
            enableCaseInsensitiveFiltering: true,
            onChange: function (element, checked) {
                var ins = jQuery('#<?php echo CHtml::activeId($model, 'instalasi_id') ?>');
                var ins_all = jQuery('#<?php echo CHtml::activeId($model, 'instalasi_id') ?>   option:selected');
                var ru = jQuery('#<?php echo CHtml::activeId($model, 'ruangan_id') ?>');

                var brands = ins_all;
                var selected = [];


                $(brands).each(function (index, brand) {
                    selected.push($(this).val());
                });

                ru.addClass('animation-loading');
                //alert(selected);

                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('/ActionDynamic/GetRuanganByMultiSelect') ?>',
                    dataType: "json",
                    data: {instalasi_id: selected},
                    success: function (data) {

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
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);

                    }
                });

            },
            onSelectAll: function () {
                var ins = jQuery('#<?php echo CHtml::activeId($model, 'instalasi_id') ?>');
                var ins_all = jQuery('#<?php echo CHtml::activeId($model, 'instalasi_id') ?>   option:selected');
                var ru = jQuery('#<?php echo CHtml::activeId($model, 'ruangan_id') ?>');

                var brands = ins_all;
                var selected = [];

                $(brands).each(function (index, brand) {
                    selected.push($(this).val());
                });

                ru.addClass('animation-loading');


                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('/ActionDynamic/GetRuanganByMultiSelect') ?>',
                    dataType: "json",
                    data: {instalasi_id: selected},
                    success: function (data) {

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
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);

                    }
                });

            },
            onDeselectAll: function () {
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
                    data: {instalasi_id: selected},
                    success: function (data) {

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
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);

                    }
                });

            }
        }).hide();

        jQuery(ru).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '150px',
            enableCaseInsensitiveFiltering: true
        }).hide();

        /**
         * multi select cara bayar dan penjamin
         */


        jQuery(cara).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '150px',
            enableCaseInsensitiveFiltering: true,
            onChange: function (element, checked) {
                var cara = jQuery('#<?php echo CHtml::activeId($model, 'carabayar_id') ?>');
                var cara_all = jQuery('#<?php echo CHtml::activeId($model, 'carabayar_id') ?>   option:selected');
                var penj = jQuery('#<?php echo CHtml::activeId($model, 'penjamin_id') ?>');

                var brands = cara_all;
                var selected = [];


                $(brands).each(function (index, brand) {
                    selected.push($(this).val());
                });

                penj.addClass('animation-loading');
                //alert(selected);

                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('/ActionDynamic/GetPenjaminByMultiSelect') ?>',
                    dataType: "json",
                    data: {carabayar_id: selected},
                    success: function (data) {

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
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);

                    }
                });

            },
            onSelectAll: function () {
                var cara = jQuery('#<?php echo CHtml::activeId($model, 'carabayar_id') ?>');
                var cara_all = jQuery('#<?php echo CHtml::activeId($model, 'carabayar_id') ?>   option:selected');
                var penj = jQuery('#<?php echo CHtml::activeId($model, 'penjamin_id') ?>');

                var brands = ins_all;
                var selected = [];

                $(brands).each(function (index, brand) {
                    selected.push($(this).val());
                });

                penj.addClass('animation-loading');


                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('/ActionDynamic/GetRuanganByMultiSelect') ?>',
                    dataType: "json",
                    data: {carabayar_id: selected},
                    success: function (data) {

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
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);

                    }
                });

            },
            onDeselectAll: function () {
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
                    data: {carabayar_id: selected},
                    success: function (data) {

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
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);

                    }
                });

            }
        }).hide();

        jQuery(penj).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '150px',
            enableCaseInsensitiveFiltering: true
        }).hide();


        /**
         * multi select propinsi dan kabupaten
         */

        jQuery(prop).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '150px',
            enableCaseInsensitiveFiltering: true,
            onChange: function (element, checked) {
                var prop = jQuery('#<?php echo CHtml::activeId($model, 'propinsi_id') ?>');
                var prop_all = jQuery('#<?php echo CHtml::activeId($model, 'propinsi_id') ?>   option:selected');
                var kab = jQuery('#<?php echo CHtml::activeId($model, 'kabupaten_id') ?>');

                var brands = prop_all;
                var selected = [];


                $(brands).each(function (index, brand) {
                    selected.push($(this).val());
                });

                kab.addClass('animation-loading');
                //alert(selected);

                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('/ActionDynamic/GetKabupatenByMultiSelect') ?>',
                    dataType: "json",
                    data: {propinsi_id: selected},
                    success: function (data) {

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
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);

                    }
                });

            },
            onSelectAll: function () {
                var prop = jQuery('#<?php echo CHtml::activeId($model, 'propinsi_id') ?>');
                var prop_all = jQuery('#<?php echo CHtml::activeId($model, 'propinsi_id') ?>   option:selected');
                var kab = jQuery('#<?php echo CHtml::activeId($model, 'kabupaten_id') ?>');

                var brands = prop_all;
                var selected = [];

                $(brands).each(function (index, brand) {
                    selected.push($(this).val());
                });

                kab.addClass('animation-loading');


                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('/ActionDynamic/GetKabupatenByMultiSelect') ?>',
                    dataType: "json",
                    data: {propinsi_id: selected},
                    success: function (data) {

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
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);

                    }
                });

            },
            onDeselectAll: function () {
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
                    data: {propinsi_id: selected},
                    success: function (data) {

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
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);

                    }
                });

            }
        }).hide();

        jQuery(kab).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '150px',
            enableCaseInsensitiveFiltering: true
        }).hide();

        jQuery(pelayanan).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '150px',
            enableCaseInsensitiveFiltering: true
        }).hide();

        jQuery(tujuan).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '150px',
            enableCaseInsensitiveFiltering: true
        }).hide();

        jQuery(penunjang).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '150px',
            enableCaseInsensitiveFiltering: true
        }).hide();

        jQuery(obat).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '150px',
            enableCaseInsensitiveFiltering: true
        }).hide();

        jQuery(cara_keluar).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '150px',
            enableCaseInsensitiveFiltering: true
        }).hide();

        jQuery(tindakan).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '150px',
            enableCaseInsensitiveFiltering: true
        }).hide();

        jQuery(jenispenjualan).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '150px',
            enableCaseInsensitiveFiltering: true
        }).hide();

        jQuery(statusbayar).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '150px',
            enableCaseInsensitiveFiltering: true
        }).hide();

        jQuery(instalasipemesan_nama).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '150px',
            enableCaseInsensitiveFiltering: true
        }).hide();

        jQuery(ruanganpemesan_nama).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '150px',
            enableCaseInsensitiveFiltering: true
        }).hide();

        jQuery(obatalkes_kategori).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '150px',
            enableCaseInsensitiveFiltering: true
        }).hide();

        jQuery(pegawai).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '150px',
            enableCaseInsensitiveFiltering: true
        }).hide();

        jQuery(kunjungan).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '150px',
            enableCaseInsensitiveFiltering: true
        }).hide();

        jQuery(ruanganpemesan_id).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '150px',
            enableCaseInsensitiveFiltering: true
        }).hide();

        jQuery(asalrujukan_id).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '150px',
            enableCaseInsensitiveFiltering: true
        }).hide();

        jQuery(namaperujuk).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '150px',
            enableCaseInsensitiveFiltering: true
        }).hide();

        jQuery(nama_pegawai).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '150px',
            enableCaseInsensitiveFiltering: true
        }).hide();

    });
</script>