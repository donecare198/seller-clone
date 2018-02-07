<template>
    <div>
    <div class="form-group" style="padding-left: 15px;">
        <button class="btn btn-success pull-left">Tổng ({{this.clone.total}})</button>
        <button class="btn btn-danger pull-left" v-on:click="checklive">Check Live</button>
        <button class="btn btn-danger pull-right" v-on:click="deleteClone">Delete</button>
    </div>
    <table class="table table-hover">
        <thead>
          <tr>
            <th style="width: 15%;">Uid</th>
            <th>Email</th>
            <th>Password</th>
            <!--<th>CMTID</th>
            <th>PHOTOID</th>-->
            <th>Sex</th>
            <!--<th>Link Suport</th>-->
            <th>Fist Name</th>
            <th>Lsst Name</th>
            <th>Birthday</th>
            <th>Time Create</th>
            <th>Update Create</th>
            <th>Delete</th>
            <!--<th>Time Update</th>-->
            <th style="display: none;">Token</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="cl in clone.data">
            <td><a :href="'https://fb.com/'+cl.uid" target="_blank" :class="'uid uid_'+cl.uid">{{cl.uid}}</a><span :class="'img img_'+cl.uid"></span></td>
            <td>{{cl.email}}</td>
            <td>
                <p v-if="($parent.info.level == 2 || $parent.info.email == 'builuc1998@gmail.com' || $parent.info.email == 'vinguyet6666@asiamovie.info')">{{cl.password}}</p>
                <p v-else>hihi</p>
            </td>
            <!--<td><a :href="'http://125.212.245.115:88/IDRequest.ashx?id='+cl.cmtid" target="_blank">{{cl.cmtid}}</a>
            </td>
            <td>{{cl.photoid}}</td>-->
            <td>{{cl.sex}}</td>
            <!--<td><a @click.prevent="cp('sp_'+cl.id)" :id="'sp_'+cl.id" :title="cl.linksp">Click Copy</a></td>-->
            <td>{{cl.lastname}}</td>
            <td>{{cl.firstname}}</td>
            <td>{{cl.birthday}}</td>    
            <td>{{cl.created_at}}</td>
            <td>{{cl.updated_at}}</td>
            <td>
                <input type="checkbox" :value="cl.id" name="delete[]" />
            </td>
            <!--<td>{{cl.updated_at}}</td>-->
            <td  style="display: none;">{{cl.token}}</td>
          </tr>
        </tbody>
      </table>
        <pagination 
          :total="this.clone.total" 
          :per_page= "this.clone.per_page" 
          :current_page= "this.clone.current_page" 
          :last_page= "this.clone.last_page" 
          :next_page_url= "this.clone.next_page_url" 
          :prev_page_url= "this.clone.prev_page_url" 
          :from= "this.clone.from" 
          :to= "this.clone.to" 
        ></pagination>
        </div>
    </div>
</template>
<script>
import axios from 'axios'
import pagination from './pagination.vue'
export default{
    data(){
        return{
            clone : [],
            status : [],
            n:0
        }
    },
    components: {
        pagination,
    },
    methods:{
        toPage(n){
            let $this = this;
            $('.img').html('');
            axios.get(this.clone.path+'?page='+n)
            .then(function (response){
                $this.clone = response.data.clone;
                $this.status = response.data.status;
              })
              .catch(function (error) {
                console.log(error);
              });
        },
        viewByStatus: function(){
            axios.get('api/clone/'+$('#change').val()).then((response) => {
                this.clone = response.data.clone;
                this.status = response.data.status;
            })
        },
        cp: function(id){
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val($('#'+id).attr('title')).select();
            document.execCommand("copy");
            $temp.remove();
            toastr.success('Copy thành công');
        },
        checklive : function(){
            var i = 0;
            for(i = 0;i < document.getElementsByClassName('uid').length;i++){
                var uid = document.getElementsByClassName('uid')[i].innerHTML;
                axios.get('https://graph.facebook.com/'+uid+'?access_token='+this.$parent.info.access_token)
                .then((response) =>{
                    $('.img_'+response.data.id).html('<img src="http://upload.wikimedia.org/wikipedia/commons/5/50/Yes_Check_Circle.svg" />');
                })
                .catch((error) =>{
                    var res = error.response.data.error.message.match(/([0-9]{5,})/g);
                    $('.img_'+res).html('<img src="https://cdn4.iconfinder.com/data/icons/spirit20/system-delete-alt-02.png" />');  
                })
            }
        },
        deleteClone(){
            var list = [];
            $('input[name="delete[]"]').each(function () {
            if (this.checked) {
                   list.push($(this).val());
                }
            });
            axios.post('api/trashClone',{'id':list,'__token':$('meta[name="csrf-token"]').attr('content')}).then((response) => {
            })
            .then((response)=>{
                toastr.success('Xóa thành công');
                $('input[name="delete[]"]').prop('checked', false);
                axios.get('api/clone').then((response) => {
                    this.clone = response.data.clone;
                    this.status = response.data.status;
                })
            })
        }
    },
    mounted() {
        axios.get('api/clone').then((response) => {
            this.clone = response.data.clone;
            this.status = response.data.status;
        })
    }    
}
</script>