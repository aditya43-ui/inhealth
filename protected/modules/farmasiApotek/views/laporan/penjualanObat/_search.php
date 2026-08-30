<div class="search-form">
    <?php
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/dropdownMulti.js', CClientScript::POS_END);

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
    <fieldset>

        <div class="row">
            <div class="col-sm-6" id="jenispenjualan">
                <?php echo CHtml::hiddenField('type', ''); ?>
                <div class="control-group">
                    <?php echo $form->hiddenField($model, 'jns_periode', array('class' => 'span2')); ?>
                    <?php echo $form->hiddenField($model, 'bln_awal', array('class' => 'span2')); ?>
                    <?php echo $form->hiddenField($model, 'bln_akhir', array('class' => 'span2')); ?>
                    <?php echo $form->hiddenField($model, 'thn_awal', array('class' => 'span2')); ?>
                    <?php echo $form->hiddenField($model, 'thn_akhir', array('class' => 'span2')); ?>
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

                <?php
                echo CHtml::hiddenField('filter', 'jenispenjualan', array('disabled' => 'disabled')) .
                    '<div class="control-group">
                                        ' . CHtml::label('Jenis Penjualan', 'jenispenjualan', array('class' => 'control-label')) . ' 
                                        <div class="controls">
                                            ' . $form->dropDownList($model, 'jenispenjualan', LookupM::getItems('jenispenjualan'), array(
                        'class' => 'form-control', 'multiple' => 'multiple'
                    )) . '
                                        </div>
                                    </div>';

                echo CHtml::hiddenField('filter', 'dokter', array('disabled' => 'disabled')) .
                    '<div class="control-group">
                                        ' . CHtml::label('Dokter', 'jenispenjualan', array('class' => 'control-label')) . ' 
                                        <div class="controls">
                                            ' . $form->dropDownList($model, 'pegawai_id', DokterV::model()->getDropDokterResep(), array(
                        'class' => 'form-control span4', 'multiple' => 'multiple'
                    )) . '
                                        </div>
                                    </div>';

                /*
                    $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                        'id' => 'jenispenjualan',
                        'slide' => true,
                        'content' => array(
                            'content2' => array(
                                'multi' => 'multi',
                                'header' => 'Berdasarkan Jenis Penjualan',
                                'isi' => 
                                'active' => true,
                            ),
                        ),
                    ));
                 * 
                 */
                ?>
            </div>
            <div class="col-sm-6" id="jenispenjualan">

                <div class="control-group">
                    <?php echo CHtml::label("Kategori", '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($model, 'obatalkes_kategori', ObatAlkesKategori::items(), array('empty' => '-- Pilih --', 'class' => 'span4')) ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label("Golongan", '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($model, 'obatalkes_golongan', ObatAlkesGolongan::items(), array('empty' => '-- Pilih --', 'class' => 'span4')) ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label("Nama Obat", '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'obatalkes_nama', array('placeholder' => 'Nama Obat', 'class' => 'span4')) ?>
                    </div>
                </div>

                <?php

                /*
                    $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                        'id' => 'jenispenjualan',
                        'slide' => true,
                        'content' => array(
                            'content3' => array(
                                'multi' => 'multi',
                                'header' => 'Berdasarkan Dokter',
                                'isi' => CHtml::hiddenField('filter', 'dokter', array('disabled' => 'disabled')) . 
                                    '<div class="control-group">
                                        '.CHtml::label('Dokter','jenispenjualan', array('class' => 'control-label')).' 
                                        <div class="controls">
                                            '.$form->dropDownList($model, 'pegawai_id', DokterV::model()->getDropDokterResep(),array(
                                            'class'=>'form-control', 'multiple'=>'multiple')).'											
                                        </div>
                                    </div>',
                                'active' => true,
                            ),
                        ),
                    ));
                 * 
                 */
                ?>
                <?php //echo $form->dropDownListRow($model, 'jenispenjualan', LookupM::getItems('jenispenjualan'),array('empty'=>'-- Pilih --', 'autofocus'=>true)); 
                ?>
            </div>
        </div>
        <div class="form-actions">
            <?php
            echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan')
            );
            ?>
            <?php echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                array(
                    'title' => 'Ulang', 'class' => 'btn btn-default', 'type' => 'reset',
                    'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                )
            ); ?>
        </div>
    </fieldset>
    <?php //$this->widget('UserTips', array('type' => 'create')); 
    ?>
</div>
<?php
$this->endWidget();
?>

<?php
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai

Yii::app()->clientScript->registerScript('reloadPage', '
    function konfirmasi(){
        window.location.href="' . Yii::app()->createUrl($module . '/' . $controller . '/LaporanPenjualanObat', array('modul_id' => Yii::app()->session['modul_id'])) . '";
    }', CClientScript::POS_HEAD); ?>

<script type="text/javascript">
    function ubahJnsPeriode() {
        var obj = $("#<?php echo CHtml::activeId($model, 'jns_periode') ?>");
        if (obj.val() == 'hari') {
            $('.hari').show();
            $('.bulan').hide();
            $('.tahun').hide();
        } else if (obj.val() == 'bulan') {
            $('.hari').hide();
            $('.bulan').show();
            $('.tahun').hide();
        } else if (obj.val() == 'tahun') {
            $('.hari').hide();
            $('.bulan').hide();
            $('.tahun').show();
        }
    }

    $(document).ready(function() {
        dropMulti('<?php echo CHtml::activeId($model, 'pegawai_id') ?>');

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

    });
</script>