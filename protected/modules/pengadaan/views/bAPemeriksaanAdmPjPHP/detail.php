<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'bapemnelianlangsung-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
        ));
?>


<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title"><span class='judul'>Berita Acara Pemeriksaan Administratif PjPHP</span></div>
    </div>
    <div class="panel-body">
        <?php $this->renderPartial('_formPemeriksaan', array('model' => $model, 'modSPK' => $modSPK, 'form' => $form)); ?>
    </div>
</div>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title"><span class='judul'>Pemeriksaan Administratif</span></div>
    </div>
    <div class="panel-body">
        <?php
        if (!empty($model->bapemeriksaanadmpjphp_id)) {
            $this->renderPartial('_ubahtabelPemeriksaanAdm', array('model' => $model, 'modSPK' => $modSPK, 'modelDetail' => $modelDetail, 'form' => $form));
        } else {
            $this->renderPartial('_tabelPemeriksaanAdm', array('model' => $model, 'modSPK' => $modSPK, 'modelDetail' => $modelDetail, 'form' => $form));
        }
        ?>
        <br>
        <?php echo $form->textFieldRow($model, 'pemeriksaan_hasil', array('readonly' => true, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
    </div>
</div>


<?php
$this->endWidget();

$cekJumlah = LookupM::model()->findAll("lookup_type = 'dokumenpemeriksaanadministratif'");

$urlGetRiwayat = $this->createUrl('GetRiwayat');
$suratperjanjiankerja_id = $_GET['suratperjanjiankerja_id'];

if (!empty($_GET['bapemeriksaanadmpjphp_id'])) {
    $update = 'iya';
    $bapemeriksaanadmpjphp_id = $_GET['bapemeriksaanadmpjphp_id'];
} else {
    $update = 'tidak';
}

$bapemeriksaanadmpjphp_id = $model->bapemeriksaanadmpjphp_id;
?>
<script>
    function print() {
        window.open('<?php echo $this->createUrl('print', array('id' => $model->bapemeriksaanadmpjphp_id)); ?>', 'printwin', 'left=100,top=100,width=640,height=480');
    }

    function cekRiwayat(obj) {
        var suratperjanjiankerja_id = <?php echo $suratperjanjiankerja_id ?>;
        if (suratperjanjiankerja_id !== "") {
            $.post("<?php echo $urlGetRiwayat ?>", {suratperjanjiankerja_id: suratperjanjiankerja_id, },
                    function (data) {
                        $("#tableRiwayat").children("tbody").append(data.tr);
                    }, "json");
        } else {
            myAlert("Silahkan pilih data Surat Perjanjian Kerja !");
        }
        return false;

    }


    function setValidasi(obj, id) {
        var total = <?php echo count($cekJumlah) ?>;
        var jumlah = 0;
        $(obj).parents('table').find('input:radio[class="cekLengkap"]:checked').each(function () {
            if ($(this).val() == 1) {
                jumlah++;
            }
        });

        if (jumlah == total) {
            $("#BapemeriksaanadmpjphpT_pemeriksaan_hasil").val('Lengkap Sesuai');
        } else {
            $("#BapemeriksaanadmpjphpT_pemeriksaan_hasil").val('Lengkap Tidak Sesuai/Tidak Lengkap');
        }
    }

    $(document).ready(function () {
        cekRiwayat();
        $('input').attr('disabled', true);
        $('textarea').attr('disabled', true);
        $('.add-on').hide();
        $('.btn').hide();
        $('.aksi').hide();
    });
</script>