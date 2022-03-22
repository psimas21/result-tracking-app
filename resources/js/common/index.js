export default{
    data(){
        return{
            roles: [],
            parties: [],
        }
    },
    methods: {
        async callApi(method, url, dataObj){
            try{
                // Send a POST request
                return await axios({
                    method: method,
                    url: url,
                    data: dataObj,
                    completed: false
                });
            }
            catch(e){
                console.log(e)
                return e.response
            }
        },
        statusText(i){
            if (i==1) {
                return "active"
            }
            else{
                return "inactive"
            }
        },

        i (desc, title="hey") {
            this.$Notice.info({
                title: title,
                desc: desc
            });
        },
        s (desc, title="Great!") {
            this.$Notice.success({
                title: title,
                desc: desc
            });
        },
        w (desc, title="oOpss!") {
            this.$Notice.warning({
                title: title,
                desc: desc
            });
        },
        e (desc, title="Oops!") {
            this.$Notice.error({
                title: title,
                desc: desc
            });
        },
        swr (desc="something went wrong! please try again.", title="Oops") {
            this.$Notice.error({
                title: title,
                desc: desc
            });
        }
    },
    async created(){
        // fetchRoles
        const res = await this.callApi('get', 'app/get_roles')
        if (res.status==200) {
            this.roles = res.data
        }
        else{
            this.swr()
        }
        // End fetchRole

        // fetchRoles
        const partyRes = await this.callApi('get', 'app/get_parties')
        if (partyRes.status==200) {
            this.parties = partyRes.data
        }
        else{
            this.swr()
        }
        // End fetchRole
    }
}