<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/entypo/css/entypo.css">        
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/font-awesome/css/font-awesome.css">
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/_print_kajinyeri.css">

<?php $modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); ?>

<style>
    .form-header{
        border-collapse: collapse;
        border-bottom: 2px solid ; 
    }
    .form-identity{
        border-collapse: collapse;
        border-top: 2px solid #999;   
        border-bottom: 2px solid #999;
        border-right: 2px solid #999;
        border-left: 2px solid #999;
    }
    .tab_partograf td {
        border: 1px solid black;
    }
    h5 {
        font-size: 10px;
        font-weight: bold;
    }
    
    .base_det .det_label, .base_det .det_label2 {
        vertical-align: top;
    }
    
    .det_label {
        display:inline-block;
        width: 100px;
    }
    .det_val {
        display:inline-block;
        width: calc(100% - 105px);
    }
    
    .det_label2 {
        display:inline-block;
        width: 50px;
    }
    .det_val2 {
        display:inline-block;
        width: calc(100% - 55px);
    }
</style>


<?php
$table = 'ext.bootstrap.widgets.BootGridView';
$template = "{summary}\n{items}\n{pager}";
if (isset($caraPrint)) {
    $template = "{items}";
    if ($caraPrint == 'EXCEL') {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
        header('Cache-Control: max-age=0');
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
    }
}
?>


<?php
$ceklis = '<span class="fa fa-check-square-o"></span>';
$unceklis = '<span class="fa fa-square-o"></span>';

$pasien = PasienM::model()->findByPk($model->pasien_id);
$modPendaftaran = PendaftaranT::model()->findByAttributes(array('pasien_id'=>$model->pasien_id));
$modPasienAdmisi = PasienadmisiT::model()->findByAttributes(array('pasien_id'=>$model->pasien_id));
$umur = explode(" ", $modPendaftaran->umur);
$graph = $model->searchPrint()->data;


?>
<div>
    <table width="100%" class="form-header">
        <tr>
            <td width="60%">
                <img src="<?php echo Params::urlProfilRSDirectory() . $modProfilRs->logo_rumahsakit ?> " style="width:200px;"/>
            </td>
            <td>
                <table width="100%" class="form-identity">
                    <tr>
                        <td>Nama </td>
                        <td>:</td>
                        <td><?php echo $pasien->nama_pasien; ?></td>
                    </tr>
                    <tr>
                        <td>Tgl lahir/ Umur </td>
                        <td>:</td>
                        <td><?php echo $pasien->tanggal_lahir."/".$modPendaftaran->umur; ?></td>
                    </tr>
                    <tr>
                        <td>No. RM </td>
                        <td>:</td>
                        <td><?php echo $pasien->no_rekam_medik; ?></td>
                    </tr>
                    <tr>
                        <td>NIK </td>
                        <td>:</td>
                        <td><?php echo $pasien->no_identitas_pasien; ?></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>
<div style="margin-bottom: 10px;">
    <h1>FORMULIR PENILAIAN DERAJAT NYERI</h1>
    <table width="50%" border="0">
        <tr>
            <td>Tanggal Masuk</td>
            <td width = "30%" style="border-bottom: 3px solid;"><?php echo $modPasienAdmisi->tgladmisi ?? '' ?></td>
        </tr>
        <tr>
            <td>Penilaian Derajat Nyeri</td>
            <td style="border-bottom: 3px solid;"><?php echo $graph[0]->skalanyeri ?></td>
            <td>Score</td>
        </tr>
    </table>
</div>
<table class="tab_page" width="100%" style="border-collapse:collapse;border-bottom: 0px;">
    <tbody>
        <tr>
            <td>
                <!-- <div style="text-align: right;">FRM/97/RSBM</div> -->
                
                <div class="panel_main">
                    <div class="panel_judul">Penilaian Skala Nyeri</div>
                    <div class="panel_body">
                        <h5>1. Wong Baker Face Pain Scale</h5>
                        <style>
                            .ruler-nyeri-tengah{
                                border-left:1px solid #333 !important;
                                border-top:1px solid #333 !important;
                                border-right:1px solid #333 !important;
                            }

                            .ruler-nyeri-left{
                                border-left:1px solid #333 !important;				
                            }
                            .ruler-nyeri-right{
                                border-right:1px solid #333 !important;				
                            }

                            .nyeri-nomor{
                                margin-left: -11px;
                            }
                        </style>
                        <table class="table noborder paddingtext" style="text-align: center; box-shadow: none; width: 600px;">                    	
                            <tr>             
                                <td width='1px;'>
                                    &nbsp;
                                </td>
                                <td  style="text-align: center;line-height: 1.42857143 !important;">
                                    <?php echo CHtml::image('images/icon_nyeri/0.png', '', array('style' => 'max-width:100%;width:50px;')); ?>
                                    <br/>
                                    0
                                    <br/>
                                    Tidak Nyeri

                                </td> 
                                <td  style="text-align: center;line-height: 1.42857143 !important;">
                                    &nbsp;
                                </td>       
                                <td  style="text-align: center;line-height: 1.42857143 !important;">
                                    <?php echo CHtml::image('images/icon_nyeri/2.png', '', array('style' => 'max-width:100%;width:50px;')); ?>
                                    <br/>
                                    2
                                    <br/>
                                    Sedikit Nyeri 
                                </td>
                                <td  style="text-align: center;line-height: 1.42857143 !important;">

                                </td> 
                                <td  style="text-align: center;line-height: 1.42857143 !important;">
                                    <?php echo CHtml::image('images/icon_nyeri/4.png', '', array('style' => 'max-width:100%;width:50px;')); ?>
                                    <br/>
                                    4
                                    <br/>
                                    Agak Menganggu
                                </td>
                                <td  style="text-align: center;">

                                </td> 
                                <td  style="text-align: center;line-height: 1.42857143 !important;">
                                    <?php echo CHtml::image('images/icon_nyeri/6.png', '', array('style' => 'max-width:100%;width:50px;')); ?>
                                    <br/>
                                    6
                                    <br/>
                                    Menganggu
                                    <br>
                                    Aktifitas
                                </td>
                                <td  style="text-align: center;">

                                </td> 
                                <td  style="text-align: center;line-height: 1.42857143 !important;">
                                    <?php echo CHtml::image('images/icon_nyeri/8.png', '', array('style' => 'max-width:100%;width:50px;')); ?>
                                    <br/>
                                    8
                                    <br/>
                                    Sangat
                                    <br>
                                    Menganggu
                                </td>
                                <td  style="text-align: center;">

                                </td> 
                                <td  style="text-align: center;line-height: 1.42857143 !important;">
                                    <?php echo CHtml::image('images/icon_nyeri/10.png', '', array('style' => 'max-width:100%;width:50px;')); ?>
                                    <br/>
                                    10
                                    <br/>
                                    Tak
                                    <br>
                                    Tertahankan
                                </td>
                            </tr>   
                            <tr>
                                <td width='1px;'>
                                    &nbsp;
                                </td>
                                <td colspan="12" style="margin-left:10px;">
                                    <table width='100%'>
                                        <tr>
                                            <td class='ruler-nyeri-left'></td>
                                            <td class=''></td>
                                            <td class=''></td>
                                            <td class=''></td>					
                                            <td class=''></td>
                                            <td class=''></td>				
                                            <td class=''></td>
                                            <td class=''></td>
                                            <td class=''></td>
                                            <td class='ruler-nyeri-right'></td>
                                        </tr>
                                        <tr>
                                            <td class='ruler-nyeri-tengah'></td>
                                            <td class='ruler-nyeri-tengah'></td>
                                            <td class='ruler-nyeri-tengah'></td>
                                            <td class='ruler-nyeri-tengah'></td>
                                            <td class='ruler-nyeri-tengah'></td>
                                            <td class='ruler-nyeri-tengah'></td>
                                            <td class='ruler-nyeri-tengah'></td>
                                            <td class='ruler-nyeri-tengah'></td>					
                                            <td class='ruler-nyeri-tengah'></td>					
                                            <td class='ruler-nyeri-tengah'></td>	
                                        </tr>
                                        <tr>

                                            <?php
                                            for ($i = 0; $i <= 10; $i++) {
                                                ?>
                                                <td onclick="pilihScala_dws(<?php echo $i; ?>)" width='<?php echo ($i == 10)?'1%':'8%'; ?>'><a style="position:relative; left:-5px;" onclick="pilihScala_dws(<?php echo $i; ?>)" class="hover"><span style="padding: 4px;" class="nyeri-nomor" id="nyerinomor_<?php echo $i; ?>" ><?php echo $i; ?></span></a></td>
                                                <?php
                                            }
                                            ?>
                                        </tr>				
                                    </table>			
                                </td>
                            </tr>	
                        </table>
                        <h5>2. Numerical Rating Scale (NRS)</h5>
                        <table class="table noborder paddingtext" style="text-align: center; box-shadow: none;">  
                            <tr>
                                <td width='1px;'>
                                    &nbsp;
                                </td>
                                <td colspan="12" style="margin-left:10px;">
                                    <table width='100%'>
                                        <tr>
                                            <td class='ruler-nyeri-left'></td>
                                            <td class=''></td>
                                            <td class=''></td>
                                            <td class=''></td>					
                                            <td class=''></td>
                                            <td class=''></td>				
                                            <td class=''></td>
                                            <td class=''></td>
                                            <td class=''></td>
                                            <td class='ruler-nyeri-right'></td>
                                        </tr>
                                        <tr>
                                            <td class='ruler-nyeri-tengah'></td>
                                            <td class='ruler-nyeri-tengah'></td>
                                            <td class='ruler-nyeri-tengah'></td>
                                            <td class='ruler-nyeri-tengah'></td>
                                            <td class='ruler-nyeri-tengah'></td>
                                            <td class='ruler-nyeri-tengah'></td>
                                            <td class='ruler-nyeri-tengah'></td>
                                            <td class='ruler-nyeri-tengah'></td>					
                                            <td class='ruler-nyeri-tengah'></td>					
                                            <td class='ruler-nyeri-tengah'></td>	
                                        </tr>
                                        <tr>

                                            <?php
                                            for ($i = 0; $i <= 10; $i++) {
                                                ?>
                                                <td onclick="pilihScala_nrs(<?php echo $i; ?>)" width='<?php echo ($i == 10)?'1%':'8%'; ?>'><a style="position:relative; left:-5px;" onclick="pilihScala_nrs(<?php echo $i; ?>)" class="hover"><span style="padding: 4px;" class="nyeri-nomor" id="nyerinomor_<?php echo $i; ?>" ><?php echo $i; ?></span></a></td>
                                                <?php
                                            }
                                            ?>
                                        </tr>				
                                    </table>			
                                </td>
                            </tr>	
                        </table>
                        <h5>3. Visual Analog Scale</h5>
                        <style>

                            .ruler {
                                position: relative;
                                height: 40px;
                                border-top: 1px solid black;
                                width: calc(100% - 20px);
                                margin-left: 10px;
                            }

                            .ruler .piece {
                                position: absolute;
                                width: 50px;
                                text-align: center;
                            }

                            .ruler .pos_0 {
                                left: calc((0% - 25px));
                            }
                            .ruler .pos_1 {
                                left: calc(10% - 25px);
                            }
                            .ruler .pos_2 {
                                left: calc(20% - 25px);
                            }
                            .ruler .pos_3 {
                                left: calc(30% - 25px);
                            }
                            .ruler .pos_4 {
                                left: calc(40% - 25px);
                            }
                            .ruler .pos_5 {
                                left: calc(50% - 25px);
                            }
                            .ruler .pos_6 {
                                left: calc(60% - 25px);
                            }
                            .ruler .pos_7 {
                                left: calc(70% - 25px);
                            }
                            .ruler .pos_8 {
                                left: calc(80% - 25px);
                            }
                            .ruler .pos_9 {
                                left: calc(90% - 25px);
                            }
                            .ruler .pos_10 {
                                left: calc(100% - 25px);
                            }

                            .ruler2 {
                                height: 50px;
                            }

                            .ruler2 .pos_b {
                                float: right;
                                text-align: center;
                            }
                            .ruler2 .pos_a {
                                float: left;
                                text-align: center;
                            }

                        </style>
                        <input type="range" id="skor_vas" min="0" max="100" onchange="setSkorVas();" value="<?php echo empty($model->skalanyeri) ? 0 : $model->skalanyeri; ?>" style="width:100%;">
                        <div class="ruler">
                            <label class="piece pos_0">0</label>
                            <label class="piece pos_1">10</label>
                            <label class="piece pos_2">20</label>
                            <label class="piece pos_3">30</label>
                            <label class="piece pos_4">40</label>
                            <label class="piece pos_5">50</label>
                            <label class="piece pos_6">60</label>
                            <label class="piece pos_7">70</label>
                            <label class="piece pos_8">80</label>
                            <label class="piece pos_9">90</label>
                            <label class="piece pos_10">100<br/>mm</label>
                        </div>
                        <div class="ruler2">
                            <label class="pos_a">Tidak<br/>Nyeri</label>
                            <label class="pos_b">Nyeri<br/>Maksimal</label>
                        </div>
                    </div>
                </div>
                
            </td>
        </tr>
    </tbody>
</table>

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/chart.min.js', CClientScript::POS_HEAD); 

$tanggalpengkajian = array();
$waktupengkajian = array();
$nyeri = array();
foreach($graph as $i => $items){
    $tanggalpengkajian[$i] = DATE("Y-m-d ; H : i : s ",strtotime($items->waktupengkajian));
    $waktupengkajian[$i] = DATE("H : i : s",strtotime($items->waktupengkajian));
    $nyeri[$i] = $items->skalanyeri;
}
$tanggalpengkajian = array_reverse($tanggalpengkajian);
$waktupengkajian = array_reverse($waktupengkajian);
$nyeri = array_reverse($nyeri);
$result = CJSON::encode($waktupengkajian);
// var_dump($result);die;

// var_dump($waktupengkajian, $tanggalpengkajian); die;

?>
<div class="panel panel-success">
    <div class="panel-body">
        <div style="width: 100%; height: 300px">
            <canvas id="myChart"></canvas>
        </div>
    </div>
</div>


<script>



const ctx = document.getElementById('myChart');
const myChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?php echo CJSON::encode($tanggalpengkajian)?>,
        datasets: [{
            label: 'Skala Nyeri',
            data: <?php echo CJSON::encode($nyeri) ?>,
            
            borderWidth: 1,
            borderColor: 'red',
        }]
    },
    options: {
        plugins:{
            legend:{
                display: false,
            }
        },
        scales: {
            x: {
                ticks: {
                    callback: function(label) {
                        let realLabel = this.getLabelForValue(label)
                        var year = realLabel.split(";")[1];
                        return year;
                    },
                    maxRotation: 90,
                    minRotation: 90,
                    display: true,
                    drawBorder: true,
                    drawOnChartArea: false
                },
                //display: false,
                gridLines: {
                                zeroLineWidth: 4,
                                drawBorder: false,
                                color: 'rgba(0, 0, 0, .5)'
                            }
                
                // title: {
                //     display: true,
                //     text: 'Waktu Pengkajuan',
                //     align : 'start',
                //     maxRotation: 90,
                //     minRotation: 90
                // }
            },
            xAxis2: {
                type: "category",
                grid: {
                drawOnChartArea: false, // only want the grid lines for one axis to show up
                },
                ticks: {
                    callback: function(label) {
                        let realLabel = this.getLabelForValue(label)
                        var month = realLabel.split(";")[0];
                        return month
                    },
                    //display: false,
                    maxRotation: 90,
                    minRotation: 90
                },
                // title: {
                //     display: true,
                //     text: 'Tanggal Pengkajuan',
                //     align : 'start',
                //     maxRotation: 90,
                //     minRotation: 90
                // }
            },
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>



