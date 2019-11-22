<template>
	<div class="404">
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<div class="container" style="text-align:center; height:60vh;">
			<h1><b>Error 404</b></h1>
			<h3>Page not found!</h3>
			<router-link :to="{ name: 'dashboard' }">Kembali ke halaman awal</router-link>
		</div>
	</div>
</template>
<script>
export default {
  name: 'NotFound'
}
</script>
