<?php 
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $url = Yii::app()->createAbsoluteUrl($module . '/' . $controller); 
?>
<script type="text/javascript">
        function ubahStatus(id, status) {
            var url = '<?php echo $url . "/ubahStatus"; ?>';
            myConfirm("Anda yakin akan " + status +" data ini?", 'Perhatian!', function(r) {
                if (r) {
                    $.post(url, {
                            id: id,
                            status:status
                        },
                        function(data) {
                            if (data.status == 1) {
                                $.fn.yiiGridView.update('kelengkapandokumen-m-grid');
                            } else {
                                myAlert('Data gagal' + status);
                            }
                        }, "json");
                }
            });
        }

        function deleteRecord(id) {
            var id = id;
            var url = '<?php echo $url . "/delete"; ?>';
            myConfirm("Yakin Akan Menghapus Data ini?", 'Perhatian!', function(r) {
                if (r) {
                    $.post(url, {
                            id: id
                        },
                        function(data) {
                            if (data.ok == 1) {
                                toastr.success('Data Berhasil Dihapus');
                                $.fn.yiiGridView.update('kelengkapandokumen-m-grid');
                            } else {
                                myAlert('Data gagal dihapus!')
                            }
                        }, "json");
                }
            });
        }

        function setKelompokDokumen(obj) {
            var valueLevel= $(obj).val();
            console.log(valueLevel);
            if(valueLevel == 1) {
                $('#kelompok_dokumen').attr('disabled', true);
                $('#kelompok_dokumen').removeClass('required');
                
            } else if(valueLevel == 2){
                $('#kelompok_dokumen').attr('disabled', false);
                $.get('<?= $url . '/getKelompokDokumen' ?>', {
                    level:valueLevel
                }, function(data) {
                    $('#kelompok_dokumen').html(data.option);
                    $('#kelompok_dokumen').addClass('required');
                }, 'json');
            } else {
                $('#kelompok_dokumen').removeClass('required');
                $('#kelompok_dokumen').html('<option value="">---Pilih---</option>');
            }
        }
    </script>