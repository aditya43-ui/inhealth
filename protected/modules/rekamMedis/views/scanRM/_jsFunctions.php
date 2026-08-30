<script>
$(function(){
    refreshScanRM();
});

function hapusGambar(obj){
    var dokfilerm_id = $(obj).attr('dokfilerm_id');
    
    myConfirm("Apakah Anda yakin akan menghapus gambar rekam medis ini?","Perhatian!", function(r){
        if (r){
            $.ajax({
                type: 'POST',
                url: '<?php echo $this->createUrl('hapusGambar'); ?>',
                data: {dokfilerm_id:dokfilerm_id},           
                dataType: "json",                        
                success: function (data) {
                    if (data.sukses == 1){                 
                        toastr.success(data.pesan,"Perhatian!");
                        refreshScanRM();
                    }else{
                        toastr.warning(data.pesan,"Perhatian!");
                    }               
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    //console.log(errorThrown);
                }
            });
        }
    });        
}
    

    
function cekFile(obj){       
    var imageArr = $(obj).get(0);

  
    var cek = $(obj).val();    
    // console.log(imageArr.files)    
    
    if (cek != ''){
        // var type = $(obj).get(0).files[0]['type'];
        var tipeFile = imageArr.type.split('/');                          
        // var ext = '.'+$(obj).val().split('.').pop().toLowerCase();           
        // var fileExt = $(obj).attr('accept').split(',');        

        var imageCount = imageArr.files.length;
        var imageToBig = false;
        
     

        var imageSize = imageArr.files[0].size;  
        var imageName = imageArr.files[0].name;
        var imageType = imageArr.files[0].type.split('/');

        var ExtensionsAllowed = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'pdf'];


        // imageSize = imageSize / 1024; //file size in Kb
        imageSize = imageSize / (1024 * 1024); //file size in Mb
       
        if(!ExtensionsAllowed.includes(imageType[1])) {
            myAlert("Type data "+ imageType[1] +" tidak sesuai. yang di izinkan png, jpg, jpeg, gif, bmp, pdf","perhatian!");
            batalGambar(obj);
            return false;
        }
        if (imageSize > 5) {
            myAlert("Ukuran file tidak boleh lebih dari 5mb","perhatian!");
            $(obj).val("");                 
            $(obj).parents(".controls").find('.labelbrowse').html('');                
            return false;
        }else{
            toastr.success(imageArr.files[0].size,"ukuran size adalah");

            tambahGambar(imageArr.files[0], $(obj).get());
            $("#simpan_gambar").removeClass('hide');
        }
    
   }     
}

var fileToBase64 = file => new Promise((resolve, reject) => {
    const reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onload = () => resolve(reader.result);
    reader.onerror = error => reject(error);
});

function tambahGambar(value_file, files){
    // var trHtml = new String(<?php echo CJSON::encode($this->renderPartial($this->path_view.'_rowGambar',array(),true));?>);
    // console.log(files);
    // $('#tbl_gambar').find('tbody').append(trHtml.replace());
    $('#tbl_gambar').find('tbody').find('tr:last').find('.span_filegambar').html(value_file.name);
    $('#tbl_gambar').find('tbody').find('tr:last').find('.file_gambar').val(value_file.tmp_name);
    $('#tbl_gambar').find('tbody').find('tr:last').find('.dokfilerm_nama').val(value_file.name);
    $('#tbl_gambar').find('tbody').find('tr:last').find('.file_gambar_nama').val(value_file.name);
    generateGambar($('#tbl_gambar').find('tbody'));
}

function generateGambar(obj){
    for (var i=0; i<$(obj).find('.file_gambar').length; i++){
        var tr = $(obj).find('.file_gambar').eq(i);
        tr.attr('id','Detailscan_'+i+'_file_gambar');
        tr.attr('name','Detailscan['+i+'][file_gambar]');
    }
    for (var i=0; i<$(obj).find('.instalasi_ids').length; i++){
        var tr = $(obj).find('.instalasi_ids').eq(i);
        tr.attr('id','Detailscan_'+i+'_instalasi_ids');
        tr.attr('name','Detailscan['+i+'][instalasi_ids][]');
        tr.multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '150px',
            enableCaseInsensitiveFiltering: true
        }).hide();
    }
    for (var i=0; i<$(obj).find('.dokfilerm_nama').length; i++){
        var tr = $(obj).find('.dokfilerm_nama').eq(i);
        tr.attr('id','Detailscan_'+i+'_dokfilerm_nama');
        tr.attr('name','Detailscan['+i+'][dokfilerm_nama]');
    }
    for (var i=0; i<$(obj).find('.file_gambar_nama').length; i++){
        var tr = $(obj).find('.file_gambar_nama').eq(i);
        tr.attr('id','Detailscan_'+i+'_file_gambar_nama');
        tr.attr('name','Detailscan['+i+'][file_gambar_nama]');
    }
    
}

function batalGambar(obj){
  $(obj).parents('tr').remove();
  generateGambar($('#tbl_gambar').find('tbody'));
}

function fileLoad(obj){
    var pasien_id = $("#pasien_pasien_id").val();
    var trHtml = new String(<?php echo CJSON::encode($this->renderPartial($this->path_view.'_rowGambar',array(),true));?>);
    $('#tbl_gambar').find('tbody').append(trHtml.replace());
    var rowCount = $('#tbl_gambar tr').length;

    console.log(rowCount);

    $('.file_multi').attr('name', 'Detailscan['+rowCount+'][files]');
    $('.file_multi').trigger('click');
    $('.file_multi').attr('class', 'terset');
    // $(obj).parents(".controls").find('input:file').trigger('click');
}


function simpanGambar(obj){
    var formData = new FormData($('#sadokrekammedis-m-form')[0]);

    // $.each($("input#DokfilermR_picture_nama[type=file]")[0].files, function(i, file) {
    //     formData.append('files[]', file);
    // });
    // var pasien_id = $("#pasien_pasien_id").val();
    // var instalasi_ids = $("#DokfilermR_instalasi_ids").val();
    // // var formData = new FormData();
    // // formData.append('file', $('input#DokfilermR_picture_nama[type=file]')[0].files);
    // formData.append('pasien_id', pasien_id);
    // formData.append('instalasi_ids', instalasi_ids);
    
    $.ajax({
        type: 'POST',
        url: '<?php echo $this->createUrl('simpanGambar'); ?>',
        data: formData,           
        dataType: "json",        
        contentType: false,
        processData: false,
        success: function (data) {
            if (data.sukses == 1){  
                $("#simpan_gambar").addClass('hide');
                $("#picture_nama").val("");
                $(".labelbrowse").html("");
                toastr.success(data.pesan,"Perhatian!");
                refreshScanRM();
                $('#tbl_gambar').find('tbody').html('');
            }else{
                toastr.warning(data.pesan,"Perhatian!");
            }               
        },
        error: function (jqXHR, textStatus, errorThrown) {
            //console.log(errorThrown);
        }
    });
    
    
}
    
function inputPasien(data) {
	var data1 = data.namadepan;
    let data2 = data.nama_pasien;
    let result = data1.concat("", data2);
	$("#pasien_pasien_id").val(data.pasien_id);
	
	$("#pasien_nama_pasien").val(result);
	$("#pasien_no_rekam_medik").val(data.no_rekam_medik);
	$("#pasien_alamat_pasien").val(data.alamat_pasien);
	$("#pasien_jeniskelamin").val(data.jeniskelamin);
	$("#pasien_tanggal_lahir").	val(data.tanggal_lahir);
    
    refreshScanRM();
    
    $("#dialogPasien").dialog('close');
}

function resetInputPasien() {
    $("#pasien_pasien_id").val("");
	
	$("#pasien_nama_pasien").val("");
	$("#pasien_alamat_pasien").val("");
	$("#pasien_jeniskelamin").val("");
	$("#pasien_tanggal_lahir").	val("");
}

function refreshScanRM() {
    var no_rm = $("#pasien_no_rekam_medik").val();
    var pasien_id = $("#pasien_pasien_id").val();
    
    // if (pasien_id == ''){
    //     toastr.warning("Pasien belum diload!","Perhatian!");
    //     return false;
    // }
    var lihat = "<?= isset($_GET['lihat']) ? 1 : 0 ?>";
    
    $.post('<?php echo $this->createUrl('loadFileScan'); ?>', {
        no_rm: no_rm,
        lihat:lihat
    }, function(data) {
        $(".panel-gambar").html(data.html);
        jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip();
    }, 'json');
}

function launchScanner() {
    var no_rm = $("#pasien_no_rekam_medik").val();
    var pasien_id = $("#pasien_pasien_id").val();
    
    // if (pasien_id == ''){
    //     toastr.warning("Pasien belum diload!","Perhatian!");
    //     return false;
    // }
    
    if (no_rm.trim() == "") {
        myAlert("Pasien harus diinput");
        return false;
    }

    location.href='scanner_rm: ' + no_rm + ':<?php echo Yii::app()->user->getState('session_id'); ?>';
}

function setNoRM(obj) {
    resetInputPasien();
    var no_rm = $(obj).val();
    
    if(no_rm == ''){
        return false;
    }
    
    $.post('<?php echo $this->createUrl('ajaxNoRM'); ?>', {
        no_rm:no_rm
    }, function(data) {
        if (data.ok == 1) {
            $(obj).val(data.pasien.no_rekam_medik);
            $("#pasien_no_rekam_medik").val(data.pasien.no_rekam_medik);
            inputPasien(data.pasien);
        }
    }, 'json');
}

function salinNoRM() {
    var t = document.getElementById('pasien_no_rekam_medik');
    t.select();
    try {
        var successful = document.execCommand('copy');
        myAlert("No. Rekam Medik sudah disalin!");
    } catch (err) {
        myAlert("No. Rekam Medik tidak dapat disalin!");
    }
}

</script>