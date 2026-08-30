<div class="white-container">
    <?php
    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php 
    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('rkdokumenpasienrmlama-v-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
    ?>
    <legend class="rim2">Transaksi Pinjam <b>Berkas RK</b></legend>
    <div class='hide'>
        <?php 
        $warnadokrm_id = 1;
        $this->widget('ext.colorpicker.ColorPicker', 
            array(
                'name'=>'Dokumen[warnadokrm_id][]',
                'value'=>WarnadokrmM::model()->getKodeWarnaId($warnadokrm_id),// string hexa decimal contoh 000000 atau 0000ff
                'height'=>'30px', // tinggi
                'width'=>'83px',        
                //'swatch'=>true, // default false jika ingin swatch
                'colors'=>  WarnadokrmM::model()->getKodeWarna(), //warna dalam bentuk array contoh array('0000ff','00ff00')
                'colorOptions'=>array(
                    'transparency'=> true,
                   ),
                )
            );
        ?>
    </div>
	<fieldset class="box">
		<legend class="rim"><i class="entypo-search"></i> Pencarian</legend>
	<div class="search-form">
    <?php $this->renderPartial('_searchDokumenRK',array(
        'model'=>$modDokumenPasienLama,'format'=>$format
    )); ?>
    </div><!--search-form-->
	</fieldset>
	<div class="block-tabel">
		<h6>Tabel Peminjaman<b> Dokumen Rekam Medis</b></h6>
    <?php $dokumen = CHtml::activeId($model, 'dokrekammedis_id'); ?>
    <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
        'id'=>'rkpeminjamanrm-t-form',
        'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#'.CHtml::activeId($model,'untukkepentingan'),
    )); ?>
    <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'rkdokumenpasienrmlama-v-grid',
    'dataProvider'=>$modDokumenPasienLama->searchPeminjaman(),
    //'filter'=>$model,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-condensed',
    'columns'=>array(
        array(
            'header'=> 'Pilih',
            'type'=>'raw',
            'value'=>'
                CHtml::hiddenField(\'Dokumen[dokrekammedis_id][]\', $data->dokrekammedis_id).
                CHtml::hiddenField(\'Dokumen[pasien_id][]\', $data->pasien_id).
                CHtml::hiddenField(\'Dokumen[pendaftaran_id][]\', $data->pendaftaran_id, array(\'class\'=>\'pendaftaran_id\')).
                CHtml::hiddenField(\'Dokumen[ruangan_id][]\', $data->ruangan_id).
                CHtml::checkBox(\'cekList[]\', \'true\', array(\'onclick\'=>\'setUrutan()\', \'class\'=>\'cekList\'));
                ',
        ),
        'lokasirak_nama',
        //'nodokumenrm',
        array(
            'header'=>'Nama Sub Rak',
            'value'=>'$data->subrak_nama',
        ),
//        'subrak_nama',
        //'warnadokrm_namawarna',
        array(
            'header'=>'Warna Dokumen',
            'type'=>'raw',
            'value'=>'$this->grid->getOwner()->renderPartial(\'_warnaDokumen\', array(\'warnadokrm_id\'=>$data->warnadokrm_id), true)',
        ),
        'no_rekam_medik',
		array(
			'header'=>'Tanggal Pendaftaran',
			'value'=>'$data->tgl_pendaftaran',
		),
        'no_pendaftaran',
        'nama_pasien',
        'tanggal_lahir',
        'jeniskelamin',
        'alamat_pasien',
        array(
            'header'=>'Nama Instalasi',
            'value'=>'$data->instalasi_nama',
        ),
//        'instalasi_nama',
        array(
            'header'=>'Nama Ruangan',
            'value'=>'$data->ruangan_nama',
        ),
        array(
            'header'=>'Print',
            'class'=>'CCheckBoxColumn',     
            'selectableRows'=>0,
            'id'=>'rows',
            'checked'=>'$data->printpeminjaman',
        ),
    ),
        'afterAjaxUpdate'=>'function(id, data){
                        var colors = jQuery(\'input[rel="colorPicker"]\').attr(\'colors\').split(\',\');
                        jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
                        jQuery(\'input[rel="colorPicker"]\').colorPicker({colors:colors});
                }',
    )); ?>
	</div>
    <fieldset class="box">
        <legend class="rim">Peminjaman Dokumen Rekam Medis</legend>
        <table style="width: 100%; border: none;">
            <tr>
                <td>
                    <!--<!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>-->-->
                    <?php echo $form->errorSummary($model); ?>

                        <?php //echo $form->textFieldRow($model,'pengirimanrm_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                        <?php //echo $form->textFieldRow($model,'dokrekammedis_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                        <?php //echo $form->textFieldRow($model,'pasien_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                        <?php //echo $form->textFieldRow($model,'pendaftaran_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                        <?php //echo $form->textFieldRow($model,'kembalirm_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                        <?php //echo $form->textFieldRow($model,'ruangan_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                        <?php // echo $form->textFieldRow($model,'nourut_pinjam',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>5)); ?>
                        <?php //echo $form->textFieldRow($model,'tglpeminjamanrm',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'tglpeminjamanrm', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $model,
                                    'attribute' => 'tglpeminjamanrm',
                                    'mode' => 'datetime',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                    ),
                                    'htmlOptions' => array('readonly' => true, 'class' => 'span3 dtPicker3'),
                                ));
                                ?>
                            </div>
                        </div>
                        <?php echo $form->textFieldRow($model,'untukkepentingan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                        <?php //echo CHtml::activeHiddenField($model,'printArray'); ?>
                        <?php //echo $form->textFieldRow($model,'tglakandikembalikan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
						<div class="control-group">
						<?php echo CHtml::activeLabel($model, 'namapeminjam', array('class' => 'control-label')); ?>
							<div class="controls">
								<?php
								$this->widget('MyJuiAutoComplete', array(
									'model' => $model,
									'attribute' => 'namapeminjam',
									'value' => '',
									'sourceUrl' => $this->createUrl('GetNamaPeminjam'),
									'options' => array(
										'showAnim' => 'fold',
										'minLength' => 2,
										'focus' => 'js:function( event, ui ) {
												$(this).val(ui.item.namapeminjam);
												return false;
											}',
										'select' => 'js:function( event, ui ) {
												$("#'.CHtml::activeId($model, 'namapeminjam') . '").val(ui.item.nama_pegawai);
												return false; }',
									),
									'htmlOptions'=>array(
										'onkeypress'=>'return $(this).focusNextInputField(event)',
										'disabled'=>($model->isNewRecord)?'':'disabled', 
									),
									'tombolDialog'=>array('idDialog'=>'dialogNamaPeminjam'),
								));
								?>
							</div>
						</div>
						<?php //echo $form->checkBoxRow($model,'printpeminjaman', array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                        <?php //echo $form->textFieldRow($model,'create_time',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                        <?php //echo $form->textFieldRow($model,'update_time',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                        <?php //echo $form->textFieldRow($model,'create_loginpemakai_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                        <?php //echo $form->textFieldRow($model,'update_loginpemakai_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                        <?php //echo $form->textFieldRow($model,'create_ruangan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                </td>
                <td>
                    <?php echo $form->textAreaRow($model,'keteranganpeminjaman',array('rows'=>6, 'cols'=>50, 'class'=>'span5', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                </td>
            </tr>
        </table>
                
                <div class="form-actions">
                        <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')) : 
                                                             Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
                                        array('class' => 'btn btn-danger', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>

                    <?php echo CHtml::link(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                                    $this->createUrl($this->id.'/index'), 
                                    array('class' => 'btn btn-default',
                                        'onclick'=>'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = "'.$this->createUrl('index').'";} ); return false;')); ?>
                         <?php if((!$model->isNewRecord) AND ((Yii::app()->user->getState('printkartulsng')==TRUE) OR (Yii::app()->user->getState('printkartulsng')==TRUE))) 
                            {  
                    ?>
                                <script>
                                    print(<?php echo $model->pendaftaran_id ?>);
                                </script>
                     <?php //echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="entypo-print"></i>')), '#', array('class'=>'btn btn-info','onclick'=>"print('$model->pendaftaran_id');return false",'disabled'=>FALSE  )); 
                           }else{
                            //echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="entypo-print"></i>')), '#', array('class'=>'btn btn-info','disabled'=>TRUE  )); 
                           } 
                    ?>
               <?php $this->endWidget(); ?>
            
							<?php 
$content = $this->renderPartial('../tips/transaksi',array(),true);
$this->widget('UserTips',array('type'=>'create','content'=>$content));?>   
			
			<?php 
      $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
       $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');

$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#rkdokumenpasienrmlama-v-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
?>
</div> 
</fieldset>
</div>
<!--======================== Begin Widget Dialog Nama Peminjam =============================-->
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogNamaPeminjam',
    'options' => array(
        'title' => 'Peminjam Dokumen',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'height' => 400,
        'resizable' => false,
    ),
));
?>
<?php 
$modPeminjam = new RKPegawaiV('searchDialog');
$modPeminjam->unsetAttributes();
if(isset($_GET['RKPegawaiV'])) {
    $modPeminjam->attributes = $_GET['RKPegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'namapeminjam-grid',
	'dataProvider'=>$modPeminjam->searchDialog(),
	'filter'=>$modPeminjam,
	'template'=>"{items}\n{pager}",
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-check\"></i>","",array("class"=>"btn-small", 
                                    "href"=>"",
                                    "id" => "selectNamaPeminjam",
                                    "onClick" => "
                                                  $(\"#'.CHtml::activeId($model,'namapeminjam').'\").val(\"$data->nama_pegawai\");
                                                  $(\"#dialogNamaPeminjam\").dialog(\"close\"); 
                                                  return false;
                                        "))',
                ),
                array(
                    'header'=>'NIP',
                    'filter'=>  CHtml::activeTextField($modPeminjam, 'nomorindukpegawai'),
                    'value'=>'$data->nomorindukpegawai',
                ),
                array(
                    'header'=>'Nama Pegawai',
                    'filter'=>  CHtml::activeTextField($modPeminjam, 'nama_pegawai'),
                    'value'=>'$data->nama_pegawai',
                ),
            ),
            'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        ));
$this->endWidget(); ?>
<!--=============================== endWidget Dialog Nama Peminjam ============================-->
<script>
    function setUrutan(){
        noUrut = 0;
        $('.cekList').each(function(){
            
           $(this).attr('name','cekList['+noUrut+']');
           
           noUrut++;
        });
    }
    
    $(document).ready(function(){
        $('form#rkpeminjamanrm-t-form').submit(function(){
            var jumlah = 0;
            $('.cekList').each(function(){
                if ($(this).is(':checked')){
                    jumlah++;
                }
            });
            if (jumlah < 1){
                myAlert('Silakan pilih Dokumen yang akan dikirim!');
                return false;
            }
        });
    });
</script>

<?php 
$printArray = CHtml::activeId($modDokumenPasienLama,'printArray');
$printArray2 = CHtml::activeId($model,'printArray');
$js = <<< JS
    function cekPrint(){
            var jumlah = 0;
            var isiPrint = '';
            $('.cekList').each(function(){
                if ($(this).is(':checked')){
                    
                    var pendaftaran_id = $(this).parents('tr').find('.pendaftaran_id').val();
                    if (isiPrint == ''){
                        isiPrint = pendaftaran_id;
                    }else{
                        isiPrint += ','+pendaftaran_id;
                    }
                    jumlah++;
                }
            });
            $('#${printArray}').val(isiPrint);
            $('#${printArray2}').val(isiPrint);
            if (jumlah < 1){
                myAlert('Silakan pilih Dokumen yang akan dikirim!');
                return false;
            }else{
                print('PRINT');
            }
    }
JS;
 Yii::app()->clientScript->registerScript('cekPrint', $js, CClientScript::POS_HEAD);
?>