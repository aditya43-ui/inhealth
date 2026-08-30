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
<table width="100%">
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
                    <div class="judulcontent" ><?php echo $judulLaporan; ?> </div>

<table id="tableObatAlkes" class="table border" bgcolor='white'>
    <thead>
        <th>Jenis Transaksi</th>
        <th>Tgl Transaksi</th>
        <th>No Transaksi</th>
        <th>Kelompok Bahan Makanan</th>
        <th>Nama Bahan Makanan</th>
        <th>Jumlah Bahan Makanan</th>    
        <th>Kondisi Bahan Makanan</th>
    </thead>
    <tbody>
    <?php
        $total = 0;
        foreach($model AS $detail){
            $modBarang = BahanmakananM::model()->findByPk($detail->bahanmakanan_id);
            $jenistransaksi = "";
            $tgltransaksi = "";
            $namatransaksi = "";
            $kondisi = "Baik";
            $total += $detail->qty_current;
            
            if(!empty($detail->terimabahandetail_id)){
                $modDet = TerimabahandetailT::model()->findByPk($detail->terimabahandetail_id);
                
                if(isset($modDet)){
                    $mod = TerimabahanmakanT::model()->findByPk($modDet->terimabahanmakan_id);
                    if(isset($mod)){
                        $jenistransaksi = "Penerimaan Bahan Makanan";
                        $tgltransaksi = MyFormatter::formatDateTimeForUser($mod->tglterimabahan);
                        $namatransaksi = $mod->nopenerimaanbahan;
                    }
                }
            }else if(!empty($detail->pemakaianhbnmkndet_id)){
                $modDet = PemakaianbhnmkndetT::model()->findByPk($detail->pemakaianhbnmkndet_id);
                
                if(isset($modDet)){
                    $mod = PemakaianbhnmknT::model()->findByPk($modDet->pemakaianbhnmkn_id);
                    if(isset($mod)){
                        $jenistransaksi = "Pemakaian Bahan Makanan";
                        $tgltransaksi = MyFormatter::formatDateTimeForUser($mod->tglpemakaianbhnmkn);
                        $namatransaksi = $mod->no_pemakaianbhnmkn;
                    }
                }
            }else if(!empty($detail->returpenbahanmakandetail_id)){
                $modDet = ReturpenbahanmakandetailT::model()->findByPk($detail->returpenbahanmakandetail_id);
                
                if(isset($modDet)){
                    $mod = ReturpenbahanmakanT::model()->findByPk($modDet->returbahanmakan_id);
                    if(isset($mod)){
                        $jenistransaksi = "Retur Bahan Makanan";
                        $tgltransaksi = MyFormatter::formatDateTimeForUser($mod->tglreturbahanmakan);
                        $namatransaksi = $mod->noreturbahanmakan;
                    }
                }
            }else if(!empty($detail->stokopnamegizidet_id)){
                $modDet = StokopnamegizidetT::model()->findByPk($detail->stokopnamegizidet_id);
                
                if(isset($modDet)){
                    $mod = StokopnamegiziT::model()->findByPk($modDet->stokopnamegizi_id);
                    if(isset($mod)){
                        $jenistransaksi = $mod->jenisstokopnamegizi;
                        $tgltransaksi = MyFormatter::formatDateTimeForUser($mod->tglstokopnamegizi);
                        $namatransaksi = $mod->nostokopnamegizi;
                        $kondisi = $modDet->kondisibarang;
                    }
                }
            }
            
            
            ?>
            <tr bgcolor='white'>   
                <td bgcolor='white'><?php echo $jenistransaksi; ?></td>
                <td bgcolor='white'><?php echo $tgltransaksi; ?></td>
                <td bgcolor='white'><?php echo $namatransaksi; ?></td>
                <td bgcolor='white'><?php echo $modBarang->kelbahanmakanan; ?></td>
                <td bgcolor='white'><?php echo $modBarang->namabahanmakanan; ?></td>
                <td bgcolor='white' style="text-align:right;"><?php echo $detail->qty_current.' '.$modBarang->satuanbahan; ?></td>
                <td bgcolor='white'><?php echo $kondisi; ?></td>
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
            <td bgcolor='white' style = "text-align:right; font-weight: bold" colspan="5">Total Bahan Makanan</td>
            <td bgcolor='white' style = "text-align:right; font-weight: bold"><?php echo (round($total * 100) / 100).' '.$modBarang->satuanbahan; ?> </td>
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
    echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('PRINT')"));
?>
    <script type='text/javascript'>
    /**
     * print
     */    
    function print(caraPrint){
        var bahanmakanan_id = '<?php echo isset($bahanmakanan_id) ? $bahanmakanan_id : ''; ?>';
        window.open('<?php echo $this->createUrl('rincian'); ?>&id='+bahanmakanan_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
    }
    </script>
<?php
}
?>
