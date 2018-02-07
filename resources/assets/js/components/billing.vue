<template>
    <div style="margin-top: 15px;">
        <div class="col-md-6">
            <div class="panel panel-primary">
              <div class="panel-heading">Nạp Tiền</div>
              <div class="panel-body">
                <div class="form-group">
                    <label>Tài Khoản Nhận: </label>
                    <input type="text" disabled="" class="form-control" :value="this.$parent.info.name" />
                </div>
                <div class="form-group">
                    <label>Số Tiền Nạp: </label>
                    <input type="number" v-on:keyup="max_billing" v-on:change="max_billing" step="10000" class="form-control" id="money_billing" value="50000" />
                    <span class="text-danger" id="message_money">50.000 VNĐ</span>
                </div>
                <div class="form-group text-right">
                    <button class="btn btn-danger" id="btnnaptien" v-on:click="addTransaction">Tiếp Theo</button>
                </div>
              </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-warning">
                <div class="panel-heading">Lịch Sử</div>
                <div class="panel-body">
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tbody>
                            <tr>
                                <th>ID</th>
                                <th>TransactionID</th>
                                <th>Money</th>
                                <th>Status</th>
                                <th>Time Create</th>
                            </tr>
                            <tr v-for="tran in $parent.Transaction">
                                <td>{{tran.id}}</td>
                                <td>{{tran.transactionid}}</td>
                                <td>{{tran.money.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.")+' VNĐ'}}</td>
                                <td>{{tran.status}}</td>
                                <td>{{tran.created_at}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import axios from 'axios'
export default {
    data(){
        return{
        }  
    },
    methods:{
        max_billing : function(){
            var money = $('#money_billing').val();
            if(money < 50000 || money > 300000000){
                $('#message_money').html('Số tiền bạn nạp phải từ 50k - 300tr');
                $('#btnnaptien').prop('disabled',true);
            }else{
                $('#message_money').html(money.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.")+" VNĐ");
                $('#btnnaptien').prop('disabled',false);
            }
        },
        addTransaction : function(){
            var money = $('#money_billing').val();
            if(money < 50000 || money > 300000000){
                $('#message_money').html('Số tiền bạn nạp phải từ 50k - 300tr');
                return false;
            }else{
                axios.post('/api/addTransaction',{'money':money})
                .then((response) => {
                    this.$parent.code = response.data.message;
                    console.log(this.$parent.code);
                    $('#modalfund').modal('show');
                })
                .catch(function (error) {
                    toastr.error(error.response.data.message);
                });
            }
        }
    },
    mounted() {
        axios.get('/api/getTransaction').then((response)=>{
            this.$parent.Transaction = response.data;
        })
    }
}
</script>