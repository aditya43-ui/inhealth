<?php $data=ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());?>
<head>
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/entypo/css/entypo.css">
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/font-awesome/css/font-awesome.css">
</head>

<style>
    
    .panel_print {
        width: 100%;
        border: 1px solid black;
        margin-bottom: 15px;
    }
    
    .panel_print_judul {
        padding: 5px;
        font-weight: bold;
        border-bottom: 1px solid black;
    }
    
    .panel_print_content {
        padding: 5px;
    }
    
    .row {
        margin-left: -5px;
        margin-right: -5px;
        clear: both;
    }
    
    .col-sm-6 {
        float: left;
        width: 50%;
        position: relative;
        min-height: 1px;
        padding-left: 5px;
        padding-right: 5px;
        box-sizing: border-box;
    }
    
    .tab_detail, .tab_list {
        width: 100%;
    }
    
    .tab_detail th, .tab_detail td {
        border: 1px solid black;
        padding: 3px;
        vertical-align: top;
    }
    
    .tab_list td {
        padding: 3px;
        vertical-align: top;
    }

    .garis-panjang {
        border-top: 1px black solid;
		height: 0px;
		width: 90%;
    }

    .garis-pendek {
        border-top: 1px black solid;
		height: 0px;
		width: 30%;
    }
    
</style>


<?php

echo $this->renderPartial('_headerSurat',array( 'colspan'=>'','modPasien'=>$modPasien,'modPendaftaran'=>$modPendaftaran));  

?>

<h3 style="text-align: center;">LAPORAN OPERASI</h3>

<table class="tab_list">
            <tr>
                <td width="15%">Nama Operator</td>
                <td width="5%">:</td>
                <td width="85%"><?php echo $rencana->dokter1->NamaLengkap; ?>
                <div class="garis-pendek"></div></td>
            </tr>
            <tr>
                <td>Asisten Anastesi</td>
                <td>:</td>
                <td><?php echo isset($rencana->paramedis->NamaLengkap)?$rencana->paramedis->NamaLengkap:"-"; ?>
                <div class="garis-pendek"></div></td>
            </tr>
            <tr>
                <td>Jenis Anastesi</td>
                <td>:</td>
                <td>
                <?php 
                $look_data = JenisAnastesiM::model()->findAll('jenisanastesi_aktif = true order by jenisanastesi_id ');
                
                foreach ($look_data as $item):  ?>
                
                <div class="control-group pilihan_text_main" style="display: inline-block; width: 15%;">
                            <?php 

                            $isceklis = 'T';?>
                            <table>
                                <tr>
                                    <td>
                                
                                        <span class="<?php echo (($anestesi->jenisanastesi_id == $item->jenisanastesi_id)?"fa fa-dot-square-o":"fa fa-square-o"); ?>"></span>
                                    </td>
                                    <td style="width:150px;">
                                        <label><?php echo $item->jenisanastesi_nama;?></label>
                                    </td>
                                    
                                    <td>
                                   
                                    </td>
                                </tr>
                            </table>
                            
                </div>
                <?php endforeach; ?>
                
                </td>
                
            </tr>
            <tr>
                <td>Kualifikasi Luka Operasi</td>
                <td>:</td>
                <td>
                <?php 
                $look_data = LookupM::getItemsUrutan('kualifikasioperasi');
                
                foreach ($look_data as $item):  ?>
                
                <div class="control-group pilihan_text_main" style="display: inline-block; width: 15%;">
                            <?php 

                            $isceklis = 'T';?>
                            <table>
                                <tr>
                                    <td>
                                        <span class="<?php
                                        if(!empty($modSpesimen->kualifikasi_operasi)){
                                            echo (($modSpesimen->kualifikasi_operasi == $item)?"fa fa-check-square-o":"fa fa-square-o");
                                        } 
                                         ?>"></span>
                                    </td>
                                    <td style="width:150px;">
                                        <label><?php echo $item;?></label>
                                    </td>
                                    
                                    <td>
                                   
                                    </td>
                                </tr>
                            </table>
                            
                </div>
                <?php endforeach; ?>
                </td>
            </tr>
            <tr>
                <td>Jenis Operasi</td>
                <td>:</td>
                <td><?php echo (empty($rencana) || empty($rencana->operasi) || empty($rencana->operasi->kegiatanoperasi)) ? "-" : ($rencana->operasi->kegiatanoperasi->kegiatanoperasi_nama); ?>
                <div class="garis-pendek"></div></td>
            </tr>
            <tr>
                <td>Kualifikasi Luka Operasi</td>
                <td>:</td>
                <td>
                <?php 
                $look_data = LookupM::getItemsUrutan('kualifikasilukaoperasi');
                
                foreach ($look_data as $item):  ?>
                
                <div class="control-group pilihan_text_main" style="display: inline-block; width: 35%;">
                            <?php 

                            $isceklis = 'T';?>
                            <table>
                                <tr>
                                    <td>
                                    <span class="<?php 
                                    if(!empty($modSpesimen->kualifikasiluka_operasi)){
                                        echo (($modSpesimen->kualifikasiluka_operasi == $item)?"fa fa-check-square-o":"fa fa-square-o");
                                    }
                                     ?>"></span>
                                    </td>
                                    <td style="width:250px;">
                                        <label><?php echo $item;?></label>
                                    </td>
                                    
                                    <td>
                                   
                                    </td>
                                </tr>
                            </table>
                            
                </div>
                <?php endforeach; ?>
                </td>
            </tr>
            <tr>
                <td>Diagnosa Pra Bedah</td>
                <td>:</td>
                <td><?php echo (empty($diagnosa) ? "" : ($diagnosa->diagnosa->diagnosa_kode . " - " . $diagnosa->diagnosa->diagnosa_nama)); ?>
                <div class="garis-panjang"></div></td>
            </tr>
            <tr>
                <td>Diagnosa Pasca Bedah</td>
                <td>:</td>
                <td><?php 
                        $signout = OperasisignoutT::model()->findByAttributes(array(
                            'pasienmasukpenunjang_id' => $penunjang->pasienmasukpenunjang_id,
                        ));
                        echo empty($signout->signout_diagnosapostop) ? "-" : ($signout->signout_diagnosapostop);
                        
                        ?>
                <div class="garis-panjang"></div></td>
            </tr>
            <tr>
                <td>Indikasi Operasi</td>
                <td>:</td>
                <td><?php echo (empty($modSpesimen->indikasi_operasi) ? "-" : ($modSpesimen->indikasi_operasi)); ?>
                <div class="garis-panjang"></div>
                </td>
            </tr>
            <tr>
                <td>Jaringan yang dieksisi/insisi</td>
                <td>:</td>
                <td><?php echo isset($modSpesimen->lokasipengambilanspesimen)? $modSpesimen->teknik->teknikpengambilanspesimen_nama.' / '.$modSpesimen->lokasipengambilanspesimen: "-"; ?>
                <div class="garis-panjang"></div>
                </td>
            </tr>
            
            <tr>
                <td>Dikirim u/Pemeriksaan PA</td>
                <td>:</td>
                <td>
                            <table>
                                <tr>
                                    <?php if(!empty($modSpesimen->statuskirim_pa)){?>
                                    <td style="width:100px;">
                                        <span class="<?php echo (($modSpesimen->statuskirim_pa == 'Ya')?"fa fa-check-square-o":"fa fa-square-o"); ?>"></span><label>Ya</label>
                                        
                                    </td>
                                    <td style="width:100px;">
                                    <span class="<?php echo (($modSpesimen->statuskirim_pa == 'Tidak')?"fa fa-check-square-o":"fa fa-square-o"); ?>"></span><label>Tidak</label>
                                    </td>
                                    <td style="width:450px;"><?php echo isset($modSpesimen->tujuanpengirimanspesimen_lainnya)?$modSpesimen->tujuanpengirimanspesimen_lainnya:"-"; ?>
                                    <div class="garis-pendek"></div></td>
                                    <?php }?>
                                </tr>
                            </table>
                </td>
            </tr>
        </table>
<table width="100%">
    <tr>
        <td style="width:25%; text-align:center;">Tanggal Operasi</td>
        <td style="width:25%; text-align:center;">Jam Operasi Mulai</td>
        <td style="width:25%; text-align:center;">Jam Operasi Selesai</td>
        <td style="width:25%; text-align:center;">Lama Operasi</td>
    </tr>
    <tr>
                        
        <td style="width:25%; text-align:center;"><?php echo MyFormatter::formatDateTimeForUser($model->tanggal_operasi); ?></td>
        <td style="width:25%; text-align:center;"><?php echo $model->jam_mulaioperasi; ?></td>
        <td style="width:25%; text-align:center;"><?php echo $model->jam_selesaioperasi; ?></td>
        <td style="width:25%; text-align:center;"><?php echo $model->lamaoperasi; ?></td>
    </tr>

</table>
<div class="panel_print">
    <div class="panel_print_judul">Laporan (Prosedur, Temuan Intra Operasi, dan Komplikasi)</div>
    <div class="panel_print_content">
        <?php echo $model->laporanoperasi; ?>
    </div>
</div>
<div class="panel_print">
    <div class="panel_print_judul">Laporan Laporan Pasca Operasi
</div>
    <div class="panel_print_content">
        <?php echo $model->laporanpascaoperasi; ?>
    </div>
</div>


<table width="100%">
    <tr>
        <td></td>
        <td width="300" style="text-align: center;">
            <?php echo strtoupper($data->kabupaten->kabupaten_nama); ?>, <?php echo empty($model->tanggalpengisian_laporanop) ? "-" : MyFormatter::formatDateTimeForUser(date('Y-m-d', strtotime($model->tanggalpengisian_laporanop))); ?>
            <br/>
            Ahli Bedah
            <br/>
            <br/>
            <br/>
            <br/>
            <br/>
            <?php echo empty($model->dokterbedahPengisilaporan) ? "-" : $model->dokterbedahPengisilaporan->namaLengkap; ?>
        </td>
    </tr>
</table>
        