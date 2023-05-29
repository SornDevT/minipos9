<template>
    <div>
        <h1>Pos Page</h1>
    </div>
</template>

<script>
import { useStore } from '../store/auth'

export default {
    name: 'Minipos9Pos',
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