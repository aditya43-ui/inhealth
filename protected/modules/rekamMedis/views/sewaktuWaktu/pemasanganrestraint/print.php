<style>
    .border_c{
        border:1px solid;
    }

    .border_a{
        border:1px solid;
        border-top: none;
        border-left: none;
        border-right: none;
    }

    .spasi{
        height:10px;
    }

    .table_isi, tr, td{
        padding:5px;
    }

    #riwayatrestrain tr td{
		text-align:center;
	}

	#riwayatrestrain .kesadaran{
		text-align:left;
	}

	.keterangan{
		border:1px solid;
		width:60%;
		min-height:100px;
		margin-bottom : 20px;
		padding : 5px;
	}
</style>

<!-- <b>FRM/123/RSBM</b> -->
<?php echo $this->renderPartial($this->path_view.'_headerPrint', array('model'=>$model, 'modPendaftaran'=>$modPendaftaran,
                'modPasien'=>$modPasien,
                'judul'=>$judul)); ?>


<table border="1px" width="100%">
    <tr>
        <td>
            <table border="1px" width="100%" id="riwayatrestrain">
                <tr>
                <th rowspan="2">No.</th>
                <th rowspan="2">Tanggal</th>
                <th rowspan="2">Jam</th>
                <th colspan="5">TTV</th>
                <th colspan="4">Luka Restraint</th>
                <th rowspan="2">Luka</th>
                <th rowspan="2">Nama Perawat</th>
                <th rowspan="2" width="150px">Paraf</th>
            </tr>
            <tr>
                <th>Kesadaran</th>
                <th>TD</th>
                <th>HR</th>
                <th>RR</th>
                <th>S</th>
                <th>Taka</th>
                <th>Taki</th>
                <th>Kaka</th>
                <th>Kaki</th>

            </tr>
            <?php 
                $no = 1;
                foreach($model as $obser){?>
                    <?php $modDetail = ObservasipemasanganrestraindetT::model()->findAllByAttributes(array('observasipemasanganrestrain_id'=>$obser->observasipemasanganrestrain_id));?>
                    <?php foreach($modDetail as $data){?>
                        <tr>
                            <td><?= $no;?></td>
                            <td><?= MyFormatter::formatdatetimeid($obser->tanggal);?></td>
                            <td><?= $obser->jam;?></td>
                            <td class="kesadaran"> <?php echo $data->kes; ?> </td>       
                            <td> <?php echo $data->td; ?> </td>       
                            <td> <?php echo $data->hr; ?> </td>
                            <td> <?php echo $data->rr; ?> </td>
                            <td> <?php echo $data->s; ?> </td>
                            <td> <?php
                                if ($data->taka == true){
                                    echo '&#10004';
                                }?> 
                            </td>
                            <td> <?php 
                                if ($data->taki == true){
                                    echo '&#10004';
                                }?> 
                            </td>
                            <td> <?php 
                                if ($data->kaka == true){
                                    echo '&#10004';
                                } ?> 
                            </td>
                            <td> <?php 
                                if ($data->kaki == true){
                                    echo '&#10004';
                                }
                            ?> </td>    
                            <td> <?php echo $data->luka; ?> </td>    
                            <td><?= $obser->perawat_pengisi;?></td>
                            <td></td>
                        </tr>
                    <?php $no++;} ?>
            <?php }?>
            </table>
            <br><br>

            <div class="keterangan">
                <p>Ket :</p>
                <p>- Maksimal pemasangan restraint selama 24 jam
                <br>- Evaluasi/ Observasi pemasangan restraint dilakukan dalam jangka waktu
                <br>&nbsp;&nbsp;a. Setiap 4 jam pada pasien dewasa &#8805; 18 tahun ke atas
                <br>&nbsp;&nbsp;b. Setiap 2 jam pada pasien anak dan remaja usia 9-17 Tahun
                <br>&nbsp;&nbsp;c. Setiap 1 jam untuk anak < 9 tahun
                <br>&nbsp;&nbsp;d. Untuk pasien dalam kondisi destruktif evaluasi/observasi dilakukan setiap 1 jam setelah pemasangan restraint.</p>
                </p>
            </div>
        </td>

    </tr>
    
    
</table>

