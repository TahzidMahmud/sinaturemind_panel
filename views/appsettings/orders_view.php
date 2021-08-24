
<div class="container-fluid">
                    <!-- Page-Title -->
         <h3 class="text-center">Your Orders ( <?php echo $this->count;?>)</h3>
         <div class="row">
             <h5 class="text-center col-sm-4">Filter By Status</h5>
             <select id="fltstat" class="form-control col-sm-6">
                 <?php if($this->stat==""){?>
                   <option value="" selected>All Types</option>
                 <?php }else{?>
                 <option value="" >All Types</option>
                 <?php }?>
                 
                 <?php if($this->stat=="Pending"){?>
                   <option value="Pending" selected>Pending</option>
                 <?php }else{?>
                 <option value="Pending">Pending</option>
                 <?php }?>
                 
                 <?php if($this->stat=="Processing"){?>
                   <option value="Processing" selected>Processing</option>
                 <?php }else{?>
                  <option value="Processing">Processing</option>
                 <?php }?>
                 
                 <?php if($this->stat=="Canceled"){?>
                   <option value="Canceled" selected>Canceled</option>
                 <?php }else{?>
                 <option value="Canceled">Canceled</option>
                 <?php }?>
                 
                 <?php if($this->stat=="Delivered"){?>
                   <option value="Delivered" selected>Delivered</option>
                 <?php }else{?>
                 <option value="Delivered">Delivered</option>
                 <?php }?>
                 
                 <?php if($this->stat=="Clear"){?>
                   <option value="Clear" selected>Cleared</option>
                 <?php }else{?>
                  <option value="Clear">Cleared</option>
                 <?php }?>
              
                 
             </select>
         </div>
         <hr>
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
                                                    <th class="border-top-0">Action</th>
                                                    
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
                                                    <td><button id="mst<?php echo( $this->orders[$i]['xossl'] )?>" class="btn btn-<?php echo $statclr ?>" onClick="openorders_table(<?php echo( $this->orders[$i]['xossl'] )?>)"><?php echo( $this->orders[$i]['xstatus'] )?></button></td>
                                                    <td><?php if($this->orders[$i]['xstatus']=="Delivered"){?>
                                                    <button class=
                                                    "btn btn-secondary" onclick="generate_voucher(<?php echo $this->orders[$i]['xossl']; ?>)">Voucher</button>
                                                    <?php }else{?>
                                                    None
                                                    <?php }?>
                                                    </td>
                                                  </tr>
                                            <?php }?>                              
                                            </tbody>
                                        </table> <!--end table-->                                               
                                    </div>
                                    
                                    <div class="row">
                                            <div id="restbl" class="" style="height:90vh;width:90vw;background-color:RGBA(0,0,0,0.08);display:none;position:fixed;top:2rem;left:1rem;bottom:1rem;">
                                                <div class="card table-responsive">
                                                <div class="row">
                                                <div class="col-md-11">
                                                     <button class="btn btn-danger mt-2 ml-2" id="close-btn">Close X</button>
                                                    <h3 class="text text-center">Orders Details</h3>
                                                </div>
                                                <div class="col-md-1">
                                                   
                                                </div>
                                               
                                                </div><hr>
                                             
                                                    <table class="m-2 table mb-0">
                                                        <thead class="thead-light">
                                                            <tr>
                                                                <th class="border-top-0">Date</th>
                                                                <th class="border-top-0">Bill For</th>
                                                                <th class="border-top-0">Item id</th>
                                                                <th class="border-top-0">Quantity</th>
                                                                <th class="border-top-0">Price</th>
                                                                <th class="border-top-0">Total</th>
                                                                <th class="border-top-0">Status</th>
                                                                <th class="border-top-0">Action</th>
                                                                
                                                            </tr><!--end tr-->
                                                        </thead>
                                                        <tbody id="orderstbl" style="max-height:100vh;overflow-y:scroll;">
                                                                                   
                                                        </tbody>

                                                    </table>
                                                </div>
                                            </div>
                                    </div>
                
                    
</div><!-- container -->
 
