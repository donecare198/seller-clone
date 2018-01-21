<template>
    <div class="">
        <div class="panel panel-default">
            <div class="panel-heading">
                <b><i class="fa fa-gears"></i> Lịch Sử Hoạt Động</b>
            </div>
            <div class="panel-body">
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tbody>
                        <tr>
                            <th>Pots ID </th>
                            <th>Nội Dung</th>
                        </tr>
                        <tr v-for="list in listVipID">
                            <td>{{list.postid}}</td>
                            <td>{{list.content}}</td>
                        </tr>
                        </tbody>
                    </table>
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
        axios.get('api/history?id='+this.$route.params.id).then((response) => {
            this.listVipID = response.data;
        })
    },
}
</script>