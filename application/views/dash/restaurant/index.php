<?php $this->load->view('shared/dash/header') ?>
<?php $this->load->view('shared/dash/fluidStart') ?>

<h3>Restaurants</h3>
<a href="<?php echo base_url();?>dash/restaurant/create"><button class="btn">Create</button></a>
<br/><br/>
<table id="restaurantTable" class="table">
    <thead>
        <tr>
            <th>Restaurant</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($restaurants as $restaurant): ?>
            <tr>
                <td><?php echo $restaurant['name'] ?></td>
                <td>
                    <a href="<?php echo base_url();?>dash/restaurant/edit/<?php echo $restaurant['id'] ?>">
                        <button type="button" class="btn btn-primary">Edit</button>
                    </a>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>
<?php $this->load->view('shared/dash/fluidEnd') ?>
<?php $this->load->view('shared/dash/footer') ?>
<script type="text/javascript">
    $(document).ready(function() {
        $('#restaurantTable').DataTable();
    });
</script>