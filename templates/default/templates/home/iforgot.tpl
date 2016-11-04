{if $email && $who}

<div class="row">
	<div class="medium-6 medium-centered large-4 large-centered columns">

		<form method="post" action="{$host}/{$module}/{$class}/reset/?who={$who}" autocomplete="off">
			<div class="row column log-in-form">
				<h4 class="text-center">Please choose a new password.</h4>
				&nbsp;
				<label>Password
				<input name="password" id="password" type="password" placeholder="" value="" autocomplete="off" />
				</label>
				<label>Renter Password
				<input name="password2" id="password2" type="password" placeholder="" value="" autocomplete="off" />
				</label>

				<div class="row centered"><input type="submit" class="medium-6 button expanded tiny" value="Reset Password" /></div>

			</div>
		</form>

	</div>
</div>

{else}

<div class="row">
	<div class="medium-6 medium-centered large-4 large-centered columns">

		<form method="post" action="{$host}/{$module}/{$class}/">
			<div class="row column log-in-form">
				<h4 class="text-center">To reset your password,<br />please enter the account email address</h4>
				&nbsp;
				<label>Email
				<input name="email" type="text" placeholder="email@address.com" value="{$smarty.post.email}">
				</label>
				
				<div class="g-recaptcha" data-sitekey="{$reCaptcha_key}"></div>
				<br />
				<div class="row centered"><input type="submit" class="medium-6 button expanded tiny" value="Reset Password" /></div>

			</div>
		</form>

	</div>
</div>

{/if}