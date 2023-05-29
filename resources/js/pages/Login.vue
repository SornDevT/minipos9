<template>
    <div class="authentication-wrapper authentication-basic container-p-y">
    <div class="authentication-inner d-flex justify-content-center">
      <!-- Register -->
      <div class="card col-md-4">
        <div class="card-body">
          <h2 class="text-center">ສະບາຍດີ, ຍິນດີຕ້ອນຮັບ</h2>
            <div class="mb-3">
              <label for="email" class="form-label">ອີເມວລ໌:</label>
              <input type="text" class="form-control" id="email"  placeholder="ປ້ອນອີເມວລ໌..." >
            </div>
            <div class="mb-3 form-password-toggle">
              <div class="d-flex justify-content-between">
                <label class="form-label" for="password">ລະຫັດຜ່ານ:</label>
                
              </div>
              <div class="input-group input-group-merge">
                <input type="password" id="password" class="form-control" name="password" placeholder="············" aria-describedby="password">
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
              </div>
            </div>
            
            <div class="mb-3">
              <button class="btn btn-primary d-grid w-100" type="submit">ເຂົ້າສູ່ລະບົບ</button>
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
        };
    },

    mounted() {
        
    },

    methods: {
        
    },
};
</script>

<style lang="scss" scoped>

</style>