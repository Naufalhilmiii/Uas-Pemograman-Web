<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.min.js" integrity="sha384-heAjqF+bCxXpCWLa6Zhcp4fu20XoNIA98ecBC1YkdXhszjoejr5y9Q77hIrv8R9i" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <title>Data khutbah Jum'at</title>
</head>

<body>
    <div class="container">
        <span id="message">></span>
        <div class="card-header bg-success">
            <div class="row">
            </div>
        </div>
        <h1 class=" mt-4 mb-4 text-center text-success text-bold">DATA KHUTBAH JUM'AT</h1>
        <span id="message"></span>
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col col-sm-9 text-success">Khutbah Jum'at</div>
                    <div class="col col-sm-3">
                        <button type="button" id="add_data" class="btn btn-primary btn-sm float-end">Add</button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered" id="sample_data">
                        <thead>
                            <tr>
                                <th>tanggal</th>
                                <th>nama</th>
                                <th>tema</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" tabindex="-1" id="action_modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" id="sample_form">
                    <div class="modal-header">
                        <h5 class="modal-title" id="dynamic_modal_title"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">tanggal</label>
                            <input type="date" name="tanggal" id="kode" class="form-control" />
                            <span id="tanggal_error" class="text-danger"></span>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">nama</label>
                            <input type="text  " name="nama" id="nama" class="form-control" />
                            <span id="nama_error" class="text-danger"></span>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">tema</label>
                            <input type="text" name="tema" id="tema" class="form-control" />
                            <span id="tema_error" class="text-danger"></span>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="id" id="id" />
                        <input type="hidden" name="action" id="action" value="Add" />
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="action_button">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            showAll();
            $('#add_data').click(function() {

                $('#dynamic_modal_title').text('Add Data');

                $('#sample_form')[0].reset();

                $('#action').val('Add');

                $('#action_button').text('Add');

                $('.text-danger').text('');

                $('#action_modal').modal('show');

            });

            $('#sample_form').on('submit', function(event) {

                event.preventDefault();

                if ($('#action').val() == "Add") {
                    var formData = {
                        'tanggal': $('#tanggal').val(),
                        'nama': $('#nama').val(),
                        'tema': $('#tema').val()
                    }
                    $.ajax({
                        url: "http://localhost/apipraktikum/api/datakhutbah/create.php",
                        method: "POST",
                        data: JSON.stringify(formData),
                        success: function(data) {
                            $('#action_button').attr('disabled', false);
                            $('#message').html('<div class="alert alert-success">' + data.message + '</div>');
                            $('#action_modal').modal('hide');
                            $('#sample_data').DataTable().destroy();
                            showAll();
                        },
                        error: function(err) {
                            console.log(err);
                        }
                    });
                } else if ($('#action').val() == "Update") {
                    var formData = {
                        'id': $('#id').val(),
                        'tanggal': $('#tanggal').val(),
                        'nama': $('#nama').val(),
                        'tema': $('#tema').val()
                    }
                    $.ajax({
                        url: "http://localhost/apipraktikum/api/datakhutbah/update.php",
                        method: "PUT",
                        data: JSON.stringify(formData),
                        success: function(data) {
                            $('#action_button').attr('disabled', false);
                            $('#message').html('<div class="alert alert-success">' + data.message + '</div>');
                            $('#action_modal').modal('hide');
                            $('#sample_data').DataTable().destroy();
                            showAll();
                        },
                        error: function(err) {
                            console.log(err);
                        }
                    });
                }

            });
        });

        function showAll() {
            $.ajax({
                type: "GET",
                contentType: "application/json",
                url: "http://localhost/apipraktikum/api/datakhutbah/read.php",
                success: function(response) {
                    // console.log(response);
                    var json = response.body;

                    var dataSet = [];
                    for (var i = 0; i < json.length; i++) {
                        var sub_array = {
                            'tanggal': json[i].tanggal,
                            'nama': json[i].nama,
                            'tema': json[i].tema,
                            'action': '<button onclick="showOne(' + json[i].id + ')" class="btn btn-sm btn-success">Edit</button>' +
                                '<button onclick="deleteOne(' + json[i].id + ')" class="btn btn-sm btn-danger">Delete</button>'
                        };
                        dataSet.push(sub_array);
                    }
                    $('#sample_data').DataTable({
                        data: dataSet,
                        columns: [{
                                data: "tanggal"
                            },
                            {
                                data: "nama"
                            },
                            {
                                data: "tema"
                            },
                            {
                                data: "action"
                            }
                        ]
                    });
                },
                error: function(err) {
                    console.log(err);
                }
            });
        }

        function showOne(id) {
            $('#dynamic_modal_title').text('Edit Data');

            $('#sample_form')[0].reset();

            $('#action').val('Update');

            $('#action_button').text('Update');

            $('.text-danger').text('');

            $('#action_modal').modal('show');

            $.ajax({
                type: "GET",
                contentType: "application/json",
                url: "http://localhost/apipraktikum/api/datakhutbah/read.php?id=" + id,
                success: function(response) {
                    $('#id').val(response.id);
                    $('#tanggal').val(response.tanggal);
                    $('#nama').val(response.nama);
                    $('#tema').val(response.tema);


                },
                error: function(err) {
                    console.log(err);
                }
            });


        }

        function deleteOne(id) {
            alert('Yakin untuk hapus data ?');
            $.ajax({
                url: "http://localhost/apipraktikum/api/datakhutbah/delete.php",
                method: "DELETE",
                data: JSON.stringify({
                    "id": id
                }),
                success: function(data) {
                    $('#action_button').attr('disabled', false);
                    $('#message').html('<div class="alert alert-success">' + data + '</div>');
                    $('#action_modal').modal('hide');
                    $('#sample_data').DataTable().destroy();
                    showAll();
                },
                error: function(err) {
                    console.log(err);
                }
            });
        }
    </script>
</body>

</html>