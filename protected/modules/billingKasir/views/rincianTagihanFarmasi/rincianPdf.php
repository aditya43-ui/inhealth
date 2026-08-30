<style>
    .jarak{
        margin-top: 50px;
    }
    .grid{
        font-size:11px;
        /*font-family: tahoma;*/
        border: 1px solid;
        border-collapse: collapse;
    }
    .grid td,th{
        padding:4px;
    }
    .info{
        font-size:11px;
        /*font-family: tahoma;*/
    }
    .footer td{
        font-size:11px;
        /*font-family: tahoma;*/
    }
    .uang{
        text-align: right;
    }
</style>
<style>
   
                .border th, .border td{
                    border:1px solid #000;
                }
                .table thead:first-child{
                    border-top:1px solid #000;        
                }

                thead th{
                    background:none;
                    color:#333;
                }

                .border {
                    box-shadow:none;
                    border-spacing: 0;
                    padding: 0;
                }

                .table tbody tr:hover td, .table tbody tr:hover th {
                    background-color: none;
                }
            </style>

<table style="width: 100%; border: none;">
    <thead>
        <tr>
             <td>
                <div class="header"><?php
         
                    echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan'=>"RINCIAN BIAYA FARMASI"));
                 ?></div>  
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <div class="content">

<table width="100%" cellpadding="0" cellspacing="0" border="0" class="info">
    <tr>
        <td valign="top" width="18%">No. RM / No. Pend</td>
        <td valign="top" width="3%">:</td>
        <td valign="top" width="23%">
            <?php echo CHtml::encode($modPendaftaran->pasien->no_rekam_medik); ?> / 
            <?php echo CHtml::encode($modPendaftaran->no_pendaftaran); ?>            
        </td>
        <td valign="top">&nbsp;</td>
        <td valign="top" width="15%">Nama PJP</td>
        <td valign="top" width="3%">:</td>
        <td valign="top" width="32%">
            <?php
                if(strlen($modPendaftaran->penanggungjawab_id) > 0)
                {
                      echo CHtml::encode(isset($modPendaftaran->penanggungJawab->nama_pj) ? $modPendaftaran->penanggungJawab->nama_pj : '');
                }else{
                    echo CHtml::encode($modPendaftaran->pasien->nama_pasien);
                }
            ?>            
        </td>
    </tr>
    <tr>
        <td valign="top"><?php echo CHtml::encode($modPendaftaran->pasien->getAttributeLabel('nama_pasien')); ?></td>
        <td valign="top">:</td>
        <td valign="top">
            <?php echo CHtml::encode($modPendaftaran->pasien->nama_pasien); ?>       
        </td>
        <td valign="top">&nbsp;</td>
        <td valign="top">Alamat PJP</td>
        <td valign="top">:</td>
        <td valign="top">
            <?php
                if(strlen($modPendaftaran->penanggungjawab_id) > 0)
                {
                  echo CHtml::encode(isset($modPendaftaran->penanggungJawab->alamat_pj) ? $modPendaftaran->penanggungJawab->alamat_pj : '');
                  
                }else{
                    echo CHtml::encode($modPendaftaran->pasien->alamat_pasien);
                }
            ?>            
        </td>
    </tr>
    <tr>
        <td valign="top"><?php echo CHtml::encode($modPendaftaran->pasien->getAttributeLabel('jeniskelamin')); ?></td>
        <td valign="top">:</td>
        <td valign="top">
            <?php echo CHtml::encode($modPendaftaran->pasien->jeniskelamin); ?>
        </td>
        <td valign="top">&nbsp;</td>
        <td valign="top"><?php echo CHtml::encode($modPendaftaran->pasien->getAttributeLabel('alamat_pasien')); ?></td>
        <td valign="top">:</td>
        <td valign="top">
            <?php echo CHtml::encode($modPendaftaran->pasien->alamat_pasien); ?>
        </td>
    </tr>
    <tr>
        <td valign="top"><?php echo CHtml::encode($modPendaftaran->getAttributeLabel('umur')); ?></td>
        <td valign="top">:</td>
        <td valign="top">
            <?php echo CHtml::encode($modPendaftaran->umur); ?>
        </td>
        <td valign="top">&nbsp;</td>
        <td valign="top"><?php echo CHtml::encode($modPendaftaran->pasien->getAttributeLabel('alamat_pasien')); ?></td>
        <td valign="top">:</td>
        <td valign="top">
            <?php
                if(strlen($modPendaftaran->carabayar_id)  && strlen($modPendaftaran->penjamin_id) > 0)
                {
                    echo CHtml::encode($modPendaftaran->carabayar->carabayar_nama)." - ". CHtml::encode($modPendaftaran->penjamin->penjamin_nama);
                }else{
                    echo '-'."/"."-";
                }
            ?>
        </td>
    </tr>
    <tr>
        <td valign="top">Unit Pelayanan</td>
        <td valign="top">:</td>
        <td valign="top">
            <?php echo CHtml::encode($modPendaftaran->instalasi->instalasi_nama); ?>
        </td>
        <td>&nbsp;</td>
        <td valign="top">Nama Rujukan</td>
        <td valign="top">:</td>
        <td valign="top">
            <?php
                if(!empty($modPendaftaran->rujukan_id)){
                if(strlen($modPendaftaran->rujukan->nama_perujuk)> 0)
                {
                    echo CHtml::encode($modPendaftaran->rujukan->nama_perujuk);
                }else{
                    echo '-';
                }
                }
            ?>
        </td>
    </tr>
    <tr>
        <td valign="top">Dokter Pemeriksa</td>
        <td valign="top">:</td>
        <td valign="top">
            <?php
             if(!empty($modPendaftaran->pegawai_id)){
              echo CHtml::encode(isset($modPendaftaran->dokter->nama_pegawai) ? $modPendaftaran->dokter->nama_pegawai : ''); 
            
             }
            ?>
        </td>
        <td valign="top">&nbsp;</td>
        <td valign="top">Rujukan Dari</td>
        <td valign="top">:</td>
        <td valign="top">
            <?php
                if(strlen($modPendaftaran->rujukan_id)> 0)
                {
                    echo CHtml::encode($modPendaftaran->rujukan->asalrujukan->asalrujukan_nama);
                }else{
                    echo '-';
                }
            ?>
        </td>
    </tr>
    <tr>
        <td valign="top">Tgl. Pemeriksaan</td>
        <td valign="top">:</td>
        <td valign="top">
            <?php
                if(strlen($modPendaftaran->tgl_pendaftaran) > 0)
                {
                    echo CHtml::encode($modPendaftaran->tgl_pendaftaran);
                }else{
                    echo '-';
                }
            ?>
        </td>
        <td valign="top">&nbsp;</td>
        <td valign="top">No. Rujukan</td>
        <td valign="top">:</td>
        <td valign="top">
            <?php
                if(strlen($modPendaftaran->rujukan_id)> 0)
                {
                    echo CHtml::encode($modPendaftaran->rujukan->no_rujukan);
                }else{
                    echo '-';
                }
            ?>
        </td>
    </tr>
</table>
<br>
<table width="100%" cellpadding="0" cellspacing="0" border="0" class="grid">
    <thead class="border">
        <tr>
            <th width="3%">No.</th>
            <th width="12%">Tanggal</th>
            <th>No. Resep</th>
            <th>Nama Items</th>
            <th width="5%">Jumlah</th>
            <th width="10%">Harga</th>
            <th width="10%">Total</th>
        </tr>
    </thead>
    <?php
        $totalSeluruh = 0;
        $totalObat = 0;
        $totalAlkes = 0;
        $totalAdmin = 0;
        $kelompokObat = 0;
        $kelompokAlkes = 0;
        foreach ($modRincian as $i => $mod)
        {
            $totalAdmin += ($mod->biayaservice + $mod->biayaadministrasi + $mod->biayakonseling);
            // if(!(strtolower($mod->jenisobatalkes_nama) == 'obat')){ update 28-10-2013
            if((strtolower($mod->jenisobatalkes_nama) == 'obat')){
                $kelompokObat ++;
                $totalObat += ($mod->qty_oa * $mod->hargasatuan_oa);
            }else
            if((strtolower($mod->jenisobatalkes_nama) == 'alkes')){
                $kelompokAlkes ++;
                $totalAlkes += ($mod->qty_oa * $mod->hargasatuan_oa);
            }
        }
        $totalSeluruh = $totalObat + $totalAlkes;
    ?>
    <?php
    if($kelompokObat > 0){
        echo '<tr><td colspan ="7"><b>Kelompok : Obat</b></td></tr>';
        for($i = 0;$i < $kelompokObat;$i++){
        ?>
            <tr>
                <td valign="top"><?php echo ($i+1); ?></td>
                <td valign="top"><?php echo date('d/m/Y', strtotime($modRincian[$i]->tglpenjualan));?></td>
                <td valign="top"><?php echo $modRincian[$i]->noresep;?></td>
                <td valign="top"><?php echo $modRincian[$i]->obatalkes_nama;?></td>
                <td valign="top" class="uang"><?php echo $format->formatNumber($modRincian[$i]->qty_oa);?></td>
                <td valign="top" class="uang"><?php echo $format->formatNumber($modRincian[$i]->hargasatuan_oa);?></td>
                <td valign="top" class="uang"><?php echo $format->formatNumber($modRincian[$i]->qty_oa * $modRincian[$i]->hargasatuan_oa);?></td>
            </tr>
        <?php } ?>
        <tr class="border">
            <td colspan="6">Total</td><td class="uang"><b><?php echo $format->formatNumber($totalObat); ?></b></td>
        </tr>
    <?php }?>

    <?php
    if($kelompokAlkes > 0){
        echo "<tr><td colspan = '7'><b>Kelompok : Alat Kesehatan</b></td></tr>";
        for($i = 0;$i < $kelompokAlkes;$i++)
        {
    ?>
            <tr>
                <td valign="top"><?php echo ($i+1); ?></td>
                <td valign="top"><?php echo $modRincian[$i]->tglpenjualan;?></td>
                <td valign="top"><?php echo $modRincian[$i]->noresep;?></td>
                <td valign="top"><?php echo $modRincian[$i]->obatalkes_nama;?></td>
                <td valign="top" class="uang"><?php echo $format->formatNumber($modRincian[$i]->qty_oa);?></td>
                <td valign="top" class="uang"><?php echo $format->formatNumber($modRincian[$i]->hargasatuan_oa);?></td>
                <td valign="top" class="uang"><?php echo $format->formatNumber($modRincian[$i]->qty_oa * $modRincian[$i]->hargasatuan_oa);?></td>
            </tr>
    <?php
        }
    ?>
        <tr class="border">
            <td colspan="6">Total</td><td class="uang"><b><?php echo $format->formatNumber($totalAlkes); ?></b></td>
        </tr>
    <?php    
    }
    ?>
</table>
<br>
<table width="100%" cellpadding="0" cellspacing="0" border="0" class="info">
    <tr>
        <td width="50%" align="center">
      <?php echo Yii::app()->user->getState("kabupaten_nama").", ".Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse(date('Y-m-d H:i:s'), 'yyyy-mm-dd hh:mm:ss')); ?><br>
            Petugas,
            <div class="jarak">&nbsp;</div>
            <div class="jarak">&nbsp;</div>
            <div class="jarak">&nbsp;</div>
            <?php echo $data['nama_pegawai']; ?>            
        </td>
        <td valign="top" width="50%" align="center">
            <table width="100%" cellpadding="0" cellspacing="0" border="0" class="footer">
                <tfoot>
                <tr>
                    <td class="uang"><b>Total Tagihan</b></td>
                    <td width="10%" class="uang"><b><?php echo $format->formatNumber($totalSeluruh); ?></b></td>
                </tr>
                <tr>
                    <td class="uang"><b>Total Biaya Racik, dll.</b></td>
                    <td class="uang"><b><?php echo $format->formatNumber($totalAdmin); ?></b></td>
                </tr>
                <tr>
                    <td class="uang"><b>Total Tangungan</b></td>
                    <td class="uang"><b><?php echo $format->formatNumber($totalSeluruh + $totalAdmin); ?></b></td>
                </tr>
                </tfoot>    
            </table>            
        </td>
    </tr>
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
   
    
   
</div>   