import { defineStore } from "pinia";

export const useStore = defineStore('auth',{
    state:() => ({
        token: null,
        test:'1234F',
        user: null
    }),
    getters:{
        get_token: (state) => state.token,
        get_data:(state) => state.test,
        get_user:(state) => state.user,
    },
    actions:{
        remove_token(){
            this.token = null
        },
        set_token(token_new){
            this.token = token_new
        },
        remove_user(){
            this.user = null
        },
        set_user(token){
            this.user = token
        },
        set_123(token_new){
            this.test = token_new
        }
    }
})