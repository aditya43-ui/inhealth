<div class="white-container">
    <legend class="rim2">Transaksi Pengembalian <b>Dokumen Rekam Medis</b></legend>
    <?php
    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
        $('.search-form').toggle();
        return false;
    });
    $('.search-form form').submit(function(){
        $.fn.yiiGridView.update('rkpeminjamandokumenrm-v-grid', {
            data: $(this).serialize()
        });
        return false;
    });
    ");
    ?>
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
    <?php
    $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php // echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-accordion icon-white"></i>')),'#',array('class'=>'search-button btn')); ?>
    <div class="search-form">
		<fieldset class="box">
			<legend class="rim"><i class="entypo-search"></i> Pencarian</legend>
        <?php $this->renderPartial('_searchPengembalian',array(
            'model'=>$modPengiriman,
        )); ?>
		</fieldset>
    </div><!--search-form-->
    <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
        'id'=>'rkkembalirm-t-form',
        'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#',
    )); ?>
    <div class="block-tabel">
        <h6>Tabel Pengembalian <b>Dokumen Rekam Medis</b></h6>
        <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'rkpeminjamandokumenrm-v-grid',
            'dataProvider'=>$modPengiriman->searchPengiriman(),
                'template'=>"{summary}\n{items}\n{pager}",
                'itemsCssClass'=>'table table-striped table-condensed',
            'columns'=>array(
                array(
                    'header'=> 'Pilih',
                    'type'=>'raw',
                    'value'=>'
                                        CHtml::hiddenField(\'no_urut\', 0,array(\'id\'=>\'no_urut\',\'class\'=>\'no_urut\')).
                        CHtml::hiddenField(\'KembalirmT[0][dokrekammedis_id]\', $data->dokrekammedis_id).
                        CHtml::hiddenField(\'KembalirmT[0][pasien_id]\', $data->pasien_id).
                        CHtml::hiddenField(\'KembalirmT[0][pendaftaran_id]\', $data->pendaftaran_id).
                        CHtml::hiddenField(\'KembalirmT[0][ruangan_id]\', $data->ruangan_id).
                        CHtml::hiddenField(\'KembalirmT[0][peminjamanrm_id]\', $data->peminjamanrm_id).
                        CHtml::hiddenField(\'KembalirmT[0][pengirimanrm_id]\', $data->pengirimanrm_id).                
                        CHtml::checkBox(\'KembalirmT[0][cekList]\', \'true\', array(\'onclick\'=>\'setUrutan(this);setLengkap(this);\', \'class\'=>\'cekList\'));
                        ',
                ),
                array(
                    'header'=> 'Lokasi Rak',
                    'type'=>'raw',
                    'value'=>'
                        CHtml::dropDownList(\'KembalirmT[0][lokasirak_id]\', $data->lokasirak_id, CHtml::listData(LokasirakM::model()->findAll(\'lokasirak_aktif = true\'), \'lokasirak_id\', \'lokasirak_nama\'), array(\'empty\'=>\'-- Pilih\', \'class\'=>\'span1 lokasiRak\'));
                        ',
                ),
                array(
                    'header'=> 'Sub Rak',
                    'type'=>'raw',
                    'value'=>'
                        CHtml::dropDownList(\'KembalirmT[0][subrak_id]\', $data->subrak_id, CHtml::listData(SubrakM::model()->findAll(\'subrak_aktif = true\'), \'subrak_id\', \'subrak_nama\'), array(\'empty\'=>\'-- Pilih\', \'class\'=>\'span1 subRak\'));
                        ',
                ),
                array(
                    'header'=>'Warna Dokumen',
                    'type'=>'raw',
                    'value'=>'$this->grid->getOwner()->renderPartial(\'_warnaDokumen\', array(\'warnadokrm_id\'=>$data->warnadokrm_id), true)',
                ),
                'no_rekam_medik',
                'pendaftaran.tgl_pendaftaran',
                'no_pendaftaran',
                'nama_pasien',
                'tanggal_lahir',
                'jeniskelamin',
                'alamat_pasien',
                'instalasi_nama',
                'ruangan_nama',
                array(
                    'header'=>'Kelengkapan',
                    'type'=>'raw',
                    'value'=>'CHtml::checkBox(\'KembalirmT[0][kelengkapan]\', \'false\', array(\'class\'=>\'lengkap\'))',
					'htmlOptions'=>array('style'=>'text-align:center;'),
                ),
        //		array(
        //			'header'=>'Print',
        //			'value'=>'CHtml::checkBox("KembalirmT[0][print]", false, array("value"=>$data->dokrekammedis_id,"id"=>"print","class"=>"inputFormTabel currency span2","onkeypress"=>"return $(this).focusNextInputField(event)"))',
        //			'type'=>'raw',
        //		),
            ),
                'afterAjaxUpdate'=>'function(id, data){
                                var colors = jQuery(\'input[rel="colorPicker"]\').attr(\'colors\').split(\',\');
                                jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
                                jQuery(\'input[rel="colorPicker"]\').colorPicker({colors:colors});
                        }',
        )); ?>
    </div>
    <fieldset class="box">
        <legend class="rim">Pengembalian Dokumen Rekam Medis</legend>
            <div class="row">
                    <div class="col-sm-4">
                        <?php 
                            $model->tglkembali = MyFormatter::formatDateTimeForUser($model->tglkembali);
                            echo $form->textFieldRow($model,'tglkembali',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
                        ?>
                        <?php // echo $form->textFieldRow($model,'petugaspenerima',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>            
					<div class="control-group">
                    <?php echo CHtml::activeLabel($model, 'petugaspenerima', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $model,
                            'attribute' => 'petugaspenerima',
                            'value' => '',
                            'sourceUrl' => $this->createUrl('GetPetugasPenerima'),
                            'options' => array(
                                'showAnim' => 'fold',
                                'minLength' => 2,
                                'focus' => 'js:function( event, ui ) {
                                        $(this).val(ui.item.petugaspenerima);
                                        return false;
                                    }',
                                'select' => 'js:function( event, ui ) {
                                        $("#'.CHtml::activeId($model, 'petugaspenerima') . '").val(ui.item.nama_pegawai);
                                        return false; }',
                            ),
                            'htmlOptions'=>array(
                                'onkeypress'=>'return $(this).focusNextInputField(event)',
                                'disabled'=>($model->isNewRecord)?'':'disabled', 
                                'class'=>'span2', 
                            ),
                            'tombolDialog'=>array('idDialog'=>'dialogPetugasPenerima'),

                        ));
                        ?>
                    </div>
                </div>
				</div>
                    <div class="span8">
                        <?php echo $form->textAreaRow($model,'keterangan_pengembalian',array('rows'=>6, 'cols'=>50, 'class'=>'span5', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                    </div>
            </div>
            <div class="form-actions">
                <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="entypo-check"></i>')) : 
                    Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
                    array('class' => 'btn btn-danger', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
                <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                    $this->createUrl('index'), 
                    array('class' => 'btn btn-default',
                    'onclick'=>'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
                <?php 
                    $content = $this->renderPartial('../tips/transaksi',array(),true);
                    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); ?>	
            </div>
    </fieldset>
<?php $this->endWidget(); ?>
<!--======================== Begin Widget Dialog Petugas Penerima =============================-->
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPetugasPenerima',
    'options' => array(
        'title' => 'Petugas Penerima',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'height' => 400,
        'resizable' => false,
    ),
));
?>
<?php 
$modPetugasPenerima = new RKPegawaiV('searchDialog');
$modPetugasPenerima->unsetAttributes();
if(isset($_GET['RKPegawaiV'])) {
    $modPetugasPenerima->attributes = $_GET['RKPegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'petugaspenerima-grid',
	'dataProvider'=>$modPetugasPenerima->searchDialog(),
	'filter'=>$modPetugasPenerima,
	'template'=>"{items}\n{pager}",
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-check\"></i>","",array("class"=>"btn-small", 
                                    "href"=>"",
                                    "id" => "selectPetugasPenerima",
                                    "onClick" => "
                                                  $(\"#'.CHtml::activeId($model,'petugaspenerima').'\").val(\"$data->nama_pegawai\");
                                                  $(\"#dialogPetugasPenerima\").dialog(\"close\"); 
                                                  return false;
                                        "))',
                ),
                array(
                    'header'=>'NIP',
                    'filter'=>  CHtml::activeTextField($modPetugasPenerima, 'nomorindukpegawai'),
                    'value'=>'$data->nomorindukpegawai',
                ),
                array(
                    'header'=>'Nama Pegawai',
                    'filter'=>  CHtml::activeTextField($modPetugasPenerima, 'nama_pegawai'),
                    'value'=>'$data->nama_pegawai',
                ),
            ),
            'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        ));
$this->endWidget(); ?>
<!--=============================== endWidget Dialog Petugas Penerima ============================-->
<script>
    function setUrutan(obj){        
        $('.cekList').each(function(){
			if($(this).is(':checked')){
				$(this).attr('checked',true);
				$(this).val(1);
			}else{
				$(this).removeAttr('checked',true);
				$(this).val(0);
			}			
        });	
		renameInputRow();
    }
    
    function setLengkap(obj){
        noUrut = 0;
        $('.lengkap').each(function(){
			if($(this).is(':checked')){
				$(this).attr('checked',true);
				$(this).val(1);
			}else{
				$(this).removeAttr('checked',true);
				$(this).val(0);
			}
           noUrut++;
        });
    }
    
	function renameInputRow(){
		var row = 0;
		$('.no_urut').each(function(){
			$(this).parents('tr').find('[name*="KembalirmT"]').each(function(){
				var input = $(this).attr('name');
				var data = input.split('KembalirmT[0]');
				if (typeof data[1] === 'undefined'){} else{
					$(this).attr('name','KembalirmT['+row+']'+data[1]);
					$(this).attr('id','KembalirmT['+row+']'+data[1]);
				}
			});
			row++;
		});
	}
	
    $(document).ready(function(){		
        $('form#rkkembalirm-t-form').submit(function(){
            var jumlah = 0;
            var lokasiRak = 0;
            var subRak = 0;
            $('.cekList').each(function(){
                if ($(this).is(':checked')){
                    jumlah++;
                }
                if ($(this).parents('tr').find('.lokasiRak').val() != ''){
                    lokasiRak++;
                }
                if ($(this).parents('tr').find('.subRak').val() != ''){
                    subRak++;
                }
            });
            if (jumlah < 1){
                myAlert('Silakan pilih Dokumen yang akan dikirim!');
                return false;
            }
            else if (lokasiRak < 1){
                myAlert('Isi Lokasi Rak pada dokumen yang dipilih!');
                return false;
            }
            else if (subRak < 1){
                myAlert('Isi Sub Rak pada dokumen yang dipilih!');
                return false;
            }
        });
    });
	
	function PrintDokumen(obj){
     parent = $(obj).parents("tr");
      if ($("#print").is(":checked")) {
           var dokrekammedis_id = parent.find("#dokrekammedis_id").val();
           alert(dokrekammedis_id);
        }else{
        
        }
        
    }
	
	/**
	* untuk print dokumen rekam medis
	 */
	function print(id,caraPrint)
	{
		var id = id;
		window.open('<?php echo $this->createUrl('printDokumen'); ?>&dokrekammedis_id='+id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');		
	}
</script>
