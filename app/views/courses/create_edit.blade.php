<div class="col-md-12 main">
    <h1 class="page-header">Course - {{ $method }}

    @if($method != 'Profile')
    <div class="pull-right">
        <a href="{{ url('membership') }}" class="btn btn-small btn-info">
          <span class="glyphicon glyphicon-chevron-left"></span> Back</a>
      </div>
    </h1>
    @endif

<form method="post">
  <div class="form-group">
    <label for="course_title">Title<sup>*</sup></label>
    <input {{ $method=='Delete'?'disabled':''; }} name="title" type="text" class="form-control" id="course_title" placeholder="Enter title" value={{ Input::old('title', isset($course) ? $course->title : null) }}>
  </div>

  <div class="form-group">
    <label for="course_detail">detail<sup>*</sup></label>
    <textarea {{ $method=='Delete'?'disabled':''; }} name="detail" class="form-control" id="course_detail" rows="3">{{ Input::old('detail', isset($course) ? $course->detail : null) }}</textarea>
  </div>

  <div class="form-group">
    <label for="course_detail">Category<sup>*</sup></label>
    <select {{ $method=='Delete'?'disabled':''; }} name="category" class="form-control">
    @foreach($categorys as $category)
      <option value="{{ $category->id }}" {{{ (Input::old('category', isset($course) && $course->category_id) === $category->id ? ' selected="selected"' : '') }}}>{{ $category->name }}</option>
    @endforeach
    </select>
  </div>

  <div class="form-group" style="position: relative">
    <label for="course_time">Time</label>
    <input {{ $method=='Delete'?'disabled':''; }} name="time" type="text" class="form-control" id="course_time" >
  </div>

  <div class="form-group">
    <label for="course_amount">Amount</label>
    <input {{ $method=='Delete'?'disabled':''; }} name="amount" type="text" class="form-control" id="course_amount" placeholder="Enter amount" value={{ Input::old('amount', isset($course) ? $course->amount : null) }}>
  </div>

  <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
  @if($method != 'Delete')
  <button type="submit" class="btn btn-default">Submit</button>
  <button type="reset" class="btn btn-default">Reset</button>
  @else
  <button type="submit" class="btn btn-default">Yes</button>
  <a href="{{ url('course') }}" class="btn btn-default">No</a>
  @endif

</form>

</div>
@section('script')
    <script type="text/javascript">
            $(function () {
                $('#course_time').datetimepicker(
                  { defaultDate: "{{ Input::old('time', ( isset($course) && $course->time != '0000-00-00 00:00:00' ) ? $course->time : null) }}" }
                );
            });
        </script>
@stop
