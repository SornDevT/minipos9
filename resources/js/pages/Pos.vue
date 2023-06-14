<template>
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-body">
                        <input type="text" class=" form-control" v-model="search" @keyup.enter="GetAllStore()" placeholder="ຄົ້ນຫາ...." >
                </div>
            </div>

            <div class="row" style="height: 70vh; overflow: auto;">

                <div class="col-md-3 cursor-pointer" v-for="list in StoreData.data" :key="list.id">
                    <div class="card mb-3" @click="AddProduct(list.id)">
                        <span v-for="i in ListOrder" :key="i.id">
                            <div class="num-img" v-if="list.id == i.id">{{ i.order_amount }}</div>
                        </span>
                        <img v-if="list.image" :src="'/assets/img/'+list.image" class=" card-img-top img-cover" alt="">
                        <img v-else src="/assets/img/add-img.png" class=" card-img-top img-cover" alt="">
                        <div class="card-body p-1 text-center">
                            {{list.name}}
                            <p class="card-text">{{formatPrice(list.price_sell)}} ກີບ</p>
                        </div>
                    </div>
                </div>
                
                

            </div>

        </div>
        <div class="col-md-4">
            
            <div class="card" style="height: 82vh; overflow: auto;">
                <div class="card-body">
                    <label for="text-customer">ຊື້ລູກຄ້າ:</label>
                    <input type="text" id="text-customer" class="form-control mb-2" v-model="customer_name" placeholder="....">

                    <label for="text-customer">ເບີໂທ:</label>
                    <input type="text" id="text-customer" class="form-control" v-model="customer_tel" placeholder="....">
                    <hr>
                    <div class=" d-flex justify-content-between fs-4 text-info fw-bold">
                        <span>ລວມຍອດເງິນ:</span>
                        <span>{{ formatPrice(TotalAmount) }} ກີບ</span>
                    </div>
                    <button class=" btn btn-info mb-3 w-100" :disabled="!TotalAmount" @click="ConfirmToPay()">ຊຳລະເງິນ</button>
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>ລາຍການ</th>
            <th>ລາຄາ</th>
            <th>ລວມຍອດ</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="list in ListOrder" :key="list.id">
            <td>{{ list.name }}</td>
            <td>{{ formatPrice(list.price_sell) }} <br> 
                <i class='bx bxs-minus-circle cursor-pointer text-warning' @click="RemoveProduct(list.id)"></i> {{ list.order_amount }} <i class='bx bxs-plus-circle cursor-pointer text-info' @click="AddProduct(list.id)"></i> | <i class='bx bxs-x-circle cursor-pointer text-danger' @click="DeleteProduct(list.id)"></i>
            </td>
            <td>{{ formatPrice(list.price_sell*list.order_amount) }}</td>
          </tr>
        </tbody>
      </table>
                </div>
            </div>
        </div>
      
    </div>

        <div class="modal fade" id="ConfirmToPay" tabindex="-1" style="display: none;" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel1">ຊຳລະເງິນ</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <div class="row">
                    <div class=" d-flex justify-content-between">
                        <div>ລວມຍອດ:</div>
                        <div>{{ formatPrice(TotalAmount) }} ກີບ</div>
                    </div>
                    <div class=" d-flex justify-content-between">
                        <div>ຮັບເງິນນຳລູກຄ້າ:</div>
                        <div>{{ formatPrice(CashAmount) }} ກີບ</div>
                    </div>
                    <div class=" d-flex justify-content-between text-danger" v-if="CashAmount-TotalAmount>0">
                        <div>ເງິນທອນ:</div>
                        <div>{{ formatPrice(CashAmount-TotalAmount) }} ກີບ</div>
                    </div>
                    
                  </div>
                  <div class=" d-flex justify-content-end">
                    <cleave :options="options" class=" form-control text-end" v-model="CashAmount" placeholder="....." style="width: 200px;"/>
                  </div>

                  <div class="d-flex justify-content-center">
                  <div class="row" style="width: 250px;">
                        <div class="col-4 mt-2">
                            <button type="button" style="width: 60px;" class="btn btn-primary" @click="AddNum(1)" >1</button>
                        </div>
                        <div class="col-4 mt-2">
                            <button type="button" style="width: 60px;" class="btn btn-primary" @click="AddNum(2)" >2</button>
                        </div>
                        <div class="col-4 mt-2">
                            <button type="button" style="width: 60px;" class="btn btn-primary" @click="AddNum(3)">3</button>
                        </div>
                        <div class="col-4 mt-2">
                            <button type="button" style="width: 60px;" class="btn btn-primary" @click="AddNum(4)">4</button>
                        </div>
                        <div class="col-4 mt-2">
                            <button type="button" style="width: 60px;" class="btn btn-primary" @click="AddNum(5)">5</button>
                        </div>
                        <div class="col-4 mt-2">
                            <button type="button" style="width: 60px;" class="btn btn-primary" @click="AddNum(6)">6</button>
                        </div>
                        <div class="col-4 mt-2">
                            <button type="button" style="width: 60px;" class="btn btn-primary" @click="AddNum(7)">7</button>
                        </div>
                        <div class="col-4 mt-2">
                            <button type="button" style="width: 60px;" class="btn btn-primary" @click="AddNum(8)">8</button>
                        </div>
                        <div class="col-4 mt-2">
                            <button type="button" style="width: 60px;" class="btn btn-primary" @click="AddNum(9)">9</button>
                        </div>
                        <div class="col-4 mt-2">
                            <button type="button" style="width: 60px;" class="btn btn-primary" @click="AddNum('00')">00</button>
                        </div>
                        <div class="col-4 mt-2">
                            <button type="button" style="width: 60px;" class="btn btn-primary" @click="AddNum(0)">0</button>
                        </div>
                        <div class="col-4 mt-2" style="width: 60px;">
                            <button type="button" style="width: 60px;" class="btn btn-danger" @click="AddNum('-')"><i class='bx bx-arrow-back'></i></button>
                        </div>
                  </div>
                </div>
                <div class="text-center mt-4">
                    <button type="button" class="btn rounded-pill btn-success" :disabled="!(CashAmount>=TotalAmount)" @click="Pay()">
                        <span v-if="loading_post">
                          <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                        ກຳລັງໂຫຼດ...
                    </span>
                    <span v-else> ຍືນຍັນຊຳລະເງິນ</span>
                       
                    </button>
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
    name: 'Minipos9Pos',
    setup(){
        const store = useStore()
        return {store}
    },
    data() {
        return {
            CashAmount:'',
            StoreData:[],
            ListOrder:[],
            search:'',
            list_page:20,
            sort:'asc',
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
                loading_post:false,
                customer_name:'',
                customer_tel:''
        };
    },

    mounted() {
        
    },
    computed:{
        TotalAmount(){
            let caculator = this.ListOrder.reduce((num,item)=> parseInt(num) + (parseInt(item.price_sell)*parseInt(item.order_amount)),0)
            return caculator
        }
    },

    methods: {
        async openLink(link) {
            
            const response = await fetch(`${link}`, {
                headers: {
                'Authorization': `Bearer ${this.store.get_token}`
                }
            });

            const html = await response.text();
            const blob = new Blob([html], { type: 'text/html' });
            const blobUrl = URL.createObjectURL(blob);
            window.open(blobUrl, '_blank');

            },
       async Pay(){
        this.loading_post = true

            await axios.post("transection/add",{
                acc_type:'income',
                listorder:this.ListOrder,
                customer_name: this.customer_name,
                customer_tel: this.customer_tel
            },{ headers:{ "content-type":"multipart/form-data", Authorization: 'Bearer '+ this.store.get_token}}).then((response)=>{
                  this.loading_post = false
                 

                        if(response.data.success){

                        $('#ConfirmToPay').modal('hide')
                        this.ListOrder = []
                        this.customer_name = ''
                        this.customer_tel = ''
                        this.GetAllStore()

                        this.openLink(window.location.origin+'/api/bills/print/'+response.data.bill_id)

                        //   this.$swal({
                        //     toast:true,
                        //     position: 'top-end',
                        //     icon: 'success',
                        //     title: response.data.message,
                        //     showConfirmButton: false,
                        //     timer: 2500
                        //   })

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
        },
        AddNum(num){
            if(num == '-'){ 
                this.CashAmount = this.CashAmount.slice(0,-1)
            } else { 
                this.CashAmount = this.CashAmount + num
            }
        },
        ConfirmToPay(){
            $('#ConfirmToPay').modal('show')
        },
        AddProduct(id){
            // console.log(id);

            let list_order = this.ListOrder.find((i)=>i.id==id)

            if(list_order){
                // ອັບເດດຈຳນວນ

                list_order.order_amount++


            } else {
                // ເພີ່ມລາຍການໃໝ່
                let item = this.StoreData.data.find((i)=>i.id==id)
                // console.log(item);


                this.ListOrder.push({
                    id: item.id,
                    name: item.name,
                    order_amount: 1,
                    price_sell: item.price_sell
                })
            }

           
        },
        RemoveProduct(id){
            let list_order = this.ListOrder.find((i)=>i.id==id)
            if(list_order){
                list_order.order_amount--
                if(list_order.order_amount<1){
                    this.ListOrder.splice(this.ListOrder.map((i)=>i.id).indexOf(id),1)
                }
            }
            
        },
        DeleteProduct(id){
            this.ListOrder.splice(this.ListOrder.map((i)=>i.id).indexOf(id),1)
        },
        formatPrice(value) {
        let val = (value / 1).toFixed(0).replace(",", ".");
        return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
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
    watch:{
        search(){
            if(this.search == ''){
                this.GetAllStore()
            }
        }
    },
    created(){
        // console.log(useStore().get_data);
        this.GetAllStore()
    }
};
</script>

<style scoped>
    .num-img{
        position: absolute;
        top: 0px;
        right: 0px;
        background-color: firebrick;
        color: white;
        padding: 5px;
        border-radius: 0px 10px 0px 10px;
    }
    .img-cover{
        object-fit: cover;
        width: 100%;
        height: 120px;
        object-position: center;
    }
</style>