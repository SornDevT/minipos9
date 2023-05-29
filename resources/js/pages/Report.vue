<template>
    <div>
        <h1>Report Page</h1>
    </div>
</template>

<script>
import { useStore } from '../store/auth'

export default {
    name: 'Minipos9Report',
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