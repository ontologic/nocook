<?php $this->load->view('shared/header') ?>
<?php $this->load->view('shared/nav') ?>

<div class="container">

    <div class="row">


        <div class="main span8">

            <div class="panel panel-default">
                <!-- Default panel contents -->
                <div class="panel-heading">Orders</div>
                <div class="panel-body">
                    <p>This will eventually be an interactive grid that lets users sort, search, and modify orders so that it is easy and simple to get everything in one place</p>
                </div>

                <!-- Table -->
                <table class="table">
                    <thead>
                    <tr>
                        <th>Date</th>
                        <th>Name</th>
                        <th>Order</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>1/14/14</td>
                        <td>Mark Smith</td>
                        <td>Steak</td>
                        <td><div class="btn-group">
                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                    Action <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="#">Status</a></li>
                                    <li><a href="#">Not Made</a></li>
                                    <li><a href="#">Waiting on Delivery</a></li>
                                    <li class="divider"></li>
                                    <li><a href="#">Delivered</a></li>
                                </ul>
                            </div></td>
                    </tr>
                    <tr>
                        <td>1/14/14</td>
                        <td>Jacob Rogers</td>
                        <td>Salad</td>
                        <td><div class="btn-group">
                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                    Action <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="#">Status</a></li>
                                    <li><a href="#">Not Made</a></li>
                                    <li><a href="#">Waiting on Delivery</a></li>
                                    <li class="divider"></li>
                                    <li><a href="#">Delivered</a></li>
                                </ul>
                            </div></td>
                    </tr>
                    <tr>
                        <td>1/14/14</td>
                        <td>Larry the Bird</td>
                        <td>Apples and Oranges</td>
                        <td><div class="btn-group">
                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                    Action <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="#">Status</a></li>
                                    <li><a href="#">Not Made</a></li>
                                    <li><a href="#">Waiting on Delivery</a></li>
                                    <li class="divider"></li>
                                    <li><a href="#">Delivered</a></li>
                                </ul>
                            </div></td>
                    </tr>
                    </tbody>
                </table>
            </div>


        </div>
    </div><!-- end of row?-->
</div><!-- end of container-->



<?php $this->load->view('shared/footer') ?>