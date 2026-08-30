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
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">Informasi <strong>Pasien Triage</strong></div>
            </div>
            <div class="panel-body">
                <div align="right" style="margin-bottom: 20px;" hidden>
                    <?php echo CHtml::link(
                        Yii::t('mds', '{icon} Tambah Pasien IGD', array('{icon}' => '<i class="fa fa-plus"></i>')),
                        Yii::app()->createUrl($this->module->id . '/daftarPasien/index'),
                        array(
                            'title' => 'Tambah Pasien IGD',
                            'class' => 'btn btn-danger',
                            // 'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                            "onclick" => "tambahTriage(null);$('#tambahTriage').dialog('open');return false;"
                        )
                    ); ?>
                </div>
                <div class="panel panel-success panel-shadow">
                    <div class="panel-heading">
                        <div class="panel-title">Tabel <strong>Pasien Triage</strong></div>
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
                    $("#div-form-pendaftaran").html(data);                      
                },
                error: function (jqXHR, textStatus, errorThrown) {                                    
                }
            });     
        }
        return false;
    }
        
    const setDaftar = (obj) => {
        let url = $(obj).data("url");        
        $.ajax({
            type: 'GET',
            url: url,               
            dataType: "json",
            success: function (data) {    
                $("#div-form-pendaftaran").html(data);                
                $("#dialogPendaftaran").dialog("open");                   
            },
            error: function (jqXHR, textStatus, errorThrown) {                                    
            }
        });        
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
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogRincianTagihanSementara',
    'options' => array(
        'title' => '<span style="width: 100%"> <span style="float: left !important; width:80% !important;">Rincian Tagihan Sementara</span>',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1000,
        'height' => 570,
        'resizable' => true,
        'close' => "js:function(){ $.fn.yiiGridView.update('daftarPasien-grid', {
            data: $('#daftarPasien-form').serialize()
        }); }",
    ),
));

$r_login = Yii::app()->user->getState('ruangan_id');

// var_dump($r_login); die;
?>
<iframe name='iframeRincianTagihanSementara' width="100%" height="100%"></iframe>
<?php $this->endWidget(); ?>
