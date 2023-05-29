<template>
    <div>
        <h1>Store Page</h1>
        <!-- {{ useStore().get_test }} -->
    </div>
</template>

<script>

import { useStore } from '../store/auth'

export default {
    name: 'Minipos9Store',

    setup(){
        const store = useStore()
        return {store}
    },

    data() {
        return {
            
        };
    },

    mounted() {
        
    },

    methods: {
        
    },
    created(){
        console.log(useStore().get_data);
    }
};
</script>

<style lang="scss" scoped>

</style>