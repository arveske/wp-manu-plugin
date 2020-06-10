	<?php
function manu_plugin_page() {

	?>
  <div class="container border">
    <div class="row bg-light">
      <div class="col-auto mr-auto"><p class="main-name text-dark align-middle">Striped Table</p></div>
      <div class="col-auto"><p class="main-link-name text-danger align-middle">.table-striped</p></div>
    </div>
    <div class="row">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>#</th>
            <th>Name</th>
            <th>Position</th>
            <th>Stack</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
<?php
                  $jsonPath = get_home_url(). '/wp-content/plugins/manu-test-plugin/data.json';
                  $response = wp_remote_get($jsonPath);
                  $responseBody = wp_remote_retrieve_body( $response );
                  $jsonObject = json_decode( $responseBody, true);
                  $couner = 0;
                  foreach ($jsonObject['items'] as $object) {
                    echo '<tr><td>' . $couner . '</td><td>' . $object['name'] . '</td><td>' . $object['position'] . '</td><td>' . $object['stack'] . '</td><td>
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                      <label class="btn btn-primary btn-sm">
                        <input type="radio" name="options" id="option1" autocomplete="off">Edit
                      </label>
                      <label class="btn btn-danger btn-sm">
                        <input type="radio" name="options" id="option2" autocomplete="off">Delete
                      </label>
                    </div>
                    </td></tr>';
                    $couner++;
                  }
    ?>

        </tbody>
      </table>
    </div>
</div>

	<?php
}
