<template>
	<div id="main">
		<header id="header"></header>
		<div id="content">
			<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
				<navigation></navigation>
			</nav>
			<main class="py-3">
				<div class="container">
					<div class="row">
						<div class="col-md-12 col-md-offset-2">
							<div class="panel panel-default">
								<div class="panel-body">
									<router-view></router-view>
								</div>
							</div>
						</div>
					</div>
				</div>
			</main>
		</div>
	</div>
</template>
<script>
	export default {}
</script>
