<div id="form-caripemeriksaan" class="form-horizontal">
    <?php echo CHtml::activeHiddenField($modPemeriksaanRad, 'ruangan_id', array('readonly' => true, 'class' => 'span3')); ?>
    <?php echo CHtml::activeHiddenField($modPemeriksaanRad, 'penjamin_id', array('readonly' => true, 'class' => 'span3')); ?>
    <?php echo CHtml::activeHiddenField($modPemeriksaanRad, 'kelaspelayanan_id', array('readonly' => true, 'class' => 'span3')); ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="control-group" style="float:left;" hidden>
                <?php echo CHtml::activeLabel($modPemeriksaanRad, 'jenispemeriksaanrad_id', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php //echo CHtml::activeTextField($modPemeriksaanRad, 'jenispemeriksaanrad_nama',array('class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)","onchange"=>"updateChecklistPemeriksaanRad();",)); 
                    ?>
                    <?php echo CHtml::activeDropDownList($modPemeriksaanRad, 'jenispemeriksaanrad_nama', CHtml::listData(JenispemeriksaanradM::model()->findAll("jenispemeriksaanrad_aktif = TRUE ORDER BY jenispemeriksaanrad_nama ASC"), 'jenispemeriksaanrad_nama', 'jenispemeriksaanrad_nama'), array("onchange" => "updateChecklistPemeriksaanRad();", 'empty' => '-- Pilih --')) ?>
                </div>
            </div>
            <div class="control-group" style="float:left;">
                <?php echo CHtml::activeLabel($modPemeriksaanRad, 'pemeriksaanrad_id', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo CHtml::activeTextField($modPemeriksaanRad, 'pemeriksaanrad_nama', array('placeholder' => 'Pemeriksaan', 'class' => 'span3 custom-only', 'onkeyup' => "return $(this).focusNextInputField(event)", "onchange" => "updateChecklistPemeriksaanRad();",)); ?>
                </div>
                <?php echo CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', "onclick" => "updateChecklistPemeriksaanRad();", 'rel' => 'tooltip', 'title' => 'Klik untuk mencari pemeriksaan')); ?>
                <?php echo CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), array('class' => 'btn btn-default', 'type' => 'button', "onclick" => "setChecklistPemeriksaanRadReset();", 'rel' => 'tooltip', 'title' => 'Klik untuk mengulang pemeriksaan')); ?>
            </div>
            <div class="control-group">
                <label class="control-label">Pemeriksaan Radiologi</label>
                <div class="controls">
                    <?php
                echo CHtml::activeHiddenField($modPemeriksaanRad,'pemeriksaanrad_id',array('readonly'=>true));

                        $this->widget('MyJuiAutoComplete', array(    
                            'model'=>$modPemeriksaanRad,
                            'attribute' => 'pemeriksaanrad_nama',
                            'source'=>'js: function(request, response) {
                                            $.ajax({
                                                url: "' . $this->createUrl('AutocompletePemeriksaanRad') . '",
                                                dataType: "json",
                                                data: {
                                                    term: request.term,
                                                },
                                                success: function (data) {
                                                        response(data);
                                                }
                                            })
                                         }',
                             'options'=>array(
                                    'showAnim'=>'fold',
                                    'minLength' => 3,
                                    'focus'=> 'js:function( event, ui ) {
                                         $(this).val("");
                                         return false;
                                     }',
                                    'select'=>'js:function( event, ui ) {
                                         $(this).val(ui.item.label);
                                         $("#RIAsesmenAwalKeperawatanT_dpjp_id").val(ui.item.value);
                                         $("#RIAsesmenAwalKeperawatanT_dpjp_nama").val(ui.item.label);
                                         return false;
                                     }',
                             ),
                        'htmlOptions'=>array(
                            'readonly'=>false,
                            'placeholder'=>'Pemeriksaan',
                            'size'=>20,
                            'class'=>'span3',
                            'onblur' => 'if(this.value === "") $("#'.Chtml::activeId($modPemeriksaanRad, 'dpjp_id') . '").val(""); ',
                            'onkeypress'=>"return $(this).focusNextInputField(event);",
                        ),
                        'tombolDialog'=>array('idDialog'=>'dialogRad','idTombol'=>'tombolRad'),
                        ));
                ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php    

$modTindakan = new ROTindakanpelayananT; 
$modTindakan->tipepaket_id = Params::TIPEPAKET_ID_NONPAKET;
$modTindakan->kelaspelayanan_id = $modKunjungan->kelaspelayanan_id;
$modTindakan->tgl_tindakan = date('Y-m-d H:i:s');


?>


<?php

    /** =============== TIM MEDIS ===================== * */
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogRad',
    'options' => array(
        'title' => 'Daftar Pemeriksaan Radiologi',
        'autoOpen' => false,
        'width' => 800,
        'height' => 600,
        'resizable' => true,
    ),
        )
);

$format = new MyFormatter();
$modTarif = new ROTariftindakanM('search');
$modTarif->unsetAttributes();
$modTarif->komponentarif_id = Params::KOMPONENTARIF_ID_TOTAL;
if (isset($_GET['ROTariftindakanM'])) {
    $modTarif->attributes = $_GET['ROTariftindakanM'];
    $modTarif->kategoritindakan_nama = $_GET['ROTariftindakanM']['kategoritindakan_nama'] ?? "";
    $modTarif->daftartindakan_kode = $_GET['ROTariftindakanM']['daftartindakan_kode'] ?? "";
    $modTarif->daftartindakan_nama = $_GET['ROTariftindakanM']['daftartindakan_nama'] ?? "";
    $modTarif->pemeriksaanrad_nama = $_GET['ROTariftindakanM']['pemeriksaanrad_nama'] ?? "";
    $modTarif->paket = $_GET['ROTariftindakanM']['paket'] ?? "";
}

if ($modTarif->paket == "paket") {

    $modTarif->unsetAttributes();
    if (isset($_GET['ROTariftindakanM'])) {
        $modTarif->attributes = $_GET['ROTariftindakanM'];
        $modTarif->tipepaket_nama = $_GET['ROTariftindakanM']['tipepaket_nama'] ?? "";
        $modTarif->paket = $_GET['ROTariftindakanM']['paket'];
    }


    $this->widget('ext.bootstrap.widgets.BootGridView', array(
        'id' => 'dialog-tariftindakan-m-grid',
        'dataProvider' => $modTarif->searchPaket(),
        'filter' => $modTarif,
        'template' => "{summary}\n{items}\n{pager}",
        'itemsCssClass' => 'table table-striped table-bordered table-condensed',
        'columns' => array(
            array(
                'header' => 'Pilih',
                'type' => 'raw',
                'filter' => CHtml::dropDownList('ROTariftindakanM[paket]', $modTarif->paket, ['paket' => 'Paket', 'nonpaket' => 'Non Paket'], array('empty' => '-- Pilih --')),
                'value' => function($data) {
                    return CHtml::Link('<i class="icon-form-check"></i>', "#", array("class" => "btn-small",
                                "onclick" => "pilihPemeriksaanIniDialogPaket(".$data->tipepaket_id."); $('#dialogRad').dialog('close'); return false;"));
                },
            ),
            array(
                'header' => 'Nama Paket',
                //'name'=>'nama_pegawai',
                'filter' => CHtml::activeTextField($modTarif, 'tipepaket_nama', array('class' => 'span3')),
                'value' => '$data->tipepaket_nama',
            ),
        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
    ));
    

} else {

    $modTarif->komponentarif_id = Params::KOMPONENTARIF_ID_TOTAL;

    $this->widget('ext.bootstrap.widgets.BootGridView', array(
        'id' => 'dialog-tariftindakan-m-grid',
        'dataProvider' => $modTarif->search(),
        'filter' => $modTarif,
        'template' => "{summary}\n{items}\n{pager}",
        'itemsCssClass' => 'table table-striped table-bordered table-condensed',
        'columns' => array(
            array(
                'header' => 'Pilih',
                'type' => 'raw',
                'filter' => CHtml::dropDownList('ROTariftindakanM[paket]', $modTarif->paket, ['paket' => 'Paket', 'nonpaket' => 'Non Paket'], array('empty' => '-- Pilih --')),
                'value' => function($data) {

                    $pemeriksaanrad = PemeriksaanradM::model()->findByPk($data->pemeriksaanrad_id);

                    echo CHtml::hiddenField('daftartindakan_kode', $data->daftartindakan->daftartindakan_kode, array('class' => 'span3 daftartindakan_kode'));
                    echo CHtml::hiddenField('pemeriksaanrad_id', $data->pemeriksaanrad_id, array('class' => 'span3 pemeriksaanrad_id_dialog'));
                    echo CHtml::hiddenField('jenispemeriksaanrad_nama', $pemeriksaanrad->jenispemeriksaanrad->jenispemeriksaanrad_nama, array('class' => 'span3 jenispemeriksaanrad_nama_dialog'));
                    echo CHtml::hiddenField('jenispemeriksaanrad_id', $pemeriksaanrad->jenispemeriksaanrad->jenispemeriksaanrad_id, array('class' => 'span3 jenispemeriksaanrad_id_dialog'));
                    echo CHtml::hiddenField('pemeriksaanrad_nama', $data->pemeriksaanrad_nama, array('class' => 'span3 pemeriksaanrad_nama'));
                    echo CHtml::hiddenField('daftartindakan_id', $data->daftartindakan_id, array('class' => 'span3 daftartindakan_id'));
                    echo CHtml::hiddenField('jenistarif_id', $data->jenistarif_id, array('class' => 'span3 jenistarif_id'));
                    echo CHtml::hiddenField('harga_tariftindakan', $data->harga_tariftindakan, array('class' => 'span3 harga_tariftindakan'));
                    echo CHtml::hiddenField('harga_tariftindakan_format', number_format($data->harga_tariftindakan, 0, "", ","), array('class' => 'span3 harga_tariftindakan_format'));
                    echo CHtml::hiddenField('kelaspelayanan_id', $data->kelaspelayanan_id, array('class' => 'span3 kelaspelayanan_id_dialog'));
                    return CHtml::Link('<i class="icon-form-check"></i>', "#", array("class" => "btn-small",
                                "onclick" => "pilihPemeriksaanIniDialog(this); $('#dialogRad').dialog('close'); return false;"));
                },
            ),
            array(
                'header' => 'Kategori Tindakan',
                //'name'=>'nama_pegawai',
                'filter' => CHtml::activeTextField($modTarif, 'kategoritindakan_nama', array('class' => 'span3')),
                'value' => '$data->daftartindakan->kategoritindakan->kategoritindakan_nama',
            ),
            array(
                'header' => 'Kode Tindakan',
                //'name'=>'nama_pegawai',
                'filter' => CHtml::activeTextField($modTarif, 'daftartindakan_kode', array('class' => 'span3')),
                'value' => '$data->daftartindakan->daftartindakan_kode',
            ),
            array(
                'header' => 'Nama Pemeriksaan',
                //'name'=>'nama_pegawai',
                'filter' => CHtml::activeTextField($modTarif, 'pemeriksaanrad_nama', array('class' => 'span3')),
                'value' => '$data->pemeriksaanrad_nama',
            ),
            array(
                'header' => 'Uraian Tindakan',
                //'name'=>'nama_pegawai',
                'filter' => CHtml::activeTextField($modTarif, 'daftartindakan_nama', array('class' => 'span3')),
                'value' => '$data->daftartindakan->daftartindakan_nama',
            ),
            array(
                'header' => 'Kelas Pelayanan',
                //'name'=>'nama_pegawai',
                'filter' => CHtml::dropDownList('ROTariftindakanM[kelaspelayanan_id]', $modTarif->kelaspelayanan_id, CHtml::listData(KelaspelayananM::model()->findAll("kelaspelayanan_aktif IS TRUE"), 'kelaspelayanan_id', 'kelaspelayanan_nama'), array('empty' => '-- Pilih --')),
                'value' => '$data->kelaspelayanan->kelaspelayanan_nama',
            ),
        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
    ));

}


$this->endWidget('zii.widgets.jui.CJuiDialog');
//=============================== END TIM MEDIS =======================================

?>

<script>

    function pilihPemeriksaanIniDialogPaket(id) {

        var pasienkirimkeunitlain_id = '<?php echo $modKunjungan->pasienkirimkeunitlain_id; ?>';

        $.post('<?php echo $this->createUrl('tambahTarifTindakanPaket'); ?>', {
            tipepaket_id: id,
            pasienkirimkeunitlain_id: pasienkirimkeunitlain_id,
        }, function(data) {
            $("#form-tindakanpemeriksaan table > tbody").append(data.rows);
            renameInputRow($("#form-tindakanpemeriksaan"));
        }, 'json');

    }

            /**
     * Centang pemeriksaan rad dari checkboxlist
     */
    function pilihPemeriksaanIniDialog(obj) {

        console.log('pilih pemeriksaan dialog');

        jQuery('.tgl_tindakan').removeClass('tgl_tindakan_last');

        var pemeriksaanrad_nama = $(obj).parent().find('.pemeriksaanrad_nama').val();
        var pemeriksaanrad_id = $(obj).parent().find('.pemeriksaanrad_id_dialog').val();
        var jenispemeriksaanrad_nama = $(obj).parent().find('.jenispemeriksaanrad_nama_dialog').val();
        var daftartindakan_id = $(obj).parent().find('.daftartindakan_id').val();
        var jenistarif_id = $(obj).parent().find('.jenistarif_id').val();
        var harga_tariftindakan = $(obj).parent().find('.harga_tariftindakan').val();
        var harga_tariftindakan_format = $(obj).parent().find('.harga_tariftindakan_format').val();
        var daftartindakan_kode = $(obj).parent().find('.daftartindakan_kode').val();
        var kelaspelayanan_id = $(obj).parent().find('.kelaspelayanan_id_dialog').val();
        var rowtindakan = '<?php echo CJSON::encode($this->renderPartial('radiologi.views.pendaftaranRadiologiRujukanRS._rowTindakanPemeriksaan', array('modTindakan' => $modTindakan), true)); ?>';

        var ada = $('#form-tindakanpemeriksaan .pemeriksaanrad_id_dialog[value="' + pemeriksaanrad_id + '"]').length > 0;
        if (!ada) {
            $("#form-tindakanpemeriksaan").find('tbody').append(rowtindakan);
            $("#form-tindakanpemeriksaan").find('input[name$="[ii][tindakanpelayanan_id]"]').val("");
            $("#form-tindakanpemeriksaan").find('input[name$="[ii][pemeriksaanrad_id]"]').val(pemeriksaanrad_id);
            $("#form-tindakanpemeriksaan").find('input[name$="[ii][daftartindakan_id]"]').val(daftartindakan_id);
            $("#form-tindakanpemeriksaan").find('input[name$="[ii][kelaspelayanan_id]"]').val(kelaspelayanan_id);
            $("#form-tindakanpemeriksaan").find('input[name$="[ii][jenistarif_id]"]').val(jenistarif_id);
            $("#form-tindakanpemeriksaan").find('span[name$="[ii][pemeriksaanrad_nama]"]').html(pemeriksaanrad_nama);
            $("#form-tindakanpemeriksaan").find('span[name$="[ii][jenispemeriksaanrad_nama]"]').html(jenispemeriksaanrad_nama);
            $("#form-tindakanpemeriksaan").find('input[name$="[ii][satuantindakan]"]').val("<?php echo Params::SATUAN_TINDAKAN_LABORATORIUM; ?>");
            $("#form-tindakanpemeriksaan").find('input[name$="[ii][tarif_satuan]"]').val((harga_tariftindakan));
            $("#form-tindakanpemeriksaan").find('input[name$="[ii][tarif_tindakan]"]').val((harga_tariftindakan_format));
            $("#form-tindakanpemeriksaan tbody tr:last .tindakan_kode").html(daftartindakan_kode);
        } else {

            myAlert('Pemeriksaan sudah dipilih');
        //     var delete_row = $("#form-tindakanpemeriksaan").find('input[name$="[pemeriksaanrad_id]"][value="' + pemeriksaanrad_id + '"]').parents('tr');
        //     delete_row.detach();
        }

            setTimeout(() => {
                
                jQuery('.tgl_tindakan_last').datetimepicker(
                jQuery.extend({showMonthAfterYear: false},
                    jQuery.datepicker.regional['id'], {
                        'dateFormat': 'dd M yy', 
                        'timeText': 'Waktu', 
                        'hourText': 'Jam',
                        'minuteText': 'Menit', 
                        'secondText': 'Detik', 
                        'showSecond': true, 
                        'timeOnlyTitle': 'Pilih   Waktu', 
                        'timeFormat': 'hh:mm:ss', 
                        'changeYear': true, 
                        'changeMonth': true, 
                        'showAnim': 'fold'
                    }
                )
            );

            }, 500);


        renameInputRow($("#form-tindakanpemeriksaan"));
    }

       /**
     * rename input row yang terakhir di tambahkan
     * @param {type} obj_table
     */
    function renameInputRow(obj_table) {
        var row = 0;
        $(obj_table).find("tbody > tr").each(function() {
            $(this).find("#no_urut").val(row + 1);
            $(this).find('span[name*="[ii]"]').each(function() { //element <span>
                var new_name = $(this).attr("name").replace("ii", (row));
                $(this).attr("name", new_name);
            });
            $(this).find('span[name$="[pemeriksaanrad_nama]"]').each(function() { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 2) {
                    $(this).attr("name", "[" + row + "][" + old_name_arr[1] + "]");
                }
            });
            $(this).find('input,select,textarea').each(function() { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 3) {
                    $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
                    $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
                }
            });
            row++;
        });

    }
    </script>