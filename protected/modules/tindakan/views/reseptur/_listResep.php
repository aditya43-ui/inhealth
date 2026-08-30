<?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'daftarriwayat-v-grid',
    'dataProvider' => $modRiwatReseptur->searchRiwayatResep(),
    'template' => "{summary}\n{items}\n{pager}",
    "replaceUrl" => true,
    'itemsCssClass' => 'table table-striped table-condensed',
    'columns' => [
        [
            'header' => 'No',
            'value' => '$row+1',
        ],  [
            'header' => 'Tanggal Resep',
            'value' => function ($data) {
                return MyFormatter::formatDateTimeForUser($data->tglreseptur);
            }
        ],
        [
            'header' => 'No Resep',
            'value' => function ($data) {
                return $data->noresep;
            }
        ],
        [
            'header' => 'Nama Dokter',
            'value' => function ($data) {
                $pegawai = PegawaiM::model()->findByPk($data->pegawai_id);

                return $pegawai->namaLengkap;
            }
        ],
        [
            'header' => 'PPDS',
            'value' => function ($data) {
                $ppds = PpdsM::model()->findByPk($data->ppds_id);

                return $ppds->ppds_nama ?? "-";
            }
        ],
        [
            'header' => 'Pegawai Input',
            'value' => function ($data) {
                // return   LoginpemakaiK::model()->findByPk($data->create_loginpemakai_id)->pegawai->namaLengkap;
                // echo   LoginpemakaiK::model()->findByPk($data->create_loginpemakai_id)->pegawai->pegawai_id;
                echo   LoginpemakaiK::model()->findByPk($data->create_loginpemakai_id)->pegawai->namalengkap;

            }
        ],
        [
            'header' => 'Copy Resep',
            'type' => 'raw',
            'value' => function ($data) {
                return  "<center>" . CHtml::link("<i class='fa fa-copy'></i>", '#', array('onclick' => 'copy_reseptur(' . $data->reseptur_id . ');return false;', 'class' => '')) . "</center>";
            }
        ],
        [
            'header' => 'Lihat Detail',
            'type' => 'raw',
            'value' => function ($data) {
                return "<center>" . CHtml::link("<i class='far fa-eye'></i>", '#', array('onclick'=>'viewDetailResep("'.$data->reseptur_id.'","'.$_GET["pendaftaran_id"].'");return false;','rel'=>'tooltip','title'=>'Klik untuk melihat detail resep')) . "</center>";
            }
        ],
        [
            'header' => 'Edit',
            'type' => 'raw',
            'value' => function ($data) {
                // $kelompokpegawai_id = $data->pegawai->kelompokpegawai_id;  
                $kelompokinput_id =  LoginpemakaiK::model()->findByPk($data->create_loginpemakai_id)->pegawai->kelompokpegawai_id;
                $kelompokperawat_id =  LoginpemakaiK::model()->findByPk(Yii::app()->user->getState('loginpemakai_id'))->pegawai->kelompokpegawai_id;

                if(empty($data->penjualanresep_id)){
                    if ($kelompokinput_id == Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK || Yii::app()->user->getState('loginpemakai_id') == Params::PERANPENGGUNA_ID_ADMIN) {
                        if($data->create_loginpemakai_id == Yii::app()->user->getState('loginpemakai_id') || Yii::app()->user->getState('loginpemakai_id') == Params::PERANPENGGUNA_ID_ADMIN) {
                            return "<center>" . CHtml::link("<i class='icon-eye-open'></i>", $this->createUrl('index', array('pendaftaran_id' => $_GET['pendaftaran_id'],'pasienadmisi_id' => ((isset($_GET['pasienadmisi_id']) && !empty($_GET['pasienadmisi_id'])) ? $_GET['pasienadmisi_id'] : null),'salin' => $data->reseptur_id)), array('rel' => 'tooltip', 'title' => 'Klik edit resep')) . "</center>"; 
                        } else {
                            return "<center>" . CHtml::link("<i class='icon-eye-open'></i>",'#', array('rel' => 'tooltip', 'title' => 'Klik edit resep', 'onclick' => 'window.parent.myAlert("Hanya dokter yang meresepkan yang bisa melakukan edit")' )) . "</center>";
                        }
                    } else {
                        if ($kelompokperawat_id == Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN) {
                            return "<center>" . CHtml::link("<i class='icon-eye-open'></i>", $this->createUrl('index', array('pendaftaran_id' => $_GET['pendaftaran_id'],'pasienadmisi_id' => ((isset($_GET['pasienadmisi_id']) && !empty($_GET['pasienadmisi_id'])) ? $_GET['pasienadmisi_id'] : null),'salin' => $data->reseptur_id)), array('rel' => 'tooltip', 'title' => 'Klik edit resep')) . "</center>"; 
                        } else {
                            return "<center>" . CHtml::link("<i class='icon-eye-open'></i>",'#', array('rel' => 'tooltip', 'title' => 'Klik edit resep', 'onclick' => 'window.parent.myAlert("Hanya dokter / perawat yang meresepkan yang bisa melakukan edit")' )) . "</center>";
                        }
                    }
                }else{
                    return "<center>" . CHtml::link("<i class='icon-eye-open'></i>",'#', array('rel' => 'tooltip', 'title' => 'Klik edit resep', 'onclick' => 'window.parent.myAlert("Resep tidak bisa diedit karena sudah dijual!")' )) . "</center>";  
                }
            }
        ],
        [
            'header' => 'Hapus',
            'type' => 'raw',
            'value' => function ($data) {
                $kelompokinput_id =  LoginpemakaiK::model()->findByPk($data->create_loginpemakai_id)->pegawai->kelompokpegawai_id;
                $kelompokperawat_id =  LoginpemakaiK::model()->findByPk(Yii::app()->user->getState('loginpemakai_id'))->pegawai->kelompokpegawai_id;

                if(empty($data->penjualanresep_id)){
                    if ($kelompokinput_id == Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK || Yii::app()->user->getState('loginpemakai_id') == Params::PERANPENGGUNA_ID_ADMIN) {
                        if($data->create_loginpemakai_id == Yii::app()->user->getState('loginpemakai_id') || Yii::app()->user->getState('loginpemakai_id') == Params::PERANPENGGUNA_ID_ADMIN) {
                            return "<center>" . CHtml::link("<i class='icon-trash'></i>",'#', array('rel' => 'tooltip', 'title' => 'Klik untuk menghapus Reseptur', 'onclick' => 'hapusresep('.$data->reseptur_id.')' )) . "</center>";  
                        } else {
                            return "<center>" . CHtml::link("<i class='icon-trash'></i>",'#', array('rel' => 'tooltip', 'title' => 'Klik edit resep', 'onclick' => 'window.parent.myAlert("Hanya dokter yang meresepkan yang dapat menghapus")' )) . "</center>";  
                        }
                    } else {
                        if ($kelompokperawat_id == Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN && $data->create_loginpemakai_id == Yii::app()->user->getState('loginpemakai_id') || $kelompokperawat_id == Params::KELOMPOKPEGAWAI_ID_BIDAN && $data->create_loginpemakai_id == Yii::app()->user->getState('loginpemakai_id') ) {
                            return "<center>" . CHtml::link("<i class='icon-trash'></i>",'#', array('rel' => 'tooltip', 'title' => 'Klik untuk menghapus Reseptur', 'onclick' => 'hapusresep('.$data->reseptur_id.')' )) . "</center>";  
                        } else {
                            return "<center>" . CHtml::link("<i class='icon-trash'></i>",'#', array('rel' => 'tooltip', 'title' => 'Klik edit resep', 'onclick' => 'window.parent.myAlert("Hanya perawat yang meresepkan yang dapat menghapus")' )) . "</center>";  
                        }
                    }
                }else{
                    return "<center>" . CHtml::link("<i class='icon-trash'></i>",'#', array('rel' => 'tooltip', 'title' => 'Klik edit resep', 'onclick' => 'window.parent.myAlert("Resep tidak bisa dihapus karena sudah dijual")' )) . "</center>";  
                }
            }
        ],
    ],
    'afterAjaxUpdate' => 'function(id, data){
jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
)); ?>

<?php
echo CHtml::hiddenField('is_reseptur', (isset($_GET['reseptur_id']) ? $_GET['reseptur_id'] : null)); ?>
<script>
    function hapusresep(reseptur_id,obj)
    {
        var is_reseptur = $('#is_reseptur').val();
        tabel = obj;
        if(is_reseptur == reseptur_id){
            window.parent.myAlert('Data sedang ditampilkan, tidak dapat dihapus. Lakukan reload halaman/klik tombol ulang terlebih dahulu!');
        }else{
            window.parent.myConfirm('Apakah anda akan menghapus Reseptur ini?', 'Perhatian!', function(r)
            {
                if(r){
                    $.ajax({
                        type:'POST',
                        url:'<?php echo $this->createUrl('hapusRiwayatReseptur'); ?>',
                        data: {reseptur_id:reseptur_id},
                        dataType: "json",
                        success:function(data){
                            if(data.sukses){
                                $.fn.yiiGridView.update('daftarriwayat-v-grid', {
                                    data:{
                                        "RJPenjualanresepT[reseptur_id]":data.reseptur_id,
                                    }
                          
                                });
                                var delete_row = $(tabel).parents('tr');
                                delete_row.detach();
                            }
                          
                            window.parent.myAlert(data.pesan);
                            refreshForm2();
                        },
                        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
                    });
    
                }
            });
        }
    }

    function refreshForm2(pendaftaran_id){
        window.location.href = "<?php echo Yii::app()->createUrl('rawatJalan/'.$this->id.'/index/&pendaftaran_id='.$_GET['pendaftaran_id']); ?>";
    }


    function cekVerifikasi(penjualanresep_id){
        if(penjualanresep_id != ""){
            window.parent.myAlert("Resep sudah diverifikasi di farmasi");
        }
    }

    const copy_reseptur = (reseptur_id) => {
        var hitung = 0;
        var rke = $("#table-obatalkespasien tbody tr:last-child td").find('input[name*="[rke]"]').val();
        $('#table-obatalkespasien > tbody > tr').each(function() {
            var det_id = $(this).find('.reseptur_id').val();
            if (reseptur_id == det_id) {
                hitung++;
            }
        });

        if (hitung >= 1) {
            window.parent.myAlert("Data Penjualan Resep sudah ada di tabel. Silahkan pilih yang lain.", "Perhatian!");
            return false;
        }

        if (rke == undefined) {
            rke = 1;
        } 
        // else {
        //     rke++;
        // }


        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('copyReseptur'); ?>',
            data: {
                reseptur_id: reseptur_id,
                rke: rke,
            },
            dataType: "json",
            success: function(data) {
                $('#table-obatalkespasien > tbody').append(data.tr);
                renameInputRowObatAlkes($("#table-obatalkespasien"));
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
</script>
<!-- <table class="items table table-bordered table-striped table-condensed" id="tblInputTindakan">
    <thead>
        <tr>
            <th>Tanggal Resep</th>
            <th>No. Resep</th>
            <th>Nama Dokter</th>
            <th>Copy Resep</th>
            <th>Lihat Detail</th>
            <th>Ubah</th>
            <th>Hapus</th>
        </tr>
    </thead>
    <?php //foreach ($modRiwayatResep as $i => $resep) { ?>
    <tr>        
        <td><?php //echo $resep->tglreseptur ?></td>
        <td><?php //echo $resep->noresep ?></td>
	    <?php //$pegawai = PegawaiM::model()->findByPk($resep->pegawai_id) ?>
        <td><?php //echo  $pegawai->namaLengkap ?></td>
        <td><center><?php //echo CHtml::link("<i class='fa fa-copy'></i>", '#', array('onclick' => 'copy_reseptur(' . $resep->reseptur_id . ');return false;', 'class' => '')); ?></center></td>
        <td><center><?php //echo CHtml::link("<i class='icon-eye-open'></i>", '#', array('onclick'=>'viewDetailResep("'.$resep->reseptur_id.'","'.$_GET["pendaftaran_id"].'");return false;','rel'=>'tooltip','title'=>'Klik untuk melihat detail resep'));  ?></center></td>
        <td>
                <center>
                <?php 
                    //$style = '';
                    //$url = $this->createUrl('index', ['pendaftaran_id' => $resep->pendaftaran_id, 'reseptur_id' => $resep->reseptur_id, 'pasienadmisi_id'=>isset($_GET['pasienadmisi_id'])?$_GET['pasienadmisi_id']:null, 'trans' => 'ubah']);
                    //if ($resep->isclose) {
                    //    $style = 'opacity:0.3;cursor:context-menu;';
                    //    $url = 'javascript:;';
                    //}
                    //echo CHtml::link("<i class='icon-form-ubah'></i>", $url, array('rel' => 'tooltip', 'title' => 'Klik untuk mengubah resep','style'=>$style));  
                ?>
                </center>
            </td>
	    <td><center><a onclick="hapusresep('<?php //echo $resep->reseptur_id; ?>',this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk menghapus Reseptur"><i class="icon-trash"></i></a></center></td>
    </tr>
    <?php //} ?>
</table> -->
<!-- <script type="text/javascript">
    function hapusresep(reseptur_id,obj)
    {
        tabel = obj;
        myConfirm('Apakah anda akan menghapus Reseptur ini?', 'Perhatian!', function(r)
        {
            if(r){
                $.ajax({
                    type:'POST',
                    url:'<?php //echo $this->createUrl('hapusRiwayatReseptur'); ?>',
                    data: {reseptur_id:reseptur_id},
                    dataType: "json",
                    success:function(data){
                        if(data.sukses){
                            var delete_row = $(tabel).parents('tr');
                            delete_row.detach();
                        }
                        myAlert(data.pesan);
                    },
                    error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
                });

            }
        });
    }

    function copy_reseptur (reseptur_id) {
        var hitung = 0;
        var rke = $("#table-obatalkespasien tbody tr:last-child td").find('input[name*="[rke]"]').val();
        $('#table-obatalkespasien > tbody > tr').each(function() {
            var det_id = $(this).find('.reseptur_id').val();
            if (reseptur_id == det_id) {
                hitung++;
            }
        });

        if (hitung >= 1) {
            window.parent.myAlert("Data Penjualan Resep sudah ada di tabel. Silahkan pilih yang lain.", "Perhatian!");
            return false;
        }

        if (rke == undefined) {
            rke = 1;
        } else {
            rke++;
        }


        $.ajax({
            type: 'POST',
            url: '<?php //echo $this->createUrl('copyReseptur'); ?>',
            data: {
                reseptur_id: reseptur_id,
                rke: rke,
            },
            dataType: "json",
            success: function(data) {
                $('#table-obatalkespasien > tbody').append(data.tr);
                renameInputRowObatAlkes($("#table-obatalkespasien"));

                var row = 0;

                $("#table-obatalkespasien").find("tbody > tr").each(function() {
                    $(this).find(".r").val(row + 1);
                    $(this).find(".rke").val(row + 1);
                    
                    row++;
                });
                hitungTotal();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
</script> -->

