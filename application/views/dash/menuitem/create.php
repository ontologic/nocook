<?php $this->load->view('shared/dash/header') ?>
<?php $this->load->view('shared/dash/fluidStart') ?>

<h3>Create a menu item</h3>

<?php echo validation_errors(); ?>

<?php echo form_open(null, array('role' => 'form')) ?>

<div class="form-group">
    <label for="name">Name</label>
    <input type="text" name="name" class="form-control" id="name" placeholder="Name" /><br />
</div>

<div class="form-group">
    <label for="description">Description</label>
    <textarea name="description" class="form-control" id="description" placeholder="Description"></textarea><br />
</div>

<!--<div class="form-group">
    <label for="price">Price</label>
    <input type="text" name="price" class="form-control" id="price" placeholder="price" /><br />
</div>-->

<input type="submit" name="submit" value="Create menu item" class="btn btn-default" />

</form>

<?php $this->load->view('shared/dash/fluidEnd') ?>
<?php $this->load->view('shared/dash/footer') ?>