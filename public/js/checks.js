$(function(){
    $('#fromDate').val("Date from");
    $('#fromDate').datepicker({dateFormat: 'yy-mm-dd 00:00:00'});
    $('#toDate').val("Date to");
    $('#toDate').datepicker({dateFormat: 'yy-mm-dd 00:00:00'});

    $('#fromDate').on('change',function(){
    	from_date = $('#fromDate').val();
    	to_date = $('#toDate').val();
    	user_id = $('#userid').val();
    	if(from_date != 'Date from' && to_date != 'Date to' && user_id !=0){
			getSpecificUserDateOrders(user_id,from_date,to_date);
		}else
    	if(to_date != 'Date to'){
    		getSpecificDateOrders(from_date,to_date);
    	}
	});

	$('#toDate').on('change',function(){
    	from_date = $('#fromDate').val();
    	to_date = $('#toDate').val();
		user_id = $('#userid').val();
    	if(from_date != 'Date from' && to_date != 'Date to' && user_id !=0){
			getSpecificUserDateOrders(user_id,from_date,to_date);
		}else
    	if(from_date != 'Date from'){
    		getSpecificDateOrders(from_date,to_date);
    	}
	});

	$('#userid').on('change',function(){
		user_id = $('#userid').val();
    	from_date = $('#fromDate').val();
    	to_date = $('#toDate').val();
		if(from_date != 'Date from' && to_date != 'Date to' && user_id !=0){
			getSpecificUserDateOrders(user_id,from_date,to_date);
		}else
		if(user_id !=0){
			$.ajax({
		        url:"/order/userchecks",
		        cache:false,
		        type: "POST", // HTTP method POST or GET
		        dataType:"html", // Data type, HTML, json etc.
		        data:{
		        	user_id:user_id,
		        	user_name:user_name,
		        	}, //Form variables
		      	success:function(r){
		      		$('.names').html('');
					$('.orders').html('');
					$('.username').html('');
					$('.orderdate').html('');
					$('.prods').html('');
		      		$('#checkscontent').html(r);
					$('.orders').hide();
					$('.username').hide();
					$('.orderdate').hide();
					$('.prods').hide();
		      	},
		      	error:function(){
		        	console.log("Error");
		      	}
			});
		}else{
		    $.ajax({
		        url:"/order/userschecks",
		        cache:false,
		        type: "POST", // HTTP method POST or GET
		        dataType:"html", // Data type, HTML, json etc.
		      	success:function(r){
		      		$('.names').html('');
					$('.orders').html('');
					$('.username').html('');
					$('.orderdate').html('');
					$('.prods').html('');
		      		$('#checkscontent').html(r);
					$('.orders').hide();
					$('.username').hide();
					$('.orderdate').hide();
					$('.prods').hide();
		      		//console.log(r);
		      	},
		      	error:function(){
		        	console.log("Error");
		      	}
			});
		}
	});

	$('.orders').hide();
	$('.username').hide();
	$('.orderdate').hide();
	$('.prods').hide();
	$('body').delegate('.expand','click',function(){
		name = $(this).attr('id');
		$('.expand').html('+');
		$(this).html('-');
		$('.orders').show();
		$('.username').hide();
		$('.username[id='+name+']').show();
	});
	$('body').delegate('.expandprods','click',function(){
		id = $(this).attr('id');
		$('.expandprods').html('+');
		$(this).html('-');
		$('.orderdate').hide();
		$('.prods').show();
		$('.orderdate[id='+id+']').show();
	});

	function getSpecificUserDateOrders(user_id,from_date,to_date){
		$.ajax({
		        url:"/order/userdatechecks",
		        cache:false,
		        type: "POST", // HTTP method POST or GET
		        dataType:"html", // Data type, HTML, json etc.
		        data:{
		        	user_id:user_id,
		        	fromDate:from_date,
		        	toDate:to_date,
		        	}, //Form variables
		      	success:function(r){
		      		$('.names').html('');
					$('.orders').html('');
					$('.username').html('');
					$('.orderdate').html('');
					$('.prods').html('');
		      		$('#checkscontent').html(r);
					$('.orders').hide();
					$('.username').hide();
					$('.orderdate').hide();
					$('.prods').hide();
		      	},
		      	error:function(){
		        	console.log("Error");
		      	}
			});
	}

	function getSpecificDateOrders(from_date,to_date){
		$.ajax({
		        url:"/order/datechecks",
		        cache:false,
		        type: "POST", // HTTP method POST or GET
		        dataType:"html", // Data type, HTML, json etc.
		        data:{
		        	fromDate:from_date,
		        	toDate:to_date,
		        	}, //Form variables
		      	success:function(r){
		      		$('.names').html('');
					$('.orders').html('');
					$('.username').html('');
					$('.orderdate').html('');
					$('.prods').html('');
		      		$('#checkscontent').html(r);
					$('.orders').hide();
					$('.username').hide();
					$('.orderdate').hide();
					$('.prods').hide();
		      	},
		      	error:function(){
		        	console.log("Error");
		      	}
			});
	}
});