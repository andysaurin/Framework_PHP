
					<div class="breadcrumbs breadcrumbs-fixed" id="breadcrumbs">

						<ul class="breadcrumb">
							<li>
								<i class="icon-home home-icon"></i>
								<a href="/">Home</a>
							</li>

							{if $module_title}
							<li>
								{if $class_title}
								<a href="/{$module}/">{$module_title}</a>
								{else}
								{$module_title}
								{/if}
							</li>
							{/if}

							{if $class_title}
							<li class="active">{$class_title}</li>
							{/if}

						</ul><!-- /.breadcrumb -->

					</div>
