<template>
    <v-app>
        <v-row>
            <v-col>
                <v-btn class="primary text-capitalize" elevation="2" @click="addModal=true">
                    <v-icon>mdi-plus</v-icon>
                    New Party
                </v-btn>
                <!--Display the Parties-->
                <v-simple-table>
                    <template v-slot:default>
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Party name</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(party, i) in parties" :key="i" v-if="parties.length">
                                <td>{{i + 1}}</td>
                                <td>{{party.party_name}}</td>
                                <td>active</td>
                                <td>
                                    <v-btn class="warning text-capitalize" x-small @click="disableShow(party, i)">Disable</v-btn>
                                    <!-- Disable/Enable Modal -->
                                    <Modal v-model="disableModal" width="360">
                                        <p slot="header" style="color:#f60;text-align:center">
                                            <Icon type="ios-information-circle"></Icon>
                                            <span>Confirmation</span>
                                        </p>
                                        <div style="text-align:center">
                                            <p>After this party is disabled will not be available again</p>
                                            <b>Will you disable it?</b>
                                        </div>
                                        <div slot="footer">
                                            <Button type="warning" size="large" long :loading="modal_loading" @click="disableParty">Disable</Button>
                                        </div>
                                    </Modal>
                                    <!-- END Disable/Enable Modal -->
                                </td>
                            </tr>
                        </tbody>
                    </template>
                </v-simple-table>
                <!--END Display the party-->
                <Modal v-model="addModal" title="Add New Party" :closable="false" :mask-closable="false">
                    <Input v-model="data.party_name" placeholder="Enter Party name.." :border="false" />

                    <div slot="footer">
                        <Button type="default" @click="addModal=false">Close</Button>
                        <Button type="primary" @click="addParty">Add Party</Button>
                    </div>
                </Modal>
            </v-col>
        </v-row>
    </v-app>
</template>
<script>
    export default {
        data () {
            return {
                addModal: false,
                disableModal: false,
                data: {
                    party_name: ''
                },
                disableData: {
                    party_name: ''
                },
                index: -1
            }
        },
        methods: {
            async addParty(){
                if (this.data.party_name.trim() == '') return this.e('Party name is required!')
                const res = await this.callApi('post', 'app/create_party', this.data)
                if(res.status == 201){
                    this.parties.unshift(res.data)
                    this.s('Party has been added successfully!')
                    this.addModal = false
                    this.data.party_name = ''
                }
                else{
                    if (res.status==422) {
                        if (res.data.errors.party_name) {
                            this.i(res.data.errors.party_name[0])
                        }
                    }
                    else{
                        this.swr()
                    }
                }
            },
            async disableParty(){
                const res = await this.callApi('post', 'app/disable_party', this.disableData)
                if(res.status == 200){
                    this.parties.splice(this.index, 1)
                    this.s('Party disabled successfully!')
                    this.disableModal = false
                }
                else{
                    this.swr()
                }
            },
            disableShow(party, index){
                let obj = {
                    id : party.id,
                    party_name : party.party_name
                }
                this.disableData = obj
                this.disableModal = true
                this.index = index
            }
        },
    }
</script>
