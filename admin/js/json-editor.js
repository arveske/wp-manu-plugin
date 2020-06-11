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
