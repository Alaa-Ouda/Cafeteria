$(function(){
	$('#confirm').before('<p>----------------</p>');
	$('#confirm').before($('#total_price'));
	$('#confirm').before($('#currency'));
	$('#confirm').before('<br/>');

	$('#prod_cat').after($('#addcategory'));

	$('#users').on('change',function(){
		user_id = $('#users').attr('value');
		user_name = $('#users').text();
		$('#user_id').attr('value',user_id);
		$.ajax({
	        url:"/order/chooseuser",
	        cache:false,
	        type: "POST", // HTTP method POST or GET
	        dataType:"html", // Data type, HTML, json etc.
	        data:{
	        	user_id:user_id,
	        	user_name:user_name,
	        	}, //Form variables
	      	success:function(r){
	      	},
	      	error:function(){
	        	console.log("Error");
	      	}
		});
	});

	flag = false;
	var prod_id;
	var prod_name;
	var prod_price;
	var prod_quantity;
	var prices=0;
	$('.product_image').on('click',function(){
		prod_id = $(this).attr('id');
		prod_name = $(this).attr('name');
		prod_price = $(this).attr('price');
		prod_quantity=1;
		if($('#choosed_products').find('tr[id='+prod_id+']').length != 0){
			quantity = parseInt($('#quantity_'+prod_id).attr('value'));
			quantity++;
			prod_quantity = quantity;
			$('#quantity_'+prod_id).attr('value',quantity);
			price = parseInt($('#price_'+prod_id).html());
			price=prod_price*quantity;
			prod_price = price;
			$('#price_'+prod_id).html(price);

		}else{
			choosed_prod = '<tr id="'+prod_id+
			'"><td><label id="choosed_product_name">'+prod_name+
			'</label></td><td><input type="number" name="quantity" id="quantity_'+prod_id+'" value="1" /></td><td>'+
    '<input type="button" class="plus" id="'+prod_id+'" value="+"><input type="button" class="minus" id="'+prod_id+'" value="-"></td><td><label class="price" id="price_'+prod_id+'">'
			+prod_price+'</label></td><td> L.E. <input type="button" class="close" id="'+prod_id+'" value="x"></td></tr>';
			
			$('#choosed_products').append(choosed_prod);
			
		}
		
		prices=0;
		$('#choosed_products tr').find('.price').each(function(){
			
			prices += parseInt($(this).html());
			$('#total_price').html(prices);
		});

		sendProductData();		
		 
	});
	$('body').delegate(".plus", 'click', function () { 
		prod_id = $(this).attr('id');
		prod_name = $(this).attr('name');

		price = parseInt($('#price_'+prod_id).html());
		prod_quantity = $('#quantity_'+prod_id).attr('value');
		
		price = price/prod_quantity;

		prod_quantity++;
		$('#quantity_'+prod_id).attr('value',prod_quantity);

		prod_price=price*prod_quantity;
	
		$('#price_'+prod_id).html(prod_price);

		prices = parseInt($('#total_price').html());
		prices+=price;
			$('#total_price').html(prices);
	sendProductData();
	});

	$('body').delegate(".minus", 'click', function () { 
		prod_id = $(this).attr('id');
		prod_name = $(this).attr('name');

		prod_price = parseInt($('#price_'+prod_id).html());
		prod_quantity = $('#quantity_'+prod_id).attr('value');

		price = prod_price/prod_quantity;
		
		if(prod_quantity > 1){
			prod_quantity--;
			$('#quantity_'+prod_id).attr('value',prod_quantity);

			prod_price-=price;
			$('#price_'+prod_id).html(prod_price);
		}else{
			$('tr[id='+prod_id+']').remove();
		}

		prices = $('#total_price').html();
		prices-=price;
		$('#total_price').html(prices);
	sendProductData();
	});


	$('body').delegate(".close", 'click', function () { 
		prod_id = $(this).attr('id');
		prod_price = parseInt($('#price_'+prod_id).html());

		$('tr[id='+prod_id+']').remove();

		prices = $('#total_price').html();
		prices-=prod_price;
			$('#total_price').html(prices);
	deleteProductData();
	});

	function sendProductData(){
		$.ajax({
	        url:"/order/chooseproduct",
	        cache:false,
	        type: "POST", // HTTP method POST or GET
	        dataType:"html", // Data type, HTML, json etc.
	        data:{
	        	prod_id:prod_id,
	        	prod_name:prod_name,
	        	prod_price:prod_price,
	        	prod_quantity:prod_quantity,
	        	}, //Form variables
	      	success:function(r){
	      	},
	      	error:function(){
	        	console.log("Error");
	      	}
		});
	}

	function deleteProductData(){
		$.ajax({
	        url:"/order/chooseproduct",
	        cache:false,
	        type: "POST", // HTTP method POST or GET
	        dataType:"html", // Data type, HTML, json etc.
	        data:{
	        	prod_id:prod_id,
	        	status:'close',
	        	}, //Form variables
	      	success:function(r){
	      	},
	      	error:function(){
	        	console.log("Error");
	      	}
		});
	}
	
});