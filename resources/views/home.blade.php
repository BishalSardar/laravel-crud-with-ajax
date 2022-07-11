<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

    <style>
        h1 {
            text-align: center;
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
            margin-top: 1em;
        }

        .container {
            width: 50%;
        }

        .table-2 {
            padding-top: 5em;
        }

        .image-style {
            width: 50px;
            height: 50px;
            object-fit: cover;
        }

        .btn-2 {
            float: right;
            margin-bottom: 2em;
        }
    </style>
</head>

<body>
    <h1>CRUD OPERATION</h1>

    <div class="container" id="person-container">
        <div class="center">
            <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal-add">
                Add
            </button>
        </div>
        <table class="table">
            <thead>
                <th>Name</th>
                <th>Details</th>
            </thead>
            <tbody id="table-body">

            </tbody>
        </table>
    </div>

    <div class="modal fade" id="exampleModal-add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="frm">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="">Name</label>
                            <input type="text" id="name" class="form-control" name="name">
                        </div>
                        <div class="form-group">
                            <label for="">Details</label>
                            <input type="text" id="details" class="form-control" name="details">
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" id="save-btn">Save changes</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModal-edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="update-frm">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="">Name</label>
                            <input type="text" id="update-name" class="form-control" name="name">
                        </div>
                        <div class="form-group">
                            <label for="">Details</label>
                            <input type="text" id="update-details" class="form-control" name="details">
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" id="update-btn">Update</button>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>


    <div class="modal fade" id="exampleModal-delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h1>Are you sure, you want to delete</h1>
                    <div class="d-flex justify-content-center">
                        <a id="delete-button" class="btn btn-primary m-1" id="save-btn">Yes</a>
                        <a class="btn btn-danger m-1" id="save-btn">No</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>

    <script>
        let global_id = "";

        $(window).on('load', function() {
            getItem();
        })

        function getItem() {
            $.ajax({
                url: "/get-item",
                type: "get",
                dataType: "json",
                success: function(data) {
                    let person = data['person'];
                    let tbody = document.getElementById('table-body');
                    for (let i = 0; i < person.length; i++) {
                        var person_id = person[i]['id'];
                        let template = `<tr>
                                            <td>${person[i]['name']}</td>
                                            <td>${person[i]['details']}</td>
                                            <td> <div>
                                                    <a><button class="btn btn-success" onClick="updatePerson(${person_id})">Update</button></a>
                                                    <a><button class="btn btn-danger" onClick="deletePerson(${person_id})">Delete</button></a>
                                                </div>
                                            </td>
                                            </tr>`;
                        tbody.innerHTML += template;
                    }
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }


        function deletePerson(id) {
            $('#delete-button').on('click', function() {
                $.ajax({
                    url: "delete/" + id,
                    type: "get",
                    success: function(data) {
                        let tbody = document.getElementById('table-body');
                        tbody.innerHTML = "";
                        getItem();
                        $('#exampleModal-delete').modal('hide');
                    },
                });
            })
            $('#exampleModal-delete').modal('show');
        }




        $('#frm').submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: "/form-submit",
                type: 'post',
                data: $('#frm').serialize(),
                success: function(data) {
                    let tbody = document.getElementById('table-body');
                    tbody.innerHTML = "";
                    getItem();
                    $('#exampleModal-add').modal('hide');
                    console.log("Heloow");
                },
                error: function(data) {
                    console.log(data);
                }
            });
        });


        $('#update-btn').on('click', function(e) {
            e.preventDefault();
            editPerson();
        })


        function updatePerson(id) {
            global_id = id;

            $.ajax({
                url: "edit/" + id,
                type: "get",
                success: function(data) {
                    document.getElementById('update-name').value = `${data.person.name}`;
                    document.getElementById('update-details').value = `${data.person.details}`;
                },
            });


            $('#exampleModal-edit').modal('show');
        }

        function editPerson() {
            console.log(global_id);
            $.ajax({
                url: "update/" + global_id,
                type: 'post',
                data: $('#update-frm').serialize(),
                success: function(data) {
                    let tbody = document.getElementById('table-body');
                    tbody.innerHTML = "";
                    getItem();
                    $('#exampleModal-edit').modal('hide');
                },
                error: function(data) {
                    console.log("hello world");
                }
            })
        }
    </script>
</body>

</html>