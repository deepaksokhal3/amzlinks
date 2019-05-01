  toastr.options = {
    closeButton:true,
    newestOnTop: $('#newestOnTop').prop('checked'),
    progressBar: true,
    positionClass: 'toast-top-right',
    onclick: null
  };
// DELETE CAMPAIGNS
var campainDelete = function(e){
	var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
	$.ajax({
        type: "POST",
        url: APP_URL+'/campaign/delete',
        data: {_token: CSRF_TOKEN, id: e},
        success: function( res ,status) {
        	res = JSON.parse(res);
        	if(res.sucsess){
            	toastr["success"](res.sucsess);
            	jQuery('#camp-row-'+e).remove();
        	}else{
        		toastr["error"](res.error);
        	}
        }
    });
}


var  TrakingId;
// DELETE Tracking Links
var  confirmTrackingLinksDelete =function(e){
    TrakingId = e;
    $('#dangerModal').modal('show');
}
var trackingLinksDelete = function(e){
    if(e){
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            type: "POST",
            url: APP_URL+"/tracking-links/delete",
            data: {_token: CSRF_TOKEN, id: TrakingId},
            success: function( res ,status) {
                res = JSON.parse(res);
                if(res.sucsess){
                    toastr["success"](res.sucsess);
                    jQuery('#row-trk-lnk-'+TrakingId).remove();
                    $('#dangerModal').modal('hide');
                }else{
                    toastr["error"](res.error);
                }
            }
        });
    }
}
// SHOW EXAMPLE CODE WHEN CHANGE TRACKING CODE TYPE 
var socialSelectScriptType = function(e){
    document.getElementById('pixel_example').src="/img/social-script/pixel_"+e.value+".png";
}
var trackingCodeDelete = function(e){
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        type: "POST",
        url: APP_URL+'/tracking/delete',
        data: {_token: CSRF_TOKEN, id: e},
        success: function( res ,status) {
            res = JSON.parse(res);
            if(res.sucsess){
                toastr["success"](res.sucsess);
                jQuery('#track-row-'+e).remove();
            }else{
                toastr["error"](res.error);
            }
        }
    });
}
var REDIRECTMODE= 1;
// CREATE NEW CLONE INPUT
var select;
var newDestinationUrl = function(e){
     var counter=1;
    jQuery("#destination-url-container .destination-Url_bs").each(function(){
        counter++;
    });
    e1 = (e =='new' || e =='edit')?1:e;
    var newDesUrl = document.getElementById('destination-Url_bs-'+e1);
    var cln = newDesUrl.cloneNode(true);
    if(e !='new'){
        cln.setAttribute('id','destination-Url_bs-'+counter);
        cln.childNodes[1].textContent = "Destination URL "+counter;
        if(cln.childNodes[3].childNodes[1].getElementsByClassName('dataPicker').length > 0){
                select =  cln.childNodes[3].childNodes[1].getElementsByClassName('dataPicker')[0];
                cln.childNodes[3].childNodes[1].getElementsByClassName('dataPicker')[0].parentElement.removeChild(cln.childNodes[3].childNodes[1].getElementsByClassName('dataPicker')[0]);
            select.childNodes[0].setAttribute('id','select-url'+counter);
            select.childNodes[1].parentElement.removeChild(select.childNodes[1]);
            select.childNodes[1].parentElement.removeChild(select.childNodes[1]);
        }
        select.childNodes[0].setAttribute('id','select-url'+counter);
           if(e=='edit'){
            select.getElementsByTagName('select')[0].setAttribute('name','destination[select][]');
            var isMobileVersion = document.getElementsByClassName('percentage_input');
            if (isMobileVersion.length > 0) {
                cln.childNodes[3].childNodes[1].getElementsByClassName('percentage_input')[0].setAttribute('name','percentage[new][]');
            }
            cln.childNodes[3].childNodes[1].getElementsByClassName('destination_input')[0].setAttribute('name','destination[new][]');
            cln.childNodes[3].childNodes[1].getElementsByClassName('destination_input')[0].style.display = 'block';
            cln.childNodes[3].childNodes[1].getElementsByClassName('destination_input')[0].value='';
            cln.childNodes[3].childNodes[1].getElementsByClassName('input-group-append')[0].childNodes[3].childNodes[1].setAttribute('rm-data','');
            cln.childNodes[3].childNodes[1].getElementsByClassName('input-group-append')[0].childNodes[3].childNodes[3].setAttribute('rm-data','');
        }
        cln.childNodes[3].childNodes[1].insertAdjacentHTML('afterbegin',select.innerHTML);

        cln.childNodes[3].childNodes[1].getElementsByClassName('destination_input')[0].style.display = 'none';
        cln.childNodes[3].childNodes[1].getElementsByClassName('destination_input')[0].value='';
       cln.childNodes[3].childNodes[1].getElementsByClassName('input-group-append')[0].childNodes[3].childNodes[1].setAttribute("onclick","setDestinationUrlAction('amz',"+counter+",this)");
       cln.childNodes[3].childNodes[1].getElementsByClassName('input-group-append')[0].childNodes[3].childNodes[3].setAttribute("onclick","setDestinationUrlAction('url',"+counter+",this)");
      
        cln.insertAdjacentHTML('beforeend', '<i class="fa fa-trash"  onclick="rmDestinationUrl(this)" style="float: right; position: absolute; margin-top: -23px; color:#f63c3a; cursor: pointer;"></i>');


        document.getElementById("destination-url-container").appendChild(cln);
         // document.getElementById('addNewDestinationBtn').setAttribute('onclick','newDestinationUrl('+counter+')');
    }else{
        cln.setAttribute('id','destination-Url_bs-'+counter);
        cln.childNodes[1].textContent = "Destination URL "+counter;
        cln.insertAdjacentHTML('beforeend', '<i class="fa fa-trash"  onclick="rmDestinationUrl(this)" style="float: right; position: absolute; margin-top: -23px; color:#f63c3a; cursor: pointer;"></i>');
        document.getElementById("destination-url-container").appendChild(cln);
         document.getElementById('addNewDestinationBtn').setAttribute('onclick',"newDestinationUrl('"+e+"')");
    }
    jQuery("#select-url"+counter).selectpicker("refresh");
}


var rmDestinationUrl = function(e){
        if(document.getElementById('rmLnkIds')){
            document.getElementById('rmLnkIds').value = document.getElementById('rmLnkIds').value? document.getElementById('rmLnkIds').value+','+e.getAttribute('rm-data'):e.getAttribute('rm-data');
        }
      e.parentElement.remove();
}

var copyUrl = function(idParm) {
    var copyText = document.getElementById(idParm);
    var textArea = document.createElement("textarea");
    textArea.value = copyText.textContent;
    document.body.appendChild(textArea);
    textArea.select();
    document.execCommand("Copy");
    textArea.remove();
    jQuery('#'+idParm).prev().css('display','block');
    setTimeout(function(){ jQuery('#'+idParm).prev().css('display','none'); }, 1000);
}

if(window.location.href.includes('tracking-links/edit')){
    jQuery('#hidn-drop').selectpicker('hide');
}
var setDestinationUrlAction = function(e,RowNumber,event){  
    try{
          if(document.getElementById('rmLnkIds')){
                document.getElementById('rmLnkIds').value = document.getElementById('rmLnkIds').value? document.getElementById('rmLnkIds').value+','+event.getAttribute('rm-data'):event.getAttribute('rm-data');
            }
          var el = document.getElementById('destination-Url_bs-'+RowNumber);
        if(e == "amz"){
            if(el.childNodes[3].childNodes[1].getElementsByClassName('dataPicker').length >0){
                select =  el.childNodes[3].childNodes[1].getElementsByClassName('dataPicker')[0];
                select.childNodes[1].parentElement.removeChild(select.childNodes[1]);
                select.childNodes[1].parentElement.removeChild(select.childNodes[1]);
               el.childNodes[3].childNodes[1].getElementsByClassName('dataPicker')[0].parentElement.removeChild(el.childNodes[3].childNodes[1].getElementsByClassName('dataPicker')[0]);
           }
            select.childNodes[0].setAttribute('id','select-url'+RowNumber);
            if(document.getElementById('rmLnkIds')){
                select.getElementsByTagName('select')[0].setAttribute('name','destination[select][]');
                el.childNodes[3].childNodes[1].getElementsByClassName('destination_input')[0].setAttribute('name','destination[new][]');
            }
            el.childNodes[3].childNodes[1].insertAdjacentHTML('afterbegin',select.innerHTML);
            el.childNodes[3].childNodes[1].getElementsByClassName('destination_input')[0].style.display = 'none';
            el.childNodes[3].childNodes[1].getElementsByClassName('destination_input')[0].value='';
        }else{
            if(el.childNodes[3].childNodes[1].getElementsByClassName('dataPicker').length >0){
                select =  el.childNodes[3].childNodes[1].getElementsByClassName('dataPicker')[0];
                 if(document.getElementById('rmLnkIds')){
                    el.childNodes[3].childNodes[1].getElementsByClassName('destination_input')[0].setAttribute('name','destination[new][]');
                }
                select.childNodes[1].parentElement.removeChild(select.childNodes[1]);
                select.childNodes[1].parentElement.removeChild(select.childNodes[1]);
                el.childNodes[3].childNodes[1].getElementsByClassName('dataPicker')[0].parentElement.removeChild(el.childNodes[3].childNodes[1].getElementsByClassName('dataPicker')[0]);
                el.childNodes[3].childNodes[1].childNodes[2].style.display = 'block';
            }
        }
    }catch(err){
        
    }
     jQuery("#select-url"+RowNumber).selectpicker("refresh");
}


// CHECK REDIRECT MODE VALIDATION

var  checkRedirectMode = function(e){
    if(e.value == 2){
        if(REDIRECTMODE != 2 ){
            if(e.getAttribute('alt') == 'edit'){
                jQuery(".percentage_input").remove();
                   jQuery('.destination_input').each(function(){
                        var index =  $(this)[0].getAttribute('index')
                        $(this).after('<input type="text"  maxlength="3" name="percentage['+index+']" class="form-control col-md-3 percentage_input" placeholder="%">');
                   });
            }else{
                jQuery('.destination_input').after('<input type="text"  maxlength="3" name="percentage[]" class="form-control col-md-3 percentage_input" placeholder="%">');
            }
        }
        var x = document.getElementsByClassName("percentage_input");
        var sumOfPercentage = 0;
        for(var i=0; i<x.length; i++){
            if(x[i].value)
            sumOfPercentage = sumOfPercentage + parseInt(x[i].value); 
        }
         if(sumOfPercentage != 100){ 
             jQuery('#select1_redirect_mode').addClass('is-invalid');
             jQuery('.card-footer .btn-primary').prop('disabled', true);
         }  
    }else{
        jQuery('#select1_redirect_mode').removeClass('is-invalid');
        jQuery(".percentage_input").remove();
        jQuery('.card-footer .btn-primary').prop('disabled', false);
    }
    REDIRECTMODE = e.value;
}

var addMultiKeywordFields = function(keyword){
    try{
        var  counter =1;
        $('#keywrd-card-body .row').each(function(e){
            counter = parseInt(counter)+1;
        })
        var  row = $("#keywrd-row-0").clone();
        if(keyword && !row.find('input:eq(0)').val()){
            $("#keywrd-row-0").find('input:eq(0)').val(keyword);
           return true;
        }else{
          row.find('input:eq(0)').val(keyword);  
        }

        if(counter > 1){
          $('#mode-type').css('display','block');  
          $('#mode-type').attr('name','redirect_mode_id'); 
        }
        row.attr('id','keywrd-row-'+counter);
        row.find('span').remove();
        row.find('input:eq(0)').hasClass('is-invalid')? row.find('input:eq(0)').removeClass('is-invalid'):'';
        row.append('<i class="fa fa-trash rm-fild-asin-row" index="keywrd-row-'+counter+'" style="float: right; position: absolute; margin-top:0.7%; color:#f63c3a; cursor: pointer;"></i>');
        row.appendTo("#keywrd-card-body");
        row.find('label').text('Keyword '+counter);
        REDIRECTMODE = $("#changemode").val();
        if(REDIRECTMODE == 2 && !row.find('input:eq(1)').hasClass('percentage-2step')){
            var sumOfPercentage = 0;
             $('#keywrd-card-body .row').each(function(e){
                $(this).find('input:eq(0)').after('<input type="text"  maxlength="3" name="percentage[]" class="form-control col-md-3 percentage-2step" placeholder="%">');
                sumOfPercentage =  sumOfPercentage + parseInt($(this).find('input:eq(1)')); 
            });
            if(sumOfPercentage != 100){
                $("#changemode").addClass('is-invalid');
                $("#changemode").after('<span class="invalid-feedback" role="alert"><strong>The percentage must be equal to 100%. </strong></span>');
                $('.card-footer .btn-primary').prop('disabled', true);
            }
        }
    }catch(err){

    }
};


jQuery(document).on('keypress','.percentage_input',function(e){
     //if the letter is not digit then display error and don't type anything
     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
               return false;
    }
});

jQuery(document).on('keyup','.percentage_input',function(e){
    if(REDIRECTMODE ==2){
        var x = document.getElementsByClassName("percentage_input");
        var sumOfPercentage = 0;
        for(var i=0; i<x.length; i++){
            if(x[i].value)
            sumOfPercentage = sumOfPercentage + parseInt(x[i].value); 
        }
        if(sumOfPercentage != 100){
            jQuery('#select1_redirect_mode').addClass('is-invalid');
            jQuery('.card-footer .btn-primary').prop('disabled', true);
        }else{
            jQuery('#select1_redirect_mode').removeClass('is-invalid');
            jQuery('.card-footer .btn-primary').prop('disabled', false);
        }
    }
});

jQuery(document).on('click','#addNewDestinationBtn',function(){
    if(REDIRECTMODE ==2){
    var x = document.getElementsByClassName("percentage_input");
        var sumOfPercentage = 0;
        for(var i=0; i<x.length; i++){
            if(x[i].value)
            sumOfPercentage = sumOfPercentage + parseInt(x[i].value); 
        }
        if(sumOfPercentage != 100){
            jQuery('#select1_redirect_mode').addClass('is-invalid');
        }else{
            jQuery('#select1_redirect_mode').removeClass('is-invalid');
        }
    }
});
// END CHECK REDIRECT MODE VALIDATION




jQuery(function($){
    $('#add-buy-together').on('click',function(){
        var  counter =1;
        $('#main-buy-together .row').each(function(e){
            counter = parseInt(counter)+1;
        })
        var  row = $("#init-row").clone();
        row.find('.invalid-feedback').remove();
        row.find('input:eq(0)').removeClass('is-invalid');
        row.find('input:eq(1)').removeClass('is-invalid');
        row.find('input:eq(0)').attr('placeholder','Asin '+counter).val('');
        row.find('input:eq(1)').attr('placeholder','Quentity '+counter).val('');
        row.find('input:eq(0)').attr('name','asin['+counter+']');
        row.find('input:eq(1)').attr('name','quantity['+counter+']');
        row.attr('id','init-row-'+counter);
        row.append('<i class="fa fa-trash rm-by-to-row" index="init-row-'+counter+'" style="float: right; position: absolute; margin-top: -23px; color:#f63c3a; cursor: pointer;"></i>');
       row.appendTo("#main-buy-together");
    }); 

    $(document).on('click','.rm-by-to-row',function(){
        $('#'+$(this).attr('index')).remove();
    });
    $(document).on('click','.rm-fild-asin-row',function(){
        $('#'+$(this).attr('index')).remove();
        var  counter =0;
        $('#keywrd-card-body .row').each(function(e){
            counter = parseInt(counter)+1;
            $(this).find('label').text('Keyword '+(e + parseInt(1)));
        });
         if(counter <= 1){
          $('#mode-type').css('display','none');  
          $('#mode-type').attr('name',''); 
          $('.percentage-2step').remove();
          $('.card-footer .btn-primary').prop('disabled', false);
        }
    });

    $('#add-field-asin').on('click',function(){
        addMultiKeywordFields(null);
    });

    $(document).on('change','#changemode',function(){
        REDIRECTMODE = $(this).val();
        if($(this).val() == 2){
            var sumOfPercentage = 0;
            $('#keywrd-card-body .row').each(function(e){
                $(this).find('input:eq(0)').after('<input type="text"  maxlength="3" name="percentage[]" class="form-control col-md-3 percentage-2step" placeholder="%">');
                sumOfPercentage =  sumOfPercentage + parseInt($(this).find('input:eq(1)')); 
            });
            if(sumOfPercentage != 100){
                $(this).addClass('is-invalid');
                $(this).after('<span class="invalid-feedback" role="alert"><strong>The percentage must be equal to 100%. </strong></span>');
                $('.card-footer .btn-primary').prop('disabled', true);
            }
        }else{
             $('#keywrd-card-body .row').each(function(e){
                $(this).find('input:eq(1)').remove();
            });
             $('.card-footer .btn-primary').prop('disabled', false);
             $(this).removeClass('is-invalid');
              $(this).next('span.invalid-feedback').remove();
        }
    });

    jQuery(document).on('keyup','.percentage-2step',function(e){
        $("#changemode").next('span.invalid-feedback').remove();
        REDIRECTMODE = $("#changemode").val();
        if(REDIRECTMODE ==2){
            var x = document.getElementsByClassName("percentage-2step");
            var sumOfPercentage = 0;
            for(var i=0; i<x.length; i++){
                if(x[i].value)
                sumOfPercentage = sumOfPercentage + parseInt(x[i].value); 
            }
            if(sumOfPercentage != 100 ){
                $("#changemode").addClass('is-invalid');
                $("#changemode").after('<span class="invalid-feedback" role="alert"><strong>The percentage must be equal to 100%. </strong></span>');
                $('.card-footer .btn-primary').prop('disabled', true);
            }else{
                $("#changemode").removeClass('is-invalid');
                $("#changemode").next('span.invalid-feedback').remove();
                $('.card-footer .btn-primary').prop('disabled', false);
            }
        }
    });


    jQuery(document).on('change','.readKeywordfile',function(){
        jQuery("#keywordfile-error").css('display','none');
        var fileTypes = ['csv', 'text', 'txt'];
        var fileInput = document.getElementById($(this).attr('id'));
        try{
            var extension = fileInput.files[0].name.split('.').pop().toLowerCase(),  //file extension from input file
            isSuccess = fileTypes.indexOf(extension) > -1;
            if(isSuccess){
                var reader = new FileReader();
                reader.onload = function () {
                   var keywords = reader.result.split("\n");
                    for (var i=0; i < keywords.length; i++) {
                        if(keywords[i])
                            addMultiKeywordFields(keywords[i].trim());
                    }
                };
                // start reading the file. When it is done, calls the onload event defined above.
                reader.readAsText(fileInput.files[0], 'utf8');
               
            }else{
               jQuery("#keywordfile-error").html('<strong>File must be csv,text or txt</strong>');
               jQuery("#keywordfile-error").css('display','block');
            }
        }catch(err){
            jQuery("#keywordfile-error").html('<strong>'+err.message+'</strong>');
            jQuery("#keywordfile-error").css('display','block');
        }
    });
});