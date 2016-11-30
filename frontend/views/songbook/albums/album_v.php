<?php $this->load->view('songbook/top'); ?>
<?php $userdata = $this->session->userdata('user_data'); ?>
<span class="page-label">Album</span>
    <div class="col-sm-3 col-sm-offset-0 col-xs-10 col-xs-offset-1 padd-0-20">
        <div class='under_shadow'>
        <div class="album_pic" style="background-image:url(<?php echo $album->pic->src; ?>)"></div>
        </div>
        <div class="marg-10-0">
        <div id='status' class="col-xs-6">
            <div data-toggle="tooltip" data-placement="bottom" title="Status" class="status_badge under_shadow"><?php echo $album->status->name; ?></div>
        </div> 
        <div id='created' class="col-xs-6">
            <div data-toggle="tooltip" data-placement="bottom" title="Created" class="status_badge under_shadow"><?php echo $album->created_at; ?></div>
        </div> 
        </div>
    </div>
    <div class="transbox-b-dark col-sm-6 col-xs-12">
        <h1><?php echo $album->name;?></h1>
    </div>
    <div class="col-sm-9">
        <table id="songs-table" class="table table-striped table-bordered songs-table" cellspacing="0" width="100%">
            <thead>
                <tr>
                <?php if(count($album->songs) == 0){ ?>
                    <th>Songs</th>
                <?php } else { ?>
                    <th>Track</th>
                    <th>Name</th>
                    <th>Created</th>
                    <th>Status</th>
                <?php }?>
                </tr>
            </thead>
            <tbody>
                <?php if(count($album->songs) == 0){ ?>
                <tr class='clickable-row' data-href='<?php echo site_url('songbook/newsong/?aid='.$album->ID)?>'>
                    <td>Create Song</td>
                </tr>
                <?php } else {
                    foreach($album->songs as $song){ ?>
                        <tr class='clickable-row' data-href='<?php echo site_url('songbook/song/v/'.$song->ID)?>'>
                            <td width="10%"><?php echo $song->track_num ?></td>
                            <td><?php echo $song->name ?></td>
                            <td><?php echo $song->created_at ?></td>
                            <td><?php echo $song->status->name ?></td>
                        </tr>
                <?php }
                    } ?>
            </tbody>
        </table>
    </div>
    <div class="col-xs-12 padd-40-20">
        <div class="col-sm-6 center padd-0-20">
            <a href="<?php echo site_url('songbook/album/e/'.$album->ID) ?>"><input id="about-btn" class="button button-info" value="Edit"></a>
        </div>
        <div class="col-sm-6 center padd-0-20">
            <a class="confirm" href="<?php echo base_url('songbook/delete_album/'.$album->ID) ?>"> <input id="form-btn" class="button button-info" value="Delete"></a>
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
    
$(document).ready(function() {
    $('#songs-table').DataTable( {
        "info": false,
        "scrollY": "400px",
        "scrollCollapse": true,
        "paging": false
} );
    addNewSongButton();
    setActive('album');
} );
    
jQuery(document).ready(function($) {
    $(".clickable-row").click(function() {
        window.document.location = $(this).data("href");
    });
});
    
    function addNewSongButton(){
        var a = document.createElement("a");
        a.setAttribute("href", "<?php echo site_url('songbook/newsong/?aid='.$album->ID)?>");
        a.setAttribute("style", "padding-right:5px");
        a.classList = 'glyph glyph-edit';
        var span = document.createElement('span');
        span.classList = "glyphicon glyphicon-plus";
        a.appendChild(span);
        var search = document.getElementById('songs-table_filter');
        search.prepend(a);
    }
    
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip(); 
    });
</script>
<?php $this->load->view('songbook/footer'); ?>