<?php
/**
 * view utama untuk mengakses menu tabulasi mikroniologi klinik
 * 
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link    <http://172.9.1.15/simpp/docs/>
 * @link    <http://piindonesia.co.id>
 */
?>
<style type="text/css">
	.nav-tabs > .active > a, .nav-tabs > .active > a:hover, .nav-tabs > li > a{
		cursor: pointer;
	}
    
    .integer {
        text-align: right;
    }
</style>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.tiler.js'); ?>
<?php
$this->breadcrumbs=array(
	'Laboratorium',
);
$this->widget('bootstrap.widgets.BootAlert');
?>

<?php
$this->widget('application.extensions.moneymask.MMask',array(
	'element'=>'.currency',
	'currency'=>'PHP',
	'config'=>array(
		'symbol'=>'Rp. ',
		'defaultZero'=>true,
		'allowZero'=>true,
		'decimal'=>',',
		'thousands'=>'.',
		'precision'=>0,
	)
));

$this->widget('application.extensions.moneymask.MMask',array(
	'element'=>'.number',
	'config'=>array(
		'defaultZero'=>true,
		'allowZero'=>true,
		'decimal'=>',',
		'thousands'=>'.',
		'precision'=>0,
	)
));
?>

<!--<legend class="rim2">Laboratorium</legend>-->
<?php 
$modKirimKeUnitLain->kelaspelayanan_id = Params::KELASPELAYANAN_ID_TANPA_KELAS;
$form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'id'=>'rjpasien-laboratorium-t-form',
    'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'focus'=>'#'.CHtml::activeId($modKirimKeUnitLain,'kelaspelayanan_id'),
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)',
           // 'onsubmit'=>'cekInput();return false;'
        ),
)); ?>
<div class="panel panel-success panel-shadow">
    <div class="panel-heading">
        <div class="panel-title">Tabel Riwayat <strong>Pemeriksaan Mikrobiologi Klinik Pasien</strong></div>
    </div>
    <div class="panel-body" style="overflow-x: auto; max-width: 100%;">
        <div class="block-tabel">
            <?php $this->renderPartial($this->path_view.'_listKirimKeUnitLain',array('modRiwayatKirimKeUnitLain'=>$modRiwayatKirimKeUnitLain)) ?>
        </div>
    </div>
</div>
<div class="row-fluid">
    <?php echo $form->errorSummary($modKirimKeUnitLain); ?>
    <span hidden><?php echo $form->dropDownListRow($modKirimKeUnitLain,'kelaspelayanan_id', CHtml::listData($modPendaftaran->getKelasPelayananItems(), 'kelaspelayanan_id', 'kelaspelayanan_nama') ,array('onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'reqKunjungan')); ?></span>
    <div class="col-sm-12">
        <div class="tab-pane active" id="tabs-basic">
            <div class="tabbable">
                <div class="control-group">
                    <?php echo CHtml::label("Ruangan <span class='required'>*</span>","",array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php 
                        $cri = new CDbCriteria();
                        //$cri->join = " JOIN instalasi_m i ON i.instalasi_id = t.instalasi_id ";
                        //$cri->addInCondition(" i.instalasi_id ", Params::getInsMikrobiologiKlinik());
                        $cri->addCondition(" ruangan_aktif = TRUE ");                                    
                        $cri->order = " ruangan_nama ASC ";
                        $dropRuang = CHtml::listData(RuanganM::model()->findAll($cri), 'ruangan_id', 'ruangan_nama');

                        if (empty($dropRuang)){
                            $dropRuang = array('empty' => '-- Pilih --');
                        }

                        echo $form->dropDownList($modKirimKeUnitLain, 'ruangan_id',$dropRuang,array('onchange'=>'cariTarifLab(this);')) ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Bahan / Spesimen </label>
                    <div class="controls" id="bahanSpesimen">
                        <?php
                            echo $form->hiddenField($modKirim, 'samplelab_id', array('class' => 'span3'));
                        
                            $this->widget('MyJuiAutoComplete', array(                    
                                'name' => 'periksabahan',
                                'source' => 'js: function(request, response) {
                                    $.ajax({
                                            url: "' . $this->createUrl('/ActionAutoComplete/bahanSpesimen') . '",
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
                                                        $(this).val(ui.item.label);
                                                        $("#KirimspesimenlabT_samplelab_id").val(ui.item.value);
                                                        return false;
                                                }',
                                                'select' => 'js:function( event, ui ) {
                                                        $(this).blur();

                                                        return false;
                                                }',
                                            ),
                                            'htmlOptions'=>array(
                                                'onblur'=>'setBahan($("#'.CHtml::activeId($modKirim, 'samplelab_id').'"));',
                                                'class'=>'','onkeypress'=>"return $(this).focusNextInputField(event)",'placeholder'=>'Ketik Nama Bahan / Spesimen',
                                                'style' => 'width:200px;'
                                                ),

                            ));		
                        ?>
                    </div>
                </div>
                <div style="height:400px;overflow-y: scroll;" id="loadSpesimen"> 
                <?php 
                    $ceklist = "";
                    $criBahan = new CDbCriteria();
                    $criBahan->select = "t.samplelab_namalainnya";
                    $criBahan->group = "t.samplelab_namalainnya";
                    $criBahan->order = "t.samplelab_namalainnya DESC";
                    $genBahan = SamplelabM::model()->findAll($criBahan);
                    foreach($genBahan as $gen){ 
                        $cri = new CDbCriteria();
                        $cri->order = "t.samplelab_nama ASC";
                        $cri->addCondition(" t.samplelab_namalainnya = '".$gen->samplelab_namalainnya."'");
                        $bahan = SamplelabM::model()->findAll($cri);
                    ?>
                    <div class="boxSample">
                        <div class="col-sm-3">
                            <div class="panel panel-success panel-shadow">
                                <div class="panel-heading">
                                    <div class="panel-title"><h6><?php echo $gen->samplelab_namalainnya; ?></h6></div>
                                </div>
                                <div class="panel-body">
                                    <?php
                                    foreach($bahan as $bhn){
                                        $modKirim->samplelab_id = $bhn->samplelab_id;
                                        if ($gen->samplelab_namalainnya == Params::BAHAN_SPESIMEN_JENIS_PUS) { 
                                            echo '<label class="checkbox inline">' . 
                                                CHtml::hiddenField("KirimspesimenlabT[".$modKirim->samplelab_id."][samplelab_id]",$modKirim->samplelab_id).
                                                CHtml::checkBox("KirimspesimenlabT[".$modKirim->samplelab_id."][cekList]", false, array("class"=>"cekList", "value" => $modKirim->samplelab_id, 'onClick' => 'inputBahan(this)' ,"onkeyup"=>"return $(this).focusNextInputField(event);"));
                                            echo "<span>" . $bhn['samplelab_nama'] . "</span></label><br/>";

                                            echo CHtml::textField("KirimspesimenlabT[".$modKirim->samplelab_id."][lokasi]", false, array("class"=>"span3", "onkeyup"=>"return $(this).focusNextInputField(event);", "placeholder" => "Lokasi ".$bhn['samplelab_nama']))."<br>";

                                        } else {
                                            echo '<label class="checkbox inline">' .
                                                CHtml::hiddenField("KirimspesimenlabT[".$modKirim->samplelab_id."][samplelab_id]",$modKirim->samplelab_id).
                                                CHtml::checkBox("KirimspesimenlabT[".$modKirim->samplelab_id."][cekList]", false, array("class"=>"cekList", "value" => $modKirim->samplelab_id,'onClick' => 'inputBahan(this)' ,"onkeyup"=>"return $(this).focusNextInputField(event);"));
                                            echo "<span>" . $bhn['samplelab_nama'] . "</span></label><br/>";
                                        }
                                    }?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
        <div class="clear"></div>
        
        <div class="control-group">
            <label class="control-label">Pemeriksaan Mikrobiologi Klinik</label>
            <div class="controls">
                <?php
                    $this->widget('MyJuiAutoComplete', array(                    
                        'name' => 'periksalab',
                        'source' => 'js: function(request, response) {
                            $.ajax({
                                    url: "' . $this->createUrl('/ActionAutoComplete/PeriksaLabRujukan') . '",
                                    dataType: "json",
                                    data: {
                                            term: request.term,
                                            ruangan_id: $("#'.CHtml::activeId($modKirimKeUnitLain, 'ruangan_id').'").val(),
                                            pendaftaran_id: '.$modPendaftaran->pendaftaran_id.', 
                                            penjamin_id: '.$modPendaftaran->penjamin_id.', 
                                            kelaspelayanan_id: '.$modPendaftaran->kelaspelayanan_id.', 
                                            jenistarif_id: '.$modJenisTarif->jenistarif_id.', 
                                            jeniskelompok: "'.Params::PATOLOGI_MIKROBIOLOGI_KLINIK.'"
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
                                    $(this).val(ui.item.label);
                                    return false;
                            }',
                            'select' => 'js:function( event, ui ) {
                                    $(this).blur();
                                    return false;
                            }',
                        ),
                       // 'tombolDialog'=>array("idDialog"=>'dialogPegawai','jsFunction'=>"setDialog(this);"),
                        'htmlOptions'=>array(
                            'onblur'=>'cariTarifLab($("#'.CHtml::activeId($modKirimKeUnitLain, 'ruangan_id').'"));',
                            'class'=>'','onkeypress'=>"return $(this).focusNextInputField(event)",'placeholder'=>'Ketik nama operasi',
                            'style' => 'width:200px;'
                            ),

                    ));		
                ?>
            </div>
        </div>
        <div class="clear"></div>
        <ul class="nav nav-tabs" id="tabes">
        </ul>
        <div class="tab-content biru">
            <div class="white tab-pane" id="tab1-klinik">
                <div style="height:400px;overflow-y: scroll;" id="generate-pemeriksaanlab">
                    <table width="100%">
                        <tr>
                            <td>
                                <?php echo CHtml::hiddenField('url',$this->createUrl('',array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id)),array('readonly'=>TRUE));?>
                                <?php echo CHtml::hiddenField('berubah','',array('readonly'=>TRUE));?>
                                <div id="formPeriksaLab">
                                    <?php 
                                        if (!empty($tarif_gen)){
                                            foreach($tarif_gen as $jns){
                                                $ceklist = false;
                                                $patologi = $jns['jenispemeriksaanlab_kelompok'];
                                                if($patologi==Params::PATOLOGI_MIKROBIOLOGI_KLINIK){
                                        ?>
                                                 <div class="col-sm-4">
                                                    <div class="boxtindakan">
                                                            <div class="panel panel-success panel-shadow">
                                                                    <div class="panel-heading">
                                                                            <div class="panel-title"><h6><?php echo $jns['jenispemeriksaanlab_nama']; ?></h6></div>
                                                                    </div>
                                                                    <div class="panel-body">
                                                                            <?php   foreach ($jns['det'] as $j => $pr) {                                                                                                                            
                                                                                        echo '<label class="checkbox inline">'.CHtml::checkBox("pemeriksaanLab[]", $ceklist, array('value'=>$pr['pemeriksaanlab_id'],
                                                                                        'onclick' => "inputperiksa(this,".$pr['ruangan_id'].");",'id'=>'pemeriksaanlabid','ruanganid'=>$pr['ruangan_id']));
                                                                                        echo "<span>".$pr['pemeriksaanlab_nama']."</span></label><br/>";
                                                                            } ?>
                                                                    </div>
                                                            </div>

                                                    </div>
                                                </div>
                                        <?php
                                                }
                                            }
                                        } ?>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    
                                       
            </div>
        </div>	
    </div>   
</div>      
<div class="row-fluid">
    <p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>
	<div class="col-sm-6">
              <label> <p style="font-weight: bold">  Data Dokter Pengirim </p> </label>
            <div class="control-group">
                <?php echo CHtml::label("Nama DPJP <span class='required'>*</span> ", '', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->hiddenField($modKirimKeUnitLain, 'pegawai_id', array('class' => 'span3 required')) ?>
                    <?php
                    $this->widget('MyJuiAutoComplete', array(
                        'name' => 'dpjp_nama',
                        'value' => isset($modKirimKeUnitLain->pegawai_id) ? $modKirimKeUnitLain->dpjp_nama : '',
                        'source' => 'js: function(request, response) {
                                       $.ajax({
                                           url: "' . $this->createUrl('AutocompletePetugas') . '",
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
                                                    $(this).val("");
                                                    return false;
                                                }',
                            'select' => 'js:function( event, ui ) {
                                            $(this).val(ui.item.value);
                                            $("#dpjp_nama").val(ui.item.nama_pegawai);
                                            $("#' . CHtml::activeId($modKirimKeUnitLain, 'pegawai_id') . '").val(ui.item.pegawai_id);
                                            return false;
                                    }',
                        ),
                        'htmlOptions' => array(
                            'onkeyup' => "return $(this).focusNextInputField(event)",
                            'class' => 'span3',
                        ),
                        'tombolDialog' => array('idDialog' => 'dialogDokter'),
                    ));
                    ?>
                </div>
            </div>
            <div class="control-group"> 
                <label class="control-label">Nama PPDS</label>
                <div class="controls">
                   <?php echo $form->hiddenField($modKirimKeUnitLain, 'ppds_id', array('class' => 'span3', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                        <?php
                            $this->widget('MyJuiAutoComplete', array(
                                'model' => $modKirimKeUnitLain,
                                'attribute' => 'ppds_nama',
                                'source' => 'js: function(request, response) {
                                        $.ajax({
                                                url: "' . $this->createUrl('/actionAutoComplete/PPDS') . '",
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
                                    'select' => 'js:function( event, ui ) {
                                                $(this).val( ui.item.ppds_nama );
                                                $("#RJPasienKirimKeUnitLainT_ppds_id").val( ui.item.ppds_id);
                                                setPpds(ui.item.ppds_id);
                                                return false;
                                    }',
                                ),
                                'htmlOptions' => array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3 required', 'placeholder' => 'Ketikkan Nama PPDS  '),
                                'tombolDialog' => array('idDialog' => 'dialogPpds', 'idTombol' => 'tombolPpds'),
                            ));
                        ?>
                        </div>
            </div>
            <div class="control-group"> 
                <label class="control-label">NIM</label>
                    <div class="controls">
                    <?PHP echo CHtml::textField('nim','',array('readonly'=>true)); ?>   
                </div>
            </div>
            <div class="control-group"> 
                <label class="control-label">Nama Prodi</label>
                    <div class="controls">
                      <?PHP echo CHtml::textField('nama_prodi', '', array('readonly' => true)); ?>   
                    </div>
            </div>
            <div class="control-group"> 
                <label class="control-label">No. HP</label>
                    <div class="controls">
                      <?PHP echo CHtml::textField('no_hp', '', array('readonly' => true)); ?>   
                    </div>
            </div>

                <div class="control-group"> 
                 <label><b>Data Pelengkap Diagnosis</b></label>
                        <div class="controls">
                          
	                     </div>
                </div>
            
                <div class="control-group"> 
                        <label class="control-label">Diagnosis</label>
                        <div class="controls">
                        <?PHP echo CHtml::textField('diagnosis','',array('readonly'=>true)); ?>   
                        </div>
                </div>
                <div class="control-group"> 
                    <label class="control-label">Klinis Penunjang Infeksi <span class="required"> * </span> </label>
                    <div class="controls">
                        <?php echo $form->textField($modKirimKeUnitLain,'klinis_penunjang_infeksi',array('onkeypress'=>"return $(this).focusNextInputField(event);", 'class' => 'required')) ?>
                    </div>
                </div>
                <div class="control-group"> 
                    <label class="control-label">Keterangan Klinis Lain</label>
                    <div class="controls">
                        <?php echo $form->textArea($modKirimKeUnitLain,'catatandokterpengirim',array('onkeypress'=>"return $(this).focusNextInputField(event);")) ?>
                    </div>
                </div>
            
                <div class="control-group"> 
                     <label><b>Permintaan Pemeriksaan Mikrobiologi</b></label>
                        <div class="controls">
                          
                        </div>
                </div>
		<div class="control-group">
			<label class="control-label required" for="RJPasienKirimKeUnitLainT_tgl_kirimpasien">
				Tanggal Permintaan
				<span class="required">*</span>
			</label>
			<?php $modKirimKeUnitLain->tgl_kirimpasien = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modKirimKeUnitLain->tgl_kirimpasien, 'yyyy-MM-dd hh:mm:ss','medium',null)); ?>
			<div class="controls">
				<?php   
					$this->widget('MyDateTimePicker',array(
						'model'=>$modKirimKeUnitLain,
						'attribute'=>'tgl_kirimpasien',
						'mode'=>'datetime',
						'options'=> array(
							'dateFormat'=>Params::DATE_FORMAT,
							'maxDate' => 'd',
						),
						'htmlOptions'=>array('readonly'=>true, 'class'=>'realtime'),
				)); ?>
			</div>
		</div> 	
                <div class="control-group"> 
                        <label class="control-label">No. Permintaan</label>
                        <div class="controls">
                            <?php echo $form->textField($modKirimKeUnitLain,'no_permintaan',array('readonly'=>true,'onkeypress'=>"return $(this).focusNextInputField(event);")) ?>
                        </div>
                </div>
                <div class="control-group"> 
                        <label class="control-label">Antibiotik yang sudah diberikan</label>
                        <div class="controls">
                            <?php echo $form->textField($modKirimKeUnitLain,'antibiotikygdiberi',array('readonly'=>false,'onkeypress'=>"return $(this).focusNextInputField(event);")) ?>
                        </div>
                        <div class="controls">
                            <?php echo $form->checkBox($modKirimKeUnitLain, 'antibiotikygdiberi_tidakada', array('onkeypress' => "return $(this).focusNextInputField(event)", 'onclick' => 'cekAntibiotik()')); ?> <label> Tidak Ada </label> <br>
                        </div>
                </div>
                 <div class="control-group"> 
                        <label class="control-label">Berapa lama</label>
                        <div class="controls">
                            <?php echo $form->textField($modKirimKeUnitLain,'antibiotik_hari',array('class'=>'numbers-only','readonly'=>false,'onkeypress'=>"return $(this).focusNextInputField(event);")) ?>
                            <label>hari</label>
                        </div>
                </div>      
        </div>
        <div class="col-sm-6">
            <div class="panel panel-success panel-shadow">
                <div class="panel-heading">
                    <div class="panel-title">Tabel Pemeriksaan <strong>Mikrobiologi Klinik <?php echo isset($modJenisTarif) ? "- " . $modJenisTarif->jenistarif->jenistarif_nama : ""; ?></strong></div>
                </div>
                <div class="panel-body table-responsive">
                    <div class="block-tabel">
                        <table id="tblFormPemeriksaanLab" class="table table-bordered table-striped table-condensed">
                            <thead>
                                <tr>
                                    <th>Jenis Pemeriksaan</th>
                                    <th>Pemeriksaan</th>
                                    <!--<th>Tarif</th>-->
                                    <th>Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                    <!--<tr id="trPeriksaLabKosong"><td colspan="5"></td></tr>-->
                            </tbody>
                        </table>
                        <table class="table bordered table-striped table-condensed">
                            <tr><td width="70%" style="text-align: right;"><!--Total Biaya Pemeriksaan--></td><td><?php echo CHtml::hiddenField('periksaTotal', '', array('class' => 'span2 integer', 'style' => 'text-align:right;', 'disabled' => 'disabled')); ?></td></tr>
                        </table>
                    </div>
                </div>
            </div> <br>	
            <div class="panel panel-success panel-shadow">
                <div class="panel-heading">
                    <div class="panel-title">Tabel <strong> Bahan / Spesimen Mikrobiologi Klinik </strong></div>
                </div>
                <div class="panel-body table-responsive">
                    <div class="block-tabel">
                        <table id="tabelBahan" class="table table-bordered table-striped table-condensed">
                            <thead>
                                <tr>
                                    <th>Jenis Spesimen </th>
                                    <th>Nama Spesimen</th>
                                    <th>Lokasi</th>
                                    <th>Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                        <table class="table bordered table-striped table-condensed">
                            <tr><td width="70%" style="text-align: right;"><!--Total Biaya Pemeriksaan--></td><td><?php echo CHtml::hiddenField('periksaSpesimen', '', array('class' => 'span2 integer', 'style' => 'text-align:right;', 'disabled' => 'disabled')); ?></td></tr>
                        </table>
                    </div>
                </div>
            </div> 
        </div>
</div>

<div class="form-actions">
	<?php 
        if(!isset($_GET['idPasienKirimKeUnitLain'])){
                echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                    array('class'=>'btn btn-primary submit', 'id'=>'btn_submit','onclick'=>'cekInput()','onkeypress'=>'cekInput()')); 
            }else{
                echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                    array('class'=>'btn btn-primary submit', 'id'=>'btn_submit','disabled'=>true)); 
            }
            echo "&nbsp;";
            echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                $this->createUrl($this->id.'/index&pendaftaran_id='.$_GET['pendaftaran_id']), 
                array('class'=>'btn btn-danger',
                    'onclick'=>'return refreshForm(this);'));
	?>
	<?php
		if(isset($_GET['idPasienKirimKeUnitLain'])){
			echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
			echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
			echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp"; 
		}else{
			echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button', 'disabled'=>'disabled'))."&nbsp&nbsp"; 
			echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button', 'disabled'=>'disabled'))."&nbsp&nbsp"; 
			echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button', 'disabled'=>'disabled'))."&nbsp"; 
		}
	?>	
	<?php 
		$idPasienKirimKeUnitLain = isset($_GET['idPasienKirimKeUnitLain'])?$_GET['idPasienKirimKeUnitLain']:null;
		$content = $this->renderPartial('rawatJalan.views.tips.tips',array(),true);
		$this->widget('UserTips',array('type'=>'admin','content'=>$content));
		$urlPrint = Yii::app()->createAbsoluteUrl($this->module->id.'/'.$this->id.'/print&id='.$modPendaftaran->pendaftaran_id.'&idPasienKirimKeUnitLain='.$idPasienKirimKeUnitLain);
		$urlPrintRiwayat = Yii::app()->createAbsoluteUrl($this->module->id.'/'.$this->id.'/printRiwayat&id='.$modPendaftaran->pendaftaran_id);
		$urlPrintPermintaan = Yii::app()->createAbsoluteUrl($this->module->id.'/'.$this->id.'/print&id='.$modPendaftaran->pendaftaran_id);
$js = <<< JSCRIPT
		function print(caraPrint){
			window.open("${urlPrint}&caraPrint="+caraPrint,"",'location=_new, width=460px');
		}
		function printRiwayat(caraPrint){
			window.open("${urlPrintRiwayat}&caraPrint="+caraPrint,"",'location=_new, width=900px');
		}
		function printPermintaan(idPasienKirimKeUnitLain){
			window.open("${urlPrintPermintaan}&idPasienKirimKeUnitLain="+idPasienKirimKeUnitLain+"&caraPrint="+"PRINT","",'location=_new, width=460px');
		}
JSCRIPT;
	Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
?>
</div>
<?php $this->endWidget(); ?>

<?php
        $this->renderPartial($this->path_view.'jsFunction', array('modPasien' => $modPasien, 'modKirimKeUnitLain' => $modKirimKeUnitLain, 'modPendaftaran' => $modPendaftaran, 'modJenisTarif' => $modJenisTarif));
	$ruangan = RuanganM::model()->findByPk(Yii::app()->user->getState('ruangan_id'));
	$instalasi_id = $ruangan->instalasi_id;
	$isinotifikasi = $modPasien->no_rekam_medik . '-' . $modPendaftaran->no_pendaftaran . '-' . $modPasien->nama_pasien . '-' . $ruangan->ruangan_nama;
?>
<?php 

//========= Dialog buat cari data PPDS  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPpds',
    'options' => array(
        'title' => 'Pencarian PPDS',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'resizable' => false,
    ),
));

$modPpds = new PpdsM();
$modPpds->unsetAttributes();
if (isset($_GET['PpdsM'])) {
    $modPpds->attributes = $_GET['PpdsM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'ppds-m-grid',
    'dataProvider' => $modPpds->searchData(),
    'filter' => $modPpds,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                "id" => "selectPpds",
                "onClick" => "$(\"#' . CHtml::activeId($modKirimKeUnitLain, 'ppds_id') . '\").val(\"$data->ppds_id\");
                              $(\"#RJPasienKirimKeUnitLainT_ppds_nama\").val(\"$data->ppds_nama\");   
                              setPpds(\"$data->ppds_id\"); 
                              $(\"#dialogPpds\").dialog(\"close\");    
                              return false;
                    "))',
        ),
        array(
            'header' => 'NIM',
            'name' => 'ppds_nim',
            'value' => '$data->ppds_nim',
        ),
        array(
            'header' => 'Nama PPDS',
            'name' => 'ppds_nama',
            'value' => '$data->ppds_nama',
        ),
        array(
            'header' => 'Tahap',
            'name' => 'ppds_tahap',
            'value' => '$data->ppds_tahap',
        ),
        array(
            'header' => 'Prodi',
            'filter'=>  CHtml::activeDropDownList($modPpds, 'programstudi_id', CHtml::listData(ProgramstudiM::model()->findAll("programstudi_aktif = TRUE ORDER BY programstudi_nama ASC"), 'programstudi_id', 'programstudi_nama'),array('empty'=>'-- Pilih --')),
            'value' => function($data) {
                    $programstudi_nama = "";
                    if(!empty($data->programstudi_id)){
                        $programstudi_nama = ProgramstudiM::model()->findByPk($data->programstudi_id)->programstudi_nama;
                    }
                    return $programstudi_nama;
            },
        ),
        array(
            'header' => 'No. HP',
            'value' => function($data){
                $nomor_hp = "-";
                $modAlamat = PpdsalamatM::model()->findByAttributes(array('ppds_id' => $data->ppds_id, 'ppdsalamat_tipe' => Params::TIPE_ALAMAT_PPDS_IDENTITAS));
                if (!empty($modAlamat)) {
                    $nomor_hp = $modAlamat->no_mobile;
                }
                return $nomor_hp;
            }
        )
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end Search data PPDS =============================
?>
<?php
    //========= Dialog buat cari DPJP ==========
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogDokter',
        'options' => array(
            'title' => 'Daftar DPJP',
            'autoOpen' => false,
            'modal' => true,
            'width' => 750,
            'resizable' => false,
        ),
    ));

    $modPegawai = new PegawairuanganV('searchDokter');
    $modPegawai->unsetAttributes();
    if (isset($_GET['PegawairuanganV']))
        $modPegawai->attributes = $_GET['PegawairuanganV'];

    $this->widget('ext.bootstrap.widgets.BootGridView', array(
        'id' => 'dokter-m-grid',
        'dataProvider' => $modPegawai->searchDokter(),
        'filter' => $modPegawai,
        'template' => "{items}\n{pager}",
        'itemsCssClass' => 'table table-striped table-bordered table-condensed',
        'columns' => array(
            ////'pegawai_id',
            array(
                'header' => 'Pilih',
                'type' => 'raw',
                'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
					"id" => "selectBahan",
					"onClick" => "
						$(\'#' . Chtml::activeId($modKirimKeUnitLain, 'pegawai_id') . '\').val(\'$data->pegawai_id\');	
						$(\'#dpjp_nama\').val(\'$data->NamaLengkap\');
						$(\'#dialogDokter\').dialog(\'close\');
						return false;"))',
            ),
             array(
            'header' => 'NIP',
            'filter' => CHtml::activeTextField($modPegawai, 'nomorindukpegawai'),
            'value' => '$data->nomorindukpegawai',
        ),
        array(
            'header' => 'Nama Pegawai',
            'filter' => CHtml::activeTextField($modPegawai, 'nama_pegawai'),
            'value' => '$data->nama_pegawai',
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'value' => function($data){
                        $hasil ='';
                        $j = JabatanM::model()->findByPk($data->jabatan_id);
                                
                        if (!empty($j)){
                            $hasil = $j->jabatan_nama;
                        }
                            return $hasil;
            },
            'filter' => Chtml::activeDropDownList($modPegawai, 'jabatan_id', Chtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --'))
        ),
        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
    ));

    $this->endWidget();
 //========= Dialog buat cari Petugas ==========
?>
<script>
      $(document).ready(function() {
           var ruangan = jQuery('#<?php echo CHtml::activeId($modKirimKeUnitLain, 'ruangan_id') ?>');	
           jQuery(ruangan).multiselect({
                   includeSelectAllOption: false,
                   buttonClass: "form-control",
                   maxHeight: 300,
                   buttonWidth: '182px',
                   enableCaseInsensitiveFiltering: true
           }).hide();
       });


    function searchDokter() {
            $('#rjpasien-laboratorium-t-form input[name*="ruangan_id"]').each(function() {
            });
    }

    $(document).ready(function() {

var samplelab = jQuery('#<?php echo CHtml::activeId($modKirim, 'samplelab_id') ?>');
    jQuery(samplelab).multiselect({
        includeSelectAllOption: true,
        buttonClass: "form-control",
        maxHeight: 300,
        buttonWidth: '240px',
        enableCaseInsensitiveFiltering: true
    }).hide();
});

$(document).ready(function() {

var caraambilsampel = jQuery('#<?php echo CHtml::activeId($modKirim, 'caraambilsampel_id') ?>');
jQuery(caraambilsampel).multiselect({
    includeSelectAllOption: true,
    buttonClass: "form-control",
    maxHeight: 300,
    buttonWidth: '240px',
    enableCaseInsensitiveFiltering: true
}).hide();
});
    </script>
