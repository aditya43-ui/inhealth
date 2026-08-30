var _jenisSuara = "";

var _arrSuara = [];
var _arrSuaraPlayList = [];
var _arrDat = [];

// playlist steps
var _suaraLen = 0;
var _suaraIdx = 0;

// internal playlist steps
var _plLen = 0;
var _plIdx = 0;

// is antrian loaded
var _isgo = false;
var _isgo2 = false;
var _isplaying = false;
var _delay = 200;

var soundList = "";

function setDelay(v) {
    // return;
    //_delay = v;
}

function setJenisSuaraAntrian(jenis) {
    if (_jenisSuara == "") {
        _jenisSuara = jenis;
    }
}

function registerSuaraAntrian(arr, jenisSuara) {
    var suaraTru = [];
    var suaraTru2 = [];
    
    $.each(arr, function(idx, val) {
        if ($.inArray(val, suaraTru) === -1) suaraTru.push(val);
    });
    
    _arrSuaraPlayList.push(arr);
    
    var bLen = _arrSuara.length;
    $.each(suaraTru, function(idx, val) {
        
        if ($.inArray(val.name, _arrSuara) === -1) {
            _arrSuara.push(val.name);
            suaraTru2.push(val);
            bLen++;
        }
    });
    
    /*
    for (var i = 0; i < suaraTru2.length; i++) {
        console.log(suaraTru2[i]);
    }*/
    
    _suaraLen += suaraTru2.length;
    // console.log("registered sound : " + suaraTru2.length + " - total : " + _suaraLen);
    // console.log("sound path : " + _jenisSuara);
    
    if (suaraTru2.length != 0) {
        $.each(suaraTru2, function(idx, val) {
            console.log("Suara", val);
            // console.log ("To be loaded : " + _jenisSuara + val.name + ".mp3");
            if (_arrDat[val.name] == null) {
                var sound = new Howl({
                    urls: [_jenisSuara + val.name + ".mp3", _jenisSuara + val.name + ".ogg"],
                    onload: cekPreloadAntrian,
                    onend: playAntrian,
                    autoplay: false,
                    loop: false,
                    volume: 0.5,
                });
                _arrDat[val.name] = sound;
            }
        });

        _isgo2 = true;
    } else {
        _isgo2 = true;
    }
    
    if (_isgo) {
        if (!_isplaying) playAntrian();
    }
    
}

function cekPreloadAntrian() {
    _suaraIdx++;
    console.log("Loaded : " + _suaraIdx + " dari " + _suaraLen);
    
    if (_suaraIdx == _suaraLen) {
        console.log("suara loaded");
        if (!_isgo) {
            _isgo = true;
            if (!_isplaying) playAntrian();
        }
    }
}

/*
function cekPreloadAntrian(obj) {
    console.log("loaded : " + obj.name);
    _suaraIdx++;
    
    if (_suaraLen == _suaraIdx) {
        _isgo = true;
        setTimeout(function() {
            driverAntrian.play("noantrian", {volume: 0});
            //playAntrians();
            setTimeout(function() {
                playAntrians();
            }, 1000);
        }, 1000);
    }
}


*/

function delayPanggil(_delay) {
    return new Promise(resolve => setTimeout(resolve, _delay));
}

function playAntrian() {
    // console.log("Play antrian");
    //setTimeout(function() {
    delayPanggil(25).then(function() {
        if (_isgo && _isgo2) {
            if (_arrSuaraPlayList.length === 0) {
                _isplaying = false;
                return false;
            }
            _isplaying = true;
            _plLen = _arrSuaraPlayList[0].length;
            
            if (_plLen == _plIdx) {
                _arrSuaraPlayList.shift();
                _plIdx = 0;
                if (_arrSuaraPlayList.length !== 0) {
                    playAntrian();
                } else {
                    _isplaying = false;
                    _isgo2 = false;
                    if (typeof doSomethingAfterBeingCalled === 'function'){
                        doSomethingAfterBeingCalled();
                    }
                }
            } else {
                // console.log("playlist length : " + _plLen + " , playlist idx : " + _plIdx);
                // console.log("sound play : " + _arrSuaraPlayList[0][_plIdx].name);
                _arrDat[_arrSuaraPlayList[0][_plIdx].name].play();
                _plIdx++;
                console.log("play antrian hold");
                if (_plIdx == 1){
                    
                }
            }
        }
    });    

    
//}, _delay);
    
}

// function anrtian untuk tidak ada suaranya

function registerSuaraAntrianSilent(arr, jenisSuara) {
    var suaraTru = [];
    var suaraTru2 = [];
    
    $.each(arr, function(idx, val) {
        if ($.inArray(val, suaraTru) === -1) suaraTru.push(val);
    });
    
    _arrSuaraPlayList.push(arr);
    
    var bLen = _arrSuara.length;
    $.each(suaraTru, function(idx, val) {
        
        if ($.inArray(val.name, _arrSuara) === -1) {
            _arrSuara.push(val.name);
            suaraTru2.push(val);
            bLen++;
        }
    });
    
    /*
    for (var i = 0; i < suaraTru2.length; i++) {
        console.log(suaraTru2[i]);
    }*/
    
    _suaraLen += suaraTru2.length;
    // console.log("registered sound : " + suaraTru2.length + " - total : " + _suaraLen);
    // console.log("sound path : " + _jenisSuara);
    
    if (suaraTru2.length != 0) {
        $.each(suaraTru2, function(idx, val) {
            console.log("Suara", val);
            // console.log ("To be loaded : " + _jenisSuara + val.name + ".mp3");
            if (_arrDat[val.name] == null) {
                var sound = new Howl({
                    urls: [_jenisSuara + val.name + ".mp3", _jenisSuara + val.name + ".ogg"],
                    onload: cekPreloadAntrianSilent,
                    onend: playAntrianSilent,
                    autoplay: false,
                    loop: false,
                    volume: 0.0,
                });
                _arrDat[val.name] = sound;
            }
        });
        
        _isgo2 = true;
    } else {
        _isgo2 = true;
    }
    
    if (_isgo) {
        if (!_isplaying) playAntrianSilent();
    }
    
}

function cekPreloadAntrianSilent() {
    _suaraIdx++;
    console.log("Loaded : " + _suaraIdx + " dari " + _suaraLen);
    
    if (_suaraIdx == _suaraLen) {
        console.log("suara loaded");
        if (!_isgo) {
            _isgo = true;
            if (!_isplaying) playAntrianSilent();
        }
    }
}

function playAntrianSilent() {
    // console.log("Play antrian");
    //setTimeout(function() {
    delayPanggil(25).then(function() {
        if (_isgo && _isgo2) {
            if (_arrSuaraPlayList.length === 0) {
                _isplaying = false;
                return false;
            }
            _isplaying = true;
            _plLen = _arrSuaraPlayList[0].length;
            
            if (_plLen == _plIdx) {
                _arrSuaraPlayList.shift();
                _plIdx = 0;
                if (_arrSuaraPlayList.length !== 0) {
                    playAntrianSilent();
                    
                } else {
                    _isplaying = false;
                    _isgo2 = false;
                    if (typeof doSomethingAfterBeingCalled === 'function'){
                        doSomethingAfterBeingCalled();
                    }
                }
            } else {
                // console.log("playlist length : " + _plLen + " , playlist idx : " + _plIdx);
                // console.log(_arrSuaraPlayList);
                // var durasiDelay = 0;
                // for(i = 0; i < _plLen; i++) {
                //     // console.log(_arrDat[_arrSuaraPlayList[0][i].name]._duration);
                //     durasiDelay += _arrDat[_arrSuaraPlayList[0][i].name]._duration;
                // }

                // durasiDelay = durasiDelay * 1000;
                // console.log(durasiDelay);

                // _arrDat[_arrSuaraPlayList[0][_plIdx].name].mute();
                // console.log(_arrDat[_arrSuaraPlayList[0][_plIdx].name]._duration);
                // console.log(_arrDat[_arrSuaraPlayList]);
                // _plIdx++;
                // delayPanggil(durasiDelay +100).then(function(){
                //     if (typeof doSomethingAfterBeingCalled === 'function'){
                //         doSomethingAfterBeingCalled();
                //     }
                // }) ;
                // console.log("play antrian hold");
                // if (_plIdx == 1){
                    
                // }
                _arrDat[_arrSuaraPlayList[0][_plIdx].name].play();
                _plIdx++;
                console.log("play antrian hold");
                if (_plIdx == 1){
                    
                }
            }
        }
    });    

    
//}, _delay);
    
}

