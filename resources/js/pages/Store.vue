<template>
   <div class="card">
  <h5 class="card-header">ລາຍການ ສະຕ໋ອກສິນຄ້າ</h5>
  <div class="card-body"> 
    <!-- {{ ShowForm  }} -->

        <div v-if="ShowForm">
            <div class=" d-flex justify-content-end mb-2">
                <div class=" d-flex">
                 
                    <button type="button" class="btn btn-success" :disabled="CheckForm" @click="SaveStore()" > 
                      <span v-if="loading_post">
                          <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                        ກຳລັງໂຫຼດ...
                    </span>
                    <span v-else>
                      <i class='bx bx-save' ></i> ບັນທຶກ 
                     </span>
                  </button>
                    <button type="button" class="btn btn-secondary ms-2" @click="CancelStore()"> <i class='bx bx-x'></i> ຍົກເລີກ </button>
                </div>
                </div>
                <div class="row">
                    <div class="col-md-4">ອັບໂຫຼດຮູບພາບ</div>
                    <div class="col-md-8">
                    
                            <label for="product-name" class="form-label fs-6">ຊື່ສິນຄ້າ: <span class="text-danger">*</span> </label>
                            <input type="text" class="form-control mb-2" id="product-name" placeholder="...." v-model="FormStore.name">
                            <label for="product-name" class="form-label fs-6">ຈຳນວນ:  <span class="text-danger">*</span></label>
                            <input type="text" class="form-control  mb-2" id="product-name" placeholder="...." v-model="FormStore.amount">

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="product-name" class="form-label fs-6  mb-2">ລາຄາຊື້: <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="product-name" placeholder="...." v-model="FormStore.price_buy">
                                </div>
                                <div class="col-md-6">
                                    <label for="product-name" class="form-label fs-6  mb-2">ລາຄາຂາຍ: <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="product-name" placeholder="...." v-model="FormStore.price_sell">
                                </div>
                            </div>
                    
                    
                    </div>
            </div>
    </div>

  
    <!-- {{ StoreData }} -->
    <div class="table-responsive text-nowrap" v-if="!ShowForm" >
      
        <div class=" d-flex justify-content-between mb-2">
            <div class=" d-flex align-items-center">
                <div class="me-2 d-flex align-items-center cursor-pointer" @click="ChangeSort()">
                    <i class='bx bx-sort-up fs-4' v-if="sort=='asc'"></i>
                    <i class='bx bx-sort-down fs-4' v-else></i>
                </div>
                <select class="form-select" v-model="list_page" @change="GetAllStore()">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="30">30</option>
                </select>
            </div>

            <div class=" d-flex">
                <input type="text" class="form-control me-2"  placeholder="ຄົ້ນຫາ..." v-model="search" @keyup.enter="GetAllStore()" >
                <button type="button" class="btn btn-info" @click="AddStore()"> <i class='bx bx-plus'></i> ເພີ່ມໃໝ່ </button>
            </div>
            
        </div>
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>ID</th>
            <th>ຮູບ</th>
            <th>ຊື່ສິນຄ້າ</th>
            <th>ລາຄາຊື້</th>
            <th>ຈັດການ</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="list in StoreData.data" :key="list.id">
            <td> {{ list.id  }} </td>
            <td> {{ list.image }}</td>
            <td> {{ list.name  }} </td>
            <td> {{ list.price_buy }}</td>
            <td>
              <div class="dropdown">
                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                <div class="dropdown-menu">
                  <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                  <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-trash me-1"></i> Delete</a>
                </div>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
      <pagination :pagination="StoreData" :offset="4" @paginate="GetAllStore($event)" />
    </div>
  </div>
</div>
</template>

<script>

import { useStore } from '../store/auth'
import axios from 'axios';

export default {
    name: 'Minipos9Store',

    setup(){
        const store = useStore()
        return {store}
    },

    data() {
        return {
            StoreData:[],
            ShowForm:false,
            FormType:true,
            EditID:'',
            FormStore:{
              name:'',
              image:'',
              amount:'',
              price_buy:'',
              price_sell:''
            },
            loading_post:false,
            search:'',
            list_page:10,
            sort:'asc',  // asc = ລຽງແຕ່ນ້ອຍ, desc = ລຽງແຕ່ໃຫຍ່ຫານ້ອຍ
        };
    },

    mounted() {
        
    },
    computed:{
        CheckForm(){
          if(this.FormStore.name == '' || this.FormStore.amount == '' || this.FormStore.price_buy == '' || this.FormStore.price_sell == '' )
          {
            return true
          } else {
            if(this.loading_post){
              return true
            } else {
              return false
            }
            
          }
        }
    },
    watch:{
      search(){
        if(this.search == ''){
          this.GetAllStore()
        }
      }
    },

    methods: {
      ChangeSort(){
          if(this.sort=='asc'){
            this.sort = 'desc'
          } else {
            this.sort = 'asc'
          }
          this.GetAllStore()
      },
        AddStore(){
            this.FormStore.name = ''
            this.FormStore.amount = ''
            this.FormStore.price_buy = ''
            this.FormStore.price_sell = ''

            this.ShowForm = true
        },
        CancelStore(){
            this.ShowForm = false
        },
        EditStore(id){
          this.EditID = id

        },
       async SaveStore(){

          this.loading_post = true
          
          if(this.CheckForm){
              if(this.FormType){
                /// ເພີ່ມຂໍ້ມູນໃໝ່
                await axios.post("store/add",this.FormStore,{ headers:{ Authorization: 'Bearer '+ this.store.get_token}}).then((response)=>{
                  this.loading_post = false
                        if(response.data.success){
                          this.ShowForm = false
                          this.GetAllStore()

                        } else {

                        }

                      }).catch((error)=>{
                        this.loading_post = false
                        console.log(error);
                        // ກວດເຊັກຫາກບໍ່ມີການ ເຂົ້າສູ່ລະບົບ ໃຫ້ໄປໜ້າເຂົ້າສູ່ລະບົບ
                        if(error){
                            if(error.response.status == 401){
                                useStore().remove_token()
                                useStore().remove_user()
                                localStorage.removeItem('web_token')
                                localStorage.removeItem('web_user')
                                this.$router.push("/login")
                            }
                        }

                      })


              } else {
                // ອັບເດດຂໍ້ມູນ

              }
          }

            

        },

        async GetAllStore(page){
            await axios.get(`store?page=${page}&search=${this.search}&lp=${this.list_page}&sort=${this.sort}`,{ headers:{ Authorization: 'Bearer '+ this.store.get_token}}).then((response)=>{

                        // console.log(response.data);

                        this.StoreData = response.data


                      }).catch((error)=>{
                        console.log(error);

                        // ກວດເຊັກຫາກບໍ່ມີການ ເຂົ້າສູ່ລະບົບ ໃຫ້ໄປໜ້າເຂົ້າສູ່ລະບົບ
                        if(error){
                            if(error.response.status == 401){
                                useStore().remove_token()
                                useStore().remove_user()
                                localStorage.removeItem('web_token')
                                localStorage.removeItem('web_user')
                                this.$router.push("/login")
                            }
                        }
                      })
        }
        
    },
    created(){
        // console.log(this.store.get_token);
      this.GetAllStore()
    }
};
</script>

<style lang="scss" scoped>

</style>