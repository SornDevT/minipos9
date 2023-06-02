<template>
    <div class="authentication-wrapper authentication-basic container-p-y">
    <div class="authentication-inner d-flex justify-content-center">
      <!-- Register -->
      <div class="card col-md-4">
        <div class="card-body">
          <h2 class="text-center">ສະບາຍດີ, ຍິນດີຕ້ອນຮັບ</h2> 
          <!-- {{ check_login }} -->
            <div class="mb-3">
              <label for="email" class="form-label">ອີເມວລ໌:</label>
              <input type="text" class="form-control" id="email" v-model="email"  placeholder="ປ້ອນອີເມວລ໌..." >
            </div>
            <div class="mb-3 form-password-toggle">
              <div class="d-flex justify-content-between">
                <label class="form-label" for="password">ລະຫັດຜ່ານ:</label>
                
              </div>
              <div class="input-group input-group-merge">
                <input type="password" id="password" class="form-control" v-model="password" name="password" @keyup.enter="login()" placeholder="············" aria-describedby="password">
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
              </div>
            </div>
            <div class="alert alert-warning" role="alert" v-if="show_error">
                        {{ text_error }}
                    </div>
            <div class="mb-3">
              <button class="btn btn-primary d-grid w-100" type="button" :disabled="check_login" @click="login()" >ເຂົ້າສູ່ລະບົບ</button>
            </div>
  

          <p class="text-center">
            <span>ບໍ່ມີບັນຊີ?</span>
            <router-link to="/register">
              <span>ສ້າງບັນຊີໃໝ່</span>
            </router-link>
          </p>
        </div>
      </div>
      <!-- /Register -->
    </div>
  </div>
</template>

<script>
import { useStore } from '../store/auth'
import axios from 'axios';

export default {
    name: 'Minipos9Login',

    setup(){
        const store = useStore()
        return {store}
    },


    data() {
        return {
            email:'',
            password:'',
            show_error:false,
            text_error:''
        };
    },
    computed:{
        check_login(){
          if(this.email == '' || this.password == ''){
            return true
          } else {
            return false
          }
        }
    },
    mounted() {
        
    },

    methods: {
       async login(){

          if(!this.check_login){
              // console.log('login Ok!')
              await axios.post("login",{
                email:this.email,
                password: this.password
              }).then((response)=>{

                        if(response.data.success){

                          // console.log(response.data.authorisation.token);

                          localStorage.setItem('web_token',response.data.authorisation.token)
                          localStorage.setItem('web_user', JSON.stringify(response.data.user))
                     

                          this.$router.push('/store')

                          this.show_error = false
                          this.text_error = ''
                          // ເຄຼຍຂໍ້ມູນໃນຟອມ

                          this.email = ''
                          this.password = ''

                        } else {

                          this.show_error = true
                          this.text_error = response.data.message
                        }

                      }).catch((error)=>{
                        console.log(error);
                      })
          }
          
        }
    },
};
</script>

<style lang="scss" scoped>

</style>