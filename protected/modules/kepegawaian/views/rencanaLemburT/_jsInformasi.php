<style>
    .yellow_focus td {
        background-color: yellow !important;
    }
</style>
<script>

function setDisetujui(tglsetuju,tglpemberitugas,id, obj, pegawai) {
    selectRow(obj);
	
	if (pegawai != <?php echo Yii::app()->user->getState('pegawai_id') ?>){
		myAlert("Hanya pegawai pemberi tugas yang bisa mengakses fitur ini");
		deselectRow();
		return false;
	}
    if (tglsetuju == 'kosong' || tglpemberitugas == 'kosong'){
		myAlert("Data belum di approve");
		deselectRow();
		return false;
	}
	
    myConfirm("Anda yakin untuk menyetujui rencana ini?", "Peringatan", function(r) {
        if (r) {
            $.post('<?php echo $this->createUrl('setSetuju'); ?>', {id: id}, function(data) {
                if (data.ok == 1) {
                    myAlert(data.msg);
                    $.fn.yiiGridView.update('rencana-lembur-t-grid');
                } else {
                    myAlert(data.msg);
                }
            }, 'json');
            deselectRow();
        } else {
            deselectRow();
        }
    });
}

function setTolak(id, obj, pegawai) {
    selectRow(obj);
	
	if (pegawai != <?php echo Yii::app()->user->getState('pegawai_id') ?>){
		myAlert("Hanya pegawai pemberi tugas yang bisa mengakses fitur ini");
		deselectRow();
		return false;
	}
	
    myPrompt("Alasan Penolakan", "", "Penolakan Rencana Lembur", function(r) {
        if (r == null) {
            deselectRow();
        } else if (r.trim() != "") {
            $.post('<?php echo $this->createUrl('setTolak'); ?>', {id: id, alasan: r}, function(data) {
                if (data.ok == 1) {
                    myAlert(data.msg);
                    $.fn.yiiGridView.update('rencana-lembur-t-grid');
                } else {
                    myAlert(data.msg);
                }
            }, 'json');
            deselectRow();
        } else {
            deselectRow();
        }
    });
}

function setBatal(id, obj, pegawai) {
    selectRow(obj);
	
	if (pegawai != <?php echo Yii::app()->user->getState('pegawai_id') ?>){
		myAlert("Hanya pegawai pemberi tugas yang bisa mengakses fitur ini");
		deselectRow();
		return false;
	}
	
    myPrompt("Alasan Pembatalan", "", "Pembatalan Rencana Lembur", function(r) {
        if (r == null) {
            deselectRow();
        } else if (r.trim() != "") {
            $.post('<?php echo $this->createUrl('setBatal'); ?>', {id: id, alasan: r}, function(data) {
                if (data.ok == 1) {
                    myAlert(data.msg);
                    $.fn.yiiGridView.update('rencana-lembur-t-grid');
                } else {
                    myAlert(data.msg);
                }
            }, 'json');
            deselectRow();
        } else {
            
            deselectRow();
        }
    });
}

function selectRow(obj) {
    console.log($(obj).parents("tr"));
    $(obj).parents("tr").addClass("yellow_focus");
}

function deselectRow() {
    $("#rencana-lembur-t-grid tr").removeClass("yellow_focus");
}

</script>