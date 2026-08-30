<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
$this->breadcrumbs = array(
    'Pemesanan Menu Diet Pegawai',
);
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'gzpesanmenudiet-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    'focus' => '#' . CHtml::activeId($model, 'nama_pemesan'),
));
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-utensils"></i> Transaksi <b>Pemesanan Menu Diet Pegawai</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Informasi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <?php
        if (!empty($_GET['sukses'])) {
            Yii::app()->user->setFlash('success', "Data pasien " . $model->nopesanmenu . " berhasil disimpan!");
        }
        ?>
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo $this->renderPartial($this->path_view . '_dataFormPegawai', array('form' => $form, 'model' => $model)); ?>
        <br>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Detail <b>Menu Diet</b>
                </div>
            </div>
            <div class="panel-body" id="fieldsetMenuDiet">
                <!--fieldset class="box" id="fieldsetMenuDiet"-->
                <div class="row">
                    <div class="col-sm-6">
                        <?php echo CHtml::hiddenField('jenisPesan'); ?>
                        <?php echo $form->textFieldRow($model, 'jenispesanmenu', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, "readonly" => true)); ?>
                        <?php // echo $form->dropDownListRow($model, 'jenispesanmenu', GZPesanmenudietT::jenisPesan(), array('inline' => true, 'empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'onchange' => 'setJenisPesan();', 'maxlength' => 50));  
                        ?>
                        <div class="control-group" id="groupRuangan">
                            <label class='control-label'><?php echo CHtml::checkBox('cekRuangan', true, array('onclick' => 'setRuangan();', 'onkeypress' => "return $(this).focusNextInputField(event);",)) . ' '; ?><?php echo CHtml::encode($model->getAttributeLabel('ruangan_id')); ?> <span class="required">*</span></label>
                            <div class="controls">
                                <?php echo CHtml::hiddenField('instalasi_id'); ?>
                                <?php echo CHtml::hiddenField('ruangan_id'); ?>
                                <?php
                                echo $form->dropDownList($model, 'instalasi_id', CHtml::listData(InstalasiM::model()->findAll('instalasi_aktif = true ORDER BY instalasi_nama ASC'), 'instalasi_id', 'instalasi_nama'), array(
                                    'empty' => '-- Pilih --', 'class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50,
                                    'ajax' => array(
                                        'type' => 'POST',
                                        'url' => $this->createUrl('setDropdownRuangan', array('encode' => false, 'namaModel' => '' . $model->getNamaModel() . '')),
                                        'update' => '#' . CHtml::activeId($model, 'ruangan_id') . ''
                                    ),
                                ));
                                ?>
                                <?php echo $form->dropDownList($model, 'ruangan_id', CHtml::listData($model->getRuanganItems($model->instalasi_id), 'ruangan_id', 'ruangan_nama'), array('empty' => '-- Pilih --', 'class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'onchange' => 'clearAll()')); ?>
                                <?php echo $form->error($model, 'ruangan_id'); ?>
                            </div>
                        </div>
                        <div class="control-group" id="pegawaiGroup" style='display:none'>
                            <label class='control-label'>Nama Pegawai</label>
                            <div class="controls">
                                <?php echo CHtml::hiddenField('pegawai_id'); ?>
                                <?php
                                $this->widget('MyJuiAutoComplete', array(
                                    'name' => 'namaPegawai',
                                    'source' => 'js: function(request, response) {
                                                $.ajax({
                                                    url: "' . $this->createUrl('pegawaiUntukMenuDiet') . '",
                                                    dataType: "json",
                                                    data: {
                                                        term: request.term,
                                                        idRuangan:$("#' . CHtml::activeId($model, 'ruangan_id') . '").val(),
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
                                                    $("#pegawai_id").val(ui.item.pegawai_id); 
                                                    $("#ruangan_id").val(ui.item.ruangan_id);
                                                    $("#instalasi_id").val(ui.item.instalasi_id);
                                                    $("#namaPegawai").val(ui.item.label); 
                                                    return false;
                                                }',
                                    ),
                                    'htmlOptions' => array(
                                        'onkeypress' => "return $(this).focusNextInputField(event)",
                                        'class' => 'span3',
                                        'placeholder' => 'Nama Pegawai',
                                    ),
                                    'tombolDialog' => array('idDialog' => 'dialogPegawai', 'jsFunction' => 'dialogMenuPegawai()'),
                                ));
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class='control-label'>Menu Diet</label>
                            <div class="controls">
                                <?php echo CHtml::hiddenField('menudiet_id'); ?>
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
                                        'class' => 'span3',
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
                            <label class='control-label'>Jenis Waktu</label>
                            <div>
                                <?php
                                $modJenisWaktu = JeniswaktuM::getJenisWaktu();
                                $myData = CHtml::encodeArray(CHtml::listData($modJenisWaktu, 'jeniswaktu_id', 'jeniswaktu_id'));
                                $myData = empty($myData) ? categories : $myData;
                                ?>
                                <!--fieldset-->
                                <?php echo '<table>
                                                            <tr>
                                                                <td>
                                                                    ' . Chtml::checkBoxList('jeniswaktu', false, CHtml::listData($modJenisWaktu, 'jeniswaktu_id', 'jeniswaktu_nama'), array('template' => '<label class="checkbox inline">{input}{label}</label>', 'separator' => '', 'style' => 'margin-left:2px;max-width:10px;', 'class' => 'span2 jeniswaktu', 'onkeypress' => "return $(this).focusNextInputField(event)")) . '
                                                                </td>
                                                            </tr>
                                                        </table>'; ?>
                                <!--</fieldset>-->
                            </div>
                        </div>
                        <div class="control-group">
                            <label class='control-label'>Jumlah</label>
                            <div class="controls">
                                <?php echo Chtml::textField('jumlah', 1, array('class' => 'span1 numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'text-align:right;')); ?>
                                <?php echo Chtml::dropDownList('URT', '', LookupM::getItems('ukuranrumahtangga'), array('empty' => '-- Pilih --', 'class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?>
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
                </div>
                <!--</fieldset>-->
                <style>
                    .table thead tr th {
                        vertical-align: middle;
                    }
                </style>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pemesanan Menu Diet Pegawai</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <!--div class="block-tabel"-->
                <table class="table table-striped table-bordered table-condensed table-responsive table-striped table-condensed" id="tableMenuDiet">
                    <thead>
                        <tr>
                            <th rowspan="2"><input type="checkbox" id="checkListUtama" name="checkListUtama" value="1" checked="checked" onclick="checkAll('cekList', this);hitungSemua();"></th>
                            <th rowspan="2">Instalasi/<br>Ruangan</th>
                            <th rowspan="2">Nama Pegawai</th>
                            <th rowspan="2">Jenis Kelamin</th>
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
            if (isset($_GET['sukses'])) {
                echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('title' => 'Simpan', 'class' => 'btn btn-danger disabled', 'type' => 'button', 'onKeypress' => 'return formSubmit(this,event)'));
            } else {
                echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'));
            }
            ?>
            <?php
            echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), Yii::app()->createUrl($this->module->id . '/PesanmenudietT/indexPegawai'), array(
                'title' => 'Ulang',
                'class' => 'btn btn-default',
                'onclick' => 'return refreshForm(this);'
            ));
            ?>
            <?php
            $content = $this->renderPartial('gizi.views.tips.transaksi', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>
<?php $this->renderPartial($this->path_view . '_dialog', array('model' => $model)); ?>
<?php
//========= Dialog buat cari Bahan Diet =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPegawai',
    'options' => array(
        'title' => 'Daftar Pegawai',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 500,
        'resizable' => false,
    ),
));
$modPegawai = new GZPegawairuanganV('search');
$modPegawai->unsetAttributes();
if (isset($_GET['GZPegawairuanganV'])) {
    $modPegawai->attributes = $_GET['GZPegawairuanganV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'gzpegawairuangan-v-grid',
    'dataProvider' => $modPegawai->searchDialog(),
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
				"id" => "selectPegawai",
				"onClick" => "
					$(\"#pegawai_id\").val($data->pegawai_id);
					$(\"#namaPegawai\").val(\'$data->nama_pegawai\');
					$(\"#dialogPegawai\").dialog(\"close\");
				"))',
        ),
        array(
            'name' => 'ruangan_nama',
            'filter' => false,
            'value' => '$data->ruangan_nama',
        ),
        'nama_pegawai',
        array(
            'name' => 'jeniskelamin',
            'filter' => LookupM::getItems('jeniskelamin'),
            'value' => '$data->jeniskelamin',
        ),
        'alamat_pegawai',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
?>
<?php
$this->widget('application.extensions.moneymask.MMask', array(
    'element' => '.numbersOnly',
    'config' => array(
        'defaultZero' => true,
        'allowZero' => true,
        'decimal' => ',',
        'thousands' => '',
        'precision' => 0,
    )
));
?>
<?php
$pegawai_login = Yii::app()->user->getState('pegawai_id');
$totalPesan = CHtml::activeId($model, 'totalpesan_org');
$instalasi_id = CHtml::activeId($model, 'instalasi_id');
$ruangan_id = CHtml::activeId($model, 'ruangan_id');
$jenisPesan = CHtml::activeId($model, 'jenispesanmenu');
$bahandiet_id = CHtml::activeId($model, 'bahandiet_id');
$namaPemesan = CHtml::activeId($model, 'nama_pemesan');
$pesanPegawai = Params::JENISPESANMENU_PEGAWAI;
$url = $this->createUrl('getMenuDietPegawai');
$jsx = <<< JS
    function inputMenuDiet(){
        var pegawai_id = $('#pegawai_id').val();
        var menudiet_id = $('#menudiet_id').val();
        var jumlah = $('#jumlah').val();
        var urt = $('#URT').val();
        var jeniswaktu = new Array();
        var ruangan_id = $('#${ruangan_id}').val();
        var instalasi_id = $('#${instalasi_id}').val();
        var instalasi = $('#instalasi_id').val();
        var ruangan = $('#ruangan_id').val();
        var jenisPesan = $('#${jenisPesan}').val();
        var pegawaiId = new Array();
		if(pegawai_id == ''){
			pegawai_id = '${pegawai_login}';
		}
        if (jenisPesan == ''){
            myAlert('Isi Jenis Pesan Menu');
            return false;
        }
        i = 0;
        $('.jeniswaktu').each(function(){
            value = $(this).val();
            if ($(this).is(':checked')){
                jeniswaktu[i]=value;
                i++;
            }
        });
        i = 0;
        $('.pegawaiId').each(function(){
            value = $(this).val();
            if ($(this).is(':checked')){
                pegawaiId[i]=value;
                i++;
            }
        });
        if (!jQuery.isNumeric(instalasi_id)){
            instalasi_id = instalasi;
        }
        if (!jQuery.isNumeric(ruangan_id)){
            if (!jQuery.isNumeric(pegawai_id) && (jenisPesan != "${pesanPegawai}")){
                myAlert('Ruangan untuk Tamu harus diisi');
                return false;
            }
            ruangan_id = ruangan;
        }
        if ($('#jenisPesan').val() == '${pesanPegawai}'){
            if ((!jQuery.isNumeric(pegawai_id))&&(pegawaiId.length < 1)){
                myAlert('Nama Pegawai Harus Diisi!');
                return false;
            }
        }
        if (!jQuery.isNumeric(menudiet_id)){
            myAlert('Isi Makanan Diet yang dipilih!');
            return false;
        }
        else if (jeniswaktu.length < 1){
            myAlert('Isi Jenis Waktu!');
            return false;
        }
        else{
            $.post('${url}', {pegawaiId:pegawaiId, jeniswaktu:jeniswaktu, pegawai_id:pegawai_id, menudiet_id:menudiet_id, jumlah:jumlah, urt:urt, ruangan_id:ruangan_id, instalasi_id:instalasi_id}, function(data){
                $('#tableMenuDiet tbody').append(data);
                $("#tableMenuDiet tbody tr:last .numbersOnly").maskMoney({"defaultZero":true,"allowZero":true,"decimal":",","thousands":"","precision":0,"symbol":null});
                hitungSemua();
            }, 'json');
        }
        $('#${jenisPesan}').attr('disabled','disabled');
        clearAll(1);
    }
    function clearAll(code){
        var tempRuangan = $('#${ruangan_id}').val();
        var tempInstalasi = $('#${instalasi_id}').val();
        var tempJenisPesan = $('#${jenisPesan}').val();
        $('#fieldsetMenuDiet div').find('input,select').each(function(){
           if ($(this).attr('type') == 'checkbox'){
            }
            else{
                $(this).val('');
            }
        });
        if (!jQuery.isNumeric(code)){
            $('#fieldsetMenuDiet #tableMenuDiet tbody').find('tr').each(function(){
                $(this).remove();
            });
        }
        if (jQuery.isNumeric(tempRuangan)){
            if ($('#cekRuangan').is(':checked')){
                 $.fn.yiiGridView.update('gzpegawairuangan-v-grid', {
                    data: "GZPegawairuanganV[ruangan_id]="+tempRuangan
                });
            }
        }
        $('#jumlah').val(1);
        $('#${ruangan_id}').val(tempRuangan);
        $('#${instalasi_id}').val(tempInstalasi);
        $('#${jenisPesan}').val(tempJenisPesan);
        $('#jenisPesan').val(tempJenisPesan);
    }
    function hitungSemua(){
        var sekian = 1;
        noUrut = 1;
        jumlah = 0;         
        $('.cekList').each(function(){
            var value = $(this).parents('tr').find('.nama').val();
            $(this).parents('tr').find('[name*="PesanmenupegawaiT"]').each(function(){
                var nama = $(this).attr('name');
                data = nama.split('PesanmenupegawaiT[]');
                if (typeof data[1] === "undefined"){}else{
                    $(this).attr('name','PesanmenupegawaiT['+(noUrut-1)+']'+data[1]);
                }
            });
            if (value == ''){
                $(this).parents('tr').find('.nama').val('Tamu '+sekian);
                sekian++;
            }
            $(this).parents('tr').find('#checkList').attr('name','checkList['+(noUrut-1)+']');
            if($(this).is(':checked')){
                jumlah++;
            }
            noUrut++;
        });
        $('#${totalPesan}').val(jumlah);
    }
    function setRuangan(){
        if ($('#cekRuangan').is(':checked')){
            $('#groupRuangan').find('select').each(function(){
                $(this).removeAttr('disabled','disabled');
            });
        }
        else{
            $('#groupRuangan').find('select').each(function(){
                $(this).attr('disabled','disabled');
            });
        }
        clearAll();
    }
    function setJenisPesan(){
        var value = $('#${jenisPesan}').val();
        if (value == '${pesanPegawai}'){
            $("#pegawaiGroup").slideDown('slow');
        }
        else{
            $("#pegawaiGroup").slideUp('slow');
        }
    }
    function dialogMenuPegawai(){
        ruangan = $('#${ruangan_id}').val();
        if(!jQuery.isNumeric(ruangan)){
            $.fn.yiiGridView.update('gzpegawairuangan-v-grid', {
                    data: "GZPegawairuanganV[ruangan_id]=0"
            });
        }
        else{
            $.fn.yiiGridView.update('gzpegawairuangan-v-grid', {
                    data: "GZPegawairuanganV[ruangan_id]="+ruangan
            });
        }
        if(!jQuery.isNumeric(ruangan)){
            myAlert('Isi ruangan terlebih dahulu!');
            return false;
        }else{
            $('#dialogPegawai').dialog('open');
        }
    }
JS;
Yii::app()->clientScript->registerScript('head', $jsx, CClientScript::POS_HEAD);
?>
<?php Yii::app()->clientScript->registerScript('submit', '
    $.fn.yiiGridView.update(\'gzpegawairuangan-v-grid\', {
                    data: "GZPegawairuanganV[ruangan_id]=0"
            });
    $("form").submit(function(){
        jumlah = 0;
        $(".cekList").each(function(){
            if ($(this).is(":checked")){
                jumlah++;
            }
        });
        if ($("#' . $namaPemesan . '").val() == ""){
            myAlert("' . CHtml::encode($model->getAttributeLabel('nama_pemesan')) . ' harus diisi!");
            return false;
        }
        else if ($("#' . $jenisPesan . '").val() == ""){
            myAlert("' . CHtml::encode($model->getAttributeLabel('jenispesanmenu')) . ' harus diisi!");
            return false;
        }
        else if (jumlah < 1){
            myAlert("Pilih Menu Diet Pasien yang akan dipesan!");
            return false;
        }
    });
    setJenisPesan();
    clearAll();
', CClientScript::POS_READY); ?>