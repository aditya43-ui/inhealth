<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
			<?php echo CHtml::label('Instalasi', '', array('class'=>'control-label')); ?>
			<div class="controls">
				<?php
                    $cr = new CDbCriteria();
                    $cr->addCondition("ispelayanan = true");
                    // $cr->addCondition("instalasirujukaninternal = false");
                    $cr->addCondition("instalasi_adakamar = false");
                    $cr->addCondition("isadministrasi = false");
                    $cr->addInCondition("instalasi_id", array(Params::INSTALASI_ID_RJ));
                    // $cr->compare('profilrs_id', Yii::app()->user->getState('profilrs_id'));
                    $cr->order = "instalasi_nama asc";
                    echo CHtml::dropDownList('checkJadwal[instalasi]', '', CHtml::listData(InstalasiM::model()->findAll($cr), 'instalasi_id', 'instalasi_nama'),
                                array('empty'=>'-- Pilih --',
                                      'id'=>'instalasi',
                                      'class' => 'required form-control span4',
                                      'onchange'=>'$("#inputForm").html(""); getRuangan();',
									/*
                                      'ajax'=>array('url'=>$this->createUrl('ajaxListPoli'),
                                                    'type'=>'POST',
                                                    'update'=>'#inputPoli'),
									 *
									 */
									));
                ?>
			</div>
		</div>
        <div class="control-group">
			<?php echo CHtml::label('Ruangan', '', array('class'=>'control-label')); ?>
			<div class="controls">
				<?php echo CHtml::dropDownList('checkJadwal[poliklinik]', null, array(), array(
					'empty'=>'-- Pilih --', 'class'=>'span4', 'id'=>'inputPoli',
                    'onchange'=>'getListDokter(); getPoli(); ',
				)); ?>
			</div>
		</div>
        <div class="control-group">
			<?php echo CHtml::label('Poliklinik', '', array('class'=>'control-label')); ?>
			<div class="controls">
				<?php echo CHtml::dropDownList('checkJadwal[ruangan]', null, array(), array(
					'empty'=>'-- Pilih --', 'class'=>'span4', 'id'=>'inputRuangan',
                    'onchange'=>'getListDokter();',
                    'onclick'=>'setData(); getIp();',
				)); ?>
			</div>
		</div>
        <div class="control-group">
            <?php echo CHtml::label('Dokter', '', array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::dropDownList('checkJadwal[pegawai]', null, array(), array(
                    'empty'=>'-- Pilih --', 'id'=>'inputPegawai', 'class'=>'span4'
                )); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Segment', '', array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'check_ipsegment', array(
                    'empty'=>'-- Pilih --','class'=>'span4', 'id'=>'inputSegment' , 'readonly'=>true
                )); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Port', '', array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'check_port', array(
                    'empty'=>'-- Pilih --', 'class'=>'span4', 'id'=>'inputPort' , 'readonly'=>true
                )); ?>
            </div>
        </div>
    </div>
</div>
<script>
    $("#inputSegment").val('');
    $("#inputPort").val('');

    function checkout(id) {
        // alert("id ="+id);
        myConfirm("Anda yakin untuk chekout dokter ini ?", "Peringatan", function(r) {
            if (r) {
                $.post('<?php echo $this->createUrl("batalRujukKeluar"); ?>', {id: id}, function(data) {
                    if (data.ok == 1) {
                        myAlert("Dokter berhasil checkout.");
                        // setTindakanPelayanan();
                        window.location.reload();
                    } else {
                        myAlert("Dokter gagal checkout.<br>" + data.msg);
                    }
                }, 'json');
            }
        });
    }
    
    //split data dan pengecekan jika poli sedang di gunakan
    function setData(){
        var poliklinik_nama = $("#inputRuangan").find(':selected').text();
	
        var split = poliklinik_nama.split(" --- ");
        if (typeof split[1] !== "undefined"){
            myAlert(split[0]+' Masih Digunakan oleh '+split[1]);
            $("#inputRuangan").val('');
            return false;
        }
    }
    function getRuangan() {
	    var id = $("#instalasi").val();

	    $.post('<?php echo $this->createUrl('ajaxListPoli');?>', {id: id}, function(data) {
		    $("#inputPoli").html(data.list);
		// jQuery("#inputPoli").multiselect("rebuild");
	    }, 'json');
    }

    function getPoli(){
        var poliklinik_id = $("#inputPoli").val();
        var poliklinik_nama = $("#inputRuangan").find(':selected').text();

        $.post('<?php echo $this->createUrl('AjaxListRuangan'); ?>', {poliklinik_id: poliklinik_id, poliklinik_nama: poliklinik_nama}, function(data) {
            // console.log(data.data[0].pegawai_id);
            $("#inputRuangan").html(data.list);
        }, 'json');
    }

    function getListDokter() {
        var ruangan_id = $("#inputPoli").val();

        $.post('<?php echo $this->createUrl('ajaxListDokterRuangan'); ?>', {ruangan_id: ruangan_id}, function(data) {
            $("#inputPegawai").html(data.list);
        }, 'json');
    }

    function getRuangan() {
	    var id = $("#instalasi").val();

	    $.post('<?php echo $this->createUrl('ajaxListPoli');?>', {id: id}, function(data) {
		    $("#inputPoli").html(data.list);
		// jQuery("#inputPoli").multiselect("rebuild");
	    }, 'json');
    }

    function getIp(){
        var poliklinik_id = $("#inputRuangan").find(':selected').text();
        // alert("Poliklinik =", poliklinik_id);
        $.post('<?php echo $this->createUrl('AjaxListIp'); ?>', {poliklinik_id: poliklinik_id}, function(data) {
            // console.log(data.list[0].ip_address);
            $("#inputSegment").val(data.list[0].ip_address);
            $("#inputPort").val(data.list[0].ip_port)
        }, 'json');
    }

    // function checkout(){
    //     alert("Sedang di kerjakan");
    // }

</script>