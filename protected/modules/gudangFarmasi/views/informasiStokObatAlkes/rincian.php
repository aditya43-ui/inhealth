<?php
$format = new MyFormatter;
$modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
?>

<style>
    .content .judulcontent{
                font-size:12pt !important;
                font-family: calbiri_b !important;
                 color:black !important;
                 font-weight:bold !important;
                  text-align:center !important;
            }
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
    }
    
    .table tbody tr:hover td, .table tbody tr:hover th {
        background-color: none;
    }
    
    .table tfoot td {
        font-weight: bold;
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
                    <div class="judulcontent"><?php echo $judulLaporan; ?></div>
                    <table bgcolor='white' class='table' style = "box-shadow:none;">
                        <tr bgcolor='white' >
                            <td width="100px">
                                Instalasi
                            </td>
                            <td>
                                : <?php echo $instalasi_nama; ?>
                            </td>
                            <td width="100px">
                              Ruangan  
                            </td>
                            <td>
                                : <?php echo $ruangan_nama; ?>
                            </td>
                        </tr>
                    </table>

<table id="tableObatAlkes" class="table border" bgcolor='white'>
    <thead>
        <th>Kode Obat Alkes</th>
        <th>Jenis Transaksi</th>
        <th>Tgl. Transaksi</th>
        <th>No. Transaksi</th>    
        <th>Nama Obat Alkes</th>
        <th>Jumlah Obat Alkes</th>    
        <th>Kondisi Obat Alkes</th>
    </thead>
    <tbody>
    <?php
        $total = 0;
        foreach($model AS $detail){
            $modBarang = ObatalkesM::model()->findByPk($detail->obatalkes_id);
            $jenistransaksi = "";
            $tgltransaksi = "";
            $namatransaksi = "";
            $kondisiOa = "Baik";
            $qtyStok = ($detail->qtystok_in - $detail->qtystok_out);
            $total += $qtyStok;
            $satuan = (isset($detail->satuankecil)?$detail->satuankecil->satuankecil_nama: "");
            
            
            if(!empty($detail->penerimaandetail_id)){
                $modTerimaPersDet = PenerimaandetailT::model()->findByPk($detail->penerimaandetail_id);
                
                if(isset($modTerimaPersDet)){
                    $modTerimaPers = PenerimaanbarangT::model()->findByPk($modTerimaPersDet->penerimaanbarang_id);
                    if(isset($modTerimaPers)){
                        $jenistransaksi = "Penerimaan Obat Alkes";
                        $tgltransaksi = MyFormatter::formatDateTimeForUser($modTerimaPers->tglterima);
                        $namatransaksi = $modTerimaPers->noterima;
                    }
                }
            }else if(!empty($detail->terimamutasidetail_id)){
                $modDet = TerimamutasidetailT::model()->findByPk($detail->terimamutasidetail_id);
                if(isset($modDet)){
                    $mod = TerimamutasiT::model()->findByPk($modDet->terimamutasi_id);
                    
                    if(isset($mod)){
                        $jenistransaksi = "Terima Mutasi Obat Alkes";
                        $tgltransaksi = MyFormatter::formatDateTimeForUser($mod->tglterima);
                        $namatransaksi = $mod->noterimamutasi;
                    }
                }
            }else if(!empty($detail->returresepdet_id)){
                $modDet = ReturresepdetT::model()->findByPk($detail->returresepdet_id);
                if(isset($modDet)){
                    $mod = ReturresepT::model()->findByPk($modDet->returresep_id);
                    
                    if(isset($mod)){
                        $jenistransaksi = "Retur Resep Obat Alkes";
                        $tgltransaksi = MyFormatter::formatDateTimeForUser($mod->tglretur);
                        $namatransaksi = $mod->noreturresep;
                    }
                }
            }else if(!empty($detail->returdetail_id)){
                $modDet = ReturdetailT::model()->findByPk($detail->returdetail_id);
                if(isset($modDet)){
                    $mod = ReturpembelianT::model()->findByPk($modDet->returpembelian_id);
                    
                    if(isset($mod)){
                        $jenistransaksi = "Retur Pembelian Obat Alkes";
                        $tgltransaksi = MyFormatter::formatDateTimeForUser($mod->tglretur);
                        $namatransaksi = $mod->noretur;
                    }
                }
            } else if(!empty($detail->mutasioadetail_id)){
                $modDet = MutasioadetailT::model()->findByPk($detail->mutasioadetail_id);
                if(isset($modDet)){
                    $mod = MutasioaruanganT::model()->findByPk($modDet->mutasioaruangan_id);
                    
                    if(isset($mod)){
                        $jenistransaksi = "Mutasi Obat Alkes";
                        $tgltransaksi = MyFormatter::formatDateTimeForUser($mod->tglmutasioa);
                        $namatransaksi = $mod->nomutasioa;
                    }
                }
            } else if(!empty($detail->obatalkespasien_id)){
                $modDet = ObatalkespasienT::model()->findByPk($detail->obatalkespasien_id);
                if(isset($modDet)){
                    if($modDet->oa == Params::OBATALKESPASIEN_BMHP){
                        
                        $jenistransaksi = "Pemakaian Bahan Pasien";
                        $tgltransaksi = MyFormatter::formatDateTimeForUser($modDet->tglpelayanan);
                        $namatransaksi = (!empty($modDet->pendaftaran)?$modDet->pendaftaran->no_pendaftaran:"");
                    }else{
                        $mod = PenjualanresepT::model()->findByPk($modDet->penjualanresep_id);
                        
                        if(isset($mod)){
                            $jenistransaksi = "Penjualan Resep Obat Alkes";
                            $tgltransaksi = MyFormatter::formatDateTimeForUser($mod->tglresep);
                            $namatransaksi = $mod->noresep;
                        }
                    }
                }
            }  else if(!empty($detail->pemusnahanoadet_id)){
                $modDet = PemusnahanoadetailT::model()->findByPk($detail->pemusnahanoadet_id);
                if(isset($modDet)){
                    $mod = PemusnahanobatalkesT::model()->findByPk($modDet->pemusnahanobatalkes_id);
                    
                    if(isset($mod)){
                        $jenistransaksi = "Pemusnahan Obat Alkes";
                        $tgltransaksi = MyFormatter::formatDateTimeForUser($mod->tglpemusnahan);
                        $namatransaksi = $mod->nopemusnahan;
                    }
                }
            }  else if(!empty($detail->stokopnamedet_id)){
                $modDet = StokopnamedetT::model()->findByPk($detail->stokopnamedet_id);
                if(isset($modDet)){
                    $mod = StokopnameT::model()->findByPk($modDet->stokopname_id);
                    
                    if(isset($mod)){
                        $jenistransaksi = $mod->jenisstokopname." Obat Alkes";
                        $tgltransaksi = MyFormatter::formatDateTimeForUser($mod->tglstokopname);
                        $namatransaksi = $mod->nostokopname;
                        $kondisiOa = $modDet->kondisibarang;
                    }
                }
            }  else if(!empty($detail->pemakaianobatdetail_id)){
                $modDet = PemakaianobatdetailT::model()->findByPk($detail->pemakaianobatdetail_id);
                if(isset($modDet)){
                    $mod = PemakaianobatT::model()->findByPk($modDet->pemakaianobat_id);
                    
                    if(isset($mod)){
                        $jenistransaksi = "Pemakaian Obat Alkes";
                        $tgltransaksi = MyFormatter::formatDateTimeForUser($mod->tglpemakaianobat);
                        $namatransaksi = $mod->nopemakaian_obat;
                    }
                }
            }  else if(!empty($detail->produksigasmedisdet_id)){
                $modDet = ProduksigasmedisdetT::model()->findByPk($detail->produksigasmedisdet_id);
                if(isset($modDet)){
                    $mod = ProduksigasmedisT::model()->findByPk($modDet->produksigasmedis_id);
                    
                    if(isset($mod)){
                        $jenistransaksi = "Produksi Gas Medis";
                        $tgltransaksi = MyFormatter::formatDateTimeForUser($mod->tgl_produksi);
                        $namatransaksi = $mod->no_produksi;
                    }
                }
            }
            
            ?>
            <tr bgcolor='white'>   
                <td bgcolor='white'><?php echo $modBarang->obatalkes_kode; ?></td>
                <td bgcolor='white'><?php echo $jenistransaksi; ?></td>
                <td bgcolor='white'><?php echo $tgltransaksi; ?></td>
                <td bgcolor='white'><?php echo $namatransaksi; ?></td>
                <td bgcolor='white'><?php echo $modBarang->obatalkes_nama; ?></td>
                <td bgcolor='white' style = "text-align:right;"><?php echo MyFormatter::formatNumberForPrint($qtyStok,2)." ".$satuan; ?></td>
                <td bgcolor='white'><?php echo $kondisiOa; ?></td>
            </tr>   
            <?php 
        }
     
    ?>
    </tbody>
    <tfoot>
        <tr>
            <td bgcolor='white' colspan="7"></td>
        </tr>
        <tr>
            <td bgcolor='white' style = "text-align:right; font-weight: bold;" colspan="5">Total Obat Alkes</td>
            <td bgcolor='white' style = "text-align:right;"><?php echo MyFormatter::formatNumberForPrint($total,2).' '.$satuan; ?> </td>
            <td bgcolor='white' style = "text-align:right;"></td>
        </tr>
    </tfoot>
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
   
    <?php // echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>

</div>

<?php
if (isset($_GET['frame'])){
    echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="entypo-print"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('PRINT')"));
?>
    <script type='text/javascript'>
    /**
     * print
     */    
    function print(caraPrint){
        var barang_id = '<?php echo isset($barang_id) ? $barang_id : ''; ?>';
        var ruangan_id = '<?php echo isset($ruangan_id) ? $ruangan_id : ''; ?>';
        window.open('<?php echo $this->createUrl('rincian'); ?>&id='+barang_id+'&ruangan_id='+ruangan_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
    }
    </script>
<?php
}
?>
