<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END);
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title"><strong> Rencana Umum Pengadaan </strong></div>
            </div>
            <div class="panel-body">
                <?php
                $this->widget('bootstrap.widgets.BootAlert');

                $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                    'id' => 'rup-t-form',
                    'enableAjaxValidation' => false,
                    'type' => 'horizontal',
                    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
                ));
                ?>
                <?php
                if (isset($_GET['sukses'])) {
                    Yii::app()->user->setFlash('success', "Data Berhasil disimpan");
                }                
                ?>
                <p class="help-block"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title"> <b> Tambah RUP </b></div>
                    </div>
                    <div class="panel-body">                        
                        <?php echo $this->renderPartial('_formRUP', array('model' => $model, 'modLokasi' => $modLokasi, 'arrLokasi' => $arrLokasi, 'form' => $form), true); ?>
                    </div>
                </div>
                    <?php echo CHtml::hiddenField('noRow',0,array('readonly'=>true)); ?>
                    <div class="panel panel-success panel-shadow" id="RAB" style="display: none">
                        <div class="panel-heading">
                            <div class="panel-title"><b> RAB/HPS</b></div>
                        </div>
                        <div class="panel-body overflow-x">
                            <table class="table table-bordered table-striped table-condensed" id="tabelRAB">

                            </table>
                            <?php echo $form->hiddenField($model,'total_harga',array('readonly'=>true, 'class'=>'integer-decimal')); ?>
                            <?php echo $form->hiddenField($model,'total_pajak',array('readonly'=>true, 'class'=>'integer-decimal')); ?>
                            <?php echo CHtml::hiddenField('jenis_trans','paket',array('readonly'=>true, 'class'=>'')); ?>
                        </div>
                    </div>
                    <?php if (!empty($_GET['sukses'])) { ?>
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <div class="panel-title"> <b> RAB/HPS </b></div>
                        </div>
                        <div class="panel-body overflow-x">
                                <table class="table table-condensed table-bordered table-striped" id="tabel-hps">
                                    <thead>
                                    <th>No.</th>        
                                    <th>Jenis Barang/Jasa</th>
                                    <th>Satuan</th>
                                    <th>Volume<span class="required">*</span></th>
                                    <th>Harga (Rp)<span class="required">*</span></th>
                                    <th>Pajak (%)<span class="required">*</span></th>
                                    <th>Jumlah Harga (Rp)<span class="required">*</span></th>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $total = 0;
                                        $i = 1;
                                        $det = RencanaumumpengadaandetT::model()->findAllByAttributes(array('rencanaumumpengadaan_id' => $_GET['rencanaumumpengadaan_id']));
                                        $tr = "";
                                        foreach ($det as $key => $value) {
                                            $value->jumlah = number_format($value->rencanaumumpengadaandet_jumlah, 2, ",", ".");
                                            $value->harga = number_format($value->rencanaumumpengadaandet_harga, 2, ",", ".");
                                            $value->rencanaumumpengadaandet_volume = number_format($value->rencanaumumpengadaandet_volume, 2, ",", ".");
                                            $tr .= $this->renderPartial("_rowRAB", array('modRAB' => $value, 'i' => $i++), true);
                                            $total += $value->rencanaumumpengadaandet_jumlah;
                                        }
                                        echo $tr;
                                        ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="6" style="text-align: right;"><label>Total Harga</label></th>
                                            <th>
                                                <?php
                                                echo CHtml::textField('total_hargaseluruhnya', number_format($total, 2, ",", "."), array('readonly' => true, 'class' => 'required integer-decimal harga'));
                                                ?>
                                            </th>
                                            <th>
                                                <?php
                                                echo CHtml::textField('total_sisapagu', number_format($total, 2, ",", "."), array('readonly' => true, 'class' => 'required integer-decimal harga'));
                                                ?>
                                            </th>
                                        </tr>
                                    </tfoot>
                                </table>
                            
                            <table class="table table-bordered table-striped table-condensed" id="tabelRAB">

                            </table>
                        </div>
                    </div>
                    <?php } ?>
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <div class="panel-title"> <b> Dana </b></div>
                        </div>
                        <div class="panel-body">
                            <?php echo $this->renderPartial('_formDana', array('model' => $model, 'modSumberDana' => $modSumberDana, 'modJenis' => $modJenis, 'arrSumberDana' => $arrSumberDana, 'arrJenis' => $arrJenis, 'form' => $form), true); ?>
                        </div>
                    </div>
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <div class="panel-title"> <b> Jadwal </b></div>
                        </div>
                        <div class="panel-body">
                            <?php echo $this->renderPartial('_formJadwal', array('model' => $model, 'form' => $form), true); ?>
                        </div>
                    </div>
                    
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <div class="panel-title"> <b> Organ Pengadaan </b></div>
                        </div>
                        <div class="panel-body">
                            <?php echo $this->renderPartial('_formPejabat', array('model' => $model, 'form' => $form), true); ?>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="form-actions">
                            <?php echo $form->hiddenField($model, 'statusnya', array('class' => 'span4')); ?>
                            <?php
                            $sukses = isset($_GET['sukses']) ? $_GET['sukses'] : null;
                            $disabledSave = ($sukses == 1) ? true : false;
                            ?>
                            <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => (isset($_GET['sukses'])) ? 'btn btn-danger' : 'btn btn-danger submit', 'id' => 'btn_submit', 'type' => 'button', 'onKeypress' => 'return formSubmit(this,event)', 'disabled' => $disabledSave, 'onclick' => 'cekSimpanRUP();return false;')); ?>
                            <?php // echo CHtml::htmlButton(Yii::t('mds', '{icon} Ajukan RUP', array('{icon}' => '<i class="entypo-upload-cloud"></i>')), array('class' => (isset($_GET['sukses'])) ? 'btn btn-success' : 'btn btn-primary submit', 'type' => 'button', 'onKeypress' => 'return formSubmit(this,event)', 'disabled' => $disabledSave, 'onclick' => 'cekSimpanRUP2();return false;')); ?>
                            <?php
                            echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="icon-refresh"></i>')), $this->createUrl('index'), array('class' => 'btn btn-default',
                                'onclick' => 'return refreshForm(this);'));
                            ?>
                        </div>
                    </div>
                </div>

                <?php echo $this->renderPartial('_jsFunction', array('model' => $model, 'modLokasi' => $modLokasi, 'modSumberDana' => $modSumberDana, 'modJenis' => $modJenis, 'form' => $form), true); ?>
                <?php echo $this->renderPartial('_dialog', array(), true); ?>
                <?php $this->endWidget(); ?>
            </div>
        </div>
    </div>
</div>

<script>
    /**
     * cek instalasi
     * @param {type} obj
     * @returns {undefined}
     */
    function cekInstalasi(obj) {
        $("#rup-t-form #ADRencanaumumpengadaanT_subprogram_id").val('');
        $("#rup-t-form #ADRencanaumumpengadaanT_subkegiatanprogram_id").val('');
        $("#rup-t-form #ADRencanaumumpengadaanT_subkegiatanprogram_nama").val('');
        $("#rup-t-form #ADRencanaumumpengadaanT_nama_pekerjaan").val('');
        $("#rup-t-form #program").val('');
        $("#rup-t-form #kegiatan").val('');
        $("#tabelRAB").html('');
        $("#totalnya").html('');
    }
    /**
     * Digunakan untuk menghitung di tabel RAB
     * @returns {undefined}
     */
    function hitung() {
        var total_harga = 0;
        var total_pajak = 0;
        var grandtotal = 0;
        var total_hargas = 0;
        var total_pajaks = 0;
        var grandtotals = 0;
        var grandtotalss = 0;
        var total_sisapagu = 0;
        var aa = 0;
        var bb = 0;
        var cc = 0;
        
        unformatNumberSemua();
        var totals = 0;
        var hit_pajaks = 0;
        var harga_vols = 0;
        $("#tabelRAB > tbody > tr").each(function () {
            var volume = parseFloat($(this).find(".volume").val());
            var harga = parseFloat($(this).find(".estimasi").val());
            var pajak = parseFloat($(this).find(".persenpajak").val());
            var sisapagu_pengadaan = parseFloat($(this).find(".sisapagu_pengadaan").val());
            if (volume != '' && harga != '' && pajak != '') {
                volume = volume;
                harga = harga;
                pajak = pajak;

                var hit_pajak = ((volume * harga * pajak) / 100);
                var harga_vol = (volume * harga);
                var total = (harga_vol) + (hit_pajak);
                
                total_harga += harga_vol;
                total_pajak += hit_pajak;
                total_sisapagu += sisapagu_pengadaan;
                grandtotal += parseFloat(total.toFixed(2));                
                $(this).find('.pajak').val(hit_pajak.toFixed(2));
                $(this).find('.harga').val(total.toFixed(2));
                $(this).find('.estimasi').val(harga);
                
                if (total.toFixed(2) > sisapagu_pengadaan) {
                    $(this).find('td').attr('style', 'background: #ffcece !important');
                    toastr.error("Jumlah yang diadakan tidak boleh melebihi sisa pagu", "Perhatian!");
                } else {
                    $(this).find('td').attr('style', 'background: white !important');
                }
            }
        });

        var dpa = $("#ADRencanaumumpengadaanT_dpa_pagu").val();        
        var totItemRBA = $("#tabelRAB > tbody > tr").length;
        var totTempTempRBA = $("#totItemRAB").val();
        $("#total_hargaseluruhnya").val(grandtotal.toFixed(2));        
        $("#total_sisapagu").val(total_sisapagu.toFixed(2));        
        $("#<?php echo CHtml::activeId($model, 'total_harga') ?>").val(total_harga.toFixed(2));
        $("#<?php echo CHtml::activeId($model, 'total_pajak') ?>").val(total_pajak.toFixed(2));
        
        setPaguDPA();
        formatNumberSemua();
        hitungTotalSumberDana();        
        hitungTotalJenisPengadaan();
    }
    
    /**
     * load metode pengadaan
     * @param {type} subkegiatanprogram_id
     * @param {type} instalasi_id
     * @param {type} periodeanggaran_id
     * @returns {undefined}
     */
    function loadMetodePengadaan(subkegiatanprogram_id, instalasi_id, periodeanggaran_id){
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('loadMetode'); ?>',
            data: {
                subkegiatanprogram_id: subkegiatanprogram_id,
                instalasi_id: instalasi_id,
                periodeanggaran_id: periodeanggaran_id
            },
            dataType: "json",
            success: function (data) {                
                $("#ADRencanaumumpengadaanT_metodepengadaan_id").val(data.metode);
                $("#ADRencanaumumpengadaanT_rencanaumumpengadaan_kategori").val(data.kategori);
                
                $("#ADRencanaumumpengadaanT_rencanaumumpengadaan_kategori").change();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
 
    /**
     * Digunakan sebagai autocomplete data pegawai
     * @param {type} data
     * @returns {undefined}
     */
    function setData(data,obj, jenis) {
    
        var cek = 0;
        
         if (typeof obj === 'undefined' || obj == null){
            var row = $('#noRow').val();            
        }else{
            var row = $(obj).parents("tr").attr('rowdata');
        }
        
        if (jenis != 'paket'){
            $("#tabel-subkegiatan-list > tbody > tr").each(function(){            
                if (    
                        $(this).find('.subkegiatanprogram_id').val() == data.subkegiatanprogram_id 
                        && 
                        $(this).find('.subkegiatanprogram_id').val() == data.subkegiatanprogram_id
                    ){
                    cek++;
                }
            });                                
            

            if (cek > 0){
                toastr.warning("Sub Kegiatan sudah dipilih","Perhatian!");
                $("#tabel-subkegiatan-list > tbody > tr[rowdata='"+row+"']").find('.programkerja_id').val("");
                $("#tabel-subkegiatan-list > tbody > tr[rowdata='"+row+"']").find('.program').html("");        
                $("#tabel-subkegiatan-list > tbody > tr[rowdata='"+row+"']").find('.subprogramkerja_id').val("");
                $("#tabel-subkegiatan-list > tbody > tr[rowdata='"+row+"']").find('.kegiatanprogram_id').val("");
                $("#tabel-subkegiatan-list > tbody > tr[rowdata='"+row+"']").find('.kegiatan').html("");
                $("#tabel-subkegiatan-list > tbody > tr[rowdata='"+row+"']").find('.subkegiatanprogram_id').val("");
                $("#tabel-subkegiatan-list > tbody > tr[rowdata='"+row+"']").find('.subkegiatanprogram_nama').val("");            
                return false;
            }
            
            $("#tabel-subkegiatan-list > tbody > tr[rowdata='"+row+"']").find('.programkerja_id').val(data.programkerja_id);
            $("#tabel-subkegiatan-list > tbody > tr[rowdata='"+row+"']").find('.program').html(data.programkerja_nama);        
            $("#tabel-subkegiatan-list > tbody > tr[rowdata='"+row+"']").find('.subprogramkerja_id').val(data.subprogramkerja_id);
            $("#tabel-subkegiatan-list > tbody > tr[rowdata='"+row+"']").find('.kegiatanprogram_id').val(data.kegiatanprogram_id);
            $("#tabel-subkegiatan-list > tbody > tr[rowdata='"+row+"']").find('.kegiatan').html(data.subprogramkerja_nama);
            $("#tabel-subkegiatan-list > tbody > tr[rowdata='"+row+"']").find('.subkegiatanprogram_id').val(data.value);
            $("#tabel-subkegiatan-list > tbody > tr[rowdata='"+row+"']").find('.subkegiatanprogram_nama').val(data.label);
            $("#tabel-subkegiatan-list > tbody > tr[rowdata='"+row+"']").find('.subkegiatanprogram_id').val(data.subkegiatanprogram_id);
            $("#tabel-subkegiatan-list > tbody > tr[rowdata='"+row+"']").find('.subkegiatanprogram_nama').val(data.subkegiatanprogram_nama);        
        }else{
            $("#tabel-subkegiatan-list > tbody > tr").each(function(){                                      
                if ($(this).find('.subkegiatanprogram_id').val() == data.subkegiatanprogram_id){
                    cek++;
                }
            }); 
            
            if (cek == 0){                
                if ($("#tabel-subkegiatan-list > tbody > tr[rowdata='"+row+"'] ").html() == null){
                    $("#tabel-subkegiatan-list > tbody ").append(data.html);
                }else{
                    $("#tabel-subkegiatan-list > tbody > tr[rowdata='"+row+"']  ").replaceWith(data.html);
                }
                renameInputRow($("#tabel-subkegiatan-list"));
            }
        }
                        
            
        var cek_map = 0;
            
        $("#tabel-sumberdana > tbody > tr").find('.mappingrekeninganggaran_id').each(function(){            
            var komponen_kegiatan = $(this).parents('tr').find('.komponen_kegiatan').val();            
            if ($(this).val() != '') {
                if ($(this).val() == data.mappingrekeninganggaran_id && komponen_kegiatan == data.subprogramkerja_nama) {
                    cek_map++;
                }
            }
        });
            
        if (cek_map == 0){
            $("#tabel-sumberdana > tbody > tr[data-row='"+row+"']").find('.mappingrekeninganggaran_id').val(data.mappingrekeninganggaran_id);
            $("#tabel-sumberdana > tbody > tr[data-row='"+row+"']").find('.rekeninganggaran5_id').val(data.rekeninganggaran5_id);
            $("#tabel-sumberdana > tbody > tr[data-row='"+row+"']").find('.mak_nama').val(data.kodeanggaran+' - '+data.nama_rekeninganggaran5);
            $("#tabel-sumberdana > tbody > tr[data-row='"+row+"']").find('.kegiatanprogram_id').val(data.kegiatanprogram_id);
            $("#tabel-sumberdana > tbody > tr[data-row='"+row+"']").find('.komponen_kegiatan').val(data.subprogramkerja_nama);
        }
            
        $("#dialogSubKegiatan").dialog('close');
//        $("#rup-t-form") #ADRencanaumumpengadaanT_subprogram_id").val(data.subprogramkerja_id);
//        $("#rup-t-form #ADRencanaumumpengadaanT_subkegiatanprogram_id").val(data.value);
//        $("#rup-t-form #ADRencanaumumpengadaanT_subkegiatanprogram_nama").val(data.label);
//        $("#rup-t-form #ADRencanaumumpengadaanT_subkegiatanprogram_id").val(data.subkegiatanprogram_id);
//        $("#rup-t-form #ADRencanaumumpengadaanT_subkegiatanprogram_nama").val(data.subkegiatanprogram_nama);
        var subpertama = $("#tabel-subkegiatan-list > tbody > tr:first").find('.subkegiatanprogram_id').val();
        
//        if (subpertama != '' && subpertama == data.subkegiatanprogram_id){
//            $("#rup-t-form #ADRencanaumumpengadaanT_nama_pekerjaan").val(data.subkegiatanprogram_nama);
//        }
        
        if (jenis == 'nonpaketsub'){
            showRAB();
            showTabelRAB();
        }
//        $("#rup-t-form #program").val(data.programkerja_nama);
//        $("#rup-t-form #kegiatan").val(data.subprogramkerja_nama);
//        $("#rup-t-form #mappingrekeninganggaran_id").val(data.mappingrekeninganggaran_id);
        //$("#rup-t-form #ADRencanaumumpengadaanT_rencanaumumpengadaan_kategori").val(data.kategori_pengadaan);
        
        //loadMetodePengadaan(data.subkegiatanprogram_id,data.instalasi_id,data.periodeanggaran_id);                                                
    }

    /**
     * Show RAB
     * @returns {undefined}
     */
    function showRAB() {
        setTimeout(function(){
            var x = document.getElementById("RAB");
            var a = $("#tabel-subkegiatan-list > tbody > tr:first").find('.subkegiatanprogram_id').val();

            if (typeof a !== 'undefined'  && a != '') {
                if (x.style.display === "none") {
                    x.style.display = "block";
                }
            }
        },500);        
    }

    /**
     * Menampilkan Pejabat PPK
     * @returns {undefined}
     */
    function showPejabatPPK() {
        var instalasi_id = $("#ADRencanaumumpengadaanT_instalasi_id").val();
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('generatePegawaiPPK'); ?>',
            data: {instalasi_id: instalasi_id},
            dataType: "json",
            success: function (data) {
                if (data.sukses == 1) {
                    //$("#ppk").html(data.html);
                    $("#tabelRAB").html('');
//                    setTimeout(function () {
//                        $.fn.yiiGridView.update('kegiatan-t-grid', {
//                            data: {
//                                "DokumenpelaksanaananggarandetT[unitkerja_id]": data.unitkerja_id,
//                            }
//                        });
//                    }, 500);
                } else {
                    myAlert(data.pesan);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    /**
     * Menampilkan pejabat PA dan KPA
     * @returns {undefined}
     */
    function showPejabatPAKPA() {
        var periodeanggaran_id = $("#ADRencanaumumpengadaanT_periodeanggaran_id").val();
        var instalasi_id = $("#ADRencanaumumpengadaanT_instalasi_id").val();
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('generatePegawaiPAKPA'); ?>',
            data: {periodeanggaran_id: periodeanggaran_id, instalasi_id:instalasi_id},
            dataType: "json",
            success: function (data) {
                if (data.sukses == 1) {
                    //$("#papa").html(data.html);
                    $("#papa").html(data.html_pa);
                    reset_pejabat();
                } else {
                    myAlert(data.pesan);
                    reset_pejabat();
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    /**
     * Generate tabel RAB
     * @returns {undefined}
     */
    function showTabelRAB() {
        var unitkerjanya = $("#ADRencanaumumpengadaanT_unitkerja_id").val();        
        var periodeanggaran_id = $("#ADRencanaumumpengadaanT_periodeanggaran_id").val();
        //var subkegiatanprogram_id = $("#ADRencanaumumpengadaanT_subkegiatanprogram_id").val();
        var mappingrekeninganggaran_id = $("#mappingrekeninganggaran_id").val();
        var subkegiatanprogram_id = new Array();
        
        $("#tabel-subkegiatan-list > tbody > tr").find('.subkegiatanprogram_id').each(function(index){
            if ($(this).val() != ''){
                subkegiatanprogram_id[index] = $(this).val();                
            }
        })
        
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('generateTableRAB'); ?>',
            data: {
                unitkerjanya: unitkerjanya, 
                periodeanggaran_id: periodeanggaran_id,
                subkegiatanprogram_id: subkegiatanprogram_id,                
            },
            dataType: "json",
            success: function (data) {
                if (data.sukses == 1) {
                    $("#tabelRAB").html(data.html);
                    $("#totalnya").html(data.valtotal);                    
                    
                    //clearMAK();
                    
                    //$("#tabel-sumberdana > tbody").html(data.sumberdana);
                    //$("#tabel-sumberdana > tbody > tr:first").find('.sumberanggaran_id').change();
                   // renameInputSumberDana();                    
                                        
                    renameInputRow($("#tabelRAB"));
                    $("#tabelRAB, #tabel-sumberdana").find('input[class*="integer-decimal"]').unmaskMoney();
                    $("#tabelRAB, #tabel-sumberdana").find('input[class*="integer-decimal"]').maskMoney(
                        {"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":2}
                    );  
                    $("#tabelRAB").find('input[class*="float2"]').unmaskMoney();
                    $("#tabelRAB").find('input[class*="float2"]').maskMoney(
                        {"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":"","precision":2}
                    );
            
                    refreshBarangJasa();
            
                    generateExt();
                    hitung();                                                                                
                } else {
                    myAlert(data.pesan);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }            
    
    function clearMAK(){
        var i = 0;
        $("#tabel-sumberdana > tbody > tr").each(function(){
            $(this).find('.mak_id').val('');
            $(this).find('.kegiatanprogram_id').val('');
            $(this).find('.mak_nama').val('');
            if (i>0){
                $(this).parents("tr").remove();
            }
            i++;
        });
    }

    $(document).ready(function () {
//        $('form').bind('click keyup select change', function (event) {
//            cekDisabled(this);
//        });
//        $(document).on('click keyup select change', function () {
//            cekDisabled('form');
//        });
//        cekDisabled('form');

        $("form").find('.float2').each(function () {
            $(this).val(formatFloat($(this).val()));
        });
    });
</script>