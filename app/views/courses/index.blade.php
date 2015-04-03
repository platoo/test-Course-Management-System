<div class="col-md-12 main">
    <h1 class="page-header">Course

      @if(  Auth::user()->role->name == 'Instructor' || Auth::user()->role->name == 'Admin' )
      <div class="pull-right">
        <a href="{{ url('course/create') }}" class="btn btn-small btn-info">
          <span class="glyphicon glyphicon-plus-sign"></span> Create</a>
      </div>
      @endif
    </h1>
	<div class="row">
 <form method="post">
 	

  
    <div class='col-md-5'>
        <div class="form-group">from
            <div class='input-group date' id='datetimepicker6'>
              
                <input name="from" type='text' class="form-control" />
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
            </div>
        </div>
    </div>

    <div class='col-md-5'>
        <div class="form-group">to
            <div class='input-group date' id='datetimepicker7'>

                <input  name="to" type='text' class="form-control" />
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
            </div>
        </div>
    </div>
<div class="col-md-6">
    <input name="search" type="text" class="form-control" placeholder="Search..." value="{{ Input::old('search', isset($search) ? $search : null) }}">
  </div>

  <div class="col-md-6">
    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
    <button type="submit" class="btn btn-default">Search</button>
     <a href="{{ url('course/clear') }}" class="btn btn-default">Clear</a>
  </div>
 </form>
</div>
<hr/>
@if( count($courses) )
<div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Title</th>
                  <th>Detail</th>
                  <th>Category</th>
                  <th>Time</th>
                  <th>Amount</th>
                  <th>Created at</th>
                  <th>Created by</th>
                  @if(  Auth::user()->role->name == 'Instructor' || Auth::user()->role->name == 'Admin' )
                  <th>Actions</th>
                  @endif
                </tr>
              </thead>
              <tbody>
               
              @foreach ($courses as $course)
              	 <tr>
              	<td>{{ $course->id }}</td>
              	<td>{{ $course->title }}</td>
              	<td>{{ $course->detail }}</td>
              	<td>{{ $course->category->name }}</td>
              	<td>{{ $course->time }}</td>
              	<td>{{ $course->amount }}</td>
              	<td>{{ $course->created_at }}</td>
              	<td>{{ $course->createdBy->getName() }}</td>
                @if(  Auth::user()->role->name == 'Instructor' || Auth::user()->role->name == 'Admin' )
                <td>
                  <a href="{{ url('course/edit/'.$course->id) }}" class="btn btn-default">edit</a>
                  <a href="{{ url('course/delete/'.$course->id) }}" class="btn btn-danger">delete</a>
                </td>
                @endif
              	</tr>
              @endforeach
              	
                
              </tbody>
                 
                  
                
            </table>
            <div class="row text-center">
            	<?php echo $courses->links(); ?>
        	</div>
          </div>
@else
<div>//no data...</div>
@endif

</div>
@section('script')
<script type="text/javascript">
    $(function () {
        $('#datetimepicker6').datetimepicker({defaultDate:'{{ $from }}'});
        $('#datetimepicker7').datetimepicker({defaultDate:'{{ $to }}'});
        $("#datetimepicker6").on("dp.change", function (e) {
            $('#datetimepicker7').data("DateTimePicker").minDate(e.date);
        });
        $("#datetimepicker7").on("dp.change", function (e) {
            $('#datetimepicker6').data("DateTimePicker").maxDate(e.date);
        });
    });
</script>
@stop