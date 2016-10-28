<?php $this->load->view('songbook/top'); ?>
<?php $userdata = $this->session->userdata('user_data'); ?>
    Album
    <div class="transbox-b-dark col-sm-8 col-sm-offset-2 col-xs-12">
        <h1><?php echo $album->name;?></h1>
    </div>
    <div class="padd-20 col-xs-12">
        <div class="col-md-12">
        <div class="col-md-4">
            <h3>Status: <?php echo $album->status->name; ?></h3>
        </div>
        <div class="col-md-4">
            <h3>Created: <?php echo $album->created_at; ?></h3>
        </div>
        <div class="col-md-10 col-md-offset-1 padd-40-20">
            <div class="col-md-6 center">
                <a href="<?php echo site_url('songbook/album/e/'.$album->ID) ?>"><input id="about-btn" class="button button-info" value="Edit"></a>
            </div>
            <div class="col-md-6 center">
                <a class="confirm" href="<?php echo base_url('songbook/delete_album/'.$album->ID) ?>"> <input id="form-btn" class="button button-info" value="Delete"></a>
            </div>
        </div>                          
    </div>
</div>
</div>
<script>
$(function() {
    $('.confirm').click(function() {
        return window.confirm("Are you sure you want to delete \"<?php echo $album->name ?>\"? (This can not be undone)");
    });
});
</script>
<?php $this->load->view('footer'); ?>