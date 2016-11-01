<?php $this->load->view('songbook/top'); ?>
<?php $userdata = $this->session->userdata('user_data'); ?>
    Song
    <div class="transbox-b-dark col-sm-8 col-sm-offset-2 col-xs-12">
        <h1><?php echo $song->name;?></h1>
        <h4>By <?php echo $song->artist; ?></h4>
    </div>
    <div class="padd-20 col-xs-12 col-sm-10 col-sm-offset-1">
        <div class="col-xs-12 transbox-b">
            <h4 class="col-xs-4 control-label">Info <a onclick="toggle('info')" class="glyph glyph-edit"><span id="info-toggle" style="font-size:16px" class="glyphicon glyphicon-chevron-up"></span></a></h4>
            <h4 class="col-xs-4 control-label">Audio <a onclick="toggle('audio')" class="glyph glyph-edit"><span id="audio-toggle" style="font-size:16px" class="glyphicon glyphicon-chevron-up"></span></a></h4>
            <h4 class="col-xs-4 control-label">Videos <a onclick="toggle('video')" class="glyph glyph-edit"><span id="video-toggle" style="font-size:16px" class="glyphicon glyphicon-chevron-up"></span></a></h4>
        </div>
        <div id="info-container" style="display:none" class="padd-20">
            <div class="col-xs-12 transbox-b">
                <div id='status' class="col-md-4">
                    <h4>Status: <?php echo $song->status->name; ?></h4>
                </div>
                <div id='album' class="col-md-4">
                    <h4>Album: <?php echo $song->album->name; ?></h4>
                </div>
                <div id='created' class="col-md-4">
                    <h4>Created: <?php echo $song->created_at; ?></h4>
                </div>
            </div>
        </div>
        <?php if(isset($audios) && !empty($audios)){ ?>
        <div id="audio-container" class="padd-20" style="display:none">
            <div  class="audio-container" >
                <?php foreach($audios as $audio){ ?>
                <div class="transbox-b col-md-6" id="<?php echo 'audio_'.$audio->ID; ?>">
                <div><span ><?php echo $audio->name ?> </span></div>
                <audio controls>
                    <source src="<?php echo $audio->src; ?>" type="audio/mp3">
                </audio>
                </div>
                <?php } ?>
            </div>
        </div>
        <?php } ?>
        <?php if(isset($videos) && !empty($videos)){ ?>
        <div id="video-container" class="padd-20" style="display:none">
            <div class="video-container" >
                <?php foreach($videos as $video){ ?>
                <div class="col-md-6" id="<?php echo 'video_'.$video->ID; ?>">
                <div><span><?php echo $video->name ?> </span></div>
                <video style="width:300px" class="" controls=""><source src="<?php echo $video->src ?>" type="video/mp4"></video>
                </div>
                <?php } ?>
            </div>
            <?php } ?>
        </div>
        <div class="transbox-b-dark lyric-container col-md-10 col-md-offset-1 padd-20">
            <h3>Lyrics:</h3>
            <?php if($song->lyrics->content != ''){ echo $song->lyrics->content;}
            else { ?> 
            <a href="<?php echo site_url('songbook/song/e/'.$song->ID) ?>"><p>Click here to add lyrics!</p></a>
            <?php }?>
        </div>
        <div class="col-xs-12 padd-20-20">
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
    
    function toggle(ele){
        var item = document.getElementById(ele + '-container');
        var toggle = document.getElementById(ele + '-toggle');
        if(item.style.display == 'none'){
            item.style.display = '';
            toggle.classList = 'glyphicon glyphicon-chevron-down';
        } else{
            item.style.display = 'none';
            toggle.classList = 'glyphicon glyphicon-chevron-up';
        }
    }
</script>
<?php $this->load->view('footer'); ?>