
  'use strict';

  var  changeUserStatus = function(userId,e){
  	try{
  	var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
  	var is_active = e.getAttribute('data-target') == 1?0:1;
  	if(e.getAttribute('data-target') == 1){
  		e.parentElement.previousElementSibling.childNodes[1].setAttribute('class','badge badge-danger');
  		e.parentElement.previousElementSibling.childNodes[1].textContent = 'Deactivated';
  		e.childNodes[1].setAttribute('class','fa fa-lock');
  	}else{
  		e.childNodes[1].setAttribute('class','fa fa-unlock');
  		e.parentElement.previousElementSibling.childNodes[1].setAttribute('class','badge badge-success');
  		e.parentElement.previousElementSibling.childNodes[1].textContent = 'Active';
  	}
		$.ajax({
		       type: "POST",
		       url: "/admin/users/update",
		       data: {_token: CSRF_TOKEN, id: userId, is_active: is_active},
		       success: function( res ,status) {
		       	res = JSON.parse(res);
		       	if(res.sucsess){
		       		e.setAttribute('data-target',is_active)
		           	toastr["success"](res.sucsess);
		       	}else{
		       		toastr["error"](res.error);
		       	}
		       }
		   });
	}catch(err){
		console.log(err.message);
	}

  }


    var  deleteFaqCatagory = function(userId,e){
  	try{
  	var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
		$.ajax({
		       type: "POST",
		       url: "/admin/users/update",
		       data: {_token: CSRF_TOKEN, id: userId, is_active: is_active},
		       success: function( res ,status) {
		       	res = JSON.parse(res);
		       	if(res.sucsess){
		       		e.setAttribute('data-target',is_active)
		           	toastr["success"](res.sucsess);
		       	}else{
		       		toastr["error"](res.error);
		       	}
		       }
		   });
	}catch(err){
		console.log(err.message);
	}

  }