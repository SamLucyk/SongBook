<div class='col-md-8 col-md-offset-2'>
<table class="table">
    <thead>
      <tr>
        <th>Name</th>
        <th>Date</th>
        <th>Album</th>
      </tr>
    </thead>
    <tbody>
     <?php foreach($songs as $song){?>
        <tr class="clickable-row" data-href='url://>'>
        <td><?php echo $song->name ?></td>
        <td>1/27/94</td>
        <td>My First Album</td>
        </tr>
        <?php } ?>
    </tbody>
  </table>
</div>

<script>
    jQuery(document).ready(function($) {
    $(".clickable-row").click(function() {
        window.document.location = $(this).data("href");
    });
});

</script>