@extends('layouts.app')
@section('content')

<div class="content_main">
  <div class="all_courses_main">
    
    <div class="course_table mt-0">
      <div class="course card-header card-header-warning card-header-icon">
        
        <h3>School Details</h3>
          <div class="table_filters">
            
            
          </div>
          <table class="table table-hover">
            <thead>
              <tr>
                <th scope="col">Name</th>
                <th scope="col">Image</th>
                <th scope="col">Address</th>
                <th scope="col">District</th>
                <th scope="col">Phone</th>
                <th scope="col">S_I_n</th>
                <th scope="col">Actions</th>
              </tr>
            </thead>
            <tbody id="mybody">
              <tr>
                <td class="first_row">
                  <div class="course_td">
                    <p>{{$schooldetail->school_name}}</p>
                  </div>
                </td>
                <td class="first_row"><img src="{{asset('/assets/img/upload/'.$schooldetail->school_image)}}" width ="100" ></td>
                <td class="first_row">{{$schooldetail->school_address}}</td>
                <td class="first_row">{{$schooldetail->district}}</td>
                <td class="first_row">{{$schooldetail->phone}}</td>
                <td class="first_row">{{$schooldetail->school_identification_number}}</td>
                
                <td class="align_ellipse first_row">
                  <a class="btn btn-sm btn-success" href="{{ url()->previous() }}">Back</a>
                </td>
              </tr>
            </tbody>
          </table>   
          
      </div>
    </div>
  </div>
</div>
<script>
    $(document).ready(function(){
      $("#search").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        // alert(value);
        $("#mybody tr").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });
    });
  </script>
@endsection