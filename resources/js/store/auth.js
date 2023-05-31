import { defineStore } from "pinia";

export const useStore = defineStore('auth',{
    state:() => ({
        token: null,
        test:'1234F'
    }),
    getters:{
        get_token: (state) => state.token,
        get_data:(state) => state.test,
    },
    actions:{
        remove_token(){
            this.token = null
        },
        set_token(token_new){
            this.token = token_new
        },
        set_123(token_new){
            this.test = token_new
        }
    }
})