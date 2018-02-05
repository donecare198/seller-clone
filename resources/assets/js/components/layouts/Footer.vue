<template>
    <div>
        <footer class="main-footer">
            <div class="pull-right hidden-xs">
                Powered By <a :href="this.$parent.config[3].link" target="_blank">{{this.$parent.config[3].value}} </a><b>Version</b> v1.0
            </div>
            <strong>Copyright &copy; 2017 <a href="/">{{this.$parent.config[2].value}}</a>.</strong> All rights reserved.
        </footer>
        <div class="control-sidebar-bg"></div>
        <a id="back-to-top" href="#" class="btn btn-primary btn-lg back-to-top" role="button" data-toggle="tooltip"
           data-placement="left"><span class="glyphicon glyphicon-chevron-up"></span></a>
    </div>
</template>