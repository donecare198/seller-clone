<template>
    <div class="wrapper">
        <Navbar></Navbar>
        <Sidebar></Sidebar>
        <!-- Content Wrapper. Contains page content noidung-->
        <div class="content-wrapper row">
            <div class="" style="float: left;width: 100%;margin-bottom: 35px;">
                <div id="hihi">
                    <router-view>
                    </router-view>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <Footer></Footer>
    </div>
</template>
<script>
import axios from 'axios'
import Navbar from './components/layouts/Navbar.vue'
import Sidebar from './components/layouts/Sidebar.vue'
import Footer from './components/layouts/Footer.vue'
var info = [];

export default {
    components: {
        Navbar,
        Sidebar,
        Footer
    },
    replace: false,
    data() {
        return {
            posts: [],
            errors: [],
            info:{},
            action: '',
        }
    },
    methods:{
        install: function(){
            this.type = [];
            $('input[name="type[]"]:checked').each((i,e)=>{
                this.type.push($(e).val());
            });
            this.package = $('#package').val();
            this.uid = $('#uid').val();
            this.speed = $('#speed').val();
            this.time = $('#time').val();
            this.action = $('#action').val();
            this.comment = $('#comment').val();
            this.rate = $('#rate').val();
            this.token = $('meta[name="csrf-token"]').attr('content');
            this.price = $('#price').val();
            if(this.uid == ''){
                    toastr.error("Vui lòng nhập UID!");
                    return false;
            }
            
            
            if(this.action == 'like'){
                if(this.type == ''){
                    toastr.error("Vui lòng chọn loại cảm xúc!");
                    return false;
                }else if(this.package == ''){
                    toastr.error("Vui lòng chọn gói cảm xúc!");
                    return false;
                }else if(this.speed == ''){
                    toastr.error("Vui lòng chọn thời gian cron!");
                    return false;
                }else if(this.time == ''){
                    toastr.error("Vui lòng chọn gói thời gian!");
                    return false;
                }
            }
            if(this.action == 'comment'){
                if(this.comment == ''){
                    toastr.error("Vui lòng nhập nội dung comment!");
                    return false;
                }
            }
            axios.post('api/install',
                {
                    'uid':this.uid,
                    'type':this.type,
                    'package':this.package,
                    'comment':this.comment,
                    'price':this.price,
                    'time':this.time,
                    'rate':this.rate,
                    'action':this.action,
                    '__token':this.token
                }).then((response) => {
                if(response.data.success == 'true'){
                    toastr.success(response.data.message);
                }else{
                    toastr.error(response.data.message);
                }
            })
        },
        tinhtien: function(){
            this.package = $('#package').val();
            this.price = $('#price').val();
            this.time = $('#time').val();
            $('#thanhtien').val(this.package * this.price * (this.time / 10));
        },
        checkuid: function(){
            this.uid = $('#uid').val();
            axios.get('https://graph.facebook.com/'+this.uid+'?access_token='+this.info.access_token).then((response) => {
                $('#uid').css('border','1px solid #ccc');
                $('#message_uid').html('<span class="success">UID: '+response.data.id+'</span><br /><span class="success">Name: '+response.data.name+'</span>');
            }).catch((error) => {
                $('#message_uid').html('<span class="error">UID bạn nhập không hợp lệ<br />'+error.response.data.error.message+'</span>');
                $('#uid').css('border','1px solid red');
            })
        }
    },
    mounted() {
        axios.get('api/me').then((response) => {
            this.info = response.data;
        })
    },
}
</script>