<template>
    <div class="p-5 bg-light" id="landingPage">
        <div class="layer">
            <div class="container">
                <h1 class="display-3 text-white text-center" id="heading">
                    Work In Progress
                </h1>
                <p class="text-white text-center">
                    We are building this site for giving you the best possible
                    user experience. Please have patience 🫶
                </p>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "WorkInProgress",
};
</script>

<style lang="scss" scoped>
#landingPage {
    background-image: url("https://images.unsplash.com/photo-1432821596592-e2c18b78144f?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxzZWFyY2h8MXx8YmxvZyUyMGJhY2tncm91bmR8ZW58MHx8MHx8&w=1000&q=80");
    height: 100vh;
    background-size: cover;
    background-repeat: no-repeat;

    .layer {
        background: rgba(51, 51, 51, 0.638);
        border-radius: 30px;
        padding: 10px;
    }

    #heading {
        text-shadow: 3px 6px rgba(0, 0, 0, 0.25) !important;
    }
}
</style>
