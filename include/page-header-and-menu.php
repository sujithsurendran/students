<form class="form-horizontal" role="form" method="post" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<div id="page-header">
					
					<div class="container1">
					  		<div class="row">
					    			<div class="col-sm-3">
					    			</div>
					    			<div class="col-sm-6">
					    					<span class="page-heading-1"><?php echo $page_name ?></span>
												
												
										</div>
					    			<div class="col-sm-3">
					    			</div>
					    	</div>
					    	
					  		<div class="row">					    	
					    			<div class="col-sm-12">
					    				<?php include 'include/menu.php';?>
					    			</div>
					    	</div>
					    	
					    	
					</div>

</div>





			<!--This is closed in footer -->
<div class="container" id="body-contents">
  <div class="row">
    <div class="col-sm-12">
			<?php display_error_messages(); ?>
			<?php if(isset($msg)){ echo $msg;	} ?>
			<br />

			<!--This is closed in footer -->