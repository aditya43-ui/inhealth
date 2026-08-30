<style>
    .booking_base {
        width: 500px;
        background-color: rgba(255, 255, 255, .5);
        border: 1px solid black;
        padding: 10px;
        padding-bottom: 30px;
    }

    .booking_base .booking_msg {
        font-size: 16px;
        padding: 20px;
    }

    #txt_no_bookng {
        font-size: 20px;
        line-height: 30px;
    }

    #booking_btn {
        line-height: 13px;
        padding: 10px;
    }

    .btn-success{
    background-color: #006838 !important;
    border-color: #006838 !important;
    }
    .input{
    border: 1px solid #006838 !important;
    }

</style>

<div class="booking_base">

    <div class="booking_msg">SCAN BARCODE / MASUKAN KODE BOOKING</div>
    <div class="booking_field">
        <?php echo CHtml::textField('txt_no_bookng', '', array()); ?>
        <?php echo CHtml::button('Check-In', array('class'=>'btn btn-success', 'id'=>'booking_btn', 'onclick'=>'daftarBooking();')); ?>
    </div>
    <iframe id="print_win_daftar" src="" style="display: none;"></iframe>
</div>

<script>

    function toBooking() {
        $("#penjamin .item-a").hide();
        $("#penjamin #item-checkin").show();
        $("#txt_no_bookng").val("").focus();
    }

    function daftarBooking() {
        var no_booking = $("#txt_no_bookng").val();
        
        $("#booking_btn").addClass('animation-loading').prop("disabled", true);

        $.post('<?php echo $this->createUrl('daftarBooking'); ?>', {no_booking: no_booking}, function(data) {
            if (data.ok == 1) {
                // alert(data.msg);
                $("#txt_no_bookng").val("");
                toPenjamin();
                printBooking(data.id);
            } else {
                alert(data.msg);
            }
            $("#booking_btn").removeClass('animation-loading').prop("disabled", false);
        }, 'json');

    }

    function printBooking(pendaftaran_id) {
        $("#print_win_daftar").attr('src', "<?php echo $this->createUrl('printKarcis') ?>&pendaftaran_id=" + pendaftaran_id);
    }

    function ketikBooking(e) {
        
        if (e.keyCode == 13) {
            e.preventDefault();
            daftarBooking();
        }
        console.log(e.keyCode);

    }

    $(document).ready(function() {
        $("#txt_no_bookng").on('keydown', ketikBooking);
    });

</script>