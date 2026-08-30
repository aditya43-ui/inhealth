<?php 
    $border = !empty($_GET['caraPrint']) ? "table-bordered" : "";
?>
<table width="100%" class="table table-condensed " <?php echo $border ?> border="1px" >
    <thead>
        <tr>
            <th style="text-align: center"> No. </th>
            <th style="text-align: center"> Nama UTD </th>
            <th style="text-align: center"> Jumlah <br> (kantong) </th>
        </tr>
    </thead>
    <tbody>
        <?php 
//            $criteria = new CDbCriteria();
//            $criteria->select = 't.ruangan_nama, count(ruangan_nama) as jumlah';
//            $criteria->addCondition("ruangan_nama != '" .Params::RUANGAN_NAMA_TRANSFUSI_DARAH. "'");
//            $criteria->group = 't.ruangan_nama';
//            $modTerima = LaporanpermenkesbankdarahV::model()->findAll($criteria);
        ?>
        <?php 
//            $no = 1;
//            foreach($modTerima as $value){ 
        ?>
        <tr>
            <td> <?php // echo $no++; ?></td>
            <td> <?php // echo $value->ruangan_nama; ?></td>
            <td> <?php // echo $value->jumlah; ?></td>
        </tr>
        <?php // } ?>
    </tbody>
</table>