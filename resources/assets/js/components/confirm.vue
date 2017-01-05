<template>
    <button type="button" class="btn btn-default" @click="confirm(id)"><i class="fa fa-trash fa-fw"></i></button>
</template>

<script>
    require('sweetalert');

    export default {
        props: ['id'],
        methods: {
            confirm(id) {
                swal({
                    title: "Anda Yakin Ingin Menghapus?",
                    text: "Anda yakin ingin menghapus data ini?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Ya!",
                    closeOnConfirm: true
                }, function() {
                    $("#form" + id).submit();
                });
            }
        }
    }
</script>
