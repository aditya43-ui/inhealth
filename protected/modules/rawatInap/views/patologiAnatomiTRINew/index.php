<?php
/**
 * view utama untuk mengakses menu tabulasi patologi anatomi
 * 
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link    <http://172.9.1.15/simpp/docs/>
 * @link    <http://piindonesia.co.id>
 */
?>

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>

<style type="text/css">
.nav-tabs>.active>a,
.nav-tabs>.active>a:hover,
.nav-tabs>li>a {
    cursor: pointer;
}

.integer {
    text-align: right;
}
</style>

<?php
$this->breadcrumbs=array(
	'Patologi Anatomi',
);
$this->widget('bootstrap.widgets.BootAlert');
?>


<?php 
//$modKirimKeUnitLain->kelaspelayanan_id = Params::KELASPELAYANAN_ID_TANPA_KELAS;
$form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'id'=>'rjpasien-laboratorium-t-form',
    'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'focus'=>'#'.CHtml::activeId($modKirimKeUnitLain,'kelaspelayanan_id'),
	'htmlOptions'=>array('onKeyPress' => 'return disableKeyPress(event)'),
)); ?>

<?php
if (isset($_GET['sukses'])) {
    Yii::app()->user->setFlash('success', "Data berhasil disimpan!");
}

$sukses = isset($_GET['sukses'])?$_GET['sukses']:'';
echo CHtml::hiddenField('sukses', $sukses);
?>

<?php 
$loginpemakai = Yii::app()->user->id;
$criteria = new CDbCriteria;
$criteria->addCondition('loginpemakai_id = ' . $loginpemakai);
$pegawai = LoginpemakaiK::model()->find($criteria);
$kelPegawai = PegawaiM::model()->findByPk($pegawai->pegawai_id);

if ((!empty($kelPegawai->loginpemakai_id == Yii::app()->user->getState('loginpemakai_id')) && !empty($kelPegawai->kelompokpegawai_id == Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN))) {

	    $idPasienKirimKeUnitLain = isset($_GET['idPasienKirimKeUnitLain'])?$_GET['idPasienKirimKeUnitLain']:null;
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
<div class="panel panel-success panel-shadow">
    <div class="panel-heading">
        <div class="panel-title">Tabel Riwayat <strong>Pemeriksaan Patologi Anatomi Pasien</strong></div>
    </div>
    <div class="panel-body table-responsive" style="overflow-x: auto; max-width: 100%;">

        <?php $this->renderPartial($this->path_view.'_listKirimKeUnitLain2',array('modRiwayatKirimKeUnitLain'=>$modRiwayatKirimKeUnitLain)) ?>

    </div>
</div>

<?php
}else{
    
    ?>

<div class="panel panel-success panel-shadow">
    <div class="panel-heading">
        <div class="panel-title">Tabel Riwayat <strong>Pemeriksaan Patologi Anatomi Pasien</strong></div>
    </div>
    <div class="panel-body table-responsive" style="overflow-x: auto; max-width: 100%;">

        <?php $this->renderPartial($this->path_view.'_listKirimKeUnitLain',array('modRiwayatKirimKeUnitLain'=>$modRiwayatKirimKeUnitLain)) ?>
        <?php $this->renderPartial($this->path_view.'_form',array('form' => $form, 'modKirimKeUnitLain'=>$modKirimKeUnitLain)) ?>

    </div>
</div>


<div class="form-actions">
    <?php 
        if(!isset($_GET['idPasienKirimKeUnitLain'])){
            echo CHtml::htmlButton($modKirimKeUnitLain->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' =>(isset($_GET['sukses']))? 'btn btn-success' : 'btn btn-primary submit',
                 'type' => 'button', 'onclick' => 'cekForm();','id'=>'btn_submit','disabled'=>(isset($_GET['sukses']))? true : false));
            }else{
                echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
                                    array('class'=>'btn btn-success submit', 'id'=>'btn_submit','disabled'=>true)); 
            }
            echo "&nbsp;";
            echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                $this->createUrl($this->id.'/index&pendaftaran_id='.$_GET['pendaftaran_id']), 
                array('class'=>'btn btn-danger',
                    'onclick'=>'return refreshForm(this);'));
	?>
    <?php 
		$idPasienKirimKeUnitLain = isset($_GET['idPasienKirimKeUnitLain'])?$_GET['idPasienKirimKeUnitLain']:null;
		$content = $this->renderPartial('rawatJalan.views.tips.tips',array(),true);
		$this->widget('UserTips',array('type'=>'admin','content'=>$content));

?>
</div>
<?php } ?>
<?php $this->endWidget(); ?>

<?php
	$ruangan = RuanganM::model()->findByPk(Yii::app()->user->getState('ruangan_id'));
	$instalasi_id = $ruangan->instalasi_id;
	$isinotifikasi = $modPasien->no_rekam_medik . '-' . $modPendaftaran->no_pendaftaran . '-' . $modPasien->nama_pasien . '-' . $ruangan->ruangan_nama;
?>
<script type="text/javascript">

    
function cekForm(){
    if (requiredCheck($("#rjpasien-laboratorium-t-form"))){
        $('#rjpasien-laboratorium-t-form').submit();
    }
   return false;
}

function setPpds(ppds_id) {
    var id = ppds_id;
    $.ajax({
        type: 'POST',
        data: {
            id: id
        },
        url: '<?php echo $this->createUrl('generatePpds'); ?>',
        dataType: "json",
        success: function(data) {
            if (data.ok != 1) {
                toastr.warning(data.msg);
                $("#RIPasienKirimKeUnitLainT_nim").val("");
                $("#RIPasienKirimKeUnitLainT_nama_prodi").val("");
                $("#RIPasienKirimKeUnitLainT_no_hp").val("");
                return false;
            }
            setVal(data.data);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(errorThrown);
        }
    });
}

function setVal(data) {
    $("#RIPasienKirimKeUnitLainT_nim").val(data.ppds_nim);
    $("#RIPasienKirimKeUnitLainT_nama_prodi").val(data.programstudi_nama);
    $("#RIPasienKirimKeUnitLainT_no_hp").val(data.nomor_hp);
}

function setDialogDiagnosaMasuk(obj) {
    $('#dialogDiagnosaMasuk').dialog('open');
    $("#judul").html($(obj).attr('judul_id'));

    var data_id = $(obj).attr('data_id');

    $("#tampungDiagnosa").val(data_id);
}
</script>