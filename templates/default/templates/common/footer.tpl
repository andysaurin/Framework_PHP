

		</section>

	</div> <!-- end page wrapper //-->

	<div class="site-footer">
		<div class="page_footer_leader">


		</div>
		<div class="page_footer">

		</div>


	    <script src="{$host}:{$static_port}/js/foundation.min.js"></script>
		<script src="{$host}:{$static_port}/js/app.js"></script>

{if $smarty.session.message && $smarty.session.message.delay > 0}{literal}
		<script>
			$(document).ready(function() {
				var $alert = $('.alert-box');
				$alert.delay({/literal}{$smarty.session.message.delay}{literal}).fadeOut(1000);
			});
		</script>
{/literal}{/if}

		<script>{literal}
			$(document).ready(function() {

				$('#main_body').click(function() {
					//fix for topbar expanded menu not closing on mobile
					'.top-bar ul.right li'
				});
				

				$('.close-modal').on('click', function() {
					$('.login').foundation('reveal', 'close');
				});

				function isValidTime(expires) {

					var date = Math.floor( $.now() /1000 );
					if ( date > expires ) {
						alert("The session for this action has expired.\nThe page will now reload to allow\nyou to complete your request.");
						return null;
					} else {
						return true;
					}
				}




		{/literal}</script>

	</div>


	</body>
</html>
