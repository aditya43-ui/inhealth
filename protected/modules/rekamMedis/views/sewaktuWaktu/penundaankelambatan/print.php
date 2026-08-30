<style>
    .border_c{
        border:1px solid;
    }

    .spasi{
        height:10px;
    }

    .table_isi, tr, td{
        padding:5px;
    }

    .table_isi, tr, td, p{
        color : black;
    }

    p{
        color : black;
    }
</style>

<b>FRM/ 118 / RSBM</b>
<?php echo $this->renderPartial($this->path_view.'_headerPrint', array('model'=>$model, 'modPendaftaran'=>$modPendaftaran,
                'modPasien'=>$modPasien,
                'judul'=>$judul)); ?>


<table width="100%" border="1px">
    <tr>
        <td width="65%">
            <p>Unit : <?= $model->unit;?></p>
            <p>Diagnosa Utama : <?php foreach ($modDiagnosa as $key => $value) {
								if ($value->kelompokdiagnosa_id == Params::KELOMPOKDIAGNOSA_UTAMA){
									echo $value->diagnosa->diagnosa_kode." ".$value->diagnosa->diagnosa_nama;
								}
							}?></p>
            <p>Diagnosa Tambahan : <?php foreach ($modDiagnosa as $key => $value) {
								if ($value->kelompokdiagnosa_id == Params::KELOMPOKDIAGNOSA_TAMBAH){
									echo $value->diagnosa->diagnosa_kode." ".$value->diagnosa->diagnosa_nama;
								}
							}?></p>
        </td>
        <td style="vertical-align:top">
            <p>Hari/Tanggal : <?= MyFormatter::getDayName($model->tanggal_pengisian)." / ".MyFormatter::formatdatetimeforuser($model->tanggal_pengisian);?></p>
            <p>Pukul : <?= $model->pukul;?></p>
        </td>
    </tr>
</table>


<table border="1px" width="100%">
    <tr>
        <td>
            

            <div style="min-height:700px; margin-left:30px; margin-right:30px;">
                <br><br>
                <p>1. Pelayanan/tindakan yang mengalami penundaan atau keterlambatan</p>
                <table border="1px" width="100%">
                    <tr>
                        <td><div style="min-height:100px;"><?= $model->pelayanantindakan;?></div></td>
                    </tr>
                </table>

                <br><br>
                <p>2. Alasan/Penyebab Penundaan atau Keterlambatan pelayanan/tindakan</p>
                <table border="1px" width="100%">
                    <tr>
                        <td><div style="min-height:100px;"><?= $model->alasanpenundaan;?></div></td>
                    </tr>
                </table>

                <br><br>
                <p>3. Solusi Alternatif Lain beserta waktu Pelayanan/tindakan dapat dilaksanakan kembali</p>
                <table border="1px" width="100%">
                    <tr>
                        <td><div style="min-height:100px;"><?= $model->solusialternatif;?></div></td>
                    </tr>
                </table>
                
                <br><br>
                <table width="100%">
                    <tr>
                        <td width="33%" style="text-align:center;"></td>
                        <td width="33%" style="text-align:center;">Singaraja, <?= MyFormatter::formatdatetimeforuser($model->tanggal_pengisian)." ".$model->pukul;?></td>
                        
                    </tr>
                    <tr>
                        <td width="33%" style="text-align:center;"><?= $model->penerima_informasi;?></td>
                        <td width="33%" style="text-align:center;"><?= $model->pemberi_informasi;?></td>
                        
                    </tr>
                    <tr>
                        <td colspan="3">
                            <div style="min-height:50px;">
                                
                            </div>
                        </td>
                    </tr>
                    
                    <tr>
                        <td style="text-align:center;">( <u><?= $model->nama_penerima;?></u> )</td>
                        <td style="text-align:center;">( <u><?= $model->petugas->NamaLengkap;?></u> )</td>
                        
                    </tr>
                    <tr>
                        <td style="text-align:center;"></td>
                        <td style="text-align:center;">NIP : ( <?= $model->petugas->nomorindukpegawai;?> )</td>
                        
                    </tr>
                
                </table>
                <br><br>
            </div>
            
        
        </td>
    </tr>

</table>

