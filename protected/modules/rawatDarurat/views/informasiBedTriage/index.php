<?php
$cs = Yii::app()->clientScript;
$path = Yii::app()->baseUrl;
$cs->registerScriptFile($path . '/js/selectize.min.js');
$cs->registerCssFile($path . '/css/selectize.bootstrap3.min.css');
?>
<?php
Yii::app()->clientScript->registerScript('search', "
    $('#informasisampel-r-search').submit(function(){
        $.fn.yiiGridView.update('informasi-stok-grid', {
            data: $(this).serialize()
        });
        return false;
    });
");

$this->widget('bootstrap.widgets.BootAlert');
?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<style>
    .selectize-input{
        height: 12px;
    }
    .selectize-dropdown{
        height: auto !important;
    }
    .selectize-control>.single{
        height: 12px;
    }
    .selectize-input>.item{
        font-size: 11px;
    }
    .selectize-dropdown-content>.option{
        font-size: 11px;
    }
    .dropdown-active{
        height: 12px;
    }
</style>
<div class="alert"></div>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">Informasi <strong>Bed Triage</strong></div>
            </div>
            <div class="panel-body">
                <div align="right" style="margin-bottom: 20px;">
                    <?php echo CHtml::link(
                        Yii::t('mds', '{icon} Tambah Pasien IGD', array('{icon}' => '<i class="fa fa-plus"></i>')),
                        Yii::app()->createUrl('/rawatDarurat/informasiBedTriage/tambahTriage'),
                        array(
                            'title' => 'Tambah Pasien IGD',
                            'class' => 'btn btn-danger',
                            // 'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                            'target' => 'iframeTambahTriage',
                            "onclick" => "$('#dialogTambahTriage').dialog('open');"
                        )
                    ); ?>
                </div>
                <div class="panel panel-success panel-shadow">
                    <div class="panel-heading">
                        <div class="panel-title">Tabel <strong>Bed Triage</strong></div>
                    </div>
                    <div class="panel-body overflow-x">
                        <?= $this->renderPartial($this->path_view . '_tabel', ['model' => $model], true) ?>
                    </div>
                </div>
                <div class="panel panel-success panel-shadow">
                    <div class="panel-heading">
                        <div class="panel-title"><i class="entypo-search"></i> Pencarian</div>
                    </div>
                    <div class="panel-body">
                        <fieldset class="">
                            <?php $this->renderPartial($this->path_view . '_search', array(
                                'model' => $model,
                            )); ?>
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function cekVerifikasiTindakLanjut(obj, pendaftaran_id) {
        if(pendaftaran_id == '') {
            myAlert('Pasien Belum Memiliki Pendaftaran');
            return false;
        }

        $("#frameTindakLanjut").prop('src', '<?php echo Yii::app()->controller->createUrl("/rawatDarurat/daftarPasien/pasienPulang"); ?>&pendaftaran_id=' + pendaftaran_id + '&dialog=1&carakeluar_id=4');
        $("#dialogTindakLanjut").dialog('open');        
    }
    function setFlashSukses(){
        myAlert('Berhasil Menambahkan Pasien Triage');    
    }

    function tambahTriage(pendaftaran_id){
        $('#temp_idPendaftaranDP').val(pendaftaran_id);
        jQuery.ajax({'url':'<?php echo $this->createUrl('tambahTriage')?>',
            'data':$(this).serialize(),
            'type':'post',
            'dataType':'json',
            'success':function(data){
                if (data.status == 'create_form') {
                    $('#tambahTriage div.divForFormTambahTriage').html(data.div);
                    $('#tambahTriage div.divForFormTambahTriage form').submit(tambahTriage);
                }else{
                    $('#tambahTriage div.divForFormTambahTriage').html(data.div);
                    $.fn.yiiGridView.update('informasi-stok-grid', {
                            data: $('form').serialize()
                    });
                    setTimeout("$('#tambahTriage').dialog('close') ",500);
                }
            },
            'cache':false
        });
        return false; 
    }

    function tambahTriagePasien(pendaftaran_id, notriage_pasien_id){
        $('#temp_idPendaftaranDP').val(pendaftaran_id);
        $('#temp_idTriage_pasien').val(notriage_pasien_id);

        console.log(pendaftaran_id);
        console.log(notriage_pasien_id);
        // jQuery.ajax({'url':'<?php echo $this->createUrl('TambahTriagePasien')?>',
        //     'data':$(this).serialize(),
        //     'type':'post',
        //     'dataType':'json',
        //     'success':function(data){
        //         if (data.status == 'create_form') {
        //             $('#tambahTriagePasien div.divForFormTambahTriagePasien').html(data.div);
        //             $('#tambahTriagePasien div.divForFormTambahTriagePasien form').submit(tambahTriagePasien);
        //         }else{
        //             $('#tambahTriagePasien div.divForFormTambahTriagePasien').html(data.div);
        //             $.fn.yiiGridView.update('daftarpasien-v-grid', {
        //                     data: $('form').serialize()
        //             });
        //             setTimeout("$('#tambahTriagePasien').dialog('close') ",500);
        //             // location.reload();
        //         }
        //     },
        //     'cache':false
        // });
        // return false; 
    }

</script>
<?php
$this->renderPartial($this->path_view . '_dialog', []);

$js = <<< JSCRIPT
   
    const cekFormDaftar = (obj) => {
        let url = $(obj).data("url");

        if (requiredCheck($("#form-pendaftaran"))){
            disableOnSubmit($(".btn-simpan"));
            $.ajax({
                type: 'POST',
                url: url,            
                data:{
                    formdata:$("#form-pendaftaran").serialize(),
                    proses:'simpan'  
                },
                dataType: "json",
                success: function (data) {   
                    var element = document.getElementById('div-form-pendaftaran'); // Mengambil elemen dengan ID 'id'
                    element.innerHTML = data; 
                   
                    window.parent.toastr.success("Data berhasil disimpan", "Perhatian!");                      
                },
                error: function (jqXHR, textStatus, errorThrown) {                                    
                }
            });     
        }
        return false;
    }
        
    
    

    const setDaftar2 = (obj) => {
        let url = $(obj).data("url");        
        $.ajax({
            type: 'GET',
            url: url,               
            dataType: "json",
            success: function (data) {    
                $("#div-form-pendaftaran2").html(data);                
                $("#dialogPendaftaran2").dialog("open");                   
            },
            error: function (jqXHR, textStatus, errorThrown) {                                    
            }
        });        
    }
JSCRIPT;
Yii::app()->clientScript->registerScript('informasi-js', $js, CClientScript::POS_HEAD);
?>

<?php
//======================= Tambah Triage ======================= 
$this->beginWidget(
    'zii.widgets.jui.CJuiDialog',
    array(
        'id' => 'tambahTriage',
        'options' => array(
            'title' => 'No Triage Pasien',
            'autoOpen' => false,
            'minWidth' => 500,
            'modal' => true,
        ),
    )
);
echo CHtml::hiddenField('temp_idPendaftaranDP', '', array('readonly' => true));
echo '<div class="divForFormTambahTriage"></div>';
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>

<?php
//======================= Tambah Triage Pasien ======================= 
// $this->beginWidget(
//     'zii.widgets.jui.CJuiDialog',
//     array(
//         'id' => 'tambahTriagePasien',
//         'options' => array(
//             'title' => 'Pilih No Triage Pasien',
//             'autoOpen' => false,
//             'minWidth' => 500,
//             'modal' => true,
//         ),
//     )
// );
// echo CHtml::hiddenField('temp_idPendaftaranDP_pasien', '', array('readonly' => true));
// echo CHtml::hiddenField('temp_idTriage_pasien', '', array('readonly' => true));
// echo '<div class="divForFormTambahTriagePasien"></div>';
// $this->endWidget('zii.widgets.jui.CJuiDialog');
?>

<?php
//======================= Tambah Triage ======================= 
$this->beginWidget(
    'zii.widgets.jui.CJuiDialog',
    array(
        'id' => 'dialogTambahTriage',
        'options' => array(
            'title' => 'No Triage Pasien',
            'autoOpen' => false,
            'minWidth' => 500,
            'height' => 350,
            'modal' => true,
            'close' => "js:function(){
                $.fn.yiiGridView.update('informasi-stok-grid');
            }"
        ),
    )
);
?>
<iframe name="iframeTambahTriage" frameborder="0" style="width: 100%; height:98%"></iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
<?php
// Dialog untuk tindak lanjut pasien ke RI=========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogTindakLanjut',
    'options' => array(
        'title' => 'Tindak Lanjut',
        'autoOpen' => false,
        'modal' => true,
        'zIndex' => 1002,
        'width' => 1000,
        'height' => 550,
        'resizable' => true,
        'close' => "js:function(){ $.fn.yiiGridView.update('daftarpasien-v-grid', {
                            data: $('#caripasien-form').serialize()
                        }); }",
    ),
));
?>
<iframe id="frameTindakLanjut" name='frameTindakLanjut' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>

<script>
    const setDaftar = (obj) => {
        let url = $(obj).data('url');        
        $.ajax({
            type: 'GET',
            url: url,               
            dataType: "json",
            success: function (data) {
                var element = document.getElementById('div-form-pendaftaran'); // Mengambil elemen dengan ID 'id'
                element.innerHTML = data;
                // $("#div-form-pendaftaran").html(data);                
                $("#dialogPendaftaran").dialog("open");                   
            },
            error: function (jqXHR, textStatus, errorThrown) {                                    
            }
        });        
    }

    var loadDataPasien = (obj) => {
        const id = $(obj).val();
        $.get("<?php echo $this->createUrl('loadPendaftaran'); ?>", {
                id: id
            },
            function(data) {
                $('.label-nama-pasien').html(data.nama_pasien);
                $('.label-alamat-pasien').html(data.alamat_pasien);
                $(".label-no-rm").html(data.no_rekam_medik)
                $('#NotriagePasienT_pasien_id').val(data.pasien_id);
                $('#NotriagePasienT_pendaftaran_id').val(id);
            },
            "json");
    }
</script>