<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>


    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>

    <?php if(isset($_GET['sukses'])){
       Yii::app()->user->setFlash('success',"<strong>Berhasil!</strong> Data berhasil disimpan.");
    } ?>

    <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
        'id'=>'guterimapersediaan-t-form',
        'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)','onsubmit'=>'return prosesSimpan(this)'),
        'focus'=>'#',
    )); ?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<div class="row-fluid">
    <div class="col-sm-12">
        <p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>
        <?php echo $form->errorSummary($model); ?>

        <div class="panel panel-success panel-shadow">
            <div class="panel-heading">
                <div class="panel-title">Data Permintaan Pembelian</div>
            </div>
            <div class="panel-body">
                <?php 
                    if(Yii::app()->user->getState('ispenerimaanlangsung') == false){
                        if (isset($modBeli)) {
                            $this->renderPartial('_dataBeli', array('modBeli'=>$modBeli, 'model'=>$model));
                        }
                    }
                ?>
            </div>
        </div>

         <div class="panel panel-success panel-shadow">
            <div class="panel-heading">
                <div class="panel-title">Data Penerimaan Barang</div>
            </div>
            <div class="panel-body">
                <div class="row-fluid">
                    <div class="col-sm-6">
                        <?php echo $form->hiddenField($model,'pajak_id'); ?>
                        <?php echo $form->textFieldRow($model,'nopenerimaan',array('readonly'=>true,'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20,'readonly'=>true)); ?>
                        <div class="control-group ">
                            <?php echo $form->labelEx($model, 'tglterima', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                    $model->tglterima = MyFormatter::formatDateTimeForUser($model->tglterima);
                                    $this->widget('MyDateTimePicker', array(
                                            'model' => $model,
                                            'attribute' => 'tglterima',
                                            'mode' => 'datetime',
                                            'options' => array(
                                                    'dateFormat' => Params::DATE_FORMAT,
                                                    'maxDate' => 'd',
                                            ),
                                            'htmlOptions' => array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)",),
                                    ));
                                ?>
                                <?php echo $form->error($model, 'tglterima'); ?>
                            </div>
                        </div>
                        <?php echo $form->textFieldRow($model,'nosuratjalan',array('class'=>'span3 custom-only', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50,'placeholder'=>'Ketikan No. Surat Jalan')); ?>
                        <div class="control-group ">
                            <?php echo $form->labelEx($model, 'tglsuratjalan', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                $model->tglsuratjalan = MyFormatter::formatDateTimeForUser($model->tglsuratjalan);
                                $this->widget('MyDateTimePicker', array(
                                        'model' => $model,
                                        'attribute' => 'tglsuratjalan',
                                        'mode' => 'datetime',
                                        'options' => array(
                                                'dateFormat' => Params::DATE_FORMAT,
                                                'maxDate' => 'd',
                                        ),
                                        'htmlOptions' => array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)",),
                                ));
                                ?>
                                <?php echo $form->error($model, 'tglsuratjalan'); ?>
                            </div>
                        </div>
                        <?php if(Yii::app()->user->getState('ispenerimaanlangsung') == true){ ?>
                        <div class="control-group ">
                            <?php echo Chtml::label("Sumber Dana <font style = 'color:red'>*</font>", 'supplier_id', array('class' => 'control-label required')); ?>
                            <div class="controls">
                                <?php echo $form->dropDownList($model,'sumberdana_id',
                                    CHtml::listData(SumberdanaM::model()->findAll('sumberdana_aktif = true'), 'sumberdana_id', 'sumberdana_nama'),
                                    array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event)",
                                    'empty'=>'-- Pilih --')); ?>
                            </div>
                        </div>
                        <div class="control-group ">
                            <?php echo Chtml::label("Supplier <font style = 'color:red'>*</font>", 'supplier_id', array('class' => 'control-label required')); ?>
                            <div class="controls">
                                <?php echo $form->hiddenField($model, 'supplier_id',array('readonly'=>true,'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                                <?php
                                $this->widget('MyJuiAutoComplete', array(
                                        'model'=>$model,
                                        'attribute' => 'supplier_nama',
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
                                                        refreshDialog();
                                                        return false;
                                                }',
                                        ),
                                        'htmlOptions' => array(
                                                'class'=>'span3',
                                                'onkeyup'=>"return $(this).focusNextInputField(event)",
                                                'onblur' => 'if(this.value === "") $("#'.Chtml::activeId($model, 'supplier_id') . '").val(""); '
                                        ),
                                        'tombolDialog' => array('idDialog' => 'dialogSupplier'),
                                ));
                                ?>
                            </div>
                        </div>
                        <?php } ?>
                        <div class="control-group ">
                            <?php echo $form->labelEx($model, 'ruanganpenerima_id', array('class'=>'control-label')); ?>
                             <div class="controls">
                                 <?php echo $form->hiddenField($model,'instalasi_id'); ?>
                                 <?php echo $form->hiddenField($model,'ruanganpenerima_id'); ?>
                                <?php echo $form->textField($model,'instalasi_nama',array('readonly'=>true,'class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                                 <?php echo $form->textField($model,'ruanganpenerima_nama',array('readonly'=>true,'class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                             </div>
                        </div>
                        <div class="control-group ">
                            <?php echo Chtml::label( "Pegawai Penerima <font style='color:red;'>*</font>", 'peg_penerima_id', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->hiddenField($model, 'peg_penerima_id'); ?>
                                <?php echo $form->textField($model,'peg_penerima_nama', array('class'=>'span3','readonly' => TRUE)); ?>
                            </div>
                        </div>
                        <div class="control-group ">
                            <?php echo Chtml::label("Pegawai Mengetahui <font style='color:red;'>*</font>", 'peg_mengetahui_id', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->hiddenField($model, 'peg_mengetahui_id'); ?>
                                <?php echo $form->textField($model,'peg_mengetahui_nama', array('class'=>'span3','readonly' => TRUE)); ?>
                            </div>
                        </div>
                        <?php echo $form->textAreaRow($model,'keterangan_persediaan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                    </div>
                    <div class="col-sm-6">
                        <?php if(Yii::app()->user->getState('ispenerimaanlangsung') == true){ ?>        
                        <div class="control-group">
                            <?php echo CHtml::label("Jenis PPh", "", array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->dropDownList($model,'pajak_id', CHtml::listData(PajakM::model()->findAll('pajak_aktif = true AND  ispajakpegawai = false order by pajak_nama ASC'), 'pajak_id', 'pajak_nama'),
                                        array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'empty'=>'-- Pilih --',)); 
                                ?>
                            </div>
                        </div>
                        <?php } ?>
                        <div class="control-group ">
                            <?php echo CHtml::activeLabel($modUangMuka, 'tgluangmukabeli', array('class'=>'control-label','label'=>'Tgl. Pembayaran Uang Muka')) ?>
                            <div class="controls">
                                <?php
                                echo CHtml::activeTextField($modUangMuka,'tgluangmukabeli', array('readonly'=>TRUE, 'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);"));
                                ?>
                            </div>
                        </div>
                         <div class="control-group ">
                            <?php echo CHtml::activeLabel($modUangMuka, 'jumlahuang', array('class'=>'control-label','label'=>'Jumlah Uang Muka')) ?>
                            <div class="controls">
                                <?php
                                echo (Params::cekHiddenHargaGudangUmum()==true)?CHtml::activeTextField($modUangMuka, 'jumlahuang', array('class'=>'span3 integer-decimal','readonly'=>true, 'style'=>'text-align: right;')):CHtml::activePasswordField($modUangMuka, 'jumlahuang', array('class'=>'span3 integer-decimal','readonly'=>true, 'style'=>'text-align: right;'));
                                ?>
                            </div>
                        </div>
                        <?php echo (Params::cekHiddenHargaGudangUmum()==true)?$form->textFieldRow($model,'totalharga',array('class'=>'span3 integer-decimal', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'readonly'=>true, 'style'=>'text-align: right;')):$form->passwordFieldRow($model,'totalharga',array('class'=>'span3 integer-decimal', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'readonly'=>true, 'style'=>'text-align: right;')); ?>
                        <div class="control-group ">
                            <?php echo CHtml::label('Total Keringanan <span class="required">*</span>', 'discount', array('class' => 'control-label required')) ?>
                            <div class="controls">
                                    <?php echo Chtml::hiddenField('discountpersen', '0', array('class' => 'span1 float2', 'onblur'=>'setTotalHarga();', 'style'=>'text-align: right;')); ?> <!--% = -->
                                    <?php echo (Params::cekHiddenHargaGudangUmum()==true)?$form->textField($model, 'discount', array('readonly' => true, 'class' => 'span3 integer-decimal', 'onkeypress' => "return $(this).focusNextInputField(event);", 'style'=>'text-align: right;')) : $form->passwordField($model, 'discount', array('readonly' => true, 'class' => 'span3 integer-decimal', 'onkeypress' => "return $(this).focusNextInputField(event);", 'style'=>'text-align: right;')); ?>
                                    <?php echo $form->error($model, 'discount'); ?>
                            </div>
                        </div>
                        <div class="control-group ">
                            <label class="control-label">
                                    Total PPN
                            </label>
                            <div class="controls">
                                <?php echo (Params::cekHiddenHargaGudangUmum()==true)? $form->textField($model,'pajakppn',array('class'=>'span3 integer-decimal', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'style'=>'text-align: right;', 'readonly' => true)) : $form->passwordField($model,'pajakppn',array('class'=>'span3 integer-decimal', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'style'=>'text-align: right;', 'readonly' => true)); ?>
                            </div>
                        </div>
                        <div class="control-group ">
                            <label class="control-label">
                                    Total PPh
                            </label>
                            <div class="controls">
                                <?php echo Chtml::hiddenField('persenpajakppn', '0', array('class' => 'span1 integer2', 'onblur'=>'setPajakPph(this.value);', 'style'=>'text-align: right;')); ?> <!-- % = -->
                                <?php echo (Params::cekHiddenHargaGudangUmum()==true)? $form->textField($model,'pajakpph',array('class'=>'span3 integer-decimal', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'style'=>'text-align: right;', 'readonly' => true)) : $form->passwordField($model,'pajakpph',array('class'=>'span3 integer-decimal', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'style'=>'text-align: right;', 'readonly' => true)); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo Chtml::label("Total Keseluruhan",'totalkeseluruhan', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo (Params::cekHiddenHargaGudangUmum()==true)? $form->textField($model,'totalkeseluruhan',array('class'=>'span3 integer-decimal text-right', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100, 'readonly' => true)):$form->passwordField($model,'totalkeseluruhan',array('class'=>'span3 integer-decimal text-right', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100, 'readonly' => true)); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-success panel-shadow">
            <div class="panel-heading">
                <div class="panel-title">Penerimaan Barang</div>
            </div>
             <div class="panel-body">
                    <?php if (isset($modDetails)){
                            echo $form->errorSummary($modDetails);
                    } ?>
                    <?php
                    // if (empty($modBeli->pembelianbarang_id)){
                        if(Yii::app()->user->getState('ispenerimaanlangsung') == true){
                            $this->renderPartial('_formDetailBarang', array('model'=>$model, 'form'=>$form));
                        }
                    // }
                    ?>
                    <?php $this->renderPartial('_tableDetailBarang', array('model'=>$model, 'form'=>$form, 'modDetails'=>$modDetails, 'modDetailBeli'=>$modDetailBeli, 'modBeli'=>$modBeli)); ?>
            </div>
        </div>
        <?php if(Yii::app()->user->getState('isfakturdigudang') == true){ ?>
        <?php echo $form->hiddenField($model, 'is_langsungfaktur', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
        <?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
            'id'=>'form-fakturpembelian',
            'content'=>array(
                'content-fakturpembelian'=>array(
                    'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onclick'=>'','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk tampilkan form Faktur Pembelian')).'<b> Faktur Pembelian</b>',
                    'isi'=>$this->renderPartial('_formFakturPembelian',array(
                        'form'=>$form,
                        'model'=>$model,
                    ),true),
                    'active'=>$model->is_langsungfaktur,
                ),   
            ),
        )); ?>
        <?php } ?>                    

        <div class="form-actions">
            <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) :
                    Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                    array('class'=>'btn btn-primary', 'type'=>'submit', 'disabled'=>!$model->isNewRecord)); ?>
            <?php echo CHtml::link(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),
                    $this->createUrl($this->module->id.'/Index'),
                    array('class'=>'btn btn-danger',
                    'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = "'.$this->createUrl('Index').'";} ); return false;'));  ?>
            <?php
                if(isset($_GET['sukses'])){
                        echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('PRINT')",'disabled'=>false));
                }else{
                        echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','disabled'=>true));
                }
            ?>
            <?php
                $content = $this->renderPartial('../tips/transaksi_penerimaan_persediaan',array(),true);
                $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
            ?>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>

<?php
//========= Dialog buat cari Bahan Diet =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPegawai',
    'options' => array(
        'title' => 'Daftar Pegawai',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 600,
        'resizable' => false,
    ),
));

$modPegawai = new GUPegawaiM('search');
$modPegawai->unsetAttributes();
//$modPegawai->ruangan_id = 0;
if (isset($_GET['GUPegawaiM']))
    $modPegawai->attributes = $_GET['GUPegawaiM'];

$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'pegawai-m-grid',
    'dataProvider'=>$modPegawai->searchDialog(),
    'filter'=>$modPegawai,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small",
                                    "id" => "selectBahan",
                                    "onClick" => "
                                    $(\"#GUTerimapersediaanT_peg_penerima_id\").val($data->pegawai_id);
                                    $(\"#GUTerimapersediaanT_peg_penerima_nama\").val(\"$data->nama_pegawai\");
                                    $(\'#dialogPegawai\').dialog(\'close\');
                                    return false;"))',
        ),
        ////'pegawai_id',
            array(
                'name' => 'nama_pegawai',
                'filter' => Chtml::activeTextField($modPegawai, 'nama_pegawai', array('class' => 'numbers-only'))
            ),
            array(
                'name' => 'nomorindukpegawai',
                'filter' => Chtml::activeTextField($modPegawai, 'nomorindukpegawai', array('class' => 'hurufs-only'))
            ),
            array(
                'header' => 'Jabatan',
                'name' => 'jabatan_id',
                'value' => function($data){
                        $j = JabatanM::model()->findByPk($data->jabatan_id);

                        if (!empty($j)){
                            return $j->jabatan_nama;
                        }else{
                            return '-';
                        }
                }
            ),
           // 'alamat_pegawai',
        // 'agama',
            //array(
            //    'name'=>'jeniskelamin',
             ////   'filter'=> CHtml::dropDownList('GUPegawaiM[jeniskelamin]',$modPegawai->jeniskelamin,LookupM::getItems('jeniskelamin'),array('empty'=>'--Pilih--')),
              //  'value'=>'$data->jeniskelamin',
              //  ),
    ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
?>

<?php
//========= Dialog buat cari Bahan Diet =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPegawaiMengetahui',
    'options' => array(
        'title' => 'Daftar Pegawai',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 600,
        'resizable' => false,
    ),
));

$modPegawai = new GUPegawaiRuanganV('search');
$modPegawai->unsetAttributes();
$modPegawai->ruangan_id = Yii::app()->user->getState('ruangan_id');
if (isset($_GET['GUPegawaiRuanganV']))
    $modPegawai->attributes = $_GET['GUPegawaiRuanganV'];

$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'pegawaimengetahui-m-grid',
    'dataProvider'=>$modPegawai->searchDialog(),
    'filter'=>$modPegawai,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small",
                                    "id" => "selectBahan",
                                    "onClick" => "
                                    $(\"#GUTerimapersediaanT_peg_mengetahui_id\").val($data->pegawai_id);
                                    $(\"#GUTerimapersediaanT_peg_mengetahui_nama\").val(\"$data->nama_pegawai\");
                                    $(\'#dialogPegawaiMengetahui\').dialog(\'close\');
                                    return false;"))',
        ),
        array(
            'header' => 'NIP',
           'name' => 'nomorindukpegawai',
           'filter' => Chtml::activeTextField($modPegawai, 'nomorindukpegawai', array('class' => 'numbers-only'))
       ),
        array(

           'name' => 'nama_pegawai',
           'filter' => Chtml::activeTextField($modPegawai, 'nama_pegawai', array('class' => 'hurufs-only'))
       ),
       array(
           'header' => 'Jabatan',
           'name' => 'jabatan_id',
           'value' => function($data){
                   $j = JabatanM::model()->findByPk($data->jabatan_id);

                   if (!empty($j)){
                       return $j->jabatan_nama;
                   }else{
                       return '-';
                   }
           },
           'filter' => Chtml::activeDropDownList($modPegawai, 'jabatan_id', Chtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --'))
       ),
    ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});'
                   . '$(".numbers-only").keyup(function(){'
                   . 'setNumbersOnly(this);'
                   . '});'
                   . '$(".hurufs-only").keyup(function(){'
                   . 'setHurufsOnly(this);'
                   . '});'
                   . '}',
));

$this->endWidget();
?>


<?php
//========= Dialog buat cari data Pegawai Menyetujui =========================
// if(Yii::app()->user->getState('ispenerimaanlangsung') == true){
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
        'id'=>'dialogSupplier',
        'options'=>array(
            'title'=>'Pencarian Supplier',
            'autoOpen'=>false,
            'modal'=>true,
            'width'=>900,
            'height'=>600,
            'resizable'=>false,
        ),
    ));

    $modSupplier = new SupplierM('searchDialog');
    $modSupplier->unsetAttributes();
    $modSupplier->supplier_jenis = Params::SUPPLIER_JENIS_UMUM;

    if(isset($_GET['GFSupplierM'])) {
        $modSupplier->attributes = $_GET['GFSupplierM'];
    }
    $this->widget('ext.bootstrap.widgets.BootGridView',array(
        'id'=>'supplier-grid',
        'dataProvider'=>$modSupplier->searchDialog(),
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
                                                    $(\"#'.CHtml::activeId($model,'supplier_nama').'\").val(\"$data->supplier_nama\");
                                                        refreshDialog();
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
                        'value'=>'$data->supplier_alamat',
                        'filter'=>Chtml::activeTextField($modSupplier, 'supplier_alamat'),
                    ),
                ),
                'afterAjaxUpdate' => 'function(id, data){
                    jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"}); }',
            ));
    $this->endWidget();
// }
//========= end Pegawai Menyetujui dialog =============================
?>


<?php
$urlAjax = $this->createUrl('getPenerimaanPersediaanBarang');
$notif = Yii::t('mds','Do You want to cancel?');
$totalharga = CHtml::activeId($model, 'totalharga');
$discount = CHtml::activeId($model, 'discount');
$pajakppn = CHtml::activeId($model, 'pajakppn');
$pajakpph = CHtml::activeId($model, 'pajakpph');
$totalkeseluruhan = CHtml::activeId($model, 'totalkeseluruhan');
$totalhutangusaha = CHtml::activeId($model, 'totalhutangusaha');
$jlmuangmukabeli = CHtml::activeId($model, 'jlmuangmukabeli');

$js = <<< JS
    function inputBarang(){
        idBarang = $('#idBarang').val();
        jumlah =  parseFloat(unformatNumber($('#jumlah').val()));
        console.log('= '+jumlah);
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
                    rename();
                    $("#tableDetailBarang tbody tr:last .integer2").maskMoney({"defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":0,"symbol":null});
                    clear();
                    setTotalHarga();
                }, 'json');
            }
        }

    }

    function cekList(id){
        x = true;
        $('.barang').each(function(){
            if ($(this).val() == id){
                myAlert('Barang telah ada d List');
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
        myConfirm("${notif}",'Perhatian!',function(r){
            if(!r) {
                return false;
            }else{
                $(obj).parents('tr').remove();
                setTotalHarga();
                rename();
            }
        });
    }
    function rename(){
        noUrut = 1;
        $('.cancel').each(function(){
            $(this).parents('tr').find('[name*="TerimapersdetailT"]').each(function(){
                var nama = $(this).attr('name');
                data = nama.split('TerimapersdetailT[]');
                if (typeof data[1] === "undefined"){}else{
                    $(this).attr('name','TerimapersdetailT['+(noUrut-1)+']'+data[1]);
                }
            });
            noUrut++;
        });
    }


    function openDialog(obj){
        $('#dialogPegawai').attr('parentClick',obj);
        $('#dialogPegawai').dialog('open');
    }

    function setTotalHarga(){
        unformatNumberSemua();
//        var discountPersen = parseFloat(unformatNumber($('#discountpersen').val()));
        var totalHarga = 0;
        var totalDiskon = 0;
        var totalPajakPpn = 0;
        var totalPajakPph = 0;
        var totalHargaKeseluruhan = 0;

        $('#tableDetailBarang tbody tr').each(function(){
            qty = parseFloat($(this).find('.qty').val());
            satuan =  parseFloat($(this).find('.satuan').val());
            persendiscount =  parseFloat($(this).find('.persendiscount').val());
            persenppn =  parseFloat($(this).find('.persenppn').val());
            persenpph =  parseFloat($(this).find('.persenpph').val());

            var jmlQtySatuan = (qty*satuan);
            if (jmlQtySatuan > 0){
                // jmlQtySatuan = parseFloat(jmlQtySatuan.toFixed(2));
                jmlQtySatuan = (jmlQtySatuan * 100).toFixed(0) / 100;
            }

            var jmldiskon = ((jmlQtySatuan * persendiscount)/100);
            if (jmldiskon > 0){
                // jmldiskon = parseFloat(jmldiskon.toFixed(2));
                jmldiskon = (jmldiskon * 100).toFixed(0) / 100;
            }
            var jmlppn = (((jmlQtySatuan - jmldiskon)*persenppn)/100);
            if (jmlppn > 0){
                // jmlppn = parseFloat(jmlppn.toFixed(2));
                jmlppn = (jmlppn * 100).toFixed(0) / 100;
            }

            var jmlpph = (((jmlQtySatuan - jmldiskon)*persenpph)/100);
            if (jmlpph > 0){
                // jmlpph = parseFloat(jmlpph.toFixed(2));
                jmlpph = (jmlpph * 100).toFixed(0) / 100;
            }
            var subtotal = (jmlQtySatuan - jmldiskon + jmlppn - jmlpph);
            if (subtotal > 0){
                // subtotal = parseFloat(subtotal.toFixed(2));
                subtotal = (subtotal * 100).toFixed(0) / 100;
            }

            $(this).find('.hargabeli').val(subtotal);
            $(this).find('.jmldiscount').val(jmldiskon);
            $(this).find('.jmlppn').val(jmlppn);
            $(this).find('.jmlpph').val(jmlpph);

            totalDiskon += jmldiskon;
            totalPajakPpn += jmlppn;
            totalPajakPph += jmlpph;
            totalHargaKeseluruhan += subtotal;
            totalHarga += satuan;
        });

        $('#totalAll').val(totalHargaKeseluruhan);
        $('#${totalharga}').val(totalHarga);
//        if(jQuery.isNumeric(totalDiskon)){
            $('#${discount}').val(totalDiskon);
//        }
//         if(jQuery.isNumeric(totalPajakPpn)){
            $('#${pajakppn}').val(totalPajakPpn);
//        }
//            if(jQuery.isNumeric(totalPajakPph)){
            $('#${pajakpph}').val(totalPajakPph);
//        }
//            if(jQuery.isNumeric(totalHargaKeseluruhan)){
            $('#${totalkeseluruhan}').val(totalHargaKeseluruhan);
//        }

    var jmluangmuka = parseFloat($('#${jlmuangmukabeli}').val());

    $('#Faktupembelian_totalharga').val(totalHarga);
    $('#Faktupembelian_discount').val(totalDiskon);
    $('#Faktupembelian_pajakppn').val(totalPajakPpn);
    $('#Faktupembelian_pajakpph').val(totalPajakPph);
    $('#Faktupembelian_totalkeseluruhan').val(totalHargaKeseluruhan);
    var totalusaha = (totalHargaKeseluruhan - jmluangmuka);
    if (totalusaha > 0){
        totalusaha = ((totalusaha * 100).toFixed(0) / 100);
    }
    $('#${totalhutangusaha}').val(totalusaha);

            formatNumberSemua();
    }

JS;
Yii::app()->clientScript->registerScript('onhead',$js,  CClientScript::POS_END);
?>

<?php
Yii::app()->clientScript->registerScript('onready','
    setTotalHarga();
   
',CClientScript::POS_READY);?>

<?php $urlPembelian = $this->createUrl('loadBarang'); ?>
<?php

$urlPrint = $this->createUrl("print");
$printid = $model->terimapersediaan_id;

$jsprint = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}&id=${printid}&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$jsprint,CClientScript::POS_HEAD);
?>
<script>
 function prosesSimpan(obj){
    var qty = false;
    var idPenerima = $("#<?php echo CHtml::activeId($model, 'peg_penerima_id') ?>").val();
    var sumberdana = $("#<?php echo CHtml::activeId($model, 'sumberdana_id'); ?>").val();
    var ruangPenerima = $("#<?php echo CHtml::activeId($model, 'ruanganpenerima_id'); ?>").val();

    $("#tableDetailBarang tbody tr").each(function(){
        if (parseFloat($(this).find(".qty").val()) > 0){
            qty = true
        }
    });

    if(!jQuery.isNumeric(sumberdana)){
        myAlert("<?php echo CHtml::encode($model->getAttributeLabel('sumberdana_id')); ?> harus diisi");
        return false;
    }
    else if (!jQuery.isNumeric(idPenerima)){
        myAlert("<?php echo CHtml::encode($model->getAttributeLabel('peg_penerima_id')); ?> harus diisi");
        return false;
    }
    else if (!jQuery.isNumeric(ruangPenerima)){
        myAlert("<?php echo CHtml::encode($model->getAttributeLabel('ruanganpenerima_id')); ?> harus diisi");
        return false;
    }

    if ($(".cancel").length < 1){
        myAlert("Detail Barang Harus Diisi");
        return false;
    }
    else if (qty == false){
        myAlert("<?php echo CHtml::encode($model->getAttributeLabel('jml_beli')); ?> harus memiliki value yang lebih dari 0");
        return false;
    }

    if (requiredCheck($(obj))) {
        var index = 0;
        var pesanharga = "";
        var kecilHpp = 0;
        var cekpph = 0;
        $('#tableDetailBarang tbody tr').each(function() {
            unformatNumberSemua();
            var hargaLama = parseFloat($(this).find('input[name$="[hargasatuanmaster]"]').val());
            var hargabaru = parseFloat($(this).find('input[name$="[hargasatuan]"]').val());
            var namaBahan = $(this).find('input[name$="[namabarangmaster]"]').val();
            var persenpph = parseFloat($(this).find('input[name$="[persenpph]"]').val());
            if (hargaLama != hargabaru) {
                kecilHpp += 1;
                if (index > 0) {
                    pesanharga += ",";
                }
                pesanharga += namaBahan + " (" + hargabaru + ")";
                index++;
            } else {
                if (kecilHpp > 1) {
                    kecilHpp -= 1;
                }
            }
            if (persenpph > 0) {
                cekpph += 1;
            } else {
                if (cekpph > 1) {
                    cekpph -= 1;
                }
            }
            $(this).find('input[name$="[hppcheck]"]').val(0);
            formatNumberSemua();
        });
        <?php if(Yii::app()->user->getState('ispenerimaanlangsung') == true){ ?>
        if (cekpph > 0) {
            if ($('#<?php echo CHtml::activeId($model, 'pajak_id'); ?>').val() == '') {
                myAlert("Jenis Pajak harus diisi ");
                return false;
            }
        }
        <?php } ?>
        <?php if(Yii::app()->user->getState('isfakturdigudang') == true){ ?>
            if (kecilHpp > 0) {
                myConfirm("Harga Netto '" + pesanharga + "' berbeda dengan yang ada di master. Apakah Anda ingin melakukan update harga otomatis?", "Perhatian!", function(r) {
                    if (r) {
                        $('#tableDetailBarang tbody tr').each(function() {
                            $(this).find('input[name$="[hppcheck]"]').val(1);
                        });
                        $('.integer-decimal, .float2, .integer2').each(function() {
                            $(this).val(unformatNumber($(this).val()));
                        });
                    } else {
                        $('#tableDetailBarang tbody tr').each(function() {
                            $(this).find('input[name$="[hppcheck]"]').val(0);
                        });
                        $('.integer-decimal, .float2, .integer2').each(function() {
                            $(this).val(unformatNumber($(this).val()));
                        });
                    }
                });
            } else {
                $('#tableDetailBarang tbody tr').each(function() {
                    $(this).find('input[name$="[hppcheck]"]').val(0);
                });
                $('.integer-decimal, .float2, .integer2').each(function() {
                    $(this).val(unformatNumber($(this).val()));
                });
            }
        <?php }else{ ?>
        $('#tableDetailBarang tbody tr').each(function() {
            $(this).find('input[name$="[hppcheck]"]').val(0);
        });

        $(".integer-decimal, .integer2, float2").each(function(){
            $(this).val(unformatNumber($(this).val()));
        });
    <?php } ?>
    }
 }   

function loadPembelian(id)
{
	$.post("<?php echo $urlPembelian; ?>", {
		id: id
	}, function(data) {
		$("#tableDetailBarang tbody").html(data.tab);
		rename();
        $("#tableDetailBarang tbody .integer2").maskMoney({"defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":0,"symbol":null});
        clear();
        setTotalHarga();
       // totPPN($("#GUTerimapersediaanT_totalharga"));
	}, "json");
}

function totPPN()
{
    if ($('#termasukPPN').is(":checked")){
        var total_harga = unformatNumber($("#GUTerimapersediaanT_totalharga").val());
		var discount = unformatNumber($("#GUTerimapersediaanT_discount").val());

		var totSementara = total_harga - discount;

        var ppn = (10/100) * totSementara;

        $("#GUTerimapersediaanT_pajakppn").val(formatNumber(ppn));
    }else{
        $("#GUTerimapersediaanT_pajakppn").val(formatNumber(0));
    }

    getTotalSeluruh();
}

function persenPpn(obj){
    if(obj.checked == true){
        $('#<?php echo CHtml::activeId($model,'pajakppn'); ?>').attr("readonly",true);
        $('#<?php echo CHtml::activeId($model,'pajakppn'); ?>').attr('checked',true);
        $('#termasukPPN').val(1);
    }else{
        $('#<?php echo CHtml::activeId($model,'pajakppn'); ?>').attr("readonly",true);
        $('#<?php echo CHtml::activeId($model,'pajakppn'); ?>').removeAttr('checked');
        $('#termasukPPN').val(0);
    }

    totPPN($("#GUTerimapersediaanT_pajakppn"));
}

function getTotalSeluruh()
{
    unformatNumberSemua();
    var totalharga = $("#GUTerimapersediaanT_totalharga").val();
    var diskon = $("#GUTerimapersediaanT_discount").val();
//    var biayaadmin = $("#GUTerimapersediaanT_biayaadministrasi").val();
    var pajakpph = $("#GUTerimapersediaanT_pajakpph").val();
    var pajakppn = $("#GUTerimapersediaanT_pajakppn").val();
//    var totalkeseluruhan = (parseInt(totalharga) - parseInt(diskon)) + parseInt(biayaadmin) + parseInt(pajakpph) + parseInt(pajakppn);
    var totalkeseluruhan = (parseInt(totalharga) - parseInt(diskon)) + parseInt(pajakpph) + parseInt(pajakppn);

    $("#GUTerimapersediaanT_totalkeseluruhan").val(totalkeseluruhan);
    formatNumberSemua();
}

function setPajakPph(obj){
   var totalharga = parseInt(unformatNumber($("#GUTerimapersediaanT_totalharga").val()));
   var discount = parseInt(unformatNumber($("#GUTerimapersediaanT_discount").val()));
   var totSementara = totalharga - discount;
    var pph = (obj/100) * totSementara;
   $("#GUTerimapersediaanT_pajakpph").val(formatNumber(pph));

   getTotalSeluruh();
}

function refreshDialog(){
    var supplier_id = $('#<?php echo CHtml::activeId($model,'supplier_id'); ?>').val();
    $.fn.yiiGridView.update('barang-m-grid', {
        data: {
            "BarangV[supplier_id]":supplier_id,			
        }
    });
}

function loadJatuhTempo()
{
    var tanggalfaktur = $('#<?php echo CHtml::activeId($model, 'tglfaktur'); ?>').val();
    var supplierid = $('#<?php echo CHtml::activeId($model, 'supplier_id'); ?>').val();
    if(tanggalfaktur != '' && supplierid != ''){
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('/keuangan/FakturPembelianGU/loadJatuhTempo'); ?>',
            data: {tgl_faktur: tanggalfaktur,supplier_id:supplierid},
            dataType: "json",
            success:function(data){
                $('#<?php echo CHtml::activeId($model, 'tgljatuhtempo'); ?>').val(data.value);
            },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
    }
    
}

$('#form-fakturpembelian > div > .accordion-heading').click(function(){
    var is_langsungfaktur = $("#<?php echo CHtml::activeId($model, "is_langsungfaktur"); ?>");
    if(is_langsungfaktur.val() > 0){ //hide
        is_langsungfaktur.val(0);
    }else{//show
        is_langsungfaktur.val(1);
        loadJatuhTempo();
    }
});

</script>
