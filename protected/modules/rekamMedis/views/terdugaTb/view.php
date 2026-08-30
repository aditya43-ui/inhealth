<?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'id' => 'terdugatb-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
        'focus' => '#RKAnamnesaT_keluhanutama_annoninput .maininput',
    ));
?>
<style>
    body {
        color: black;
    }

    .base_det .det_label, .base_det .det_label2 {
        vertical-align: top;
    }
    
    .det_label {
        display: inline-block;
        width: 150px;
    }
    
    .det_val {
        display: inline-block;
        width: calc(100% - 155px);
    }
    
    .det_label2 {
        display: inline-block;
        width: 150px;
    }
    
    .det_val2 {
        display: inline-block;
        width: calc(100% - 155px);
    }
</style>
<div class="row">
    <div class="panel panel-gradient">
        <div class="panel-heading">
            <div class="panel-title">
                Terduga TB
            </div>
        </div>
        <div class="panel-body">

            <div class="row">
                <div class="col-md-6">
                    <div class="control-group">
                        <div class="base_det">
                            <div class="det_label">Tgl. Terduga TB </div>
                            <div class="det_val">: 
                                <?php
                                    echo MyFormatter::formatDateTimeForUser($modTerdugaTb->tglterdugatb);
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="base_det">
                            <div class="det_label">Lokasi Anatomi Penyakit </div>
                            <div class="det_val">: 
                                <?php
                                    echo $modTerdugaTb->lokasianatomipenyakit;
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="base_det">
                            <div class="det_label">Total Skoring TB Anak </div>
                            <div class="det_val">: 
                                <?php
                                    echo $modTerdugaTb->totalskorintbanak;
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="base_det">
                            <div class="det_label">Hasil Pemeriksaan Foto Torax </div>
                            <div class="det_val">: 
                                <?php
                                    echo $modTerdugaTb->hasilfototorax;
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="control-group">
                        <div class="base_det">
                            <div class="det_label">Status HIV </div>
                            <div class="det_val">: 
                                <?php
                                    echo $modTerdugaTb->statushiv;
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="base_det">
                            <div class="det_label">Riwayat Penyakt Terdahulu </div>
                            <div class="det_val">: 
                                <?php
                                    echo $modTerdugaTb->riwayatpenyaktterdahulu;
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="base_det">
                            <div class="det_label">Pemeriksaan </div>
                            <div class="det_val">: 
                                <?php
                                    echo strtoupper($modTerdugaTb->jenis_pemeriksaan);
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row" style="margin-top: 20px;">
                <div class="col-md-12">
                    <div class="panel panel-gradient">
                        <div class="panel-heading" style="display: flex;">
                            <div class="panel-title">
                                <i></i> Pengambilan Contoh Uji dan Pemeriksaan Mikroskopis
                            </div>
                            <div class="panel-title" style="text-align: right; margin: 3px;">
                                <i class="entypo-minus row_3" style="cursor: pointer;"></i>
                            </div>
                        </div>
                        <div class="panel-body" id="row_3" style="display: block;">             
                            <table class="table" id="tablePengalamanOrganisasi" style="padding-left: 0; padding-right: 0;">
                                <thead>
                                    <tr>
                                        <th rowspan="2">Tanggal Pengambilan</th>
                                        <th rowspan="2">Tanggal Hasil Diperoleh</th>
                                        <th rowspan="2">Hasil</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        foreach($modUjiTerdugaTb as $mut){
                                    ?>
                                    <tr>
                                        <td>
                                            <?php
                                                echo MyFormatter::formatDateTimeForUser($mut->tglpengambilan);
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                                echo MyFormatter::formatDateTimeForUser($mut->tglhasil);
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                                echo $mut->hasil;
                                            ?>
                                        </td>
                                    </tr>
                                    <?php
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row" style="margin-top: 20px;">
                <div class="col-md-6">
                    <div class="panel panel-gradient">
                        <div class="panel-heading">
                            <div class="panel-title">
                                Xpert MTB/RIF
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="control-group">
                                <div class="base_det">
                                    <div class="det_label">Tgl. Hasil Diperoleh </div>
                                    <div class="det_val">: 
                                        <?php
                                            echo MyFormatter::formatDateTimeForUser($modTerdugaTb->tglhasil_xpertmtbrif);
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="control-group">
                                <div class="base_det">
                                    <div class="det_label">Hasil </div>
                                    <div class="det_val">: 
                                        <?php
                                            echo $modTerdugaTb->hasil_xpertmtbrif;
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="panel panel-gradient">
                        <div class="panel-heading">
                            <div class="panel-title">
                                Biakan
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="control-group">
                                <div class="base_det">
                                    <div class="det_label">Tgl. Hasil Diperoleh </div>
                                    <div class="det_val">: 
                                        <?php
                                            echo MyFormatter::formatDateTimeForUser($modTerdugaTb->tglhasil_biakan);
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="control-group">
                                <div class="base_det">
                                    <div class="det_label">Hasil </div>
                                    <div class="det_val">: 
                                        <?php
                                            echo $modTerdugaTb->hasil_biakan;
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row" style="margin-top: 20px; margin-bottom: 20px;">
                <div class="col-md-12">
                    <div class="panel panel-gradient">
                        <div class="panel-heading" style="display: flex;">
                            <div class="panel-title">
                                <i></i> Kesimpulan dan Tindak Lanjut
                            </div>
                            <div class="panel-title" style="text-align: right; margin: 3px;">
                                <i class="entypo-minus row_5" style="cursor: pointer;"></i>
                            </div>
                        </div>
                        <div class="panel-body" id="row_5" style="display: block;">
                            <div class="col-md-6">
                                <div class="control-group">
                                    <div class="base_det">
                                        <div class="det_label">Kesimpulan </div>
                                        <div class="det_val">: 
                                            <?php
                                                echo $modTerdugaTb->kesimpulan;
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <div class="base_det">
                                        <div class="det_label">Tgl. Mulai Pengobatan TB </div>
                                        <div class="det_val">: 
                                            <?php
                                                echo MyFormatter::formatDateTimeForUser($modTerdugaTb->tglmulaipengobatan);
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <div class="base_det">
                                        <div class="det_label">Tgl. Selesai Pengobatan TB </div>
                                        <div class="det_val">: 
                                            <?php
                                                echo MyFormatter::formatDateTimeForUser($modTerdugaTb->tglselesaipengobatan);
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="control-group">
                                    <div class="base_det">
                                        <div class="det_label">Rujukan Keluar </div>
                                        <div class="det_val">: 
                                            <?php
                                                $r = RujukankeluarM::model()->findByPk($modTerdugaTb->rujukankeluar_id);
                                                echo $r->rumahsakitrujukan;
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <div class="base_det">
                                        <div class="det_label">Keterangan </div>
                                        <div class="det_val">: 
                                            <?php
                                                echo $modTerdugaTb->keterangan;
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php
                echo CHtml::link('Kembali', $this->createUrl('index', array('pendaftaran_id' => $modPendaftaran->pendaftaran_id)), array(
                    'class'=>'btn btn-danger'
                )); 
            ?>

        </div>
    </div>
</div>
<?php $this->endWidget(); ?>
<script>
    $(".row_3").click(function () {
        $('#row_3').slideToggle();
    });
    $(".row_5").click(function () {
        $('#row_5').slideToggle();
    });
</script>