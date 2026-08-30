<?php
$nama_pasien = '';
$jeniskelamin =' ';
$no_rekam_medik = '';
$dokter = '';
$tgl_lahir ='';
$gol_darah = '';
$ruangan_nama = '';
$kelaspelayanan_nama ='';
$modPasien = '';
$modPegawai ='';
$ruangan='';
$kelaspelayanan='';
$penjamin='';
$no_pendaftaran='';
  if(isset($modPendaftaran)) {
      $modPasien = isset($modPendaftaran->pasien_id) ? PasienM::model()->findByPk($modPendaftaran->pasien_id) : ' ';
      $modPegawai = isset($modPendaftaran->pegawai_id) ? PegawaiM::model()->findByPk($modPendaftaran->pegawai_id) : ' ';
      $no_pendaftaran = isset($modPendaftaran->no_pendaftaran) ? $modPendaftaran->no_pendaftaran : ' ';
      $umur = isset($modPendaftaran->umur) ? $modPendaftaran->umur : ' ';
      $nama_pasien = isset($modPasien->nama_pasien) ? $modPasien->nama_pasien : ' ';
      $tgl_lahir = isset($modPasien->tanggal_lahir) ? $format->formatDateTimeForDb($modPasien->tanggal_lahir) :' ';
      $jeniskelamin = isset($modPasien->jeniskelamin) ? $modPasien->jeniskelamin :' ';
      $no_rekam_medik = isset($modPasien->no_rekam_medik) ? $modPasien->no_rekam_medik : ' ';
      $dokter = isset($modPegawai->nama_pegawai) ? $modPegawai->nama_pegawai : ' ';
      $gol_darah_hide = isset($modPasien->golongandarah) ? $modPasien->golongandarah : ' ';
      $gol_darah = isset($modPasien->golongandarah) ? $modPasien->golongandarah.'/'.$modPasien->rhesus : ' ';
      $ruangan = isset($modPendaftaran->ruangan_id) ? BDRuanganM::model()->findByPk($modPendaftaran->ruangan_id) :' ';
      $ruangan_nama = isset($ruangan->ruangan_nama) ? $ruangan->ruangan_nama : ' ';
      $kelaspelayanan = isset($modPendaftaran->kelaspelayanan_id) ? BDKelaspelayananM::model()->findByPk($modPendaftaran->kelaspelayanan_id) :' ';
      $kelaspelayanan_nama = isset($kelaspelayanan->kelaspelayanan_nama) ? $kelaspelayanan->kelaspelayanan_nama : ' ';
      $penjamin = isset($modPendaftaran->penjamin_id) ? PenjaminpasienM::model()->findByPk($modPendaftaran->penjamin_id) :' ';
      $penjamin_nama = isset($penjamin->penjamin_nama) ? $penjamin->penjamin_nama : ' ';
      $alamat_pasien = isset($modPasien->alamat_pasien) ? $modPasien->alamat_pasien : ' ';
  }
?>

<div class="col-sm-6">
     <?php 
    if(empty($modPendaftaran) && $modPendaftaran == null) {  ?>
        <div class="control-group">
        <?php echo CHtml::label("No. Permintaan Darah <span class='required'>*</span>", 'no_permintaandarah', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::hiddenField('permintaandarah_id');  
                $this->widget('MyJuiAutoComplete', array(
                                'name'=>'no_permintaandarah',
                                'source'=>'js: function(request, response) {
                                               $.ajax({
                                                   url: "'.$this->createUrl('AutocompletePermintaanDarah').'",
                                                   dataType: "json",
                                                   data: {
                                                       no_permintaandarah: request.term,
                                                   },
                                                   success: function (data) {
                                                           response(data);
                                                   }
                                               })
                                            }',
                                 'options'=>array(
                                       'minLength' => 3,
                                        'focus'=> 'js:function( event, ui ) {
                                             $(this).val( "");
                                             return false;
                                         }',
                                       'select'=>'js:function( event, ui ) {
                                            $(this).val( ui.item.no_permintaandarah);
                                            return false;
                                        }',
                                ),
                                'tombolDialog'=>array('idDialog'=>'dialogPermintaanDarah'),
                                'htmlOptions'=>array('placeholder'=>'No. Permintaan Darah','class'=>'all-caps','rel'=>'tooltip','title'=>'No. Permintaan Darah',
                                'onkeyup'=>"return $(this).focusNextInputField(event)",                                    
                                ),
                            )); 
            ?>
        </div>
    </div>
    <?php    
    }
    ?>
    <div class="control-group">
        <?php echo CHtml::label('Tgl. Pendaftaran','',array('class'=>'control-label')); ?>
        <div class="controls">
            <?php $tgl = isset($modPendaftaran->tgl_pendaftaran) ? $format->formatDateTimeForUser($modPendaftaran->tgl_pendaftaran) :' '; ?> 
            <?php echo CHtml::TextField('tgl_pendaftaran',$tgl,array('readonly'=>true)); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('No. Pendaftaran','',array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::TextField('no_pendaftaran',$no_pendaftaran,array('readonly'=>true)); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Ruangan','',array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::TextField('ruangan_nama',$ruangan_nama,array('readonly'=>true)); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Kelas Pelayanan','',array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::TextField('kelas_pelayanan',$kelaspelayanan_nama,array('readonly'=>true)); ?>
        </div>
    </div> 
    <div class="control-group">
        <?php echo CHtml::label('Diagnosis','',array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::TextField('diagnosis',!empty($modPermintaanDarah->diagnosis)?$modPermintaanDarah->diagnosis:'',array('readonly'=>true)); ?>
        </div>
    </div> 
    <div class="control-group">
        <?php echo CHtml::label('Penjamin','',array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::TextField('penjamin',$penjamin_nama,array('readonly'=>true)); ?>
        </div>
    </div> 
    <div class="control-group">
        <?php echo CHtml::label('Alamat Pasien','',array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textArea('alamat_pasien',$alamat_pasien,array('readonly'=>true)); ?>           
        </div>
    </div>
</div>
<div class="col-sm-6">
    <div class="control-group">
        <?php echo CHtml::label('No. Rekam Medik','',array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::TextField('no_rekam_medik',$no_rekam_medik,array('readonly'=>true)); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Nama Pasien','',array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::TextField('nama-pasien',$nama_pasien,array('readonly'=>true)); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Tgl. Lahir','',array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::TextField('tgl_lahir',$tgl_lahir,array('readonly'=>true)); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Umur','',array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::TextField('umur',$umur,array('readonly'=>true)); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Jenis Kelamin','',array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::TextField('jenis_kelamin',$jeniskelamin,array('readonly'=>true)); ?>
        </div>
    </div>
    <div class="control-group hide">
        <?php echo CHtml::label('Golongan darah/Rhesus','',array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::hiddenField('gol_darah_hide',$gol_darah_hide,array('readonly'=>true)); ?>
            <?php echo CHtml::TextField('gol_darah',$gol_darah,array('readonly'=>true)); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Dokter yang Menangani','',array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::TextField('Dokter',$dokter,array('readonly'=>true)); ?>
        </div>
    </div>
</div>

<?php 
//========= Dialog buat cari data permintaan darah =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPermintaanDarah',
    'options'=>array(
        'title'=>'Pencarian Data Permintaan Darah',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>980,
        'height'=>480,
        'resizable'=>false,
    ),
));
    $modDialogPermintaan = new BDInfopermintaandarahpasien('searchDialog');
    $modDialogPermintaan->unsetAttributes();
    if(isset($_GET['BDInfopermintaandarahpasien'])) {
        $modDialogPermintaan->attributes = $_GET['BDInfopermintaandarahpasien'];
    }

    $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'datapermintaan-grid',
            'dataProvider'=>$modDialogPermintaan->searchDialogForUjiKompatibilitas(),
            'filter'=>$modDialogPermintaan,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-bordered table-condensed',
            'columns'=>array(
                    array(
                        'header'=>'Pilih',
                        'type'=>'raw',
                        'value'=>function($data){        
                            return CHtml::Link("<i class='icon-form-check'></i>","javascript:void(0);",array("class"=>"btn-small", 
                                "id" => "selectPermintaan",
                                "onClick" => "
                                    $('#no_permintaandarah').val('".$data['no_permintaandarah']."');
                                    getDataPermintaan(".$data['permintaandarah_id'].");   
                                    cariGolongan(); 
                                    $('#dialogPermintaanDarah').dialog('close');                                            
                            "));
                        },
                    ),                    
                    array(
                        'header'=>'No. Permintaan Darah',
                        'name'=>'no_permintaandarah',
                        'value'=>'$data["no_permintaandarah"]'
                    ),
                    array(
                        'header'=>'Jenis Permintaan',
                        'name'=>'jenispermintaan',
                        'value'=>'$data["jenispermintaan"]'
                    ),
                    array(
                        'header'=>'Nama Pasien',
                        'value'=>function($data) {
                            return $data['nama_pasien'];
                        },
                    ),
                    array(
                        'header'=>'No. Pendaftaran',
                        'value'=>function($data) {
                             return $data['no_pendaftaran'];
                        },
                    ),

            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    ));

$this->endWidget();
////======= end permintaan darah dialog =============
?>
