<style type="text/css">
    #form-jenis-kunjungan{
        padding: 20px;
    }
</style>
<?php
Yii::app()->clientScript->registerScript('search', "
    $('#search-form').submit(function(){
        $.fn.yiiGridView.update('daftar-penunjang-grid', {
            data: $(this).serialize()
        });
        return false;
    });
");

$this->widget('bootstrap.widgets.BootAlert');
?>
<?php 
    $module  = $this->module->name; 
    $controller = $this->id;
    $format = new MyFormatter();
?>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">Informasi <strong>Barcode</strong></div>
            </div>
            <div class="panel-body">
                
                <div class="panel panel-success panel-shadow">
                    <div class="panel-heading">
                        <div class="panel-title"> <strong>Barcode</strong></div>
                    </div>
                    <div class="panel-body overflow-x form-barcode-1 form-horizontal" >                            
                          <div class="control-group">
                              <label class="control-label">BARCODE</label>
                              <div class="controls">
                                  <?= CHtml::hiddenField('antriId','') ?>
                                  <?= CHtml::textField('nomorbarcode','',['class'=>'span3 inputbarcode required']) ?>
                              </div>
                          </div>
                        <div class="form-actions">
                            <?= CHtml::htmlButton("SIMPAN",['class'=>'btn btn-danger','onclick'=>'prosesBarcode(1);']) ?>
                        </div>
                    </div>
                </div>	
                
                <?php
                    $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                        'id' => 'form-pencarian-barcode',
                        'content' => array(
                            'content-barcode' => array(
                                'header' => '<b>Pencarian Daftar Pengunjung</b>',
                                'isi' => $this->renderPartial($this->path_view . '_search', array(
                                    'model' => $model,
                                ), true),
                                'active' => false,
                            ),
                        ),
                    ));
                ?>
                                
                <div class="panel panel-success panel-shadow">
                    <div class="panel-heading">
                        <div class="panel-title">Tabel <strong>Data Daftar Penunjang</strong></div>
                    </div>
                    <div class="panel-body overflow-x" >                            
                          <?= $this->renderPartial($this->path_view.'_tabel',['model'=>$model],true) ?>                       
                    </div>
                </div>								
                							
            </div>
        </div>
    </div>
</div>  

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogBarcode',
    'options' => array(
        'title' => 'Barcode',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 300,
        'height' => 200,
        'resizable' => false,
    ),
));
echo '<div class="dialog-content"></div>';
?>
<div class="form-horizontal form-barcode-2" style="padding:20px;">
    <div class="control-group">
        <label class="control-label">BARCODE</label>
        <div class="controls">
            <?= CHtml::textField('nomorbarcodebyantrian','',['class'=>'span3 inputbarcode' ]) ?>
        </div>
    </div>
  <div class="form-actions">
      <?= CHtml::htmlButton("SIMPAN",['class'=>'btn btn-danger','onclick'=>'prosesBarcode(2);',]) ?>
  </div>
</div>
<script>
    $(function() {
        var myInput = document.getElementById("nomorbarcode");
        myInput.focus();
        // $('.nomorbarcode').focus();
    })
</script>
<?php
$this->endWidget();

$this->renderPartial('_dialog',[]);

$urlPrint = $this->createUrl('/antrian/ambilTiket/print');
$urlCheckinBarcode = $this->createUrl('checkinBarcode');
$urlFormJenisKunjungan = $this->createUrl('formJenisKunjungan');
$urlCekNoRm = $this->createUrl('cekNoRm');
$urlAutoCompletePasien = $this->createUrl('/actionAutoComplete/pasienInformasi');

$konfig = KonfigsystemK::model()->find();
$nodeJsAktif = ($konfig->is_nodejsaktif)?'ya':'tidak';

        
$js = <<< JSCRIPT
    
    const genExt = () => {
        $("#form-jenis-kunjungan").find(".no_rm").autocomplete(
            {
                'showAnim':'fold',
                'minLength':3,
                'focus':function(event, ui )
                {
                    $(this).val("");
                    return false;
                },
                'select':function( event, ui )
                {                                                
                    setPasien(ui.item)
                    return false;
                },
                'source':function(request, response)
                {                                                                                                                                  
                    $.ajax({
                        url: "${urlAutoCompletePasien}",
                        dataType: "json",
                        data:{
                            no_rekam_medik: request.term,                                                            
                        },
                        success: function (data) {
                            response(data);
                        }
                    })
                },
            }
        );
    }
        
    const setPasien = (data) => {
        $("#form-jenis-kunjungan").find(".no_rm").val(data.no_rekam_medik);
        $("#form-jenis-kunjungan").find(".nama_pasien").val(data.nama_pasien);
    }
        
    const setFasttrack = (id, setform) => {
        const ruanganId = $("#ruanganpoli_pilih").val();        
        const form = $("#form-jenis-kunjungan");
        let kosong = 0;

        form.find(".required").attr("style","");
        form.find(".required").each(function(){
            if ($(this).val() == ''){
                kosong++;
                $(this).attr("style","border:red 1px solid;");
            }
        });
        
        if (kosong > 0){
            myAlert("Inputan mandatory harus diisi","Perhatian!");
        }else{
            $.ajax({
                type: 'GET',
                url: '${urlCekNoRm}',
                data: {
                    formdata: form.find("input,textarea").serialize(),                      
                }, 
                dataType: "json",
                success: function(data) {
                    if (data.ada){
                        ubahFasttrack(data.id, 'simpan')
                    }else{
                        myAlert("Nomor rekam medik tidak terdaftar","Perhatian!");
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });            
        }
    }
        
    const ubahFasttrack = (id, setform) => {
        let method = 'POST';
        if (setform == 'generate')
            method = 'GET';
            
        // if ($('#AntrianT_nama_pj').val() == '' || $('#AntrianT_alasan_fasttrack').val() == '' ){
        //     myAlert('field harus di isi');
        //     return false;
        // }
       
        $.ajax({
            type: method,
            url: "${urlFormJenisKunjungan}",
            data: {
                id,
                formdata: $("#form-jenis-kunjungan").find("input,textarea").serialize(),
                setform
            },
            dataType: "json",
            success: function(data) {
             
                if (setform == 'generate'){
                    $("#form-jenis-kunjungan").html(data);
                    $("#dialogJenisKunjungan").dialog("open");
            
                    genExt();
                }else{
                    if ($('#AntrianT_nama_pj').val() == '' || $('#AntrianT_alasan_fasttrack').val() == '' ){
                        myAlert('field harus di isi');
                        return false;
                    }
                    if (data.sukses == 1){
                        // myAlert(data.pesan,"Perhatian!");
                        toastr.success("Perhatian!", data.pesan);
                        refreshTabel();
            
                        $("#dialogJenisKunjungan").dialog("close");
            
                        if ('${nodeJsAktif}' == 'ya'){
                            socket.emit('send',{conversationID:'infoAntrian',panggil:3});
                        }
                    }else{
                        Notiflix.Report.Failure("Perhatian!",data.pesan,"OK");
                    }
                }
            }
        });      
    }
        
    const refreshTabel = () => {
        $("#search-form").submit();
    }
        
    const showBarcode = (id) => {
        $("#antriId").val(id);
        $("#dialogBarcode").dialog("open");
    }

    $(function() {
        $('body').on('keydown', 'input,textarea', function(e) {
        var inputbarcode = $('.inputbarcode').val();
    
            if(inputbarcode != '' ) {
                if (e.key === "Enter") {
                    // Do something
                    prosesBarcode(1);
                    prosesBarcode(2);
                }
            }
       
        console.log(this.value);
        if (e.which === 32 && e.target.selectionStart === 0) {
        return false;
        }
        });
        });
       
        
    const prosesBarcode = (jenis,event) => {      
        if (jenis == 1){        
            if (requiredCheck($(".form-barcode-1"))){
                $("#antriId").val("");  
                prosesSimpan($("#nomorbarcode").val());
            }
        }else if (jenis == 3){
          if(event.key =="Enter"){
            if (requiredCheck($(".form-barcode-2"))){
                prosesSimpan($("#nomorbarcodebyantrian").val());
              }
            } 
        
        } else{
            if (requiredCheck($(".form-barcode-2"))){
                prosesSimpan($("#nomorbarcodebyantrian").val());
            }
        }
        return false;
    }
        


    const prosesSimpan = (nomorbarcode,status = '',antriId = '') => {
        if (antriId == ''){
            antriId = $("#antriId").val();
        }
                
        $.ajax({
            type: 'POST',
            url: "${urlCheckinBarcode}",
            data: {
                nomorbarcode, 
                antriId,
                status
            },
            dataType: "json",
            success: function(data) {
                if (data.sukses == 1 ){
                    socket.emit('send',{conversationID:'infoAntrian',panggil:3,arr:{antrianId:data.antrian_id,loketId:data.loket_id}});
                    var warning = ['Check In Berhasil !'];
                    toastr.success("Perhatian!", 'Check In Berhasil');
                    $('.inputbarcode').val('');
                    // for(var i=0;i<warning.length;i++) {
                    //                   setTimeout(alert(warning[i]), 1000);
                    //               } 
                    refreshTabel();
                    $("#dialogBarcode").dialog("close");
            
                }else{
                    toastr.error("Perhatian!", (data.sukses == 0)?" Gagal Check-in":"Nomor Barcode tidak terdaftar");
                    $('.inputbarcode').val('');
                    // Notiflix.Report.Failure("Perhatian!",(data.sukses == 0)?" Gagal Check-in":"Nomor Barcode tidak terdaftar",'Press Enter');
                }
                var myInput = document.getElementById("nomorbarcode");
                myInput.focus();
            }
        });       
    }
        
    function print(id){
        window.open("${urlPrint}&antrian_id="+id,"",'location=_new, width=900px');
    }
JSCRIPT;
        Yii::app()->clientScript->registerScript('js-informasi-barcode', $js, CClientScript::POS_HEAD);