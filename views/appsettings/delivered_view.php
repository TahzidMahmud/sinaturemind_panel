
<div class="container-fluid">
                    <!-- Page-Title -->
         <h3 class="text-center">Your Orders</h3><hr>
                    <div class="table-responsive">
                                        <table class="table mb-0">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th class="border-top-0">Date</th>
                                                     <th class="border-top-0">Order NO</th>
                                                    <th class="border-top-0">Bill For</th>
                                                    <th class="border-top-0">Mobile</th>
                                                    <th class="border-top-0">Billing Address</th>
                                                    <th class="border-top-0">Delivery For</th>
                                                    <th class="border-top-0">Mobile</th>
                                                    <th class="border-top-0">Delivery Address</th>
                                                    <th class="border-top-0">Delivery Method</th>
                                                    <th class="border-top-0">Status</th>
                                                </tr><!--end tr-->
                                            </thead>
                                            <tbody id="" style="max-height:100vh;overflow-y:scroll;">
                                            <?php for($i=0;$i<count($this->orders);$i++){?>
                                                  <tr>
                                                    <td><?php echo( $this->orders[$i]['xdate'] )?></td>
                                                    <td><?php echo( $this->orders[$i]['xossl'] )?></td>
                                                    <td><?php echo( $this->orders[$i]['xparty_name'] )?></td>
                                                    <td><?php echo(  $this->orders[$i]['xpartymobile'] )?></td>
                                                    <td><?php echo( $this->orders[$i]['xpartyadd'] )?></td>
                                                    <td><?php echo(  $this->orders[$i]['xtoparty'] )?></td>
                                                    <td><?php echo( $this->orders[$i]['xdelmobile'] )?></td>
                                                    <td><?php echo( $this->orders[$i]['xdeladd'].','.$this->orders[$i]['xdeldistrict'].','.$this->orders[$i]['xdelthana'] )?></td>
                                                    <td><?php echo( $this->orders[$i]['xwh'] )?></td>
                                                    <?php $statclr=""; if($this->orders[$i]['xstatus'] == "Processing"){
                                                                $statclr="primary";
                                                            }else if($this->orders[$i]['xstatus'] == "Delivered"){
                                                                $statclr="warning";
                                                            }else if($this->orders[$i]['xstatus'] == "Canceled"){
                                                                $statclr="info";
                                                            }else if($this->orders[$i]['xstatus'] == "Clear"){
                                                                $statclr="success";
                                                            }else if($this->orders[$i]['xstatus'] == "Pending"){
                                                                $statclr="danger";
                                                            }else{
                                                                $statclr="primary";
                                                            }?>
                                                    <td><button id="mst<?php echo( $this->orders[$i]['xossl'] )?>" class="btn btn-<?php echo $statclr ?>" onClick="opendelivered_orders_table(<?php echo( $this->orders[$i]['xossl'] )?>)"><?php echo( $this->orders[$i]['xstatus'] )?></button></td>
                                                  </tr>
                                            <?php }?>                              
                                            </tbody>
                                        </table> <!--end table-->                                               
                                    </div>
                                    
                                    <div class="row">
                                            <div id="restbl" class="" style="height:90vh;width:90vw;background-color:RGBA(0,0,0,0.08);display:none;position:fixed;top:2rem;left:5rem;bottom:1rem;">
                                                <div class="card table-responsive">
                                                <div class="row">
                                                <div class="col-md-11">
                                                    <h3 class="text text-center">Orders Details</h3>
                                                </div>
                                                <div class="col-md-1">
                                                    <button class="btn btn-danger mt-2 ml-2" id="close-btn">Close X</button>
                                                </div>
                                               
                                                </div><hr>
                                             
                                                    <table id="dl_table" class="m-2 table mb-0">
                                                        <thead class="thead-light">
                                                            <tr>
                                                                <th class="border-top-0">Date</th>
                                                                <th class="border-top-0">Bill For</th>
                                                                <th class="border-top-0">Item id</th>
                                                                <th class="border-top-0">Quantity</th>
                                                                <th class="border-top-0">Total</th>
                                                                <th class="border-top-0">ABL Comission</th>
                                                                <th class="border-top-0">Action</th>
                                                                
                                                            </tr><!--end tr-->
                                                        </thead>
                                                        <tbody id="del_orderstbl" style="max-height:100vh;overflow-y:scroll;">
                                                                                   
                                                        </tbody>

                                                    </table>
                                                    <br>
                                                    <div class="row">
                                                        <div class="col-md-4"></div>
                                                        <div class="col-md-3 d-flex"><b>Total</b> = <input value="" id="pay-total" readonly class="form-control"> <b>Tk</b></div>
                                                    <div class="col-md-4"><button class="btn btn-lg btn-primary" id="cal-btn">Calculate</button><button class="btn btn-lg btn-success ml-2" id="pay-btn">Pay Now</button></div>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                
                    
</div><!-- container -->
 
