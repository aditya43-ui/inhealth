<script>

//     function simpanAllData_dws(){
//   if(requiredCheck($('.formICU').find("#icu-t-form"))){
//     var indexNext = $('.formICU').find('#rootwizardICU').data('bootstrapWizard').nextIndex();
//     var indexstep = $('.formICU').find('#rootwizardICU').data('bootstrapWizard').currentIndex();
//     $(".formICU").addClass("animation-loading");
//     $('.formICU').find(".integer-decimal, .integer2, .float2").each(function(){
//         $(this).val(unformatNumber($(this).val()));
//     });
//     var pendaftaran_id = $('#<?php // echo Chtml::activeId($model, 'pendaftaran_id') ?>').val();
//     var pasienadmisi_id = $('#<?php // echo Chtml::activeId($model, 'pasienadmisi_id') ?>').val();
//     var pasien_id = $('#<?php // echo Chtml::activeId($model, 'pasien_id') ?>').val();
//     var kriteriamasukicu_id = $('#<?php // echo Chtml::activeId($model, 'kriteriamasukicu_id') ?>').val();

//     var dataSerialized = $('.formICU').find('#icu-t-form').serializeArray();
//     dataSerialized.push({name: 'indexcurrent',value:indexstep});
//     dataSerialized.push({name: 'indexNext',value:indexNext});
//     dataSerialized.push({name: 'KriteriamasukicuT[pendaftaran_id]',value:pendaftaran_id});
//     dataSerialized.push({name: 'KriteriamasukicuT[pasienadmisi_id]',value:pasienadmisi_id});
//     dataSerialized.push({name: 'KriteriamasukicuT[kriteriamasukicu_id]',value:kriteriamasukicu_id});
   
//     if(indexstep > 1){
//       $('#checkSimpanData').val('simpan');
//     }else if (indexstep == 1){
//       $('#checkSimpanData').val('');
//     }
//     var checksimpan = $('#checkSimpanData').val();
//     dataSerialized.push({name: 'checksimpan',value:checksimpan});

//     $.ajax({
//         type:'POST',
//         url:'<?php // echo $this->createUrl('SimpanOrLoad'); ?>',
//         data: dataSerialized,
//         dataType: "json",
//         'async': false,
//         success:function(data){
//           suksesData = false;
//           if(data != ""){
//             if(data.sukses > 0){
//               suksesData = true;
//               $('.formICU').find('.divAlert').html('<div class="alert alert-block alert-success"><a class="close" data-dismiss="alert">×</a>'+data.pesan+'</div>');
//               $.fn.yiiGridView.update('observasi-grid', {
//                   data: $(this).serialize()
//               });
//             }else{
//               $('.formICU').find('.divAlert').html('<div class="alert alert-block alert-error"><a class="close" data-dismiss="alert">×</a>'+data.pesan+'</div>');
//             }
//             if(suksesData==true){
//               setTimeout(function(){
//                   $('.formICU').find('.divAlert').html('');
//               }, 5000);
//             }
//           }else{
//               $('.formICU').find('.divAlert').html('<div class="alert alert-block alert-error"><a class="close" data-dismiss="alert">×</a>Data Gagal disimpan!!</div>');

//           }
//           $(".formICU").removeClass("animation-loading");
//         },
//         error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown); $(".formICU").removeClass("animation-loading");}
//     });
//   }
// }


// function simpanDataForm_dws(simpanDt, indexstep, handeland){
//   var suksesData = false;
//     if(requiredCheck($('.formICU').find(simpanDt))){
//       var indexNext = $('.formICU').find('#rootwizardICU').data('bootstrapWizard').nextIndex();
//       $(".formICU").addClass("animation-loading");
//       $('.formICU').find(".integer-decimal, .integer2, .float2").each(function(){
//           $(this).val(unformatNumber($(this).val()));
//       });
//       var pendaftaran_id = $('#<?php // echo Chtml::activeId($model, 'pendaftaran_id') ?>').val();
//       var pasienadmisi_id = $('#<?php // echo Chtml::activeId($model, 'pasienadmisi_id') ?>').val();
//       var pasien_id = $('#<?php // echo Chtml::activeId($model, 'pasien_id') ?>').val();
//    //   var jenisasesmen = $('#choise_dewasa').find('#<?php // echo Chtml::activeId($model, 'jenisasesmen') ?>').val();
//       var kriteriamasukicu_id = $('#<?php // echo Chtml::activeId($model, 'kriteriamasukicu_id') ?>').val();

//       if(indexstep > 1){
//         $('#checkSimpanData').val('simpan');
//       }else if (indexstep == 1){
//         $('#checkSimpanData').val('');
//       }

//       var checksimpan = $('#checkSimpanData').val();

//       var dataSerialized = $('.formICU').find(simpanDt).serializeArray();
//       dataSerialized.push({name: 'indexcurrent',value:indexstep});
//       dataSerialized.push({name: 'indexNext',value:indexNext});
//       dataSerialized.push({name: 'checksimpan',value:checksimpan});
//       dataSerialized.push({name: 'KriteriamasukicuT[kriteriamasukicu_id]',value:kriteriamasukicu_id});
//       dataSerialized.push({name: 'KriteriamasukicuT[pendaftaran_id]',value:pendaftaran_id});
//       dataSerialized.push({name: 'KriteriamasukicuT[pasienadmisi_id]',value:pasienadmisi_id});

//       $.ajax({
//           type:'POST',
//           url:'<?php // echo $this->createUrl('SimpanOrLoad'); ?>',
//           data: dataSerialized,
//           dataType: "json",
//           'async': false,
//           success:function(data){
//             suksesData = false;
//             if(data != ""){
//               if(data.sukses > 0){
//                 suksesData = true;
//                 $('.formICU').find('.divAlert').html('<div class="alert alert-block alert-success"><a class="close" data-dismiss="alert">×</a>'+data.pesan+'</div>');
//                 $.fn.yiiGridView.update('observasi-grid', {
//                     data: $(this).serialize()
//                 });
//               }else{
//                 $('.formICU').find('.divAlert').html('<div class="alert alert-block alert-error"><a class="close" data-dismiss="alert">×</a>'+data.pesan+'</div>');
//               }

//               if(suksesData==true){
//                 setTimeout(function(){
//                     $('.formICU').find('.divAlert').html('');
//                 }, 5000);
//               }


//             }else{
//                 $('.formICU').find('.divAlert').html('<div class="alert alert-block alert-error"><a class="close" data-dismiss="alert">×</a>Data Gagal disimpan!!</div>');
//             }
//             $(".formICU").removeClass("animation-loading");
//           },
//           error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown); $(".formICU").removeClass("animation-loading");}
//       });
//     }
//     return suksesData;
// }



var currentTab = 0; // Current tab is set to be the first tab (0)
showTab(currentTab); // Display the current tab

function showTab(n) {
  // This function will display the specified tab of the form...
  var x = document.getElementsByClassName("tab-pane");
  x[n].style.display = "block";
  //... and fix the Previous/Next buttons:
  if (n == 0) {
    document.getElementById("prevBtn").style.display = "none";
  } else {
    document.getElementById("prevBtn").style.display = "inline";
  }
  if (n == (x.length - 1)) {
    document.getElementById("nextBtn").innerHTML = "Submit";
  } else {
    document.getElementById("nextBtn").innerHTML = "Next";
  }
  //... and run a function that will display the correct step indicator:
  fixStepIndicator(n)
}

function nextPrev(n) {
  // This function will figure out which tab to display
  var x = document.getElementsByClassName("tab-pane");
  // Exit the function if any field in the current tab is invalid:
  if (n == 1 && !validateForm()) return false;
  // Hide the current tab:
  x[currentTab].style.display = "none";
  // Increase or decrease the current tab by 1:
  currentTab = currentTab + n;
  // if you have reached the end of the form...
  if (currentTab >= x.length) {
    // ... the form gets submitted:
    document.getElementById("kriteriamasukicu-t-form").submit();
    return false;
  }
  // Otherwise, display the correct tab:
  showTab(currentTab);
}

function validateForm() {
  // This function deals with validation of the form fields
  var x, y, i, valid = true;

  x = document.getElementsByClassName("tab-pane");
  y = x[currentTab].getElementsByClassName("btn");
  // A loop that checks every input field in the current tab:
  for (i = 0; i < y.length; i++) {
    // If a field is empty...
    if (y[i].value == "") {
      // add an "invalid" class to the field:
      y[i].className += " invalid";
      // and set the current valid status to false
      valid = false;
    }
  }
  
  // If the valid status is true, mark the step as finished and valid:
  if (valid) {

    $('.kriteriamasukicu-t-form').find('#<?php echo CHtml::activeId($model,'kardiovaskular_ismiokardinfark') ?>').val();

    document.getElementsByClassName("step")[currentTab].className += " finish";
  }
  return valid; // return the valid status
}



function fixStepIndicator(n) {
  // This function removes the "active" class of all steps...
  var i, x = document.getElementsByClassName("step");
  for (i = 0; i < x.length; i++) {
    x[i].className = x[i].className.replace(" active", "");
  }
  //... and adds the "active" class on the current step:
  x[n].className += " active";
}




$('#checkSimpanData').val('');
    $('.formICU').find('#rootwizardICU').bootstrapWizard({
      tabClass: "",
        onTabShow: function($tab, $navigation, index)
        {
          setCurrentProgressTab($(this), $navigation, $tab, $(this).find(".steps-progress div"), index);
        },
        onPrevious: function(tab, navigation, index){
        },
        onNext: function(tab, navigation, index){
          var postdata = $('.formICU').find('#icu-t-form');
          var indexStepDewasa = 9;
          
          var cekDewasa = simpanDataForm_dws(postdata, index);
          if(index == indexStepDewasa && cekDewasa==true){
              $('.formICU').find('.next').hide();
          }else{
            $('.formICU').find('.next').show();
          }

          return cekDewasa;
          // return true;
        },
        onTabClick: function(tab, navigation, index){
        }
      });

</script>