{if !$modal}<div class="row">&nbsp;</div>{/if}

			<div class="row">
				{if $modal}<div class="small-12 small-centered columns">{else}<div class="medium-6 medium-centered large-4 large-centered columns">{/if}

					<form method="post" action="{$host}/login/{if $smarty.get.ret}?ret={$smarty.get.ret}{/if}">
						<div class="text-center column log-in-form">
							<h4>Login</h4>
							<div class="drop">

								<div class="row collapse">
									<div class="small-2 columns">
										<span class="prefix"><i class="fi-torso" style="font-size: 1.2rem;"></i></span>
									</div>
									<div class="small-10 columns">
										<input name="username" type="text" placeholder="Email" value="{$smarty.request.username}" />
									</div>
								</div>
								<div class="row collapse">
									<div class="small-2 columns">
										<span class="prefix"><i class="fi-lock" style="font-size: 1.2rem;"></i></span>
									</div>
									<div class="small-10 columns">
										<input name="password" type="password" placeholder="Password" />
									</div>
								</div>

								<div class="small" style="text-align: left">
								<a href="{$host}/home/iforgot/{if $smarty.get.ret}?ret={$smarty.get.ret}{/if}">Forgot your password ?</a><br />
								Don't have an account ?
								<a href="{$host}/home/create/{if $smarty.get.ret}?ret={$smarty.get.ret}{/if}">Signup.</a>
								</div>
							</div>

							<div style="padding-top:10px;{if $modal}text-align:right;{/if}">
								<input type="submit" class="success button radius tiny" style="border-radius: 0.6rem;height:2rem;" value="Sign in"  />
								{if $modal}<a class="secondary tiny button radius close-modal" style="border-radius: 0.6rem;height:2rem;" aria-label="Cancel">Cancel</a>{/if}
							</div>

						</div>
					</form>

				</div>
			</div>