
<div class="panel panel-primary panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Pengambilan <strong>Sampel Pemeriksaan</strong></div>
    </div>
    <div class="panel-body">
        <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'pppendaftaran-mp-form',
            'enableAjaxValidation' => false,
            'enableClientValidation' => false,
            'type' => 'horizontal',
            'focus' => '#isPasienLama',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
        ));
        //
        ?>
        <div class="panel panel-success panel-shadow">
            <div class="panel-heading">
                <div class="panel-title">Data Pasien</div>
            </div>
            <div class="panel-body row-fluid">

                <?php
                $this->widget('bootstrap.widgets.BootAlert');
                $this->renderPartial('template/_ringkasDataPasien', array('modPasienMasukPenunjang' => $modPasienMasukPenunjang));
                echo $form->errorSummary(array($modKirimSample, $modPengambilanSample));
                ?>
            </div>
        </div>								
        <div class="panel panel-success panel-shadow">
            <div class="panel-heading">
                <div class="panel-title">Data Sampel <?php echo CHtml::htmlButton("<i class='icon icon-white icon-plus'></i>", array('onclick' => 'addRowSample(this);return false;', 'rel' => 'tooltip', 'title' => 'Klik untuk menambah data sample', 'class' => 'btn btn-primary')); ?></div>
            </div>
            <div class="panel-body">
                <table width="100%" id="data-sample">
                    <?php
                    $samples = count($modPengambilanSamples);
                    if ($samples > 0) {
                        foreach ($modPengambilanSamples as $i => $pengambilanSample) {
                            echo $this->renderPartial('_rowSample', array('form' => $form, 'modPengambilanSample' => $pengambilanSample, 'i' => $i), true);
                        }
                    } else {
                        echo $this->renderPartial('_rowSample', array('form' => $form, 'modPengambilanSample' => $modPengambilanSample, 'i' => 0), true);
                    }
                    ?>
                </table>
            </div>
        </div>								
        <div class='form-actions'>
            <?php
            echo CHtml::htmlButton($modKirimSample->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="icon-ok icon-white"></i>')) :
                            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => (isset($_GET['sukses'])) ? 'btn btn-primary' : 'btn btn-primary submit', 'type' => 'submit',
                'id' => 'btn_simpan', 'disabled' => (isset($_GET['sukses'])) ? true : false
            ));
            ?>
            <?php echo CHtml::link(Yii::t('mds', '{icon} Batal', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), $this->createUrl('index'), array('class' => 'btn btn-danger')); ?>
            <?php echo CHtml::link(Yii::t('mds', '{icon} Cetak Permintaan', array('{icon}' => '<i class="' . MyIcon::getIcons('cetak') . '"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printHasil();return false")); ?>
            <?php
            echo '&nbsp;';
            if (!empty($modPasienMasukPenunjang->pasienmasukpenunjang_id)) {
                echo CHtml::link('<i class="entypo-back" style="color: white;"></i> Kembali', '#', array('class' => 'btn btn-red', 'onclick' => 'window.history.back(); return false;', 'style' => 'color: white;'));
            }
            ?>
        </div>
        <?php
        if ($samples > 0) {
            $trSample = $this->renderPartial('_rowSample', array('form' => $form, 'modPengambilanSample' => $modPengambilanSample, 'i' => $i + 1), true);
        } else {
            $trSample = $this->renderPartial('_rowSample', array('form' => $form, 'modPengambilanSample' => $modPengambilanSample, 'i' => 0), true);
        }
        ?>
        <?php $this->endWidget(); ?>
    </div>
</div>


<script type="text/javascript">
    /**
     * - digunakan untuk memanggil data prinout
     * @returns {memanggil windows dialog untuk melihat prinout}
     */
    function printHasil()
    {
        var pasienmasukpenunjang_id = '<?php echo isset($_GET['pasienmasukpenunjang_id']) ? $_GET['pasienmasukpenunjang_id'] : '' ?>';
        if (pasienmasukpenunjang_id != "") {
            window.open('<?php echo $this->createUrl('printPermintaan'); ?>&pasienmasukpenunjang_id=' + pasienmasukpenunjang_id, 'printwin', 'left=100,top=0,width=768,height=640');
        } else {
            myAlert("Tidak Ada Data Pasien");
        }
    }

    function addRowSample()
    {
        var trSample = <?= json_encode($trSample) ?>;
        $('table#data-sample').append(trSample.replace());
        renameInput();
    }
    function hapusRowSample(obj, id = null)
    {
        if (id == null) {
            $(obj).parents('tr').detach();
        } else {
            myConfirm("Apakah anda yakin akan menghapus data sampel ini?", "Perhatian!", function (r) {
                if (r) {
                    $.post('<?php echo $this->createUrl('ajaxDeleteDataSample') ?>', {id: id}, function (data) {
                        if (data.success)
                        {
                            $(obj).parents('tr').detach();
                            myAlert('Data berhasil dihapus !!');
                        } else {
                            myAlert('Data Gagal dihapus');
                        }
                    }, 'json');
                }
            });
    }

    }


    function renameInput() {
        var row = 0;
        var obj_table = '#data-sample';
        $(obj_table).find("tbody > tr").each(function () {

            $(this).find('input,select,textarea').each(function () { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 3) {
                    $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
                    $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
                }
            });
            $(this).find('span.add-on').each(function () {
                var old_name = $(this).parent('.input-append').find('input').attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                var id_span = '';
                if (old_name_arr.length == 3) {
                    id_span = old_name_arr[0] + "_" + row + "_" + old_name_arr[2] + "_date";
                    id = old_name_arr[0] + "_" + row + "_" + old_name_arr[2];
                    registerDateJs(id, id_span);
                }
            });

            $(this).find('a.accordion-toggle').each(function () {
                var old_name = $(this).attr("href");
                var old_name_arr = old_name.split("-");

                $(this).attr("href", old_name_arr[0] + '-' + old_name_arr[1] + '-' + row);

            });

            $(this).find('div.accordion-body').each(function () {
                var old_name = $(this).attr("id");
                var old_name_arr = old_name.split("-");

                $(this).attr("id", old_name_arr[0] + '-' + old_name_arr[1] + '-' + row);

            });
            row++;
        });
    }

    function registerDateJs(id, id_span) {
        jQuery('#' + id).datetimepicker(jQuery.extend({showMonthAfterYear: false}, jQuery.datepicker.regional['id'], {'dateFormat': 'dd M yy', 'maxDate': 'd', 'timeText': 'Waktu', 'hourText': 'Jam', 'minuteText': 'Menit', 'secondText': 'Detik', 'showSecond': true, 'timeOnlyTitle': 'Pilih Waktu', 'timeFormat': 'hh:mm:ss', 'changeYear': true, 'changeMonth': true, 'showAnim': 'fold', 'yearRange': '-80y:+20y'}));
        jQuery('#' + id_span).on('click', function () {
            jQuery('#' + id).datepicker('show');
        });
    }

    $(document).ready(function () {
        $('form').bind('click keyup select change', function (event) {
            cekDisabled(this);
        });
        $(document).on('click keyup select change', function () {
            cekDisabled('form');
        });
        cekDisabled('form');
    });

</script>
<?php
$jscript = <<< JS
function enableInputSample(obj)
{
    
}
JS;
Yii::app()->clientScript->registerScript('enabledKirimSample', $jscript, CClientScript::POS_HEAD);

$enableInputSample = ($modKirimSample->isKirimSample) ? 1 : 0;
$js = <<< JS

JS;
Yii::app()->clientScript->registerScript('ready', $js, CClientScript::POS_READY);
?>