<div class="row">
	<div class="medium-10 medium-centered large-8 large-centered columns">
			<h2>Account profile</h2>
	</div>
</div>
<div class="row">
	<div class="medium-10 medium-centered large-8 large-centered columns">

		<div class="section">


			<label class="blue bold">Account login details</label>
			<div>&nbsp;</div>
			<div class="drop">
				<form method="post" id="account_form" action="/account/update/{if $smarty.get.ret}?{$smarty.get.ret}{/if}">
					<input type="hidden" name="xsrf_key" value="{$session->xsrf_key}" />
					<div class="row column medium-12 medium-centered large-10 large-centered columns">
						<label class="smaller{if $input_errors.name} input_error{/if}"><strong>First-Last Name</strong>
							<input name="name" type="text" value="{$session->name}" />
						</label>
					</div>
					<div class="row column medium-12 medium-centered large-10 large-centered columns">
						<label class="smaller{if $input_errors.email} input_error{/if}"><strong>Email</strong> (this is also your login username)
							<input name="email" type="text" value="{$session->username}" />
						</label>
					</div>
					<div class="row column medium-12 medium-centered large-10 large-centered columns">
						<label class="smaller{if $input_errors.new_password} input_error{/if}"><strong>Password</strong>&nbsp;&nbsp;&nbsp;<a id="change-pass" onClick="if( $('#change-pass-div:hidden').length ) { $('#change-pass-div').slideDown(); } else { $('#change-pass-div').slideUp(); }">change my password</a>
							<div id="change-pass-div"{if !$input_errors.new_password} style="display:none"{/if}>
								<label class="smaller">Current Password</label>
								<input name="current_password" type="password" value="" autocomplete="off" />
								<label class="smaller">New Password</label>
								<input name="new_password_1" placeholder="enter your new password" type="password" value="" autocomplete="off" />
								<input name="new_password_2" placeholder="re-enter new password" type="password" value="" autocomplete="off" />
							</div>
						</label>
					</div>
					<div>&nbsp;</div>
					<div class="row centered" style="padding:10px 0 0 50px">
						<input type="submit" name="account_form" class="button radius expanded small" value="Update my login details" />
					</div>

				</form>
			</div>

		</div>
	</div>
</div>
<div class="row">&nbsp;</div>


{literal}
<script type="text/javascript">
	$(document).ready(function() {
		$('#profile_form input[type=radio]').change(function() {
		    if (this.value == 1) {
				$('#company_info').show(200);
				$('#personal_info').hide(200);

			} else {
				$('#personal_info').show(200);
				$('#company_info').hide(200);
			}
		});
		$('#company_country').change(function() {
		    $('#company_city').val(null);
		});
		$('#personal_country').change(function() {
		    $('#personal_city').val(null);
		});
	});
{/literal}

</script>
<script src="{$host}/bower_components/country-region-selector/dist/jquery.crs.min.js"></script>
