$(function(){
	//$('#ordertotal').hide();
    $('#from').val("Date from");
    $('#from').datepicker({dateFormat: 'yy-mm-dd 00:00:00'});
    $('#to').val("Date to");
    $('#to').datepicker({dateFormat: 'yy-mm-dd 00:00:00'});

    $('#from').on('change',function(){
    	from_date = $('#from').val();
    	to_date = $('#to').val();
    	user_id = $('#userid').val();
    	if(from_date != 'Date from' && to_date != 'Date to' && user_id !=0){
			getSpecificUserDateOrders(user_id,from_date,to_date);
		}
	});

	$('#to').on('change',function(){
    	from_date = $('#from').val();
    	to_date = $('#to').val();
		user_id = $('#userid').val();
    	if(from_date != 'Date from' && to_date != 'Date to' && user_id !=0){
			getSpecificUserDateOrders(user_id,from_date,to_date);
		}
	});

	function getSpecificUserDateOrders(user_id,from_date,to_date){
		$.ajax({
		        url:"/order/userdateorders",
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
					$('#ordertotal').html('');
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