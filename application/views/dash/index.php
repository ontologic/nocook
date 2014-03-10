<?php $this->load->view('shared/dash/header') ?>
<?php $this->load->view('shared/dash/fluidStart') ?>

<h1>Dash</h1>

    <table id="example">
        <thead>
        <tr>
            <th>Column 1</th>
            <th>Column 2</th>
            <th>etc</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>Row 1 Data 1</td>
            <td>Row 1 Data 2</td>
            <td>etc</td>
        </tr>
        <tr>
            <td>Row 2 Data 1</td>
            <td>Row 2 Data 2</td>
            <td>etc</td>
        </tr>
        </tbody>
    </table>

<?php $this->load->view('shared/dash/fluidEnd') ?>
<?php $this->load->view('shared/dash/footer') ?>
<script type="text/javascript">
    $(document).ready( function () {
        var table = $('#example').DataTable();
    } );
</script>