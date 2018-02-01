<template>
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">

            <div class="user-panel">
                <div class="pull-left image">
                    <img :src="this.$parent.info.avatar"
                         class="img-circle" alt="User Image">
                </div>
                <div class="pull-left info">
                    <p id="name">{{this.$parent.info.name}}</p>
                    <a href="#"><i class="fa fa-money"></i> {{this.$parent.info.money}}</a>
                </div>
            </div>
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu tree" data-widget="tree">
                <li class="header">MAIN MENU</li>
                <li>
                    <router-link to="/viplike">
                        <i class="fa fa-hand-o-right"></i> <span>Mua Vip Like</span>
                    </router-link>
                </li>
                <li>
                    <router-link to="/vipcomment">
                        <i class="fa fa-hand-o-right"></i> <span>Mua Vip Comment</span>
                    </router-link>
                </li>
                <li>
                    <router-link to="/history">
                        <i class="fa fa-hand-o-right"></i> <span>History</span>
                    </router-link>
                </li>
                <li>
                    <router-link to="/billing">
                        <i class="fa fa-credit-card-alt"></i> <span>Nạp Tiền</span>
                    </router-link>
                </li>
                <!--
                <li>
                    <router-link to="/vipshare">
                        <i class="fa fa-hand-o-right"></i> <span>Mua Vip Share</span>
                    </router-link>
                </li>
                <li>
                    <router-link to="/review">
                        <i class="fa fa-hand-o-right"></i> <span>Mua Review Fanpage</span>
                    </router-link>
                </li>
                <li>
                    <router-link to="/follow">
                        <i class="fa fa-hand-o-right"></i> <span>Mua Vip Follow</span>
                    </router-link>
                </li>
                <li>
                    <router-link to="/likefanpage">
                        <i class="fa fa-hand-o-right"></i> <span>Mua Like Fanpage</span>
                    </router-link>
                </li>
                <li>
                    <router-link to="/follow">
                        <i class="fa fa-hand-o-right"></i> <span>Billing</span>
                    </router-link>
                </li>
                <li>
                    <router-link to="/vipbuff">
                        <i class="fa fa-hand-o-right"></i> <span>Vip Buff</span>
                    </router-link>
                </li>-->
            </ul>

        </section>
        <!-- /.sidebar -->
        <!-- Modal -->
          <div class="modal fade" id="modalfund" role="dialog">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header" style="text-align: center;">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Nạp Tiền</h4>
                </div>
                <div class="modal-body">
                  <div class="form-group text-center">
                    <div class="input-group">
                      <span class="input-group-btn">
                        <button class="btn btn-secondary" type="button">Đơn Vị(VNĐ)</button>
                      </span>
                      <input type="number" class="form-control" id="money_addfund" placeholder="Số tiền muốn nạp" value="100000">
                      <span class="input-group-btn">
                        <button class="btn btn-secondary" type="button" v-on:click="addfund">Tạo Lệnh Nạp Tiền</button>
                      </span>
                    </div>
                  </div>
                  <div style="font-size: 16px;font-weight: bold; display: none;" id="infoaddfund">
                    Để hoàn thành việc nạp tiền vào hệ thống, bạn cần chuyển tiền đến tài khoản .<br /> 
                    Chủ tài khoản: <span class="text-danger">xxxx</span> <br />
                    Số tài khoản: <span class="text-danger">xxxx</span> <br />
                    Ngân hàng <span class="text-danger">xxxx</span><br />
                    Nội dung: <span class="text-danger">Nap tien viplike_{{this.idtransaction}}</span><br />
                  </div>
                </div>
              </div>
            </div>
          </div>
    </aside>
</template>
<script>
import axios from 'axios'
export default {
    data() {
        return{
            idtransaction : 0
        }
    },
    methods:{
        addfund : function(){
            axios.post('/api/naptien',{
                token: $('meta[name="csrf-token"]').attr('content'),
                money: $('#money_addfund').val()
            }).then((response) => {
                this.idtransaction = response.data.id
            }).catch((error) => {
                
            })
            $('#infoaddfund').show(500);
        }   
    }
    
}

</script>