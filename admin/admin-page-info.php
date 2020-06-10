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
                  $deletUrl = get_home_url() . '/index.php/wp-json/manu/developers/delete-developer/';
                  $editUrl = get_home_url() . '/index.php/wp-json/manu/developers/edit-developer/';
                  $response = wp_remote_get($jsonPath);
                  $responseBody = wp_remote_retrieve_body( $response );
                  $jsonObject = json_decode( $responseBody, true);
                  $couner = 0;
                  foreach ($jsonObject['items'] as $object) {
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

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script>
let idForDelete;
let idForEdit;
let delUrl;
let editUrl;
function deleteObject() {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", delUrl, true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.send(JSON.stringify({
        id: idForDelete
    }));
    setTimeout(function(){ location.reload(); }, 800);
}

function editObject() {
  let objName = document.getElementById("inputName").value;
  let objPosition = document.getElementById("inputPosition").value;
  let objStack = document.getElementById("inputStack").value;
    var xhr = new XMLHttpRequest();
    xhr.open("POST", editUrl, true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.send(JSON.stringify({
        id: idForEdit,
        name: objName,
        position: objPosition,
        stack: objStack
    }));
    setTimeout(function(){ location.reload(); }, 800);
}


</script>
<script>
$(document).on("click", ".delete-button", function () {
     var objectId = $(this).data('id');
     var pathToPost = $(this).data('url');
     var devName = $(this).data('name');
     $(".del-body #devId").text(objectId + 1);
     $(".del-body #devName").text(devName);
     idForDelete = objectId;
     delUrl = pathToPost;
});

$(document).on("click", ".edit-button", function () {
     var objectName = $(this).data('name');
     var objectPosition = $(this).data('position');
     var objectStack = $(this).data('stack');
     $(".edit-body #inputName").val(objectName);
     $(".edit-body #inputPosition").val(objectPosition);
     $(".edit-body #inputStack").val(objectStack);
     idForEdit = $(this).data('id');
     editUrl = $(this).data('url');
});
</script>

	<?php
}
