<table class="table table-bordered table-striped table-condensed">
    <thead>
        <tr>
            <th> No.</th>
            <th> Nomor Transaksi </th>
            <th> Nomor BA</th>
            <th> Tanggal Pembuatan BA</th>
            <th> Termin </th>
            <th> Pihak Kesatu </th>
            <th> Pihak Kedua</th>
            <th> Ubah </th>
            <th> Cetak </th>
        </tr>
    </thead>
    <?php
    $mod = SuratperjanjiankerjaterminT::model()->findByAttributes(array('suratperjanjiankerja_id' => $_GET['suratperjanjiankerja_id']));
    $modDet = BaserahterimaT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $_GET['suratperjanjiankerja_id']));
    $no = 1;
    if (!empty($mod)) {
        if (!empty($modDet)) {
            foreach ($modDet as $det) {
                $modTermin = SuratperjanjiankerjaterminT::model()->findByAttributes(array('suratperjanjiankerja_id' => $_GET['suratperjanjiankerja_id']));
                
                ?>
                <tbody>
                    <tr>
                        <td> <?php echo $no++; ?></td>
                        <td> <?php echo  CHtml::link($det->baserahterima_nomor,
                                                    Yii::app()->createUrl('pengadaan/BASerahTerima/detail&suratperjanjiankerja_id='.$_GET['suratperjanjiankerja_id'].'&baserahterima_id='.$det->baserahterima_id),
                                                    array(
                                                        'class'=>'hover',
                                                        "rel"=>"tooltip",
                                                        "target"=>"frame2", 
                                                        "onclick"=>"$('#dialog2').dialog('open');",
                                                        "title"=>"Klik untuk Melihat Detail BA Serah Terima"));?>
                        </td>
                        <td> <?php echo $det->nomor_beritaacara; ?></td>
                        <td> <?php echo MyFormatter::formatDateTimeForUser($det->create_time); ?></td>
                        <td> <?php echo ($det->termin_persen != 100) ? "Termin ".$det->terminke . " (".$det->termin_persen. "%)" : "Non Termin"; ?></td>
                        <td> <?php echo $det->pegawai->namaLengkap; ?></td>
                        <td> <?php echo $det->supplier->supplier_nama; ?></td>
                        <td>
                            <?php
                            echo "<div align=center>" . 
                                    CHtml::link("<i class ='glyphicon glyphicon-pencil' style='font-size:12px;'> </i>", 
                                    Yii::app()->createUrl('pengadaan/bASerahTerima/ubah&suratperjanjiankerja_id=' . $_GET['suratperjanjiankerja_id'] . '&baserahterima_id=' . $det->baserahterima_id)) . "</div>";
                            ?>
                        </td>
                        <td> 
                            <?php
                            
                            if(empty($modTermin->suratperjanjiankerja->istermin)){
                            
                            ?>
                                <?php echo "<div align=center>" .
                                    CHtml::link("<i class ='glyphicon glyphicon-print' style='font-size:12px;'> </i>", 
                                        '#', 
                                            array( 
                                                    "data-placement"=>"left", 
                                                    "rel" => "tooltip", 
                                                    "title" => "Klik untuk Mencetak BA Serah Terima", 
                                                    "target" => "frame1", 'onclick' => "window.open('" . Yii::app()->createUrl('pengadaan/bASerahTerima/print&id=' . $det->baserahterima_id) . "', 'printwin', 'left=100,top=100,width=790,height=1120')")) . 
                                    "</div>";
                            }else{
                                ?>
                                <?php echo "<div align=center>" .
                                    CHtml::link("<i class ='glyphicon glyphicon-print' style='font-size:12px;'> </i>", 
                                        '#', 
                                            array(
                                                     "data-placement"=>"left", 
                                                    "rel" => "tooltip", 
                                                    "title" => "Klik untuk Mencetak BA Serah Terima Termin", 
                                                    "target" => "frame1", 'onclick' => "window.open('" . Yii::app()->createUrl('pengadaan/bASerahTerima/printTermin&id=' . $det->baserahterima_id) . "', 'printwin', 'left=100,top=100,width=790,height=1120')")) . 
                                    "</div>";
                                
                            }
                            
                            ?>
                        </td>
                    </tr>
                </tbody>
                <?php
            }
        }
    }
    ?>
</table>
<?php
// ===========================Dialog Penelitian=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialog1',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'BA Serah Terima',
        'autoOpen' => false,
        'width' => 1100,
        'height' => 600,
        'resizable' => true,
        'scroll' => false,
    ),
));
?>
<iframe src="" name="frame1" width="100%" height="100%">
</iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Work Order================================
?>

<?php
// ===========================Dialog Penelitian=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialog2',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Detail BA Serah Terima',
        'autoOpen' => false,
        'width' => 1100,
        'height' => 600,
        'resizable' => true,
        'scroll' => false,
    ),
));
?>
<iframe src="" name="frame2" width="100%" height="100%">
</iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Work Order================================
?>