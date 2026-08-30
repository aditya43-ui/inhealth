<div class="white-container">
    <legend class="rim2">Transaksi <b>Visite Dokter</b></legend>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
    <?php 
    Yii::app()->clientScript->registerScript('search', "
    $('.search-form form').submit(function(){
        $('#daftarPasien-grid').addClass('animation-loading');
        $.fn.yiiGridView.update('daftarPasien-grid', {
            data: $(this).serialize()
        });
        return false;
    });
    "); ?>
    <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'id'=>'pasienVisite-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'focus'=>'#namaDokter',
            'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
    )); 
    $this->widget('bootstrap.widgets.BootAlert'); ?>
    <!--<legend class="rim">Berdasarkan tanggal</legend>-->
    <div class="row">
        <div class="search-form">
            <table style="width: 100%; border: none;">
                <tr>
                    <td>
                        <div class="control-group">
                            <div class="control-label">
                                    <?php echo CHtml::label('Tgl. Visite *','Tanggal Visite *', array()); ?>
                            </div>
                            <div class="controls">
                                    <?php   
                                            $this->widget('MyDateTimePicker',array(
                                                            'name'=>'tanggalVisite',
                                                            'value'=>Yii::app()->dateFormatter->formatDateTime(
                                                                    CDateTimeParser::parse(date('Y-m-d H:i:s'), 'yyyy-MM-dd hh:mm:ss')),
                                                            'mode'=>'datetime',
                                                            'options'=> array(
                                                                    'dateFormat'=>Params::DATE_FORMAT,
                                                                    'maxDate' => 'd',

                                                            ),
                                                            'htmlOptions'=>array('readonly'=>true,
                                                                    'onkeypress'=>"return $(this).focusNextInputField(event)",
                                                                    'class'=>'isRequired'
                                                                    ),
                                            ));
                                    ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="control-label">
                                    <?php echo CHtml::label('Jenis Visite','Jenis Visite', array()); ?>
                            </div>
                            <div class="controls">
                                    <?php $this->widget('MyJuiAutoComplete',array(
                            'name'=>'jenisVisite',    
                            'value'=>'',
                            'sourceUrl'=> $this->createUrl('GetDaftarTindakanVisite'),
                            'options'=>array(
                               'showAnim'=>'fold',
                               'minLength' => 2,
                               'focus'=> 'js:function( event, ui ) {
                                    $(this).val( ui.item.label);

                                    return false;
                                }',
                                'select'=>'js:function( event, ui ) {
                                 samakanVisite(ui.item.daftartindakan_id);
                                          }'

                            ),
                            'htmlOptions'=>array('onkeypress'=>"return $(this).focusNextInputField(event)"),
                            )); ?>
                            </div>
                        </div>
                    </td>
                    <td>
                        <?php
                        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                            'action' => Yii::app()->createUrl($this->route),
                            'method' => 'get',
                            'id' => 'pencarian-form',
                            'type' => 'horizontal',
                            ));
                        ?>
                        <div class="control-group">
                            <div class="control-label">
                                    <?php echo CHtml::label('Dokter Visite','Nama Dokter', array()); ?>
                            </div>
                            <div class="controls">
                                <?php $this->widget('MyJuiAutoComplete',array(
                                'name'=>'namaDokter',    
                                'value'=>'',
                                'sourceUrl'=> Yii::app()->createUrl('ActionAutoComplete/GetDokterJenisKelamin'),
                                'options'=>array(
                                   'showAnim'=>'fold',
                                   'minLength' => 2,
                                   'focus'=> 'js:function( event, ui ) {
                                        $(this).val( ui.item.label);
                                        $("#'.CHtml::activeId($model,'nama_pegawai').'").val( ui.item.nama_pegawai);
                                        $("#'.CHtml::activeId($model,'pegawai_id').'").val( ui.item.pegawai_id);

                                        return false;
                                    }',
                                    'select'=>'js:function( event, ui ) {
                                     samakanDokter(ui.item.pegawai_id);

                                              }'

                                ),
                                'tombolDialog'=>array('idDialog'=>'dialogDokter'),
                                'htmlOptions'=>array('onkeypress'=>"return $(this).focusNextInputField(event)"),
                                )); ?>
                                <?php echo CHtml::activeHiddenField($model,'nama_pegawai',array('class'=>'span4')); ?>
                                <?php echo CHtml::activeHiddenField($model,'pegawai_id',array('class'=>'span4')); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class='controls'>
                                <?php echo CHtml::activeCheckBox($model,'is_dokter',array('onclick'=>'setDokter(this);','style'=>'width : 10px', 'onkeyup' => "return $(this).focusNextInputField(event)"))?>                
                                Dokter Penanggung Jawab
                          </label>
                        </div>
                    </td>
                    <td>
                        <div class="control-group">
                            <div class="control-label">No. Rekam Medik</div>
                            <div class="controls">				
                                    <?php echo CHtml::activeTextField($model,'no_rekam_medik',array('class'=>'span4','placeholder'=>'No. Rekam Medik')); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="control-label">Nama Pasien</div>
                            <div class="controls">
                                    <?php echo CHtml::activeTextField($model,'nama_pasien',array('class'=>'span4','placeholder'=>'Nama Pasien')); ?>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        <div class="form-actions">
	<?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-danger', 'type' => 'button','onclick'=>'pencarianForm();')); ?>
	<?php // echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')),array('class' => 'btn btn-default', 'type'=>'reset')); ?>
	</div>
	<?php $this->endWidget(); ?>
    </div>
    <div class="block-tabel">
        <h6>Tabel <b>Visite Dokter</b></h6>
        <?php
             $this->widget('ext.bootstrap.widgets.BootGridView', array(
                'id'=>'daftarPasien-grid',
                'dataProvider'=>$model->searchRIVisiteDokter(),
                'template'=>"\n{items}",
                'itemsCssClass'=>'table table-striped table-condensed',
                'columns'=>array(
                            array(
                               'header'=>'Tanggal Admisi / Masuk Kamar',
                                'type'=>'raw',
                                'value'=>'$data->tglAdmisiMasukKamar'
                            ),
        //                    'ruangan_nama',
        //                    array(
        //                       'name'=>'caramasuk_nama',
        //                        'type'=>'raw',
        //                        'value'=>'$data->caramasuk_nama',
        //                    ),
                            array(
                               'header'=>'No. Rekam Medik / No. Pendaftaran',
                                'type'=>'raw',
                                'value'=>'$data->noRmNoPend',
                            ),
                            array(
                                'header'=>'Nama Pasien / Alias',
                                'value'=>'$data->namaPasienNamaBin'
                            ),
                            array(
                                'name'=>'jeniskelamin',
                                'value'=>'$data->jeniskelamin',
                            ),
        //                    array(
        //                        'name'=>'umur',
        //                        'value'=>'$data->umur',
        //                    ),
        //                    array(
        //                       'name'=>'Dokter',
        //                        'type'=>'raw',
        //                        'value'=>'$data->nama_pegawai',
        //                    ),
                            array(
                                'header'=>'Jenis Penjamin / Penjamin',
                                'value'=>'$data->caraBayarPenjamin',
                            ),
                            array(
                               'name'=>'kelaspelayanan_nama',
                                'type'=>'raw',
                                'value'=>'$data->kelaspelayanan_nama',
                            ),
                            array(
                               'name'=>'jeniskasuspenyakit_nama',
                                'type'=>'raw',
                                'value'=>'$data->jeniskasuspenyakit_nama',
                            ),
                            array(
                                                        'header'=>'Dokter Penanggung Jawab',
                                                        'name'=>'nama_pegawai',
                                                        'type'=>'raw',
                                                        'value'=>'$data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang_nama',
                            ),
                        //dicomment RND-6891
        //                   array(
        //                        'header'=>'Dokter Visite*',
        //                        'type'=>'raw',
        //                        'value'=>'CHtml::dropDownList("RITindakanPelayananT[pegawai_id][]","",CHtml::listdata(DokterV::model()->findAll(\'ruangan_id='.Yii::app()->user->getState('ruangan_id').'\'),"pegawai_id","nama_pegawai"),array("style"=>"width:100px;font-size:11px;","empty"=>"- Pilih -","onkeypress"=>"return $(this).focusNextInputField(event)",
        //                                                       "class"=>"idDokter"))
        //                                                       .CHtml::hiddenField("RITindakanPelayananT[penjamin_id][]",$data->penjamin_id,array("readonly"=>TRUE,"class"=>"span1"))                                   
        //                                                       .CHtml::hiddenField("RITindakanPelayananT[pasienadmisi_id][]",$data->pasienadmisi_id,array("readonly"=>TRUE,"class"=>"span1"))
        //                                                       .CHtml::hiddenField("RITindakanPelayananT[kelaspelayanan_id][]",$data->kelaspelayanan_id,array("readonly"=>TRUE,"class"=>"span1"))
        //                                                       .CHtml::hiddenField("RITindakanPelayananT[pasien_id][]",$data->pasien_id,array("readonly"=>TRUE,"class"=>"span1"))                                   
        //                                                       .CHtml::hiddenField("RITindakanPelayananT[pendaftaran_id][]",$data->pendaftaran_id,array("readonly"=>TRUE,"class"=>"span1"))                                   
        //                                                       .CHtml::hiddenField("RITindakanPelayananT[carabayar_id][]",$data->carabayar_id,array("readonly"=>TRUE,"class"=>"span1"))                                   
        //                                                       .CHtml::hiddenField("RITindakanPelayananT[jeniskasuspenyakit_id][]",$data->jeniskasuspenyakit_id,array("readonly"=>TRUE,"class"=>"span1"))                                   
        //                        ',),
                            array(
                                'header'=>'Visite Dokter *',
                                'type'=>'raw',
                                'value'=>'CHtml::dropDownList("RITindakanPelayananT[daftartindakan_id][]","",CHtml::listdata(RIDaftarTindakanM::model()->findAll(\'daftartindakan_visite=TRUE\'),"daftartindakan_id","daftartindakan_nama"),array("style"=>"width:100px;font-size:11px;","empty"=>"- Pilih -","onkeypress"=>"return $(this).focusNextInputField(event)",
                                                               "class"=>"idVisite"))
                                                                                                                   .CHtml::hiddenField("RITindakanPelayananT[penjamin_id][]",$data->penjamin_id,array("readonly"=>TRUE,"class"=>"span1"))                                   
                                                               .CHtml::hiddenField("RITindakanPelayananT[pasienadmisi_id][]",$data->pasienadmisi_id,array("readonly"=>TRUE,"class"=>"span1"))
                                                               .CHtml::hiddenField("RITindakanPelayananT[kelaspelayanan_id][]",$data->kelaspelayanan_id,array("readonly"=>TRUE,"class"=>"span1"))
                                                               .CHtml::hiddenField("RITindakanPelayananT[pasien_id][]",$data->pasien_id,array("readonly"=>TRUE,"class"=>"span1"))                                   
                                                               .CHtml::hiddenField("RITindakanPelayananT[pendaftaran_id][]",$data->pendaftaran_id,array("readonly"=>TRUE,"class"=>"span1"))                                   
                                                               .CHtml::hiddenField("RITindakanPelayananT[carabayar_id][]",$data->carabayar_id,array("readonly"=>TRUE,"class"=>"span1"))                                   
                                                               .CHtml::hiddenField("RITindakanPelayananT[jeniskasuspenyakit_id][]",$data->jeniskasuspenyakit_id,array("readonly"=>TRUE,"class"=>"span1"))',),

                             array(
                               'header'=>'Pilih',
                               'type'=>'raw',
                               'value'=>'CHtml::checkBox("RITindakanPelayananT[ceklist][]",false,array("class"=>"ceklist","onclick"=>"dipilih(this)","onkeypress"=>"return $(this).focusNextInputField(event)"))
                                        .CHtml::hiddenField("RITindakanPelayananT[dipilih][]","Tidak",array("readonly"=>TRUE,"class"=>"span1 dipilih"))                                   
                                        ',
                            ),

                    ),
                'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
            ));

        ?>
    </div>
    <div class="form-actions">
        <div style="display: none;">
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
                            array('class' => 'btn btn-danger', 'type'=>'submit','id'=>'btn_simpan')); ?>
        </div>    
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
                        array('class' => 'btn btn-danger', 'type'=>'button','onclick'=>'validasi()')); ?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-cancel"></i>')), 
        Yii::app()->createUrl($this->module->id.'/TransaksiVisiteDokter/index'), 
        array('class' => 'btn btn-default',
        'onclick'=>'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
        <?php
        $content = $this->renderPartial('../tips/transaksi',array(),true);
        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
        ?>
    </div>
</div>
<?php
$this->endWidget();
//$js = <<< JS
//
//
//
//
//JS;
//Yii::app()->clientScript->registerScript('JSriwayatPasien',$js,CClientScript::POS_READY);
$urlCekTarifTindakan = Yii::app()->createUrl('rawatInap/TransaksiVisiteDokter/getTarifTindakan');
$js = <<< JS

   
function samakanDokter(idPegawai){   
$('.idDokter').each(function(){
        $(this).val(idPegawai);
    });   
}

function samakanVisite(idVisite){   
    $('.idVisite').each(function(){
        $(this).parents('tr').find('.ceklist').attr('checked',false);
        $(this).val(idVisite);
        
        
    });   
} 

    function dipilih(obj){
    
        if($(obj).is(':checked')){
            daftartindakan_id = $(obj).parents('tr').find("select[name*='[daftartindakan_id]']").val();
            kelaspelayanan_id = $(obj).parents('tr').find("input[name*='[kelaspelayanan_id]']").val();
            
            if(daftartindakan_id != '' && kelaspelayanan_id != ''){
                $.post("${urlCekTarifTindakan}", { daftartindakan_id: daftartindakan_id, kelaspelayanan_id: kelaspelayanan_id },
                    function(data){
                        if(data.status == 'Ada')
                        {
                           $(obj).parent().find('input').val('Ya');
                        }
                        else
                        {
                            myAlert('Maaf, Daftar Tindakan tidak memiliki tarif');
                            $(obj).parent().find('.ceklist').attr('checked',false);
                        }
                }, "json");
            }else{
                myAlert('Silakan pilih jenis Visite Dokter');
                $(obj).parent().find('.ceklist').attr('checked',false);
            }
        }else{
            $(obj).parent().find('input').val('Tidak');
        }
    }
    function validasi()
    {
        jumlahCeklist=0;
        validasiDokter='Ya';
        validasiVisite='Ya';
        
        $('.isRequired').each(function(){

            if($(this).val()==''){
                myAlert('Harap Isi Semua Yang Bertanda *')
                $(this).focus();
            }

        }); 
        
          $('.ceklist').each(function(){
            
            if($(this).is(':checked'))
               {
                  jumlahCeklist = jumlahCeklist +1;  
                  
                  if($(this).parent().prev().find('select').val()==''){
                        $(this).parent().prev().find('select').focus();
                                                validasiVisite='Tidak';

                    }
                  
                   if($(this).parent().prev().prev().find('select').val()==''){
                        $(this).parent().prev().prev().find('select').focus();
                        validasiDokter='Tidak';
                  }

               } 
          });
          
      if(jumlahCeklist==0){
        myAlert('Anda Belum Memilih Pasien');
      }else if(validasiDokter=='Tidak'){
        myAlert('Harap Isi Semua Data Dokter Yang Diperlukan');
      }else if (validasiVisite=='Tidak'){
        myAlert('Harap Isi Semua Data Visite Yang Diperlukan');
      }else{
        //$('#btn_simpan').click();
		$('#pasienVisite-form').submit();		
//        myAlert('simpan');
      }    
         
    }
JS;
Yii::app()->clientScript->registerScript('sasfsddfsgfhgdfgsgsdg',$js,CClientScript::POS_HEAD);
?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
    'id'=>'dialogDokter',
    'options'=>array(
        'title'=>'Pencarian Dokter',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modDokter = new DokterV('search');
$modDokter->unsetAttributes();
$modDokter->ruangan_id = Yii::app()->user->getState('ruangan_id');
if(isset($_GET['DokterV'])){
    $modDokter->attributes = $_GET['DokterV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'pegawaiYangMengajukan-m-grid',
    'dataProvider'=>$modDokter->search(),
    'filter'=>$modDokter,
    'template'=>"{summary}\n{items}\n{pager}",
    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
        array(
            'header'=>'Pilih',
            'type'=>'raw',
            'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn_small",
                "id"=>"selectPegawai",
                "onClick"=>"samakanDokter($data->pegawai_id);
                            $(\"#namaDokter\").val(\"$data->nama_pegawai\");
                            $(\"#'.CHtml::activeId($model,'nama_pegawai').'\").val(\"$data->nama_pegawai\");
                            $(\"#'.CHtml::activeId($model,'pegawai_id').'\").val(\"$data->pegawai_id\");
                            $(\"#dialogDokter\").dialog(\"close\");
                            return false;"
                ))'
        ),
        
        'gelardepan',
         array(
            'name'=>'nama_pegawai',
            'header'=>'Nama Dokter',
         ),
        'gelarbelakang_nama',
        'jeniskelamin',
        'notelp_pegawai',
        'nomobile_pegawai',
        array(
            'name'=>'nomorindukpegawai',
            'header'=>'NIK',
         ),
    ),
    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));
        
$this->endWidget();
?>

<script>
function pencarianForm(){
	$.fn.yiiGridView.update('daftarPasien-grid', {
        data: $('.search-form input').serialize()
    });
}
function setDokter(obj){
	var nama_pegawai = $('#<?php echo CHtml::activeId($model,'nama_pegawai'); ?>').val();
	var pilih = $('#<?php echo CHtml::activeId($model,'is_dokter'); ?>');
	if($(obj).is(':checked')){
		if(nama_pegawai == ''){
			myAlert('Silakan pilih Dokter terlebih dahulu!');
			$(obj).attr('checked', false);
			pilih.val(0);
		}
		pilih.val(1);
	}else{
		pilih.val(0);
	}
	
}
</script>