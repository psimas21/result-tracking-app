export default{
    data(){
        return{

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
}