<form class="form-horizontal" role="form" method="post" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">



<img src="<?php echo LOGO; ?>" alt="Model Engineering College" style="width:100px;"/>
<div id="page-header">




					
					<div class="container1">
					
						<div class="row">
					    			<div class="col-sm-12">
												<div class="site-header"><!--#0661a9 -->
													
													<span class="main-heading-1"><?php echo MAIN_HEADING_1;?></span>
													<span class="main-heading-2"><?php echo MAIN_HEADING_2; ?></span>
													<span class="main-heading-2"><?php echo MAIN_HEADING_3; ?></span>
												</div>				    			
					    			
					    			</div>
						</div>




					
					
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

</div><!--  started in main page -->



			<!--This is closed in footer -->
<div class="container" id="body-contents">
  <div class="row">
    <div class="col-sm-12">
			<?php display_error_messages(); ?>
			<?php if(isset($msg)){ echo $msg;	} ?>
			<br />

			<!--This is closed in footer -->