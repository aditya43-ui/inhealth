<style type="text/css">
        .radio-inline {
            margin-left: 10px;
        }
    </style>
<?php
$this->widget('bootstrap.widgets.BootAlert'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'id'=>'baujicoba-t-form',
    'enableAjaxValidation'=>false,
    'type'=>'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);',
        'enctype' => 'multipart/form-data',
        ),
    'focus'=>'#',
)); ?>
<?php echo $form->errorSummary($model); ?>
<?php echo $form->errorSummary($modDetail); ?>
<?php echo $form->errorSummary($modPegawai); ?>
    
<div class="panel-group joined" id="accordion-uji">
    <div class="panel panel-success"> 
        <div class="panel-heading"> 
            <h4 class="panel-title" style="background-color: #a6db9c"> 
                <a data-toggle="collapse" data-parent="#accordion-uji" href="#riwayat" aria-expanded="true" class="">
                    Riwayat Berita Acara Uji Coba / Uji Fungsi
                </a> 
            </h4> 
        </div> 
        <div id="riwayat" class="panel-collapse collapse" aria-expanded="false" style=""> 
            <div class="panel-body" style="background-color: #fff; overflow: auto; max-height: 300px;">
                <?php echo $this->renderPartial('_riwayat', array('model' => $model, 'form' => $form), true); ?>
            </div> 
        </div> 
    </div>
</div>

<div class="panel panel-success">
    <div class="panel panel-heading">
        <div class="panel-title"> <b> Berita Acara Uji Coba / Uji Fungsi </b></div>
    </div>
    <div class="panel-body">
        <?php $this->renderPartial('_formUjiCoba', array('model' => $model, 'form' => $form)); ?>
    </div>
</div>

<div class="panel panel-success">
    <div class="panel panel-heading">
        <div class="panel-title"> <b> Tim Teknis </b></div>
    </div>
    <div class="panel-body">
        <?php $this->renderPartial('_formTimTeknis', array('modPegawai' => $modPegawai, 'form' => $form)); ?>
    </div>
</div>

<div class="panel panel-success">
    <div class="panel panel-heading">
        <div class="panel-title"> <b> Alat yang diuji Fungsi </b></div>
    </div>
    <div class="panel-body">
        <?php $this->renderPartial('_formAlat', array('model' => $model, 'modDetail' => $modDetail, 'form' => $form)); ?>
        <div class = "control-group">
            <?php echo Chtml::label("Alat Berfungsi  <span class='required'>*</span> ",'hasil_uji', array('class'=>'control-label')) ?>
            <div class = "controls">
               <?php echo $form->dropDownList($model,'hasil_uji', LookupM::getItems("hasilujicoba"),
                    array('onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --', 'class' => 'span3 required')); ?>
            </div>
        </div>
    </div>
</div>
<div class="row-fluid">
    <div class="form-actions">
        <?php
        $modPPK = PejabatpengadaanM::model()->findByAttributes(array('jabatan_pengadaan' => Params::JABATAN_PENGADAAN_PPK, 'pejabatpengadaan_aktif' => true, 'pegawai_id' => Yii::app()->user->getState('pegawai_id')));

         if (!empty($modPPK)) {
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary submit',
                'type' => 'submit', 'disabled' => true  ));
         } else {
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary submit',
                'type' => 'submit', 'disabled' => isset($_GET['sukses'])? true : false ));
         }
        ?>
        <?php
        echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
        $this->createUrl($this->id.'/index', array('suratperjanjiankerja_id' => $_GET['suratperjanjiankerja_id'])), array('class'=>'btn btn-danger', 'onclick'=>'return refreshForm(this);'));
        echo "&nbsp;";
        if (empty($model->baujifungsi_id)) {
           // echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'disabled' => 'true'));
            //echo "&nbsp;";
        } else {
            //echo CHtml::htmlButton(Yii::t('mds','{icon} Cetak',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary-blue', 'disabled'=>false,'type'=>'button','onclick'=>'print(\'PRINT\')'));
            //echo "&nbsp;";
        }
        ?>
    </div>
</div>
<?php 
    $id = $_GET['suratperjanjiankerja_id'];
    $ujifungsi_id = $model->baujifungsi_id;
?>
<?php $this->endWidget(); ?>

<script>
    function cekFile(obj){       
        
        var cek = $(obj).val();        
        
        if (cek != ''){
            var type = $(obj).get(0).files[0]['type'];
            var tipeFile = type.split('/');                          
            var ext = '.'+$(obj).val().split('.').pop().toLowerCase();           
            var fileExt = $(obj).attr('accept').split(',');        
                                                
                                                
                                                
            if($.inArray(ext, fileExt) == -1 && $.inArray(tipeFile[0]+'/*', fileExt) == -1) {
                myAlert('Tipe file yang diupload tidak diizinkan !',"Perhatian!");
                $(obj).val("");                 
                return false;
            }

            var sizee = $(obj).get(0).files[0].size; //file size in bytes
            sizee = sizee / 1024; //file size in Kb
            sizee = sizee / 1024; //file size in Mb

            if (sizee > 5) {
                window.parent.toastr.warning("Ukuran file tidak boleh lebih dari 5mb","perhatian !");
                $(obj).val("");                 
                $(obj).parents(".control-group").find('.labelbrowse').html('');                
                return false;
            }else{
                $(obj).parents(".control-group").find('.labelbrowse').html("<u>"+$(obj).get(0).files[0]['name']+"</u>");
            }
        }       
    }
    
    function fileLoad(obj){
        $(obj).parents(".control-group").find('input:file').trigger('click');
    }
    
    
    function print(){
        window.open('<?php echo $this->createUrl('print',array('id'=>$model->baujifungsi_id)); ?>','printwin','left=100,top=100,width=640,height=480');
    }
    /*function setAlatUji(){
        var id  = '<?php // echo $id; ?>';       
        var ujifungsi_id  = '<?php // echo $ujifungsi_id; ?>';       
        $.ajax({
            type:'POST',
            url:'<?php // echo $this->createUrl('GetAlat'); ?>',
            data: {
                id: id, ujifungsi_id: ujifungsi_id
            },//
            dataType: "json",
            success:function(data){
                $('#tblAlat > tbody').append(data.form);
                jQuery('<?php // echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement":"<?php // echo Params::TOOLTIP_PLACEMENT; ?>"});
                renameInputRow($("#tblAlat"));

                $("#tblAlat").removeClass("animation-loading");
            },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
    }*/
    
    function renameInputRow(obj_table){
        var row = 0;
        $(obj_table).find("tbody > tr").each(function(){
                $(this).find('span').each(function(){ //element <input>
                        var old_name = $(this).attr("name").replace(/]/g,"");
                        var old_name_arr = old_name.split("[");
                        if(old_name_arr.length == 3){
                                $(this).attr("name","["+row+"]["+old_name_arr[2]+"]");
                        }
                });
                $(this).find('input,select,textarea').each(function(){ //element <input>
                        var old_name = $(this).attr("name").replace(/]/g,"");
                        var old_name_arr = old_name.split("[");
                        if(old_name_arr.length == 3){
                                $(this).attr("id",old_name_arr[0]+"_"+row+"_"+old_name_arr[2]);
                                $(this).attr("name",old_name_arr[0]+"["+row+"]["+old_name_arr[2]+"]");
                        }
                });
                row++;
        });

        //====button visibility
        //init
        $(obj_table).find('tr td.rowbutton .icon-plus-sign').parent().show();
        $(obj_table).find('tr td.rowbutton .icon-minus-sign').parent().show();
        //set
        $(obj_table).find('tr td.rowbutton .icon-plus-sign').parent().hide();
        $(obj_table).find('tr:last-child td.rowbutton .icon-plus-sign').parent().show();
        var rowCount = $(obj_table).find('tbody tr').length;
        if(rowCount==1){
                $(obj_table).find('tr:first-child td.rowbutton .icon-minus-sign').parent().hide();
                $(obj_table).find('tr:first-child td.rowbutton .icon-plus-sign').parent().show();
                id = $(obj_table).find('tr:first-child input[name*="[dokumenpengadaan_id]"]').val();
                if(id!=""){
                        $(obj_table).find('tr:first-child td.rowbutton .icon-minus-sign').parent().show();
                }
        }
        //====end button visibility

    }
    
    function hapusLookup(obj){
        myConfirm("Apakah Anda yakin tidak melakukan Uji Coba/Fungsi terhadap item ini?","Perhatian!",
        function(r){
            if(r){
                $(obj).parents('tr').detach();
                renameInputRow($("#tblAlat"));
            }
        });
    }
    
    function renameInput(obj_table){
        var row = 0;
            var jmlRow = $('#tabelTimTeknis tbody tr').length;
            if (jmlRow == 1){
                    $("#tabelTimTeknis > tbody > tr:last .tambahRow").attr('style','display:true;');
                    $("#tabelTimTeknis > tbody > tr:last .hapusRow").attr('style','display:none;');
            }else{
                    $("#tabelTimTeknis > tbody > tr:last .tambahRow").attr('style','display:true;');
                    $("#tabelTimTeknis > tbody > tr .hapusRow").attr('style','display:true;');
            }
            var jmlRow1 = $('#tabelTimPenyedia tbody tr').length;
            if (jmlRow1 == 1){
                    $("#tabelTimPenyedia > tbody > tr:last .tambahRow").attr('style','display:true;');
                    $("#tabelTimPenyedia > tbody > tr:last .hapusRow").attr('style','display:none;');
            }else{
                    $("#tabelTimPenyedia > tbody > tr:last .tambahRow").attr('style','display:true;');
                    $("#tabelTimPenyedia > tbody > tr .hapusRow").attr('style','display:true;');
            }
            $(obj_table).find("tbody > tr").each(function(){
            $(this).find("#no_urut").val(row+1);
            $(this).attr('data-row',row);
            $(this).find('span[name*="[ii]"]').each(function(){ //element <span>
                var old_name = $(this).attr("name").replace(/]/g,"");
                var old_name_arr = old_name.split("[");
                if(old_name_arr.length == 3){
                    $(this).attr("name","["+row+"]["+old_name_arr[2]+"]");
                }
            });
            $(this).find('input,select,textarea').each(function(){ //element <input>
                var old_name = $(this).attr("name").replace(/]/g,"");
                var old_name_arr = old_name.split("[");
                if(old_name_arr.length == 3){
                    $(this).attr("id",old_name_arr[0]+"_"+row+"_"+old_name_arr[2]);
                    $(this).attr("name",old_name_arr[0]+"["+row+"]["+old_name_arr[2]+"]");
                }
            });                        
            row++;
        });
    }
    
    function tambahBaris()
    {
        var row = '<?php echo CJSON::encode($this->renderPartial('_rowTimTeknis',array('modPegawai'=>$modPegawai, 'i'=>1),true));?>';

        $("#tabelTimTeknis > tbody > tr:last .tambahRow").attr('style','display:none;');
        $("#tabelTimTeknis > tbody > tr:last .hapusRow").attr('style','display:true;');
        $('#tabelTimTeknis > tbody').append(row);
        renameInput('#tabelTimTeknis');   
        generatePicker();
        jQuery('input[name$="[nama_pegawai]"]').autocomplete(
        {
            'showAnim': 'fold',
            'minLength': 3,
            'focus': function (event, ui)
            {
                $(this).val(ui.item.nama_pegawai);
                return false;
            },
            'select': function (event, ui)
            {
                setPegAuto($(this), ui.item);
                return false;
            },
            'source': function (request, response)
            {
                $.ajax({
                    url: "<?php echo $this->createUrl('AutocompletePegawai'); ?>",
                    dataType: "json",
                    data: {
                        term: request.term
                    },
                    success: function (data) {
                        response(data);
                    }
                });
            }
        });
    }
    
    function tambahBarisPenyedia()
    {
        var rowPenyedia = '<?php echo CJSON::encode($this->renderPartial('_rowTimTeknisPenyedia',array('modPegawaiPenyedia'=>$modPegawaiPenyedia, 'i'=>1),true));?>';

        $("#tabelTimPenyedia > tbody > tr:last .tambahRow").attr('style','display:none;');
        $("#tabelTimPenyedia > tbody > tr:last .hapusRow").attr('style','display:true;');
        $('#tabelTimPenyedia > tbody').append(rowPenyedia);
        renameInput('#tabelTimPenyedia');   
        generatePicker();
    }
    
    function generatePicker(){
        $('#tabelTimTeknis').find("tbody > tr").each(function(){
            jQuery('input[name$="[nama_pegawai]"]').autocomplete(
            {
                'showAnim': 'fold',
                'minLength': 3,
                'focus': function (event, ui)
                {
                    $(this).val(ui.item.nama_pegawai);
                    return false;
                },
                'select': function (event, ui)
                {
                    setPegAuto($(this), ui.item);
                    return false;
                },
                'source': function (request, response)
                {
                    $.ajax({
                        url: "<?php echo Yii::app()->createUrl('ActionAutoComplete/getPegawai'); ?>",
                        dataType: "json",
                        data: {
                            term: request.term
                        },
                        success: function (data) {
                            response(data);
                        }
                    });
                }
            });
        });
        
    }
    
    function setDialog(obj){
        parent = $(obj).parents(".input-append").find("input").attr("id");
        var no = $(obj).parents("tr").data('row');
        $("#no_row").val(parseInt(no));
        dialog = "#dialog1";
        $(dialog).attr("parent-dialog",parent);
        $(dialog).dialog("open");   
    }
    
    function setDialogPenyedia(obj){
        parent = $(obj).parents(".input-append").find("input").attr("id");
        var no = $(obj).parents("tr").data('row');
        $("#no_row").val(parseInt(no));
        dialog = "#dialog2";
        $(dialog).attr("parent-dialog",parent);
        $(dialog).dialog("open");   
    }
    
    // Set Pegawai Dialog
    function setPegawaiDialog(pegawai_id){
        var dialog = "#dialog1";
        var no = $("#no_row").val() 
        parent = $(dialog).attr("parent-dialog");
        obj = $("#"+parent);;
        
        var ada = 0;
        $("#tabelTimTeknis > tbody > tr").each(function(){
            var pegawai_id_temp = $(this).find('input[name$="[pegawai_id]"]').val();
            if(pegawai_id == pegawai_id_temp){
                ada++;
            }
        });
                
        if(ada==0){
            $.get('<?php echo $this->createUrl('AutocompletePegawai'); ?>',{pegawai_id:pegawai_id},function(data){
                $("#tabelTimTeknis > tbody > tr").each(function(){
                    if ($(this).attr('data-row') == no){
                        setPeg($(this).find('input[name$="[pegawai_id]"]'),data[0]);
                    }                    
                });
                
            },"json");
        }else{
            myAlert("Data Pegawai sudah ditambahkan di tabel, silahkan pilih data Pegawai yang lain");
        }
        
        $(dialog).dialog("close");
    }  
    
    function setPeg(obj,item){
        var ada = 0;
        $("#tabelTimTeknis > tbody > tr").each(function(){
            peg_id = $(this).find('input[name$="[pegawai_id]"]').val();
            if(item.pegawai_id === peg_id){
                ada++;
            }
        });
        
        if(ada==0){
            $(obj).parents('tr').find('input[name$="[pegawai_id]"]').val(item.pegawai_id);
            $(obj).parents('tr').find('input[name$="[nama_pegawai]"]').val(item.nama_pegawai);
            $(obj).parents('tr').find('input[name$="[nomorindukpegawai]"]').val(item.nomorindukpegawai);
        }else{
            myAlert("Data Pegawai sudah ditambahkan di tabel, silahkan pilih data Pegawai yang lain");
            $(obj).parents('tr').find('input[name$="[nama_pegawai]"]').val('');
            $(obj).parents('tr').find('input[name$="[pegawai_id]"]').val('');
            $(obj).parents('tr').find('input[name$="[nomorindukpegawai]"]').val('');
            $(obj).val('');
        }
    }
    
    function setPegAuto(obj,item)
    {
        var ada = 0;
        $("#tabelTimTeknis > tbody > tr").each(function(){
            pegawai_id_temp = $(this).find('input[name$="[pegawai_id]"]').val();
            if(item.pegawai_id == pegawai_id_temp){
                ada++;
            }
        });
        if(ada==0){
            $(obj).parents('tr').find('input[name$="[pegawai_id]"]').val(item.pegawai_id);
            $(obj).parents('tr').find('input[name$="[nama_pegawai]"]').val(item.nama_pegawai);
            $(obj).parents('tr').find('input[name$="[nomorindukpegawai]"]').val(item.nomorindukpegawai);
        }else{
            myAlert("Data Pegawai sudah ditambahkan di tabel, silahkan pilih data Pegawai yang lain");
            $(obj).parents('tr').find('input[name$="[nama_pegawai]"]').val('');
            $(obj).parents('tr').find('input[name$="[pegawai_id]"]').val('');
            $(obj).parents('tr').find('input[name$="[nomorindukpegawai]"]').val('');
        }
    }
    
    function hapusBaris(obj){
        var id = $(obj).parents("tr").find("input[name$='[pegtimteknis_id]']").val();
        if(id !== ""){
            myConfirm("Apakah anda yakin akan menghapus data ini dari database?","Perhatian!",
            function(r){
                    if(r){
                        $.ajax({
                                type:'POST',
                                url:'<?php echo $this->createUrl('Delete'); ?>&id='+id,
                                data: {id : id},//
                                dataType: "json",
                                success:function(data){
                                        if(data.sukses == 1){
                                                $(obj).parents('tr').detach();
                                                renameInput($("#tabelTimTeknis"));
                                        }
                                        myAlert(data.pesan);
                                        var rowCount = $("#tabelTimTeknis").find('tbody tr').length;
                                        if(rowCount==0){
                                            tambahBaris();
                                        }
                                },
                                error: function (jqXHR, textStatus, errorThrown) { myAlert("Data tidak dapat dihapus karena sudah digunakan di transaksi lainnya.");}
                        });
                    }
            });
        } else {
            $(obj).parents('tr').detach();
            renameInput($("#tabelTimTeknis"));
        }
    }
    
    function hapusBarisPenyedia(obj){
        var id = $(obj).parents("tr").find("input[name$='[teknisipenyedia_id]']").val();
        if(id !== ""){
            myConfirm("Apakah anda yakin akan menghapus data ini dari database?","Perhatian!",
            function(r){
                    if(r){
                        $.ajax({
                                type:'POST',
                                url:'<?php echo $this->createUrl('DeletePenyedia'); ?>&id='+id,
                                data: {id : id},//
                                dataType: "json",
                                success:function(data){
                                        if(data.sukses == 1){
                                                $(obj).parents('tr').detach();
                                                renameInput($("#tabelTimPenyedia"));
                                        }
                                        myAlert(data.pesan);
                                        var rowCount = $("#tabelTimPenyedia").find('tbody tr').length;
                                        if(rowCount==0){
                                            tambahBarisPenyedia();
                                        }
                                },
                                error: function (jqXHR, textStatus, errorThrown) { myAlert("Data tidak dapat dihapus karena sudah digunakan di transaksi lainnya.");}
                        });
                    }
            });
        } else {
            $(obj).parents('tr').detach();
            renameInput($("#tabelTimPenyedia"));
        }
    }
    
    function setPegawai(){
        var id  = '<?php echo $ujifungsi_id; ?>';       
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('GetPegawai'); ?>',
            data: {
                id: id
            },
            dataType: "json",
            success:function(data){
                $('#tabelTimTeknis > tbody').append(data.form);
                jQuery('<?php  echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement":"<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
                renameInput($("#tabelTimTeknis"));
                generatePicker();
                $("#tabelTimTeknis").removeClass("animation-loading");
                sesudahSimpan();
            },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
    }
    
    function setDataPenyedia(){
        var id  = '<?php echo $ujifungsi_id; ?>';       
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('GetPenyedia'); ?>',
            data: {
                id: id
            },
            dataType: "json",
            success:function(data){
                $('#tabelTimPenyedia > tbody').append(data.form);
                jQuery('<?php  echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement":"<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
                renameInput($("#tabelTimPenyedia"));
                generatePicker();
                $("#tabelTimPenyedia").removeClass("animation-loading");
                sesudahSimpan();
            },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
    }
    
    function setValidasiCekDisabled(obj, validasiTambahan) {
        $(obj).find('input[type=text], textarea').blur(function() {
            cekDisabled(obj, validasiTambahan);
        });
        $(obj).find("input[type=text], select").change(function() {
            cekDisabled(obj, validasiTambahan);
        });
        
        cekDisabled(obj, validasiTambahan);
    }
    
    function sesudahSimpan(){
        <?php if(isset($_GET['sukses'])){ ?>
            $('input,textarea,select').attr('disabled', true);
            $('.panel-success').find('.btn').attr('disabled', true);
            $('.submit').attr('disabled', true);
            $('.tambahRow').hide();
            $('.hapusRow').hide();
        <?php } ?>
    }
    
    $(document).ready(function () {
        
        terminke = $("#<?= CHtml::activeId($model, 'terminke') ?>").val();
        jumlah_termin = $("#<?= CHtml::activeId($model, 'jumlah_termin') ?>").val();
                
        if('<?php echo $ujifungsi_id; ?>' === '' && terminke > jumlah_termin){
            $(".submit").attr('disabled', true);
        }else{
            setValidasiCekDisabled($("#baujicoba-t-form"), function() {
                return true;
            });
        }
        
        $("#tabelTimTeknis > tbody > tr .tambahRow").attr('style','display:true;');
        $("#tabelTimPenyedia > tbody > tr .tambahRow").attr('style','display:true;');
        if ('<?php echo $ujifungsi_id; ?>' !== '') {
            setPegawai();
            setDataPenyedia();
        } else {
            tambahBaris(); 
            tambahBarisPenyedia();
        }
        
        $('.baujifungsidet_tanggal').parents('td').find('.add-on').css('float','right');
        
        sesudahSimpan();
    });
</script>