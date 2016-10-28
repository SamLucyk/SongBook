<div class='col-md-10 col-md-offset-1 col-xs-12 padd-20'>
<table id="songs-table" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
            <?php if(count($songs) == 0){ ?>
                <th>Songs</th>
            <?php } else { ?>
                <th>Name</th>
                <th>Created</th>
                <th>Status</th>
                <th>Album</th>
            <?php }?>
            </tr>
        </thead>
        <tbody>
            <?php if(count($songs) == 0){ ?>
            <tr class='clickable-row' data-href='<?php echo site_url('songbook/newsong')?>'>
                <td>Create Song</td>
            </tr>
            <?php } else {
                foreach($songs as $song){ ?>
            <tr class='clickable-row' data-href='<?php echo site_url('songbook/song/v/'.$song->ID)?>'>
                <td><?php echo $song->name ?></td>
                <td><?php echo $song->created_at ?></td>
                <td><?php echo $song->status->name ?></td>
                <td><?php echo $song->album->name ?></td>
            </tr>
            <?php }
                } ?>
        </tbody>
    </table>

<script>
$(document).ready(function() {
    $('#songs-table').DataTable( {
        "info": false,
        "scrollY": "300px",
        "scrollCollapse": true,
        "paging": false
} );
} );
    
jQuery(document).ready(function($) {
    $(".clickable-row").click(function() {
        window.document.location = $(this).data("href");
    });
});
</script>