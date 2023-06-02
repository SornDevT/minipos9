<template>
   <div class="card">
  <h5 class="card-header">Bordered Table</h5>
  <div class="card-body"> {{ ShowForm  }}

        <div v-if="ShowForm">
            <div class=" d-flex justify-content-end mb-2">
                <div class=" d-flex">
                    <button type="button" class="btn btn-success"> <i class='bx bx-save' ></i> ບັນທຶກ </button>
                    <button type="button" class="btn btn-secondary ms-2" @click="CancelStore()"> <i class='bx bx-x'></i> ຍົກເລີກ </button>
                </div>
                </div>
                <div class="row">
                    <div class="col-md-4">ອັບໂຫຼດຮູບພາບ</div>
                    <div class="col-md-8">
                    
                            <label for="product-name" class="form-label fs-6">ຊື່ສິນຄ້າ:</label>
                            <input type="text" class="form-control mb-2" id="product-name" placeholder="....">
                            <label for="product-name" class="form-label fs-6">ຈຳນວນ:</label>
                            <input type="text" class="form-control  mb-2" id="product-name" placeholder="....">

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="product-name" class="form-label fs-6  mb-2">ລາຄາຊື້:</label>
                            <input type="text" class="form-control" id="product-name" placeholder="....">
                                </div>
                                <div class="col-md-6">
                                    <label for="product-name" class="form-label fs-6  mb-2">ລາຄາຂາຍ:</label>
                                    <input type="text" class="form-control" id="product-name" placeholder="....">
                                </div>
                            </div>
                    
                    
                    </div>
            </div>
    </div>

  

    <div class="table-responsive text-nowrap" v-if="!ShowForm" >
        <div class=" d-flex justify-content-between mb-2">
            <div class=" d-flex justify-content-center align-items-center">
                <div class="me-2">
                    <i class='bx bx-sort-up fs-4'></i>
                </div>
                <select  class="form-select">
                    <option value="10">10</option>
                    <option value="30">30</option>
                    <option value="50">50</option>
                </select>
            </div>

            <div class=" d-flex">
                <input type="text" class="form-control me-2"  placeholder="ຄົ້ນຫາ..."  >
                <button type="button" class="btn btn-info" @click="AddStore()"> <i class='bx bx-plus'></i> ເພີ່ມໃໝ່ </button>
            </div>
            
        </div>
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Project</th>
            <th>Client</th>
            <th>Users</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>Angular Project</strong></td>
            <td>Albert Cook</td>
            <td>
              <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar avatar-xs pull-up" title="" data-bs-original-title="Lilian Fuller">
                  <img src="assets/img/avatars/5.png" alt="Avatar" class="rounded-circle">
                </li>
                <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar avatar-xs pull-up" title="" data-bs-original-title="Sophia Wilkerson">
                  <img src="assets/img/avatars/6.png" alt="Avatar" class="rounded-circle">
                </li>
                <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar avatar-xs pull-up" title="" data-bs-original-title="Christina Parker">
                  <img src="assets/img/avatars/7.png" alt="Avatar" class="rounded-circle">
                </li>
              </ul>
            </td>
            <td><span class="badge bg-label-primary me-1">Active</span></td>
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
          <tr>
            <td><i class="fab fa-react fa-lg text-info me-3"></i> <strong>React Project</strong></td>
            <td>Barry Hunter</td>
            <td>
              <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar avatar-xs pull-up" title="" data-bs-original-title="Lilian Fuller">
                  <img src="assets/img/avatars/5.png" alt="Avatar" class="rounded-circle">
                </li>
                <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar avatar-xs pull-up" title="" data-bs-original-title="Sophia Wilkerson">
                  <img src="assets/img/avatars/6.png" alt="Avatar" class="rounded-circle">
                </li>
                <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar avatar-xs pull-up" title="" data-bs-original-title="Christina Parker">
                  <img src="assets/img/avatars/7.png" alt="Avatar" class="rounded-circle">
                </li>
              </ul>
            </td>
            <td><span class="badge bg-label-success me-1">Completed</span></td>
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
          <tr>
            <td><i class="fab fa-vuejs fa-lg text-success me-3"></i> <strong>VueJs Project</strong></td>
            <td>Trevor Baker</td>
            <td>
              <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar avatar-xs pull-up" title="" data-bs-original-title="Lilian Fuller">
                  <img src="assets/img/avatars/5.png" alt="Avatar" class="rounded-circle">
                </li>
                <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar avatar-xs pull-up" title="" data-bs-original-title="Sophia Wilkerson">
                  <img src="assets/img/avatars/6.png" alt="Avatar" class="rounded-circle">
                </li>
                <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar avatar-xs pull-up" title="" data-bs-original-title="Christina Parker">
                  <img src="assets/img/avatars/7.png" alt="Avatar" class="rounded-circle">
                </li>
              </ul>
            </td>
            <td><span class="badge bg-label-info me-1">Scheduled</span></td>
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
          <tr>
            <td><i class="fab fa-bootstrap fa-lg text-primary me-3"></i> <strong>Bootstrap Project</strong></td>
            <td>Jerry Milton</td>
            <td>
              <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar avatar-xs pull-up" title="" data-bs-original-title="Lilian Fuller">
                  <img src="assets/img/avatars/5.png" alt="Avatar" class="rounded-circle">
                </li>
                <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar avatar-xs pull-up" title="" data-bs-original-title="Sophia Wilkerson">
                  <img src="assets/img/avatars/6.png" alt="Avatar" class="rounded-circle">
                </li>
                <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar avatar-xs pull-up" title="" data-bs-original-title="Christina Parker">
                  <img src="assets/img/avatars/7.png" alt="Avatar" class="rounded-circle">
                </li>
              </ul>
            </td>
            <td><span class="badge bg-label-warning me-1">Pending</span></td>
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
    </div>
  </div>
</div>
</template>

<script>

import { useStore } from '../store/auth'

export default {
    name: 'Minipos9Store',

    setup(){
        const store = useStore()
        return {store}
    },

    data() {
        return {
            ShowForm:false,
        };
    },

    mounted() {
        
    },

    methods: {

        AddStore(){
            this.ShowForm = true
        },
        CancelStore(){
            this.ShowForm = false
        },

        async getTest(){

            const store = useStore()
            const token = store.get_token

            await axios.get("store",{ headers:{ Authorization: 'Bearer '+ token}}).then((response)=>{
                        console.log(response.data);
                      }).catch((error)=>{
                        console.log(error);
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
        // console.log(useStore().get_data);
        this.getTest()
    }
};
</script>

<style lang="scss" scoped>

</style>