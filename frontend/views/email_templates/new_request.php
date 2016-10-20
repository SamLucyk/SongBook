<?php $this->load->view('email_templates/email_header'); ?>
<table border="0" style="max-width: 600px; width:100%; margin-left:50px; margin-right:auto; color:#333;">
    <tr>
        <td>
            <div style="font-size: 16px; line-height: 24px;">
            <p style="margin-top:0px">
                <b>Name: </b><?php echo $first . " " . $last;?><br>
                <b>Email: </b><?php echo $email;?><br>
                <b>Who are you with?: </b><?php echo $who;?><br>
                <b>What do you want to do?: </b><?php echo $what;?><br>
                <b>When is your date?: </b><?php echo $date;?><br>
                <b>Price Range: </b><?php echo $price;?><br>
                
                <?php 
                if (!isset($dinner)) { $dinner = []; }
                if (!isset($time)) { $time = []; }
                if (!isset($location)) { $location = []; }
                if (!isset($other)) { $other = []; }

                $checkboxes = array(
                    "Time of day?:" => $time,
                    "Do you have a neighbor hood preference?:" => $location,
                    "What type of eats are you looking for?:" => $dinner,
                    "Check all that interest you!:" => $other
                );
                foreach ($checkboxes as $key => $list){
                    if (isset($list)){
                        if ($list) {?>
                <b><?php echo $key ?></b><br>  
                    <?php
                        $last = end($list);
                        foreach ($list as $value) { 
                        echo $value; 
                        if (!($value == $last)){?> -- 
                    <?php }} ?><br>
                <?php } }
                }?>
                <b>What are your thoughts on...</b><br>
                <?php 
                foreach ($resturant as $key => $val){ ?>
                        <?php echo $key ?>: <i><?php echo $val ?></i><br>
                <?php } ?>
                <b>What is most important to you?: </b><?php echo $important;?><br>
        
            </p>
            </div>
        </td>
        </tr>
</table>
<?php $this->load->view('email_templates/email_footer'); ?>
