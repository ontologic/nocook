<?php $this->load->view('shared/dash/header') ?>
<?php $this->load->view('shared/dash/fluidStart') ?>

    <h3>Delete a menu item</h3>

<?php echo validation_errors(); ?>

<?php echo form_open(null, array('role' => 'form')) ?>

    <div><strong>Name</strong></div>
    <div><?php echo $menuItem['name'];?></div>

    <div><strong>Description</strong></div>
    <div><?php echo $menuItem['description'];?></div>

    <br/>
    <input type="submit" name="submit" value="Delete menu item" class="btn btn-default" />

</form>

<?php $this->load->view('shared/dash/fluidEnd') ?>
<?php $this->load->view('shared/dash/footer') ?>