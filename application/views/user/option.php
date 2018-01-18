<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<br>

    <div class="row">
    <div class="col-md-6 offset-md-3 text-center">
        <h1><?php echo $this->lang->line('user_option_title'); ?></h1>
        <br><hr>
		
<p class="lead"><?php echo $this->lang->line('user_option_ask0'); ?></p>       
        
<label class="custom-control custom-radio">
<input type="radio" name="pH" class="custom-control-input" id="checkbox_pH" checked >
<span class="custom-control-indicator"></span>
<span class="custom-control-description"><?php echo $this->lang->line('user_option_msg1'); ?></span>
</label>
<label class="custom-control custom-radio">
<input type="radio" name="pH" class="custom-control-input" id="checkbox_pH" disabled>
<span class="custom-control-indicator"></span>
<span class="custom-control-description"><?php echo $this->lang->line('user_option_msg2'); ?></span>
</label>
<label class="custom-control custom-radio">
<input type="radio" name="pH" class="custom-control-input" id="checkbox_pH" disabled>
<span class="custom-control-indicator"></span>
<span class="custom-control-description"><?php echo $this->lang->line('user_option_msg3'); ?></span>
</label><br>    		

<form id="formform" method="POST">
<p class="lead"><?php echo $this->lang->line('user_option_ask1'); ?></p>

<script>
function toggle(source) {
  checkboxes = document.getElementsByClassName("custom-control-input a");
   for(var i=0, n=checkboxes.length;i<n;i++) {
   checkboxes[i].checked = source.checked;}
}
</script>
<div class="options">
<label class="custom-control custom-checkbox">
<input type="checkbox" name="all" class="custom-control-input a" id="checkbox_temperature" onClick="toggle(this)" <?php if($parameter->temp == "1" && $parameter->pH == "1" && $parameter->light == "1" && $parameter->moisture == "1") echo "checked"; ?>>
<span class="custom-control-indicator"></span>
<span class="custom-control-description"><?php echo $this->lang->line('user_option_var1'); ?></span>
</label><br>

<label class="custom-control custom-checkbox">
<input type="checkbox" name="temp" class="custom-control-input a" id="checkbox_temp" <?php if($parameter->temp == "1") echo "checked"; ?>>
<span class="custom-control-indicator"></span>
<span class="custom-control-description"><?php echo $this->lang->line('user_option_var2'); ?></span>
</label><br>

<label class="custom-control custom-checkbox">
<input type="checkbox" name="pH" class="custom-control-input a" id="checkbox_pH" <?php if($parameter->pH == "1") echo "checked"; ?>>
<span class="custom-control-indicator"></span>
<span class="custom-control-description"><?php echo $this->lang->line('user_option_var3'); ?></span>
</label><br>

<label class="custom-control custom-checkbox">
<input type="checkbox" name="light" class="custom-control-input a" id="checkbox_light" <?php if($parameter->light == "1") echo "checked"; ?>>
<span class="custom-control-indicator"></span>
<span class="custom-control-description"><?php echo $this->lang->line('user_option_var4'); ?></span>
</label><br>

<label class="custom-control custom-checkbox">
<input type="checkbox" name="moisture" class="custom-control-input a" id="checkbox_moisture" <?php if($parameter->moisture == "1") echo "checked"; ?>>
<span class="custom-control-indicator"></span>
<span class="custom-control-description"><?php echo $this->lang->line('user_option_var5'); ?></span>
</label>
</div>
<p class="lead"><?php echo $this->lang->line('user_option_ask2'); ?></p>
<select form="formform" name="time_lim">
  <option value="10" <?php if($parameter->time_lim == "10") echo "selected"; ?>>10</option>
  <option value="20" <?php if($parameter->time_lim == "20") echo "selected"; ?>>20</option>
  <option value="30" <?php if($parameter->time_lim == "30") echo "selected"; ?>>30</option>
  <option value="40" <?php if($parameter->time_lim == "40") echo "selected"; ?>>40</option>
  <option value="50" <?php if($parameter->time_lim == "50") echo "selected"; ?>>50</option>
  <option value="60" <?php if($parameter->time_lim == "60") echo "selected"; ?>>60</option>
</select> minutes
<br>
<br>
<button type="submit" class="btn btn-primary"><?php echo $this->lang->line('user_option_button'); ?></button>
</form><br>
<?php if(isset($success)): ?>
<div class="alert alert-success">
  <?php echo $this->lang->line('user_option_success'); ?>
</div>
<img height=225 width=340 src="<?php echo base_url() . 'assets/images/gif.gif' ?>">
<?php endif; ?>
</div>
</div>
