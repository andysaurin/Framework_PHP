				<div class="row">&nbsp;</div>
				<div class="row">
					<div class="medium-6 medium-centered large-5 large-centered columns">
				
						<form method="post" action="{$host}/create{if $smarty.get.ret}?ret={$smarty.get.ret}{/if}">
							<div class="text-center row column log-in-form">
								<h4 class="text-center">Create an account</h4>
								<div class="drop">
									<label class="text-left{if $input_errors.name} input_error{/if}">Your Name
										<input name="name" type="text" placeholder="Your Name" value="{$smarty.post.name}" />
									</label>
									<label class="text-left{if $input_errors.email} input_error{/if}">Your Email <small>(this is your login)</small>
										<input name="email" type="text" placeholder="email@address.com" value="{$smarty.post.email}" />
									</label>
									<label class="text-left{if $input_errors.email} input_error{/if}">Retype your Email address
										<input name="email_repeat" type="text" placeholder="repeat email@address.com" value="" />
									</label>
									<label class="text-left{if $input_errors.password} input_error{/if}">Password
										<input name="password" type="password" placeholder="Password" autocomplete="off" />
									</label>
					
									<div class="g-recaptcha{if $input_errors.g-recaptcha-response} class="input_error"{/if}" data-sitekey="{$reCaptcha_key}"></div>
								</div>
								<div style="padding-top:10px;"><input type="submit" class="medium-6 button expanded tiny" value="Create an account" /></div>
				
							</div>
						</form>
				
					</div>
				</div>