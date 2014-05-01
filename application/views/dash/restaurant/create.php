<?php $this->load->view('shared/dash/header') ?>
<?php $this->load->view('shared/dash/fluidStart') ?>

    <h3>Create restaurant</h3>

<?php echo validation_errors(); ?>

<?php echo form_open(null, array('role' => 'form')) ?>

    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" name="name" class="form-control" id="name" placeholder="Name" /><br />
    </div>

    <div class="form-group">
        <label for="name">Tax Percent</label>
        <input type="text" name="tax_percent" class="form-control" id="tax_percent" placeholder="Tax Percent" /><br />
    </div>

    <div class="form-group">
        <label for="stripe_public_key">Stripe Public Key</label>
        <input type="text" name="stripe_public_key" class="form-control" id="stripe_public_key" placeholder="Stripe Public Key" /><br />
    </div>

    <div class="form-group">
        <label for="stripe_secret_key">Stripe Secret Key</label>
        <input type="text" name="stripe_secret_key" class="form-control" id="stripe_secret_key" placeholder="Stripe Secret Key" /><br />
    </div>

    <div class="form-group">
        <label for="lineOne">Address Line One</label>
        <input type="text" name="lineOne" class="form-control" id="lineOne" placeholder="Address Line One" /><br />
    </div>

    <div class="form-group">
        <label for="lineOne">Address Line Two</label>
        <input type="text" name="lineTwo" class="form-control" id="lineTwo" placeholder="Address Line Two" /><br />
    </div>

    <div class="form-group">
        <label for="city">City</label>
        <input type="text" name="city" class="form-control" id="city" placeholder="City" /><br />
    </div>

    <div class="form-group">
        <label for="state">State</label>
        <input type="text" name="state" class="form-control" id="state" placeholder="State" /><br />
    </div>

    <div class="form-group">
        <label for="zip">Zip Code</label>
        <input type="text" name="zip" class="form-control" id="zip" placeholder="Zip Code" /><br />
    </div>

    <div class="form-group">
        <label for="telephone">Telephone</label>
        <input type="text" name="telephone" class="form-control" id="telephone" placeholder="Telephone" /><br />
    </div>

    <input type="submit" name="submit" value="Create restaurant" class="btn btn-default" />

    </form>

<?php $this->load->view('shared/dash/fluidEnd') ?>
<?php $this->load->view('shared/dash/footer') ?>