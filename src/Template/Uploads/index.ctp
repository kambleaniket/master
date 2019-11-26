<h1>Upload File</h1>
<div class="content">
    <?= $this->Flash->render() ?>
   
    <div class="large-5 medium-3 columns">
        <?php echo $this->Form->create($uploadData, ['type' => 'file']); ?>
            <?php echo $this->Form->input('file', ['type' => 'file', 'class' => 'form-control']); ?>
            <?php echo $this->Form->button(__('Upload File'), ['type'=>'submit', 'class' => 'form-control btn btn-success','id' => 'btnupload']); ?>
            <br>
        <?php echo $this->Form->end(); ?>
    </div>
   <div class="large-7 medium-6 columns">
   	<div class="large-2 medium-3 columns">
   	
   	<?= $this->Html->link(__('Export'), ['action' => 'createXls','class' => 'btn btn-success']) ?>
   	</div>
   	<h5><b>Existing files in database</b></h5>
   		<table>
   			<th>SR</th>
   			<th>NAME</th>
   			<th>SIZE</th>
   			<th>Created Date</th>
   			<?php
   			$count =1;
   			foreach ($files as $file) { ?>
   				<tr class="table-row">
				<td><?php echo $count ?></td>
				<td><?php echo $file->name ?></td>
				<td><?php echo $file->size ?>KB</td>
				<td><?php echo $file->created ?></td>
				</tr>
   			<?php $count ++ ;} 
   			
   		?>

   		</table>
   		   		
   </div>
</div>
<div class="row">
  <div class="col-sm-12 col-lg-4 text-white">
    <div class="shadow-lg p-3 mb-5 bg-white rounded">
    <div class="card bg-info">
      <div class="card-body">
        <h5 class="card-title">Special title treatment</h5>
        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
        <a href="#" class="btn btn-warning"><i class="fas fa-arrow-alt-circle-up"></i>Go somewhere</a>
      </div>
    </div>
  </div>
  </div>
  <div class="col-sm-12 col-lg-4">
    <div class="shadow-lg p-3 mb-5 bg-white rounded">
      <div class="card bg-info text-white">
      <div class="card-body">
        <h5 class="card-title">Special title treatment</h5>
        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
        <a href="#" class="btn btn-light">Go somewhere</a>
      </div>
    </div>  
    </div>
  </div>
  <div class="col-sm-12 col-lg-4">
    <div class="shadow-lg p-3 mb-5 bg-white rounded">
    <div class="card bg-info text-white">
      <div class="card-body">
        <h5 class="card-title">Special title treatment</h5>
        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
        <a href="#" class="btn btn-warning ">Go somewhere</a>
      </div>
    </div>
  </div>
</div>
</div>
