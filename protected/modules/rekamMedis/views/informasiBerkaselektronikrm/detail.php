<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/dflip/js/libs/jquery.min.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/dflip/js/dflip.min.js'); ?>
<link href="<?php echo Yii::app()->request->baseUrl; ?>/js/dflip/css/dflip.min.css" rel="stylesheet" type="text/css">
<link href="<?php echo Yii::app()->request->baseUrl; ?>/js/dflip/css/themify-icons.min.css" rel="stylesheet" type="text/css">
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
        Detail Berkas Elektronik Rekam Medik
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-6">
                <h5></h5>
                <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <td>Nama Pasien</td>
                            <td><?php echo $modPasien->nama_pasien?></td>
                        </tr>
                        <tr>
                            <td>No Rekam Medik</td>
                            <td><?php echo $modPasien->no_rekam_medik?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">
                List Berkas Elektronik Rekam Medik
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-12">
                        <h5></h5>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <th>Tanggal Upload</th>
                                    <th>Lihat</th>
                                </thead>
                                <tbody>
                                    <?php foreach($dokFiles as $det) { ?>
                                    <tr>
                                        <td><?php echo $det['upload_tgl']?></td>
                                        <td>
                                        <a class="_df_custom" href="#" source="<?php echo Params::urlFileRMPasienDirectory().$det['namafolder'].'/'.$det['dokfilerm_filepath'] ?>"> Lihat Dokumen
</a>
                                        <!-- <div class="_df_book" source="" id="df_manual_book">
                                        </div> -->
                                        </td>
                                        <!-- <td><span><i class="fa fa-file" onclick="setFlipbook('<?php //echo Params::urlFileRMPasienDirectory().$det['namafolder'].'/'.$det['dokfilerm_filepath'] ?>')"></i></span></td> -->
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



    <script type="text/javascript">
        function setFlipbook(pdf){
            if(getFileExtension(pdf) == 'pdf'){
                window.ope
            }
            // console.log()
        }
        jQuery(function() {

        DFLIP.defaults.onReady = function(flipbook){
            console.log("flipbook ready");
            flipbook.ui.fullScreen.trigger("click");
        }

        });
        function getFileExtension(filename) {
                return filename.slice((filename.lastIndexOf(".") - 1 >>> 0) + 2);
        }

        var url = './file/MongoDB (2).pdf';
    </script>