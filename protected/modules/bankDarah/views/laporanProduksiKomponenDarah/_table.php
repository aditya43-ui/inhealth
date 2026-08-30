<?php
/**
* - digunakan sebagai Laporan Skrining IMLTD
* @author : Elham Budianto
* @email : elhambudianto1@gmail.com
* @wiki : ..
**/
?>
<?php 
    $itemCssClass = 'table table-bordered table-striped table-condensed';
    $table = 'ext.bootstrap.widgets.HeaderGroupGridView';
    $sort = true;
    $row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
    if (isset($caraPrint)){
         $row = '$row+1';
        //$data = $model->searchTable();
        //$template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL"){
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
        }
        
        if ($caraPrint=='PDF') {
            $table = 'ext.bootstrap.widgets.BootGridViewPDF';
        }
        
        $itemCssClass = 'table border';
        
    } else{
        //$data = $model->searchTable();
         //$template = "{summary}\n{items}\n{pager}";
    }
?>

<div>
    <table width="100%" class="table table-bordered table-condensed" border="1px" style="text-align:center; font-weight: bold" id="table-laporan">
        <thead>
            <tr>
                <!--<td rowspan="2" style="text-align:center;">No</td>-->
                <td rowspan="2" style="text-align:center;">Tanggal</td>
                <td rowspan="2" style="text-align:center;">Jumlah Donor</td>
                <td rowspan="2" style="text-align:center;">Gagal Sadap</td>
                <td rowspan="2" style="text-align:center;">IMLTD Reaktif</td>
                <td colspan="4" style="text-align:center;">Jenis Kantong</td>
                <td colspan="6" style="text-align:center;">Jenis Komponen</td>
                <td rowspan="2" style="text-align:center;">Gagal Produksi</td>
                <td rowspan="2" style="text-align:center;">Keterangan</td>
                <td rowspan="2" style="text-align:center;">Asal Darah</td>
            </tr>
            <tr>
                <td style="text-align:center;">SG</td>
                <td style="text-align:center;">DB</td>
                <td style="text-align:center;">TR</td>
                <td style="text-align:center;">QD</td>
                <td style="text-align:center;">WB</td>
                <td style="text-align:center;">PRC</td>
                <td style="text-align:center;">TC</td>
                <td style="text-align:center;">FFP</td>
                <td style="text-align:center;">PCR</td>
                <td style="text-align:center;">AHF</td>
            </tr>
        </thead>
       
    </table>
</div>