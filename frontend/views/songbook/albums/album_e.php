<?php $this->load->view('songbook/top'); ?>
<?php $userdata = $this->session->userdata('user_data'); ?>
    Song
    <form id="albumUpdateForm" action="<?php echo base_url('songbook/update_album/'.$album->ID); ?>" method="post">
        <div class="transbox-b-dark col-sm-8 col-sm-offset-2 col-xs-12">
            <h1>
                <div class="form-group">
                    <input type="text" class="form-control" id='name' name="name" style="font-variant: none;" value="<?php echo $album->name ?>" onblur="inputBlur(this)">
                </div>
            </h1>
        </div>
        <div class="padd-20 col-xs-12">
            <div class="col-md-4">
                <h3>Status: 
                    <div class="form-group">
                        <select class="form-control" id="status" name="status">
                            <?php foreach($statuses as $status){ ?>
                                <option value="<?php echo $status->ID; ?>" <?php if($status->ID == $album->status_id){echo 'selected';} ?>><?php echo $status->name; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </h3>
            </div>
            <div class="col-md-4">
                <h3>Created: 
                    <div class="form-group">
                        <div class='input-group date' id='datetimepicker1' style="color:black">
                            <input type='text' name='created_at' class="form-control" value="<?php echo $album->created_at?>"/>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </h3>
            </div>
            <div class="col-md-10 col-md-offset-1 padd-40-20">
                <div class="col-md-6 center">
                    <a onclick='updateSong()'><input id="about-btn" class="button button-info" value="Save"></a>
                </div>
                <div class="col-md-6 center">
                    <a href="<?php echo base_url('songbook/album/v/'.$album->ID) ?>"> <input id="form-btn" class="button button-info" value="Cancel"></a>
                </div>
            </div>  
        </div>
        </form>
<div class="col-md-4">
    <form action="<?php echo base_url('songbook/upload_album_pic/'.$album->ID)?>" method="post" enctype="multipart/form-data">
        Select image to upload:
        <input type="file" name="fileToUpload" id="fileToUpload">
        <input type="submit" value="Upload Image" name="submit">
    </form>
</div>
</div
</div>
<script type="text/javascript">
    $(function () {
        $('#datetimepicker1').datetimepicker({
                    format: 'MM/DD/YYYY'
        });
    });
    
    function updateSong() {
        document.getElementById("albumUpdateForm").submit();
    }
</script>
<?php $this->load->view('footer'); ?>