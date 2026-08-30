<div class="col-md-12">
    <p class="help-block"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>
    <div class="control-group">
        <?php echo CHtml::label("Kategori Pengadaan <span class='required'>*</span>", "", array('class' => 'control-label')); ?>
        <div class="controls">
            <?php
            echo CHtml::hiddenField('kategori_pengadaan' , 'Penyedia', array('class' => 'kategori_pengadaan')); 
            if (!empty($_GET['ubah'])) {
                echo $form->textField($model, 'kategori_pengadaan', array('class' => 'span3', 'readonly' => true));
            } else {
                echo $form->radioButtonList($model, 'kategoripengadaan', LookupM::getItems("kategoripengadaan"), array('onchange' => 'pilihKategori()', 'value' => 'Penyedia', 'class' => 'span1 kategoripengadaan', 'inline' => true, 'onkeypress' => "return $(this).focusNextInputField(event)")); 
            }
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Nomor Referensi <span class='required'>*</span>", "", array('class' => 'control-label')); ?>
        <div class="controls">
            <?php
                echo $form->hiddenField($model, 'rencanaumumpengadaan_id', array('class' => 'span3 rencana_id', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)"));
                echo $form->hiddenField($model, 'suratperjanjiankerja_id', array('class' => 'span3 spk_id', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)"));
            if (!empty($_GET['notadinaspptk_id'])) {
                echo $form->textField($model, 'persiapanpengadaan_nomor', array('class' => 'span3', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)"));
            } else {
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,
                    'attribute' => 'persiapanpengadaan_nomor',
                    'source' => 'js: function(request, response) {
                                    $.ajax({
                                            url: "' . $this->createUrl('AutocompleteDaftarNomor') . '",
                                            dataType: "json",
                                            data: {
                                                term: request.term,
                                                kategori_pengadaan: $(".kategori_pengadaan").val(),
                                            },
                                            success: function (data) {
                                                response(data);
                                            }
                                    })
                                 }',
                    'options' => array(
                        'showAnim' => 'fold',
                        'minLength' => 3,
                        'select' => 'js:function( event, ui ) {
                                        setPersiapanpengadaan(ui.item);
                                        return false;
                                    }',
                    ),
                    'htmlOptions' => array(
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'class' => 'span3 required',
                        'placeholder' => 'Ketikkan Nomor Surat Perjanjian Kerja'
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogPersiapan'),
                ));
            }
            ?>
        </div>
    </div>
    <div class="control-group" id="field-perintah-pengiriman" hidden="true">
        <label class="control-label"> Perintah Pengiriman </label>
        <div class="controls">
            <?php echo CHtml::activeDropDownList($model, 'perintahpengiriman_id', CHtml::listData(LookupM::model()->findAll("lookup_type = null AND lookup_aktif IS TRUE ORDER BY lookup_urutan ASC"), 'lookup_name', 'lookup_name'), array('empty' => '-- Pilih --', 'onblur' => "showTabelRincian('Penyedia')", 'class' => 'span3')); ?>
        </div>
    </div>
    <?php if (!empty($_GET['ubah']) && !empty($model->perintahpengiriman_id)) { ?>
    <div class="control-group" id="field-perintah-pengiriman">
        <label class="control-label"> Perintah Pengiriman </label>
        <div class="controls">
            <?php echo $form->hiddenField($model, 'perintahpengiriman_id', array('class' => 'span3', 'readonly' => true)); ?>
            <?php 
                $modPerintah = PerintahpengirimanT::model()->findByPk($model->perintahpengiriman_id);
                $nomor = "Termin ".$modPerintah->terminke." (".$modPerintah->termin_persen."%) - ".$modPerintah->perintahpengiriman_nomor;
                echo CHtml::textField('perintahpengiriman_nomor', $nomor, array('class' => 'span3', 'readonly' => true))?>
        </div>
    </div>
    <?php } ?>
    <div class="control-group">
        <?php echo CHtml::label("Tahun Anggaran", "", array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model, 'tahunanggaran', array('class' => 'span3', 'readonly' => true)); ?>
            <?php echo $form->hiddenField($model, 'unitkerja_id', array('class' => 'span3', 'readonly' => true)); ?>
            <?php echo $form->hiddenField($model, 'instalasi_id', array('class' => 'span3', 'readonly' => true)); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Program", "", array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model, 'programkerja_nama', array('class' => 'span6', 'readonly' => true)); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Kegiatan", "", array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model, 'kegiatanprogram_nama', array('class' => 'span6', 'readonly' => true)); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Sub Kegiatan", "", array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model, 'subkegiatanprogram_nama', array('class' => 'span6', 'readonly' => true)); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Paket Pekerjaan", "", array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model, 'paket_pekerjaan', array('class' => 'span6', 'readonly' => true)); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Kode Rekening", "", array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model, 'koderekening', array('class' => 'span6', 'readonly' => true)); ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label"> Lumsum </label>
        <div class="controls">
                <?php 
                    echo $form->checkBox($model, 'islumsum', array('onclick' => 'hitungTotalSeluruhnya()'));
                ?>
        </div>
    </div>
</div>


<?php
/* =========================== Dialog Persiapan Pengadaan ============================ */
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPersiapan',
    'options' => array(
        'title' => 'Pencarian Data Referensi',
        'autoOpen' => false,
        'modal' => true,
        'width' => 700,
        'resizable' => false,
    ),
));

$modPersiapan = new DaftarnomorNotadinaspptkV('search');
$modPersiapan->unsetAttributes();
if (isset($_GET['DaftarnomorNotadinaspptkV'])) {
    $modPersiapan->attributes = $_GET['DaftarnomorNotadinaspptkV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'daftarnomor-m-grid',
    'dataProvider' => $modPersiapan->searchDialog(),
    'filter' => $modPersiapan,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function($data) {
                $res = $data->attributes;   
                $res['kegiatanprogram_nama'] = '';
                $res['suratperjanjiankerja_id'] = '';
                $res['rencanaumumpengadaan_id'] = '';
                $res['perintah_pengiriman'] = "";
                $res['kegiatanprogram_nama'] .= !empty($data->subprogramkerja_kode) ? $data->subprogramkerja_kode . " - " . $data->subprogramkerja_nama : '';
                $res['nilai_hps'] = !empty($data->nilai_pekerjaan) ? number_format($data->nilai_pekerjaan, 2, ",", ".") : '';
                if ($data->kategori_pengadaan == "Penyedia") {
                    $modSPK = SuratperjanjiankerjaT::model()->findByPk($data->nomor_id);
                    $res['jenis_termin'] = ($modSPK->istermin == true) ? $modSPK['jenis_termin'] : "";
                    $modTermin = SuratperjanjiankerjaterminT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $modSPK->suratperjanjiankerja_id));
                    $res['tabel'] = '';
                    $a = '';
                    if (!empty($modTermin)) {
                        foreach($modTermin as $mod){
                            $a .= 
                                    "<tr>" .
                                        "<td>".$mod['terminke']."</td>" .
                                        "<td>".MyFormatter::formatUang($mod['jumlah_harga'], "Rp.", 2)."</td>" .
                                    "</tr>" ;
                        }
                    }
                    $res['tabel'] = $a; 
                    $res['suratperjanjiankerja_id'] = $data->nomor_id; 
                    $modPerintahPengiriman = PerintahpengirimanT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $res['suratperjanjiankerja_id']));
                    if (!empty($modPerintahPengiriman)) {
                        $res['perintah_pengiriman'] = count($modPerintahPengiriman);
                    }
                } else {
                    $res['rencanaumumpengadaan_id'] = $data->nomor_id; 
                }
                $res = json_encode($res);

                return CHtml::Link("<i class=\"icon-form-check\"></i>", "#", array(
                            "class" => "btn-small",
                            "id" => "persiapanpengadaan",
                            "onClick" => "setPersiapanpengadaan(" . $res . ");
                                          $('#dialogPersiapan').dialog('close');"
                ));
            },
        ),
        array(
            'header' => 'Nomor ',
            'name' => 'nomor_dokumen',
            'value' => '$data->nomor_dokumen',
        ),
        array(
            'header' => 'Nomor Dokumen',
            'name' => 'nomor_kontrak',
            'value' => '$data->nomor_kontrak',
        ),
        array(
            'header' => 'Tanggal',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tanggal_dokumen)',
            'filter' => $this->widget('MyDateTimePicker', array(
                'model' => $modPersiapan,
                'attribute' => 'tanggal_dokumen',
                'mode' => 'date',
                'options' => array(
                    'dateFormat' => Params::DATE_FORMAT
                ),
                'htmlOptions' => array('readonly' => false, 'id' => 'tanggal_dokumen', 'class' => 'dtPicker3'),
                    ), true
            ),
        ),
        array(
            'header' => 'Paket Pekerjaan',
            'name' => 'paket_pekerjaan',
            'filter' => CHtml::activeHiddenField($modPersiapan, 'kategori_pengadaan', array('class' => 'kategori_pengadaan')) . 
                        CHtml::activeTextField($modPersiapan, 'paket_pekerjaan') ,
            'value' => '$data->paket_pekerjaan',
        ),
        array(
            'header' => 'Nilai Pekerjaan',
            'value' => function($data){
                echo MyFormatter::formatUang($data->nilai_pekerjaan, "Rp.", 2);
                
            },
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});

            jQuery(\'#tanggal_dokumen\').datepicker(jQuery.extend({
                        showMonthAfterYear:false}, 
            jQuery.datepicker.regional[\'id\'], 
                       {\'dateFormat\':\'dd M yy\',\'maxDate\':\'d\',\'timeText\':\'Waktu\',\'hourText\':\'Jam\',\'minuteText\':\'Menit\',
                       \'secondText\':\'Detik\',\'showSecond\':true,\'timeOnlyTitle\':\'Pilih Waktu\',\'timeFormat\':\'hh:mms\',
                       \'changeYear\':true,\'changeMonth\':true,\'showAnim\':\'fold\',\'yearRange\':\'-80y:+20y\'})); 
            jQuery(\'#tanggal_dokumen_date\').on(\'click\', function(){jQuery(\'#tanggal_dokumen\').datepicker(\'show\');}); 
    }',
));
$this->endWidget();
/* ============================= end Persiapan Pengadaan ============================= */
?>
<script>
    /**
     * Set Persiapan Pengadaan
     * @param {type} data
     * @returns {undefined}
     */
    function setPersiapanpengadaan(data) {
        $("#notadinaspptk-t-form #NotadinaspptkT_rencanaumumpengadaan_id").val(data.rencanaumumpengadaan_id);
        $("#notadinaspptk-t-form #NotadinaspptkT_suratperjanjiankerja_id").val(data.suratperjanjiankerja_id);
        $("#notadinaspptk-t-form #NotadinaspptkT_persiapanpengadaan_nomor").val(data.nomor_dokumen);
        $("#notadinaspptk-t-form #NotadinaspptkT_programkerja_nama").val(data.programkerja_nama);
        $("#notadinaspptk-t-form #NotadinaspptkT_kegiatanprogram_nama").val(data.kegiatanprogram_nama);
        $("#notadinaspptk-t-form #NotadinaspptkT_subkegiatanprogram_nama").val(data.subkegiatanprogram_nama);
        $("#notadinaspptk-t-form #NotadinaspptkT_paket_pekerjaan").val(data.paket_pekerjaan);
        $("#notadinaspptk-t-form #NotadinaspptkT_dpa_pagu").val(data.dpa_pagu);
        $("#notadinaspptk-t-form #NotadinaspptkT_koderekening").val(data.kode_rekening);
        $("#notadinaspptk-t-form #NotadinaspptkT_mappingrekeninganggaran_id").val(data.mappingrekeninganggaran_id);
        $("#notadinaspptk-t-form #NotadinaspptkT_pegppk_id").val(data.pegawaippk_id);
        $("#notadinaspptk-t-form #NotadinaspptkT_pegppk_nama").val(data.nama_ppk);
        $("#notadinaspptk-t-form #NotadinaspptkT_kontrak_nomor").val(data.nomor_kontrak);
        $("#notadinaspptk-t-form #NotadinaspptkT_kontrak_tanggal").val(data.tanggal_dokumen);
        $("#notadinaspptk-t-form #NotadinaspptkT_supplier_id").val(data.supplier_id);
        $("#notadinaspptk-t-form #NotadinaspptkT_supplier_nama").val(data.supplier_nama);
        $("#notadinaspptk-t-form #NotadinaspptkT_supplier_alamat").val(data.supplier_alamat);
        $("#notadinaspptk-t-form #NotadinaspptkT_tahunanggaran").val(data.tahun);
        $("#notadinaspptk-t-form #NotadinaspptkT_islumsum").val(data.islumsum);
        $("#notadinaspptk-t-form #NotadinaspptkT_unitkerja_id").val(data.unitkerja_id);
        $("#notadinaspptk-t-form #NotadinaspptkT_instalasi_id").val(data.instalasi_id);
        $("#jenis_termin").val(data.jenis_termin);
        $("#tabelTermin").children("tbody").append(data.tabel);

        if (data.istermin == true) {
            $('#field-termin').removeAttr('hidden');
        } else {
            $('#field-termin').attr('hidden', true);
        }
            
        var kategoripengadaan = $(".kategoripengadaan:checked").attr('value');
        if (kategoripengadaan == 'Penyedia') {
            showTabelRincian('Penyedia');
            listTermin(data.suratperjanjiankerja_id);
        } else {
            showTabelRincian('Swakelola');
        }
        
        if (data.perintah_pengiriman > 0) {
            $('#field-perintah-pengiriman').removeAttr('hidden');
            listPerintahPengiriman(data.nomor_id);
        } else {
            $('#field-perintah-pengiriman').attr('hidden', true);
        }
                
        $('.spk_id').val(data.suratperjanjiankerja_id);
        setTimeout(function () {
            $.fn.yiiGridView.update('dialogrincianspk-m-grid', {
                data: {
                    "SuratperjanjiankerjarincianT[suratperjanjiankerja_id]": data.suratperjanjiankerja_id,
                    "SuratperjanjiankerjarincianT[default]": 'ada'
                }
            });
        }, 500);
        
        $('.rencanaumumpengadaan_id').val(data.rencanaumumpengadaan_id);
        setTimeout(function () {
            $.fn.yiiGridView.update('dialogrincianrup-m-grid', {
                data: {
                    "ADRencanaumumpengadaandetT[rencanaumumpengadaan_id]": data.rencanaumumpengadaan_id,
                    "ADRencanaumumpengadaandetT[default]": 'ada'
                }
            });
        }, 500);        
    }
    
    function listTermin(suratperjanjiankerja_id) {
    $.get("<?php echo Yii::app()->createUrl('pengadaan/notadinaspptkT/setDropdownTermin'); ?>", { suratperjanjiankerja_id:suratperjanjiankerja_id },
        function(data){
           
            $('#NotadinaspptkT_termin').html(data.list_termin);
    }, "json");
    }
    
    function listPerintahPengiriman(suratperjanjiankerja_id) {
    $.get("<?php echo Yii::app()->createUrl('pengadaan/notadinaspptkT/setDropdownPerintahPengiriman'); ?>", {suratperjanjiankerja_id:suratperjanjiankerja_id },
        function(data){
            $('#NotadinaspptkT_perintahpengiriman_id').html(data.list_perintah_pengiriman);
    }, "json");
    }
    
    function pilihKategori() {
        var kategoripengadaan = $(".kategoripengadaan:checked").attr('value');
        if (kategoripengadaan == 'Penyedia') {
            $('#field-termin').attr('hidden', true);
            $('#formKontrak').show(); 
            refreshDialog('Penyedia');
            document.getElementById("NotadinaspptkT_persiapanpengadaan_nomor").placeholder = "Ketik Nomor Surat Perjanjian Kerja";
        } else {
            $('#formKontrak').hide(); 
            refreshDialog('Swakelola');
            document.getElementById("NotadinaspptkT_persiapanpengadaan_nomor").placeholder = "Ketik Nomor Rencana Umum Pengadaan";
        }
        resetField();
    }
    
    function resetField(){
        $("#notadinaspptk-t-form #NotadinaspptkT_rencanaumumpengadaan_id").val('');
        $("#notadinaspptk-t-form #NotadinaspptkT_suratperjanjiankerja_id").val('');
        $("#notadinaspptk-t-form #NotadinaspptkT_persiapanpengadaan_nomor").val('');
        $("#notadinaspptk-t-form #NotadinaspptkT_programkerja_nama").val('');
        $("#notadinaspptk-t-form #NotadinaspptkT_kegiatanprogram_nama").val('');
        $("#notadinaspptk-t-form #NotadinaspptkT_subkegiatanprogram_nama").val('');
        $("#notadinaspptk-t-form #NotadinaspptkT_paket_pekerjaan").val('');
        $("#notadinaspptk-t-form #NotadinaspptkT_dpa_pagu").val('');
        $("#notadinaspptk-t-form #NotadinaspptkT_koderekening").val('');
        $("#notadinaspptk-t-form #NotadinaspptkT_mappingrekeninganggaran_id").val('');
        $("#notadinaspptk-t-form #NotadinaspptkT_pegppk_id").val('');
        $("#notadinaspptk-t-form #NotadinaspptkT_pegppk_nama").val('');
        $("#notadinaspptk-t-form #NotadinaspptkT_kontrak_nomor").val('');
        $("#notadinaspptk-t-form #NotadinaspptkT_kontrak_tanggal").val('');
        $("#notadinaspptk-t-form #NotadinaspptkT_supplier_id").val('');
        $("#notadinaspptk-t-form #NotadinaspptkT_supplier_nama").val('');
        $("#notadinaspptk-t-form #NotadinaspptkT_supplier_alamat").val('');
        $("#notadinaspptk-t-form #NotadinaspptkT_tahunanggaran").val('');
        $("#notadinaspptk-t-form #NotadinaspptkT_instalasi_id").val('');
        $("#notadinaspptk-t-form #NotadinaspptkT_unitkerja_id").val('');
        $("#notadinaspptk-t-form #NotadinaspptkT_termin").val('-- Pilih --');
        $("#jenis_termin").val('');
        $("#tabelRincian tbody tr").detach();
    }
    
    function refreshDialog(jenis){
        $('.kategori_pengadaan').val(jenis);
        setTimeout(function () {
            $.fn.yiiGridView.update('daftarnomor-m-grid', {
                data: {
                    "DaftarnomorNotadinaspptkV[kategori_pengadaan]": jenis,
                    "DaftarnomorNotadinaspptkV[default]": 'ada'
                }
            });
        }, 500);
    }
</script>