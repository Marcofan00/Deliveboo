<template>
    <footer :class="hamburgermenu? 'if_open' : ''">
        <div class="container container_xxl_">
                <!-- Contatti  -->
            <div class="info">
                <a href="/contatti">Contatti</a>
            </div>

                <!-- Chi siamo  -->
            <div class="info">
                <a href="/chisiamo">Chi siamo</a>
            </div>

                <!-- Social  -->
            <div id="social_logo">
                <div id="social">
                    <a href="https://www.instagram.com/boolean.careers/?hl=it"><i class="social_icon fab fa-instagram"></i></a>
                    <a href="https://it-it.facebook.com/boolean.careers/"><i class="social_icon fab fa-facebook"></i></a>
                    <a href="https://www.linkedin.com/school/boolean-careers/mycompany/"><i class="social_icon fab fa-linkedin"></i></a>
                </div>
            
                <div class="logo_footer">
                    <a href="/">
                        <img  src="/storage/img/LogoFooter.png" alt="logo footer">
                    </a>
                </div>
            </div>
        </div>
    </footer>
    
</template>

<script>
    export default {
        data(){
            return{
                hamburgermenu : false,
            }
        },
        created(){
            this.$root.$on('openHambMenu',(value)=>{
                this.hamburgermenu = value;
                });
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>