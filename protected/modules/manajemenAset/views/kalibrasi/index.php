<?php
/**
 * view utama untuk menampilkan form - form dan data pada transaksi kalibrasi
 * 
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link    <http://172.9.1.15/simpp/docs/>
 * @link    <http://piindonesia.co.id>
 */
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'kalibrasi-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('enctype'=>'multipart/form-data','onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);','onclick'=>'cekDisabled(this);',),
    'focus' => '#',
        ));

        echo CHtml::hiddenField('no_row',0);
?>

<div class="panel panel-gradient">	

    <div class="panel-heading">
        <div class="panel-title"><i class="glyphicon glyphicon-briefcase"></i> Kalibrasi</div>
    </div>
    <div class="panel-body">
    <p class="help-block" style="color:#333;"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>
    <?php echo $form->errorSummary($model); ?>
    <?php 
        if (isset($_GET['frame'])){
            $this->renderPartial('_riwayatKalibrasiFrame', array('model' => $modRiwayatKalibarasi,'format'=>$format)); 
        }else{
            $this->renderPartial('_riwayatKalibrasi', array('modRiwayatKalibarasi' => $modRiwayatKalibarasi,'format'=>$format)); 
        }
    ?>
    <div class="panel panel-primary panel-success">
        <div class="panel-heading">
            <div class="panel-title">											
                <i class="glyphicon glyphicon-file"></i> Kalibrasi																	
            </div>
        </div>
        <div class="panel-body">
            <div class="row-fluid">
                <div class="col-sm-6">  
                    <div class="control-group">
                        <?php echo CHtml::label('Jenis Peralatan <span class="required">*</span>','nmbarang',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->hiddenField($model, 'invperalatan_id', array('readonly' => true)); ?>
                            <?php
                        if (!isset($_GET['frame'])){
                                    $this->widget('MyJuiAutoComplete', array(
                                        'name' => 'invperalatan_nmbrg',
                                        'source' => 'js: function(request, response) {
                                               $.ajax({
                                                   url: "' . $this->createUrl('/actionAutoComplete/DropInventarisasiAset') . '",
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
                                            'minLength' => 3,
                                            'focus' => 'js:function( event, ui ) {
                                            $(this).val( ui.item.label);
                                            return false;
                                        }',
                                            'select' => 'js:function( event, ui ) {
                                            $("#invperalatan_nmbrg").val(ui.item.invperalatan_namabrg); 
                                            $("#no_aset").val(ui.item.invperalatan_kode);
                                            $("#lokasi_aset").val(ui.item.lokasiaset_namalokasi);
                                            $("#MAInvkalibarasiT_invperalatan_id").val(ui.item.invperalatan_namabrg);
                                             return false;
                                    }',
                                        ),
                                        'htmlOptions' => array(

                                            'class' => 'span3',
                                            'onkeyup' => "return $(this).focusNextInputField(event)",
                                        ),
                                        'tombolDialog' => array('idDialog' => 'dialogInvPeralatan'),
                                    ));
                            }else{
                                 echo $form->textField($model, 'invperalatan_namabrg', array('readonly' => true));
                            }
                        ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Nomor Aset','',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo CHtml::textField('no_aset',$model->invperalatan_kode,array('readonly'=>true)); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Nomor Seri','',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo CHtml::textField('nomor_seri',$model->peralatan_noseri,array('class'=>'peralatan_noseri','readonly'=>true)); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Lokasi. Aset','',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo CHtml::textField('lokasi_aset',!empty($model->lokasi->lokasiaset_namalokasi)?$model->lokasi->lokasiaset_namalokasi:'',array('readonly'=>true)); ?>
                        </div>
                    </div>
                     <div class="control-group ">
                        <?php echo CHtml::label('Tanggal Kalibrasi','', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php $model->tglkalibrasi = MyFormatter::formatDateTimeForUser($model->tglkalibrasi); ?> 
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'tglkalibrasi',
                                'mode' => 'datetime',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                //
                                ),
                                'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)",'style'=>'width:204px;'
                                ),
                            ));
                            ?>
                        </div>
                    </div>
                     <div class="control-group ">
                        <?php echo CHtml::label('Berlaku Sampai','', array('class' => 'control-label')) ?>                        
                         <div class="controls">
                            <?php
                            $model->berlaku_sdtgl = MyFormatter::formatDateTimeForUser($model->berlaku_sdtgl);
                            $this->widget('MyDateTimePicker', array(
                                'model' => $model,
                                'attribute' => 'berlaku_sdtgl',
                                'mode' => 'date',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                //
                                ),
                                'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)",'style'=>'width:204px;'
                                ),
                            ));
                            ?>
                        </div>
                    </div>
                    
                    <div class="form-utama form-body" id="form-pelaksana" del="form_pelaksana">
                        <?= $this->renderPartial('row/_pelaksana',['model'=>$modDet], true) ?>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="control-group">
                            <?php echo CHtml::label('Nomor Kalibrasi <span class="required">*</span>','',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->textField($model, 'nokalibrasi', array('readonly' => true, 'class' => 'span3 required', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Data Vendor Pemeliharaan','',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->hiddenField($model, 'supplier_id', array('readonly' => true)); ?>
                            <?php
                       $this->widget('MyJuiAutoComplete', array(
                        'name' => 'supplier_nama',
                        'source' => 'js: function(request, response) {
                                $.ajax({
                                        url: "' . $this->createUrl('AutoCompleteSupplier') . '",
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
                                'minLength' => 3,
                                'focus' => 'js:function( event, ui ) {
                                        $(this).val( ui.item.label);										
                                        return false;
                                }',
                                'select' => 'js:function( event, ui ) {
                                        $("#'.Chtml::activeId($model, 'supplier_id') . '").val(ui.item.supplier_id); 
                                        $("#supplier_nama").val(ui.item.supplier_nama); 
                                        return false;
                                }',
                        ),
                        'htmlOptions' => array(
                                'class'=>'span3',
                                'onkeyup'=>"return $(this).focusNextInputField(event)",        
                        ),
                        'tombolDialog' => array('idDialog' => 'dialogSupplier'),
                ));
                ?>
                        </div>
                    </div>
                    
                    <div class="control-group">
                            <?php echo CHtml::label('Keterangan','',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->textArea($model, 'invkalibrasi_ket', array('rows' => 5, 'cols' => 50, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        </div>
                    </div>
                                
                    
                    <div class="control-group">
                        <label class="control-label">Dokumen</label>
                        <div class="controls">
                        <?php
                            echo CHtml::link("Browse",'javascript:;',array('onclick'=>'fileLoad(this);','class'=>'btn btn-primary')).'&nbsp;'.CHtml::link("<u></u>",'javascript:;',array('onclick'=>'fileLoad(this);','class'=>'labelbrowse'));
                            echo CHtml::activeHiddenField($model, 'temp_lampiran_berkas',array('readonly' => true, 'class'=>'temp_picture_nama'));
//                            echo "<br/>".CHtml::link("<u>".$model->temp_lampiran_berkas."</u>",$this->createUrl('GetDokumen',array('id'=>$model->pegawaicuti_id)),array('rel'=>'tooltip','data-original-title'=>'Klik untuk mengunduh file', 'style'=>'color:blue;', 'target'=>'_BLANK'));
                            echo "<div class='hide'>";
                            echo CHtml::activeFileField($model,'lampiran_berkas',array( 'onchange'=>'cekFile(this);','accept'=>'application/pdf,.pdf',));
                            echo "</div>";                                   
                        ?>    
                            <br/>
                            <span style="color:red;font-size:9px;"><i>File berformat PDF dan maks 5mb</i></span>
                        </div>
                    </div>        
                                   
                    <div class="control-group">
                            <?php echo CHtml::label("Laik Pakai",'',array('class' => 'control-label')); ?>

                        <div class="controls">
                            <?php echo $form->checkBox($model,'islaikpakai', array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?>

                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>

    <div class="form-actions">
<?php
echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' =>(isset($_GET['sukses']))? 'btn btn-danger' : 'btn btn-danger submit', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)','disabled'=>(isset($_GET['sukses']))? true : false));
?>
        <?php
        if (isset($_GET['frame'])){
            echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl($this->module->id . '/Index'), array('class' => 'btn btn-default',
                'onclick' => 'myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = "' . $this->createUrl('Index',array('id'=>$_GET['id'],'frame'=>$_GET['frame'])) . '";} ); return false;'));
        }else{
            echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl($this->module->id . '/Index'), array('class' => 'btn btn-default',
                'onclick' => 'myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = "' . $this->createUrl('Index') . '";} ); return false;'));
        }
        ?>
        <?php
        $content = $this->renderPartial('tips/transaksi', array(), true);
        $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
        ?>
    </div>
</div>
</div>
<?php $this->endWidget(); ?>
<?php echo $this->renderPartial('_jsFunctions', array('model' => $model), true); ?>

<?php
//========= Dialog Inv Peralatan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogInvPeralatan',
    'options' => array(
        'title' => 'Pencarian Jenis Peralatan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 600,
        'zIndex' => 1002,
        'resizable' => false,
    ),
));

$modNamaBarang = new InvperalatanT('search');
$modNamaBarang->unsetAttributes();
if (isset($_GET['InvperalatanT'])) {
    $modNamaBarang->attributes = $_GET['InvperalatanT'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'barangsearch-grid',
    'dataProvider' => $modNamaBarang->searchDialogInvPeralatan(),
    'filter' => $modNamaBarang,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                                    "href"=>"",
                                    "id" => "selectObat",
                                    "onClick" => "
                                                  $(\"#invperalatan_nmbrg\").val(\"$data->invperalatan_namabrg\");
                                                  $(\"#MAInvkalibarasiT_invperalatan_id\").val(\"$data->invperalatan_id\");
                                                  $(\"#no_aset\").val(\"$data->invperalatan_kode\");
                                                  $(\"#nomor_seri\").val(\"$data->peralatan_noseri\");
                                                  $(\"#lokasi_aset\").val(\"$data->lokasiaset_namalokasi\");
                                                  setRiwayat();
                                                  $(\"#dialogInvPeralatan\").dialog(\"close\"); 
                                                  return false;
                                        "))',
            
        ),
        array(
            'header'=>'Nomor Aset',
            'name'=>'invperalatan_kode',
            'value'=>'$data->invperalatan_kode'
        ),
        array(
            'header'=>'Nomor Seri',
            'name'=>'peralatan_noseri',
            'value'=>'$data->peralatan_noseri'
        ),
        [
            'header' => 'Jenis Peralatan',
            'name' => 'invperalatan_namabrg'
        ],        
     
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
//========= end =============================
?>

<?php 
//========= Dialog buat cari vendor =========================

$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogSupplier',
    'options'=>array(
        'title'=>'Pencarian Data Vendor Pemeliharaan',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modSupplier = new SupplierM('search');
$modSupplier->unsetAttributes();
$modSupplier->supplier_aktif = true;

if(isset($_GET['GFSupplierM'])) {
    $modSupplier->attributes = $_GET['GFSupplierM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'supplier-grid',
	'dataProvider'=>$modSupplier->search(),
	'filter'=>$modSupplier,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                                    "href"=>"",
                                    "id" => "selectObat",
                                    "onClick" => "
                                                  $(\"#'.CHtml::activeId($model,'supplier_id').'\").val(\"$data->supplier_id\");
                                                  $(\"#supplier_nama\").val(\"$data->supplier_nama\");
                                                
                                                  $(\"#dialogSupplier\").dialog(\"close\"); 
                                                  return false;
                                        "))',
                ),
                array(
                    'header'=>'Nama',
                    'name'=>'supplier_nama',
                    'value'=>'$data->supplier_nama',
                    'filter'=>Chtml::activeTextField($modSupplier, 'supplier_nama', array('class' => 'numbers-only'))
                ),
                array(
                    'header'=>'Alamat',
                    //n 'filter'=>  CHtml::activeTextField($modSupplier, 'supplier_alamat'),
                    'value'=>'$data->supplier_alamat',
                    'filter'=>Chtml::activeTextField($modSupplier, 'supplier_alamat'),
                ),
            ),
            'afterAjaxUpdate' => 'function(id, data){
                   jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"}); }',
        ));
$this->endWidget();
//========= end  dialog =============================
?>

<?php
//========= Dialog buat cari data Pegawai Pelaksana =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPegawai',
    'options' => array(
        'title' => 'Pencarian Pegawai Pelaksana',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 600,
        'zIndex' => 1002,
        'resizable' => false,
    ),
));

$modPegawaiMenyetujui = new PegawaiV('search');
$modPegawaiMenyetujui->is_peg_internalaset = true;
if (isset($_GET['PegawairuanganV'])) {
    $modPegawaiMenyetujui->attributes = $_GET['PegawairuanganV'];
    $modPegawaiMenyetujui->is_peg_internalaset = true;
    $modPegawaiMenyetujui->jabatan_nama = isset($_GET['PegawairuanganV']['jabatan_nama'])?$_GET['PegawairuanganV']['jabatan_nama']:null;
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawaimenyetujui-grid',
    'dataProvider' => $modPegawaiMenyetujui->searchAllPegawai(),
    'filter' => $modPegawaiMenyetujui,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function($data){
    
                    $dt['namaLengkap'] = $data->namaLengkap;
                    $dt['pegawai_id'] = $data->pegawai_id;
                    $res = json_encode($dt);
                    
                    return CHtml::Link("<i class='icon-form-check'></i>","javascript:;",array("class"=>"btn-small", 
                    "href"=>"",
                    "id" => "selectObat",
                    "onClick" => "setPegawai(".$res.",'');"));
            },
        ),
        array(
            'header' => 'NIP',
            'filter' => CHtml::activeTextField($modPegawaiMenyetujui, 'nomorindukpegawai'),
            'value' => '$data->nomorindukpegawai',
        ),
        array(
            'header' => 'Nama Pegawai',
            'filter' => CHtml::activeTextField($modPegawaiMenyetujui, 'nama_pegawai'),
            'value' => '$data->nama_pegawai',
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_nama',
            'value' => function($data){
                        $hasil ='';
                        $j = JabatanM::model()->findByPk($data->jabatan_id);
                                
                        if (!empty($j)){
                            $hasil = $j->jabatan_nama;
                        }
                            return $hasil;
            },
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
//========= end Pegawai dialog =============================
?>

<script>
     $(document).ready(function () {
       <?php if(isset($_GET['sukses'])){ ?>
        $("input, select, textarea").attr("readonly",true);		
    <?php } ?>
        $('form').bind('click keyup select change', function (event) {
            cekDisabled(this);
        });
        $(document).on('click keyup select change', function () {
            cekDisabled('form');
        });
        cekDisabled('form');
     });  
</script>
