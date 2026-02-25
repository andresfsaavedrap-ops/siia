<!DOCTYPE html>
<html>
<head>
	<title>Update Constants</title>
</head>
<body>
<?php echo validation_errors(); ?>
<?php if ($this->session->flashdata('message')): ?>
	<p><?php echo $this->session->flashdata('message'); ?></p>
<?php endif; ?>

<?php echo form_open('configcontroller/update_constants'); ?>
<label for="constant_name">Constant Name:</label>
<input type="text" name="constant_name" id="constant_name"><br>

<label for="constant_value">Constant Value:</label>
<input type="text" name="constant_value" id="constant_value"><br>

<button type="submit">Update Constant</button>
<?php echo form_close(); ?>
</body>
</html>

