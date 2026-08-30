

<style>

body {
    color: black;
}

.tab_detail {
    width:100%;
}

.tab_detail th, .tab_detail td {
    color: black;
    border: 1px solid black;
    padding: 3px;
}

.tab_detail th {
    font-weight: bold;
}

.tab_header {
    width: 100%;
    margin-bottom: 10px;    
    .tab_header td {
        padding: 3px;
        border: none;
    }

</style>
<table style="width: 100%; border: none;">
    <thead>
        <tr>
            <td>
                <div class="header"><?php
                    echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array());
                    ?></div>  
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <div class="content">
                    <div class="judulcontent">  <?php echo $judul_print ?>
                       </div>
                    <table class='tab_header'>
                        <tr>
                            <td>No. Pemesanan</td>
                            <td>:</td>
                            <td width="100%">
                            <?php echo CHtml::encode($modPermintaandarah->no_permintaan); ?>
                            </td>
                            <td nowrap>No. Penerimaan</td>
                            <td>:</td>
                            <td nowrap><?php echo CHtml::encode($modPenerimaan->no_penerimaan); ?></td>
                            
                        </tr>
                        <tr>
                            <td nowrap>Tgl. Pemesanan</td>
                            <td>:</td>
                            <td><?php echo CHtml::encode($modPermintaandarah->tgl_permintaan); ?></td>
                            <td nowrap>Tgl. Penerimaan</td>
                            <td>:</td>
                            <td nowrap><?php echo CHtml::encode($modPenerimaan->tgl_penerimaan); ?></td>
                        </tr>
                    </table>

                    <table id="tableObatAlkes" class="tab_detail">
                        <thead>

                        <th>No.</th>
                        <th>Jenis Darah</th>
                        <th>Golongan Darah</th>
                        <th>Rhesus</th>
                        <th>Jumlah</th>
                        <th>Keterangan</th>
                        <!--<th>Ukuran<br>Bahan</th>-->

                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($modPermintaandarahdetail AS $detail):
                                ?>
                                <tr>  
                                    <td><?php echo $no; ?></td>
                                    <td><?php echo $detail->jeniskomponendarah->jeniskomponenedarah_nama?></td>
                                    <td><?php echo $detail->golongandarah?></td>
                                    <td><?php echo $detail->rhesus?></td>
                                    <td><?php echo $detail->jumlah?></td>
                                    <td><?php echo $detail->keterangan_det?></td>
                                </tr>   
                                <?php
                                $no++;

                            endforeach;
                            ?>
                        </tbody>   
                    </table>

                    <table width="100%" style="margin-top:20px;">
                        <tr>
                            <td width="100%" align="left" align="top">
                                <table style="width: 100%; border: none;">
                                    <tr>
                                        <td width="35%" align="center">
                                                <div>Petugas Menerima</div>
                                                <div style="margin-top:60px;"><?php echo isset($modPenerimaan->petugas_penerima_id) ? $modPenerimaan->petugas->NamaLengkap : "" ?></div>
                                            </td>
                                        <td width="35%" align="center">
                                        </td>
                                        <td width="35%" align="center">
                                            <div>Petugas Mengetahui:</div>
                                            <div style="margin-top:60px;"><?php echo isset($modPenerimaan->petugas_mengetahui_id) ? $modPenerimaan->pengetahui->NamaLengkap : "" ?></div>
                                            
                                        </td>
                                    </tr>
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
        <?php echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
    
</div>

