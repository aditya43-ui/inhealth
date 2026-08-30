/**
 * source: http://jsfiddle.net/RZXEF/
 * @type Number
 * modified by:
 */
var IDLE_TIMEOUT = 60*60; //seconds (detik)

var _idleSecondsCounter = 0;
document.onclick = function() {
    _idleSecondsCounter = 0;
};
document.onmousemove = function() {
    _idleSecondsCounter = 0;
};
document.onkeypress = function() {
    _idleSecondsCounter = 0;
};
// window.setInterval('CheckIdleTime()', 1000);

function CheckIdleTime() {
    _idleSecondsCounter++;
//    COUNTER TIDAK DITAMPILKAN
//    var oPanel = document.getElementById("SecondsUntilExpire");
//    if (oPanel)
//        oPanel.innerHTML = (IDLE_TIMEOUT - _idleSecondsCounter) + "";
    if (_idleSecondsCounter >= IDLE_TIMEOUT) {
//        alert("Session login Anda telah habis !");
        _idleSecondsCounter = 0;
        document.location.href = "index.php?r=site/logout";
    }
}
