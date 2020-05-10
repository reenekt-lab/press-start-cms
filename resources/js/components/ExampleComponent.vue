<template>
    <div>
        <div class="card-header">Example Component</div>

        <div class="card-body">
            <p @click="addCount">{{count}}</p>
        </div>
    </div>
</template>

<script>
    export default {
        data:function () {
            return {
                count:0,
            }
        },
        methods:{
            addCount:function ()
            {
                this.count+=2;
            }
        }
    }
</script>
