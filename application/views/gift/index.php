<?php $this->load->view('shared/header') ?>
<?php $this->load->view('shared/nav') ?>

    <div class="container">
        <?php echo validation_errors(); ?>

        <?php echo form_open(null, array('role' => 'form')) ?>
        <?php foreach ($menuTypes as $menuType) {
            $findGiftOfType = function ($menuItemType)
            {
                return function ($giftItem) use ($menuItemType) { return $giftItem['menuitemtype'] == $menuItemType; };
            };
            $giftOfType = array_filter($giftItems, $findGiftOfType($menuType['id']));
            $wtf = reset($giftOfType);
            $quantityOfGiftType = count($giftOfType) == 0 ? 0 : $wtf['quantity'];

            $menuHeader = sprintf('<h4>%s ($%s) <strong>Choose %d</strong></h4>', $menuType['name'], $menuType['price'], $quantityOfGiftType);
            echo $menuHeader;
            echo '<table class="table"><thead><tr><th>Name</th><th>Description</th><th>Price</th><th>Quantity</th></tr></thead><tbody>';

            $findMenuItemsOfType = function ($menuItemType)
            {
                return function ($item) use ($menuItemType) { return ($item['menuitemtype'] == $menuItemType); };
            };
            $menuItemsOfType = array_filter($menu, $findMenuItemsOfType($menuType['id']));
            foreach($menuItemsOfType as $menuItem)
            {
                echo '<tr>';
                echo '<td>'.$menuItem['name'].'</td>';
                echo '<td>'.$menuItem['description'].'</td>';
                echo '<td>$'.$menuType['price'].'</td>';
                if($quantityOfGiftType > 0)
                {
                    echo '<td><input name="'.$menuItem['id'].'" type="number" value="0" /></td>';
                }
                echo '</tr>';
            }
            echo '</tbody></table><br/>';
        }
        ?>
        <input type="submit" value="Order" class="btn btn-default" />
        </form>
    </div><!-- end of container-->

<?php $this->load->view('shared/footer') ?>