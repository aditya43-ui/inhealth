<?php 
    $itemCssClass = 'table table-bordered table-striped table-condensed';
    $table = 'ext.bootstrap.widgets.HeaderGroupGridView';
    $sort = true;
    $row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
    if (isset($caraPrint)){
        $row = '$row+1';
        $data = $model->searchTableKunjungan();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL"){
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
        }
         if ($caraPrint=='PDF') {
            $table = 'ext.bootstrap.widgets.BootGridViewPDF';
            
        }
  
        echo "
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
                border-spacing:0px;
                padding:0px;
            }

            .table tbody tr:hover td, .table tbody tr:hover th {
                background-color: none;
            }
        </style>";
        $itemCssClass = 'table border';
        
    } else{
        $data = $model->searchTableKunjungan();
         $template = "{summary}\n{items}\n{pager}";
    }
?>
<style>
    tr:last-child > td:first-child{
        border-bottom-left-radius: 0px !important;
        border-bottom-right-radius: 0px !important;
    }
</style>

<div>
    <table id="tableLaporan" width="100%" class="table table-bordered table-condensed" border="1px solid !important" style="text-align:center; font-weight: bold; ">
        <thead>
            <tr>
                <td rowspan="2" style="text-align:center;">Tanggal</td>
                <td rowspan="2" style="text-align:center;">Lokasi</td>
                <td rowspan="2" style="text-align:center;">Jumlah</td>
                <td colspan="2" style="text-align:center;">Jenis Kelamin</td>
                <td colspan="2" style="text-align:center;">Donor Ke-</td>
                <td colspan="3" style="text-align:center;">Jenis Donor</td>
            </tr>
            <tr>
                <td style="text-align:center;">L</td>
                <td style="text-align:center;">P</td>
                <td style="text-align:center;">1x</td>
                <td style="text-align:center;">>1</td>
                <td style="text-align:center;">Skrl</td>
                <td style="text-align:center;">Uskel</td>
                <td style="text-align:center;">Auto</td>
            </tr>
        </thead>
        <tbody>
            <?php 
            foreach ($modShow as $value){
                $cari = LapkunjungandonorV::model()->findAllByAttributes(array('waktu_pendaftaran' => $value->waktu_pendaftaran,'ruangan_rekruitmen_id'=>$value->ruangan_rekruitmen_id));
                $laki = Params::JENIS_KELAMIN_LAKI_LAKI;
                $perempuan = Params::JENIS_KELAMIN_PEREMPUAN;
                $skrl = 'Sukarela'; $pggt = 'Pengganti';  $al = 'Autologus';
                $satu = 1;
                $lebihdarisatu = !1;
                $tglsekarang = 'sekarang';
                $ruangrekrutmen = $value->ruangan_rekruitmen_id;
                $cekruangan = RuanganM::model()->findByPk($value->ruangan_rekruitmen_id);
            ?>
            <tr>
                <td style="text-align: center"><?php echo MyFormatter::formatDateTimeForUser($value->waktu_pendaftaran); ?></td>
                <td><?php echo $cekruangan->ruangan_nama ?></td>
                <td style="text-align: center"><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$tglsekarang"]['jumlah'][$ruangrekrutmen]["ruangrekrutmen"]) ? $b["$value->waktu_pendaftaran"]['det']["$tglsekarang"]['jumlah'][$ruangrekrutmen]["ruangrekrutmen"] :"";?></td>
                <td style="text-align: center"><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$laki"]['jumlah'][$ruangrekrutmen]["ruangrekrutmen"]) ? $b["$value->waktu_pendaftaran"]['det']["$laki"]['jumlah'][$ruangrekrutmen]["ruangrekrutmen"] :""; ?> </td>
                <td style="text-align: center"><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$perempuan"]['jumlah'][$ruangrekrutmen]["ruangrekrutmen"]) ? $b["$value->waktu_pendaftaran"]['det']["$perempuan"]['jumlah'][$ruangrekrutmen]["ruangrekrutmen"] :""; ?> </td>
                <td style="text-align: center"><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$satu"]['jumlah'][$ruangrekrutmen]["ruangrekrutmen"]) ? $b["$value->waktu_pendaftaran"]['det']["$satu"]['jumlah'][$ruangrekrutmen]["ruangrekrutmen"] :""; ?></td>
                <td style="text-align: center"><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$lebihdarisatu"]['jumlah'][$ruangrekrutmen]["ruangrekrutmen"]) ? $b["$value->waktu_pendaftaran"]['det']["$lebihdarisatu"]['jumlah'][$ruangrekrutmen]["ruangrekrutmen"] :""; ?></td>
                <td style="text-align: center"><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$skrl"]['jumlah'][$ruangrekrutmen]["ruangrekrutmen"]) ? $b["$value->waktu_pendaftaran"]['det']["$skrl"]['jumlah'][$ruangrekrutmen]["ruangrekrutmen"] :"";?></td>
                <td style="text-align: center"><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$pggt"]['jumlah'][$ruangrekrutmen]["ruangrekrutmen"]) ? $b["$value->waktu_pendaftaran"]['det']["$pggt"]['jumlah'][$ruangrekrutmen]["ruangrekrutmen"] :"";?></td>
                <td style="text-align: center"><?php echo isset($b["$value->waktu_pendaftaran"]['det']["$al"]['jumlah'][$ruangrekrutmen]["ruangrekrutmen"]) ? $b["$value->waktu_pendaftaran"]['det']["$al"]['jumlah'][$ruangrekrutmen]["ruangrekrutmen"] :"";?></td>
            </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>