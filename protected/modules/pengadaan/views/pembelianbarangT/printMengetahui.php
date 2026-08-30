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
    }
    
    .table tbody tr:hover td, .table tbody tr:hover th {
        background-color: none;
    }

    h3, h4 {
        color: black !important;
    }
    .tblpadding td{
        padding: 5px !important;
    }
</style>
<?php 
$modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());

$table = 'ext.bootstrap.widgets.BootGridView';
$template = "{summary}\n{items}\n{pager}";
if (isset($caraPrint)){
	$template = "{items}";
	if($caraPrint=='EXCEL'){
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
		header('Cache-Control: max-age=0');   
		$table = 'ext.bootstrap.widgets.BootExcelGridView';
	}
}

if (isset($judulLaporan)){
    echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan));      
}

//echo $this->renderPartial('application.views.headerReport.headerAnggaran',array('judulLaporan'=>$judulLaporan, 'deskripsi'=>$deskripsi, 'colspan'=>10));
?>
<table bgcolor='white' class='' style = "box-shadow:none; width: 100%">
    <tr bgcolor='white' >
        <td width="50%">
            <table bgcolor='white' class='tblpadding' style = "box-shadow:none;">
                <tr bgcolor='white' >
                     <td>
                        <b><?php echo CHtml::encode($model->getAttributeLabel('nopembelian')); ?></b>
                    </td>
                    <td>
                        : <?php echo CHtml::encode($model->nopembelian); ?>
                    </td>
                </tr>
                <tr>
                     <td>
                        <b><?php echo CHtml::encode($model->getAttributeLabel('tglpembelian')); ?></b>
                   </td>
                   <td>
                       : <?php echo !empty($model->tglpembelian)?MyFormatter::formatDateTimeForUser($model->tglpembelian):"-" ?>
                   </td>
                </tr>
                <tr>
                    <td>
                        <b><?php echo CHtml::encode($model->getAttributeLabel('tgldikirim')); ?></b>
                   </td>
                   <td>
                       : <?php echo !empty($model->tgldikirim)?MyFormatter::formatDateTimeForUser($model->tgldikirim):"-"; ?>
                   </td>
                </tr>
                <tr>
                    <td>
                        <b>No Referensi</b>            
                    </td>
                    <td>
                        : <?php echo (!empty($model->noreferensi)?$model->noreferensi:""); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b><?php echo "Supplier" ?></b>            
                   </td>
                   <td>
                       : <?php 
                           echo $model->supplier->supplier_nama;
                       ?>
                   </td>
                </tr>
                <tr>
                    <td>
                        <b><?php echo "Sumber Dana" ?></b>            
                   </td>
                   <td>
                       : <?php 
                           echo (isset($model->sumberdana)? $model->sumberdana->sumberdana_nama: "-");
                       ?>
                   </td>
                </tr>
                <tr>
                    <td>
                        <b>Keterangan</b>            
                    </td>
                    <td>
                        : <?php echo preg_replace('/\s\s+/', '<br />', $model->keterangan); ?>
                    </td>
                </tr>
            </table>
        </td>
        <td width="50%">
            <table bgcolor='white' class='tblpadding' style = "box-shadow:none;">
                <tr bgcolor='white' >
                    <td>
                        <b><?php echo CHtml::encode($model->getAttributeLabel('peg_pemesanan_id')); ?></b>            
                    </td>
                    <td>: <?php echo CHtml::encode($model->pemesan->nama_pegawai); ?></td>
                </tr>
                <tr>
                    <td>
                        <b><?php echo "Alamat" ?></b>
                    </td>
                    <td> :
                        <?php 
                            echo $model->supplier->supplier_alamat;
                        ?>
                    </td> 
                </tr>
                <tr>
                    <td>
                        <b><?php echo "No Telp" ?></b>
                    </td>
                    <td> :
                        <?php 
                            echo $model->supplier->supplier_telp;
                        ?>
                    </td> 
                </tr>
                <tr>
                    <td>
                        <b>Jenis PPh</b>            
                    </td>
                    <td>
                        : <?php echo (isset($model->pajak)?$model->pajak->pajak_nama:"-"); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>Tanggal Permintaan Uang Muka Pembelian</b>            
                    </td>
                    <td>
                        : <?php echo !empty($model->tglpermintaanuangmuka)?MyFormatter::formatDateTimeForUser($model->tglpermintaanuangmuka):"-"; ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>Jumlah Permintaan Uang Muka Pembelian</b>            
                    </td>
                    <td>
                        : Rp. <?php echo (!empty($model->jmlpermintaanuangmuka)? MyFormatter::formatNumberForPrint($model->jmlpermintaanuangmuka,2): "-"); ?>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<table id="tableObatAlkes" class="table border" bgcolor='white'>
    <thead>
        <th>No.Urut</th>
         <th>Tipe Barang</th>
        <th>Kode Barang</th>
        <th>Nama Barang</th>
        <th>Isi Dalam Kemasan</th>
        <th>Jumlah Permintaan</th>    
        <th>Harga Satuan (Rp)</th>
        <th>Keringanan (%)</th>    
        <th>Keringanan (Rp)</th>
        <th>PPN (%)</th>    
        <th>PPN (Rp)</th>
        <th>PPh (%)</th>    
        <th>PPh (Rp)</th>    
        <th>Subtotal (Rp)</th>
    </thead>
    <tbody>
    <?php
    $no=1;
        $total = 0;
        foreach($modDetailBeli AS $detail):
            $jmlQty = ($detail->hargasatuan * $detail->jmlbeli);
            $jmlDiskon = round((($jmlQty * $detail->persendiscount)/100),2);
            $jmlPpn = round(((($jmlQty - $jmlDiskon) * $detail->persen_ppn)/100),2);
            $jmlPph = round(((($jmlQty - $jmlDiskon) * $detail->persenpph)/100),2);
            $totalAll = round(($jmlQty - $jmlDiskon + $jmlPpn - $jmlPph),2);
            
            $total += $totalAll;
            
            ?>
        <?php $modBarang = BarangM::model()->findByPk($detail->barang_id); ?>
            <tr bgcolor='white'>   
                <td bgcolor='white'><?php echo $no; ?></td>
                <td bgcolor='white'><?php echo !empty($modBarang->barang_type)?$modBarang->barang_type:null;  ?></td>
                <td bgcolor='white'><?php echo $modBarang->barang_kode; ?></td>
                <td bgcolor='white'><?php echo $modBarang->barang_nama; ?></td>
                <td bgcolor='white'><?php echo $detail->jmldlmkemasan; ?></td>
                <td bgcolor='white' style = "text-align:right;"><?php echo number_format($detail->jmlbeli,2,",",".").' '.$detail->satuanbeli; ?></td>
                <td bgcolor='white' style = "text-align:right;"><?php echo ($this->cekPegawaiJabatan() || Params::cekHiddenHargaGudangUmum()==true)?"Rp ".number_format($detail->hargasatuan,2,",","."):"Hidden"; ?></td>
                <td bgcolor='white' style = "text-align:right;"><?php echo number_format($detail->persendiscount,2,",","."); ?></td>
                <td bgcolor='white' style = "text-align:right;"><?php echo ($this->cekPegawaiJabatan() || Params::cekHiddenHargaGudangUmum()==true)?"Rp ".number_format($jmlDiskon,2,",","."):"Hidden"; ?></td>
                <td bgcolor='white' style = "text-align:right;"><?php echo $detail->persen_ppn; ?></td>
                <td bgcolor='white' style = "text-align:right;"><?php echo ($this->cekPegawaiJabatan() || Params::cekHiddenHargaGudangUmum()==true)?"Rp ".number_format($jmlPpn,2,",","."):"Hidden"; ?></td>
                <td bgcolor='white' style = "text-align:right;"><?php echo number_format($detail->persenpph,2,",","."); ?></td>
                <td bgcolor='white' style = "text-align:right;"><?php echo ($this->cekPegawaiJabatan() || Params::cekHiddenHargaGudangUmum()==true)?"Rp ".number_format($jmlPph,2,",","."):"Hidden"; ?></td>
                <td bgcolor='white' style = "text-align:right;"><?php echo ($this->cekPegawaiJabatan() || Params::cekHiddenHargaGudangUmum()==true)?"Rp ".number_format($totalAll,2,",","."):"Hidden"; ?></td>
            </tr>   
            <?php 
        $no++;
        
        endforeach;
     
    ?>
    </tbody>
    <tfoot>
        <tr>
            <td bgcolor='white' style = "text-align:right;" colspan="13">Total Harga</td>
            <td bgcolor='white' style = "text-align:right;"><?php echo ($this->cekPegawaiJabatan() || Params::cekHiddenHargaGudangUmum()==true)?"Rp ".number_format($total,2,",","."):"Hidden"; ?> </td>
        </tr>
    </tfoot>
</table>
<br/>
<table width="100%" style="margin:0px;" cellpadding="0" cellspacing="0">
    <tr>
        <td colspan="3">Pesanan tersebut akan dipergunakan untuk :</td>
    </tr>
        <tr>
            <td  width="20%">Nama Sarana</td>
            <td>:</td>
            <td>Instalasi Gudang Umum <?php echo $modProfilRs->nama_rumahsakit; ?></td>
        </tr>
        <tr>
            <td  width="20%">Alamat</td>
            <td>:</td>
            <td><?php 
            $alamatrs = $modProfilRs->alamatlokasi_rumahsakit.", Kelurahan ".$modProfilRs->kelurahan->kelurahan_nama.", Kecamatan ".$modProfilRs->kecamatan->kecamatan_nama.", ".$modProfilRs->kabupaten->kabupaten_nama;
            echo ucwords(strtolower($model->alamatpengirim)); ?></td>
        </tr>
    </table><br/>
