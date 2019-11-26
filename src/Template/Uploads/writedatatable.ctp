<div class="container">
	<div class="card large-6 medium-3 columns">
		<div class="large-6 medium-3 columns">
        		<?php echo $this->Form->create($uploadFile, ['type' => 'file']); ?>
            	<?php echo $this->Form->input('file', ['type' => 'file', 'class' => 'form-control']); ?>
            	<?php echo $this->Form->button(__('Upload File'), ['type'=>'submit', 'class' => 'form-control btn 	btn-success','id' => 'btnupload']); ?><br>
        		<?php echo $this->Form->end(); ?>
    	</div>
	</div>	
	</div>
	