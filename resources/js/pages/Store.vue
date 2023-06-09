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
                    <div class="col-md-4 text-center" style="position: relative;">
                      <button type="button" class="btn rounded-pill btn-icon btn-danger box-del" v-if="FormStore.image" @click="CleanImg()">
                        <i class='bx bxs-x-circle fs-4'></i>
                      </button>
                      <img :src="image_pre" class=" rounded cursor-pointer" @click="$refs.img_store.click()" style="width:80%" alt="">

                      <input type="file" class=" form-control mt-2" ref="img_store" @change="onSelected" style="display: none;">
                    </div>
                    <div class="col-md-8">
                    
                            <label for="product-name" class="form-label fs-6">ຊື່ສິນຄ້າ: <span class="text-danger">*</span> </label>
                            <input type="text" class="form-control mb-2" id="product-name" placeholder="...." v-model="FormStore.name">
                            <label for="product-name" class="form-label fs-6">ຈຳນວນ:  <span class="text-danger">*</span></label>
                            <cleave :options="options" class="form-control  mb-2" id="product-name" placeholder="...." v-model="FormStore.amount" />

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="product-name" class="form-label fs-6  mb-2">ລາຄາຊື້: <span class="text-danger">*</span></label>
                            <cleave :options="options" class="form-control" id="product-name" placeholder="...." v-model="FormStore.price_buy" />
                                </div>
                                <div class="col-md-6">
                                    <label for="product-name" class="form-label fs-6  mb-2">ລາຄາຂາຍ: <span class="text-danger">*</span></label>
                                    <cleave :options="options" class="form-control" id="product-name" placeholder="...." v-model="FormStore.price_sell" />
                                </div>
                            </div>
                    
                    
                    </div>
            </div>
    </div>

  
    <!-- {{ StoreData }} -->
    <!-- <button @click="showAlert">Hello world</button> -->
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
            <th width="120">ຮູບ</th>
            <th>ຊື່ສິນຄ້າ</th>
            <th>ລາຄາຊື້</th>
            <th>ຈັດການ</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="list in StoreData.data" :key="list.id">
            <td> {{ list.id  }} </td>
            <td> <img :src="'/assets/img/'+list.image" class="w-100 rounded" alt="" v-if="list.image"> 
               <img src="/assets/img/add-img.png" class="w-100 rounded" alt="" v-else>
               </td>
            <td> {{ list.name  }} </td>
            <td> {{ formatPrice(list.price_buy) }}</td>
            <td>
              <div class="dropdown">
                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                <div class="dropdown-menu">
                  <a class="dropdown-item" href="javascript:void(0);" @click="CopyStore(list.id)"><i class='bx bx-copy-alt me-1' ></i> ກ໊ອບປີ້</a>
                  <a class="dropdown-item" href="javascript:void(0);" @click="EditStore(list.id)"><i class="bx bx-edit-alt me-1"></i> ແກ້ໄຂ</a>
                  <a class="dropdown-item" href="javascript:void(0);" @click="DeleteStore(list.id)"><i class="bx bx-trash me-1"></i> ລຶບ</a>
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
            options: {
                  // prefix: '₭ ',
                  numeral: true,
                  numeralPositiveOnly: true,
                  noImmediatePrefix: true,
                  rawValueTrimPrefix: true,
                  numeralIntegerScale: 10,
                  numeralDecimalScale: 2,
                  numeralDecimalMark: ',',
                  delimiter: '.'
                },
          image_pre: window.location.origin+'/assets/img/add-img.png'
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
      CleanImg(){
        this.FormStore.image = ''
        this.image_pre = window.location.origin+'/assets/img/add-img.png'
      },
      onSelected(event){
        // console.log(event);
        this.FormStore.image = event.target.files[0]
        let reader = new FileReader();
        reader.readAsDataURL(this.FormStore.image);
        reader.addEventListener("load", function(){
          this.image_pre = reader.result;
        }.bind(this),false);

      },
      showAlert() {
      // Use sweetalert2
      this.$swal('Hello Vue world!!!');
    },
    formatPrice(value) {
        let val = (value / 1).toFixed(0).replace(",", ".");
        return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
      },
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
       async EditStore(id){
          this.EditID = id
          this.FormType = false

          await axios.get(`store/edit/${id}`,{ headers:{ Authorization: 'Bearer '+ this.store.get_token}}).then((response)=>{
         
                          this.ShowForm = true
                          this.FormStore = response.data
                          if(response.data.image){
                            this.image_pre = window.location.origin + '/assets/img/'+response.data.image
                          } else {
                            this.image_pre = window.location.origin+'/assets/img/add-img.png'
                          }
                          console.log(this.FormStore);

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

        },
       async CopyStore(id){
          this.EditID = id
          this.FormType = true

          await axios.get(`store/edit/${id}`,{ headers:{ Authorization: 'Bearer '+ this.store.get_token}}).then((response)=>{
         
                          this.ShowForm = true
                          this.FormStore = response.data

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
        },
        DeleteStore(id){



          this.$swal({
            title: 'ທ່ານແນ່ໃຈບໍ່?',
            text: "ທີ່ຈະລຶບຂໍ້ມູນນີ້!",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ຕົກລົງລຶບ!',
            cancelButtonText: 'ຍົກເລີກ'
          }).then((result) => {
            if (result.isConfirmed) {

                // this.loading_post = true
                axios.delete(`store/delete/${id}`,{ headers:{ Authorization: 'Bearer '+ this.store.get_token}}).then((response)=>{
                  // this.loading_post = false

                    if(response.data.success){
                      this.GetAllStore()

                      this.$swal('ສຳເລັດ!',response.data.message,'success')

                    } else {
                      this.$swal('ຜິດຜາດ!',response.data.message,'error')
                    }


                }).catch((error)=>{
                  // this.loading_post = false
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
          })

          

        },
       async SaveStore(){

          this.loading_post = true
          
          if(this.CheckForm){
              if(this.FormType){
                /// ເພີ່ມຂໍ້ມູນໃໝ່
                await axios.post("store/add",this.FormStore,{ headers:{ "content-type":"multipart/form-data", Authorization: 'Bearer '+ this.store.get_token}}).then((response)=>{
                  this.loading_post = false
                 

                        if(response.data.success){
                          this.ShowForm = false
                          this.GetAllStore()

                          this.$swal({
                            toast:true,
                            position: 'top-end',
                            icon: 'success',
                            title: response.data.message,
                            showConfirmButton: false,
                            timer: 2500
                          })

                        } else {
                          this.$swal({
                            // toast:true,
                            position: 'center',
                            icon: 'error',
                            title: 'ຜິດຜາດ!',
                            text: response.data.message,
                            showConfirmButton: false,
                            timer: 4500
                          })
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

                await axios.post(`store/update/${this.EditID}`,this.FormStore,{ headers:{ "content-type":"multipart/form-data", Authorization: 'Bearer '+ this.store.get_token}}).then((response)=>{
                  this.loading_post = false

                  if(response.data.success){
                          this.ShowForm = false
                          this.GetAllStore()

                          this.$swal({
                            toast:true,
                            position: 'top-end',
                            icon: 'success',
                            title: response.data.message,
                            showConfirmButton: false,
                            timer: 2500
                          })

                        } else {
                          this.$swal({
                            // toast:true,
                            position: 'center',
                            icon: 'error',
                            title: 'ຜິດຜາດ!',
                            text: response.data.message,
                            showConfirmButton: false,
                            timer: 4500
                          })
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

<style scoped>
  .box-del{
    position: absolute;
    right: 10px;
    top: 10px;
  }
</style>