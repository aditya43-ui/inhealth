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
        width: calc(100% - 100px);
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
<div style="padding: 20px">
    <div>
        <div class="panel-heading">
            <div class="panel-title" style="text-align: center">
                <h2>TERDUGA TB</h2>
            </div>
        </div>
        <div class="panel-body">

            <div style="margin-top: 30px; display:flex; justify-content: space-between;">
                <div>
                    <div class="control-group">
                        <div style="display:flex;">
                            <div style="width: 150px;">Tgl. Terduga TB</div>
                            <div> : 
                                <?php
                                    echo MyFormatter::formatDateTimeForUser($modTerdugaTb->tglterdugatb);
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="control-group">
                        <div style="display:flex;">
                        <div style="width: 150px;">Lokasi Anatomi Penyakit</div>
                            <div> : 
                                <?php
                                    echo $modTerdugaTb->lokasianatomipenyakit;
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="control-group">
                        <div style="display:flex;">
                        <div style="width: 150px;">Total Skoring TB Anak</div>
                            <div> : 
                                <?php
                                    echo $modTerdugaTb->totalskorintbanak;
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="control-group">
                        <div style="display:flex;">
                        <div style="width: 150px;">Hasil Pemeriksaan Foto Torax</div>
                            <div> : 
                                <?php
                                    echo $modTerdugaTb->hasilfototorax;
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="control-group">
                            <div style="display:flex;">
                            <div style="width: 150px;">Status HIV</div>
                                <div> : 
                                    <?php
                                        echo $modTerdugaTb->statushiv;
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="control-group">
                            <div style="display:flex;">
                            <div style="width: 150px;">Riwayat Penyakt Terdahulu</div>
                                <div> : 
                                    <?php
                                        echo $modTerdugaTb->riwayatpenyaktterdahulu;
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="control-group">
                            <div style="display:flex;">
                            <div style="width: 150px;">Pemeriksaan</div>
                                <div> : 
                                    <?php
                                        echo strtoupper($modTerdugaTb->jenis_pemeriksaan);
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div style="margin-top: 20px;">
                <div class="col-md-12">
                    <div class="panel panel-gradient">
                        <div class="panel-heading" style="display: flex;">
                            <div class="panel-title">
                                <h4>Pengambilan Contoh Uji dan Pemeriksaan Mikroskopis</h4>
                            </div>
                        </div>
                        <div class="panel-body" id="row_3">             
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Tanggal Pengambilan</th>
                                        <th>Tanggal Hasil Diperoleh</th>
                                        <th>Hasil</th>
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

            <div style="margin-top: 20px; display: flex; justify-content: center;">
                <div class="col-md-6" style="width: 100%;">
                    <div style="border: 1px solid black; padding: 5px; margin-right: 5px;" class="panel panel-gradient">
                        <div style="border-bottom: 1px solid black;" class="panel-heading">
                            <div class="panel-title" style="margin: 5px 0;">
                                <h4>Xpert MTB/RIF</h4>
                            </div>
                        </div>
                        <div class="panel-body" style="margin: 5px 0;">
                            <div class="control-group">
                                <div style="display:flex;">
                                    <div style="width: 150px;">Tgl. Hasil Diperoleh</div>
                                    <div> : 
                                        <?php
                                            echo MyFormatter::formatDateTimeForUser($modTerdugaTb->tglhasil_xpertmtbrif);
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="control-group">
                                <div style="display:flex;">
                                    <div style="width: 150px;">Hasil</div>
                                    <div> : 
                                        <?php
                                            echo $modTerdugaTb->hasil_xpertmtbrif;
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6" style="width: 100%;">
                    <div style="border: 1px solid black; padding: 5px; margin-left: 5px;" class="panel panel-gradient">
                        <div style="border-bottom: 1px solid black;" class="panel-heading">
                            <div class="panel-title" style="margin: 5px 0;">
                                <h4>Biakan</h4>
                            </div>
                        </div>
                        <div class="panel-body" style="margin: 5px 0;">
                            <div class="control-group">
                                <div style="display:flex;">
                                    <div style="width: 150px;">Tgl. Hasil Diperoleh</div>
                                    <div> : 
                                        <?php
                                            echo MyFormatter::formatDateTimeForUser($modTerdugaTb->tglhasil_biakan);
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="control-group">
                                <div style="display:flex;">
                                    <div style="width: 150px;">Hasil</div>
                                    <div> : 
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

            <div style="margin-top: 20px; margin-bottom: 20px;">
                <div class="col-md-12">
                    <div style="border: 1px solid black; padding: 5px;" class="panel panel-gradient">
                        <div style="border-bottom: 1px solid black;" class="panel-heading">
                            <div class="panel-title" style="margin: 5px 0;">
                                <h4>Kesimpulan dan Tindak Lanjut</h4>
                            </div>
                        </div>
                        <div class="panel-body" style="margin: 5px 0; display: flex; justify-content: space-between;">
                            <div class="col-md-6">
                                <div class="control-group">
                                    <div style="display:flex;">
                                        <div style="width: 150px;">Kesimpulan</div>
                                        <div> : 
                                            <?php
                                                echo $modTerdugaTb->kesimpulan;
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <div style="display:flex;">
                                        <div style="width: 150px;">Tgl. Mulai Pengobatan TB</div>
                                        <div> : 
                                            <?php
                                                echo MyFormatter::formatDateTimeForUser($modTerdugaTb->tglmulaipengobatan);
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <div style="display:flex;">
                                        <div style="width: 150px;">Tgl. Selesai Pengobatan TB</div>
                                        <div> : 
                                            <?php
                                                echo MyFormatter::formatDateTimeForUser($modTerdugaTb->tglselesaipengobatan);
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="control-group">
                                    <div style="display:flex;">
                                        <div style="width: 150px;">Rujukan Keluar</div>
                                        <div> : 
                                            <?php
                                                $r = RujukankeluarM::model()->findByPk($modTerdugaTb->rujukankeluar_id);
                                                echo $r->rumahsakitrujukan;
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <div style="display:flex;">
                                        <div style="width: 150px;">Keterangan</div>
                                        <div> : 
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
        </div>
    </div>
</div>