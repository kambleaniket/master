<div class="container">
	<div class="row"> 
		
	</div>
	<div class="active-cyan-6 large-6 mb-4">
 		 	<input class="form-control" type="text" id="searchFields" placeholder="Search" aria-label="Search">
 		 	<button class="btn btn-primary " id="export">Export</button>
	</div>
	
	<div class="table-div">
			<table class="table" id="table-data">
			  <thead class="thead-dark">
			    <tr>
			      <th scope="col">Id </th>
			      <th scope="col">Sortname</th>
			      <th scope="col">Name</th>
			      <th scope="col">Phonecode</th>
			    </tr>
			  </thead>
			  <tbody id="tbodyid">
			    	<?php
			    	 	foreach ($countries as $country) { ?>
			    			<tr>	
			    				<td><?= $country->id ?> </td>
			    				<td><?= $country->sortname ?> </td>
			    				<td><?= $country->name ?> </td>
			    				<td><?= $country->phonecode ?> </td>

			    			</tr>	
			    	<?php 	} ?>
			    				     
			    </tr>
			  </tbody>
			</table>
	</div>
</div>