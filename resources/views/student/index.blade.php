@extends('layouts.app')

@section('content')
<!-- AddStudentModal -->
    <div class="modal fade" id="AddStudentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-light">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Student Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="saveform_errList"></div>
                    <div class="form-group mb-3">
                        <label for="">First Name</label>
                        <input type="text" class="first_name form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Last Name</label>
                        <input type="text" class="last_name form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Age</label>
                        <input type="number" class="age form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Phone</label>
                        <input type="tel" class="phone form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary add_student">Save</button>
                </div>
            </div>
        </div>
    </div>
<!-- End -- AddStudentModal -->

<!-- EditStudentModal -->
    <div class="modal fade" id="EditStudentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-light">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit & Update Student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                    <div id="updateform_errList"></div>
                    
                    <input type="hidden" id="edit_stud_id">

                    <div class="form-group mb-3">
                        <label for="">First Name</label>
                        <input type="text" id="edit_first_name" class="first_name form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Last Name</label>
                        <input type="text" id="edit_last_name" class="last_name form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Age</label>
                        <input type="number" id="edit_age" class="age form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Phone</label>
                        <input type="tel" id="edit_phone" class="phone form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary update_student">Update</button>
                </div>
            </div>
        </div>
    </div>
<!-- End -- EditStudentModal -->

<!-- DeleteStudentModal -->
<div class="modal fade" id="DeleteStudentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-light">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete Student</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                
                <input type="hidden" id="delete_stud_id">
                <h4>Are you sure ? want to delete this data ?</h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger delete_student_btn">Yes</button>
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">No</button>
            </div>
        </div>
    </div>
</div>
<!-- End -- DeleteStudentModal -->

    <div class="container py-5">
        <div class="row">
            <div class="col-md-12">

                <div id="success_message"></div>

                <div class="card">
                    <div class="card-header">
                        <h4>Student Lists 
                            <a href="#" data-bs-toggle="modal" data-bs-target="#AddStudentModal" class="btn btn-success float-end btn-sm">Add Student</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-light table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Age</th>
                                    <th>Phone</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            fetchstudent();

            function fetchstudent()
            {
                $.ajax({
                    type: "GET",
                    url: "/fetch-students",
                    dataType: "json",
                    success: function (response) {
                        $('tbody').html("");
                        $.each(response.students, function (key, item) { 
                             $('tbody').append('<tr>\
                                    <td>'+item.id+'</td>\
                                    <td>'+item.first_name+'</td>\
                                    <td>'+item.last_name+'</td>\
                                    <td>'+item.age+'</td>\
                                    <td>'+item.phone+'</td>\
                                    <td><button type="button" value="'+item.id+'" class="edit_student btn btn-primary btn-sm">Edit</button></td>\
                                    <td><button type="button" value="'+item.id+'" class="delete_student btn btn-danger btn-sm">Delete</button></td>\
                                </tr>');
                        });
                    }
                });
            }

            $(document).on('click', '.delete_student', function (e) {
                e.preventDefault();
                
                var stud_id = $(this).val();
                $('#delete_stud_id').val(stud_id);
                $('#DeleteStudentModal').modal('show');
            });

            $(document).on('click', '.delete_student_btn', function (e) {
                e.preventDefault();
                
                $(this).text("Deleting");
                var stud_id = $('#delete_stud_id').val();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "DELETE",
                    url: "/delete-student/"+stud_id,
                    success: function (response) {
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);
                        $('#DeleteStudentModal').modal('hide');
                        $('.delete_student_btn').text("Yes");
                        fetchstudent();
                    }
                });
            });

            $(document).on('click', '.edit_student', function (e) {
                e.preventDefault();

                var stud_id = $(this).val();
                $('#EditStudentModal').modal('show');
                $.ajax({
                    type: "GET",
                    url: "/edit-student/"+stud_id,
                    success: function (response) {
                        if(response.status == 404)
                        {
                            $('#success_message').html("");
                            $('#success_message').addClass('alert alert-danger');
                            $('#success_message').text(response.message);
                        }
                        else{
                            $('#edit_first_name').val(response.student.first_name);
                            $('#edit_last_name').val(response.student.last_name);
                            $('#edit_age').val(response.student.age);
                            $('#edit_phone').val(response.student.phone);
                            $('#edit_stud_id').val(stud_id);
                        }
                    }
                });
            });

            $(document).on('click', '.update_student', function (e) {
                e.preventDefault();

                $(this).text("Updating");
                var stud_id = $('#edit_stud_id').val();
                var data = {
                    'first_name' : $('#edit_first_name').val(),
                    'last_name' : $('#edit_last_name').val(),
                    'age' : $('#edit_age').val(),
                    'phone' : $('#edit_phone').val(),
                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "PUT",
                    url: "/update-student/"+stud_id,
                    data: data,
                    dataType: "json",
                    success: function (response) {
                        if(response.status == 400)
                        {
                            $('#updateform_errList').html("");
                            $('#updateform_errList').addClass('alert alert-danger');
                            $.each(response.errors, function (key, err_values) { 
                                 $('#updateform_errList').append('<li>'+err_values+'</li>');
                            });
                            $('.update_student').text("Update");
                        }else if(response.status == 404) 
                        {
                            $('#updateform_errList').html("");
                            $('#success_message').addClass('alert alert-success');
                            $('#success_message').text(response.message);
                            $('.update_student').text("Update");
                        } else {
                            $('#updateform_errList').html("");
                            $('#success_message').html("");
                            $('#success_message').addClass('alert alert-success');
                            $('#success_message').text(response.message);
                            $('#EditStudentModal').modal('hide');
                            $('.update_student').text("Update");
                            fetchstudent();
                        }
                    }
                });

            });

            $(document).on('click', '.add_student', function (e) {
                e.preventDefault();

                $(this).text("Adding");
                var data = {
                    'first_name': $('.first_name').val(),
                    'last_name': $('.last_name').val(),
                    'age': $('.age').val(),
                    'phone': $('.phone').val(),
                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "POST",
                    url: "/students",
                    data: data,
                    dataType: "json",
                    success: function (response) {
                        if(response.status == 400)
                        {
                            $('#saveform_errList').html("");
                            $('#saveform_errList').addClass('alert alert-danger');
                            $.each(response.errors, function (key, err_values) { 
                                 $('#saveform_errList').append('<li>'+err_values+'</li>');
                            });
                            $('.add_student').text("Save");
                        }
                        else{
                            $('#saveform_errList').html("");
                            $('#success_message').addClass('alert alert-success');
                            $('#success_message').text(response.message);
                            $('#AddStudentModal').modal('hide');
                            $('#AddStudentModal').find('input').val("");
                            $('.add_student').text("Save");
                            fetchstudent();
                        }
                    }
                });
            });
        });
    </script>
@endsection