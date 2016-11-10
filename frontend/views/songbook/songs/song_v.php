<?php $this->load->view('songbook/top'); ?>
<?php $userdata = $this->session->userdata('user_data'); ?>
    <span class="page-label">Song</span>
     <div class="col-sm-4 col-sm-offset-0 col-xs-10 col-xs-offset-1 padd-0-20">
        <div class='under_shadow'>
        <div class="song_album_pic" style="background-image:url(<?php echo $song->album->pic->src; ?>)"></div>
        </div>
         <?php if(isset($audios) && !empty($audios)){ ?>
        <div id="audio-container" class="" >
            <div class="" >
                <?php foreach($audios as $audio){ ?>
                <div class="col-md-12 audio-margin" id="<?php echo 'audio_'.$audio->ID; ?>">
                    <div class="boxshadow">
                    <div><span ><?php echo $audio->name ?> </span></div>
                    <audio controls>
                        <source src="<?php echo $audio->src; ?>" type="audio/mp3">
                    </audio>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
        <?php } ?>
    </div>
    <div class="transbox-b-dark col-sm-8 col-xs-12">
        <h1><?php echo $song->name;?></h1>
        <h4>By <?php echo $song->artist; ?></h4>
    </div>
    <div class="padd-20 col-xs-12 col-sm-8">
        <div class="col-xs-12 padd-20" id="info-container">
            <div class="col-xs-12 transbox-b">
                <div id='status' class="col-md-4">
                    <h4>Status: <?php echo $song->status->name; ?></h4>
                </div>
                <div id='album' class="col-md-4">
                    <h4>Album: <a href="<?php echo base_url("songbook/album/v").'/'.$song->album->ID?>"><?php echo $song->album->name; ?></a></h4>
                </div>
                <div id='created' class="col-md-4">
                    <h4>Created: <?php echo $song->created_at; ?></h4>
                </div>
            </div>
        </div>
        
        <?php if(isset($videos) && !empty($videos)){ ?>
        <div id="video-container" class="padd-20">
            <div class="video-container" >
                <?php foreach($videos as $video){ ?>
                <div class="col-md-12" id="<?php echo 'video_'.$video->ID; ?>">
                    <div class="boxshadow">
                        <div><span><?php echo $video->name ?> </span></div>
                        <video style="width:300px" class="" controls=""><source src="<?php echo $video->src ?>" type="video/mp4"></video>
                    </div>
                </div>
                <?php } ?>
            </div>
            <?php } ?>
        </div>
        <div class="col-xs-12 padd-20">
            <div class="transbox-b-dark lyric-container col-md-10 col-md-offset-1">
                <h3>Lyrics:</h3>
                <?php if($song->lyrics->content != ''){ echo $song->lyrics->content;}
                else { ?> 
                <a href="<?php echo site_url('songbook/song/e/'.$song->ID) ?>"><p>Click here to add lyrics!</p></a>
                <?php }?>
            </div>
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
    setActive('song');
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
<?php $this->load->view('songbook/footer'); ?>