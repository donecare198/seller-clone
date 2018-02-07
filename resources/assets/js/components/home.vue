<template>
    <section class="content">
        <input type="hidden" id="id_user" value="">
        <!-- Thong Tin Website-->
        <div class="row">
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>{{this.infoSystem.countClone}}</h3>
                        <p>Tổng Clone</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-user-plus"></i>
                    </div>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>{{this.infoSystem.daban}}</h3>

                        <p>Đã Bán</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-android"></i>
                    </div>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3>{{this.infoSystem.chuaban}}</h3>

                        <p>Chưa Bán</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-cc-visa"></i>
                    </div>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3>{{this.infoSystem.countUser}}</h3>

                        <p>Người Dùng</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-users"></i>
                    </div>
                </div>
            </div>
            <!-- ./col -->
        </div>
        <!---Giới Thiệu Dịch Vụ---->
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">Mua Clone</div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label>Loại Clone</label>
                            <select class="form-control" id="loai">
                                <option value="1">Clone Trắng</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Giá / 1 Clone</label>
                            <input type="text" disabled="" :value="this.$parent.config[7].value.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')+' VNĐ'" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label>Số Lượng</label>
                            <input type="number" step="10" id="soluong" v-on:change="tinhtien" v-on:keyup="changeSolong" v-on:keydown="tinhtien" value="100" class="form-control" placeholder="Nhập vào số lượng clone muốn mua" />
                        </div>
                        <div class="form-group">
                            <label>Thành Tiền</label>
                            <input type="text" disabled="" :value="(100 * this.$parent.config[7].value).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.') + ' VNĐ'" id="thanhtien" class="form-control" />
                        </div>
                        <div class="form-group text-center">
                            <button class="btn btn-danger" v-on:click="buyClone">Mua Clone</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <table class="table table-bodered text-center">
                    <tr>
                        <th>STT</th>
                        <th>Loại</th>
                        <th>Giá(VNĐ)</th>
                        <th>Số Lượng</th>
                        <th>Thời Gian</th>
                        <th>Download</th>
                    </tr>
                <tbody>
                    <tr v-for="(his,index) in historyBuy.data">
                        <td>{{index + 1}}</td>
                        <td>{{his.loai}}</td>
                        <td>{{his.giatien.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.")}} VNĐ</td>
                        <td>{{his.soluong}}</td>
                        <td>{{his.created_at}}</td>
                        <td><a :href="'http://fb666.net/api/downloadClone/'+his.id" target="_blank"><i class="fa fa-download"></i></a></td>
                    </tr>
                </tbody>
                </table>
                <pagination 
                  :total="this.historyBuy.total" 
                  :per_page= "this.historyBuy.per_page" 
                  :current_page= "this.historyBuy.current_page" 
                  :last_page= "this.historyBuy.last_page" 
                  :next_page_url= "this.historyBuy.next_page_url" 
                  :prev_page_url= "this.historyBuy.prev_page_url" 
                  :from= "this.historyBuy.from" 
                  :to= "this.historyBuy.to" 
                ></pagination>
            </div>
        </div>
    </section>
</template>
<script>
import axios from 'axios'
import pagination from './pagination.vue'
export default{
    data() {
        return{
            infoSystem:[],
            historyBuy:[],
            n:0
        }
    },
    components: {
        pagination,
    },
    methods:{
        toPage(n){
            let $this = this;
            axios.get(this.historyBuy.path+'?page='+n)
            .then(function (response){
                $this.historyBuy = response.data;
              })
              .catch(function (error) {
                console.log(error);
              });
        },
        changeSolong : function(){
            var soluong = $('#soluong').val();
            if(soluong < 100){
                toastr.error('Bạn chỉ cần mua tối thiểu 100 Clone');
            }else if(soluong > this.infoSystem.chuaban){
                toastr.error('Bạn chỉ có thể mua tối đa '+this.infoSystem.chuaban+' Clone');
            }
        },
        tinhtien(){
            var soluong = $('#soluong').val();
            var tinh = soluong * this.$parent.config[7].value;
            tinh = tinh.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.")+' VNĐ';
            $('#thanhtien').val(tinh);
        },
        buyClone : function(){
            var data = {'__token':$('meta[name="csrf-token"]').attr('content'),
                        'soluong':$('#soluong').val(),
                        'loai':$('#loai').val()}
            axios.post('api/buyClone',data)
            .then((response)=>{
                toastr.success(response.data.message);
                axios.get('api/historyBuy').then((response) => {
                    this.historyBuy = response.data;
                    console.log(this.historyBuy);
                })
                axios.get('api/infoSystem').then((response) => {
                    this.infoSystem = response.data;
                })
            })
            .catch((error)=>{
                console.log(error.response);
                toastr.error(error.response.data.message);
            })
        },
    },
    mounted(){
        axios.get('api/infoSystem').then((response) => {
            this.infoSystem = response.data;
        })
        axios.get('api/historyBuy').then((response) => {
            this.historyBuy = response.data;
            console.log(this.historyBuy);
        })
        
    }
}
</script>