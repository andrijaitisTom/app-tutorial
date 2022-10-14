<script>
export default {

	data() {
		return {
			greeting: 'Hello World!',
		}
	},
	methods: {
		onClickButton(event) {
			this.$emit('clicked', 'someValue')
		},
	},

}
</script>

<template>
	<div class="startScreenBackground">
		<div class="startScreenContainer">
			<p class="startScreenTitle">
				Select company to view documents:
			</p>
			<div class="startScreenLogosContainer">
				<div class="startScreenLogoCover">
					<img src="../src/assets/images/bankera.svg">
                    <p class="startScreenCompanyTitle">Bankera</p>
				</div>
				<div class="startScreenLogoCover">
					<img src="../src/assets/images/spectrocoin.svg">
                    <p class="startScreenCompanyTitle">SpectroCoin</p>
				</div>
				<div class="startScreenLogoCover">
					<img src="../src/assets/images/pervesk.svg">
                    <p class="startScreenCompanyTitle">Pervesk</p>
				</div>
			</div>
		</div>
	</div>
</template>

<style>

.startScreenContainer{
    height: 100vh;
    display: flex;
    flex-direction: column;
    justify-content: center;
}
.startScreenLogosContainer{
    display: flex;
    justify-content: center;
    align-items: center;
}
.startScreenBackground{
    position:fixed;
    padding:0;
    margin:0;

    top:0;
    left:0;
    z-index: 1300;
    width: 100%;
    height: 100%;
    background:rgba(199, 0, 0, 0.5);
}
.startScreenLogoCover{
    background-color: white;
    padding: 50px;
    border-radius: 16px;
    margin: 0 32px ;
}
.startScreenTitle{
    color: white;
    font-size: 32px;
}
.startScreenCompanyTitle{
    margin-top: 10px;
    font-size: 20px;
    color: black;
}
#dmsapplogo{
    background-color: yellowgreen;
}

</style>
