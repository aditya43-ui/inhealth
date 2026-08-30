<?php
$this->breadcrumbs = array(
    'Pemesanan Menu Diet Pasien'
); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-utensils"></i> Transaksi <b>Pemesanan Menu Diet Pasien</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Informasi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'gzpesanmenudiet-t-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
            'focus' => '#' . CHtml::activeId($model, 'nama_pemesan'),
        ));
        ?>
        <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
        <?php
            Yii::app()->user->setFlash('success', "Data pasien " . $model->nopesanmenu . " berhasil disimpan!");
        ?>
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php $this->renderPartial($this->path_view . '._dataForm', array('form' => $form, 'model' => $model)); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="fas fa-file-contract"></i> Detail <b>Menu Diet</b>
                </div>
            </div>
            <div class="panel-body" id="fieldsetMenuDiet">
                <!--fieldset class="box" id="fieldsetMenuDiet"-->
                <div class="row">
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php //echo CHtml::hiddenField('jenisPesan');  
                            ?>
                            <?php //echo $form->dropDownListRow($model, 'jenispesanmenu', GZPesanmenudietT::jenisPesan(), array('inline' => true, 'empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'onchange' => 'setJenisPesan();', 'maxlength' => 50)); 
                            ?>
                            <label class='control-label'><?php echo CHtml::encode($model->getAttributeLabel('ruangan_id')); ?> <span class="required">*</span></label>
                            <div class="controls">
                                <?php //echo CHtml::hiddenField('instalasi_id');  
                                ?>
                                <?php //echo CHtml::hiddenField('ruangan_id'); 
                                ?>
                                <?php
                             $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
                              $model->instalasi_id = Yii::app()->user->getState('instalasi_id');
                              $model->ruangantampil = Yii::app()->user->getState('ruangantampil');
                              $model->instalasitampil = Yii::app()->user->getState('instalasitampil');
                    
                                // if ($model->disabled === true) {
                                    echo $form->dropDownList($model, 'instalasi_id', CHtml::listData($model->getInstalasiItems(), 'instalasi_id', 'instalasi_nama'), array(
                                        'empty' => '-- Pilih --', 'class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50,
                                        'ajax' => array(
                                            'type' => 'POST',
                                            'url' => $this->createUrl('setDropdownRuangan', array('encode' => false, 'namaModel' => '' . $model->getNamaModel() . '')),
                                            'update' => '#' . CHtml::activeId($model, 'ruangan_id') . ''
                                        ),
                                    ));
                                ?>
                                 <?php  echo $form->dropDownList($model, 'ruangan_id', CHtml::listData($model->getRuanganItems(), 'ruangan_id', 'ruangan_nama'), array('empty' => '-- Pilih --', 'class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'onchange' => 'clearAll()')); ?>
                       
                                <?php echo $form->error($model, 'ruangan_id'); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class='control-label'>Nama Pasien</label>
                            <div class="controls">
                                <?php echo CHtml::hiddenField('jenistarif_id'); ?>
                                <?php echo CHtml::hiddenField('kelaspelayanan_id'); ?>
                                <?php echo CHtml::hiddenField('penjamin_id'); ?>
                                <?php echo CHtml::hiddenField('pasien_id'); ?>
                                <?php echo CHtml::hiddenField('pendaftaran_id'); ?>
                                <?php echo CHtml::hiddenField('pasienadmisi_id'); ?>
                                <!--<div class="input-append" style='display:inline'>-->
                                <?php
                                $this->widget('MyJuiAutoComplete', array(
                                    'name' => 'namaPasien',
                                    'source' => 'js: function(request, response) {
                                                $.ajax({
                                                    url: "' . $this->createUrl('pasienUntukMenuDiet') . '",
                                                    dataType: "json",
                                                    data: {
                                                        namaPasien: request.term,
                                                        ruangan_id:$("#' . CHtml::activeId($model, 'ruangan_id') . '").val(),
                                                    },
                                                    success: function (data) {
                                                        response(data);
                                                    }
                                                })
                                            }',
                                    'options' => array(
                                        'showAnim' => 'fold',
                                        'minLength' => 2,
                                        'focus' => 'js:function( event, ui ) {
                                                    $(this).val( ui.item.label);
                                                    return false;
                                                }',
                                        'select' => 'js:function( event, ui ) {
                                                    $(this).val( ui.item.nama_pasien);
                                                    $("#pasien_id").val(ui.item.pasien_id); 
                                                    $("#pendaftaran_id").val(ui.item.pendaftaran_id); 
                                                    $("#pasienadmisi_id").val(ui.item.pasienadmisi_id); 
                                                    $("#kelaspelayanan_id").val(ui.item.kelaspelayanan_id); 
                                                    $("#penjamin_id").val(ui.item.penjamin_id); 
                                                    $("#jenistarif_id").val(ui.item.jenistarif_id);                                                                                                                     refreshDialogMenuDiet();
                                                    return false;
                                                }',
                                    ),
                                    'htmlOptions' => array(
                                        'onkeypress' => "return $(this).focusNextInputField(event)",
                                        'class' => 'hurufs-only span4',
                                        'placeholder' => 'Nama Pasien',
                                    ),
                                    'tombolDialog' => array('idDialog' => 'dialogPasien', 'jsFunction' => 'dialogMenuPasien()'),
                                ));
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class='control-label'>Menu Diet</label>
                            <div class="controls">
                                <?php echo CHtml::hiddenField('URT'); ?>
                                <?php echo CHtml::hiddenField('menudiet_id'); ?>
                                <?php echo CHtml::hiddenField('jenisdiet_id'); ?>
                                <!--<div class="input-append" style='display:inline'>-->
                                <?php
                                $this->widget('MyJuiAutoComplete', array(
                                    'name' => 'menuDiet',
                                    'source' => 'js: function(request, response) {
                                                $.ajax({
                                                    url: "' . $this->createUrl('menuDiet') . '",
                                                    dataType: "json",
                                                    data: {
                                                        term: request.term,
                                                        jenisdiet_id:$("#' . CHtml::activeId($model, 'jenisdiet_id') . '").val(),
                                                        kelaspelayanan_id:$("#kelaspelayanan_id").val(),
                                                        penjamin_id:$("#penjamin_id").val(),
                                                    },
                                                    success: function (data) {
                                                        response(data);
                                                    }
                                                })
                                            }',
                                    'options' => array(
                                        'showAnim' => 'fold',
                                        'minLength' => 2,
                                        'focus' => 'js:function( event, ui ) {
                                                    $(this).val( ui.item.label);
                                                    return false;
                                                }',
                                        'select' => 'js:function( event, ui ) {
                                                    $("#menudiet_id").val(ui.item.menudiet_id); 
                                                    $("#URT").val(ui.item.ukuranrumahtangga); 
                                                    return false;
                                                }',
                                    ),
                                    'htmlOptions' => array(
                                        'onkeypress' => "return $(this).focusNextInputField(event)",
                                        'class' => 'span4 custom-only',
                                        'placeholder' => 'Menu Diet',
                                    ),
                                    'tombolDialog' => array('idDialog' => 'dialogMenuDiet'),
                                ));
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="control-group">
                            <label class='control-label' style="text-align:left;padding-left:25px;">Jenis Waktu</label>
                            <?php
                            $modJenisWaktu = JeniswaktuM::getJenisWaktu();
                            $myData = CHtml::encodeArray(CHtml::listData($modJenisWaktu, 'jeniswaktu_id', 'jeniswaktu_id'));
                            $myData = empty($myData) ? array() : $myData;
                            ?>
                            <!--fieldset-->
                            <?php echo '<table>
                                                            <tr >
                                                                <td>
                                                                    ' . Chtml::checkBoxList('jeniswaktu', false, CHtml::listData($modJenisWaktu, 'jeniswaktu_id', 'jeniswaktu_nama'), array('template' => '<label class="checkbox inline">{input}{label}</label>', 'separator' => '', 'style' => 'margin-left:2px;max-width:10px;', 'class' => 'span2 jeniswaktu', 'onkeypress' => "return $(this).focusNextInputField(event)")) . '
                                                                </td>
                                                            </tr>
                                                        </table>';
                            ?>
                            <!--</fieldset>-->
                        </div>
                        <div class="control-group">
                            <label class='' style="text-align:left;padding-left:25px;padding-right:5px;">Jumlah</label>
                            <?php echo Chtml::textField('jumlah', 1, array('class' => 'span1 numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'text-align:right;', 'readonly' => true)); ?>
                            <?php //echo Chtml::dropDownList('URT', '', LookupM::getItems('ukuranrumahtangga'), array('empty' => '-- Pilih --', 'class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?>
                            <?php
                            echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>', array(
                                'onclick' => 'inputMenuDiet();return false;',
                                'class' => 'btn btn-primary',
                                'onkeypress' => "inputMenuDiet();return $(this).focusNextInputField(event)",
                                'rel' => "tooltip",
                                'title' => "Klik untuk menambahkan Menu Diet",
                            ));
                            ?>
                        </div>
                    </div>
                </div>
                <style>
                    .table thead tr th {
                        vertical-align: middle;
                    }
                </style>
                <!--</fieldset>-->
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pemesanan Menu Diet Pasien</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <!--div class="block-tabel"-->
                <table class="table table-bordered table-striped table-condensed" id="tableMenuDiet">
                    <thead>
                        <tr>
                            <th rowspan="2"><input type="checkbox" id="checkListUtama" name="checkListUtama" value="1" checked="checked" onclick="checkAll('cekList', this);hitungSemua();"></th>
                            <th rowspan="2">Instalasi/<br>Ruangan</th>
                            <th rowspan="2">No. Pendaftaran</th>
                            <th rowspan="2">No. Rekam Medik</th>
                            <th rowspan="2">Nama Pasien</th>
                            <th rowspan="2">Jenis Kelamin/ <br>Umur</th>
                            <th rowspan="2">Jenis Diet</th>
                            <th colspan="<?php echo count((array)$modJenisWaktu); ?>">
                                <p style="margin: 0; text-align: center;">Menu Diet</p>
                            </th>
                            <th rowspan="2">Jumlah</th>
                            <th rowspan="2">Satuan/URT</th>
                        </tr>
                        <tr>
                            <?php
                            foreach ($modJenisWaktu as $row) {
                                echo '<th>' . $row->jeniswaktu_nama . '</th>';
                            }
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <!--/div-->
            </div>
        </div>
        <div class="form-actions">
            <?php
            if (isset($_GET['id'])) {
                echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'));
            } else {
                echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'));
            }
            ?>
            <?php
            echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), Yii::app()->createUrl($this->module->id . '/' . $this->id . '/index'), array(
                'class' => 'btn btn-default',
                'onclick' => 'return refreshForm(this);'
            ));
            ?>
            <?php
            $content = $this->renderPartial('gizi.views.tips.transaksi', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
<?php $this->renderPartial($this->path_view . '_dialog', array('model' => $model)); ?>
<?php
//ruangan daftar pasien
if (Yii::app()->user->getState('instalasi_id') == Params::INSTALASI_ID_GIZI) {
    $nama = "<span id='namaRuangan'></span>";
} else {
    $nama = '-' . Yii::app()->user->getState('ruangan_nama') . '-';
}
?>
<?php
//========= Dialog buat cari Bahan Diet =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPasien',
    'options' => array(
        'title' => 'Daftar Pasien ' . $nama,
        'autoOpen' => false,
        'modal' => true,
        'width' => 1000,
        'height' => 500,
        'resizable' => false,
    ),
));
if (Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_VK) {
    echo $this->renderPartial($this->path_view . 'daftarPasien/_pasienVK', array(), true);
} else {
    echo $this->renderPartial($this->path_view . 'daftarPasien/_pasienRI', array(), true);
}
$this->endWidget();
?>
<?php
$instalasi_id = CHtml::activeId($model, 'instalasi_id');
$ruangan_id = CHtml::activeId($model, 'ruangan_id');
$totalPesan = CHtml::activeId($model, 'totalpesan_org');
$bahandiet_id = CHtml::activeId($model, 'bahandiet_id');
$jenisdiet_id = CHtml::activeId($model, 'jenisdiet_id');
$namaPemesan = CHtml::activeId($model, 'nama_pemesan');
$url = Yii::app()->createUrl('gizi/pesanmenudietT/getMenuDietDetail');
$jsx = <<< JS
    function inputMenuDiet(){
        var pasien_id = $('#pasien_id').val();
        var pendaftaran_id = $('#pendaftaran_id').val();
        var pasienadmisi_id = $('#pasienadmisi_id').val();
        var kelaspelayanan_id = $('#kelaspelayanan_id').val();
        var menudiet_id = $('#menudiet_id').val();
        var jumlah = $('#jumlah').val();
        var jeniswaktu = new Array();
        var pendaftaranId = new Array();
        var pasienAdmisi = new Array();
        var jenisdiet_id = $('#jenisdiet_id').val();
        var urt = $('#URT').val();
        var ruangan_id = $('#${ruangan_id}').val();
        var instalasi_id = $('#${instalasi_id}').val();
        i = 0;
        $('.jeniswaktu').each(function(){
            value = $(this).val();
            if ($(this).is(':checked')){
                jeniswaktu[i]=value;
                i++;
            }
        });
        i = 0;
        $('.pendaftaranId').each(function(){
            value = $(this).val();
            valueAdmisi = $(this).attr('admisi');
            if ($(this).is(':checked')){
                pasienAdmisi[i]=valueAdmisi;
                pendaftaranId[i]=value;
                i++;
            }
        });
        if (!jQuery.isNumeric(ruangan_id)){
            myAlert('Silakan pilih ruangan!');
            return false;
        }
        else if ((!jQuery.isNumeric(pendaftaran_id))&&(pendaftaranId.length < 1)){
            myAlert('Isi Nama Pasien!');
            return false;
        }
        else if (!jQuery.isNumeric(menudiet_id)){
            myAlert('Isi Makanan Diet yang dipilih!');
            return false;
        }
        else if (jeniswaktu.length < 1){
            myAlert('Isi Jenis Waktu yang dipilih!');
            return false;
        }
        else{
            $.post('${url}', {jenisdiet_id:jenisdiet_id, pasien_id:pasien_id, pasienAdmisi:pasienAdmisi, pasienadmisi_id:pasienadmisi_id, pendaftaranId:pendaftaranId, jeniswaktu:jeniswaktu, pendaftaran_id:pendaftaran_id, menudiet_id:menudiet_id, jumlah:jumlah, urt:urt, ruangan_id:ruangan_id, instalasi_id:instalasi_id, kelaspelayanan_id:kelaspelayanan_id}, function(data){                                
                if (cekDetail(data.jenisDietPasien) === true){
                    $('#tableMenuDiet tbody').append(data.tr);
                    $("#tableMenuDiet tbody tr:last .numbersOnly").maskMoney({"defaultZero":true,"allowZero":true,"decimal":",","thousands":"","precision":0,"symbol":null});
                    hitungSemua();
                }else{
                    myAlert("Maaf, Nama Pasien '<b>"+data.namaPasien+"</b>' Jenis Diet '<b>"+data.jenisDiet+"</b>' <br> Pada Tabel Sudah Ada");                        
                }
            }, 'json');
        }
        clearAll(1);
    }
    function hitungSemua(){
        noUrut = 1;
        jumlah = 0;
        $('.cekList').each(function(){
            $(this).parents('tr').find('[name*="PesanmenudetailT"]').each(function(){
                var nama = $(this).attr('name');
                data = nama.split('PesanmenudetailT[]');
                if (typeof data[1] === "undefined"){}else{
                    $(this).attr('name','PesanmenudetailT['+(noUrut-1)+']'+data[1]);
                }
            });
            noUrut++;
            if($(this).is(':checked')){
                jumlah++;
            }
        });
        $('#${totalPesan}').val(jumlah);
    }
    function cekDetail(jenisDietPasien){
        x = true;
        $('.jenisDiet').each(function(){
            if ($(this).val() == jenisDietPasien){                                
                x = false;                
            }
        });
        return x;
    }
    function clearAll(code){
        var tempRuangan = $('#${ruangan_id}').val();
        var tempInstalasi = $('#${instalasi_id}').val();
        console.log('ok',tempInstalasi);
        $('#fieldsetMenuDiet div').find('input,select').each(function(){
            if ($(this).attr('type') == 'checkbox'){
            }
            else{
                $(this).val('');
                $("#GZPesanmenudietT_instalasitampil").val(tempInstalasi);
                $("#GZPesanmenudietT_ruangantampil").val(tempRuangan);
            }
        });
        if (!jQuery.isNumeric(code)){
            $('#fieldsetMenuDiet #tableMenuDiet tbody').find('tr').each(function(){
                $(this).remove();
            });
           // console.log(code);
        }
        if(jQuery.isNumeric(tempRuangan)){
            $.fn.yiiGridView.update('gzinfokunjunganri-v-grid', {
                   //data: "GZInfokunjunganriV[ruangan_id]="+tempRuangan
                   data: "GZInfopasienmasukkamarV[ruangan_id]="+tempRuangan 
                 //  console.log(tempRuangan);
                });
        }
        $('#jumlah').val(1);
        $('#${ruangan_id}').val(tempRuangan);
        $('#${instalasi_id}').val(tempInstalasi);
    }
    function dialogMenuPasien(){
        ruangan = $('#${ruangan_id}').val();
        if(!jQuery.isNumeric(ruangan)){
            $.fn.yiiGridView.update('gzinfokunjunganri-v-grid', {
                    //data: $("#dialogPasien :input").serialize() + "&" + "GZInfokunjunganriV[ruangan_id]=0"
                    data: $("#dialogPasien :input").serialize() + "&" + "GZInfopasienmasukkamarV[ruangan_id]=0"
            });
        }
        else{
            refreshDialogPasien();
            $.fn.yiiGridView.update('gzinfokunjunganri-v-grid', {
                    //data: $("#dialogPasien :input").serialize() + "&" + "GZInfokunjunganriV[ruangan_id]="+ruangan
                    data: $("#dialogPasien :input").serialize() + "&" + "GZInfopasienmasukkamarV[ruangan_id]="+ruangan
            });
        }
        if(!jQuery.isNumeric(ruangan)){
            myAlert('Isi ruangan terlebih dahulu!');
            return false;
        }else{
            $('#dialogPasien').dialog('open');
        }
    }
JS;
Yii::app()->clientScript->registerScript('head', $jsx, CClientScript::POS_HEAD);
?>
<?php Yii::app()->clientScript->registerScript('submit', '
    $.fn.yiiGridView.update("gzinfokunjunganri-v-grid", {
		//data: "GZInfokunjunganriV[ruangan_id]=0"
                data: "GZInfopasienmasukkamarV[ruangan_id]=0"                
	});
    $("form").submit(function(){
        var jenisdiet_id =$("#' . $jenisdiet_id . '").val();
        jumlah = 0;
        $(".cekList").each(function(){
            if ($(this).is(":checked")){
                jumlah++;
            }
        });
        if (!jQuery.isNumeric($("#' . $jenisdiet_id . '").val())){
            myAlert("' . CHtml::encode($model->getAttributeLabel('jenisdiet_id')) . ' harus diisi!");
            return false;
        }
        else if ($("#' . $namaPemesan . '").val() == ""){
            myAlert("' . CHtml::encode($model->getAttributeLabel('nama_pemesan')) . ' harus diisi!");
            return false;
        }
        else if (jumlah < 1){
            myAlert("Pilih Menu Diet Pasien yang akan dipesan!");
            return false;
        }
    });
', CClientScript::POS_READY); ?>
<script>
    function refreshDialogPasien() {
        //$("#namaBarang").addClass("animation-loading-1");
        var ru = $("#GZPesanmenudietT_ruangan_id option:selected").html();
        setTimeout(function() {
            $("#namaRuangan").html('-' + ru + '-');
        }, 500);
    }
</script>