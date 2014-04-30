<?php $this->load->view('shared/header') ?>
<?php $this->load->view('shared/nav') ?>

    <div class="container">
        <?php echo validation_errors(); ?>

        <h2>Delivery Information</h2>
        <?php echo form_open(null, array('role' => 'form')) ?>

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

        <input type="submit" value="Continue" class="btn btn-default" />

        </form>
    </div>

<?php $this->load->view('shared/footer') ?>