<template>
    <div class="row g-4 mb-4">
  <div class="col-sm-6 col-xl-3">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-start justify-content-between">
          <div class="content-left">
            <span>ລາຍຮັບ</span>
          </div>
          <span class="badge bg-label-primary rounded p-2">
        
            <i class='bx bx-line-chart bx-sm'></i>
          </span>
        </div>
        <div class="d-flex align-items-end mt-2">
              {{ formatPrice(data_income)  }} ກີບ 
              <small class="text-success">(+29%)</small>
            </div>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-xl-3">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-start justify-content-between">
          <div class="content-left">
            <span>ລາຍຈ່າຍ</span>
          </div>
          <span class="badge bg-label-danger rounded p-2">
   
            <i class='bx bx-line-chart-down bx-sm'></i>
          </span>
        </div>
        <div class="d-flex align-items-end mt-2">
             {{ formatPrice(data_expense) }} ກີບ 
              <small class="text-success">(+18%)</small>
            </div>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-xl-3">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-start justify-content-between">
          <div class="content-left">
            <span>ກຳໄລ</span>
          </div>
          <span class="badge bg-label-success rounded p-2">
          
            <i class='bx bx-chart  bx-sm'></i>
          </span>
        </div>
        <div class="d-flex align-items-end mt-2">
             {{ formatPrice(data_income-data_expense) }} ກີບ 
              <small class="text-danger">(-14%)</small>
            </div>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-xl-3">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-start justify-content-between">
          <div class="content-left">
            <span>ຍອດສະຕ໋ອກ</span>
          </div>
          <span class="badge bg-label-warning rounded p-2">
            <i class='bx bxs-store-alt  bx-sm'></i>
          </span>
        </div>
        <div class="d-flex align-items-end mt-2">
            {{ formatPrice(data_store) }} 
              <small class="text-success">(+42%)</small>
            </div>
      </div>
    </div>
  </div>
</div>
</template>

<script>
import { useStore } from '../store/auth'
import axios from 'axios';

export default {
    name: 'Minipos9GrapBoard',
    setup(){
        const store = useStore()
        return {store}
    },
    data() {
        return {
            data_income:'',
            data_expense:'',
            data_store:'',
        };
    },

    mounted() {
        
    },

    methods: {
        formatPrice(value) {
        let val = (value / 1).toFixed(0).replace(",", ".");
        return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
      },
       async GetData(){
            await axios.get('report/grapboard',{ headers:{ Authorization: 'Bearer '+ this.store.get_token}}).then((response)=>{
                
                this.data_income = response.data.income
                this.data_expense = response.data.expense
                this.data_store = response.data.store

              }).catch((error)=>{
                console.log(error);
                   if(error){
                        if(error.response.status == 401){
                            useStore().remove_token()
                            this.$router.push('/login')
                        }
                    }
              })
        }
    },
    created(){
        this.GetData()
    }
};
</script>

<style lang="scss" scoped>

</style>