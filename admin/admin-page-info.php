<?php
function manu_plugin_page()
{
/*
Show table with data from JSON file
*/
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
            <th style="width: 8%">#</th>
            <th style="width: 20%">Name</th>
            <th style="width: 20%">Position</th>
            <th style="width: 32%">Stack</th>
            <th style="width: 20%">Actions</th>
          </tr>
        </thead>
        <tbody>
<?php
    $jsonPath = get_home_url() . '/wp-content/plugins/manu-test-plugin/data.json';
    $deletUrl = get_home_url() . '/index.php/wp-json/manu/developers/delete-developer/';
    $editUrl = get_home_url() . '/index.php/wp-json/manu/developers/edit-developer/';
    $response = wp_remote_get($jsonPath);
    $responseBody = wp_remote_retrieve_body($response);
    $jsonObject = json_decode($responseBody, true);
    $couner = 0;
    foreach ($jsonObject['items'] as $object)
    {
        echo '<tr><td>' . ($couner + 1) . '</td><td>' . $object['name'] . '</td><td>' . $object['position'] . '</td><td>' . $object['stack'] . '</td><td>
                    <button type="button" class="btn btn-primary btn-sm edit-button" data-toggle="modal" data-target="#editModal" data-name="' . $object['name'] . '"
                    data-position="' . $object['position'] . '" data-stack="' . $object['stack'] . '" data-id="' . $couner . '" data-url="' . $editUrl . '">Edit</button>
                    <button type="button" class="btn btn-danger btn-sm delete-button" data-toggle="modal" data-target="#deleteModal" data-id="' . $couner . '"
                    data-url="' . $deletUrl . '" data-name="' . $object['name'] . '">Delete</button>
                    </td></tr>';
        $couner++;
    }
?>

        </tbody>
      </table>
    </div>
</div>

<!-- Modal for editor -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Изменить данные разработчика</h5>
      </div>
      <div class="modal-body edit-body">
        <form>
          <div class="form-group">
            <label for="inputName">Name</label>
            <input type="text" class="form-control" id="inputName" value="">
          </div>
          <div class="form-group">
            <label for="inputName">Position</label>
            <input type="text" class="form-control" id="inputPosition" value="">
          </div>
          <div class="form-group">
            <label for="inputStack">Stack</label>
            <input type="text" class="form-control" id="inputStack" value="">
          </div>
          <button type="submit" onclick="editObject()" class="btn btn-primary" data-dismiss="modal">Сохранить</button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" id="editSave" class="btn btn-secondary"  data-dismiss="modal">Отмена</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal for delete -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModalLabel">Вы уверены, что хотите удалить выбранный элемент?</h5>
      </div>
      <div class="modal-body del-body">
        <span>#</span>
        <span id="devId"></span>
        <span> Name: </span>
        <span id="devName"></span>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Нет</button>
        <button type="button" class="btn btn-danger" onclick="deleteObject()" data-dismiss="modal">Да</button>
      </div>
    </div>
  </div>
</div>

<!-- Footer scripts -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<?php
    $scriptPath = plugin_dir_url(__FILE__) . 'js/json-editor.js';
    echo '<script src="' . $scriptPath . '"></script>';
}
