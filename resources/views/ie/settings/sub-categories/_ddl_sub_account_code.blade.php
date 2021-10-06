<label class="control-label show-xs-only">Sub-Account Code</label>
{!! Form::select('sub_account_code', $subAccountLists , $subAccountCode, ["class" => 'form-control select2', "autocomplete" => "off"]) !!}
<script type="text/javascript">
	$(document).ready(function(){
		$("select[name='sub_account_code']").select2();
	});
</script>