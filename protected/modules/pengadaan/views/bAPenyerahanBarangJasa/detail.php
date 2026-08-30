<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'bapenyerahanbarang-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
        ));
?>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title"> <b> Berita Acara Penyerahan Barang dan Jasa</b> </div>
    </div>
    <div class="panel-body">
        <?php $this->renderPartial('_formPenyerahan', array('model' => $model, 'form' => $form)) ?>
    </div>
</div>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title"> <b> Lampiran </b> </div>
    </div>
    <div class="panel-body">
        <?php $this->renderPartial('_formLampiran', array('model' => $model, 'modRincian' => $modRincian, 'modDetail' => $modDetail, 'form' => $form, 'modSurat' => $modSurat)) ?>
    </div>
</div>
<div class="row-fluid">
    <div class="form-actions">
        <?php
        ?>
    </div>
</div>

<?php
$this->endWidget();

$urlGetRiwayat = $this->createUrl('GetRiwayat');
$suratperjanjiankerja_id = $_GET['suratperjanjiankerja_id'];
?>

<script>

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

    function print() {
        window.open('<?php echo $this->createUrl('print', array('id' => $model->bapenyerahanbarangjasa_id)); ?>', 'printwin', 'left=100,top=100,width=640,height=480');
    }

    $(document).ready(function () {
        cekRiwayat();
        setValidasiCekDisabled($("#bapenyerahanbarang-t-form"), function () {
            return true;
        });
        $('input').attr('disabled', true);
        $('textarea').attr('disabled', true);
        $('.add-on').hide();
        $('.btn').hide();
        $('.aksi').hide();
        $('select').attr('disabled', true);
    });
</script>



