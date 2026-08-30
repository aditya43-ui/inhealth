<style>
    .checkin_base {
        text-align: center;
    }

    body{
    background:none !important;
    margin: 0px !important;
    }
    .booking_base {
        width: 500px;
        background-color: rgba(255, 255, 255, .5);
        border: 1px solid black;
        padding: 10px;
        padding-bottom: 30px;
    }

    .booking_title {
        font-weight: bold;
        font-size: 50px;
        color: #006838;
    }
    .botom{
        padding-top: 170px !important;
    }

    .booking_rs {
        font-size: 28px;
        color: #ED1E79;
    }

    .booking_msg {
        font-size: 16px;
        color: #006838;
        padding: 20px;
    }

    #txt_no_bookng {
        font-size: 14px;
        line-height: 30px;
        padding: 0px 10px;
    }
    #footerAntrian{
        width: 100% !important;
    }
    #booking_btn {
        line-height: 13px;
        padding: 10px;
    }

    .btn-success {
        background-color: #006838 !important;
        border-color: #006838 !important;
        border-radius: 30px;
        margin-left: 10px;
    }

    input {
        border: 1px solid #ED1E79 !important;
        border-radius: 30px;
        width: 300px;
    }
    .sosmed{
        float: right;
        font-size: 20px;
        margin-left: 5px;
    }
    .sosmed a{
        text-decoration: none;
    }
    .sosmed1{
        float: right;
        font-size: 13px;
        margin-left: 5px;
    }
    .sosmed1 a, .sosmed1 a:hover{
        text-decoration: none;
        color: #006838;
    }
    
.btn-danger:hover,
.btn-danger:focus,
.btn-danger:active,.btn-danger{
    background-color: #ED1E79;
    border-color: #ED1E79;
    color: #fff;
        border-top-left-radius: 30px;
        border-bottom-right-radius: 30px;
        width: 150px;
        height: 30px;
    }
</style>

<!-- <div class="booking_base"> -->
<div class="checkin_base">
    <div class="sosmed">
        <a href=""><div class="btn btn-danger" type="button">Sariasih.com</div></a>
    </div>
    <div class="sosmed1">
        <a href=""><i class="fa-youtube-play"></i>RS Sari Asih</a>
    </div>
    <div class="sosmed1">
        <a href=""><i class="entypo-facebook-circled"></i>RS Sari Asih Group</a>
    </div>
    <div class="sosmed1">
        <a href=""><i class="entypo-instagram"></i>@rssariasih</a>
    </div>
        <div id="ekios1x" style="padding-top: 120px !important;"></div>
    <div class="booking_title">KIOS DIGITAL</div>
    <?php
    // $profil = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
    // echo $profil->nama_rumahsakit;
    $config = KonfigsystemK::model()->find();
    ?>
    <div class="booking_rs">RUMAH SAKIT SARI ASIH</div>
    <div class="booking_msg">
        Silahkan Masukan Kode Booking :<br />
        <b>No. Rekam Medis</b> (Kartu Berobat Pasien)<br />
        atau <b>No. Kartu BPJS Kesehatan</b>
    </div>
    <div class="booking_field">
        <?php echo CHtml::textField('txt_no_bookng', '', array("placeholder" => "No. Rekam Medis/No. BPJS Kesehatan")); ?>
        <?php echo CHtml::button('Check-In', array('class' => 'btn btn-success', 'id' => 'booking_btn', 'onclick' => 'daftarBooking();')); ?>
    </div>
    <iframe id="print_win_daftar" src="" style="display: none;"></iframe>
    <div class="row botom">
        <div class="block-footer-antrian">
            <div id="footerAntrian">
                <marquee direction="left" scrollamount="10" id="textrunning">
                    <?php echo $config->running_text_kiosk; ?>
                </marquee>
            </div>
            <!-- <div id="footerClock"></div> -->
        </div>
    </div>
</div>
<!-- </div> -->

<script>
    function toBooking() {
        $("#penjamin .item-a").hide();
        $("#penjamin #item-checkin").show();
        $("#txt_no_bookng").val("").focus();
    }

    function daftarBooking() {
        var no_booking = $("#txt_no_bookng").val();

        $("#booking_btn").addClass('animation-loading').prop("disabled", true);

        $.post('<?php echo $this->createUrl('daftarBooking'); ?>', {
            no_booking: no_booking
        }, function(data) {
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