@extends('layouts.app')
@section('content')

<!-- create Modal -->
<div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Student</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        <div class="modal-body">
            <ul id="err_list"></ul>
          <form action="">
              <div class="form-group mb-3">
                  <label for="name">Name:</label>
                  <input type="text" class="name form-control">
              </div>
              <div class="form-group mb-3">
                <label for="name">Email:</label>
                <input type="email" class="email form-control">
            </div>
            <div class="form-group mb-3">
                <label for="name">Phone:</label>
                <input type="text" class="phone form-control">
            </div>
            <div class="form-group mb-3">
                <label for="name">Course:</label>
                <input type="text" class="course form-control">
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary add_student">Save</button>
        </div>
      </div>
    </div>
  </div>
  {{-- end of create modal --}}

    <!-- edit Modal -->
<div class="modal fade" id="editStudentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Update Student</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        <div class="modal-body">
            <ul id="update_error"></ul>
          <form action="">
              <input type="hidden" id="student_id">
              <div class="form-group mb-3">
                  <label for="name">Name:</label>
                  <input type="text" id="edit_name" class="name form-control">
              </div>
              <div class="form-group mb-3">
                <label for="name">Email:</label>
                <input type="email" id="edit_email" class="email form-control">
            </div>
            <div class="form-group mb-3">
                <label for="name">Phone:</label>
                <input type="text" id="edit_phone" class="phone form-control">
            </div>
            <div class="form-group mb-3">
                <label for="name">Course:</label>
                <input type="text" id="edit_course" class="course form-control">
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary update_student">Update</button>
        </div>
      </div>
    </div>
  </div>
  {{-- end of edit modal --}}

  <!-- delete Modal -->
<div class="modal fade" id="deleteStudentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Delete Student</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        <div class="modal-body">
              <input type="hidden" id="delete_student_id">
              <h3>Are you sure you want to delete?</h3>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
          <button type="button" class="btn btn-danger delete_student_btn">Yes</button>
        </div>
      </div>
    </div>
  </div>
  {{-- end of edit modal --}}

    <div class="container py-5">
        <div class="row">
            <div class="col-md-12">
                <p id="success"></p>
            <div class="card">
                <div class="card-header">
                    <h4>Student
                    <a href="#" class="btn btn-primary float-right" data-toggle="modal" data-target="#addStudentModal">Add student</a>
                </h4>
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Course</th>
                            <th scope="col">Edit</th>
                            <th scope="col">Delete</th>
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
    $(document).ready(function(){

        // fetch students
        function fetchStudents()
        {
            $.ajax({
            type: 'GET',
            url: 'fetch-students',
            dataType: 'json',
            success: function (response){
                // console.log(response.students);
                $('tbody').html("");
                $.each(response.students, function(key, item){
                        $('tbody').append(`<tr>
                            <th scope="row">${item.id}</th>
                            <th scope="row">${item.name}</th>
                            <th scope="row">${item.email}</th>
                            <th scope="row">${item.phone}</th>
                            <th scope="row">${item.course}</th>
                            <td><button type="button" value="${item.id}" class="edit_student btn btn-primary btn-sm">Edit</button></td>
                            <td><button type="button" value="${item.id}" class="delete_student btn btn-danger btn-sm">Delete</button></td>
                          </tr>`)
                    }); 
            }
            });
        }
        fetchStudents();


        // edit student
        //update student details
        $(document).on('click', '.update_student', function(e){
            e.preventDefault();

            $(this).text('updating..')
            var student_id = $('#student_id').val();
            var data = {
            'name'   : $('#edit_name').val(),
            'email'  : $('#edit_email').val(),
            'phone'  : $('#edit_phone').val(),
            'course' : $('#edit_course').val(),
            }
            // console.log(data);
            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
           });
            $.ajax({
                type     : 'PUT',
                url      : 'update-student/'+student_id,
                data     : data,  //data from the var data above
                dataType : 'json',
                success  : function(response){
                    if(response.status == 400){
                        $('#update_error').html("");
                        $('#update_error').addClass("alert alert-danger");
                        $.each(response.errors, function(key, err){
                        $('#update_error').append(`<li>${err}</li>`)

                       $('.update_student').text('update')

                    });
                    }else if(response.status == 404){
                        $('#success').html("");
                        $('#success').addClass("alert alert-danger");
                        $('#success').text(response.message);
                        $('#editStudentModal').modal('hide');

                        $('.update_student').text('update')

                    }else{
                        $('#err_list').html("");
                        $('#success').addClass("alert alert-success");
                        $('#success').text(response.message);
                        $('#editStudentModal').modal('hide');
                        $('#editStudentModal').find('input').val("");

                        $('.update_student').text('update')

                        fetchStudents();
                    }
                }
            });
        });
        //fetch student details
        $(document).on('click', '.edit_student', function(e){
            e.preventDefault();
            var stud_id = $(this).val();
            $('#editStudentModal').modal('show')
            $.ajax({
            type: 'GET',
            url: 'edit-student/'+stud_id,
            dataType: 'json',
            success: function (response){
                if(response.status == 404)
                {
                  $('#update_error').html("");
                  $('#update_error').addClass("alert alert-danger");
                  $('#update_error').text(response.message);
                }
                else
                {
                    $('#edit_name').val(response.student.name);
                    $('#edit_email').val(response.student.email);
                    $('#edit_phone').val(response.student.phone);
                    $('#edit_course').val(response.student.course);
                    $('#student_id').val(stud_id);
                }
            }
         });
        });
        // delete student details
        $(document).on('click', '.delete_student', function(e){
            e.preventDefault();
            var student_id = $(this).val();
            $('#delete_student_id').val(student_id)
            $('#deleteStudentModal').modal('show');
        });
        $(document).on('click', '.delete_student_btn', function(e){
            e.preventDefault();
            $(this).text('Deleting....')
            var student_id = $('#delete_student_id').val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type     : 'DELETE',
                url      : 'delete-student/'+student_id,
                dataType : 'json',
                success  : function(response){
                    $('#success').addClass("alert alert-success");
                    $('#success').text(response.message)
                    $('#deleteStudentModal').modal('hide');
                    $('.delete_student_btn').text('Yes')
                    fetchStudents();
                }
        })
    });
        // create student
      $(document).on('click', '.add_student', function(e){
        e.preventDefault();
        var data = {
            'name': $('.name').val(),
            'email': $('.email').val(),
            'phone': $('.phone').val(),
            'course': $('.course').val(),
        }
        // console.log(data);
        // from laravel documentation
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        //end

        $.ajax({
            type: 'POST',
            url: 'students',
            data: data,  //data from the var data
            dataType: 'json',
            success: function (response){
                // console.log(response);
                if(response.status == 400)
                {
                    $('#err_list').html("");
                    $('#err_list').addClass("alert alert-danger");
                    $.each(response.errors, function(key, err){
                        $('#err_list').append(`<li>${err}</li>`)
                    });
                }
                else
                {
                    $('#err_list').html("");
                    $('#err_list').removeClass("alert alert-danger");
                    $('#success').addClass("alert alert-success");
                    $('#success').text(response.message);
                    $('#addStudentModal').modal('hide');
                    $('#addStudentModal').find('input').val("");

                   fetchStudents();
                }
            }
        });
        });
    });
</script>
@endsection