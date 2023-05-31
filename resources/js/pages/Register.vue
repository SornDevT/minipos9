<template>
    <div class="authentication-wrapper authentication-basic container-p-y">
    <div class="authentication-inner d-flex justify-content-center">
      <!-- Register -->
      <div class="card col-md-4">
        <div class="card-body">
          <h2 class="text-center">ສະບາຍດີ, ຍິນດີຕ້ອນຮັບ</h2> 
          <!-- ໂຕແປ name: {{ name }} -->
            <div class="mb-3">
              <label for="name" class="form-label">ຊື່:</label>
              <input type="text" class="form-control" id="name" v-model="name"  placeholder="ປ້ອນຊື່..." >
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">ອີເມວລ໌:</label>
              <input type="text" class="form-control" id="email" v-model="email"  placeholder="ປ້ອນອີເມວລ໌..." >
            </div>

            <div class="mb-3 form-password-toggle">
              <div class="d-flex justify-content-between">
                <label class="form-label" for="password">ລະຫັດຜ່ານ:</label>
                
              </div>
              <div class="input-group input-group-merge">
                <input type="password" id="password" class="form-control" v-model="password" name="password" placeholder="············" aria-describedby="password">
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
              </div>
            </div>
            <div class="mb-3 form-password-toggle">
              <div class="d-flex justify-content-between">
                <label class="form-label" for="password">ຍືນຍັນລະຫັດຜ່ານ:</label>
                
              </div>
              <div class="input-group input-group-merge"> 
                <input type="password" id="password" class="form-control" v-model="password2" name="password" placeholder="············" aria-describedby="password">
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
              </div>
            </div>
                    <div class="alert alert-warning" role="alert" v-if="show_error">
                        {{ text_error }}
                    </div>
            <div class="mb-3">
              <button class="btn btn-primary d-grid w-100" type="button" @click="register()">ລົງທະບຽນ</button>
            </div>
  

          <p class="text-center">
            <span>ມີບັນຊີແລ້ວ</span>
            <router-link to="/login">
              <span>ເຂົ້າສູ່ລະບົບ</span>
            </router-link>
          </p>
        </div>
      </div>
      <!-- /Register -->
    </div>
  </div>
</template>

<script>

import axios from 'axios';

export default {
    name: 'Minipos9Register',

    data() {
        return {
            name:'',
            email:'',
            password:'',
            password2:'',
            show_error:false,
            text_error:''
        };
    },

    mounted() {
        
    },

    methods: {
        register(){

            if(this.name == '' || this.email == '' || this.password == '' || this.password2 ==''){ // ກວດການປ້ອນຂໍ້ມູນ
                this.show_error = true
                this.text_error = 'ກະລຸນາປ້ອນຂໍ້ມູນໃຫ້ຄົບຖ້ວນ!'
            } else {
                
              if(this.password.length>5){ //ກວດລະຫັດຜ່ານ ຕ້ອງຫຼາວກ່ວາ 5 ຕົວອັກສອນ

                  if(this.password == this.password2){  // ກວດລະຫັດຜ່ານ ຕ້ອງກົງກັນ
                      this.show_error = false
                      this.text_error = ''

                      axios.post("register",{
                        name: this.name,
                        email: this.email,
                        password: this.password
                      }).then((response)=>{
                        console.log(response.data)

                        if(response.data.success){

                          this.show_error = false
                          this.text_error = ''
                          // ເຄຼຍຂໍ້ມູນໃນຟອມ
                          this.name = ''
                          this.email = ''
                          this.password = ''
                          this.password2 = ''

                          this.$router.push("/login")


                        } else {

                          this.show_error = true
                          this.text_error = response.data.message
                        }

                      }).catch((error)=>{
                        console.log(error);
                      })


                  } else {
                      this.show_error = true
                      this.text_error = 'ລະຫັດຜ່ານບໍ່ກົງກັນ!'
                  }

              } else{
                this.show_error = true
                this.text_error = 'ລະຫັດຜ່ານຕ້ອງຫຼາຍກ່ວາ 5 ຕົວອັກສອນ!'
              }

                
            }

        }
    },
};
</script>

<style lang="scss" scoped>

</style>