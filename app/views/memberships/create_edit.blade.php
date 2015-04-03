<div class="col-md-12 main">
    <h1 class="page-header">Membership - {{ $method }}

    <div class="pull-right">
        <a href="{{ url('membership') }}" class="btn btn-small btn-info">
          <span class="glyphicon glyphicon-chevron-left"></span> Back</a>
      </div>
    </h1>

<form method="post">
  @if($method != 'Profile')
  <div class="form-group">
    <label for="membership_username">Username</label>
    <input {{ ( $method=='Delete' || $method=='Edit' ) ?'disabled':''; }} name="username" type="text" class="form-control" id="membership_username" placeholder="Enter username" value={{ Input::old('username', isset($membership) ? $membership->username : null) }}>
  </div>

   @if($method!='Delete')
  <div class="form-group">
    <label for="membership_password">Password</label>
    <input {{ $method=='Delete'?'disabled':''; }} name="password" type="password" class="form-control" id="membership_password" placeholder="Enter password" value="">
  </div>
 
  <div class="form-group">
    <label for="membership_password_confirmation">Password Confirmation</label>
    <input {{ $method=='Delete'?'disabled':''; }} name="password_confirmation" type="password" class="form-control" id="membership_password_confirmation" placeholder="Enter Password Confirmation" value="">
  </div>
    @endif

  @endif

  <div class="form-group">
    <label for="membership_firstname">Firstname</label>
    <input {{ $method=='Delete'?'disabled':''; }} name="firstname" type="text" class="form-control" id="membership_firstname" placeholder="Enter firstname" value={{ Input::old('firstname', isset($membership) ? $membership->firstname : null) }}>
  </div>

  <div class="form-group">
    <label for="membership_lastname">Lastname</label>
    <input {{ $method=='Delete'?'disabled':''; }} name="lastname" type="text" class="form-control" id="membership_lastname" placeholder="Enter lastname" value={{ Input::old('lastname', isset($membership) ? $membership->lastname : null) }}>
  </div>

  <div class="form-group">
    <label for="membership_nickname">Nickname</label>
    <input {{ $method=='Delete'?'disabled':''; }} name="nickname" type="text" class="form-control" id="membership_nickname" placeholder="Enter nickname" value={{ Input::old('nickname', isset($membership) ? $membership->nickname : null) }}>
  </div>

  <div class="form-group" style="position: relative">
    <label for="membership_birthdate">Birthdate</label>
    <input {{ $method=='Delete'?'disabled':''; }} name="birthdate" type="text" class="form-control" id="membership_birthdate" >
  </div>

  @if($method != 'Profile')
  <div class="form-group">
    <label for="membership_detail">Role</label>
    <select {{ $method=='Delete'?'disabled':''; }} name="role" class="form-control">
    @foreach($roles as $role)
      <option value="{{ $role->id }}" {{{ (Input::old('role', isset($membership) && $membership->role_id === $role->id ? ' selected="selected"' : '')) }}}>{{ $role->name }}</option>
    @endforeach
    </select>
  </div>
  @endif

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
                $('#membership_birthdate').datetimepicker(
                  { format: "MM/DD/YYYY",
                    viewMode: 'years',
                    defaultDate: "{{ Input::old('birthdate', ( isset($membership) && $membership->birthdate != '0000-00-00' ) ? $membership->birthdate : null) }}" }
                );
            });
        </script>
@stop
