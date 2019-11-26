$(document).ready(function () {
	$("#searchFields").on('keyup',function(){
		var searchFields = $('#searchFields').val();
		// console.log("Here is the value : " +searchFields );
		$.ajax({
			headers: {'X-CSRF-TOKEN' : csrfToken},
			url : 'uploads/searchfields',
			type : 'POST',
			dataType : 'Html',
			data : {searchField : searchFields},
			success : function(data){
				 $("#table-data tr").remove();
				var data = JSON.parse(data);
				// console.log(data);
				// var len = data.length;
				// console.log("Length " +len);

                
                // for( var i = 0; i<len; i++){
                   
                    // $("#table-data").append("<td>"+data[0]['id']+"</td><td>"+data[0]['sortname']+"</td><td>"+data[0]['name']+"</td><td>"+data[0]['phonecode']+"</td>");
                    // ('#table-data').append("<tr><td>"+data['id']+"</td><td>"+data['sortname']+"</td><td>"+data['name']+"</td><td>"+data['phonecode']+"</td></tr>");
                	// }
                }

		});
	});
	$("#export").on('click',function(){
		if(confirm("This will genarate PDF")){
			$.ajax({
			headers: {'X-CSRF-TOKEN' : csrfToken},
			url : 'uploads/searchfields',
			type : 'get',
			success : function(data){
				$.ajax({
					headers: {'X-CSRF-TOKEN' : csrfToken},
					url : 'uploads/createpdf',
					type : 'post',
					data : {pagedata : data}
					
				});
			}

			});	
		}
		
	});
});