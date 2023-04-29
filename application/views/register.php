<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>User Registration Form</title>
	<link rel="stylesheet" type="text/css" href="<?=base_url(); ?>bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>style.css"/>

</head>
<body>
<div class="container">
	<h1 class="page-header text-center">User Management system</h1>
	<div class="row">
		<div class="col-sm-4">
			<?php
		    	if(validation_errors()){
		    		?>
		    		<div class="alert alert-info text-center">
		    			<?php echo validation_errors(); ?>
		    		</div>
		    		<?php
		    	}
 
				if($this->session->flashdata('message')){
					?>
					<div class="alert alert-info text-center">
						<?php echo $this->session->flashdata('message'); ?>
					</div>
					<?php
					unset($_SESSION['message']);
				}
		    ?>
			<?php
			if($this->session->flashdata('response')){
				?>
				<div class="alert alert-info text-center">
					<?php echo $this->session->flashdata('response'); ?>
				</div>
				<?php
				unset($_SESSION['response']);
			}
			?>
			<h3 class="text-center"><b>User Signup Form</b></h3>
			<form method="POST" action="<?php echo base_url().'user/register'; ?>">
			    <div class="form-group">
					<label for="name">Name:</label>
					<input type="text" class="form-control" id="name" name="name" value="<?php echo set_value('name'); ?>">
				</div>
				<div class="form-group">
					<label for="email">Email:</label>
					<input type="text" class="form-control" id="email" name="email" value="<?php echo set_value('email'); ?>">
				</div>
				<div class="form-group">
					<label for="name">Mobile:</label>
					<input type="text" class="form-control" id="name" name="mobile" value="<?php echo set_value('mobile'); ?>">
				</div>
				<button type="submit" name="submit" class="btn btn-primary">Register</button>
			</form>
		</div>

		<div class="col-sm-8">
			<h3 class="text-center"><b>User Table</b></h3>
			<table class="table table-bordered table-striped">
				<thead>
					<tr>
						<th>UserID</th>
						<th>Name</th>
						<th>Email</th>
						<th>Mobile</th>
						<th>Verification</th>
					</tr>
				</thead>
				<tbody>
				<?php
					foreach($users as $row){
						?>
						<tr>
							<td><?php echo $row->id; ?></td>
							<td><?php echo $row->name; ?></td>
							<td><?php echo $row->email; ?></td>
							<td><?php echo $row->mobile; ?></td>
							<td><?php echo $row->verification ? 'Verified' : 'Not Verified'; ?></td>
						</tr>
						<?php
					}
				?>
				</tbody>
			</table>
		</div>
	</div>
</div>
</body>
</html>