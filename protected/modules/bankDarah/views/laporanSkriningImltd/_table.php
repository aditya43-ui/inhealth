<?php
/**
* digunakan sebagai Laporan Skrining IMLTD
* @author Elham Budianto <elhambudianto1@gmail.com>
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
                <td rowspan="2" style="text-align:center;">No</td>
                <td rowspan="2" style="text-align:center;">Bulan</td>
                <td rowspan="2" style="text-align:center;">Jumlah Sampel</td>
                <td colspan="8" style="text-align:center;">Parameter</td>
                <td colspan="2"style="text-align:center;">Reaktif</td>
                <td colspan="2" style="text-align:center;">Kantong</td>
            </tr>
            <tr>
                <td style="text-align:center;">HBsAg</td>
                <td style="text-align:center;">%</td>
                <td style="text-align:center;">HCV</td>
                <td style="text-align:center;">%</td>
                <td style="text-align:center;">HIV</td>
                <td style="text-align:center;">%</td>
                <td style="text-align:center;">Sipilis</td>
                <td style="text-align:center;">%</td>
                <td style="text-align:center;">Total</td>
                <td style="text-align:center;">%</td>
                <td style="text-align:center;">Total</td>
                <td style="text-align:center;">%</td>
            </tr>
        </thead>
        <tbody>
            
        </tbody>
    </table>
</div>