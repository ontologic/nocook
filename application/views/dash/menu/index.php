<?php $this->load->view('shared/dash/header') ?>
<?php $this->load->view('shared/dash/fluidStart') ?>

<h3><?php echo $restaurant['name']?> Menu</h3>
<div class="alert alert-warning">You menu is incomplete!</div>
<?php
foreach ($menuTypes as $menuType) {
    $menuHeader = sprintf('<h4>%s (%s-%s)</h4>', $menuType['name'], $menuType['minimum'], $menuType['maximum']);
    echo $menuHeader;
    $createItemHref = sprintf('%smenuitem/create/%s/%s', base_url(), $restaurant['id'], $menuType['id']);
    echo '<a href="'.$createItemHref.'">';
    echo '<button class="btn">Create</button></a>';
    echo '<table class="table"><thead><tr><th>Name</th><th>Description</th><th>Price</th><th>Actions</th></tr></thead><tbody>';

    $findMenuItemsOfType = function ($menuItemType)
    {
        return function ($item) use ($menuItemType) { return ($item['type'] == $menuItemType); };
    };
    $menuItemsOfType = array_filter($menu, $findMenuItemsOfType($menuType['id']));
    foreach($menuItemsOfType as $menuItem)
    {
        echo '<tr>';
        echo '<td>'.$menuItem['name'].'</td>';
        echo '<td>'.$menuItem['description'].'</td>';
        echo '<td>'.$menuItem['price'].'</td>';
        echo '<td>';
            $editItemUrl = sprintf('%smenuitem/edit/%s', base_url(), $menuItem['id']);
            $deleteItemUrl = sprintf('%smenuitem/delete/%s', base_url(), $menuItem['id']);
            echo '<div class="btn-group"><a href="'.$editItemUrl.'"><button class="btn btn-primary">Edit</button></a></div>';
            echo '<div class="btn-group"><a href="'.$deleteItemUrl.'"<button class="btn btn-danger">Delete</button></div>';
        echo '</td>';
        echo '</tr>';
    }
    echo '</tbody></table><br/>';
}
?>

<?php $this->load->view('shared/dash/fluidEnd') ?>
<?php $this->load->view('shared/dash/footer') ?>
<script type="text/javascript">
    $(document).ready(function() {
        $('.table').DataTable({
            "bFilter": false,
            "bPaginate": false
        });
        $('.dataTables_info').remove();
        $('div.dataTables_wrapper > div.row-fluid').remove();
    });
</script>