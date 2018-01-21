<template>
    <div class="row">
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <b><i class="fa fa-gears"></i> Panel Cài Đặt VIP Comment</b>
                </div>
                <div class="panel-body">
                    <form action="" method="POST">
                        <div class="form-group">
                            <label>ID mới cần thêm:</label>
                            <input id="uid" v-on:change="this.$parent.checkuid" placeholder="100004520190007" type="number" class="form-control" name="id" required="" autofocus="">
                            <label id="message_uid"></label>
                        </div><!--
                        <div class="form-group">
                            <label>Số Status/1 Ngày:</label>
                            <select name="limitpost" id="limitpost" class="form-control">
                                <option value="12">12 Post/Day</option>
                            </select>
                        </div>-->
                        <div class="form-group">
                            <label>Nội Dung</label>
                            <textarea id="comment" placeholder="Nhiều nội dung cách nhau bằng dấu gạch thẳng '|' Nội dung 1 | Nội dung 2 | Nội dung 3" class="form-control" rows="6" style="max-width: 100%"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Số Lượng Comment:</label>
                            <input type="hidden" id="price" value="500" />
                            <select name="package"  v-on:change="this.$parent.tinhtien" id="package" class="form-control">
                                <option value="50">50 Comment</option>
                                <option value="100">100 Comment</option>
                                <option value="150">150 Comment</option>
                            </select>
                        </div>
                        <!--<div class="form-group">
                            <label>Tốc Độ Like/5 Phút:</label>
                            <select name="speed" id="speed" class="form-control">
                                <option value="30">30 Comment</option>
                                <option value="40">40 Comment</option>
                                <option value="50">50 Comment</option>
                                <option value="100">100 Comment</option>
                            </select>
                        </div>-->
                        <div class="form-group">
                            <label>Thời Hạn:</label>
                            <select  v-on:change="this.$parent.tinhtien" name="time" id="time" class="form-control">
                                <!--<option value="free">Free Test 1 Day</option>-->
                                <option value="10">10 Ngày</option>
                                <option value="20">20 Ngày</option>
                                <option value="30">30 Ngày</option>
                            </select>
                        </div>
                        Thành Tiền:
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                            <input type="text" disabled="disable" value="25000" class="form-control" id="thanhtien" />
                            <input type="hidden" id="action" value="comment" />
                            <span class="input-group-addon">VNĐ</span>
                        </div>
                        <br>
                        <button type="button" v-on:click="this.$parent.install" class="btn btn-danger">Cài VIP Comment</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <b><i class="fa fa-gears"></i> Danh Sách ID VIP Comment</b>
                </div>
                <div class="panel-body">
                    <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-hover">
                                    <tbody>
                                    <tr style="width: 100%;">
                                        <th style="width: 50%;">UID</th>
                                        <th style="width: 25%;">Gói</th>
                                        <th style="width: 25%;">Hạn Sử Dụng</th>
                                    </tr>
                                    <tr v-for="list in listVipID.data">
                                        <td>{{list.uid}}</td>
                                        <td>{{list.limit}} Cmt</td>
                                        <td>{{list.time}} Ngày</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
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
        axios.get('api/getViplikeID?action=comment').then((response) => {
            this.listVipID = response.data;
        })
    },
}
</script>