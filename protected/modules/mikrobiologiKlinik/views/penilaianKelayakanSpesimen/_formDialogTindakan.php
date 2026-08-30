<?php
/**
*  Dialog berisi data autocomplete dan dialog box pencarian tindakan
*
* @category     views
* @author       M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @website      <piindonesia.co.id>
 *@wiki         <https://piiproject.atlassian.net/wiki/display/MDO>
*/
?>
<div id="form-dialogtindakan">
    <div class="control-group">
        <?php echo CHtml::label("Pemeriksaan Lab", '', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php
            $this->widget('MyJuiAutoComplete', array(
                'name' => 'pemeriksaanlab_nama',
                'value' => $modPemeriksaanLab->pemeriksaanlab_nama,
                'source' => 'js: function(request, response) {
                    ruangan_id = $("#ruangan_id").val();
                    penjamin_id = $("#penjamin_id").val();
                    kelaspelayanan_id = $("#kelaspelayanan_id").val();
                    $.ajax({
                            url: "' . $this->createUrl('AutocompletePemeriksaan') . '",
                            dataType: "json",
                            data: {
                                term: request.term,
                                ruangan_id: ruangan_id,
                                penjamin_id: penjamin_id,
                                kelaspelayanan_id: kelaspelayanan_id,
                            },
                            success: function (data) {
                                response(data);
                            }
                    })
                }',
                'options' => array(
                    'minLength' => 3,
                    'focus' => 'js:function( event, ui ) {
                        $(this).val("");
                        return false;
                    }',
                    'select' => 'js:function( event, ui ) {
                        add_pemeriksaan_pilihan(ui.item.daftartindakan_id);
                        return false;
                    }',
                ),
                'tombolDialog' => array('idDialog' => 'dialogTindakan', 'idTombol' => 'tombolDialogTindakan'),
                'htmlOptions' => array('placeholder' => 'Pilih Pemeriksaan Lab', 'class' => 'all-caps',
                    'onkeyup' => "return $(this).focusNextInputField(event)",
                ),
            ));
            ?>
        </div>
    </div>
</div>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogTindakan',
    'options' => array(
        'title' => 'Pencarian Pemeriksaan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 960,
        'height' => 600,
        'resizable' => false,
    ),
));
$tindakanLab = new MKTarifpemeriksaanlabruanganV('search');
$tindakanLab->unsetAttributes();
$tindakanLab->ruangan_id = 9999;

if (isset($_GET['MKTarifpemeriksaanlabruanganV'])) {
    $tindakanLab->attributes = $_GET['MKTarifpemeriksaanlabruanganV'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'tindakantariflab-m-grid',
    'dataProvider' => $tindakanLab->searchTarif(),
    'filter' => $tindakanLab,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => ' Pilih',
            'type' => 'raw',
            'value' => function($data) use ($tindakanLab) {
                return CHtml::checkBox('check', false, array(
                            'data-id' => $data->daftartindakan_id,
                            'onchange' => 'check_sr_pemeriksaan(this);',
                            'class' => 'request_checks_pemeriksaan',
                ));
            },
            'htmlOptions' => array(
                'style' => 'text-align: center',
            ),
            'footer' => CHtml::htmlButton('+ Tambah', array('class' => 'btn btn-green', 'onclick' => 'add_pemeriksaan_pilihan(null); $("#dialogTindakan").dialog("close");'))
        ),
        array(
            'header' => 'Jenis Pemeriksaan',
            'name' => 'jenispemeriksaanlab_id',
            'value' => '$data->jenispemeriksaanlab_nama',
            'filter' => CHtml::activeHiddenField($tindakanLab, 'kelaspelayanan_id', array('class' => 'dialog_kelaspelayanan_id')) . CHtml::activeHiddenField($tindakanLab, 'penjamin_id', array('class' => 'dialog_penjamin_id')) . CHtml::activeHiddenField($tindakanLab, 'ruangan_id', array('class' => 'dialog_ruangan_id')) . CHtml::activeDropDownList($tindakanLab, 'jenispemeriksaanlab_id', CHtml::listData(JenispemeriksaanlabM::model()->findAll("jenispemeriksaanlab_id in (107, 108) and jenispemeriksaanlab_aktif = true ORDER BY jenispemeriksaanlab_nama"), 'jenispemeriksaanlab_id', 'jenispemeriksaanlab_nama'), array('empty' => '-- Pilih --'))
        ),
        array(
            'header' => 'Pemeriksaan',
            'name' => 'pemeriksaanlab_nama',
            'value' => '$data->pemeriksaanlab_nama',
        )
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});update_check_selected_produk();}',
));
$this->endWidget();
?>

<script>
var is_checked = {};
var is_checked_pemeriksaan = {};

// ---------------------------- Produk ------------------------------

function check_sr_pemeriksaan(obj) {
    var id = $(obj).data('id');

    if ($(obj).is(":checked")) {
        is_checked_pemeriksaan[id] = id;
    } else {
        is_checked_pemeriksaan[id] = 0;
    }
}

function update_check_selected_produk() {		
    $(".request_checks_pemeriksaan").each(function() {
        var id = $(this).data('id');		
        var obj = $(this);

        if (typeof is_checked_pemeriksaan[id] != "undefined" && is_checked_pemeriksaan[id] != 0)
            $(this).prop("checked", true);

        $("#form-tindakanpemeriksaan > table > tbody > tr").each(function() {			
            if ( ($(this).find('.idDaftarTindakan').val() == id) ) {
                $(obj).prop("checked", true).prop("disabled", true);
            }
        });
    });
}

function set_check_all_pemeriksaan() {
    $(".request_checks_pemeriksaan").prop("checked", $(".check_all").is(":checked")).change();
}

function add_pemeriksaan_pilihan(daftartindakan_id) {
    var arr = new Array();
    var pemeriksaan = '';

    $.each(is_checked_pemeriksaan, function(idx, val) {
            arr.push(val);		
    });
    
    ada = 0;
    if(daftartindakan_id != null){
        $("#form-tindakanpemeriksaan > table > tbody > tr").each(function () {
            idDaftarTindakan = $(this).find('.idDaftarTindakan').val();
            if(idDaftarTindakan == daftartindakan_id){
                ada++;
            }
        });
        if(ada == 0){
            arr.push(daftartindakan_id);
        }else{
            myAlert("Pemeriksaan sudah ada pada tabel pemeriksaan");
            return false;
        }
    }

    is_checked_pemeriksaan = {};

    var ruangan_id = $("#ruangan_id").val();
    var penjamin_id = $("#penjamin_id").val();
    var kelaspelayanan_id = $("#kelaspelayanan_id").val();		
    var pasienmasukpenunjang_id = $("#pasienmasukpenunjang_id").val();	
	
    $.post('<?php echo $this->createUrl('addTindakanPilihan'); ?>', {
        id: arr, 
        ruangan_id: ruangan_id,
        penjamin_id: penjamin_id,
        kelaspelayanan_id: kelaspelayanan_id,
        pasienmasukpenunjang_id: pasienmasukpenunjang_id
        }, function(data) {
            if (data.sukses == 1){
                var cf = confirm("Apakah Anda yakin, akan menambahkan beberapa pemeriksaan yang sama, yaitu : "+data.ada+" ?");

                if (cf){
                    $("#form-tindakanpemeriksaan > table > tbody").append(data.row);				
                    renameInputRow($("#form-tindakanpemeriksaan"));				
                    $(".request_checks_pemeriksaan, .check_all_pemeriksaan").prop("checked", false);
                }
            }else{
                $("#form-tindakanpemeriksaan > table > tbody").append(data.row);				
                renameInputRow($("#form-tindakanpemeriksaan"));				
                $(".request_checks_pemeriksaan, .check_all_pemeriksaan").prop("checked", false);
            }								
    }, 'json');
}

function delItems(obj){
    permintaankepenunjang_id = $(obj).parents('tr').find('.permintaankepenunjang_id').val();
    idpemeriksaanlab = $(obj).parents('tr').find('.idpemeriksaanlab').val();
    $(obj).parents('tr').attr("style","border:red 2px solid;");
    
    if(permintaankepenunjang_id != ""){
        var result = confirm("Apakah Anda yakin menghapus data pemeriksaan ini dari Database ??");
        if (result) {
            $.post('<?php echo $this->createUrl('hapusPermintaanPenunjang'); ?>', {
                permintaankepenunjang_id: permintaankepenunjang_id
                }, function(data) {
                    if(data.sukses == 1){
                        $(obj).parents('tr').remove();
                        renameInputRow($("#form-tindakanpemeriksaan"));
                        $('.panel-spesimen').each(function () {
                            pemeriksaanlab_id = $(this).find('input[name$="[pemeriksaanlab_id]"]');
                            pemeriksaanlab_nama = $(this).find('input[name$="[pemeriksaanlab_nama]"]');
                            if(idpemeriksaanlab == pemeriksaanlab_id.val()){
                                pemeriksaanlab_id.val('');
                                pemeriksaanlab_nama.val('');
                            }
                        });
                    }else{
                        myAlert(data.pesan);
                    }							
            }, 'json');
        }else{
            $(obj).parents('tr').attr("style","");
            return false;
        }
    }else{
        var result = confirm("Apakah Anda yakin batal data pemeriksaan tambahan ini ??");
        if (result) {
            $(obj).parents('tr').remove();
            renameInputRow($("#form-tindakanpemeriksaan"));	
            
            $('.panel-spesimen').each(function () {
                spesimen_id = $(this).find('input[name$="[spesimen_id]"]');
                pemeriksaanlab_id = $(this).find('input[name$="[pemeriksaanlab_id]"]');
                pemeriksaanlab_nama = $(this).find('input[name$="[pemeriksaanlab_nama]"]');
                if(idpemeriksaanlab == pemeriksaanlab_id.val() && spesimen_id.val() == ''){
                    pemeriksaanlab_id.val('');
                    pemeriksaanlab_nama.val('');
                }
            });
            
        }else{
            $(obj).parents('tr').attr("style","");
            return false;
        }
    }
}

function updateTabelProduk() {
    jQuery.fn.yiiGridView.update('tindakantariflab-m-grid', {
        data: $("#tindakantariflab-m-grid :input").serialize(),
    });
}
	
function refreshDialogOA(){        
    $("#pemeriksaanlab_nama").addClass('animation-loading');

    setTimeout(function(){			
            $("#pemeriksaanlab_nama").removeClass("animation-loading");
    },500);
}

$('#tombolDialogTindakan').click(function(){
    var ruangan_id = $("#ruangan_id").val();
    var penjamin_id = $("#penjamin_id").val();
    var kelaspelayanan_id = $("#kelaspelayanan_id").val();
    var pendaftaran_id = $("#pendaftaran_id").val();

    if (pendaftaran_id != '') {
        $(".dialog_ruangan_id").val(ruangan_id);
        $(".dialog_penjamin_id").val(penjamin_id);
        $(".dialog_kelaspelayanan_id").val(kelaspelayanan_id);
        $.fn.yiiGridView.update('tindakantariflab-m-grid', {
            data: {
                "MKTarifpemeriksaanlabruanganV[ruangan_id]": ruangan_id,
                "MKTarifpemeriksaanlabruanganV[penjamin_id]": penjamin_id,
                "MKTarifpemeriksaanlabruanganV[kelaspelayanan_id]": kelaspelayanan_id,
                "MKTarifpemeriksaanlabruanganV[jenispemeriksaanlab_id]": [107, 108],
            }
        });
    } else {
        $("#dialogTindakan").dialog("close");
        alert("Maaf, Pasien Belum Dipilih");
        return false;
    }
});

function cekTinKeluar(obj) {
    var obj_table = '#table-rujukankeluar';
    var cekTin = 0;

    if ($(obj).val() != '') {
        $(obj_table).find("tbody > tr").each(function () {
            $(this).find('input,select,textarea').each(function () { //element <input>		
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");

                if (old_name_arr[2] == 'daftartindakan_id') {
                    if ($(this).val() == $(obj).val()) {
                        cekTin++;
                    }
                }
            });
        });

        if (cekTin > 1) {
            myAlert("Tindakan yang sudah dipilih, tidak dapat dipilih untuk pememriksaan keluar yang lain ");
            $(obj).val("");
            return false;
        }
    }
}

</script>