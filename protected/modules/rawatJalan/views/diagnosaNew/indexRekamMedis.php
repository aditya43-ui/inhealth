<style>
    .sorot {
        background-color: yellow !important;
    }
    body {
        overflow-x: visible; 
        min-height: 650px;
    }
</style>

<script type="text/javascript">
    var id_diagnosax = new Array();
</script>
<div class="row bodylanguage">
    <div class="col-sm-12">
        <?php
        // if (!empty($this->modSMS)) {
        $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
            'id' => 'list-penjualanresep',
            'content' => array(
                'content-list-penjualanresep' => array(
                    'header' => '<b>Riwayat Diagnosa</b>',
                    'isi' => $this->renderPartial($this->path_view . "_riwayatDiagnosa", array(
                        'modDiagnosa' => $modDiagnosa,
                        'model' => $model,
                        'modPendaftaran' => $modPendaftaran,
                        'modUraian' => $modUraian,
                        'path_view' => $path_view,
                        'modAdmisi' => $modAdmisi,
                        'modRiwayat' => $modRiwayat
                    ), true),
                    'active' => true,
                ),
            ),
        ));
        // }
        ?>
    </div>
</div>
<?php
$this->breadcrumbs=array(
	'Verifikasi Diagnosis',
);
//$this->renderPartial($path_view . '_formDataPasien',array('modPendaftaran'=>$modPendaftaran));

$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm',
    array(
        'id'=>'uraian-diagnosax-form',
        'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array(
            'onKeyPress'=>'return disableKeyPress(event)'
        ),
        'focus'=>'#',
    )
);
$this->widget('bootstrap.widgets.BootAlert');
$this->renderPartial($path_view . '_gridDiagnosaICDXRekamMedik',
    array(
        'form' => $form, 
        'modDiagnosa'=>$modDiagnosa,
        'model'=>$model,
        'modPendaftaran'=>$modPendaftaran, 
        'modUraian'=>$modUraian,
        'path_view'=>$path_view,
        'modAdmisi' =>$modAdmisi,
    )
);
?>
<br>
<?php
$this->renderPartial($path_view . '_gridDiagnosaICDIX',
    array(
        'form' => $form, 
        'modDiagnosaix'=>$modDiagnosaix,
        'model'=>$model_ix,
        'modPendaftaran'=>$modPendaftaran, 
        'modUraian'=>$modUraianIx,
        'path_view'=>$path_view,
        'modAdmisi' =>$modAdmisi,
    )
);
?>

<div class="form-actions">
</div>

<?php
    $this->endWidget();
?>
<script>
    function print(caraPrint, idReseptur) {
        var pendaftaran_id = '<?php echo isset($_GET["pendaftaran_id"]) ? $_GET["pendaftaran_id"] : null ?>';
        window.open('<?php echo $this->createUrl('print'); ?>&id=' + pendaftaran_id + '&caraPrint=' + caraPrint, 'printwin', 'left=100,top=100,width=1000,height=640');
    }

    $(document).ready(function() {
        if (typeof parent.cekPeriksaPasien != "undefined") {
            parent.cekPeriksaPasien();
        }
    });
</script>