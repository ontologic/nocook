<?php $this->load->view('shared/dash/header') ?>
<?php $this->load->view('shared/dash/fluidStart') ?>

<h3>Restaurant Zip Codes</h3>
<a href="<?php echo base_url();?>dash/restaurant/create"><button class="btn">Create</button></a>
<br/><br/>
<table id="zipTable" class="table">
    <thead>
    <tr>
        <th>Restaurant</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($zips as $zip): ?>
        <tr>
            <td><?php echo $zip['zip'] ?></td>
            <td>
                <a href="<?php echo base_url();?>dash/restaurant/zip/delete/<?php echo $zip['zip'] ?>">
                    <button type="button" class="btn btn-primary">Delete</button>
                </a>
            </td>
        </tr>
    <?php endforeach ?>
    </tbody>
</table>

<br/><br/>

<h4>Add Zip Code</h4>
<?php echo validation_errors(); ?>
<?php echo form_open(null, array('role' => 'form')) ?>
    <div class="form-group">
        <label for="zip">Zip Code</label>
        <input type="text" name="zip" class="form-control" id="zip" placeholder="Zip Code" /><br />
    </div>
    <input type="submit" name="submit" value="Add Zip Code" class="btn btn-default" />
</form>

<?php $this->load->view('shared/dash/fluidEnd') ?>
<?php $this->load->view('shared/dash/footer') ?>
<script type="text/javascript">
    $(document).ready(function() {
        $('#zipTable').DataTable();
    });
</script>