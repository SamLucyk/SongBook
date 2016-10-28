<?php $this->load->view('songbook/top'); ?>
<?php $userdata = $this->session->userdata('user_data'); ?>
    Song
    <form id="songUpdateForm" action="<?php echo base_url('songbook/update_song/'.$song->ID); ?>" method="post">
        <div class="transbox-b-dark col-sm-8 col-sm-offset-2 col-xs-12">
            <h1>
                <div class="form-group">
                    <input type="text" class="form-control" id='name' name="name" style="font-variant: none;" value="<?php echo $song->name ?>" onblur="inputBlur(this)">
                </div>
            </h1>
        </div>
        <div class="padd-20 col-xs-12">
            <div class="col-md-12">
            <div class="col-md-4">
                <h3>Status: 
                    <div class="form-group">
                        <select class="form-control" id="status" name="status">
                            <?php foreach($statuses as $status){ ?>
                                <option value="<?php echo $status->ID; ?>" <?php if($status->ID == $song->status_id){echo 'selected';} ?>><?php echo $status->name; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </h3>
            </div>
            <div class="col-md-4">
                <h3>Album: 
                    <div class="form-group">
                        <select class="form-control" id="album" name="album">
                                <option value="none" selected>No Album</option>
                            <?php foreach($albums as $album){ ?>
                                <option value="<?php echo $album->ID; ?>" 
                                        <?php if(isset($song->album_id)){
                                                if($album->ID == $song->album_id){
                                                    echo 'selected';}
                                        }?>><?php echo $album->name; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </h3>
            </div>
            <div class="col-md-4">
                <h3>Created: 
                    <div class="form-group">
                        <div class='input-group date' id='datetimepicker1' style="color:black">
                            <input type='text' name='created_at' class="form-control" value="<?php echo $song->created_at?>"/>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </h3>
            </div>
            <div class="padd-20 col-md-10 col-md-offset-1 center">
                <label class="control-label">Select File</label>
                <div class="col-xs-12 padd-20-0">
                    <input name="file-upload" id="file-upload" type='file'>
                </div>
            </div>
            <div class="col-md-10 col-md-offset-1 padd-20-20">
                <div class="form-group col-sm-12">
                    <label for="lyrics"><h3>Lyrics</h3></label><br/>
                    <textarea id="lyrics" name="lyrics"><?php echo $song->lyrics->content; ?></textarea>
                </div>
            </div>
            <div class="col-md-10 col-md-offset-1 padd-40-20">
                <div class="col-md-6 center">
                    <a onclick='updateSong()'><input id="about-btn" class="button button-info" value="Save"></a>
                </div>
                <div class="col-md-6 center">
                    <a href="<?php echo base_url('songbook/song/v/'.$song->ID) ?>"> <input id="form-btn" class="button button-info" value="Cancel"></a>
                </div>
            </div>  
        </div>
        </div>
        </form>

<script type="text/javascript">
    $(function () {
        $('#datetimepicker1').datetimepicker({
                    format: 'MM/DD/YYYY'
        });
    });
    
    function updateSong() {
        document.getElementById("songUpdateForm").submit();
    }

    jQuery(document).ready(function(){

    CKEDITOR.replace( 'lyrics', {
        uiColor: '#94A8B1',
        height: '500px'
    });

    });
    
    $("#file-upload").fileinput({'showUpload':true, 'previewFileType':'any', 'multiple':true, 'uploadUrl':'<?php echo site_url('songbook/upload_song'); ?>/<?php echo $song->ID; ?>'});
</script>
<?php $this->load->view('footer'); ?>