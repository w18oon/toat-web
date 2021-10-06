{{-- @if(!\Auth::user()->isAllowCreateRequest()) --}}
@if(!true)
  	<ul class="list-unstyled alert alert-warning alert-dismissible" role="alert">
  		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    	<li>
          <h4>This user not allow to create any request because employee data is incomplete, please contact administrator to resolve this issue.
          </h4>
      </li>
		  @if(!\Auth::user()->employee->position_id)
    		  <li><span class="m-l-md"> - employee position was not set. </span></li>
      @endif
		  @if(!\Auth::user()->employee->email_address)
          <li><span class="m-l-md"> - employee email address was not set. </span></li>
    	@endif
  	</ul>
@endif