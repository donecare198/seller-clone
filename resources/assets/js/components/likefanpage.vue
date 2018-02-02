<template>
    <div class="row">
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <b><i class="fa fa-gears"></i> Panel Cài Đặt VIP Like</b>
                </div>
                <div class="panel-body">
                    <form action="" method="POST">
                        <div class="form-group">
                            <label>ID mới cần thêm:</label>
                            <input id="uid" placeholder="100004520190007" type="number" class="form-control" name="id" required="" autofocus="">
                        </div>
                        <div class="form-group">
                            <label>Số Lượng Follow</label>
                            <center>
                                <div class="label label-info" align="center">Follow: <span id="soluong">1000</span></div>
                            </center>
                            <input class="form-control" type="range" name="package" min="1000" max="50000" id="package" value="60" onchange="document.getElementById('soluong').innerHTML=this.value;">
                        </div>
                        Thành Tiền:
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                            <input type="text" disabled="disable" value="15000" class="form-control" id="thanhtien" />
                            <input type="hidden" disabled="disable" value="likefanpage" class="form-control" id="action" />
                            <span class="input-group-addon">VNĐ</span>
                        </div>
                        <br>
                        <button type="button" class="btn btn-danger" v-on:click="this.$parent.install">Cài VIP Like</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <b><i class="fa fa-gears"></i> Danh Sách ID VIP</b>
                </div>
                <div class="panel-body">
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tbody>
                            <tr>
                                <th>UID</th>
                                <th>Gói</th>
                                <th>Hạn Sử Dụng</th>
                                <th>Active</th>
                            </tr>
                            <tr v-for="list in listVipID.data">
                                <td>{{list.uid}}</td>
                                <td>{{list.limit * 10}} Like</td>
                                <td>{{list.time}} Ngày</td>
                                <td><input type="checkbox" :checked="list.active == 1 ? 'checked':''" /> </td>
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
    data() {
        return {
            posts: [],
            errors: [],
            type:[],
            package: '',
            uid: '',
            speed: '',
            time: '',
            listVipID: [],
        }
    },
    mounted() {
        axios.get('api/getViplikeID?action=likefanpage').then((response) => {
            this.listVipID = response.data;
        })
    },
}
</script>