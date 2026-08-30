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
                    <div class="judulcontent">RINCIAN STOK BARANG </div>

<table id="tableObatAlkes" class="table border" bgcolor='white'>
    <thead>
        <th>Kode Barang</th>
        <th>Jenis Transaksi</th>
        <th>Tgl. Transaksi</th>
        <th>No. Transaksi</th>    
        <th>Nama Barang</th>
        <th>Jumlah Barang</th>    
        <th>Kondisi Barang</th>
    </thead>
    <tbody>
    <?php
        $total = 0;
        foreach($model AS $detail){
            $modBarang = BarangM::model()->findByPk($detail->barang_id);
            $jenistransaksi = "";
            $tgltransaksi = "";
            $namatransaksi = "";
            $total += $detail->inventarisasi_qty_skrg;
            
            if(!empty($detail->terimapersdetail_id)){
                $modTerimaPersDet = TerimapersdetailT::model()->findByPk($detail->terimapersdetail_id);
                
                if(isset($modTerimaPersDet)){
                    $modTerimaPers = TerimapersediaanT::model()->findByPk($modTerimaPersDet->terimapersediaan_id);
                    if(isset($modTerimaPers)){
                        $jenistransaksi = "Penerimaan Barang";
                        $tgltransaksi = MyFormatter::formatDateTimeForUser($modTerimaPers->tglterima);
                        $namatransaksi = $modTerimaPers->nopenerimaan;
                    }
                }
            }else if(!empty($detail->mutasibrgdetail_id)){
                $modMutasiDet = MutasibrgdetailT::model()->findByPk($detail->mutasibrgdetail_id);
                if(isset($modMutasiDet)){
                    $modMutasi = MutasibrgT::model()->findByPk($modMutasiDet->mutasibrg_id);
                    
                    if(isset($modMutasi)){
                        $jenistransaksi = "Mutasi Barang";
                        $tgltransaksi = MyFormatter::formatDateTimeForUser($modMutasi->tglmutasibrg);
                        $namatransaksi = $modMutasi->nomutasibrg;
                    }
                }
            }else if(!empty($detail->batalmutasibrg_id)){
                $modBatalMutasiBrg = BatalmutasibrgT::model()->findByPk($detail->batalmutasibrg_id);
                if(isset($modBatalMutasiBrg)){
                    $modMutasi = MutasibrgT::model()->findByPk($modBatalMutasiBrg->mutasibrg_id);
                    
                    if(isset($modMutasi)){
                        $jenistransaksi = "Batal Mutasi Barang";
                        $tgltransaksi = MyFormatter::formatDateTimeForUser($modMutasi->tglmutasibrg);
                        $namatransaksi = $modMutasi->nomutasibrg;
                    }
                }
            }else if(!empty($detail->invbarangdet_id)){
                $modInvBarangdet = InvbarangdetT::model()->findByPk($detail->invbarangdet_id);
                if(isset($modInvBarangdet)){
                    $modInvbarang = InvbarangT::model()->findByPk($modInvBarangdet->invbarang_id);
                    
                    if(isset($modInvbarang)){
                        $jenistransaksi = $modInvbarang->invbarang_jenis;
                        $tgltransaksi = MyFormatter::formatDateTimeForUser($modInvbarang->invbarang_tgl);
                        $namatransaksi = $modInvbarang->invbarang_no;
                    }
                }
            } else if(!empty($detail->pemakaianbarang_id)){
                $modPemakaian = PemakaianbarangT::model()->findByPk($detail->pemakaianbarang_id);
                    
                if(isset($modPemakaian)){
                    $jenistransaksi = "Pemakaian Barang";
                    $tgltransaksi = MyFormatter::formatDateTimeForUser($modPemakaian->tglpemakaianbrg);
                    $namatransaksi = $modPemakaian->nopemakaianbrg;
                }
            }
            
            ?>
            <tr bgcolor='white'>   
                <td bgcolor='white'><?php echo $modBarang->barang_kode; ?></td>
                <td bgcolor='white'><?php echo $jenistransaksi; ?></td>
                <td bgcolor='white'><?php echo $tgltransaksi; ?></td>
                <td bgcolor='white'><?php echo $namatransaksi; ?></td>
                <td bgcolor='white'><?php echo $modBarang->barang_nama; ?></td>
                <td bgcolor='white' style = "text-align:right;"><?php echo $detail->inventarisasi_qty_skrg.' '.$modBarang->barang_satuan; ?></td>
                <td bgcolor='white'><?php echo $detail->inventarisasi_keadaan; ?></td>
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
            <td bgcolor='white' style = "text-align:right;" colspan="5">Total Barang</td>
            <td bgcolor='white' style = "text-align:right;"><?php echo $total.' '.$modBarang->barang_satuan; ?> </td>
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
   
    <?php  echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>

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
