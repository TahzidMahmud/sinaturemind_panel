<div class="container">
    <div class="row">
        <img src="./theme/assets/images/logoamr.png" alt="logo-small" class="float-center" style="height:5rem;width:5rem;position:absolute;left:10%;top:2%;" >
        <div style="position:absolute;top:2%;right:10%;"><button id="prntt" class="btn btn-primary">Print/Pdf</button></div>
    </div><br>
    <div class="row">
        <h4 class="" style="position:absolute;top:15%;left:8%;right:20%;"><b><?php echo $this->store["xorgname"] ;?></b></h4>
         <h6 class="" style="position:absolute;top:18%;left:8%;right:20%;">Address: <?php echo $this->store["xaddress"] ;?> ,<?php echo $this->store["xdistrict"] ;?>,<?php echo $this->store["xthana"] ;?>, </h6>
          <h6 class="" style="position:absolute;top:20%;left:8%;right:20%;">Mobile: <?php echo $this->store["xstore"] ;?></h6>
          
        
    </div>
    <div style="display:flex;justify-content:space-between;position:absolute;top:28%;min-width:100%;">
        
        <div style="min-width:50%;">
            <h6><b>Deleivery For: <?php echo $this->mst["xtoparty"];?></b></h6>
            <h6>Address: ,<?php echo $this->mst["xdeladd"];?> <?php echo $this->mst["xdelthana"];?> <?php echo $this->mst["xdeldistrict"];?></h6>
            <h6>Mobile no: <?php echo $this->mst["xdelmobile"];?></h6>
        </div>
        <div style="min-width:50%;">
            <h6><b>Order No : <?php echo $this->mst["xossl"];?></b></h6>
           <h6><b>Order Date : </b><span style="margin-right:5rem;"><?php echo date("d-m-Y", strtotime($this->mst["ztime"]));  ?></span> <b>Time : </b><?php echo date("h:m:sa", strtotime($this->mst["ztime"])); ?></h6>
            <h6><b>Deliver Date : </b><span style="margin-right:5rem;"><?php echo $this->dt;  ?></span> <b>Time : </b><?php echo $this->tm;  ?></h6>
        </div>
    </div>
    <div style="position:absolute;top:41%;left:2%;min-width:98%">
        <hr style="padding-bottom:0px;margin-bottom:0px;
  border-width: 1px;">
        <table class="table" style="min-width:100%;">
          <thead>
            <tr>
              <th scope="col" style="text-align:left;width:10%">SL No</th>
              <th scope="col" style="text-align:center;width:50%">Product</th>
              <th scope="col" style="text-align:center;width:10%">Quantity</th>
              <th scope="col" style="text-align:center;width:10%">MRP</th>
              <th scope="col" style="text-align:center;width:10%">Discount Price</th>
              <th scope="col" style="text-align:center;width:10%">Bill</th>
            </tr>
          </thead>
          <tbody>
              <?php $sl=0;$total=0;$total_mrp=0;?>
              <?php foreach($this->orders as $order){?>
              <?php $sl++?>
            <tr style="border-left:1px;">
              <th style="text-align:left;width:10%"><?php echo $sl;?></th>
              <td style="text-align:left;width:50%"><?php echo $order["item_name"];?></td>
              <td style="text-align:center;width:10%"><?php echo number_format($order["xqty"]);?></td>
              <td style="text-align:center;width:10%"><?php echo $order["mrp"];?></td>
              <td style="text-align:center;width:10%"><?php echo number_format($order["xprice"],2);?></td>
              <td style="text-align:center;width:10%"><?php echo $order["xprice"]*$order["xqty"];?></td>
              <?php $total+=$order["xprice"]*$order["xqty"];$total_mrp+=$order["mrp"]*$order["xqty"]?>
            </tr>
            <?php }?>
           
          </tbody>
        </table><hr style=" border-style: inset;
  border-width: 2px;">
  <h4 class="" style="text-align:right;margin-right:5rem;">Sub-Total : <?php echo $total_mrp;?> ৳</h4>
  <h4 class="" style="text-align:right;margin-right:5rem;">Shipping : <?php echo $this->mst["shipping"];?> ৳</h4>
        
        <h4 style="text-align:right;margin-right:5rem;">Discount : <?php echo ($total_mrp-$total);?> ৳</h4>
        <h4 class="" style="text-align:right;margin-right:5rem;">Total Bill : <?php echo $total + $this->mst["shipping"];?> ৳</h4>
        <h4 class="" style="text-align:right;margin-right:5rem;">Cash to Collect : <?php echo $total + $this->mst["shipping"];?> ৳</h4>
        
        <hr style=" border-style: inset;
  border-width: 2px;">
  <h4><b>Sorry, We Are Unable to Deliver The Following Item(s)</b></h4>
        <table class="table" style="min-width:100%;">
          <thead>
            <tr>
              <th scope="col" style="text-align:left;width:10%">SL No</th>
              <th scope="col" style="text-align:center;width:50%">Product</th>
              <th scope="col" style="text-align:center;width:10%">Quantity</th>
              <th scope="col" style="text-align:center;width:10%">MRP</th>
              <th scope="col" style="text-align:center;width:10%">Discount Price</th>
              <th scope="col" style="text-align:center;width:10%">Bill</th>
            </tr>
          </thead>
          <tbody>
                <?php $s=0;?>
              <?php foreach($this->cancel_order as $order){?>
              <?php $s++?>
            <tr style="border-left:1px;">
              <th style="text-align:left;width:10%"><?php echo $s;?></th>
              <td style="text-align:left;width:50%"><?php echo $order["item_name"];?></td>
              <td style="text-align:center;width:10%"><?php echo number_format($order["xqty"]);?></td>
              <td style="text-align:center;width:10%"><?php echo $order["mrp"];?></td>
              <td style="text-align:center;width:10%"><?php echo number_format($order["xprice"],2);?></td>
              <td style="text-align:center;width:10%"><?php echo $order["xprice"]*$order["xqty"];?></td>
              
            </tr>
            <?php }?>
           
          </tbody>
        </table>
        
        
        <div style="min-height:10rem;">
            <h5><b>Note : </b></h5>
        </div>
    </div>
</div>
