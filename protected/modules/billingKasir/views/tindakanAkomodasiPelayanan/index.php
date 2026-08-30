<style>
    .tarif {
        color: red;
    }

    .yellow td {
        background-color: yellow !important;
    }
</style>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>

<?php
if (isset($_GET['pendaftaran_id']))
    // Yii::app()->user->setFlash('success', "Data tindakan berhasil disimpan!");
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Transaksi Akomodasi Pelayanan
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data Pasien
                </div>
            </div>
            <div class="panel-body">
                <form class="form-horizontal">
                <?php
                echo $this->renderPartial(
                    $this->path_view.'_ringkasDataPasien',
                    array(
                        'modPendaftaran' => $modPendaftaran,
                        'modPasien' => $modPasien
                    ), true
                );
                ?>
                </form>
            </div>
        </div>
        <div>
            <iframe class="biru" id="frame" src="" width='100%' frameborder="0" style="overflow-y:scroll; height: 600px"></iframe>
        </div>
    </div>
</div>
