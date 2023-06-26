<template>
    <div>
      
        <!-- <DoughnutChart :chartData="testData" /> -->
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">ສະຫຼຸບລາຍຮັບ-ລາຍຈ່າຍ</div>
                    <div class=" d-flex justify-content-end">
                        <div class="btn-group me-2" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-secondary" @click="month_type = 'm'"><i class='bx bx-chevron-right' v-if="month_type=='m'"></i> ເດືອນ</button>
                            <button type="button" class="btn btn-secondary" @click="month_type = 'y'"><i class='bx bx-chevron-right' v-if="month_type=='y'"></i> ປີ</button>
                        </div>
                            <input type="date" class="form-control me-2" v-model="dmy" style="width:150px" >
                            <button type="button" class="btn btn-success me-2" @click="CreateReport()"> ສະແດງຂໍ້ມູນ </button>
                    </div>
                    <div class="card-body">
                        <LineChart :chartData="chdata" :options="choptions" />
                    </div>
                </div>
            </div>
            <div class="col-md-4">

                <div class="card mb-4">
                    <div class="card-body">
                            <div class=" d-flex justify-content-between">
                                <span><i class='bx bxs-wallet-alt' ></i> <br> ລາຍຮັບ</span>
                                <span> {{  formatPrice(sum_income)  }} ກີບ</span>
                            </div>
                </div>
            </div>
            <div class="card mb-4">
                    <div class="card-body">
                            <div class=" d-flex justify-content-between">
                                <span><i class='bx bxs-wallet-alt' ></i> <br> ລາຍຈ່າຍ</span>
                                <span> {{ formatPrice(sum_expense)  }} ກີບ</span>
                            </div>
                </div>
            </div>
            <div class="card">
                    <div class="card-body">
                            <div class=" d-flex justify-content-between">
                                <span><i class='bx bxs-wallet-alt' ></i> <br> ກຳໄລ</span>
                                <span> {{ formatPrice(sum_profit)  }} ກີບ</span>
                            </div>
                </div>
            </div>

            </div>
        </div>

    </div>
</template>

<script>
import { useStore } from '../store/auth'
import axios from 'axios';
import { LineChart } from 'vue-chart-3';
import { Chart, registerables } from "chart.js";
import moment from "moment"

Chart.register(...registerables);

export default {
    name: 'Minipos9Report',
    setup(){
        const store = useStore()
        return {store}
    },
    data() {
        return {
            month_type:'m',
            dmy: new Date().toISOString().slice(0,10),
            data_income:[],
            data_expense:[],
            chdata:[],
            choptions:{
                plugins:{
                tooltip: {
                    callbacks: {
                        label: function (tooltipItem, data) {
                        return (
                            Number(tooltipItem.raw) .toFixed(0) .replace(/./g, function (c, i, a) { return i > 0 && c !== "." && (a.length - i) % 3 === 0 ? "." + c : c; }) + " ກີບ" );
                        },
                    },
                    mode: "index",
                    intersect: false,
                    },
              },
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                    y:{
                        ticks: {
                            display: true,
                            beginAtZero: false,
                            callback: function (value, index, values) {
                            return ( Number(value) .toFixed(0) .replace(/./g, function (c, i, a) { return i > 0 && c !== "." && (a.length - i) % 3 === 0 ? "." + c : c; }) + " ກີບ" );
                            },
                        },
                        gridLines: {
                            show: true,
                        },
                        },
                    },
                    
            },
        };
    },
    components:{
        LineChart,moment
    },

    mounted() {
        
    },
    computed:{
        sum_income(){
            return this.data_income.reduce((num,item)=> num + item.price,0)
        },
        sum_expense(){
            return this.data_expense.reduce((num,item)=> num + item.price,0)
        },
        sum_profit(){
            return this.sum_income-this.sum_expense
        }
    },

    methods: {
        formatPrice(value) {
        let val = (value / 1).toFixed(0).replace(",", ".");
        return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
      },
      async CreateReport(){
                await axios.post('report',{
                month_type: this.month_type,
                dmy:this.dmy
             },{ headers:{ Authorization: 'Bearer '+ this.store.get_token}}).then((response)=>{
                
                this.data_income = response.data.income
                this.data_expense = response.data.expense
                this.GenGrap()

              }).catch((error)=>{
                console.log(error);
                   if(error){
                        if(error.response.status == 401){
                            useStore().remove_token()
                            this.$router.push('/login')
                        }
                    }
              })
        },
        GenGrap(){

                    if(this.month_type =='m'){

                    let re_income = []
                    let re_expense = []
                    let m = this.dmy.split("-")[1]
                    let y = this.dmy.split("-")[0]

                    let chart_label = []

                    let lastday = this.Getlastday(y,m)

                    for (let i = 0; i < lastday; i++) {
                        chart_label.push("ວັນທີ່ "+(i+1))
                    }

                    // console.log(chart_label)

                    re_income = this.Get_data_chart(lastday,this.data_income) || 0;
                    re_expense = this.Get_data_chart(lastday, this.data_expense) || 0;

                    this.chdata = {
                        labels: chart_label,
                        datasets: [
                            {
                                label: 'ລາຍຮັບ',
                                fill: false,
                                borderColor: "#330011",
                                data: re_income
                            },
                            {
                                label: 'ລາຍຈ່າຍ',
                                fill: false,
                                borderColor: "#DC3912",
                                data: re_expense
                            },
                            // {
                            //     label: 'ສິນຄ້າ',
                            //     fill: false,
                            //     borderColor: "#339911",
                            //     data: re_income
                            // },
                        ]
                    }

                    // this.update_chart = Math.floor(Math.random() * 100)

                    } else {


                        let re_income = []
                        let re_expense = []
                        let m = this.dmy.split("-")[1]
                        let y = this.dmy.split("-")[0]
                        let chart_label = ["ເດືອນ 1","ເດືອນ 2","ເດືອນ 3","ເດືອນ 4","ເດືອນ 5","ເດືອນ 6","ເດືອນ 7","ເດືອນ 8","ເດືອນ 9","ເດືອນ 10","ເດືອນ 11","ເດືອນ 12"]

                        // let lastday = this.Getlastday(y,m)

                        // for (let i = 0; i < lastday; i++) {
                        //     chart_label.push("ວັນທີ່ "+(i+1))
                        // }

                        // console.log(chart_label)

                        re_income = this.Get_data_chart_y(12,this.data_income) || 0;
                        re_expense = this.Get_data_chart_y(12, this.data_expense) || 0;

                        this.chdata = {
                            labels: chart_label,
                            datasets: [
                                {
                                    label: 'ລາຍຮັບ',
                                    fill: false,
                                    borderColor: "#330011",
                                    data: re_income
                                },
                                {
                                    label: 'ລາຍຈ່າຍ',
                                    fill: false,
                                    borderColor: "#DC3912",
                                    data: re_expense
                                },
                            ]
                        }

                        // this.update_chart = Math.floor(Math.random() * 100)

                    } 

                    },
        Getlastday(y,m){
			let dd = new Date(y, m , 0).getDate();
            console.log('ວັນທີ່ສຸດທ້າຍ ຂອງເດືອນ:'+ dd)
            return dd;
        },
        Getday(value){
          return moment(value).format("DD");
        },
        Getmonth(value){
          return moment(value).format("MM");
        },
        Get_data_chart(date, data){
        //    console.log(data)
          let new_db_in = [];
          let databack = [];
          for (let y = 0; y < data.length; y++) {
            if (data[y] != "") {
            let day = this.Getday(data[y].created_at);
            new_db_in.push({ price: data[y].price, day: day });
            }
          }
            // console.log(new_db_in)
          
            let update_db_in = new_db_in.reduce((a, c) => {
              let filtered = a.filter((el) => el.day === c.day);
              if (filtered.length > 0) {
              a[a.indexOf(filtered[0])].price =
                parseInt(a[a.indexOf(filtered[0])].price) + parseInt(c.price);
              } else {
              a.push(c);
              }
              return a;
            }, []);

        //    console.log(update_db_in)

            for (let i = 0; i < date; i++) {
              let type = true;
              for (let k = 0; k < update_db_in.length; k++) {
              if (update_db_in[k].day == i + 1) {
                if (type) {
                databack.push(update_db_in[k].price);
                type = false;
                }
              }
              }
              if (type) {
              databack.push(0);
              type = false;
              }
            }

            // console.log(databack)

          return databack;
        },
        Get_data_chart_y(monthchart, data){

          let new_db_in = [];
          let databack = [];
          for (let y = 0; y < data.length; y++) {
            if (data[y] != "") {
            let month = this.Getmonth(data[y].created_at);
            new_db_in.push({ price: data[y].price, month: month });
            }
          }

          let update_db_in = new_db_in.reduce((a, c) => {
            let filtered = a.filter((el) => el.month == c.month);
            if (filtered.length > 0) {
            a[a.indexOf(filtered[0])].price =
              parseInt(a[a.indexOf(filtered[0])].price) + parseInt(c.price);
            } else {
            a.push(c);
            }
            return a;
          }, []);

          for (let i = 0; i < monthchart; i++) {
            let type = true;
            for (let k = 0; k < update_db_in.length; k++) {
            if (update_db_in[k].month == i + 1) {
              if (type) {
              databack.push(update_db_in[k].price);
              type = false;
              }
            }
            }
            if (type) {
            databack.push(0);
            type = false;
            }
          }

        //   console.log(databack)

          return databack;
          

        },
    },
    created(){
        this.CreateReport()
        console.log(useStore().get_data);
    }
};
</script>

<style lang="scss" scoped>

</style>