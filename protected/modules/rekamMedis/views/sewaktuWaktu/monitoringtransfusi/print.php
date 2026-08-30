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

    .table_serah{
        text-align:center;
    }

    .judul_table{
        text-align:center;
    }
</style>

<!-- <b>FRM/123/RSBM</b> -->
<?php echo $this->renderPartial($this->path_view.'_headerPrint', array('model'=>$model, 'modPendaftaran'=>$modPendaftaran,
                'modPasien'=>$modPasien,
                'judul'=>$judul)); ?>


<table border="1px" width="100%">
    <tr>
        <td>Tanggal <?= MyFormatter::formatdatetimeforuser($model->create_time);?></td>
    </tr>
    <tr>
        <td>Waktu Serah Terima : <?php $tgl_serah = SerahterimaT::model()->findByAttributes(array('monitoringtranfusidarah_id'=>$model->monitoringtranfusidarah_id));
            echo isset($tgl_serah->create_time) ? Date('G:i:s',strtotime($tgl_serah->create_time)) : '';
        ?> WITA</td>
    </tr>
    <tr>
        <td>
            <table width="100%" border="1px" class="table_serah">
                <tr>
                    <td width="30%">Serah Terima</td>
                    <td width="50%">Penjelasan</td>
                    <td width="10%">Petugas Bank Darah</td>
                    <td width="10%">Perawat</td>
                </tr>
                <?php foreach($modSerahTerima as $serah){?>
                    <tr>
                        <td><?= $serah->nama_serahterima;?></td>
                        <td><?= $serah->penjelasan;?></td>
                        <td><?php if($serah->is_petugasbankdarah == true){?>
                            <span style="padding-right: 10px;" class="fa fa-check"></span>
                        <?php }else{?>
                            <span style="padding-right: 10px;" class="fa fa-minus"></span>
                        <?php }?>
                        </td>
                        <td><?php if($serah->is_perawat == true){?>
                            <span style="padding-right: 10px;" class="fa fa-check"></span>
                        <?php }else{?>
                            <span style="padding-right: 10px;" class="fa fa-minus"></span>
                        <?php }?>
                        </td>
                    </tr>
                <?php }?>
                <tr>
                    <td colspan="2">Tanda Tangan</td>
                    <td><div style="height:100px;"></div></td>
                    <td></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td>
            Waktu Transfusi Dimulasi : <?php $tgl_serah = TransfusidarahT::model()->findByAttributes(array('monitoringtranfusidarah_id'=>$model->monitoringtranfusidarah_id));
            echo isset($tgl_serah->create_time) ? Date('G:i:s',strtotime($tgl_serah->create_time)) : '-';
        ?> WITA
        </td>
    </tr>
    <tr>
        <td>
            <table width="100%" border="1px">
                <tr>
                    <td class="judul_table">Kondisi</td>
                    <?php foreach($modTransfusi as $tranfusi){?>
                        <td class="judul_table"><?= $tranfusi->waktu_tranfusi." <br>".$tranfusi->jam_transfusi;?></td>
                    <?php }?>
                </tr>
                <?php foreach($modTransfusi as $i => $tranfusi){?>
                    <tr>
                        <td><?= $tranfusi->kondisi_transfusidarah;?></td>
                        <?php foreach($modTransfusi as $a => $tran){?>
                        <?php if ($i == $a){?>
                            <td><?= $tran->deskripsi;?></td>
                        <?php } else {?>
                            <td></td>
                        <?php }
                        }
                        ?>
                    </tr>
                   
                <?php }?>
                <tr>
                    <td>Tanda Reaksi Transfusi</td>
                    <?php foreach($modTransfusi as $tranfusi){?>
                        <td><?php 
                            $modTransDet = TransfusidarahdetT::model()->findAllByAttributes(array('transfusidarah_id'=>$tranfusi->transfusidarah_id));
                            foreach ($modTransDet as $c => $det){
                                echo $det->nama_tandareaksi."<br>"; 
                            }?></td>
                    <?php }?>
                </tr>
                <tr>
                    <td>Nama Petugas</td>
                        <?php foreach($modTransfusi as $tranfusi){?>
                        <td><?= $tranfusi->petugas;?></td>
                        <?php }?>
                </tr>
                <tr>
                    <td>Tanda Tangan</td>
                        <?php foreach($modTransfusi as $tranfusi){?>
                        <td><div style="height:100px;"></div></td>
                        <?php }?>
                </tr>
            </table>
        </td>
    </tr>
    
    
</table>

