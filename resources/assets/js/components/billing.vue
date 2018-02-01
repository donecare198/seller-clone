<template>
    <div>
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
                    <input type="number" v-on:keyup="max_billing" class="form-control" id="money_billing" value="50000" />
                    <span class="text-danger" id="message_money">50.000 VNĐ</span>
                </div>
                <div class="form-group text-right">
                    <button class="btn btn-danger" id="btnnaptien">Tiếp Theo</button>
                </div>
              </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
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
        }
    }
}
</script>