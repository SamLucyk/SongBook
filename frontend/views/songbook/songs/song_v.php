<?php $this->load->view('songbook/top'); ?>
<?php $userdata = $this->session->userdata('user_data'); ?>
    Song
    <div class="transbox-b-dark col-sm-8 col-sm-offset-2 col-xs-12">
        <h1><?php echo $song->name;?></h1>
        <h4>By <?php echo $user->first.' '.$user->last ?></h4>
    </div>
    <div class="padd-20 col-xs-12">
        <audio controls>
            <source src="<?php echo base_url('uploads/15-_-Silver-Song.mp3'); ?>" type="audio/mp3">
</audio>
        <div class="col-md-12 padd-0-20">
        <div id='status' class="col-md-4">
            <h3>Status: <?php echo $song->status->name; ?></h3>
        </div>
        <div id='album' class="col-md-4">
            <h3>Album: <?php echo $song->album->name; ?></h3>
        </div>
        <div id='created' class="col-md-4">
            <h3>Created: <?php echo $song->created_at; ?></h3>
        </div>
    </div>
        <div class="transbox-b-dark col-md-10 col-md-offset-1 padd-20">
            <h3>Lyrics:</h3>
            <?php if($song->lyrics->content != ''){ echo $song->lyrics->content;}
            else { ?> 
            <a href="<?php echo site_url('songbook/song/e/'.$song->ID) ?>"><p>Click here to add lyrics!</p></a>
            <?php }?>
        </div>
        <div class="col-xs-12 padd-20-0">
            <div class="col-md-6 center">
                <a href="<?php echo site_url('songbook/song/e/'.$song->ID) ?>"><input id="about-btn" class="button button-info" value="Edit"></a>
            </div>
            <div class="col-md-6 center">
                <a class="confirm" href="<?php echo base_url('songbook/delete_song/'.$song->ID) ?>"> <input id="form-btn" class="button button-info" value="Delete"></a>
            </div>
        </div> 
    </div>
</div>
</div>
<script>
$(function() {
    $('.confirm').click(function() {
        return window.confirm("Are you sure you want to delete \"<?php echo $song->name ?>\"? (This can not be undone)");
    });
});
</script>
<?php $this->load->view('footer'); ?>