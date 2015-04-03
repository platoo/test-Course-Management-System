<div class="col-md-12 main">
    <h1 class="page-header">Membership

      @if(  Auth::user()->role->name == 'Instructor' || Auth::user()->role->name == 'Admin' )
      <div class="pull-right">
        <a href="{{ url('membership/create') }}" class="btn btn-small btn-info">
          <span class="glyphicon glyphicon-plus-sign"></span> Create</a>
      </div>
      @endif
    </h1>

@if( count($memberships) )
<div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Role</th>
                  <th>Username</th>
                  <th>Firstname</th>
                  <th>Lastname</th>
                  <th>Nickname</th>
                  <th>Birthdate</th>
                  <th>Created at</th>
                  
                  @if(  Auth::user()->role->name == 'Instructor' || Auth::user()->role->name == 'Admin' )
                  <th>Actions</th>
                  @endif
                </tr>
              </thead>
              <tbody>
               
              @foreach ($memberships as $membership)
              	 <tr>
              	<td>{{ $membership->id }}</td>
                <td>{{ $membership->role->name }}</td>
              	<td>{{ $membership->username }}</td>
              	<td>{{ $membership->firstname }}</td>
              	<td>{{ $membership->lastname }}</td>
              	<td>{{ $membership->nickname }}</td>
              	<td>{{ $membership->birthdate }}</td>
              	<td>{{ $membership->created_at }}</td>
              	{{-- <td>{{ $membership->createdBy->getName() }}</td> --}}
                @if(  Auth::user()->role->name == 'Instructor' || Auth::user()->role->name == 'Admin' )
                <td>
                  <a href="{{ url('membership/edit/'.$membership->id) }}" class="btn btn-default">edit</a>
                  @if( $membership->id != 1 )
                    <a href="{{ url('membership/delete/'.$membership->id) }}" class="btn btn-danger">delete</a>
                  @endif
                </td>
                @endif
              	</tr>
              @endforeach
              	
                
              </tbody>
                 
                  
                
            </table>
            <div class="row text-center">
            	<?php echo $memberships->links(); ?>
        	</div>
          </div>
@else
<div>//no data...</div>
@endif

</div>
