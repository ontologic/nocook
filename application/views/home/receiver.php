<?php $this->load->view('shared/header') ?>
<?php $this->load->view('shared/nav') ?>

    <h1>Step 1</h1>

    <div class="container">
        <?php echo validation_errors(); ?>

        <h2>Delivery Information</h2>
        <?php echo form_open(null, array('role' => 'form')) ?>

        <div class="form-group">
            <label>First Name</label>
            <?php echo form_input($first); ?>
        </div>

        <div class="form-group">
            <label>Last Name</label>
            <?php echo form_input($last); ?>
        </div>

        <div class="form-group">
            <label>Address</label>
            <?php echo form_input($address); ?>
        </div>

        <div class="form-group">
            <label>Zip</label>
            <?php echo form_input($zip); ?>
        </div>

        <div class="form-group">
            <label for="city">Telephone</label>
            <?php echo form_input($telephone); ?>
        </div>

        <input type="submit" value="Continue" class="btn btn-default" />

        </form>
    </div>

<?php $this->load->view('shared/footer') ?>