<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'preventifmainten-m-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
	'focus'=>'#',
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row-fluid">

            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="control-group">
                        <?php echo CHtml::label('Jenis Peralatan <span class="required">*</span>','barang_id', array('class'=>'span2 control-label')) ?>
                        <div class="controls">
                            <?php 
                            $barang = BarangM::model()->findByPk($modHitung->barang_id);
                            $namaBarang = empty($barang) ? null : $barang->barang_nama;
                            echo CHtml::hiddenField('idBarang', $modHitung->barang_id); ?>
                            <?php
                                $this->widget('MyJuiAutoComplete', array(
                                    'name' => 'namaBarang',
                                    'value' => $namaBarang,
                                    'source' => 'js: function(request, response) {
                                    $.ajax({
                                        url: "' . $this->createUrl('/actionAutoComplete/getBarang') . '",
                                        dataType: "json",
                                        data: {
                                            term: request.term,
                                            barang_type: "'.ParamsConst::TYPE_BARANG_INVENTARIS.'"
                                        },
                                        success: function (data) {
                                            response(data);
                                        }
                                    })
                                }',
                                'options' => array(
                                    'showAnim' => 'fold',
                                    'minLength' => 3,
                                    'focus' => 'js:function( event, ui ) {
                                        $(this).val( ui.item.label);
                                        return false;
                                    }',
                                    'select' => 'js:function( event, ui ) {
                                        $("#idBarang").val(ui.item.barang_id); 
                                        return false;
                                    }',
                                ),
                                'htmlOptions' => array(
                                    'onkeypress' => "return $(this).focusNextInputField(event)",
                                    'class' => 'span3 custom-only',
                                    'placeholder'=>'Ketikan nama barang',
                                ),
                                'tombolDialog' => array('idDialog' => 'dialogBarang', 'idTombol'=>'tombolDialogBarang'),
                                ));
                            ?>
                        </div>
                    </div>
                    <div class="control-group">            
                        <?php echo CHtml::label('Fungsi <span class="required">*</span>','res_fungsi_nama', array('class'=>'span2 control-label')) ?>
                        <div class="controls">
                            <?php 
                            $list = KlasifikasiresikoM::model()->findAllByAttributes(array('kelompokresiko'=>"Fungsi"));
                            $listData = CHtml::listData(KlasifikasiresikoM::model()->findAllByAttributes(array('kelompokresiko'=>"Fungsi")),'kategori_resiko','kategori_resiko');
                            $listOption = array();
                            foreach($list as $item) {
                                $listOption[$item->kategori_resiko] = array(
                                    'data-nilai'=>$item->nilai_resiko,
                                );
                            }
                            echo $form->dropDownList($modHitung,'res_fungsi_nama',$listData,array('empty'=>'-- Pilih --','class'=>'span3  required','onchange' => 'selectNilaiFungsi(this)' ,
                            'onkeypress'=>'return $(this).focusNextInputField(event)', 'options'=>$listOption)); ?>
                            <?php echo $form->textField($modHitung,'res_fungsi_nilai',array('class'=>'span2 integer2 angka','readonly' => true ,'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20)); ?>
                        </div>
                    </div>
                    <div class="control-group">            
                        <?php echo CHtml::label('Resiko <span class="required">*</span>','Resiko', array('class'=>'span2 control-label')) ?>
                        <div class="controls">
                            <?php 
                            $list = KlasifikasiresikoM::model()->findAllByAttributes(array('kelompokresiko'=>"Resiko"));
                            $listData = CHtml::listData(KlasifikasiresikoM::model()->findAllByAttributes(array('kelompokresiko'=>"Resiko")),'kategori_resiko','kategori_resiko');
                            $listOption = array();
                            foreach($list as $item) {
                                $listOption[$item->kategori_resiko] = array(
                                    'data-nilairesiko'=>$item->nilai_resiko,
                                );
                            }
                            echo $form->dropDownList($modHitung,'res_klinis_nama',$listData,array('empty'=>'-- Pilih --','class'=>'span3  required','onchange' => 'selectNilaiResiko(this)' ,
                            'onkeypress'=>'return $(this).focusNextInputField(event)', 'options'=>$listOption)); ?>
                            <?php echo $form->textField($modHitung,'res_klinis_nilai',array('class'=>'span2 integer2 angka','readonly' => true ,'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20)); ?>
                        </div>
                    </div>
                    <div class="control-group">            
                        <?php echo CHtml::label('Pemeliharaan <span class="required">*</span>','Pemeliharaan', array('class'=>'span2 control-label')) ?>
                        <div class="controls">
                            <?php 
                            $list = KlasifikasiresikoM::model()->findAllByAttributes(array('kelompokresiko'=>"Pemeliharaan"));
                            $listData = CHtml::listData(KlasifikasiresikoM::model()->findAllByAttributes(array('kelompokresiko'=>"Pemeliharaan")),'kategori_resiko','kategori_resiko');
                            $listOption = array();
                            foreach($list as $item) {
                                $listOption[$item->kategori_resiko] = array(
                                    'data-nilaipemeliharaan'=>$item->nilai_resiko,
                                );
                            }
                            echo $form->dropDownList($modHitung,'res_pemeliharaan_nama',$listData,array('empty'=>'-- Pilih --','class'=>'span3  required','onchange' => 'selectNilaiPemeliharaan(this)' ,
                            'onkeypress'=>'return $(this).focusNextInputField(event)', 'options'=>$listOption)); ?>
                            <?php echo $form->textField($modHitung,'res_pemeliharaan_nilai',array('class'=>'span2 integer2 angka','readonly' => true ,'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20)); ?>
                        </div>
                    </div>
                    <div class="control-group">            
                        <?php echo CHtml::label('Insiden <span class="required">*</span>','Insiden', array('class'=>'span2 control-label')) ?>
                        <div class="controls">
                            <?php 
                            $list = KlasifikasiresikoM::model()->findAllByAttributes(array('kelompokresiko'=>"Insiden"));
                            $listData = CHtml::listData(KlasifikasiresikoM::model()->findAllByAttributes(array('kelompokresiko'=>"Insiden")),'kategori_resiko','kategori_resiko');
                            $listOption = array();
                            foreach($list as $item) {
                                $listOption[$item->kategori_resiko] = array(
                                    'data-nilaiinsiden'=>$item->nilai_resiko,
                                );
                            }
                            echo $form->dropDownList($modHitung,'res_insiden_nama',$listData,array('empty'=>'-- Pilih --','class'=>'span3  required','onchange' => 'selectNilaiInsiden(this)' ,
                            'onkeypress'=>'return $(this).focusNextInputField(event)', 'options'=>$listOption)); ?>
                            <?php echo $form->textField($modHitung,'res_insiden_nilai',array('class'=>'span2 integer2 angka','readonly' => true ,'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20)); ?>
                        </div>
                    </div>
                    <div class="control-group ">            
                        <?php echo CHtml::label('Nilai EM <span class="required">*</span>','nilai_em', array('class'=>'span2 control-label')) ?>
                        <div class="controls ">
                            <div id="nilaiEm" style="display: inline">
                               <?php echo $form->textField($modHitung,'nilai_em',array('class'=>'span2 integer2','readonly' => true,'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20)); ?>
                            </div>
                            <div id="klasifikasiEm" style="display: inline">
                                <?php echo $form->textField($modHitung,'frekuensi_inspeksi',array('class'=>'span3','readonly' => true ,'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20)); ?>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-body">
                <div class="control-group">
                    <?php echo CHtml::label('Frekuensi <span class="required">*</span>','frekuensi_inspeksi', array('class'=>'span2 control-label')) ?>
                    <div id="fp" class="controls">
                        <?php echo $form->textField($model,'frekuensi_inspeksi', array('empty'=>'-- Pilih --', 'readonly' => true ,'class'=>'span2 required','onkeypress'=>'return $(this).focusNextInputField(event)')); ?>
                        <?php echo $form->textField($model,'frekuensi_jml',array('class'=>'span1 integer','readonly' => true ,'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20)); ?>
                        <?php echo $form->textField($model,'frekuensi_satuan', array('empty'=>'-- Pilih --', 'readonly' => true ,'class'=>'span2 required','onkeypress'=>'return $(this).focusNextInputField(event)')); ?>
                    </div>
                    <div id="fk" class="controls" style="display: none">
                        <?php echo $form->dropDownList($model,'frekuensi_inspeksi',CHtml::listData(LookupM::model()->findAllByAttributes(array('lookup_type'=>"frekuensi_inspeksi")),'lookup_value','lookup_name'),array('empty'=>'-- Pilih --', 'readonly' => false ,'class'=>'span2 required','onkeypress'=>'return $(this).focusNextInputField(event)')); ?>
                        <?php echo $form->textField($model,'frekuensi_jml',array('style'=>'text-align: right;','class'=>'span1 numbers-only','onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20)); ?>
                        <?php echo $form->dropDownList($model,'frekuensi_satuan',CHtml::listData(LookupM::model()->findAllByAttributes(array('lookup_type'=>"satuanumum")),'lookup_value','lookup_name'),array('empty'=>'-- Pilih --','class'=>'span2 required','onkeypress'=>'return $(this).focusNextInputField(event)')); ?>
                    </div>
                    
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('IPM Checklist <span class="required">*</span>','ipmchecklist_id', array('class'=>'control-label')) ?>
                    <div class="controls col-sm-8">
                        <?php
                        
                        $ceklis = IpmchecklistM::model()->findAll(array(
                            'condition'=>"ipm_aktif = true and trim(ipm_jenis) <> '".ParamsConst::IPM_JENIS_NON_IPM."'",
                            'select'=>'ipm_jenis',
                            'group'=>'ipm_jenis',
                        ));
                        
                        
                        
                        
                        /*
                        $cek = new IpmchecklistM;
                        $cek->ipm_jenis = Params::IPM_JENIS_NON_IPM;

                        $ceklis[] = $cek;
                        */
                        
                        $list_ceklis = CHtml::listData($models, 'ipmchecklist_id', 'ipmchecklist_list');
                        
                        
                        foreach ($ceklis as $item) {
                            
                            $clist = CHtml::listData(IpmchecklistM::model()->findAllByAttributes(array('ipm_jenis'=>$item->ipm_jenis)),'ipmchecklist_id','ipm_listnama');
                            
                            echo '<div style="font-weight: bold">'.$item->ipm_jenis.'</div>';
                            
                            
                        
                            foreach ($clist as $ipm_id => $cek) {
                                
                                echo '<div class="col-sm-6">';
                                echo $form->checkbox($model, '[detail]['.$ipm_id.']ipmchecklist_id', array(
                                    'uncheckValue'=>0,
                                    'checked'=>empty($list_ceklis[$ipm_id]) ? false : $list_ceklis[$ipm_id],
                                ))." ".CHtml::label($cek, '');
                                echo '</div>';
                            }
                            echo '<div class="clear"></div>';
                            
                        }
                        ?>
                        
                        
                    </div>
                </div>
                <div class="control-group">
                    <?php 
                    $model->ipmchecklist_list = false;
                    
                    echo CHtml::label('Checklist ','ipmchecklist_list', array('class'=>'control-label')) ?>
                    <div class="controls">
                    <?php echo $form->textField($model,'ipmchecklist_list', array('class' => 'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
                        <?php
                            echo CHtml::htmlButton('<i class="entypo-plus"></i>', 
                                array('onclick' => 'inputCheklis();return false;',
                                    'class' => 'btn btn-primary',
                                    'onkeypress' => "return $(this).focusNextInputField(event)",
                                    'rel' => "tooltip",
                                    'title' => "Klik untuk menambahkan Checklist",));
                        ?>
                    <div id="divTabelCeklis">
                        <table id="tabel-ceklis">
                            <thead>
                                <th style="display: none"> Nama Ceklis</th>
                                <th style="display: none"> Batal </th>
                            </thead>
                            <tbody> 
                            
                            </tbody>
                        </table>
                    </div>
                    </div>
                    
                </div>
            </div>
            </div>
	</div>
	<div class="row-fluid">
	<div class="form-actions">
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),array('class'=>'btn btn-danger', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
				$this->createUrl('create'), 
				array('class'=>'btn btn-default',
					  'onclick'=>'return refreshForm(this);')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Preventive Maintence Barang',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
		<?php $this->widget('UserTips',array('content'=>'')); ?>
		</div>
	</div>
<?php $this->endWidget(); ?>

<script type="text/javascript">
    tr = new String(<?php echo CJSON::encode($this->renderPartial('_rowCeklis', array('model'=>$model), true)); ?>);
    function inputCheklis(){
        var ceklis_id = $('#PreventifMaintenM_ipmchecklist_id').val();
        var ceklis = $('#PreventifmaintenM_ipmchecklist_list').val();
        if (ceklis != '') {
            $.ajax({
                type: 'POST', 
                url: '<?php echo $this->createUrl('setFormCeklis')?>',
                data: {ceklis_id:ceklis_id,ceklis:ceklis},
                dataType: "json", 
                success:function(data){
                    if (data.pesan !== "") {
                        myAlert(data.pesan);
                        return false; 
                    }
                    $('#tabel-ceklis tbody').append(data.form);
                    $('#tabel-ceklis tbody ceklis:last-child').val(ceklis);
                    $('#PreventifmaintenM_ipmchecklist_list').val(null);
                }, 
                error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
            });
        } else {
            myAlert("Silahkan isi ceklis terlebih dahulu!");
        }
    }
    function renameInputRow(obj_table){
        var row = 0;
        $(obj_table).find("tbody > tr").each(function(){
            $(this).find("#no_urut").val(row+1);
            $(this).find('span').each(function(){ //element <input>
                var old_name = $(this).attr("name").replace(/]/g,"");
                var old_name_arr = old_name.split("[");
                if(old_name_arr.length == 4){
                    $(this).attr("name","[detail]["+row+"]["+old_name_arr[3]+"]");
                }
            });
            $(this).find('input,select,textarea').each(function(){ //element <input>
                var old_name = $(this).attr("name").replace(/]/g,"");
                var old_name_arr = old_name.split("[");
                if(old_name_arr.length == 4){
                    $(this).attr("id",old_name_arr[0]+"_detail_"+row+"_"+old_name_arr[3]);
                    $(this).attr("name",old_name_arr[0]+"[detail]["+row+"]["+old_name_arr[3]+"]");
                }
            });
            row++;
        });
		
    }
    function hapus(obj)
    {
        myConfirm("Apakah anda akan menghapus checklist ini?","Perhatian!",function(r) {
            if(r){
                $(obj).parent().parent().remove();
                            renameInputRow($("#table-ceklis"));
            }
        });
    }
    function selectNilaiFungsi()
    {
        $("#PerhitunganemM_res_fungsi_nilai").val($("#PerhitunganemM_res_fungsi_nama :selected").data('nilai'));
        hitungNilaiEM();
    }
    function selectNilaiResiko(){
        $("#PerhitunganemM_res_klinis_nilai").val($("#PerhitunganemM_res_klinis_nama :selected").data('nilairesiko'));
        hitungNilaiEM();
    }
    function selectNilaiPemeliharaan(){
        $("#PerhitunganemM_res_pemeliharaan_nilai").val($("#PerhitunganemM_res_pemeliharaan_nama :selected").data('nilaipemeliharaan'));
        hitungNilaiEM();
    }
    function selectNilaiInsiden(){
        $("#PerhitunganemM_res_insiden_nilai").val(  $("#PerhitunganemM_res_insiden_nama :selected").data('nilaiinsiden'));        
        hitungNilaiEM();
    } 
    
    function hitungNilaiEM() {
        var sum = 0; 
        $(".angka").each(function(){
            if ($(this).val() != "") {
                sum += parseInt($(this).val());
            }
        });
        $("#PerhitunganemM_nilai_em").val(sum);
        console.log(sum);        
        
        if (sum < 12 ) {
            $('#fp').hide().find(":input").prop("disabled", true);
            $('#fk').show().find(":input").prop("disabled", false);
            $("#PerhitunganemM_frekuensi_inspeksi").val("Sesuai Keperluan");
        } else if (sum >= 12 && sum <= 14){
            $("#PerhitunganemM_frekuensi_inspeksi").val("Annual");
            $("#fp #PreventifmaintenM_frekuensi_inspeksi").val("SETIAP");
            $("#fp #PreventifmaintenM_frekuensi_jml").val(1);
            $("#fp #PreventifmaintenM_frekuensi_satuan").val("TAHUN");
            $('#fp').show().find(":input").prop("disabled", false);
            $('#fk').hide().find(":input").prop("disabled", true);
        } else if (sum >= 15 && sum <= 19){
            $("#PerhitunganemM_frekuensi_inspeksi").val("Semi-Annual");
            $("#fp #PreventifmaintenM_frekuensi_inspeksi").val("SETIAP");
            $("#fp #PreventifmaintenM_frekuensi_jml").val(6);
            $("#fp #PreventifmaintenM_frekuensi_satuan").val("BULAN");
            $('#fp').show().find(":input").prop("disabled", false);
            $('#fk').hide().find(":input").prop("disabled", true);
        } else {
            $("#PerhitunganemM_frekuensi_inspeksi").val("Three Yearly");
            $("#fp #PreventifmaintenM_frekuensi_inspeksi").val("SETIAP");
            $("#fp #PreventifmaintenM_frekuensi_jml").val(4);
            $("#fp #PreventifmaintenM_frekuensi_satuan").val("BULAN");
            $('#fp').show().find(":input").prop("disabled", false);
            $('#fk').hide().find(":input").prop("disabled", true);
        }
    }

</script>
<?php
//========= Dialog buat cari Barang =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogBarang',
    'options' => array(
        'title' => 'Daftar Barang',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 500,
        'resizable' => false,
    ),
));

$modBarang = new MABarangM('searchDialog');
$modBarang->unsetAttributes();
$modBarang->barang_aktif = true;
$modBarang->barang_type = ParamsConst::TYPE_BARANG_INVENTARIS;
if (isset($_GET['MABarangM'])){
    $modBarang->attributes = $_GET['MABarangM'];
    $modBarang->barang_aktif = true;
    $modBarang->barang_type = ParamsConst::TYPE_BARANG_INVENTARIS;
}   

$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'barang-m-grid',
    'dataProvider'=>$modBarang->searchDialog(),
    'filter'=>$modBarang,
       // 'template'=>"{items}\n{pager}",
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
        ////'barang_id',
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectBarang",
                                    "onClick" => "
                                        
                                        $(\'#idBarang\').val(\'$data->barang_id\');
                                        $(\'#namaBarang\').val(\'$data->barang_nama\');
                                        $(\'#satuan\').val(\'$data->barang_satuan\');
                                        $(\'#dialogBarang\').dialog(\'close\');
                                        return false;"))',
        ),
        [
            'header' => 'Jenis Peralatan',
            'name' => 'barang_nama'
        ]         
        
    ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
?>

<?php 
$urlAjax = $this->createUrl('AjaxGetPesanBarang');
$notif = Yii::t('mds','Do You want to cancel?');
$js = <<< JS
    function inputBarang(){
        idBarang = $('#idBarang').val();
        jumlah = $('#jumlah').val();
        satuan = $('#satuan').val();

        if (!jQuery.isNumeric(idBarang)){
            myAlert('Isi Barang yang akan dipesan');
            return false;
        }
        else if (!jQuery.isNumeric(jumlah)){
            myAlert('Isi jumlah barang yang akan dipesan');
            return false;
        }
        else{
            if (cekList(idBarang) == true){
                $.post('${urlAjax}', {idBarang:idBarang, jumlah:jumlah, satuan:satuan}, function(data){
                    $('#tableDetailBarang tbody').append(data);
                    $("#tableDetailBarang tbody tr:last .numbersOnly").maskMoney({"defaultZero":true,"allowZero":true,"decimal":",","thousands":"","precision":0,"symbol":null});
                    clear();
                    renameInput();
                    $('#GUPesanbarangT_keterangan_pesan').blur();
                }, 'json');
            }
        }
        
    }
            
    function cekList(id){
        x = true;
        $('.barang').each(function(){
            if ($(this).val() == id){
                myAlert('Barang telah ada di daftar');
                clear();
                x = false;
            }
        });
        return x;
    }
    
    function clear(){
        $('#formDetailBarang').find('input, select').each(function(){
            $(this).val('');
        });
        $('#jumlah').val(1);
    }
    
    function batal(obj){
        myConfirm('Apakah anda akan menghapus barang?', 'Perhatian!', function(r)
        {
            if(r){
                $(obj).parent().parent().remove();
                $('#GUPesanbarangT_keterangan_pesan').blur();
            }
        });
        
        renameInput();
    }
    function renameInput(){
        urutan = 0;
        $('.barang').each(function(){
            $(this).parents('tr').find('[name*="PesanbarangdetailT"]').each(function(){
                var nama = $(this).attr('name');
                data = nama.split('PesanbarangdetailT[]');
                if (typeof data[1] === "undefined"){}else{
                    $(this).attr('name','PesanbarangdetailT['+urutan+']'+data[1]);
                }
            });
            urutan++;
        });        
    }
JS;
Yii::app()->clientScript->registerScript('onhead',$js,  CClientScript::POS_HEAD);
?>
    
