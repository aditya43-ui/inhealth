<style>
    .tab_detail {
        width: 100%;
    }
    
    .tab_detail th, .tab_detail td {
        border: 1px solid black;
    }
</style>
<table style="width: 100%; border: none;">
    <thead>
        <tr>
             <td>
                <div class="header"><?php
                    echo $this->renderPartial('application.views.headerReport.headerDefaultNewest', array());
                    ?></div>  
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <div class="content">
                        <br>
			<div class="judulcontent">  </div>
                        <br>
                       
<table width="74%" style="margin: 0;" cellpadding="0" cellspacing="0">
    <tr>
            <td width="20%">No. Rencana</td>
            <td>:</td>
            <td><?php echo $model->norencana; ?></td>
        </tr>    
    <tr>
            <td>Tanggal Rencana Lembur</td>
            <td>:</td>
            <td><?php echo MyFormatter::formatDateTimeForUser($model->tglrencana); ?></td>
    </tr>
    <tr>
            <td>Pemberi Tugas</td>
            <td>:</td>
            <td><?php echo (isset($model->pemberitugas_id) ? PegawaiM::model()->findByPk($model->pemberitugas_id)->nama_pegawai:""); ?></td>
    </tr>
    <tr>
            <td>Keterangan</td>
            <td>:</td>
            <td><?php echo $model->keterangan; ?></td>
    </tr>
    </table><br>
    <table id="tabelPegawaiLembur" class="tab_detail">
        <thead >
            <th width="20%" style="text-align: center;">No.</th>
            <th>No. Induk Pegawai</th>
            <th>Nama Pegawai</th>
            <!--<th>Jabatan</th>-->
            <th>Jam Mulai</th>
            <th>Jam Selesai</th>
            <th>Jenis Lembur</th>
            <th>Alasan Lembur</th>
        </thead>
        <tbody>
        <?php
            $tr = '';
            $no = 1;
            $format = new MyFormatter;
           if(count((array)$rencana) > 0){
                foreach($rencana AS $key=> $modDetail){
                            $rencana[$key]->jamMulai = date('H:i', strtotime($rencana[$key]->tglmulai));
                            $rencana[$key]->jamSelesai = date('H:i', strtotime($rencana[$key]->tglselesai));
							$lembur = BiayalemburM::model()->findByPk($modDetail->biayalembur_id);
                            $tr.="<tr>
                               <td style='text-align: center;'>".$no++."</td>
                               <td >".$rencana[$key]->pegawai->nomorindukpegawai."</td>
                               <td >".$rencana[$key]->pegawai->nama_pegawai."</td>
                               <td>".$rencana[$key]->jamMulai."</td>
                               <td>".$rencana[$key]->jamSelesai."</td>
                               <td>".$lembur->biayalembur_nama."</td>
                               <td>".$rencana[$key]->alasanlembur."</td>
                               </tr>   
                           "; // <td>".$modDetail[$key]->pegawai->departement->departement_nama."</td>

                     }
                     echo $tr;
                
            }
            ?>
    </tbody>
    </table>
		</div>		
            </td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td>
                <div class="footer-space">&nbsp;</div>
            </td>
        </tr>
    </tfoot>
</table>
<div class="">
</div>
<div class="footer">
    <?php   if (isset($caraPrint) && $caraPrint!="PDF"){  ?>
    <?php echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
    <?php  }  ?>
</div>   